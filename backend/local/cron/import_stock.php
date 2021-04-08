<?php
require_once '../../vendor/autoload.php';
require '../helper/logger.php';
use \GuzzleHttp\Client;

$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);

define('URL', 'https://marketplace.book-online.ru/bookstore/stocks');
define('AUTH', '7e47a6fdfa664dbc876fa0310f962e5a');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule('catalog');
@set_time_limit(0);
@ignore_user_abort(true);

CAgent::CheckAgents();
define("BX_CRONTAB_SUPPORT", true);
define("BX_CRONTAB", true);
CEvent::CheckEvents();
logger("Начали обновление цен");
$resProducts =  \Bitrix\Iblock\ElementTable::getList([
    "select" => [
        "CODE",
        "ACTIVE",
        'ID',
        "PRICE" => "PRICE_LIST.PRICE",
        "QUANTITY" => "PRODUCT.QUANTITY",
        "AVAILABLE" => "PRODUCT.AVAILABLE",
        "IBLOCK_ID"
    ],
    'runtime' => [
        'PRICE_LIST' => [
            'data_type' => \Bitrix\Catalog\PriceTable::class,
            'reference' => [
                '=this.ID' => 'ref.PRODUCT_ID',
            ],
            'join_type' => 'left'
        ],
        'PRODUCT' => [
            'data_type' => \Bitrix\Catalog\ProductTable::class,
            'reference' => [
                '=this.ID' => 'ref.ID',
            ],
            'join_type' => 'left'
        ]
    ],
    'filter' => [
        ">=IBLOCK_ID" => 4
    ],
])->fetchAll();

$offers = array_combine(
    array_map(function($item) { return ($item["CODE"]); }, $resProducts),
    array_map(function($item) { return ((object)[
        'idtow' => $item['CODE'],
        'available' => $item['AVAILABLE'] === 'Y' ? 1 : 0,
        'price' => $item['PRICE'],
        'stock' => $item['QUANTITY']
    ]); }, $resProducts)
);

for( $i = 0; $i <= count($offers)/100; $i++ ){
    $body['idtows'] = array_slice(array_keys($offers), $i*100, 100);

    try {
        $client = new Client();
        $response = $client->post(URL, [
            'headers' => [
                'Authorization' => AUTH,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => json_encode($body)
        ]);

        $result = $response->getBody()->getContents();

    } catch (Exception $error) {
        logger($error->getMessage(), 'error');
        continue;
    }
    $stocks = json_decode($result)->stocks;

    foreach($stocks as $stock){
        if($stock <> $offers[$stock->idtow]) {

            $key = array_search($stock->idtow, array_column($resProducts, 'CODE'));
            $elementID = $resProducts[$key]['ID'];

            if($stock->price <> $offers[$stock->idtow]->price){
                $priceFields = Array(
                    "PRODUCT_ID" => $elementID,
                    "PRICE" => $stock->price
                );

                $result = \Bitrix\Catalog\Model\Price::update($elementID, $priceFields);
            }
            if($stock->available <> $offers[$stock->idtow]->available){
               \Bitrix\Catalog\Model\Product::update($elementID, ['AVAILABLE' => $stock->available ? "Y" : "N" ]);
            }

            if($stock->stock <> $offers[$stock->idtow]->stock){
                $productResult = \Bitrix\Catalog\Model\Product::update($elementID, ['QUANTITY' => $stock->stock]);
            }
        }
    }
}
logger("Закончили обновление цен");
require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/tools/backup.php");
CMain::FinalActions();
?>

<?php
require_once '../../vendor/autoload.php';
use \JsonMachine\JsonMachine;
use \GuzzleHttp\Client;
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

function logger($message, $file='debug') {
    if(!is_dir ($_SERVER["DOCUMENT_ROOT"]."/local/log")){
        mkdir($_SERVER["DOCUMENT_ROOT"]."/local/log");
    }

    $date = date('d.m.Y h:i:s');
    $log ="\n|  Date:  ".$date."  |   ".$message;
    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/log/$file.log", $log . PHP_EOL, FILE_APPEND);
}

$blockSection = [
    1 => 'books',
    9 => 'books',
    12 => 'no_books',
    13 => 'no_books',
    17 => 'no_books',
    18 => 'no_books',
    19 => 'foods'
];

$blockProperty = [
    'ISBN', 'AUTHOR', 'PUBLISHER', 'PUB_YEAR', 'AGE', 'PAGES', 'COVER', 'COUNTRY',
    'MANUFACTURER', 'SERIES', 'IMPORTER', 'MATERIAL', 'PACKING', 'WEIGHT',
    'KIND', 'LEAF', 'FORM', 'STANDART', 'NET_KG', 'GROSS_KG', 'PACK_TYPE', 'COLLECTION', 'BREND', 'ORIGIN', 'CONSISTS'
];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);

define('URL', 'https://marketplace.book-online.ru/bookstore/stocks');
define('AUTH', '7e47a6fdfa664dbc876fa0310f962e5a');

$time_start_script = microtime(true);
logger("Начали загрузку товаров");
$importFile = $DOCUMENT_ROOT.'/local/json/data.json';

if(!file_exists($importFile)){
    die("Файла на выгрузку товаров не существует, file = $importFile");
}

$sections = JsonMachine::fromFile($importFile, '/product_types');
$offers = JsonMachine::fromFile($importFile, '/offers');

foreach ($offers as $offer) {
    $data[] = $offer['idtow'];
}

$offerCount = count($data);

$stores = [];
/* для определения цены и количество товаров, требуется запрос отправить https://marketplace.book-online.ru/bookstore/stocks
 * запросе надо передать массив из айди товаров, максимльное количество элементов в массиве 100
 * поэтому сначала узнаем сколько элементов в файле, и разбиваем на нужное количество запросов
*/
for( $i = 0; $i <= $offerCount/100; $i++ ){
    $body['idtows'] = array_slice($data, $i*100, 100);
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
        //die("Произошла ошибка запроса на сервер https://marketplace.book-online.ru/bookstore/stocks");
    }
    $stocks = json_decode($result)->stocks;
    foreach($stocks as $stock){
        $stores[$stock->idtow] = $stock;
    }
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);

CAgent::CheckAgents();
define("BX_CRONTAB_SUPPORT", true);
define("BX_CRONTAB", true);
CEvent::CheckEvents();

CModule::IncludeModule("iblock");
CModule::IncludeModule('catalog');
$time_start_section = microtime(true);
foreach ($sections as $index => $section) {
    $blockId = CIBlock::GetList(
        [],
        [
            'TYPE' => 'catalog',
            'CODE' => $blockSection[$index],

        ], true
    )->GetNext()['ID'];

    $sectionId = CIBlockSection::GetList([], [
        "IBLOCK_ID" => $blockId,
        'EXTERNAL_ID' => $index
    ])->GetNext()['ID'];

    $bs = new CIBlockSection;

    $sectionFields = [
        "ACTIVE" => 'Y',
        "IBLOCK_ID" => $blockId,
        "NAME" => $section,
        "DESCRIPTION" => $section,
        "EXTERNAL_ID" => $index
    ];
    if($sectionId > 0) {
        $sectionResult = $bs->Update($sectionId, $sectionFields);
        logger("Обновили раздел id = $sectionId");
    } else {
        $sectionId = $bs->Add($sectionFields);
        logger("добавили раздел id = $sectionId");
        $sectionResult = ($sectionId > 0);
    }

    if(!$sectionResult)
        echo $sectionId->LAST_ERROR;
}

$time_end_section = microtime(true);
$time_section = $time_end_section - $time_start_section;
logger("Время потраченное на загрузку разделов $time_section секунд");

$time_start_element = microtime(true);
foreach ($offers as $currentItem ) {
    $store = $stores[$currentItem['idtow']];

    if(!$store)
        continue;

    //проверим есть ли такой подраздел
    $section = CIBlockSection::GetList([], [
        "IBLOCK_CODE" => $blockSection[$currentItem['type_id']],
        'EXTERNAL_ID' => $currentItem['type_id']
    ])->GetNext();

    $sectionId = $section['ID'];
    $blockId =  $section['IBLOCK_ID'];

    $bs = new CIBlockSection;
    $sectionFields = [
        "ACTIVE" => 'Y',
        "IBLOCK_ID" => $blockId,
        "NAME" =>  $currentItem['features']['section'],
        'IBLOCK_SECTION_ID' => $sectionId,
        "DESCRIPTION" => $currentItem['features']['section'],
    ];

    //проверяем есть ли у товара подраздел
    $subSectionId = false;
    if($currentItem['features']['section']){
        $subSectionId = CIBlockSection::GetList([], [
            "IBLOCK_ID" => $blockId,
            'IBLOCK_SECTION_ID' => $sectionId,
            'NAME' => $currentItem['features']['section']
        ])->GetNext()['ID'];

        if($subSectionId > 0) {
            $subSectionResult = $bs->Update($subSectionId, $sectionFields);
            logger("Обновили подраздел id = $subSectionId");
        } else {
            $subSectionId = $bs->Add($sectionFields);
            logger("Добавили подраздел id = $subSectionId");
            $subSectionResult = ($subSectionId > 0);
        }
    }

    //загружаем товары по разделам
    $idtow = $currentItem['idtow'];
    $propertyValues = [];
    $propertyValues["EAN"] = $currentItem['ean'];
    foreach ($currentItem['features'] as $propertyKey => $property) {
        if (in_array(mb_strtoupper($propertyKey), $blockProperty)) {
            $propertyValues[mb_strtoupper($propertyKey)] = $property;
        }
    }
    if($currentItem['features']['dimensions']){
        list($width, $length, $height) = explode('x', $currentItem['features']['dimensions']);

        $propertyValues["WIDTH"] = $width;
        $propertyValues["LENGTH"] = $length;
        $propertyValues["HEIGHT"] = $height;
    }
    $el = new CIBlockElement;

    //проверим существование элемента
    $element = CIBlockElement::GetList([], [
        "IBLOCK_ID" => $blockId,
        'CODE' => $idtow
    ]);

    if($resElement = $element->Fetch()) {
        $elementId = $resElement['ID'];
        $resultElement = $el->Update($elementId, [
            "ACTIVE" => $store->available ? "Y" : "N",
            "NAME" => $currentItem['name'],
            "DETAIL_TEXT" => $currentItem['descr'],
            'CODE' => $idtow,
            "PROPERTY_VALUES" => $propertyValues
        ]);
        logger("Обновили товар id = $elementId, idtow = $idtow", 'element');
    } else {
        $detailPicture = CFile::MakeFileArray("http://torg.book-online.ru/marketplace/goods/$idtow.jpg");
        if($currentItem['pics']) {
            foreach ($currentItem['pics'] as $picture){
                $propertyValues['PHOTO'][] = CFile::MakeFileArray("http://images.book-online.ru/$idtow/$picture");
            }
        }
        $elementFields = array(
            "ACTIVE" => $store->available ? "Y" : "N",
            "IBLOCK_ID" => $blockId,
            "IBLOCK_SECTION_ID" => $subSectionId ? $subSectionId : false,
            "NAME" => $currentItem['name'],
            "DETAIL_TEXT" => $currentItem['descr'],
            "PREVIEW_PICTURE" => $detailPicture['size'] ? $detailPicture : false,
            "DETAIL_PICTURE" => $detailPicture['size'] ? $detailPicture : false,
            "PROPERTY_VALUES" => $propertyValues,
            'CODE' => $idtow,
        );
        $elementId = $el->Add($elementFields, false, false, true);

        if($elementId > 0){
            logger("Добавили товар id = $elementId, idtow = $idtow ", 'element');
            /* Делаем добавленный товар простым, иначе не сможем прописать цены */
            \Bitrix\Catalog\Model\Product::Add([
                "ID" => $elementId,
                "VAT_ID" => 1,
                "VAT_INCLUDED" => "Y",
                "TYPE " => \Bitrix\Catalog\ProductTable::TYPE_PRODUCT //Тип товара
            ]);
        } else {
            logger("Ошибка добавления товара idtow = $idtow  $el->LAST_ERROR", 'error');
            continue;
        }
    }

    //Добавляем или обновляем цену товара
    $priceFields = Array(
        "PRODUCT_ID" => $elementId,
        "CATALOG_GROUP_ID" => 1,
        "PRICE" => $store->price,
        "CURRENCY" => "RUB"
    );

    //Смотрим установлена ли цена для данного товара
    $dbPrice = \Bitrix\Catalog\Model\Price::getList([
        "filter" => array(
            "PRODUCT_ID" => $elementId,
            "CATALOG_GROUP_ID" => 1
        )
    ]);

    if ($arPrice = $dbPrice->fetch()) {
        //Если цена установлена, то обновляем
        $result = \Bitrix\Catalog\Model\Price::update($arPrice["ID"], $priceFields);

        if ($result->isSuccess()){
            logger("Обновили цену у товара у элемента каталога " . $elementId . " Цена " . $store->price, 'element');
        } else {
            logger("Ошибка обновления цены у товара у элемента каталога " . $elementId  . " Ошибка " . $result->getErrorMessages(), 'error');
        }
    }else{
        //Если цены нет, то добавляем
        $result = \Bitrix\Catalog\Model\Price::add($priceFields);

        if ($result->isSuccess()){
            logger("Добавили цену у товара у элемента каталога " . $elementId . " Цена " . $store->price, 'element');
        } else {
            logger("Ошибка добавления цены у товара у элемента каталога " . $elementId . " Ошибка " . $result->getErrorMessages(), 'error');
        }
    }

    //Смотрим установленo количество товаров
    $products = \Bitrix\Catalog\ProductTable::getList([
        'filter' => [ 'ID' => $elementId ]
    ]);

    //Прописываем товару количество
    $productFields = [
        'ID' => $elementId,
        'QUANTITY_TRACE' => \Bitrix\Catalog\ProductTable::STATUS_DEFAULT,
        'CAN_BUY_ZERO' => \Bitrix\Catalog\ProductTable::STATUS_DEFAULT,
        'CATALOG_GROUP_ID' => 1,
        'QUANTITY' => $store->stock
    ];

    if($res = $products->fetch()){
        $productResult = \Bitrix\Catalog\Model\Product::update($res['ID'], ['QUANTITY' => $store->stock]);
        if ($productResult->isSuccess()){
            logger("Обновили количество  товаров у элемента каталога " . $elementId . " Количество " . $store->stock, 'element');
        } else {
            logger("Ошибка обновления количество у товара у элемента каталога " . $elementId  . " Ошибка " . $result->getErrorMessages(), 'error');
        }

    } else {
        //если нет количества то добавим
        $productResult = \Bitrix\Catalog\Model\Product::add($productFields);
        if ($productResult->isSuccess()){
            logger("Добавили количество  товаров у элемента каталога " . $elementId . " Количество " . $store->stock, 'element');
        } else {
            logger("Ошибка добавления количество у товара у элемента каталога " . $elementId  . " Ошибка " . $result->getErrorMessages(), 'error');
        }
    }
}

$time_end_element = microtime(true);
$time_element = $time_end_element - $time_start_element;
logger("Затраченное время на загрузку товаров $time_element секунд" );

$time_end_script =  microtime(true);;
$time = $time_end_script - $time_start_script;

logger("Завершили загрузку товаров ....\nЗатраченное время $time секунд" );
require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/tools/backup.php");
unlink($importFile);

CMain::FinalActions();
?>

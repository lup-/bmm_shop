<?php
require_once '../../vendor/autoload.php';
require '../helper/logger.php';

use \JsonMachine\JsonMachine;

$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);

CAgent::CheckAgents();
define("BX_CRONTAB_SUPPORT", true);
define("BX_CRONTAB", true);
CEvent::CheckEvents();

CModule::IncludeModule("iblock");
CModule::IncludeModule('catalog');

$infoBlocks = [
    [
        'fields' => [
            'code' => 'books',
        ],
        'properties' => [
            [
                'name' => 'ЖАНР',
                'code' => 'CATEGORY',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Серия',
                'code' => 'SERIES',
                'type' => 'S',
                'multitype' => 'N'
            ]
        ]
    ],
    [
        'fields' => [
            'code' => 'non-books',
        ],
        'properties' => [
            [
                'name' => 'Категория',
                'code' => 'CATEGORY',
                'type' => 'S',
                'multitype' => 'N'
            ]
        ]
    ],
    [
        'fields' => [
            'code' => 'foods',
        ],
        'properties' => [
            [
                'name' => 'Категория',
                'code' => 'CATEGORY',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Серия',
                'code' => 'SERIES',
                'type' => 'S',
                'multitype' => 'N'
            ]
        ]
    ],
];

foreach ($infoBlocks as $infoBlock) {
    $infoBlockFields = $infoBlock['fields'];
    $infoBlocksProperties = $infoBlock['properties'];
    $blockId = CIBlock::GetList(
        array(),
        array(
            'TYPE' => 'catalog',
            'CODE' => $infoBlockFields['code'],

        ), true
    )->GetNext()['ID'];

    //добавляем свойства к блоку
    foreach ($infoBlocksProperties as $index => $property) {
        $propertyBlock = new CIBlockProperty;

        $propertyBlock->Add([
            "NAME" => $property['name'],
            "ACTIVE" => "Y",
            "SORT" => 100,
            "CODE" =>  $property['code'],
            "PROPERTY_TYPE" =>  $property['type'],
            "IBLOCK_ID" => $blockId,
            "MULTIPLE" =>  $property['multitype'],
        ]);
    }
}

$importFile = $DOCUMENT_ROOT.'/local/json/data.json';

if(!file_exists($importFile)){
    die("Файла на выгрузку товаров не существует, file = $importFile");
}
logger("Начали загрузку товаров");

$offers = JsonMachine::fromFile($importFile, '/offers');

foreach ($offers as $currentItem) {
    $idtow = $currentItem['idtow'];
    $features = $currentItem['features'];
    $weight = $currentItem['weight'];
    $propertyValues = [];
    foreach ($features as $propertyKey => $property) {
        if($propertyKey == 'topic'){
            $propertyValues['CATEGORY'] = $property;
        }
        if($propertyKey == 'series'){
            $propertyValues['SERIES'] = $property;
        }
    }
    $element = CIBlockElement::GetList([], [
        'CODE' => $idtow
    ]);
    $el = new CIBlockElement;
    if($resElement = $element->Fetch()) {
        $elementId = $resElement['ID'];
        $resultElement = $el->Update($elementId, [
            "PROPERTY_VALUES" => $propertyValues,
        ]);
        $productResult = \Bitrix\Catalog\Model\Product::Update($elementId,[
            "WEIGHT" => $weight,
        ]);
        logger("Обновили товар id = $elementId, idtow = $idtow", 'property');
    }
}

require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/tools/backup.php");
unlink($importFile);

CMain::FinalActions();
?>

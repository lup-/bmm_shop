<?php
require_once '../../vendor/autoload.php';
require '../helper/logger.php';

use \JsonMachine\JsonMachine;
use \GuzzleHttp\Client;
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

$blockSection = [
    1 => 'books',
    9 => 'books',
    12 => 'non-books',
    13 => 'non-books',
    17 => 'non-books',
    18 => 'non-books',
    19 => 'foods'
];

$blockProperty = [
    'ISBN', 'AUTHOR', 'PUBLISHER', 'PUB_YEAR', 'AGE', 'PAGES', 'COVER', 'COUNTRY', 'ILLUSTRATORS',
    'MANUFACTURER', 'SERIES', 'IMPORTER', 'MATERIAL', 'PACKING', 'WEIGHT', 'DIMENSIONS',
    'KIND', 'LEAF', 'FORM', 'STANDART', 'NET_KG', 'GROSS_KG', 'PACK_TYPE', 'COLLECTION', 'BREND', 'ORIGIN', 'CONSISTS'
];


$elementProperty = [
    'books' => ['ISBN', 'AUTHOR', 'PUBLISHER', 'PUB_YEAR', 'PAGES', 'COVER', 'COUNTRY'],
    'non-books' => ['MANUFACTURER', 'SERIES', 'IMPORTER', 'MATERIAL', 'PACKING', 'COUNTRY'],
    'foods' => ['KIND', 'LEAF', 'FORM', 'STANDART', 'NET_KG', 'GROSS_KG', 'PACK_TYPE', 'COLLECTION', 'BREND', 'ORIGIN', 'CONSISTS', 'MANUFACTURER'],
];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);

define('URL', 'https://marketplace.book-online.ru/bookstore/stocks');
define('AUTH', '7e47a6fdfa664dbc876fa0310f962e5a');

$importFile = $DOCUMENT_ROOT.'/local/json/data.json';

if(!file_exists($importFile)){
    die("Файла на выгрузку товаров не существует, file = $importFile");
}

$time_start_script = microtime(true);
logger("Начали загрузку товаров");

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
        continue;
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

function getSection($blockId, $sectionId, $sectionName, $subSectionId = 0) {
    $bs = new CIBlockSection;

    $arFilter = [
        "IBLOCK_ID" => $blockId,
        'SECTION_ID' => $sectionId,
        "NAME" => $sectionName
    ];

    $topicId = false;

    $rsSections = CIBlockSection::GetList([], $arFilter, false, [ "ID", "EXTERNAL_ID"]);

    while($arSection = $rsSections->GetNext())
    {
        $topicId = $arSection['ID'];
        $externalId = $arSection['EXTERNAL_ID'];

        if($topicId && $subSectionId > 0 && !$externalId){
            $bs->Update($topicId, ["EXTERNAL_ID" => $subSectionId]);
        }
    }

    if(!$topicId) {
        $topicId = $bs->Add([
            "ACTIVE" => 'Y',
            "IBLOCK_ID" => $blockId,
            "NAME" =>  $sectionName,
            'IBLOCK_SECTION_ID' => $sectionId,
            "DESCRIPTION" => $sectionName,
            "EXTERNAL_ID" => $sectionId > 0 ? $sectionId : ''
        ]);
    }
    return $topicId;
}

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
        "CODE" => "$blockSection[$index]_$index",
        "NAME" => $section,
        "DESCRIPTION" => $section,
        "EXTERNAL_ID" => $index
    ];
    if(!$sectionId) {
        $sectionId = $bs->Add($sectionFields);
        logger("добавили раздел id = $sectionId");
        $sectionResult = ($sectionId > 0);

        if(!$sectionResult)
            logger("Ошибка при добавлении раздела $sectionId->LAST_ERROR");
    }
}

$time_end_section = microtime(true);
$time_section = $time_end_section - $time_start_section;
logger("Время потраченное на загрузку разделов $time_section секунд");

$time_start_element = microtime(true);
foreach ($offers as $currentItem ) {

    $idtow = $currentItem['idtow'];
    $store = $stores[$idtow];

    if(!$store)
        continue;

    $typeId = $currentItem['type_id'];
    $section = CIBlockSection::GetList([], [
        "CODE" => "$blockSection[$typeId]_$typeId",
        'EXTERNAL_ID' => $currentItem['type_id']
    ])->GetNext();

    $sectionId = $section['ID'];
    $blockId =  $section['IBLOCK_ID'];
    $blockCode = $section['IBLOCK_CODE'];

    /*соберем все свойства товара*/
    $propertyValues = [];
    $propertyValues["EAN"] = $currentItem['ean'];
    $features = $currentItem['features'];
    $dimensions = $currentItem['dimensions'];

    foreach ($features as $propertyKey => $property) {
        if (in_array(mb_strtoupper($propertyKey), $blockProperty)) {
            $propertyValues[mb_strtoupper($propertyKey)] = $property;
        }

        if($propertyKey == 'topic'){
            $propertyValues['TOPIC'] = $property;
        }
    }

    if($dimensions) {
        list($width, $length, $height) = explode('x', $dimensions);
        $propertyValues["DIMENSIONS"] = $dimensions;
        $propertyValues["WIDTH"] = $width;
        $propertyValues["LENGTH"] = $length;
        $propertyValues["HEIGHT"] = $height;
    }

    if($currentItem['age']) {
        $propertyValues["AGE"] = $currentItem['age'];
    }

    if($currentItem['weight']) {
        $propertyValues["WEIGHT"] = $currentItem['weight'];
    }

    /* 1 - добавим подраздел, топик и подтопик если такие имеется */
    $subSectionId = false;
    if($currentItem['features']['section']){
        $subSectionId = getSection($blockId, $sectionId, $currentItem['features']['section']);
    }

    /* добавим топик если таковой имеется */
    if($currentItem['features']['topic']) {
        $subSectionId = getSection($blockId, $subSectionId, $currentItem['features']['topic'], $currentItem['features']['topic_id']);
    }

    /* добавим подтопик если имеется*/
    if($currentItem['features']['subtopic']) {
        $subSectionId = getSection($blockId, $subSectionId, $currentItem['features']['subtopic'], $currentItem['features']['subtopic_id']);
    }

    /* Проверим есть ли такой товар в системе, если нет добавим */
    $element = CIBlockElement::GetList([], [
        "IBLOCK_ID" => $blockId,
        'CODE' => $idtow
    ]);

    $el = new CIBlockElement;

    if($resElement = $element->Fetch()) {

        $elementId = $resElement['ID'];
        $elementHash = $resElement['TMP_ID'];
        logger("Товар уже существует  id = $elementId, idtow = $idtow", 'goods');

    } else {
        /* 2 добавляем новый товар с картинками */
        $detailPicture = CFile::MakeFileArray("http://torg.book-online.ru/marketplace/goods/$idtow.jpg");
        if($currentItem['pics']) {
            foreach ($currentItem['pics'] as $picture){
                $propertyValues['PHOTO'][] = CFile::MakeFileArray("http://images.book-online.ru/$idtow/$picture");
            }
        }

        $elementId = $el->Add([
            "ACTIVE" => $store->available ? "Y" : "N",
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $blockId,
            "IBLOCK_SECTION_ID" => $subSectionId ? $subSectionId : $sectionId,
            "NAME" => $currentItem['name'],
            "DETAIL_TEXT" => $currentItem['descr'],
            "PREVIEW_PICTURE" => $detailPicture['size'] ? $detailPicture : false,
            "DETAIL_PICTURE" => $detailPicture['size'] ? $detailPicture : false,
            "PROPERTY_VALUES" => $propertyValues,
            'CODE' => $idtow,
        ],
            false,
            false,
            true);

        /* 3 - Добавлем к товару количество */
        if($elementId > 0){
            /* Делаем добавленный товар простым, иначе не сможем прописать цены */
            $productResult = \Bitrix\Catalog\Model\Product::Add([
                "ID" => $elementId,
                "AVAILABLE" => $store->available ? "Y" : "N",
                "VAT_ID" => 1,
                "VAT_INCLUDED" => "Y",
                "TYPE " => \Bitrix\Catalog\ProductTable::TYPE_PRODUCT,  //Тип товара
                'QUANTITY_TRACE' => \Bitrix\Catalog\ProductTable::STATUS_DEFAULT,
                'CAN_BUY_ZERO' => \Bitrix\Catalog\ProductTable::STATUS_DEFAULT,
                'CATALOG_GROUP_ID' => 1,
                'QUANTITY' => $store->stock,
                "WEIGHT" => $currentItem['weight'],
            ]);
            logger("Добавили товар " . $elementId . " Количество " . $store->stock, 'element');

        } else {
            logger("Ошибка добавления товара idtow = $idtow  $el->LAST_ERROR", 'error');
            continue;
        }

        /* 4 - Добавляем цену товара */
        $result = \Bitrix\Catalog\Model\Price::add([
            "PRODUCT_ID" => $elementId,
            "CATALOG_GROUP_ID" => 1,
            "PRICE" => $store->price,
            "CURRENCY" => "RUB"
        ]);

        if ($result->isSuccess()){
            logger("Добавили цену у товара у элемента каталога " . $elementId . " Цена " . $store->price, 'element');
        } else {
            logger("Ошибка добавления цены у товара у элемента каталога " . $elementId . " Ошибка " . $result->getErrorMessages(), 'error');
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

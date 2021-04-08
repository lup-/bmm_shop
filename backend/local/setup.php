<?php

$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);

$infoBlocks = [
    [
        'fields' => [
            'code' => 'books',
            'name' => 'Книги'
        ],
        'properties' => [
            [
                'name' => 'ean',
                'code' => 'EAN',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'isbn',
                'code' => 'ISBN',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Автор',
                'code' => 'AUTHOR',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Издатель',
                'code' => 'PUBLISHER',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Год издания',
                'code' => 'PUB_YEAR',
                'type' => 'N',
                'multitype' => 'N'
            ],
            [
                'name' => 'Возрастное ограничение',
                'code' => 'AGE',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Страницы',
                'code' => 'PAGES',
                'type' => 'N',
                'multitype' => 'N'
            ],
            [
                'name' => 'Обложка',
                'code' => 'COVER',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Страна',
                'code' => 'COUNTRY',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Картинки',
                'code' => 'PHOTO',
                'type' => 'F',
                'multitype' => 'Y'
            ],
        ]
    ],
    [
        'fields' => [
            'code' => 'non-books',
            'name' => 'НЕ Книги'
        ],
        'properties' => [
            [
                'name' => 'ean',
                'code' => 'EAN',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Изготовитель',
                'code' => 'MANUFACTURER',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Серия',
                'code' => 'SERIES',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Импортер',
                'code' => 'IMPORTER',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Страна',
                'code' => 'COUNTRY',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Материал',
                'code' => 'MATERIAL',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Упаковка',
                'code' => 'PACKING',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Возрастное ограничение',
                'code' => 'AGE',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Размер',
                'code' => 'DIMENSIONS',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Вес',
                'code' => 'WEIGHT',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Ширина',
                'code' => 'WIDTH',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Длина',
                'code' => 'LENGTH',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Высота',
                'code' => 'HEIGHT',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Картинки',
                'code' => 'PHOTO',
                'type' => 'F',
                'multitype' => 'Y'
            ],
        ]
    ],
    [
        'fields' => [
            'code' => 'foods',
            'name' => 'Питание'
        ],
        'properties' => [
            [
                'name' => 'ean',
                'code' => 'EAN',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Сорт',
                'code' => 'KIND',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Листья',
                'code' => 'LEAF',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Форма',
                'code' => 'FORM',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Стандарт',
                'code' => 'STANDART',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Нетто',
                'code' => 'NET_KG',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Брутто',
                'code' => 'GROSS_KG',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Упаковка',
                'code' => 'PACK_TYPE',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Коллекция',
                'code' => 'COLLECTION',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Бренд',
                'code' => 'BREND',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Изготовитель',
                'code' => 'MANUFACTURER',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Страна',
                'code' => 'COUNTRY',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Оригинал',
                'code' => 'ORIGIN',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Содержание',
                'code' => 'CONSISTS',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Размер',
                'code' => 'DIMENSIONS',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Ширина',
                'code' => 'WIDTH',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Длина',
                'code' => 'LENGTH',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Высота',
                'code' => 'HEIGHT',
                'type' => 'S',
                'multitype' => 'N'
            ],
            [
                'name' => 'Картинки',
                'code' => 'PHOTO',
                'type' => 'F',
                'multitype' => 'Y'
            ],
        ]
    ]
];

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
@set_time_limit(0);
@ignore_user_abort(true);

CModule::IncludeModule("iblock");
CModule::IncludeModule('catalog');

CAgent::CheckAgents();
define("BX_CRONTAB_SUPPORT", true);
define("BX_CRONTAB", true);
CEvent::CheckEvents();

foreach ($infoBlocks as $infoBlock) {
    $infoBlockFields = $infoBlock['fields'];
    $infoBlocksProperties = $infoBlock['properties'];

    $blockId = CIBlock::GetList(
        array(),
        array(
            'TYPE' => 'catalog',
            'NAME' => $infoBlockFields['name'],

        ), true
    )->GetNext()['ID'];

    $infoBlockCode = $infoBlockFields['code'];
    if(!$blockId){
        $newInfoBlock = new CIBlock;
        $newInfoBlockId = $newInfoBlock->Add([
            'IBLOCK_TYPE_ID' => 'catalog',
            'LID' => 's1',
            'CODE' => $infoBlockCode,
            'NAME' => $infoBlockFields['name'],
            'ACTIVE' => 'Y',
            'SORT' => 100,
            'LIST_PAGE_URL' => "#SITE_DIR#/$infoBlockCode/",
            'DETAIL_PAGE_URL' => "#SITE_DIR#/$infoBlockCode/#SECTION_ID#/#ELEMENT_ID#/",
            'SECTION_PAGE_URL' => "#SITE_DIR#/$infoBlockCode/#SECTION_ID#/",
            'DESCRIPTION' => $infoBlockFields['name'],
            'DESCRIPTION_TYPE' => 'html',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'SECTION_PROPERTY' => 'Y',
            'SECTIONS_NAME' => 'Разделы',
            'SECTION_NAME' => 'Раздел',
            'ELEMENTS_NAME' => 'Товары',
            'ELEMENT_NAME' => 'Товар',
            'EXTERNAL_ID' => 'books'
        ]);

        //устанавливаем доступ
        CIBlock::SetPermission($newInfoBlockId, ["1"=>"X", "2"=>"R"]);

        //добавляем свойства к блоку
        foreach ($infoBlocksProperties as $index => $property) {
            $propertyBlock = new CIBlockProperty;

            $propertyBlock->Add([
                "NAME" => $property['name'],
                "ACTIVE" => "Y",
                "SORT" => ($index + 1) * 100,
                "CODE" =>  $property['code'],
                "PROPERTY_TYPE" =>  $property['type'],
                "IBLOCK_ID" => $newInfoBlockId,
                "MULTIPLE" =>  $property['multitype'],
            ]);
        }

        //добавляем торговый каталог
        $boolResult = CCatalog::Add([
            'IBLOCK_ID' => $newInfoBlockId
        ]);
        if ($boolResult == false)
        {
            if ($ex = $APPLICATION->GetException())
            {
                $strError = $ex->GetString();
                ShowError($strError);
            }
        }
    } else {
        print_r("Инфоблок $blockId существует ....");
    }
}

require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/tools/backup.php");
CMain::FinalActions();
?>

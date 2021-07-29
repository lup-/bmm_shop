<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

$publisherId = $_REQUEST['PUBLISHER_ID'];
$publisherIblockId = $arParams['IBLOCK_ID'];

$elementIterator = CIBlockElement::getList(
    [],
    [
        "IBLOCK_ID" => $publisherIblockId,
        "ID" => $publisherId,
    ],
    false,
    false,
    ["ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE"]
);

$linked = false;
if ($element = $elementIterator->Fetch())
{
    $linked = $element;
    if($element['PREVIEW_PICTURE'] > 0 ) {
        $linked['PREVIEW_PICTURE'] = CFile::GetFileArray($linked['PREVIEW_PICTURE']);
    }
}

$ELEMENT_SORT_FIELD = "sort";
$ELEMENT_SORT_FIELD2 = "id";
$ELEMENT_SORT_ORDER = "asc";
$ELEMENT_SORT_ORDER2 = "asc";
if($_GET['sort']) {
    switch ($_GET['sort']){
        case 'price_up':
            $ELEMENT_SORT_FIELD = 'catalog_PRICE_1';
            $ELEMENT_SORT_ORDER = 'asc';
            break;
        case 'price_down':
            $ELEMENT_SORT_FIELD = 'catalog_PRICE_1';
            $ELEMENT_SORT_ORDER = 'desc';
            break;
        case 'rating':
            $ELEMENT_SORT_FIELD = 'PROPERTY_rating';
            $ELEMENT_SORT_ORDER = 'desc';
            $ELEMENT_SORT_FIELD2 = 'PROPERTY_BLOG_COMMENTS_CNT';
            $ELEMENT_SORT_ORDER2 = 'desc';
            break;
    }
}

global $publisherFilter;
if ($linked) {
    $publisherFilter = ['PROPERTY_PUBLISHER' => $linked['NAME']];
}

$arResult['LINKED'] = $linked;
$arResult['ELEMENT_SORT_FIELD'] = $ELEMENT_SORT_FIELD;
$arResult['ELEMENT_SORT_ORDER'] = $ELEMENT_SORT_ORDER;
$arResult['ELEMENT_SORT_FIELD2'] = $ELEMENT_SORT_FIELD2;
$arResult['ELEMENT_SORT_ORDER2'] = $ELEMENT_SORT_ORDER2;
$arResult['ELEMENTS_FILTER'] = $publisherFilter;
$arResult["BOOK_BLOCK_ID"] = $arParams["BOOK_BLOCK_ID"];
$arResult["RCM_PROD_ID"] = $_REQUEST["PRODUCT_ID"];

if ($linked && $arParams['SET_META_TAGS'] === 'Y') {
    $seoCacheId = serialize(['IBLOCK_ID' => $publisherIblockId, 'ELEMENT_ID' => $linked['ID']]);
    $seoCache = new CPHPCache();
    $seoParams = [];
    if ($seoCache->InitCache(36000, $seoCacheId, '/catalog/seo')) {
        $seoParams = $seoCache->GetVars();
    }
    elseif ($seoCache->StartDataCache()) {
        $priceFieldName = "PRICE_${arParams['PRICE_ID']}";
        $query = CIBlockElement::GetList(
            [$priceFieldName => 'ASC'],
            [
                'IBLOCK_ID' => $arResult['BOOK_BLOCK_ID'],
                'ACTIVE' => 'Y',
                'PROPERTY_PUBLISHER' => $linked['NAME'],
            ],
            false,
            false,
            ['ID', 'IBLOCK_ID', '*', $priceFieldName]
        );

        $minPriceElement = $query->Fetch();

        $seoParams = [
            'COUNT' => $query->result->num_rows,
            'MIN_PRICE' => $minPriceElement[$priceFieldName]
        ];

        $seoCache->EndDataCache($seoParams);
    }

    $replaceFields = $linked;
    $replaceFields['YEAR'] = date('Y');
    $replaceFields['MIN_PRICE'] = $seoParams['MIN_PRICE'];
    $replaceFields['COUNT'] = $seoParams['COUNT'];

    $title = $arParams['TITLE_TEMPLATE'];
    $description = $arParams['DESCRIPTION_TEMPLATE'];

    foreach ($replaceFields as $field => $value) {
        $title = str_replace("#${field}#", $value, $title);
        $description = str_replace("#${field}#", $value, $description);
    }

    $APPLICATION->SetTitle($title);
    $APPLICATION->SetPageProperty("description", $description);
}

$this->IncludeComponentTemplate();
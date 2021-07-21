<?
require $_SERVER['DOCUMENT_ROOT'].'/local/helper/cyrillic_urls.php';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
decodeRequestParams(['PUBLISHER_NAME']);

$elementIterator = CIBlockElement::getList(
    array(),
    array("IBLOCK_ID" => $_ENV['PUBLISHER_BLOCK_ID'], "NAME" => $_REQUEST['PUBLISHER_NAME']),
    false,
    false,
    array("ID", "IBLOCK_ID", "PREVIEW_TEXT","PREVIEW_PICTURE")
);
$linked = [];
if($element = $elementIterator->Fetch())
{
    $linked = $element;
    if($element['PREVIEW_PICTURE'] > 0 ) {
        $linked['PREVIEW_PICTURE'] = CFile::GetFileArray($linked['PREVIEW_PICTURE']);
    }
}
?>
<?if($_REQUEST['PUBLISHER_NAME']):?>
<div class="publisher-info">
    <h1><?=$_REQUEST['PUBLISHER_NAME']?></h1>
    <?if($linked):?>
        <div class="row">
            <div class="col-12 col-md-9 publisher-info__text">
                <?=$linked["PREVIEW_TEXT"]?>
            </div>
            <div class="col-12 col-md-3 publisher-info__image">
                <?if($linked['PREVIEW_PICTURE']["SRC"]):?>
                    <img src="<?=$linked['PREVIEW_PICTURE']["SRC"]?>">
                <?endif;?>
            </div>
        </div>
    <?endif;?>
</div>
<?endif;?>
<?

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
$publisherFilter = array('PROPERTY_PUBLISHER' => $_REQUEST['PUBLISHER_NAME']);
?>
<div class="catalog__row_5">
    <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"main_section",
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "Y",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/cart/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "main_section",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $ELEMENT_SORT_FIELD,
		"ELEMENT_SORT_FIELD2" => $ELEMENT_SORT_FIELD2,
		"ELEMENT_SORT_ORDER" => $ELEMENT_SORT_ORDER,
		"ELEMENT_SORT_ORDER2" => $ELEMENT_SORT_ORDER2,
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "publisherFilter",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"IBLOCK_ID" => $_ENV["BOOK_BLOCK_ID"],
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
			0 => "STICKER_HIT",
			1 => "STICKER_NEW",
			2 => "STICKER_ACTION",
		),
		"LAZY_LOAD" => "Y",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "0",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "main_navigation",
		"PAGER_TITLE" => "",
		"PAGE_ELEMENT_COUNT" => "20",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "bestsell",
		"SECTION_CODE" => "books_1",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "AUTHOR",
			2 => "",
		),
		"SEF_MODE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "Y",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"PROPERTY_CODE_MOBILE" => "",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"LABEL_PROP_MOBILE" => array(
			0 => "STICKER_HIT",
		),
		"LABEL_PROP_POSITION" => "bottom-left",
		"SEF_RULE" => "",
		"SECTION_CODE_PATH" => "",
		"MESS_BTN_LAZY_LOAD" => "Показать ещё"
	),
	false
);?>
</div>

<?
$APPLICATION->SetTitle("Издательства");
$APPLICATION->SetDirProperty('theme','red_image');
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

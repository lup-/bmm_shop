<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CJSCore::Init(array("jquery"));
?>
<?
//метод нахождения id рекомендуемых товаров
function getRecommendedIds($productId, $propertyName)
{
    if(!$productId)
        return array();

    $elementIterator = CIBlockElement::getList(
        array(),
        array("ID" => $productId),
        false,
        false,
        array("ID", "IBLOCK_ID")
    );

    $linked = array();
    if($element = $elementIterator->getNextElement())
    {
        $props = $element->getProperties();
        $linked = $props[$propertyName]['VALUE'];
    }

    if(empty($linked))
        $linked = -1;

    $productIterator = CIBlockElement::getList(
        array(),
        array("ID" => $linked),
        false,
        array(),
        array("ID")
    );

    $ids = array();
    while($item = $productIterator->fetch())
        $ids[] =  $item['ID'];

    return $ids;
}

//выдергиваем запрос для фильтра из урл, иначе символ + превращается в пробел
$regex = '/^\/.*\/filter\/(.*)\/apply\//';
$currentRequest = Bitrix\Main\Context::getCurrent()->getRequest()->getRequestedPage();
preg_match($regex, $currentRequest,$matches);
$smartFilterPath = $matches[1];

$sectionPath = $_REQUEST['SECTION_PATH'];
$smartPath = "/".$sectionPath.'/filter/#SMART_FILTER_PATH#/apply/';

$sectionID = $_REQUEST["SECTION_ID"];

//условия фильтра для разных секций
switch ($sectionPath) {
    case "latest":
        $title = 'Новинки';
        $smartPreFilter =  array('PROPERTY_STICKER_NEW_VALUE' => 'new');
        break;
    case 'bestsellers':
        $title = 'Бестселлеры';
        $smartPreFilter =  array('PROPERTY_BEST_SELLER_VALUE' => 'Y');
        break;
    case 'children':
        $title = 'Детям';
        $sectionID = $_ENV['CHILDREN_SECTION_ID'];
        break;
    case 'recommend':
        $title = 'Рекомендации';
        $smartPreFilter =  array('ID' => getRecommendedIds($_ENV['RECOMMEND_PRODUCT_ID'], 'RECOMMEND'));
        break;
}

$elementSortField = "PROPERTY_rating";
$elementSortField2 = "id";
$elementSortOrder = "desc";
$elementSortOrder2 = "desc";

//сортировка
if($_REQUEST['sort']) {
    switch ($_REQUEST['sort']){
        case 'price_up':
            $elementSortField = 'catalog_PRICE_1';
            $elementSortOrder = 'asc';
            break;
        case 'price_down':
            $elementSortField = 'catalog_PRICE_1';
            $elementSortOrder = 'desc';
            break;
        case 'rating':
            $elementSortField = 'PROPERTY_rating';
            $elementSortOrder = 'desc';
            $elementSortField2 = 'PROPERTY_BLOG_COMMENTS_CNT';
            $elementSortOrder2 = 'desc';
            break;
    }
}
?>
<div class="catalog row " id="mycomponent">
    <div class="catalog-filter d-md-flex col-md-3" id="filterModal" data-backdrop="false">
        <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                "section_filter",
                array(
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CONVERT_CURRENCY" => "N",
                    "CURRENCY_ID" => "RUB",
                    "DISPLAY_ELEMENT_COUNT" => "Y",
                    "FILTER_NAME" => "arrFilter",
                    "FILTER_VIEW_MODE" => "VERTICAL",
                    "HIDE_NOT_AVAILABLE" => "Y",
                    "IBLOCK_ID" => $_ENV["BOOK_BLOCK_ID"],
                    "IBLOCK_TYPE" => "catalog",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "POPUP_POSITION" => "left",
                    "PREFILTER_NAME" => "smartPreFilter",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "SAVE_IN_SESSION" => "N",
                    "SECTION_CODE" => "",
                    "SECTION_DESCRIPTION" => "-",
                    "SECTION_ID" => $sectionID,
                    "SECTION_TITLE" => $title,
                    "SEF_MODE" => "Y",
                    "TEMPLATE_THEME" => "blue",
                    "XML_EXPORT" => "N",
                    "SECTION_CODE_PATH" => $_REQUEST["SECTION_PATH"],
                    "SEF_RULE" => $smartPath,
                    "SMART_FILTER_PATH" => $smartFilterPath,
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "COMPONENT_TEMPLATE" => "section_filter",
                    "INSTANT_RELOAD" => "Y"
                ),
                array('HIDE_ICONS' => 'Y')
            );?>
    </div>
    <div class="catalog__main col-12 col-md-9">
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
		"COMPATIBLE_MODE" => "N",
		"COMPONENT_TEMPLATE" => "main_section",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DETAIL_URL" => "/books/#SECTION_ID#/#ELEMENT_ID#/",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $elementSortField,
		"ELEMENT_SORT_FIELD2" => $elementSortField2,
		"ELEMENT_SORT_ORDER" => $elementSortOrder,
		"ELEMENT_SORT_ORDER2" => $elementSortOrder2,
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => $_ENV["BOOK_BLOCK_ID"],
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_TYPE_ID" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
        "LABEL_PROP" => array(
            0 => "STICKER_HIT",
            1 => "STICKER_NEW",
            2 => "STICKER_ACTION",
        ),
		"LABEL_PROP_MOBILE" => array(
            0 => "STICKER_HIT",
            1 => "STICKER_NEW",
            2 => "STICKER_ACTION",
        ),
		"LABEL_PROP_POSITION" => "top-left",
		"LAZY_LOAD" => "Y",
		"LINE_ELEMENT_COUNT" => "4",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "",
			1 => "",
			2 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
			2 => "",
			3 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "asc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "",
			1 => "",
			2 => "",
		),
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "main_navigation",
		"PAGER_TITLE" => $title,
		"PAGE_ELEMENT_COUNT" => "20",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,quantity,quantityLimit,sku,buttons",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => "",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_MOBILE" => "",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"SECTION_ID" => $sectionID,
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "/books/#SECTION_ID#/",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
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
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "site",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"SEF_RULE" => "",
		"SECTION_CODE_PATH" => "",
		"MESS_BTN_LAZY_LOAD" => "Показать ещё"
	),
	false
);?>
    </div>
</div>
<?
$APPLICATION->SetTitle($title);
$APPLICATION->SetDirProperty('theme','red_image');
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>






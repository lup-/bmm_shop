<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
\Bitrix\Main\UI\Extension::load("ui.vue");
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <? $APPLICATION->ShowHead(); ?>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
    <meta content="ie=edge" http-equiv="x-ua-compatible"/>
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@100;400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.0.0/nouislider.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.0.0/nouislider.min.js"></script>

    <title><?$APPLICATION->ShowTitle()?></title>
    <link href="template_styles.css" rel="stylesheet">

</head>
<body>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="wrapper">
    <div class="header-theme header-theme_<?$APPLICATION->ShowProperty('theme');?>">
        <div class="container">
            <nav class="nav-main navbar navbar-expand-lg">
                <div class="collapse navbar-collapse" id="navigation">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <img alt="" class="location" src=""/>
                            <a class="nav-link location" href="#">Петропавловск-Камчатский<span class="sr-only">(current)</span> </a>
                        </li>
                    </ul>
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "top_menu", Array(
                        "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                        "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
                        "DELAY" => "N",	// Откладывать выполнение шаблона меню
                        "MAX_LEVEL" => "1",	// Уровень вложенности меню
                        "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                        "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                        "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                        "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                        "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
                        "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                        false
                    );?>

                    <ul class="navbar-nav">
                    <?$APPLICATION->IncludeFile(
                        "/auth/index.php",
                        Array(),
                        Array("MODE"=>"php")
                        );?>

                        <li>
                            <?if ($_GET['logout'] === 'y') {
                                $USER->Logout();
                                LocalRedirect('/');
                            }?>
                        <li>

                        <li class="nav-item">
                            <a class="nav-link phone" href="tel:+ 7 495 984-35-23">+ 7 495 984-35-23</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="navigation">
                <ul class="navigation__left">
                    <li class="navigation-item">
                        <a class="navigation-logo" href="/"> <img src="/images/logo.svg"> </a>
                    </li>
                    <li class="navigation-item navigation-name">
                        Официальный магазин торгового дома БММ
                    </li>
                    <?$APPLICATION->IncludeComponent("bitrix:search.title", "search_form", Array(
                        "NUM_CATEGORIES" => "1",
                        "TOP_COUNT" => "5",
                        "CHECK_DATES" => "N",
                        "SHOW_OTHERS" => "N",
                        "PAGE" => SITE_DIR."books/",
                        "CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
                        "CATEGORY_0" => array(
                        0 => "iblock_catalog",
                        ),
                        "CATEGORY_0_iblock_catalog" => array(
                        0 => "all",
                        ),
                        "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                        "SHOW_INPUT" => "Y",
                        "INPUT_ID" => "title-search-input",
                        "CONTAINER_ID" => "search",
                        "PRICE_CODE" => array(
                        0 => "BASE",
                        ),
                        "SHOW_PREVIEW" => "Y",
                        "PREVIEW_WIDTH" => "75",
                        "PREVIEW_HEIGHT" => "75",
                        "CONVERT_CURRENCY" => "Y",
                        ),
                        false
                    );?>
                </ul>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:sale.basket.basket.line",
                    "bootstrap_v5",
                    array(
                        "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                        "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                        "SHOW_PERSONAL_LINK" => "N",
                        "SHOW_NUM_PRODUCTS" => "Y",
                        "SHOW_TOTAL_PRICE" => "N",
                        "SHOW_PRODUCTS" => "N",
                        "POSITION_FIXED" => "N",
                        "SHOW_AUTHOR" => "N",
                        "PATH_TO_REGISTER" => SITE_DIR."login/",
                        "PATH_TO_PROFILE" => SITE_DIR."personal/",
                        "COMPONENT_TEMPLATE" => "bootstrap_v5",
                        "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                        "SHOW_EMPTY_VALUES" => "N",
                        "PATH_TO_AUTHORIZE" => "",
                        "SHOW_REGISTRATION" => "Y",
                        "HIDE_ON_BASKET_PAGES" => "N",
                        "POSITION_HORIZONTAL" => "right",
                        "POSITION_VERTICAL" => "top"
                    ),
                    false
                );?>
            </div>
            <header class="header">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "main_menu",
                    array(
                        "ROOT_MENU_TYPE" => "left",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_THEME" => "site",
                        "CACHE_SELECTED_ITEMS" => "N",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "MAX_LEVEL" => "4",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "COMPONENT_TEMPLATE" => "main_menu"
                    ),
                    false
                );?>
                <?
                $needHeadTitle= preg_match("~^".SITE_DIR."(publisher|children|latest|bestsellers|recommend|personal\/cart|personal\/order\/make)/~", $curPage);?>
<?if($needHeadTitle):?>
            <div class="header__container">
                <h1><?$APPLICATION->ShowTitle()?></h1>
            </div>
        </header>
    </div>
</div>
<div class="content pb-5">
<?else:?>
        </header>
        <?if (CSite::InDir('/index.php')):?>
            <div class="header-content header-banners">
                <?
                global $arrFilter;

                $arrFilter = array('PROPERTY_SHOW_ON' => 'slider');
                $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"banner_slider", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arrFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => $_ENV["BANNER_BLOCK_ID"],
		"IBLOCK_TYPE" => "banners",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "round",
		"PAGER_TITLE" => "баннеры",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "SHOW_ON",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "banner_slider"
	),
	false
);?>
                <?
                global $arrFilter;
                $arrFilter = array('PROPERTY_SHOW_ON' => 'main');
                $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"banner_right", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arrFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => $_ENV["BANNER_BLOCK_ID"],
		"IBLOCK_TYPE" => "banners",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "2",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "round",
		"PAGER_TITLE" => "баннеры",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "SHOW_ON",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "banner_right"
	),
	false
);?>

            </div>
        <?endif;?>
    </div>
</div>
<div class="content">
<?endif;?>
    <div class="container">

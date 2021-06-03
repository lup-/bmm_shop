<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
\Bitrix\Main\UI\Extension::load("ui.vue");
CJSCore::Init(array("fx"));
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

    <title>BMM shop</title>

    <link href="template_styles.css" rel="stylesheet"/>
</head>
<body>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="wrapper">
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
            <?/*$APPLICATION->IncludeFile(
                "/auth/index.php",
                Array(),
                Array("MODE"=>"php")
            );*/?>
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
        <li class="navigation-item">
          <form class="form-inline navigation-form my-2 my-lg-0">
            <input aria-label="Search" class="form-control mr-sm-2" placeholder="Поиск книг, авторов" type="search"/>
            <button class="btn navbtn btn-default my-2 my-sm-0" type="submit">Найти</button>
          </form>
        </li>
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
                "HIDE_ON_BASKET_PAGES" => "Y",
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
    </header>
      <?if (CSite::InDir('/index.php')):?>
          <div class="header-content header-banners">
              <?$APPLICATION->IncludeComponent(
                  "bitrix:news.line",
                  "slider",
                  array(
                      "COMPONENT_TEMPLATE" => "slider",
                      "IBLOCK_TYPE" => "banners",
                      "IBLOCKS" => array(
                          0 => "10",
                      ),
                      "NEWS_COUNT" => "4",
                      "FIELD_CODE" => array(
                          0 => "",
                          1 => "",
                      ),
                      "SORT_BY1" => "ACTIVE_FROM",
                      "SORT_ORDER1" => "DESC",
                      "SORT_BY2" => "SORT",
                      "SORT_ORDER2" => "ASC",
                      "DETAIL_URL" => "",
                      "CACHE_TYPE" => "A",
                      "CACHE_TIME" => "300",
                      "CACHE_GROUPS" => "Y",
                      "ACTIVE_DATE_FORMAT" => "d.m.Y"
                  ),
                  false
              );?>
              <?$APPLICATION->IncludeComponent("bitrix:news.line", "right_banner", Array(
                  "COMPONENT_TEMPLATE" => "",
                  "IBLOCK_TYPE" => "banners",	// Тип информационного блока
                  "IBLOCKS" => array(	// Код информационного блока
                      0 => "11",
                  ),
                  "NEWS_COUNT" => "2",	// Количество новостей на странице
                  "FIELD_CODE" => array(	// Поля
                      0 => "",
                      1 => "",
                  ),
                  "SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
                  "SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
                  "SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
                  "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
                  "DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
                  "CACHE_TYPE" => "A",	// Тип кеширования
                  "CACHE_TIME" => "300",	// Время кеширования (сек.)
                  "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                  "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
              ),
                  false
              );?>
          </div>
      <?endif;?>
  </div>
    <div class="content">
        <div class="container">

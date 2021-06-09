<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Политика конфидиальности");
?>
<section class="content-wrap">
    <div class="content-wrap__sidebar">
        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "info_menu",
            Array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "left",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => array(""),
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "info",
                "USE_EXT" => "N"
            )
        );?>
    </div>
    <div class="content-wrap__content">
        <div class="content__head">
            <h1>Политика конфиденциальности</h1>
            <div class="content__date">
                <span>"02" марта 2021</span>
                <span>г. Москва</span>
            </div>
        </div>
        <p>Настоящая Политика конфиденциальности персональных данных (далее – Политика конфиденциальности) действует в отношении всей информации, которую Интернет-магазин «Официальный интернет-магазин Торгового Дома БММ», расположенный на доменном имени
            <a href="http://www.bmm.ru">http://www.bmm.ru</a>, может получить о Пользователе во время использования сайта Интернет-магазина, программ и продуктов Интернет-магазина.</p>
        <ol class="politics-list nested">
            <li class="politics-list__item title">ОПРЕДЕЛЕНИЕ ТЕРМИНОВ
                <ol class="list-submenu">
                    <li>Написать статью</li>
                    <li>Почитать книгу 1 час</li>
                    <li>Сходить в кино</li>
                </ol>
            </li>
            <li class="politics-list__item title">ОБЩИЕ ПОЛОЖЕНИЯ
                <ol class="list-submenu">
                    <li>Написать статью</li>
                    <li>Почитать книгу 1 час</li>
                    <li>Сходить в кино</li>
                </ol></li>
            <li class="politics-list__item title">ПРЕДМЕТ ПОЛИТИКИ КОНФИДЕНЦИАЛЬНОСТИ</li>
            <li class="politics-list__item title">ЦЕЛИ СБОРА ПЕРСОНАЛЬНОЙ ИНФОРМАЦИИ ПОЛЬЗОВАТЕЛЯ</li>
            <li class="politics-list__item title">СПОСОБЫ И СРОКИ ОБРАБОТКИ ПЕРСОНАЛЬНОЙ ИНФОРМАЦИИ</li>
            <li class="politics-list__item title">ОБЯЗАТЕЛЬСТВА СТОРОН</li>
            <li class="politics-list__item title">ОТВЕТСТВЕННОСТЬ СТОРОН</li>
            <li class="politics-list__item title">РАЗРЕШЕНИЕ СПОРОВ</li>
            <li class="politics-list__item title">ДОПОЛНИТЕЛЬНЫЕ УСЛОВИЯ</li>

        </ol>

    </div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>



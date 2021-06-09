<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
</div>
  <footer class="footer">
    <div class="container">
        <?$APPLICATION->IncludeComponent("bitrix:catalog.products.viewed", "viewed_slider", Array(
            "ACTION_VARIABLE" => "action_cpv",	// Название переменной, в которой передается действие
            "ADDITIONAL_PICT_PROP_3" => "-",	// Дополнительная картинка
            "ADDITIONAL_PICT_PROP_4" => "-",	// Дополнительная картинка
            "ADDITIONAL_PICT_PROP_6" => "-",	// Дополнительная картинка
            "ADDITIONAL_PICT_PROP_7" => "-",	// Дополнительная картинка
            "ADDITIONAL_PICT_PROP_8" => "-",	// Дополнительная картинка
            "ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
            "ADD_TO_BASKET_ACTION" => "ADD",	// Показывать кнопку добавления в корзину или покупки
            "BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
            "CACHE_GROUPS" => "Y",	// Учитывать права доступа
            "CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "CACHE_TYPE" => "A",	// Тип кеширования
            "CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
            "DEPTH" => "2",	// Максимальная отображаемая глубина разделов
            "DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
            "ENLARGE_PRODUCT" => "STRICT",	// Выделять товары в списке
            "HIDE_NOT_AVAILABLE" => "N",	// Недоступные товары
            "HIDE_NOT_AVAILABLE_OFFERS" => "N",	// Недоступные торговые предложения
            "IBLOCK_ID" => "",	// Инфоблок
            "IBLOCK_MODE" => "multi",	// Показывать товары из
            "IBLOCK_TYPE" => "catalog",	// Тип инфоблока
            "LABEL_PROP_3" => "",	// Свойство меток товара
            "LABEL_PROP_6" => "",	// Свойство меток товара
            "LABEL_PROP_7" => "",	// Свойство меток товара
            "LABEL_PROP_8" => "",	// Свойство меток товара
            "LABEL_PROP_POSITION" => "top-left",	// Расположение меток товара
            "MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
            "MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
            "MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
            "MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
            "MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
            "PAGE_ELEMENT_COUNT" => "30",	// Количество элементов на странице
            "PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
            "PRICE_CODE" => "",	// Тип цены
            "PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",	// Порядок отображения блоков товара
            "PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
            "PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",	// Вариант отображения товаров
            "PRODUCT_SUBSCRIPTION" => "Y",	// Разрешить оповещения для отсутствующих товаров
            "SECTION_CODE" => "",	// Код раздела
            "SECTION_ELEMENT_CODE" => "",	// Символьный код элемента, для которого будет выбран раздел
            "SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],	// ID элемента, для которого будет выбран раздел
            "SECTION_ID" => $GLOBALS["CATALOG_CURRENT_SECTION_ID"],	// ID раздела
            "SHOW_CLOSE_POPUP" => "N",	// Показывать кнопку продолжения покупок во всплывающих окнах
            "SHOW_DISCOUNT_PERCENT" => "N",	// Показывать процент скидки
            "SHOW_FROM_SECTION" => "N",	// Показывать товары из раздела
            "SHOW_MAX_QUANTITY" => "N",	// Показывать остаток товара
            "SHOW_OLD_PRICE" => "N",	// Показывать старую цену
            "SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
            "SHOW_PRODUCTS_3" => "N",	// Показывать товары каталога
            "SHOW_PRODUCTS_6" => "N",	// Показывать товары каталога
            "SHOW_PRODUCTS_7" => "N",	// Показывать товары каталога
            "SHOW_PRODUCTS_8" => "N",	// Показывать товары каталога
            "SHOW_SLIDER" => "Y",	// Показывать слайдер для товаров
            "SLIDER_INTERVAL" => "3000",	// Интервал смены слайдов, мс
            "SLIDER_PROGRESS" => "N",	// Показывать полосу прогресса
            "TEMPLATE_THEME" => "blue",	// Цветовая тема
            "USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
            "USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
            "USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
        ),
        false
        );?>

      <div class="footer__content">
		  <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
				"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
				"CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
				"DELAY" => "N",	// Откладывать выполнение шаблона меню
				"MAX_LEVEL" => "1",	// Уровень вложенности меню
				"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
					0 => "",
				),
				"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
				"MENU_CACHE_TYPE" => "N",	// Тип кеширования
				"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
				"ROOT_MENU_TYPE" => "bottom",	// Тип меню для первого уровня
				"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
			),
			false
		);?>
         <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "bottom1",
                "USE_EXT" => "N",
                "COMPONENT_TEMPLATE" => "footer_menu"
                ),
                false
            );?>
			<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "bottom_menu", Array(
                "ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
                    "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
                    "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                    "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                    "CACHE_TYPE" => "A",	// Тип кеширования
                    "COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
                    "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",	// Показывать количество
                    "FILTER_NAME" => "sectionsFilter",	// Имя массива со значениями фильтра разделов
                    "IBLOCK_ID" => "6",	// Инфоблок
                    "IBLOCK_TYPE" => "catalog",	// Тип инфоблока
                    "SECTION_CODE" => "",	// Код раздела
                    "SECTION_FIELDS" => array(	// Поля разделов
                        0 => "",
                        1 => "",
                    ),
                    "SECTION_ID" => "16",	// ID раздела
                    "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
                    "SECTION_USER_FIELDS" => array(	// Свойства разделов
                        0 => "",
                        1 => "",
                    ),
                    "SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
                    "TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
                    "VIEW_MODE" => "TEXT",	// Вид списка подразделов
                ),
                false
            );?>
      </div>
      <div class="footer__bottom row">
        <div class="footer-socials col-12 col-md-6">
          <div class="footer-socials__item footer-socials__item--fb"><a href="">Мы в Facebook</a></div>
          <div class="footer-socials__item footer-socials__item--vk"><a href="">Мы в VK</a></div>
          <div class="footer-socials__item footer-socials__item--inst"><a href="">Мы в Instagram</a></div>
        </div>
        <div class="footer__payments col-12 col-md-6">
          <div class="payment payment--visa"></div>
          <div class="payment payment--mir"></div>
          <div class="payment payment--master"></div>
          <div class="payment payment--verified"></div>
          <div class="payment payment--verifmaster"></div>
        </div>

      </div>

      <div class="footer__info">
        Информация, размещенная на сайте интернет магазина <a href="">www.bmm.ru</a> не является публичной офертой
        установленной положениями ст. 437 ГК РФ и носит справочный характер. Цена, наличие и количество доступного к
        продаже товара может отличаться от размещенного на странице интернет магазина <a href="">www.bmm.ru</a>.
        Уточняйте информацию у менеджеров магазина.
      </div>
      <div class="footer__links row">
        <div class="footer__links-item col-12 col-sm-6 col-md-4">
          <a href="/about/policy/">Политика конфиденциальности</a>
        </div>
        <div class="footer__links-item col-12 col-sm-6 col-md-4">
          <a href="/about/offert/">Публичная оферта</a>
        </div>
        <div class="footer__links-item col-12 col-sm-6 col-md-4">
          <a href="/about/agreement/">Пользовательское соглашение</a>
        </div>
      </div>
    </div>
  </footer>
</div>
</div>

<script src="dist/main.bundle.js"></script>
</body>
</html>

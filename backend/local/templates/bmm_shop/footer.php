<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
</div>
  <footer class="footer">
    <div class="container">
        <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.products.viewed", 
	"viewed_slider", 
	array(
		"ACTION_VARIABLE" => "action_cpv",
		"ADDITIONAL_PICT_PROP_3" => "-",
		"ADDITIONAL_PICT_PROP_4" => "-",
		"ADDITIONAL_PICT_PROP_6" => "-",
		"ADDITIONAL_PICT_PROP_7" => "-",
		"ADDITIONAL_PICT_PROP_8" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/cart/",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CONVERT_CURRENCY" => "N",
		"DEPTH" => "2",
		"DISPLAY_COMPARE" => "N",
		"ENLARGE_PRODUCT" => "STRICT",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "",
		"IBLOCK_MODE" => "multi",
		"IBLOCK_TYPE" => "catalog",
		"LABEL_PROP_3" => array(
		),
		"LABEL_PROP_6" => array(
		),
		"LABEL_PROP_7" => array(
		),
		"LABEL_PROP_8" => array(
		),
		"LABEL_PROP_POSITION" => "top-left",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"PAGE_ELEMENT_COUNT" => "9",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_CODE" => "",
		"SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],
		"SECTION_ID" => $GLOBALS["CATALOG_CURRENT_SECTION_ID"],
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_PRODUCTS_3" => "N",
		"SHOW_PRODUCTS_6" => "N",
		"SHOW_PRODUCTS_7" => "N",
		"SHOW_PRODUCTS_8" => "N",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "viewed_slider"
	),
	false
);?>

      <div class="footer__content">
		  <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer_menu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "bottom",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "footer_menu"
	),
	false
);?>
         <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer_menu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "bottom1",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "footer_menu"
	),
	false
);?>
          <?$APPLICATION->IncludeComponent(
              "bitrix:menu",
              "bottom_section_menu",
              Array(
                  "ALLOW_MULTI_SELECT" => "N",
                  "CHILD_MENU_TYPE" => "left",
                  "DELAY" => "N",
                  "MAX_LEVEL" => "1",
                  "MENU_CACHE_GET_VARS" => array(""),
                  "MENU_CACHE_TIME" => "3600",
                  "MENU_CACHE_TYPE" => "N",
                  "MENU_CACHE_USE_GROUPS" => "Y",
                  "ROOT_MENU_TYPE" => "bottom_section",
                  "USE_EXT" => "Y"
              )
          );?>
      </div>
      <div class="footer__bottom row">
        <div class="footer-socials col-12 col-md-6">
          <div class="footer-socials__item footer-socials__item--fb"><a href="https://www.facebook.com/tdbmm">Мы в Facebook</a></div>
          <div class="footer-socials__item footer-socials__item--vk"><a href="https://vk.com/td_bmm">Мы в VK</a></div>
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
        <?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_footer_menu", array(
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "",
            "DELAY" => "N",
            "MAX_LEVEL" => "1",
            "MENU_CACHE_GET_VARS" => array(
            ),
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "ROOT_MENU_TYPE" => "bottom_footer",
            "USE_EXT" => "N",
            "COMPONENT_TEMPLATE" => "bottom_footer_menu"
        ),
            false
        );?>
    </div>
  </footer>
</div>
</div>
</body>
</html>

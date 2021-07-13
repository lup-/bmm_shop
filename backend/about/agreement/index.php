<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Пользовательское соглашение");
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
        <div class="content-wrap__content content-wrap__content_text">
            Настоящим я даю Обществу с ограниченной ответственностью Издательство «Окей-книга» согласие на обработку предоставленных мной персональных данных в соответствии с положениями&nbsp; Федерального закона от 27.07.2009 г. № 152-ФЗ «О&nbsp;персональных данных» и <a href="/about/policy/">Условиями продажи товаров на сайте интернет-магазина «<span style="color: #231f20; font-weight: 700;">Официальный книжный Торгового Дома БММ</span>»</a>, с которыми я ознакомлен и полностью принимаю.<br>
        </div>
 </section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
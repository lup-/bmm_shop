<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оплата");
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
        <h3 class="content__head">Оплата товара</h3>
        <p>
            1. Расчеты между Продавцом и Покупателем за Товар производятся одним из указанных на Сайте способов, доступных для конкретного Заказа. Согласованным способом оплаты считается способ, выбранный Покупателем при оформлении Заказа.
        </p>
        <p>
            2. Продавец принимает оплату за Товар в российских рублях согласно законодательству Российской Федерации.
        </p>
        <p>
            3. Осуществляя платеж на Сайте или при получении Заказа банковской картой, Покупатель соглашается с направлением ему кассового чека в электронной форме (ссылки на кассовый чек с возможностью скачать его в формате PDF) на электронную почту либо на номер телефона (в случае отсутствия у Продавца информации об электронной почте). Кассовый чек в печатной форме в таком случае Покупателю не предоставляется.
        </p>
    </div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
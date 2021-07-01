<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
?>

<? $APPLICATION->IncludeComponent(
    "bmm:favorites",
    "list",
    Array(
        "FAVORITE_DETAILS_URL" => "/personal/favorite/",
        "LOAD_DETAILS" => "Y",
        "PRICE_ID" => 1,
    ),
    false
);?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Публичная оферта");
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
                <h1>Публичная оферта</h1>
            </div>
        </div>
    </section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
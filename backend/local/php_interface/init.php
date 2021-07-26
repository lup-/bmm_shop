<?php
AddEventHandler("main", "OnBeforeUserRegister", Array("RegistrationClass", "OnBeforeUserRegisterHandler"));
AddEventHandler("sale", "OnOrderSave", 'OnOrderSaveHandler');

class RegistrationClass
{
    function OnBeforeUserRegisterHandler(&$arFields)
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];
    }
}

function OnOrderSaveHandler(&$ID, &$arFields, &$orderFields, &$isNew) {
    include_once $_SERVER["DOCUMENT_ROOT"]."/local/helper/yandexDelivery.php";

    $yandexDelivery = new YandexDelivery();

    if($yandexDelivery->isAllowDeliveryRequest($ID)) {
        $yandexDelivery->createOrderDraft($ID);
    }
}

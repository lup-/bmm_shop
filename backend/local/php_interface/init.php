<?php
AddEventHandler("main", "OnBeforeUserRegister", Array("RegistrationClass", "OnBeforeUserRegisterHandler"));
class RegistrationClass
{
    function OnBeforeUserRegisterHandler(&$arFields)
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];
    }
}

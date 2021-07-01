<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = [
    "GROUPS"     => [],
    "PARAMETERS" => [
        "FAVORITE_DETAILS_URL" => [
            "PARENT"   => "BASE",
            "NAME"     => "Ссылка на раздел избранного",
            "TYPE"     => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT"  => "#",
        ],
        "LOAD_DETAILS" => [
            "PARENT"   => "BASE",
            "NAME"     => "Загружать товары из базы",
            "TYPE"     => "CHECKBOX",
            "MULTIPLE" => "N",
            "DEFAULT"  => "N",
        ],
        "PRICE_ID" => [
            "PARENT"   => "BASE",
            "NAME"     => "Код цены",
            "TYPE"     => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT"  => "N",
        ],
    ],
];
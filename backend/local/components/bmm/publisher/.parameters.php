<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = [
    "GROUPS"     => [],
    "PARAMETERS" => [
        'IBLOCK_ID' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Инфоблок',
            'TYPE'    => 'STRING',
            'REFRESH' => 'Y',
        ],
        'BOOK_BLOCK_ID' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Инфоблок с книгами',
            'TYPE'    => 'STRING',
            'REFRESH' => 'Y',
        ],
        "SHOW_BOOKS" => [
            "PARENT"   => "BASE",
            "NAME"     => "Показывать книги издательства",
            "TYPE"     => "CHECKBOX",
            "MULTIPLE" => "N",
            "DEFAULT"  => "N",
        ],
        "SET_META_TAGS" => [
            "PARENT"   => "BASE",
            "NAME"     => "Установить мета-тэги страницы",
            "TYPE"     => "CHECKBOX",
            "MULTIPLE" => "N",
            "DEFAULT"  => "N",
        ],
        "TITLE_TEMPLATE" => [
            "PARENT"   => "BASE",
            "NAME"     => "Шаблон тэга title",
            'TYPE'    => 'STRING',
        ],
        "DESCRIPTION_TEMPLATE" => [
            "PARENT"   => "BASE",
            "NAME"     => "Шаблон тэга description",
            'TYPE'    => 'STRING',
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
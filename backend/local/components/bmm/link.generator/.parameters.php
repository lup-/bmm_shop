<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = [
    "GROUPS"     => [],
    "PARAMETERS" => [
        'IBLOCK_ID' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Инфоблок',
            'TYPE'    => 'STRING',
        ],
        'IBLOCK_SECTION_ID' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Раздел инфоблока',
            'TYPE'    => 'STRING',
        ],
        'ELEMENT_NAME' => [
            'PARENT' => 'BASE',
            'NAME'   => 'Название элемента',
            'TYPE'   => 'STRING',
        ],
        'URL_TEMPLATE' => [
            'PARENT' => 'BASE',
            'NAME'   => 'Шаблон ссылки',
            'TYPE'   => 'STRING',
        ],
    ],
];
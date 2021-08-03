<?php
$arUrlRewrite=array (
    21 =>
        array (
            'CONDITION' => '#^/(bestsellers|children|latest|recommend)/filter/(.*?)/apply/#',
            'RULE' => 'SECTION_ID=16&SECTION_PATH=$1&SMART_FILTER_PATH=$2&$3',
            'ID' => '',
            'PATH' => '/catalog/filtered.php',
            'SORT' => 100,
        ),
    22 =>
        array (
            'CONDITION' => '#^/(bestsellers|children|latest|recommend)/.*#',
            'RULE' => 'SECTION_ID=16&SECTION_PATH=$1',
            'ID' => 'bitrix:catalog',
            'PATH' => '/catalog/filtered.php',
            'SORT' => 100,
        ),
    0 =>
        array (
            'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
            'RULE' => 'componentName=$1',
            'ID' => NULL,
            'PATH' => '/bitrix/services/mobileapp/jn.php',
            'SORT' => 100,
        ),
    2 =>
        array (
            'CONDITION' => '#^/bitrix/services/ymarket/#',
            'RULE' => '',
            'ID' => '',
            'PATH' => '/bitrix/services/ymarket/index.php',
            'SORT' => 100,
        ),
    12 =>
        array (
            'CONDITION' => '#^/publisher/(.*?)/#',
            'RULE' => 'PUBLISHER_NAME=$1&$2',
            'ID' => '',
            'PATH' => '/catalog/publisher.php',
            'SORT' => 100,
        ),
    5 =>
        array (
            'CONDITION' => '#^/personal/order/#',
            'RULE' => '',
            'ID' => 'bitrix:sale.personal.order',
            'PATH' => '/personal/order/index.php',
            'SORT' => 100,
        ),
    18 =>
        array (
            'CONDITION' => '#^/non-books/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog',
            'PATH' => '/catalog/non-books/index.php',
            'SORT' => 100,
        ),
    28 =>
        array (
            'CONDITION' => '#^/personal/#',
            'RULE' => '',
            'ID' => 'bitrix:sale.personal.section',
            'PATH' => '/personal/index.php',
            'SORT' => 100,
        ),
    7 =>
        array (
            'CONDITION' => '#^/store/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog.store',
            'PATH' => '/store/index.php',
            'SORT' => 100,
        ),
    10 =>
        array (
            'CONDITION' => '#^/foods/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog',
            'PATH' => '/catalog/foods/index.php',
            'SORT' => 100,
        ),
    26 =>
        array (
            'CONDITION' => '#^/books/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog',
            'PATH' => '/catalog/index.php',
            'SORT' => 100,
        ),
    1 =>
        array (
            'CONDITION' => '#^/rest/#',
            'RULE' => '',
            'ID' => NULL,
            'PATH' => '/bitrix/services/rest/index.php',
            'SORT' => 100,
        ),
    27 =>
        array (
            'CONDITION' => '#^/news/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/news/index.php',
            'SORT' => 100,
        ),
    29 =>
        array (
            'CONDITION' => '#^/api/orders/#',
            'RULE' => '',
            'ID' => '',
            'PATH' => '/local/api/orders.php',
            'SORT' => 100,
        ),
    30 =>
        array (
            'CONDITION' => '#^/api/order/([0-9]+).*/#',
            'RULE' => 'orderId=$1&$2',
            'ID' => '',
            'PATH' => '/local/api/order.php',
            'SORT' => 100,
        ),
);

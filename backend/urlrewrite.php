<?php
$arUrlRewrite=array (
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
  5 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/bestsellers/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/catalog/filtered.php?filter=bestsellers',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/recommend/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/catalog/recommend.php',
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
  6 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/children/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/catalog/filtered.php?filter=children',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/latest/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/catalog/filtered.php?filter=latest',
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
  19 => 
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
  3 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
);

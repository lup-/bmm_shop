<?php
/** @global array $arResult */
use Bitrix\Iblock\Component\Tools;

foreach ($arResult['ORDERS'] as $orderIndex => $order) {
    $basketItemIds = array_map(function ($item) {
        return $item['PRODUCT_ID'];
    }, $order['BASKET_ITEMS']);

    $detailImagesByIds = [];
    $itemProps = [];
    $fullItemsQuery = CIBlockElement::GetList(false, ['ID' => $basketItemIds]);
    while ($item = $fullItemsQuery->GetNextElement()) {
        $fields = $item->GetFields();
        Tools::getFieldImageData(
            $fields,
            ['DETAIL_PICTURE'],
            Tools::IPROPERTY_ENTITY_ELEMENT,
            'IPROPERTY_VALUES'
        );
        $detailImagesByIds[$fields['ID']] = $fields['DETAIL_PICTURE']['SRC'];
        $itemProps[$fields['ID']] = $item->GetProperties();
    }

    foreach ($order['BASKET_ITEMS'] as $basketIndex => $basketItem) {
        $imageSrc = $detailImagesByIds[ $basketItem['PRODUCT_ID'] ];
        $basketItem['DETAIL_PICTURE_SRC'] = $imageSrc;
        $basketItem['DISPLAY_PROPERTIES'] = $itemProps[ $basketItem['PRODUCT_ID'] ];
        $order['BASKET_ITEMS'][$basketIndex] = $basketItem;
    }

    $arResult['ORDERS'][$orderIndex] = $order;
}

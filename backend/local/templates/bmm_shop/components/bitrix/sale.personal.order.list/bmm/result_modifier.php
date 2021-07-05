<?php
/** @global array $arResult */

foreach ($arResult['ORDERS'] as $orderIndex => $order) {
    $basketItemIds = array_map(function ($item) {
        return $item['ID'];
    }, $order['BASKET_ITEMS']);

    $detailImagesByIds = [];
    $fullItemsQuery = CIBlockElement::GetList(false, ['ID' => $basketItemIds]);
    while ($item = $fullItemsQuery->GetNextElement()) {
        $fields = $item->GetFields();
        $detailImagesByIds[$fields['ID'] ] = CFile::GetPath($fields["DETAIL_PICTURE"]);
    }

    foreach ($order['BASKET_ITEMS'] as $basketIndex => $basketItem) {
        $imageSrc = $detailImagesByIds[$basketItem['ID'] ];
        $basketItem['DETAIL_PICTURE_SRC'] = $imageSrc;
        $order['BASKET_ITEMS'][$basketIndex] = $basketItem;
    }

    $arResult['ORDERS'][$orderIndex] = $order;
}

<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Iblock\Component\Tools;

/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */

if(!$USER->IsAuthorized()) {
    $favoriteIds = unserialize($APPLICATION->get_cookie("favorites"));
}
else {
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
    $favoriteIds = $arUser['UF_FAVORITES'];
}

if (!$favoriteIds) {
    $favoriteIds = [];
}

$hasFavorites = count($favoriteIds) > 0;

$arResult['FAVORITE_IDS'] = $favoriteIds;
$arResult['FAVORITES_COUNT'] = count($favoriteIds);
$arResult['HAS_FAVORITES'] = $hasFavorites;

if ($arParams['LOAD_DETAILS'] === 'Y' && $hasFavorites) {
    $priceFieldName = 'PRICE_'.$arParams['PRICE_ID'];

    $queryResult = CIBlockElement::GetList(
        ["SORT" => $favoriteIds],
        ["ID" => $favoriteIds],
        false,
        false,
        ['ID', 'IBLOCK_ID', '*', 'PROPERTY_*', $priceFieldName, 'QUANTITY', 'AVAILABLE']
    );
    $favoriteElements = [];
    while ($favoriteElement = $queryResult->GetNextElement()) {
        $elementFields = $favoriteElement->GetFields();

        Tools::getFieldImageData(
            $elementFields,
            array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
            Tools::IPROPERTY_ENTITY_ELEMENT,
            'IPROPERTY_VALUES'
        );

        $elementFields['PRICE'] = str_replace('.00', '', $elementFields[$priceFieldName]);
        $elementFields['DISPLAY_PROPERTIES'] = $favoriteElement->GetProperties();
        $favoriteElements[] = $elementFields;
    }

    $arResult['FAVORITES'] = $favoriteElements;
}
else {
    $arResult['FAVORITES'] = [];
}

$this->IncludeComponentTemplate();
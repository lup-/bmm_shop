<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
require_once $_SERVER['DOCUMENT_ROOT'].'/local/helper/cyrillic_urls.php';

/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

$elementIterator = CIBlockElement::getList([], [
    "IBLOCK_ID" => $arParams['IBLOCK_ID'],
    "NAME" => $arParams['ELEMENT_NAME'],
]);

$element = $elementIterator->Fetch();
if (!$element) {
    $dbElement = new CIBlockElement;
    $urlCode = encodePart($arParams['ELEMENT_NAME'], false, true);

    $newPublisherId = $dbElement->Add([
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "IBLOCK_SECTION_ID" => $arParams['IBLOCK_SECTION_ID'],
        "NAME" => $arParams['ELEMENT_NAME'],
        "CODE" => $urlCode,
        "ACTIVE" => "N"
    ]);

    if ($newPublisherId) {
        $element = CIBlockElement::GetByID($newPublisherId)->Fetch();
    }
}

$url = $arParams['URL_TEMPLATE'];
foreach ($element as $field => $value) {
    $url = str_replace("#${field}#", $value, $url);
}

$arResult['URL'] = $url;
$arResult['ELEMENT'] = $element;

$this->IncludeComponentTemplate();
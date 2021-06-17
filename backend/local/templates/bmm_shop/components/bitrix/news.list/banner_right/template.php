<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="header-content__wrap">
    <div class="header-content__block best">
        <h1><?=$arResult["ITEMS"][0]["NAME"]?></h1>
        <h2><?= $arResult["ITEMS"][0]["PREVIEW_TEXT"] ?></h2>
        <div class="flex-fill"></div>
        <a href="<?=$arResult["ITEMS"][0]["PROPERTIES"]["PAGE_LINK"]["VALUE"]?>"><?=$arResult["ITEMS"][0]["PROPERTIES"]["BUTTON_TEXT"]["VALUE"] ? $arResult["ITEMS"][0]["PROPERTIES"]["BUTTON_TEXT"]["VALUE"] : "Перейти"?></a>

    </div>
    <div class="header-content__block bestsellers">
        <h1><?=$arResult["ITEMS"][1]["NAME"]?></h1>
        <h2><?= $arResult["ITEMS"][1]["PREVIEW_TEXT"] ?></h2>
        <div class="flex-fill"></div>
        <a href="<?=$arResult["ITEMS"][1]["PROPERTIES"]["PAGE_LINK"]["VALUE"]?>"><?=$arResult["ITEMS"][1]["PROPERTIES"]["BUTTON_TEXT"]["VALUE"] ? $arResult["ITEMS"][1]["PROPERTIES"]["BUTTON_TEXT"]["VALUE"] : "Перейти"?></a>

    </div>
</div>


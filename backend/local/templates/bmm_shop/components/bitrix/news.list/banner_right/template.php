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
        <div class="flex-fill"></div>
        <a href="#">Перейти</a>
    </div>
    <div class="header-content__block bestsellers">
        <h1><?=$arResult["ITEMS"][1]["NAME"]?></h1>
        <div class="flex-fill"></div>
        <a href="#">Перейти</a>
    </div>
</div>


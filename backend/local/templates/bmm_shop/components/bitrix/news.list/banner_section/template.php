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
<div class="catalog__main_banners row">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <div class="catalog__main_banner col-12 col-md-6 col-lg-3">
            <h1><?= $arItem["NAME"] ?></h1>
        </div>
    <? endforeach; ?>
</div>
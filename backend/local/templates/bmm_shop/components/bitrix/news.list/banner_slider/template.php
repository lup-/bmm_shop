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
<div class="swiper-container header-banners__slider">
    <div class="swiper-wrapper">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
          ?>
            <div class="swiper-slide header-banners__banner_left">
                <h1><?= $arItem["NAME"] ?></h1>
                <h2><?= $arItem["PREVIEW_TEXT"] ?></h2>
                <div class="flex-fill"></div>
                <a href="<?=$arItem["PROPERTIES"]["PAGE_LINK"]["VALUE"]?>"><?=$arItem["PROPERTIES"]["BUTTON_TEXT"]["VALUE"] ? $arItem["PROPERTIES"]["BUTTON_TEXT"]["VALUE"] : "Перейти"?></a>
            </div>
        <? endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>

<script>
    jQuery(document).ready(function () {
        var swiper = new Swiper(".header-banners__slider", {
            slidesPerView: 1,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
        });
    });
</script>


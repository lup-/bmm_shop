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
            <div class="swiper-slide header-banners__banner_left">
                <h1><?= $arItem["NAME"] ?></h1>
                <h2>С 12 — 27 мая скидка до 25%</h2>
                <div class="flex-fill"></div>
                <a href="#">Перейти</a>
            </div>
        <? endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>

<script>
	var swiper = new Swiper(".header-banners__slider", {
	pagination: {
		el: ".swiper-pagination",
        clickable: true
	},
	});
</script>
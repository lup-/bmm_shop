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
<div class="content__publishers">
    <a id="publishers"></a><div class="content__publishers_title">Наши издательства:</div>
    <div class="swiper-container content__publishers_swiper">
        <div class="swiper-wrapper">
            <?foreach ($arResult["ITEMS"] as $item):?>
            <div class="swiper-slide content__publishers_publisher">
                <a href="/publisher/<?=$item['ID']?>_<?=$item["CODE"]?>/"><img src="<?=$item["PREVIEW_PICTURE"]["SRC"]?>" alt=""></a>
            </div>
            <?endforeach;?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

</div>


<script>
    var swiper = new Swiper(".content__publishers_swiper", {
        slidesPerView: 3,
        breakpoints: {
            576: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 5,
            },
            992: {
                slidesPerView: 7,
            },
            1200: {
                slidesPerView: 9,
            },
            1400: {
                slidesPerView: 11,
            }
        },
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
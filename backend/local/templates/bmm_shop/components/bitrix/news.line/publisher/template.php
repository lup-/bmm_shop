<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require $_SERVER['DOCUMENT_ROOT'].'/local/helper/cyrillic_urls.php';

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
    <div class="content__publishers_title">Наши издательства:</div>
    <div class="swiper-container content__publishers_swiper">
        <div class="swiper-wrapper">
            <?foreach ($arResult["ITEMS"] as $item):?>
            <div class="swiper-slide content__publishers_publisher">
                <a href="<?=encodeCyrillicUrl('/publisher/'.$item["NAME"].'/', false)?>"><img src="<?=$item["PREVIEW_PICTURE"]["SRC"]?>" alt=""></a>
            </div>
            <?endforeach;?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

</div>


<script>
    var swiper = new Swiper(".content__publishers_swiper", {
        slidesPerView: 4,
        breakpoints: {
            576: {
                slidesPerView: 4,
            },
            768: {
                slidesPerView: 6,
            },
            992: {
                slidesPerView: 8,
            },
            1200: {
                slidesPerView: 10,
            },
            1400: {
                slidesPerView: 12,
            }
        },
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
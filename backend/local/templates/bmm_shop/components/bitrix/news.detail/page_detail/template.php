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
$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';
CUtil::InitJSCore(array('fx', 'jquery'));
?>
<div class="row news-text">
    <div class="mb-3" id="<?echo $this->GetEditAreaId($arResult['ID'])?>"></div>
    <div class="col-12 col-md-8">
        <div class="row navigation-row">
            <div class="col-12">
                <a href="javascript:history.back()" class="navigation-row__back">
                    <img src="/images/menu-arrow-back-mobile.svg"> Назад
                </a>
            </div>
        </div>
        <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
            <h1 class="news-text_title"><?=$arResult["NAME"]?></h1>
        <?endif;?>

        <div class="news-text__date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>

        <?if($arResult["DETAIL_PICTURE"]["SRC"]):?>
            <img class="news-text__image d-sm-none" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>">
        <?endif;?>
        <div class="news-text__text"><?=$arResult["DETAIL_TEXT"]?> </div>
    </div>

    <div class="col-12 col-md-4 d-none d-sm-flex">
        <?if($arResult["DETAIL_PICTURE"]["SRC"]):?>
        <img class="news-text__image" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>">
        <?endif;?>
    </div>
</div>
<script type="text/javascript">
	BX.ready(function() {
		var slider = new JCNewsSlider('<?=CUtil::JSEscape($this->GetEditAreaId($arResult['ID']));?>', {
			imagesContainerClassName: 'news-detail-slider-container',
			leftArrowClassName: 'news-detail-slider-arrow-container-left',
			rightArrowClassName: 'news-detail-slider-arrow-container-right',
			controlContainerClassName: 'news-detail-slider-control'
		});
	});
</script>

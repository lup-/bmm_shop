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
<section class="info-block">
    <?if ($arParams["LINK_TO_PAGE"]):?>
        <div class="info-block__title"><a href="<?=$arParams['LINK_TO_PAGE']?>"><?=$arParams["PAGER_TITLE"]?></a></div>
    <?else:?>
        <div class="info-block__title"><?=$arParams["PAGER_TITLE"]?></div>
    <?endif?>
    <div class="info-block__items">
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        if(isset($arItem['PREVIEW_PICTURE']["SRC"])){
            $class = 'image';
            $hasImage = true;
            $image = $arItem['PREVIEW_PICTURE']["SRC"];

        } else {
            $hasImage = false;
            $class = 'info';
        }

        if($arItem['PROPERTIES']['LINK']['VALUE']){
            $isInstagramNews = true;
            $link = $arItem['PROPERTIES']['LINK']['VALUE'];

        } else {
            $isInstagramNews = false;
            $link = $arItem["DETAIL_PAGE_URL"];
        }
        ?>
        <a href="<?=$link?>" class="info-block__item <?=$class?>" style="<?if($hasImage):?>background-image: url(<?=$image?>) <?endif;?>">
            <?if(!$isInstagramNews):?>
                <div class="title"><?echo $arItem["NAME"]?></div>
                <div class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
            <?endif;?>
        </a>
    <?endforeach;?>
</div>
</section>


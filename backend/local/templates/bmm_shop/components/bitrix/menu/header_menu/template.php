<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="header__container d-none d-sm-block">
    <ul class="header__container_tabs">
    <?foreach($arResult as $arItem):?>
        <li class="<?=$arItem["SELECTED"] ? 'header__container_tab_active' : ''?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
    <?endforeach?>
    </ul>
</div>
<?endif?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="dropdown dropdown__navigation d-sm-none">
    <button class="btn btn-text dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?foreach($arResult as $arItem):?>
            <?if ($arItem["SELECTED"]):?>
                <?=$arItem["TEXT"]?>
            <?endif;?>
        <?endforeach;?>
    </button>
    <div class="dropdown-menu">
    <?foreach($arResult as $arItem):?>
        <a class="dropdown-item" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
    <?endforeach;?>
    </div>
</div>
<?endif?>

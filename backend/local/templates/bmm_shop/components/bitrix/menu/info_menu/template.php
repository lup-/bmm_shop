<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <ol class="sidebar-list">
        <?foreach($arResult as $arItem):
            if( $arItem["DEPTH_LEVEL"] > 1)
                continue;
        ?>
            <li class="sidebar-list__item">
                <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
            </li>
        <?endforeach;?>
    </ol>
<?endif?>
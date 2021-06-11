<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <?
    $columnItemsCount = count($arResult)/4 + 1;
    $columnItems = array_chunk($arResult,  $columnItemsCount);
    ?>
    <?foreach ($columnItems as $columns):?>
        <ul class="footer-list">
            <?foreach($columns as $arItem):?>
                <li class="footer-list__item" ><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
            <?endforeach?>
        </ul>
    <?endforeach;?>
<?endif?>


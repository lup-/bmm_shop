<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="footer__links row">
	<?foreach($arResult as $arItem):
		if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
			continue;
	?>
        <div class="footer__links-item col-12 col-sm-6 col-md-4">
            <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
        </div>
	<?endforeach?>
</div>
<?endif?>
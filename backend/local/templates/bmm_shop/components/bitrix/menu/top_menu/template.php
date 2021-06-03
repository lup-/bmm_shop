<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <ul class="navbar-nav mr-auto">
		<?foreach($arResult as $arItem):
			if( $arItem["DEPTH_LEVEL"] > 1)
				continue;
		?>
			<li class="nav-item">
                <a class="nav-link" href="<?=$arItem["LINK"]?>" ><?=$arItem["TEXT"]?></a>
            </li>
		<?endforeach?>
	</ul>
<?endif?>
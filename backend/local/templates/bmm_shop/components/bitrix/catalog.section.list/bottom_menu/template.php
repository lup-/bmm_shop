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

$halved = array_chunk($arResult['SECTIONS'], ceil(count($arResult['SECTIONS'])/2));
foreach($halved as $key => $sect):?>
	<ul class="footer-list">
		<?foreach($sect as $arItem):?>
			<li class="footer-list__item" ><a href="<?=$arItem["SECTION_PAGE_URL"]?>" class="selected"><?=$arItem["NAME"]?></a></li>
		<?endforeach?>
	</ul>
<?endforeach?>

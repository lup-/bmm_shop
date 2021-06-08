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

CJSCore::Init(array("ajax"));
//Let's determine what value to display: rating or average ?
if ($arParams['DISPLAY_AS_RATING'] === 'vote_avg')
{
	if (
		!empty($arResult['PROPERTIES']['vote_count']['VALUE'])
		&& is_numeric($arResult['PROPERTIES']['vote_sum']['VALUE'])
		&& is_numeric($arResult['PROPERTIES']['vote_count']['VALUE'])
	)
	{
		$DISPLAY_VALUE = round($arResult['PROPERTIES']['vote_sum']['VALUE'] / $arResult['PROPERTIES']['vote_count']['VALUE'], 2);
	}
	else
	{
		$DISPLAY_VALUE = 0;
	}
}
else
{
	$DISPLAY_VALUE = $arResult["PROPERTIES"]["rating"]["VALUE"];
}
$voteContainerId = 'vote_'.$arResult["ID"];
/*echo '<pre>';
print_r($component->arParams);
echo '</pre>';*/
?>
<div id="rating_for_product">
    <div class="bx-rating text-primary" id="<?echo $voteContainerId?>">
	<?
	$onclick = "JCFlatVote.do_vote(this, '".$voteContainerId."', ".$arResult["AJAX_PARAMS"].")";
	foreach ($arResult["VOTE_NAMES"] as $i => $name)
	{
		if ($DISPLAY_VALUE && round($DISPLAY_VALUE) > $i)
			$ratingIcon = '<svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.90341 0.245117L11.4683 5.80577L17.5494 6.52678L13.0535 10.6845L14.2469 16.6907L8.90341 13.6997L3.55991 16.6907L4.75334 10.6845L0.257441 6.52678L6.33853 5.80577L8.90341 0.245117Z" fill="#F77211"/></svg>';
		else
			$ratingIcon = '<svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.09091 1.3713L11.2275 6.00334L11.3381 6.2431L11.6003 6.27419L16.6658 6.87479L12.9207 10.3382L12.7269 10.5174L12.7783 10.7764L13.7725 15.7796L9.32131 13.2881L9.09091 13.1591L8.86051 13.2881L4.40936 15.7796L5.4035 10.7764L5.45496 10.5174L5.2611 10.3382L1.51601 6.87479L6.58157 6.27419L6.84377 6.2431L6.95436 6.00334L9.09091 1.3713Z"fill="white" stroke="#F77211" stroke-width="0.943396"/></svg>';

		$itemContainerId = $voteContainerId.'_'.$i;
		?><span
			class="bx-rating-icon-container"
			id="<?echo $itemContainerId?>"
			title="<?echo $name?>"
			<?if (!$arResult["VOTED"] && $arParams["READ_ONLY"]!=="Y"):?>
				onmouseover="JCFlatVote.trace_vote(this, true);"
				onmouseout="JCFlatVote.trace_vote(this, false)"
				onclick="<?echo htmlspecialcharsbx($onclick);?>"
			<?endif;?>
		><?echo $ratingIcon?></span><?
	}
	if ($arParams["SHOW_RATING"] == "Y"):?>
		(<?echo $DISPLAY_VALUE?>)
	<?endif;
?>
</div>
</div>
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

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

$ages = [
    '0-3' => ['1+', '2+', '3+'],
    '4-6' => ['4+', '5+', '6+'],
    '7-12' => ['7+', '8+', '9+', '10+', '11+', '12+'],
    '13-16' => ['13+', '14+', '15+', '16+'],
    "18" => ['17+', '18+']
];
?>

<div>
    <div class="catalog-filter__header d-flex d-sm-none">
        <a href="#" class="catalog-filter__close" data-dismiss="modal"></a>
    </div>
    <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" >
        <?foreach($arResult["HIDDEN"] as $arItem):?>
            <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
        <?endforeach;?>
        <div class="catalog-filter__item">
            <?foreach($arResult["ITEMS"] as $key=>$arItem)//цена
            {
                $key = $arItem["ENCODED_ID"];
                if(isset($arItem["PRICE"])):
                    if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                        continue;

                    $step_num = 4;
                    $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                    $prices = array();
                    if (Bitrix\Main\Loader::includeModule("currency"))
                    {
                        for ($i = 0; $i < $step_num; $i++)
                        {
                            $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                        }
                        $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                    }
                    else
                    {
                        $precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
                        for ($i = 0; $i < $step_num; $i++)
                        {
                            $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
                        }
                        $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                    }
                    ?>
                    <h6>
                        <span class="">ЦЕНА</span>
                    </h6>

                    <div class="bx-filter <?=$templateData["TEMPLATE_CLASS"]?>" disabled="none" >
                <div class="bx-filter-parameters-box bx-active">

                    <div class="bx-filter-block form-group collapse" data-role="bx_filter_block">
                        <div class="row bx-filter-parameters-box-container">
                            <div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
                                <div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
                                    <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
                                    <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
                                    <div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
                                    <div class="bx-ui-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
                                        <a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
                                        <a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="price-value col-6">
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                        id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                        value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                        placeholder="от <?echo $arItem["VALUES"]["MIN"]["VALUE"]?>"
                                        onkeyup="smartFilter.keyup(this)"
                                    />
                                </div>
                                <div class="price-value col-6">
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                        id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                        value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                        placeholder="до <?echo $arItem["VALUES"]["MAX"]["VALUE"]?>"
                                        onkeyup="smartFilter.keyup(this)"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?
                $arJsParams = array(
                    "leftSlider" => 'left_slider_'.$key,
                    "rightSlider" => 'right_slider_'.$key,
                    "tracker" => "drag_tracker_".$key,
                    "trackerWrap" => "drag_track_".$key,
                    "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                    "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                    "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                    "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                    "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                    "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                    "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
                    "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                    "precision" => $precision,
                    "colorUnavailableActive" => 'colorUnavailableActive_'.$key,
                    "colorAvailableActive" => 'colorAvailableActive_'.$key,
                    "colorAvailableInactive" => 'colorAvailableInactive_'.$key,
                );
                ?>
                    <script type="text/javascript">
                        BX.ready(function(){
                            window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                        });
                    </script>
                <?endif;
            } ?>
            <?foreach($arResult["ITEMS"] as $key=>$arItem) //все остальное
            {
                if(empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
                    continue;

                if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
                    continue;?>

                <?if($arItem["CODE"] == 'AGE') {
                    $recommededAges = [];
                    $arItemValues = $arItem["VALUES"];
                    foreach ($ages as $printAge => $age){
                        foreach($age as $ageValues){
                            if(isset($arItemValues[$ageValues])){
                                $recommededAges[$printAge]["VALUES"][$ageValues] = $arItemValues[$ageValues];
                                $recommededAges[$printAge]["CHECKED"] = $arItemValues[$ageValues]["CHECKED"];
                            }
                        }
                    }?>
                <h6>
                    <span><?=mb_strtoupper($arItem["NAME"])?></span>
                </h6>
                <?foreach($recommededAges as $keyPrint => $printAge): ?>
                    <div class="checkbox">
                        <div class="form-check">
                            <label for="<?=$keyPrint?>" id="<?=$keyPrint?>" class="form-check-label">
                                <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="<?=$keyPrint?>"
                                        id="<?=$keyPrint?>"
                                    <? echo $printAge["CHECKED"]? 'checked': '' ?>
                                        onclick="smartFilter.checkAge(this)"
                                /> <span><?=$keyPrint?></span>
                            </label>
                            <div class="form-group collapse" style="border: 1px solid" id="checkbox-<?=$keyPrint?>">
                                <?foreach ($printAge["VALUES"] as $val => $ar):?>
                                    <div class="checkbox">
                                        <label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
                                            <input
                                                    style=""
                                                    type="checkbox"
                                                    name="<?=$ar["CONTROL_NAME"]?>"
                                                    id="<?=$ar["CONTROL_ID"]?>"
                                                    value="<?=$ar["HTML_VALUE"]?>"
                                                <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                            />
                                            <?=$val?>
                                        </label>
                                    </div>
                                <?endforeach?>
                            </div>
                        </div>
                    </div>
                <? endforeach;?>
                <?} else { ?>
                <h6>
                    <span><?=mb_strtoupper($arItem["NAME"])?></span>
                </h6>
                <?
                    $totalCheckboxes = count($arItem["VALUES"]);
                    $checkboxIndex = 0;
                    $maxCheckboxes = 7;
                    $showCollapse = $totalCheckboxes > $maxCheckboxes;
                    $collapseCode = "collapse".$arItem["CODE"];
                ?>
                <?foreach($arItem["VALUES"] as $val => $ar):?>
                    <?if ($showCollapse && $checkboxIndex === $maxCheckboxes):?>
                        <a class="catalog-filter__show_more" data-toggle="collapse" href="#<?=$collapseCode?>" aria-expanded="false">Показать все</a>
                        <script>
                            jQuery('[href="#<?=$collapseCode?>"]').on('click', function () {
                                jQuery(this).hide();
                            });
                        </script>
                        <div class="collapse" id="<?=$collapseCode?>">
                    <?endif?>
                    <div class="checkbox">
                        <div class="form-check">
                            <label data-role="label_<?=$ar["CONTROL_ID"]?>" class="form-check-label" for="<? echo $ar["CONTROL_ID"] ?>">
                                <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                    <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                        onclick="smartFilter.click(this)"
                                />
                                <?=$ar["VALUE"];?>
                            </label>
                        </div>
                    </div>
                    <?if ($showCollapse && $checkboxIndex === $totalCheckboxes-1):?>
                        </div>
                    <?endif?>
                    <?$checkboxIndex++?>
                <?endforeach;?>
                <? }?>
            <?}?>

        </div>
        <div class="row d-none">
            <div class="col-xs-12 bx-filter-button-box">
                <div class="bx-filter-block">
                    <div class="bx-filter-parameters-box-container">
                        <input
                            class="btn btn-themes"
                            type="submit"
                            id="set_filter"
                            name="set_filter"
                            value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
                        />
                        <input
                            class="btn btn-link"
                            type="submit"
                            id="del_filter"
                            name="del_filter"
                            value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
                        />
                        <div class="bx-filter-popup-result <?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
                            <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
                            <span class="arrow"></span>
                            <br/>
                            <a href="<?echo $arResult["FILTER_URL"]?>" target=""><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clb"></div>
    </form>
</div>

<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>

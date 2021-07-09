<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

if (isset($arResult['ITEM']))
{
	$item = $arResult['ITEM'];
	$areaId = $arResult['AREA_ID'];
	$itemIds = array(
		'ID' => $areaId,
		'PICT' => $areaId.'_pict',
		'SECOND_PICT' => $areaId.'_secondpict',
		'PICT_SLIDER' => $areaId.'_pict_slider',
		'STICKER_ID' => $areaId.'_sticker',
		'SECOND_STICKER_ID' => $areaId.'_secondsticker',
		'QUANTITY' => $areaId.'_quantity',
		'QUANTITY_DOWN' => $areaId.'_quant_down',
		'QUANTITY_UP' => $areaId.'_quant_up',
		'QUANTITY_MEASURE' => $areaId.'_quant_measure',
		'QUANTITY_LIMIT' => $areaId.'_quant_limit',
		'BUY_LINK' => $areaId.'_buy_link',
		'BASKET_ACTIONS' => $areaId.'_basket_actions',
		'NOT_AVAILABLE_MESS' => $areaId.'_not_avail',
		'SUBSCRIBE_LINK' => $areaId.'_subscribe',
		'COMPARE_LINK' => $areaId.'_compare_link',
		'PRICE' => $areaId.'_price',
		'PRICE_OLD' => $areaId.'_price_old',
		'PRICE_TOTAL' => $areaId.'_price_total',
		'DSC_PERC' => $areaId.'_dsc_perc',
		'SECOND_DSC_PERC' => $areaId.'_second_dsc_perc',
		'PROP_DIV' => $areaId.'_sku_tree',
		'PROP' => $areaId.'_prop_',
		'DISPLAY_PROP_DIV' => $areaId.'_sku_prop',
		'BASKET_PROP_DIV' => $areaId.'_basket_prop',
        "FAVORITE_ID" => $areaId.'_favorite_item',
	);
	$obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId);
	$isBig = isset($arResult['BIG']) && $arResult['BIG'] === 'Y';

	$productTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $item['NAME'];

	$imgTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $item['NAME'];

	$skuProps = array();

	$haveOffers = !empty($item['OFFERS']);
	if ($haveOffers)
	{
		$actualItem = isset($item['OFFERS'][$item['OFFERS_SELECTED']])
			? $item['OFFERS'][$item['OFFERS_SELECTED']]
			: reset($item['OFFERS']);
	}
	else
	{
		$actualItem = $item;
	}

	if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers)
	{
		$price = $item['ITEM_START_PRICE'];
		$minOffer = $item['OFFERS'][$item['ITEM_START_PRICE_SELECTED']];
		$measureRatio = $minOffer['ITEM_MEASURE_RATIOS'][$minOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
		$morePhoto = $item['MORE_PHOTO'];
	}
	else
	{
		$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
		$measureRatio = $price['MIN_QUANTITY'];
		$morePhoto = $actualItem['MORE_PHOTO'];
	}

	$showSlider = is_array($morePhoto) && count($morePhoto) > 1;
	$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($item['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

	$discountPositionClass = isset($arResult['BIG_DISCOUNT_PERCENT']) && $arResult['BIG_DISCOUNT_PERCENT'] === 'Y'
		? 'product-item-label-big'
		: 'product-item-label-small';
	$discountPositionClass .= $arParams['DISCOUNT_POSITION_CLASS'];

	$labelPositionClass = isset($arResult['BIG_LABEL']) && $arResult['BIG_LABEL'] === 'Y'
		? 'product-item-label-big'
		: 'product-item-label-small';
	$labelPositionClass .= $arParams['LABEL_POSITION_CLASS'];

	$buttonSizeClass = isset($arResult['BIG_BUTTONS']) && $arResult['BIG_BUTTONS'] === 'Y' ? 'btn-md' : 'btn-sm';
	$itemHasDetailUrl = isset($item['DETAIL_PAGE_URL']) && $item['DETAIL_PAGE_URL'] != '';
	?>

	<div class="product-item-container<?=(isset($arResult['SCALABLE']) && $arResult['SCALABLE'] === 'Y' ? ' product-item-scalable-card' : '')?>"
		id="<?=$areaId?>" data-entity="item">
        <div class="news-book__item">
            <?if ($item['LABEL']):?>
                <? if (!empty($item['LABEL_ARRAY_VALUE']))
                {
                    foreach ($item['LABEL_ARRAY_VALUE'] as $code => $value)
                    {
                        list(,$stickerCode) = explode("_",$code);
                        ?>
                        <div class="blot blot__<?=mb_strtolower($stickerCode)?>"></div>
                    <?}
                }
                ?>
            <?endif;?>
            <?if($price['PERCENT'] > 0):?>
                <div class="blot blot__discount"></div>
            <?endif;?>
            <div class="book-img book-image-<?=$arParams['cell']?>">
                <a href="<?=$item["DETAIL_PAGE_URL"] ?>" title="<?= $item["NAME"] ?>"><img src="<?=$item["PREVIEW_PICTURE"]["SRC"] ?>" alt=""></a>
                <span class="book__tags">
                    <?if ($item['LABEL']):?>

                            <? if (!empty($item['LABEL_ARRAY_VALUE']))
                            {
                                foreach ($item['LABEL_ARRAY_VALUE'] as $code => $value)
                                {
                                    list(,$stickerCode) = explode("_",$code);
                                    ?>
                                    <span class="book__tag book__tag_<?=mb_strtolower($stickerCode)?>"><?=$value?></span>
                                <?}
                            }
                            ?>
                    <?endif;?>
                    <?if($price['PERCENT'] > 0):?>
                        <span class="book__tag book__tag_discount">-<?=$price['PERCENT']?>%</span>
                    <?endif;?>
                </span>

            </div>
            <div class="news-book__item_descr">
                <a class="book-name" href="<?=$item["DETAIL_PAGE_URL"] ?>" title="<?= $item["NAME"] ?>"><?= $item["NAME"] ?></a>
                <div class="book-author"><? echo $item['DISPLAY_PROPERTIES']['AUTHOR']['VALUE'];?></div>
                <div class="book-sum">
                    <? if ($price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE'] ): ?>
                        <span class="sum"><s><?= $price["PRINT_RATIO_BASE_PRICE"] ?></s> <?= $price["PRINT_RATIO_PRICE"] ?></span>
                    <? else: ?>
                        <span class="sum"><?= $price["PRINT_RATIO_BASE_PRICE"] ?></span>
                    <? endif; ?>
                </div>
                <div class="book-actions">
                    <div id="<?=$itemIds['BASKET_ACTIONS']?>">
                        <button class="btn btn-transparent btn-cart" id="<?=$itemIds['BUY_LINK']?>">
                            <i class="btn-cart__icon"></i>
                            <span>В корзину</span>
                        </button>
                    </div>
                    <button class="btn btn-transparent btn-fav" id="<?=$itemIds['FAVORITE_ID']?>"  data-item="<?=$item['ID']?>" >
                        <i class="btn-fav__icon"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="modal-<?=$item['ID']?>" class="modal modal-shop fade">
            <div class="modal-backdrop show"></div>
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header">
                        <button id="close-modal-<?=$item['ID']?>" type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="modal-title">Спасибо</h5>
                        Товар успешно добавлен в корзину.
                    </div>
                    <div class="modal-footer">
                        <button id="order-modal-<?=$item['ID']?>" type="button" class="btn btn-success">Оформить заказ</button>
                        <button id="exit-modal-<?=$item['ID']?>" type="button" class="btn btn-text" data-dismiss="modal">Продолжить покупки</button>
                    </div>
                </div>
            </div>
        </div>
        <script>document.body.append(document.getElementById("modal-<?=$item['ID']?>"))</script>
		<?
        $jsParams = array(
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'PRODUCT' => array(
                'ID' => $item['ID'],
                'NAME' => $productTitle,
                'CAN_BUY' => $item['CAN_BUY'],
                'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL']
            ),
            'BASKET' => array(
                'BASKET_URL' => $arParams['~BASKET_URL'],
                'ADD_URL_TEMPLATE' => $arParams['~ADD_URL_TEMPLATE'],
                'BUY_URL_TEMPLATE' => $arParams['~BUY_URL_TEMPLATE']
            ),
            'VISUAL' => array(
                'ID' => $itemIds['ID'],
                'BASKET_ACTIONS_ID' => $itemIds['BASKET_ACTIONS'],
                'FAVORITE_ID' => $itemIds['FAVORITE_ID'],
                'BUY_ID' => $itemIds['BUY_LINK']
            )
        );
		?>
		<script>
          var blockItem = new JCCatalogItem(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
		</script>
	</div>
	<?
	unset($item, $actualItem, $minOffer, $itemIds, $jsParams);
}
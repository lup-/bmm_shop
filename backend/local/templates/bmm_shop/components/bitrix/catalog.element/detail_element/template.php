<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
* @global CMain $APPLICATION
* @var array $arParams
* @var array $arResult
* @var CatalogSectionComponent $component
* @var CBitrixComponentTemplate $this
* @var string $templateName
* @var string $componentPath
* @var string $templateFolder
*/

$this->setFrameMode(true);
/*echo '<pre>';
print_r($arParams['TEMPLATE_THEME']);
echo '</pre>';*/
//переписать
if(!$USER->IsAuthorized()){
    $arFavorites = unserialize($APPLICATION->get_cookie("favorites"));
} else {
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
    $arFavorites = $arUser['UF_FAVORITES'];
}

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link_main',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel',
    'FAVORITE_ID' => $mainId.'_main_favorite',
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}
$actualItem["MORE_PHOTOS"] = [];
if( sizeof( $arResult["PROPERTIES"]["PHOTO"]["VALUE"] ) > 1) {
    $showSliderControls = true;
    foreach($arResult["PROPERTIES"]["PHOTO"]["VALUE"] as $FILE_ID) {
        if( is_array($FILE = CFile::GetFileArray($FILE_ID)) ) {
            array_push($actualItem["MORE_PHOTOS"], $FILE);
        }
    }

    $arResult['MORE_PHOTOS'] = $actualItem["MORE_PHOTOS"];
    $arResult['MORE_PHOTOS_COUNT'] = sizeof( $arResult['MORE_PHOTOS'] );
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$themeClass = (isset($arParams['TEMPLATE_THEME'])  && $arParams['TEMPLATE_THEME'] === 'books')
    ?  $arParams['TEMPLATE_THEME']
    : '';

?>
    <div class="row product product-mobile">
        <div class="col-12 product__description">
            <div class="product__info">
                <div class="product__info_author"><?=$actualItem['PROPERTIES']['AUTHOR']['VALUE'];?></div>
                <div class="product__info_title"><?=$actualItem["NAME"]?></div>
                <div class="product__info_share">
                <span class="product__info_reviews">
                <span class="product__info_rating">
                  <span class="product__info_rating_star"></span>
                  <span class="product__info_rating_star"></span>
                  <span class="product__info_rating_star"></span>
                  <span class="product__info_rating_star"></span>
                </span>
                25 отзывов
              </span>
                </div>
            </div>
            <div class="product__tags">
                <?if ($actualItem['LABEL']):?>
                    <? if (!empty($actualItem['LABEL_ARRAY_VALUE']))
                    {
                        foreach ($actualItem['LABEL_ARRAY_VALUE'] as $code => $value)
                        {
                            list(,$stickerCode) = explode("_",$code);
                            ?>
                            <span class="product__tag product__tag_<?=mb_strtolower($stickerCode)?>"><?=$value?></span>
                        <?}
                    }
                    ?>
                <?endif;?>
                <?if($price['PERCENT'] > 0):?>
                    <span class="product__tag product__tag_discount">-<?=$price['PERCENT']?>%</span>
                <?endif;?>
            </div>
        </div>
    </div>
    <div class="row product" id="<?=$itemIds['ID']?>">
        <div class="col-12 col-lg-4 product__image">
            <?$isBook = $actualItem['IBLOCK_CODE'] === 'books'?>
            <div class="product__image_big <?=($isBook ? '' : 'no-shadow')?>" id="<?=$itemIds["BIG_SLIDER_ID"]?>" data-entity="images-container">
               <img id="big-image" src="<?=$actualItem["DETAIL_PICTURE"]["SRC"] ?>" alt="">
            </div>
            <ul class="product__image_previews" id="more_pictures">
                <?if (!empty($actualItem['MORE_PHOTOS'])): ?>
                    <?foreach ($actualItem['MORE_PHOTOS'] as $key => $photo):?>
                        <li data-entity="slider-control" class="product__image_preview product__image_preview_<?=($key == 0 ? ' active' : '')?> small-image">
                            <img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>">
                        </li>
                    <?endforeach;?>
                <?endif;?>
            </ul>
        </div>
        <div class="col-12 col-lg-8 product__description">
            <div class="product__tags">
                <?if ($actualItem['LABEL']):?>
                    <? if (!empty($actualItem['LABEL_ARRAY_VALUE']))
                    {
                        foreach ($actualItem['LABEL_ARRAY_VALUE'] as $code => $value)
                        {
                            list(,$stickerCode) = explode("_",$code);
                            ?>
                            <span class="product__tag product__tag_<?=mb_strtolower($stickerCode)?>"><?=$value?></span>
                        <?}
                    }
                    ?>
                <?endif;?>
                <?if($price['PERCENT'] > 0):?>
                    <span class="product__tag product__tag_discount">-<?=$price['PERCENT']?>%</span>
                <?endif;?>
            </div>
            <div class="product__info">
                <?if($themeClass === 'books'):?>
                <div class="product__info_author"><?=$actualItem['PROPERTIES']['AUTHOR']['VALUE'];?></div>
                <?endif;?>
                <div class="product__info_title"><?=$actualItem["NAME"]?></div>
                <div class="product__info_top">
                    <div class="product__info_share">
                        <span class="product__info_reviews">
                            <span class="product__info_rating" id="product__info_rating">
                                <?
                                $APPLICATION->IncludeComponent(
                                    'bitrix:iblock.vote',
                                    'rating_item',
                                    array(
                                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                        'ELEMENT_ID' => $arResult['ID'],
                                        'ELEMENT_CODE' => '',
                                        'MAX_VOTE' => '5',
                                        'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
                                        'SET_STATUS_404' => 'N',
                                        "READ_ONLY" => $USER->IsAuthorized() ? "N" : "Y",
                                        'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
                                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                                        "SITE_VERSION" => 'desktop'
                                    ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                );
                                ?>
                            </span>
                            <a href="#reviews" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false">
                                <?=$actualItem['PROPERTIES']['BLOG_COMMENTS_CNT']['VALUE'] >0
                                    ? $actualItem['PROPERTIES']['BLOG_COMMENTS_CNT']['VALUE']
                                    : 0
                                ?> отзывов
                            </a>
                        </span>
                        <button class="btn btn-text btn-fav <?= in_array($actualItem['ID'], $arFavorites) ? 'btn-fav__active' : ''?>" id="<?=$itemIds['FAVORITE_ID']?>" data-item="<?=$actualItem['ID']?>" >
                            <i class="btn-fav__icon"></i>
                            <span>В избранное</span>
                        </button>
                        <button class="btn btn-text btn-share d-none">
                            <i class="btn-share__icon"></i>
                            <span>Поделиться</span>
                        </button>
                    </div>
                    <div class="product__info_prices">
                        <div class="product__info_price" >
                            <? if ($price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE'] ): ?>
                                <s class="product__info_price_sum-discount">
                                    <span class="sum" id="<?=$itemIds["DISCOUNT_PERCENT_ID"]?>"><?= $price["PRINT_RATIO_BASE_PRICE"] ?></span>
                                </s>
                            <? endif; ?>
                            <span class="product__info_price_sum" id="<?=$itemIds['PRICE_ID']?>">
                                <span class="sum"><?= $price["PRINT_RATIO_PRICE"] ?></span>
                              </span>
                            <?if($price['PERCENT'] > 0):?>
                                <span class="product__tag product__tag_discount">-<?=$price['PERCENT']?>%</span>
                            <?endif;?>
                            <div id="<?=$itemIds['BASKET_ACTIONS_ID']?>" style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">
                                <?if ($actualItem['PRODUCT']['QUANTITY'] > 0): ?>
                                    <a class="btn btn-text btn-cart"
                                       id="<?=$itemIds['ADD_BASKET_LINK']?>"
                                       href="javascript:void(0);">
                                        <i class="btn-cart__icon"></i>
                                        <span>В корзину</span>
                                    </a>
                                <?else:?>
                                    <span class="text-muted">Нет в наличии</span>
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__info_bottom">
                    <table class="table table-borderless product__info_features">
                        <tbody>
                        <tr><td></td><td></td></tr>
                        <tr><td>ID товара</td><td><?=$actualItem["ID"]?></td></tr>
                        <?switch ($arParams['TEMPLATE_THEME']) {
                            case 'books':
                                ?>
                                <tr><td>Издательство</td><td><?=$actualItem["PROPERTIES"]["PUBLISHER"]["VALUE"] ? $actualItem["PROPERTIES"]["PUBLISHER"]["VALUE"] : "-" ?></td></tr>
                                <tr><td>Категория</td><td><?=$actualItem["PROPERTIES"]["GENRE"]["VALUE"] ? $actualItem["PROPERTIES"]["GENRE"]["VALUE"] : "-" ?></td></tr>
                                <tr><td>Год издания</td><td><?=$actualItem["PROPERTIES"]["PUB_YEAR"]["VALUE"] ? $actualItem["PROPERTIES"]["PUB_YEAR"]["VALUE"] : "-" ?></td></tr>
                                <tr><td>ISBN</td><td><?=$actualItem["PROPERTIES"]["ISBN"]["VALUE"] ? $actualItem["PROPERTIES"]["ISBN"]["VALUE"] : "-" ?></td></tr>
                                <tr><td>Кол-во страниц</td><td><?=$actualItem["PROPERTIES"]["PAGES"]["VALUE"] ? $actualItem["PROPERTIES"]["PAGES"]["VALUE"] : "-" ?></td></tr>
                                <tr><td>Формат</td><td><?=$actualItem["PROPERTIES"]["DIMENSIONS"]["VALUE"] ? $actualItem["PROPERTIES"]["DIMENSIONS"]["VALUE"] : "-" ?></td></tr>
                                <tr><td>Тип обложки</td><td><?=$actualItem["PROPERTIES"]["COVER"]["VALUE"] ? $actualItem["PROPERTIES"]["COVER"]["VALUE"] : "-" ?></td></tr>
                                <tr><td>Вес, г</td><td><?=$actualItem["PROPERTIES"]["WEIGHT"]["VALUE"] ? $actualItem["PROPERTIES"]["WEIGHT"]["VALUE"] : "-" ?></td></tr>
                               <? break;
                            case 'non-books':?>
                                <tr><td>без понятия какие данные тут нужны</td></tr>

                                <?break;
                            case 'foods':?>
                                <tr><td>без понятия какие данные тут нужны</td></tr>
                                <?break;

                        }?>
                        <tr><td>Возрастные ограничения</td><td><?=$actualItem["PROPERTIES"]["AGE"]["VALUE"] ? $actualItem["PROPERTIES"]["AGE"]["VALUE"] : "-" ?></td></tr>

                        </tbody>
                    </table>
                </div>
                <ul class="nav" id="detailsTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="home" aria-selected="true">
                            Описание
                        </a>
                    </li>
                    <?if($themeClass === 'books'):?>
                    <li class="nav-item">
                        <a class="nav-link" id="smi-tab" data-toggle="tab" href="#smi" role="tab" aria-controls="profile" aria-selected="false">
                            СМИ о книге
                            <span class="nav-link__count">45</span>
                        </a>
                    </li>
                    <?endif;?>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="contact" aria-selected="false">
                            Отзывы
                            <span class="nav-link__count"><?=$actualItem['PROPERTIES']['BLOG_COMMENTS_CNT']['VALUE'] >0
                                    ? $actualItem['PROPERTIES']['BLOG_COMMENTS_CNT']['VALUE']
                                    : ''
                                ?> </span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="detailsTabContent">
                    <div class="tab-pane fade show active product__info_detail-text" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <?=$actualItem["DETAIL_TEXT"]?>
                    </div>
                    <div class="tab-pane fade" id="smi" role="tabpanel" aria-labelledby="smi-tab">
                        ...
                    </div>
                    <div class="tab-pane fade product__info_section product__info_reviews-text" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <?if ($arParams['USE_COMMENTS'] === 'Y') {
							$componentCommentsParams = array(
								'ELEMENT_ID' => $arResult['ID'],
								'ELEMENT_CODE' => '',
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
								'URL_TO_COMMENT' => '',
								'WIDTH' => '',
								'COMMENTS_COUNT' => '',
								'BLOG_USE' => $arParams['BLOG_USE'],
								'FB_USE' => $arParams['FB_USE'],
								'FB_APP_ID' => $arParams['FB_APP_ID'],
								'VK_USE' => $arParams['VK_USE'],
								'VK_API_ID' => $arParams['VK_API_ID'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'BLOG_TITLE' => '',
								'BLOG_URL' => $arParams['BLOG_URL'],
								'PATH_TO_SMILE' => '',
								'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
								'AJAX_POST' => 'Y',
								'SHOW_SPAM' => 'Y',
								'SHOW_RATING' => 'N',
								'FB_TITLE' => '',
								'FB_USER_ADMIN_ID' => '',
								'FB_COLORSCHEME' => 'light',
								'FB_ORDER_BY' => 'reverse_time',
								'VK_TITLE' => '',
								'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                                "VOTE_SESSION" => $arResult["VOTE_SESSION"]
							);
							if(isset($arParams["USER_CONSENT"]))
								$componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
							if(isset($arParams["USER_CONSENT_ID"]))
								$componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
							if(isset($arParams["USER_CONSENT_IS_CHECKED"]))
								$componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
							if(isset($arParams["USER_CONSENT_IS_LOADED"]))
								$componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
							$APPLICATION->IncludeComponent(
								'bitrix:catalog.comments',
								'reviews',
								$componentCommentsParams,
								$component,
								array('HIDE_ICONS' => 'Y')
							);
                        }?>
                    </div>
                </div>
            </div>

        </div>
    </div>

<div class="bx-catalog-element" id="<?=$itemIds['ID']?>" itemscope itemtype="http://schema.org/Product">
	<div class="row">

		<?
		$showOffersBlock = $haveOffers && !empty($arResult['OFFERS_PROP']);
		$mainBlockProperties = array_intersect_key($arResult['DISPLAY_PROPERTIES'], $arParams['MAIN_BLOCK_PROPERTY_CODE']);
		$showPropsBlock = !empty($mainBlockProperties) || $arResult['SHOW_OFFERS_PROPS'];
		$showBlockWithOffersAndProps = $showOffersBlock || $showPropsBlock;
		?>

	</div>

	<meta itemprop="name" content="<?=$name?>" />
	<meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />

	<?
	if ($haveOffers)
	{
		$offerIds = array();
		$offerCodes = array();

		$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

		foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
		{
			$offerIds[] = (int)$jsOffer['ID'];
			$offerCodes[] = $jsOffer['CODE'];

			$fullOffer = $arResult['OFFERS'][$ind];
			$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

			$strAllProps = '';
			$strMainProps = '';
			$strPriceRangesRatio = '';
			$strPriceRanges = '';

			if ($arResult['SHOW_OFFERS_PROPS'])
			{
				if (!empty($jsOffer['DISPLAY_PROPERTIES']))
				{
					foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
					{
						$current = '<li class="product-item-detail-properties-item">
					<span class="product-item-detail-properties-name">'.$property['NAME'].'</span>
					<span class="product-item-detail-properties-dots"></span>
					<span class="product-item-detail-properties-value">'.(
							is_array($property['VALUE'])
								? implode(' / ', $property['VALUE'])
								: $property['VALUE']
							).'</span></li>';
						$strAllProps .= $current;

						if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
						{
							$strMainProps .= $current;
						}
					}

					unset($current);
				}
			}

			if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
			{
				$strPriceRangesRatio = '('.Loc::getMessage(
						'CT_BCE_CATALOG_RATIO_PRICE',
						array('#RATIO#' => ($useRatio
								? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
								: '1'
							).' '.$measureName)
					).')';

				foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
				{
					if ($range['HASH'] !== 'ZERO-INF')
					{
						$itemPrice = false;

						foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
						{
							if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
							{
								break;
							}
						}

						if ($itemPrice)
						{
							$strPriceRanges .= '<dt>'.Loc::getMessage(
									'CT_BCE_CATALOG_RANGE_FROM',
									array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
								).' ';

							if (is_infinite($range['SORT_TO']))
							{
								$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
							}
							else
							{
								$strPriceRanges .= Loc::getMessage(
									'CT_BCE_CATALOG_RANGE_TO',
									array('#TO#' => $range['SORT_TO'].' '.$measureName)
								);
							}

							$strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
						}
					}
				}

				unset($range, $itemPrice);
			}

			$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
			$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
			$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
			$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
		}

		$templateData['OFFER_IDS'] = $offerIds;
		$templateData['OFFER_CODES'] = $offerCodes;
		unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

		$jsParams = array(
			'CONFIG' => array(
				'USE_CATALOG' => $arResult['CATALOG'],
				'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
				'SHOW_PRICE' => true,
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
				'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
				'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
				'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
				'OFFER_GROUP' => $arResult['OFFER_GROUP'],
				'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
				'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
				'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
				'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
				'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
				'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
				'USE_STICKERS' => true,
				'USE_SUBSCRIBE' => $showSubscribe,
				'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
				'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
				'ALT' => $alt,
				'TITLE' => $title,
				'MAGNIFIER_ZOOM_PERCENT' => 200,
				'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
				'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
				'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
					? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
					: null
			),
			'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
			'VISUAL' => $itemIds,
			'DEFAULT_PICTURE' => array(
				'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
				'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
			),
			'PRODUCT' => array(
				'ID' => $arResult['ID'],
				'ACTIVE' => $arResult['ACTIVE'],
				'NAME' => $arResult['~NAME'],
				'CATEGORY' => $arResult['CATEGORY_PATH']
			),
			'BASKET' => array(
				'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'BASKET_URL' => $arParams['BASKET_URL'],
				'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
				'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
				'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
			),
			'OFFERS' => $arResult['JS_OFFERS'],
			'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
			'TREE_PROPS' => $skuProps
		);
	}
	else
	{
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
		{
			?>
			<div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
				<?
				if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
				{
					foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
					{
						?>
						<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
						<?
						unset($arResult['PRODUCT_PROPERTIES'][$propId]);
					}
				}

				$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
				if (!$emptyProductProperties)
				{
					?>
					<table>
						<?
						foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
						{
							?>
							<tr>
								<td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
								<td>
									<?
									if (
										$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
										&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
									)
									{
										foreach ($propInfo['VALUES'] as $valueId => $value)
										{
											?>
											<label>
												<input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
													value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
												<?=$value?>
											</label>
											<br>
											<?
										}
									}
									else
									{
										?>
										<select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
											<?
											foreach ($propInfo['VALUES'] as $valueId => $value)
											{
												?>
												<option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
													<?=$value?>
												</option>
												<?
											}
											?>
										</select>
										<?
									}
									?>
								</td>
							</tr>
							<?
						}
						?>
					</table>
					<?
				}
				?>
			</div>
			<?
		}

		$jsParams = array(
			'CONFIG' => array(
				'USE_CATALOG' => $arResult['CATALOG'],
				'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
				'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
				'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
				'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
				'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
				'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
				'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
				'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
				'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
				'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
				'USE_STICKERS' => true,
				'USE_SUBSCRIBE' => $showSubscribe,
				'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
				'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
				'ALT' => $alt,
				'TITLE' => $title,
				'MAGNIFIER_ZOOM_PERCENT' => 200,
				'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
				'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
				'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
					? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
					: null
			),
			'VISUAL' => $itemIds,
			'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
			'PRODUCT' => array(
				'ID' => $arResult['ID'],
				'ACTIVE' => $arResult['ACTIVE'],
				'PICT' => reset($arResult['MORE_PHOTO']),
				'NAME' => $arResult['~NAME'],
				'SUBSCRIPTION' => true,
				'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
				'ITEM_PRICES' => $arResult['ITEM_PRICES'],
				'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
				'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
				'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
				'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
				'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
				'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
				'SLIDER' => $arResult['MORE_PHOTO'],
				'CAN_BUY' => $arResult['CAN_BUY'],
				'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
				'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
				'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
				'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
				'CATEGORY' => $arResult['CATEGORY_PATH']
			),
			'BASKET' => array(
				'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
				'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
				'EMPTY_PROPS' => $emptyProductProperties,
				'BASKET_URL' => $arParams['BASKET_URL'],
				'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
				'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
			)
		);
		unset($emptyProductProperties);
	}

	if ($arParams['DISPLAY_COMPARE'])
	{
		$jsParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	?>
</div>
<div id="modal-detail-product-<?=$arResult['ID']?>" class="modal modal-shop fade">
    <div class="modal-backdrop show"></div>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <button id="close-modal-product-<?=$arResult['ID']?>" type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title">Спасибо</h5>
                Товар успешно добавлен в корзину.
            </div>
            <div class="modal-footer">
                <button id="order-modal-product-<?=$arResult['ID']?>" type="button" class="btn btn-success">Оформить заказ</button>
                <button id="exit-modal-product-<?=$arResult['ID']?>" type="button" class="btn btn-text" data-dismiss="modal">Продолжить покупки</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-error-product-<?=$arResult['ID']?>" class="modal modal-shop fade">
    <div class="modal-backdrop show"></div>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <button id="close-modal-error-product-<?=$arResult['ID']?>" type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modal-error-text-<?=$arResult['ID']?>">
            </div>
        </div>
    </div>
</div>
<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
		BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
	});

	var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?
unset($actualItem, $itemIds, $jsParams);
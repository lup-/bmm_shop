<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>
<script id="basket-item-template" type="text/html">
    <li class="list-group-item d-flex py-4" id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
        {{#SHOW_RESTORE}}
        <div class="basket-items-list-item-notification" colspan="<?=$restoreColSpan?>">
            <div class="basket-items-list-item-notification-inner basket-items-list-item-notification-removed" id="basket-item-height-aligner-{{ID}}">
                {{#SHOW_LOADING}}
                <div class="basket-items-list-item-overlay"></div>
                {{/SHOW_LOADING}}
                <div class="basket-items-list-item-removed-container">
                    <div>
                        <?=Loc::getMessage('SBB_GOOD_CAP')?> <strong>{{NAME}}</strong> <?=Loc::getMessage('SBB_BASKET_ITEM_DELETED')?>.
                    </div>
                    <div class="basket-items-list-item-removed-block">
                        <a href="javascript:void(0)" data-entity="basket-item-restore-button">
                            <?=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?>
                        </a>
                        <span class="basket-items-list-item-clear-btn" data-entity="basket-item-close-restore-button"></span>
                    </div>
                </div>
            </div>
        </div>
        {{/SHOW_RESTORE}}
        {{^SHOW_RESTORE}}
        <div class="d-flex flex-column w-100">
            <div class="d-flex">
                <div class="form-check basket-items__check">
                    <input class="form-check-input position-static" type="checkbox" value="{{ID}}" data-entity="basket-item-selected">
                </div>

                <div class="basket-items__image mr-3 mr-sm-5">
                    <img src="{{{DETAIL_PICTURE_SRC}}}" data-image-index="{{ID}}" data-column-property-code="{{CODE}}">
                </div>

                <div class="basket-items__info-actions d-flex flex-fill flex-column justify-content-between">
                    <div class="basket-items__info-top d-flex justify-content-between">
                        <div class="d-flex-inline flex-column">
                            <div class="basket-items__info_title">{{{NAME}}}</div>
                            {{#AUTHOR}}
                            <div class="basket-items__info_author">{{{NAME}}}</div>
                            {{/AUTHOR}}
                        </div>
                        <div class="basket-items__price-count d-none d-md-flex">
                            {{#SHOW_DISCOUNT_PRICE}}
								<span id="basket-item-sum-price-old-{{ID}}">

									<s class="basket-items__price-old mr-4">{{{SUM_FULL_PRICE_FORMATED}}}</s>

								</span>
                            {{/SHOW_DISCOUNT_PRICE}}

                            <div class="basket-item-price-current">
                                <div class="d-flex-inline flex-column mr-4">
                                    <div class="basket-items__price" id="basket-item-sum-price-{{ID}}">{{{SUM_PRICE_FORMATED}}}</div>
                                    {{#SHOW_DISCOUNT_PRICE}}
                                    <div class="basket-items__discount">-{{DISCOUNT_PRICE_PERCENT}}%</div>
                                    {{/SHOW_DISCOUNT_PRICE}}
                                </div>
                            </div>
                            <div class="basket-items-list-item-amount">
                                <div class="basket-item-block-amount{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}" data-entity="basket-item-quantity-block">
                                    <span class="basket-item-amount-btn-minus" data-entity="basket-item-quantity-minus"></span>
                                    <div class="basket-item-amount-filed-block">
                                        <input type="text" class="basket-item-amount-filed" value="{{QUANTITY}}"
                                               {{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
                                        data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
                                        id="basket-item-quantity-{{ID}}">
                                        <small class="form-text text-muted" id="basket-item-price-{{ID}}">
                                            {{{PRICE_FORMATED}}}/{{MEASURE_TEXT}}
                                        </small>
                                    </div>
                                    <span class="basket-item-amount-btn-plus" data-entity="basket-item-quantity-plus"></span>

                                    {{#SHOW_LOADING}}
                                    <div class="basket-items-list-item-overlay"></div>
                                    {{/SHOW_LOADING}}
                                </div>
                            </div>

                            <div class="basket-items-list-item-amount d-none" data-entity="basket-item-quantity-block">
                                <span class="basket-item-amount-btn-minus" data-entity="basket-item-quantity-minus"></span>

                                    <input type="text" class="basket-item-amount-filed" value="{{QUANTITY}}"
                                           {{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
                                    data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
                                    id="basket-item-quantity-{{ID}}">

                                <small class="form-text text-muted" id="basket-item-price-{{ID}}">
                                    {{{PRICE_FORMATED}}}/{{MEASURE_TEXT}}
                                </small>
                                <span class="basket-item-amount-btn-plus" data-entity="basket-item-quantity-plus"></span>
                            </div>

                            <div class="basket-items__remove " data-entity="basket-item-delete">
                                <span>×</span>
                                {{#SHOW_LOADING}}
                                <div class="basket-items-list-item-overlay"></div>
                                {{/SHOW_LOADING}}
                            </div>
                        </div>
                        <div class="basket-items_fav d-block d-sm-none">
                            <button class="btn btn-text btn-fav">
                                <i class="btn-fav__icon"></i>
                            </button>
                        </div>
                    </div>
                    <div data-entity="basket-item-favorite-block" class="basket-items__info-bottom d-flex justify-content-between align-items-end flex-column flex-sm-row mt-4">
                        <button  id='basket-item-favorite-span-{{ID}}' class="btn btn-text btn-fav d-none d-sm-inline-flex"
                                data-entity="basket-item-favorite-button"
                        >
                            <i class="btn-fav__icon btn-fav__active"></i>
                            <span id="{{ID}}" >В избранное</span>
                        </button>
                        {{#ISBN}}
                        <div class="basket-items__info_isbn">
                            <p class="mb-0">ISBN {{CODE}}</p>
                        </div>
                        {{/ISBN}}
                    </div>
                </div>
            </div>
            <div class="basket-items__price-count d-flex d-sm-none mt-4 justify-content-end">
                <s class="basket-items__price-old mr-4">1&nbsp;820&nbsp;₽</s>
                <div class="d-flex-inline flex-column mr-4">
                    <div class="basket-items__price">1&nbsp;040&nbsp;₽</div>
                    <div class="basket-items__discount">-15%</div>
                </div>
                <div class="form-group">
                    {{#AVAILABLE_QUANTITY}}
                    <select class="form-control mr-4">
                        {{#SELECT_QUANTITY}}
                        <option value="{{VALUE}}" {{SELECTED}}>{{VALUE}}</option>
                        {{/SELECT_QUANTITY}}
                    </select>
                    {{/AVAILABLE_QUANTITY}}
                    <small class="form-text text-muted">
                        520 ₽/шт.
                    </small>
                </div>
                <div class="basket-items__remove"><a href="#">×</a></div>
            </div>
        </div>
        {{/SHOW_RESTORE}}
    </li>
</script>

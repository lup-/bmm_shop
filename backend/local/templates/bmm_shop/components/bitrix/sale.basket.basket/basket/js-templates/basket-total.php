<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>

<script id="basket-total-template" type="text/html">
    <div class="basket-info card">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                {{#DISCOUNT_PRICE_FORMATED}}
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Общая стоимость
                    <span class="basket-info__value"> {{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Скидка
                    <span class="basket-info__value">{{{DISCOUNT_PRICE_FORMATED}}}</span>
                </li>
                {{/DISCOUNT_PRICE_FORMATED}}
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="d-inline-flex flex-column">
                        <span>Общая стоимость</span>
                        <small>{{#WEIGHT_FORMATED}}
								<?=Loc::getMessage('SBB_WEIGHT')?>: {{{WEIGHT_FORMATED}}}
								{{#SHOW_VAT}}<br>{{/SHOW_VAT}}
							{{/WEIGHT_FORMATED}}
                        </small>
                    </span>
                    <span class="basket-info__value d-inline-flex flex-column text-right" data-entity="basket-total-price">
                        <span>{{{PRICE_FORMATED}}}</span>
                        <small>Без учета доставки</small>
                    </span>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <?if ($arParams['HIDE_COUPON'] !== 'Y'):?>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Промокод" data-entity="basket-coupon-input">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button">Применить</button>
                    </div>
            </div>
            <?endif;?>
        </div>

        <div class="card-body">
            <button class="btn btn-block btn-success{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}" data-entity="basket-checkout-button">Оформить заказ</button>
        </div>
    </div>
</script>

<?

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/style.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $code => $error)
	{
		if ($code !== $component::E_NOT_AUTHORIZED)
			ShowError($error);
	}
	$component = $this->__component;
}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
	if (!count($arResult['ORDERS']))
	{
		if ($_REQUEST["filter_history"] == 'Y')
		{
			if ($_REQUEST["show_canceled"] == 'Y')
			{
				?>
				<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER')?></h3>
				<?
			}
			else
			{
				?>
				<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST')?></h3>
				<?
			}
		}
		else
		{
			?>
			<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST')?></h3>
			<?
		}
	}
	?>

	<?
	if (!count($arResult['ORDERS']))
	{
		?>
		<div class="row">
			<div class="col">
				<a href="<?=htmlspecialcharsbx($arParams['PATH_TO_CATALOG'])?>" class="mr-4"><?=Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG')?></a>
			</div>
		</div>
		<?
	}?>

<div class="order-list">
	<?if ($_REQUEST["filter_history"] !== 'Y')
	{
		$paymentChangeData = array();
		$orderHeaderStatus = null;

		foreach ($arResult['ORDERS'] as $key => $order):?>
            <?
                $statusId = $order['ORDER']['STATUS_ID'];
                $statusTitle = $arResult['INFO']['STATUS'][$statusId]['NAME'];
            ?>
            <div class="order">
                <h3>Заказ №<?=$order['ORDER']['ACCOUNT_NUMBER']?>&nbsp;&mdash;&nbsp;<?=$statusTitle?></h3>
                <div class="row order-items">
                    <div class="col-12 col-lg-8">
                        <ul class="list-group list-group-flush">
                            <?foreach ($order['BASKET_ITEMS'] as $product):?>
                            <?
                                $priceNotTrailZeros = preg_replace("#(00)+$#", "", $product['PRICE']);
                                $priceNotTrailZeros = preg_replace("#\.$#", "", $priceNotTrailZeros);
                            ?>
                            <li class="list-group-item d-flex py-4">
                                <div class="d-flex flex-column w-100">
                                    <div class="d-flex">
                                        <div class="order-items__info_image mr-3 mr-sm-5">
                                            <img src="<?=$product['DETAIL_PICTURE_SRC']?>">
                                        </div>
                                        <div class="order-items__info-actions d-flex flex-fill flex-column justify-content-between">
                                            <div class="order-items__info-top d-flex justify-content-between">
                                                <div class="d-flex-inline flex-column">
                                                    <div class="order-items__info_title"><?=$product['NAME']?></div>
                                                    <div class="order-items__info_author"><?=$product['DISPLAY_PROPERTIES']['AUTHOR']['VALUE']?></div>
                                                </div>
                                                <div class="order-items__price-count d-none d-md-flex">
                                                    <div class="d-flex-inline flex-column">
                                                        <div class="order-items__price text-right"><?=$priceNotTrailZeros?>&nbsp;₽</div>
                                                    </div>
                                                </div>
                                                <div class="order-items_fav d-block d-sm-none">
                                                    <button class="btn btn-text btn-fav">
                                                        <i class="btn-fav__icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="order-items__info-bottom d-flex justify-content-between align-items-end flex-column flex-sm-row mt-4">
                                                <div class="flex-fill"></div>
                                                <div class="order-items__info_isbn">
                                                    <p class="mb-0">ISBN <?=$product['DISPLAY_PROPERTIES']['ISBN']['VALUE']?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-items__price-count d-flex d-sm-none mt-4 justify-content-end">
                                        <div class="d-flex-inline flex-column mr-4">
                                            <div class="order-items__price"><?=$priceNotTrailZeros?>&nbsp;₽</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?endforeach;?>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-4 order-status">
                        <h6 class=""><?=Loc::getMessage('SPOL_TPL_PAYMENT')?></h6>

                        <?foreach ($order['PAYMENT'] as $payment):
                            if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y')
                            {
                                $paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
                                    "order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
                                    "payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
                                    "allow_inner" => $arParams['ALLOW_INNER'],
                                    "refresh_prices" => $arParams['REFRESH_PRICES'],
                                    "path_to_payment" => $arParams['PATH_TO_PAYMENT'],
                                    "only_inner_full" => $arParams['ONLY_INNER_FULL'],
                                    "return_url" => $arResult['RETURN_URL'],
                                );
                            }
                            ?>

                            <div class="sale-order-list-inner-row">
                                <div class="sale-order-list-payment">
                                    <div class="mb-1 sale-order-list-payment-title">
                                        <div class="sale-order-list-payment-status">Статус оплаты</div>
                                        <?if ($payment['PAID'] === 'Y'):?>
                                            <div class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_PAID')?></div>
                                        <?elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N'):?>
                                            <div class="sale-order-list-status-restricted"><?=Loc::getMessage('SPOL_TPL_RESTRICTED_PAID')?></div>
                                        <?else:?>
                                            <div class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTPAID')?></div>
                                        <?endif?>
                                    </div>
                                    <div class="mb-1 sale-order-list-payment-price">
                                        <div class="sale-order-list-payment-element">Стоимость</div>
                                        <div class="sale-order-list-payment-number"><?=$payment['FORMATED_SUM']?></div>
                                    </div>
                                    <? if (!empty($payment['CHECK_DATA']))
                                    {
                                        $listCheckLinks = "";
                                        foreach ($payment['CHECK_DATA'] as $checkInfo)
                                        {
                                            $title = Loc::getMessage('SPOL_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID']))." - ". htmlspecialcharsbx($checkInfo['TYPE_NAME']);
                                            if($checkInfo['LINK'] <> '')
                                            {
                                                $link = $checkInfo['LINK'];
                                                $listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
                                            }
                                        }
                                        if ($listCheckLinks <> '')
                                        {
                                            ?>
                                            <div class="sale-order-list-payment-check">
                                                <div class="sale-order-list-payment-check-left"><?= Loc::getMessage('SPOL_CHECK_TITLE')?>:</div>
                                                <div class="sale-order-list-payment-check-left"><?=$listCheckLinks?></div>
                                            </div>
                                            <?
                                        }
                                    }?>
                                </div>
                                <?
                                if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y' && $payment['ACTION_FILE'] !== 'cash')
                                {
                                    if ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
                                    {
                                        ?>
                                        <div class="sale-order-list-button-container">
                                            <a class="btn btn-primary disabled"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
                                        </div>
                                        <?
                                    }
                                    elseif ($payment['NEW_WINDOW'] === 'Y')
                                    {
                                        ?>
                                        <div class="sale-order-list-button-container">
                                            <a class="btn btn-primary" target="_blank" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
                                        </div>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="sale-order-list-button-container">
                                            <a class="btn btn-primary ajax_reload" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
                                        </div>
                                        <?
                                    }
                                }
                                ?>
                            </div>
                            <?
                        endforeach;
                        if (!empty($order['SHIPMENT'])):?>
                            <h6 class=""><?=Loc::getMessage('SPOL_TPL_DELIVERY')?></h6>
                        <?endif;?>
                        <?foreach ($order['SHIPMENT'] as $shipment):?>
                            <?if (!empty($shipment['DELIVERY_ID'])):?>
                                <div class="sale-order-list-shipment-status">
                                    <div class="sale-order-list-shipment-item"><?=Loc::getMessage('SPOL_TPL_DELIVERY_SERVICE')?></div>
                                    <div class="sale-order-list-shipment-block"><?=$arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME']?></div>
                                </div>
                            <?endif;?>
                            <div class="sale-order-list-shipment-element">
                                <div class="sale-order-list-status-item">Стоимость</div>
                                <div class="sale-order-list-status-block"><?=$shipment['FORMATED_DELIVERY_PRICE']?></div>
                            </div>
                            <div class="sale-order-list-shipment-element">
                                <div class="sale-order-list-status-item">Статус</div>
                                <?
                                if ($shipment['DEDUCTED'] == 'Y')
                                {
                                    ?>
                                    <div class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_LOADED');?></div>
                                    <?
                                }
                                else
                                {
                                    ?>
                                    <div class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTLOADED');?></div>
                                    <?
                                }
                                ?>
                            </div>
                            <div class="sale-order-list-shipment-status">
                                <div class="sale-order-list-shipment-status-item"><?=Loc::getMessage('SPOL_ORDER_SHIPMENT_STATUS');?></div>
                                <div class="sale-order-list-shipment-status-block"><?=htmlspecialcharsbx($shipment['DELIVERY_STATUS_NAME'])?></div>
                            </div>

                            <?if (!empty($shipment['TRACKING_NUMBER'])):?>
                            <div class="sale-order-list-shipment-element">
                                <div class="sale-order-list-shipment-id-name"><?=Loc::getMessage('SPOL_TPL_POSTID')?>:</div>
                                <div class="sale-order-list-shipment-id"><?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></div>
                            </div>
                            <?endif;?>
                            <?if ($shipment['TRACKING_URL'] <> ''):?>
                            <div class="sale-order-list-shipment-button-container">
                                <a class="btn btn-primary" target="_blank" href="<?=$shipment['TRACKING_URL']?>">
                                    <?=Loc::getMessage('SPOL_TPL_CHECK_POSTID')?>
                                </a>
                            </div>
                            <?endif;?>

                        <?endforeach;?>
                        <div class="sale-order-list-inner-row">
                            <a class="btn btn-primary" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>"><?=Loc::getMessage('SPOL_TPL_REPEAT_ORDER')?></a>
                            <?if ($order['ORDER']['CAN_CANCEL'] !== 'N'):?>
                            <a class="btn btn-secondary mt-2" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>"><?=Loc::getMessage('SPOL_TPL_CANCEL_ORDER')?></a>
                            <?endif?>
                        </div>
                    </div>
                </div>
            </div>
		<?endforeach;
	}
	else
	{
		$orderHeaderStatus = null;

		if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS']))
		{
			?>
			<div class="row">
				<div class="col">
					<h2><?= Loc::getMessage('SPOL_TPL_ORDERS_CANCELED_HEADER') ?></h2>
				</div>
			</div>
			<?
		}

		foreach ($arResult['ORDERS'] as $key => $order)
		{
			if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $_REQUEST["show_canceled"] !== 'Y')
			{
				$orderHeaderStatus = $order['ORDER']['STATUS_ID'];
				?>
				<h1 class="sale-order-title">
					<?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?>&raquo;
				</h1>
				<?
			}
			?>
			<div class="row sale-order-list-accomplished-title-container">
				<h3 class="g-font-size-20 mb-1 mt-1 col-sm">
					<?= Loc::getMessage('SPOL_TPL_ORDER') ?>
					<?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') ?>
					<?= htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER'])?>
					<?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
					<span class="text-nowrap"><?= $order['ORDER']['DATE_INSERT'] ?>,</span>
					<?= count($order['BASKET_ITEMS']); ?>
					<?
					$count = mb_substr(count($order['BASKET_ITEMS']), -1);
					if ($count == '1')
					{
						echo Loc::getMessage('SPOL_TPL_GOOD');
					}
					elseif ($count >= '2' || $count <= '4')
					{
						echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
					}
					else
					{
						echo Loc::getMessage('SPOL_TPL_GOODS');
					}
					?>
					<?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
					<span class="text-nowrap"><?= $order['ORDER']['FORMATED_PRICE'] ?></span>
				</h3>
				<div class="col-sm-auto">
					<?
					if ($_REQUEST["show_canceled"] !== 'Y')
					{
						?>
						<span class="sale-order-list-accomplished-date">
									<?= Loc::getMessage('SPOL_TPL_ORDER_FINISHED')?>
								</span>
						<?
					}
					else
					{
						?>
						<span class="sale-order-list-accomplished-date canceled-order">
									<?= Loc::getMessage('SPOL_TPL_ORDER_CANCELED')?>
								</span>
						<?
					}
					?>
					<span class="sale-order-list-accomplished-date"><?= $order['ORDER']['DATE_STATUS_FORMATED'] ?></span>
				</div>
			</div>
			<div class="row mb-5">
				<div class="col pt-3 sale-order-list-inner-container">
					<div class="row pb-3 sale-order-list-inner-row">
						<div class="col-auto col-auto sale-order-list-about-container">
							<a class="g-font-size-15 sale-order-list-about-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>"><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></a>
						</div>
						<div class="col"></div>
						<div class="col-auto sale-order-list-repeat-container">
							<a class="g-font-size-15 sale-order-list-cancel-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>"><?=Loc::getMessage('SPOL_TPL_REPEAT_ORDER')?></a>
						</div>
					</div>
				</div>
			</div>
			<?
		}
	}

	echo $arResult["NAV_STRING"];

	if ($_REQUEST["filter_history"] !== 'Y')
	{
		$javascriptParams = array(
			"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
			"templateFolder" => CUtil::JSEscape($templateFolder),
			"templateName" => $this->__component->GetTemplateName(),
			"paymentList" => $paymentChangeData,
			"returnUrl" => CUtil::JSEscape($arResult["RETURN_URL"]),
		);
		$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
		?>
		<script>
			BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
		</script>
		<?
	}
}
?>
</div>

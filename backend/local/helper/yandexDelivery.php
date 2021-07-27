<?php
use Bitrix\Main\Loader;
use Yandex\Delivery\Admin\OrderList;
use Bitrix\Main;
use Bitrix\Sale;
use Yandex\Delivery;

Loader::IncludeModule("yandex.delivery");

class YandexDelivery extends OrderList
{
    const SERVICE_TYPE_COURIER = 'COURIER';
    const SERVICE_TYPE_PICKUP = 'PICKUP';
    const SERVICE_TYPE_POST = 'POST';
    const CARD_PAYMENT_NAME = 'Оплата банковской картой';
    const COURIER_PAYMENT_NAME = 'Наличные курьеру';

    public function isAllowDeliveryRequest($orderId)
    {
        $isAllowDelivery = false;

        $order = Sale\Order::load($orderId);

        if($order !== null){
            $external = new Delivery\Api\ExternalOrder();
            $externalData = $external->loadByBitrixOrderId($order->getId());
            if(!$externalData){
                $deliveryId = $order->getField("DELIVERY_ID");
                $arDelivery = \Bitrix\Sale\Delivery\Services\Table::getById($deliveryId)->fetch();
                $deliveryType = $arDelivery['CONFIG']['MAIN']['SERVICE_TYPE'];

                $paymentId = $order->getField("PAY_SYSTEM_ID");
                $payment = \Bitrix\Sale\PaySystem\Manager::getById($paymentId);

                if($deliveryType === self::SERVICE_TYPE_COURIER || $deliveryType === self::SERVICE_TYPE_PICKUP || $deliveryType === self::SERVICE_TYPE_POST){
                    if($payment["NAME"] === self::COURIER_PAYMENT_NAME){
                        $isAllowDelivery = true;
                    } else {
                        if($payment["NAME"] === self::CARD_PAYMENT_NAME && $order->isPaid()){
                            $isAllowDelivery = true;
                        }
                    }
                }
            }
        }

        return $isAllowDelivery;
    }

    public function createOrderDraft($orderId)
    {
        define("YANDEX_DELIVERY_CREATE_ORDER", "Y");
        unset($_SESSION['YADELIVERY_ID_DATA_CALCULATE']);

        $order = Sale\Order::load($orderId);

        if (null === $order)
        {
            throw new Main\ArgumentException('orderId');
        }

        $this->setOrder($order);

        $request = new Delivery\Api\Document\Request();

        $deliveryType = '';

        $externalId = $this->getExternalId($order->getField('ACCOUNT_NUMBER'), $order->getId());
        $recipient = $this->getRecipient();

        $contacts = $this->getContacts();

        $comment = $this->getComment();

        $cost = $this->getCost();

        $deliveryOption = [
            "tariffId" => '',
            "delivery" => '',
            "deliveryForCustomer" => '',
            "partnerId" => '',
            "calculatedDeliveryDateMin" => "",
            "calculatedDeliveryDateMax" => "",
        ];

        $places = [
            'externalId' => $externalId,
            //'dimensions' => '',
        ];

        $shipmentInfo = [];
        $collection = $order->getShipmentCollection();

        /** @var \Bitrix\Sale\Shipment $shipment */
        foreach ($collection as $shipment)
        {

            if ($shipment->isSystem())
            {
                continue;
            }

            /** @var Delivery\Service\Profile $profile */

            $profile = $shipment->getDelivery();

            $shipmentExtServices = $shipment->getExtraServices();

            $percent = !$profile->isPartnerPost() ? $profile->getParentHandler()->getAssessedPercent() : 100;

            /** @var Delivery\Data\Shipment\Cost $costDelivery */
            $costDelivery = new Delivery\Data\Shipment\Cost($shipment);

            $costDelivery->setAssessedPercent($percent);

            $deliveryOption['delivery'] = $shipment->getField('BASE_PRICE_DELIVERY');
            $deliveryOption['deliveryForCustomer'] = $shipment->getField('BASE_PRICE_DELIVERY');

            /** @var Delivery\Service\Profile $profile */
            $deliveryType = $profile->getServiceType();

            /** @var Sale\Delivery\ExtraServices\Manager $manager */
            $manager = $profile->getExtraServices();

            $extraServicesList = $manager->getItems();

            /** @var Delivery\ExtraServices\Pickup $extraService */
            if ($extraService = reset($extraServicesList))
            {
                $tableSaveCalc = Delivery\Api\Calculation::getDataClass();

                if ($order->getId() > 0)
                {
                    $resSaveCalc = $tableSaveCalc::getList(['filter' => ['ORDER_ID' => $order->getId()]]);

                    if ($arData = $resSaveCalc->fetch())
                    {
                        $shipmentExtServices = [$arData['ID']];

                    }
                }

                $extraService->setValueJson(reset($shipmentExtServices));
                $extraService->setValue(reset($shipmentExtServices));


                $arShipmentExtraService = $extraService->getCalculation()->getShipment();

                if ($arShipmentExtraService['date'] !== null)
                {
                    $profile->calculate($shipment);

                    $manager = $profile->getExtraServices();
                    $extraServicesList = $manager->getItems();
                    if ($extraService = reset($extraServicesList))
                    {
                        $extraService->setValue(reset($shipmentExtServices));
                    }

                    if ($calculation = $profile->getCalculationOption())
                    {
                        $shipmentInfo['date'] = $calculation->getShipmentDate()[0]['date'];
                        $deliveryOption['calculatedDeliveryDateMin'] = $calculation->getDeliveryDateMin();
                        $deliveryOption['calculatedDeliveryDateMax'] = $calculation->getDeliveryDateMax();

                        $cost['assessedValue'] = $calculation->getAssessedValue();

                        foreach ($calculation->getServices() as $key => $service)
                        {
                            if ($cost['fullyPrepaid'] && $service['code'] === 'CASH_SERVICE')
                            {
                                continue;
                            }
                            $service['cost'] = (float)$service['cost'] . '';
                            $deliveryOption['services'][$key] = $service;
                        }
                    }
                }

                $deliveryOption['tariffId'] = $extraService->getTariffId();
                $deliveryOption['partnerId'] = $extraService->getPartnerId();

                if($currentDeliveryIntervalId = $extraService->getCurrentDeliveryIntervalId())
                {
                    $deliveryOption['deliveryIntervalId']  = $currentDeliveryIntervalId;
                }

                $shipmentInfo['partnerTo'] = $arShipmentExtraService['partner']['id'];
                if ($shipmentInfo['date'])
                {
                    if ($arShipmentExtraService['type'] === $this::TYPE_IMPORT)
                    {
                        $shipmentInfo['warehouseTo'] = $arShipmentExtraService['warehouse']['id'];
                    }

                    $shipmentInfo['warehouseFrom'] = $profile->getParentHandler()->getStoreId();
                }

                $shipmentInfo['type'] = $arShipmentExtraService['type'];
            }

            $dimensions = $profile->getShipmentDimensions($shipment);
            $arItemsDimension = [];

            $weightBitrixUnit = Delivery\Data\Weight::getBitrixUnit();
            $weightServiceUnit = Delivery\Data\Weight::getServiceUnit();
            $sizeBitrixUnit = Delivery\Data\Size::getBitrixUnit();
            $sizeServiceUnit = Delivery\Data\Size::getServiceUnit();

            /** @var Delivery\Data\Shipment\DimensionsItem $dimensionsItem */
            /** @var Sale\BasketItem $basketItem */

            $collectionItems = $shipment->getShipmentItemCollection();

            $arVatProducts = $this->getVatProduct($collectionItems);
            foreach ($collectionItems as $shipmentItem)
            {
                $dimensionsItem = $dimensions->getItem($shipmentItem);

                $basketItem = $shipmentItem->getBasketItem();
                if ($basketItem->isBundleChild())
                {
                    continue;
                }

                $costItem = $costDelivery->getItem($shipmentItem);


                $externalIdItem = $this->getExternalId($this->getArticle($basketItem), $basketItem->getProductId());


                $arItemsDimension[] = [
                    'count' => (float)$basketItem->getQuantity(),
                    'dimensions' => [
                        'weight' => $dimensionsItem->getWeight(),
                        'length' => $dimensionsItem->getLength(),
                        'width' => $dimensionsItem->getWidth(),
                        'height' => $dimensionsItem->getHeight(),
                    ],
                ];
                $arItem = [
                    'externalId' => (string)$externalIdItem,
                    'name' => (string)$basketItem->getField('NAME'),
                    'count' => (float)$basketItem->getQuantity(),
                    'price' => $costItem->getPrice(),
                    'assessedValue' => (float)$costItem->getAssessedPrice() . '',
                    'dimensions' => [
                        'weight' => Delivery\Data\Weight::convertUnit($dimensionsItem->getWeight(), $weightBitrixUnit,
                            $weightServiceUnit),
                        'length' => Delivery\Data\Size::convertUnit($dimensionsItem->getLength(), $sizeBitrixUnit,
                            $sizeServiceUnit),
                        'width' => Delivery\Data\Size::convertUnit($dimensionsItem->getWidth(), $sizeBitrixUnit,
                            $sizeServiceUnit),
                        'height' => Delivery\Data\Size::convertUnit($dimensionsItem->getHeight(), $sizeBitrixUnit,
                            $sizeServiceUnit),
                    ],
                    'tax' => isset($arVatProducts[$basketItem->getProductId()]) ?
                        $arVatProducts[$basketItem->getProductId()]['tax'] : $this::arTax['NO_VAT'],
                ];
                $places['items'][] = $arItem;
            }

            $arAllDimension = $this->getBoxDimension($arItemsDimension);

            if ($arAllDimension)
            {
                $places['dimensions'] = $arAllDimension;
            }
            $address = new Delivery\Data\Shipment\Address($shipment);
            $recipient['address']['geoId'] = $address->getToGeoId();

            $recipient['pickupPointId'] = $extraService->getPickupPointId();

            break;
        }

        $token = Delivery\Api\Token::loadById((string)Delivery\Config::getOption('TOKEN'));

        $request->setOrderId($externalId);
        $request->setComment($comment);
        $request->setDeliveryType($deliveryType);
        $request->setRecipient($recipient);
        $request->setContacts($contacts);
        $request->setCost($cost);
        $request->setPlaces([$places]);
        $request->setSenderId($profile->getParentHandler()->getSenderId());
        $request->setShipment($shipmentInfo);
        $request->setDeliveryOption($deliveryOption);
        $request->setIdDraft(Delivery\Api\ExternalOrder::getIdYandex($order->getId()));

        $request->setToken($token);

        $extOrderId = null;

        if ($result = $request->load())
        {
            if ($result->isSuccess())
            {
                $this->setSuccess(true);

                $extOrderId = (int)$result->getResponse()->getData();

                if ($extOrderId > 1)
                {
                    $this->addMessage(Delivery\Config::getLang('ADMIN_ORDER_LIST_ORDER_STATS_DRAFT_CREATED_MESSAGE', [
                        '#ORDER_ID#' => $order->getField('ACCOUNT_NUMBER'),
                    ]));

                    Delivery\Api\ExternalOrder::changeStatusOrder($order->getId(), $this::STATUS_SEND_DRAFT);
                    Delivery\Api\ExternalOrder::changeIdYandex($order->getId(), $extOrderId);
                }
                else
                {

                    Delivery\Api\ExternalOrder::changeStatusOrder($order->getId(), $this::STATUS_ERROR_SEND_DRAFT);
                    Delivery\Api\ExternalOrder::addError($order->getId(), serialize($result->getResponse()->getData()));

                    throw new Main\SystemException((Delivery\Config::getLang('ADMIN_ORDER_LIST_ORDER_STATS_DRAFT_CREATED_ERROR', [
                        '#ORDER_ID#' => $order->getField('ACCOUNT_NUMBER'),
                        '#ERROR_TYPE#' => $result->getResponse()->getErrorsText(),
                    ])),
                        '999');
                }
            }
            else
            {
                $this->setSuccess(false);

                Delivery\Api\ExternalOrder::addError($order->getId(), $result->getErrorMessages()[0]);
                Delivery\Api\ExternalOrder::changeStatusOrder($order->getId(), $this::STATUS_ERROR_SEND_DRAFT);

                $this->addError($result->getErrorMessages()[0]);
            }
        }

        return $extOrderId;
    }
}

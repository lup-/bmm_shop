<?php
use Bitrix\Sale;
use Bitrix\Main;
use Yandex\Delivery;

class bmmOrder
{
    protected $request;

    public function __construct(Main\HttpRequest $request = null)
    {
        $this->request = $request !== null ? $request : Main\Context::getCurrent()->getRequest();
    }

    public function isAccess()
    {
        $token = $this->request->get('token');

        if(isset($token) && $token === $_ENV['BMM_TOKEN']){
            return true;
        }

       return false;
    }

    public function getList() {
        $queryParams = [];
        $queryParams += $this->initFilter();

        return $this->loadItems($queryParams);
    }

    public function show($orderId = null)
    {
        $orderId = $orderId !== null ? $orderId : $this->request->get('orderId');
        $order = \Bitrix\Sale\Order::load($orderId);
        if ($order === null){
           return [
               'error' => "заказ с таким номером не найден"
           ];
        }

        return $this->getOrderRow($order);
    }

    protected function initFilter(): array
    {
        $result = [];
        $filter = $this->request->get('filter');

        if(isset($filter)) {
            foreach ($filter as $filterCode => $filterValue) {
                switch ($filterCode) {
                    case "from":
                        if($filterValue !== ''){
                            $queryFilter['>='.'DATE_UPDATE'] = $filterValue;
                        }
                        break;
                    case "to":
                        if($filterValue !== '') {
                            $queryFilter['<=' . 'DATE_UPDATE'] = $filterValue;
                        }
                        break;
                    case "id":
                        $queryFilter['>='.'ID'] = $filterValue;
                        break;
                    default:
                        $queryFilter[mb_strtoupper($filterCode)] = $filterValue;
                }
            }
        }

        if (!empty($queryFilter))
        {
            $result['filter'] = $queryFilter;
        }

        return $result;
    }

    protected function loadItems(array $queryParameters = []): array
    {
        $orderCollection = $this->loadOrderCollection($queryParameters);
        $result = [];

        if (is_array($orderCollection) || is_object($orderCollection))
        {
            /** @var \Bitrix\Sale\Order $order */
            foreach ($orderCollection as $order){
                $result['orders'][] = $this->getOrderRow($order);
            }
        }

        return $result;
    }

    protected function loadOrderCollection(array $filterParameters = []): array
    {
        $result = [];
        if (isset($filterParameters['filter']))
        {
            $arFilter = $filterParameters['filter'];
        }
        $arId = [];

        $dbRes = \Bitrix\Sale\Order::getList([
            'select' => [
                "ID",
                'DELIVERY_ID',
            ],
            'filter' => $arFilter ? :[],
            'limit' => false,
            'offset' => false,
            'order' => ['ID' => 'DESC'],
        ]);

        while ($order = $dbRes->fetch())
        {
            $arId[$order['ID']] = $order['ID'];
            $result[] = \Bitrix\Sale\Order::load($order['ID']);
        }

        return $result;
    }

    protected function getOrderRow(\Bitrix\Sale\Order $order): array
     {
        $result = [
            "id" => $order->getId(),
            "account_number" => $order->getField("ACCOUNT_NUMBER"),
            "pay_system_id" => $order->getField("PAY_SYSTEM_ID"),
            "delivery_id" => $order->getField("DELIVERY_ID"),
            "date_insert" => $order->getDateInsert()->toString(),
            "date_update" => $order->getField("DATE_UPDATE")->toString(),
            "user_id" => $order->getUserId(),
            "person_type_id" => $order->getPersonTypeId(),
            "payed" => $order->isPaid(),
            "status_id" => $order->getField("STATUS_ID"),
            "status_text" => $this->getStatus($order->getField("STATUS_ID")),
            "price_delivery" => $order->getDeliveryPrice(),
            "allow_delivery" => $order->isAllowDelivery(),
            "price" => $order->getPrice(),
            "currency" => $order->getCurrency(),
            "discount_value" => $order->getDiscountPrice(),
            "sum_paid" => $order->getSumPaid(),
            "canceled" => $order->isCanceled(),
            "date_canceled" => $order->getField("DATE_CANCELED") ? $order->getField("DATE_CANCELED")->toString() : null,
            "delivery" => $this->getOrderDelivery($order),
            "shipment" => $this->getOrderShipment($order),
            "payment" => $this->getOrderPayment($order),
            "buyer" => $this->getOrderBuyer($order),
            "products" => $this->getOrderBasket($order)
        ];

        return $result;
    }

    protected function getOrderBasket(\Bitrix\Sale\Order $order): array
    {
        $result = [];
        $basket = $order->getBasket();

        $itemCollection = $basket->getOrderableItems();

        if ($itemCollection !== null)
        {
            foreach ($itemCollection as $item)
            {
                $product = CIBlockElement::GetByID($item->getProductId())->Fetch();
                $itemRow = [
                    'id' => $item->getProductId(),
                    'idtow' => $product["CODE"],
                    'name' => $item->getField('NAME'),
                    'price' => $item->getFinalPrice(),
                    'currency' => $item->getField('CURRENCY'),
                    'base_price' => $item->getBasePrice(),
                    'quantity' => $item->getQuantity(),
                    'weight' => $item->getWeight(),
                    'discount_price' => $item->getDiscountPrice()
                ];

                $result[] = $itemRow;
            }
        }

        return $result;
    }

    protected function getOrderDelivery(\Bitrix\Sale\Order $order): array
    {
        $result = [];
        $external = new Delivery\Api\ExternalOrder();
        $externalData = $external->loadByBitrixOrderId($order->getId());

        if(isset($externalData)) {
            $result = [
                'id' => $externalData->getField("ID"),
                'yandex_order_id' => $externalData->getField("YANDEX_ORDER_ID"),
                'bitrix_order_id' => $externalData->getField("BITRIX_ORDER_ID"),
                'yandex_status_code' => $externalData->getField("YANDEX_STATUS_CODE"),
                'yandex_status_text' => $this->getStatus($externalData->getField("YANDEX_STATUS_CODE")),
            ];
        }

        return $result;
    }

    protected function getOrderShipment(\Bitrix\Sale\Order $order): array
    {
        $shipments = Sale\Shipment::loadForOrder($order->getId());
        $result = [];

        foreach ($shipments as $shipment){
            if($shipment->isSystem())
                continue;

            $result[] = [
                "id" => $shipment->getField("ID"),
                "order_id" => $shipment->getField("ORDER_ID"),
                "account_number" => $shipment->getField("ACCOUNT_NUMBER"),
                "status_id" => $shipment->getField("STATUS_ID"),
                "status_text" => $this->getStatus($shipment->getField("STATUS_ID")),
                "base_price_delivery" => $shipment->getField("BASE_PRICE_DELIVERY"),
                "price_delivery" => $shipment->getField("PRICE_DELIVERY"),
                "weight" => $shipment->getWeight(),
                "custom_price_delivery" => $shipment->getField("CUSTOM_PRICE_DELIVERY") === 'Y',
                "currency" => $shipment->getField("CURRENCY"),
                "discount_price" => $shipment->getField("DISCOUNT_PRICE"),
                "allow_delivery" => $shipment->getField("ALLOW_DELIVERY") === "Y",
                "delivery_name" => $shipment->getField("DELIVERY_NAME"),
                "canceled" => $shipment->getField("CANCELED") === "Y",
            ];
        }

        return $result;
    }

    protected function getOrderPayment(\Bitrix\Sale\Order $order): array
    {
        $result = [];
        $paymentCollection = $order->getPaymentCollection();

        foreach ($paymentCollection as $payment) {
            $result[] = [
                "id" => $payment->getField("ID"),
                "order_id" => $payment->getField("ORDER_ID"),
                "account_number" => $payment->getField("ACCOUNT_NUMBER"),
                "paid" => $payment->isPaid(),
                "ps_status" => $payment->getField("PS_STATUS"),
                "ps_status_code" => $payment->getField("PS_STATUS_CODE"),
                "ps_invoice_id" => $payment->getField("PS_INVOICE_ID"),
                "ps_sum" => $payment->getSum(),
                "currency" => $payment->getField("CURRENCY"),
                "pay_system_name" => $payment->getPaymentSystemName(),
                "is_return" => $payment->isReturn(),
            ];
        }

        return $result;
    }

    protected function getOrderBuyer(\Bitrix\Sale\Order $order): array
    {
        $dbRes = \Bitrix\Sale\PropertyValueCollection::getList([
            'select' => ['*'],
            'filter' => [
                '=ORDER_ID' => $order->getId(),
            ]
        ]);

        $result = [];
        while ($item = $dbRes->fetch()) {
            $result[mb_strtolower($item["CODE"])] = $item["VALUE"];
        }

        return $result;
    }

    protected function getStatus($statusId) {
        $statuses = [
            'N' => 'Новый заказ',
            'E' => 'Ошибка',
            'SD' => 'Черновик создан',
            'SDO' => 'Заказ отменен',
            'SO'  => 'Заказ оформлен',
            'ESD' => 'Ошибка при создании черновика',
            'ESO' => 'Ошибка при оформлении заказа',
            'NOS' => 'Нет отгрузки. Нужно рассчитать доставку заново',
            'DN' => 'Ожидает обработки',
            'DF' => 'Отгружен'
        ];

        return $statuses[$statusId] ? :null;
    }
}

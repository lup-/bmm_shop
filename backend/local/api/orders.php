<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require $_SERVER["DOCUMENT_ROOT"]."/local/helper/bmmOrder.php";
use Bitrix\Main\Loader;

Loader::IncludeModule("sale");
Loader::IncludeModule("yandex.delivery");

$order = new bmmOrder();
if($order->isAccess()){
    $items = $order->getList();
    header('Content-Type: application/json');
    echo json_encode($items);
} else {
    header('HTTP/1.1 401 Unauthorized');
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>

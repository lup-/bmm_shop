<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$GLOBALS['APPLICATION']->RestartBuffer();
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
$application = Application::getInstance();
$context = $application->getContext();
/* Избранное */
global $APPLICATION;
if($_GET['id']) {
    $id = $_GET['id'];
    if(!$USER->IsAuthorized()) {
        $arElements = unserialize($APPLICATION->get_cookie('favorites'));
        if(!in_array($id , $arElements)) {
            $arElements[] = $id;
            $status= 1; // Датчик. Добавляем
        } else {
            $key = array_search($id, $arElements); // Находим элемент, который нужно удалить из избранного
            unset($arElements[$key]);
            $status = 2; // Датчик. Удаляем
        }
        $cookie = new Cookie("favorites", serialize($arElements), time() + 60*60*24*60); $cookie->setDomain($context->getServer()->getHttpHost());
        $cookie->setHttpOnly(false);
        $context->getResponse()->addCookie($cookie);
    } else {
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $arUser = $rsUser->Fetch();
        $arElements = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя

        if(!in_array($id , $arElements)) // Если еще нету этой позиции в избранном
        {
            $arElements[] = $id ;
            $status = 1;
        } else {
            $key = array_search($id, $arElements); // Находим элемент, который нужно удалить из избранного
            unset($arElements[$key]);
            $status = 2;
        }
        $USER->Update($idUser, Array("UF_FAVORITES" => $arElements)); // Добавляем элемент в избранное

    }

} else {
    $result = [
        "status" => 'ok'
    ];
}

$result = [
    "status" => $status,
    'count' => $arElements ? count($arElements) : 0
];

echo json_encode($result);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>



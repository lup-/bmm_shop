<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');

$arParamsToDelete = array(
    "login",
    "login_form",
    "logout",
    "register",
    "forgot_password",
    "change_password",
    "confirm_registration",
    "confirm_code",
    "confirm_user_id",
    "logout_butt",
    "auth_service_id",
    "clear_cache",
    "backurl",
);
$currentUrl = urlencode($APPLICATION->GetCurPageParam("", $arParamsToDelete));
$pathToAuthorize = $arParams['PATH_TO_AUTHORIZE'];
$pathToAuthorize .= (mb_stripos($pathToAuthorize, '?') === false ? '?' : '&');
$pathToAuthorize .= 'login=yes&backurl='.$currentUrl;

if(!$USER->IsAuthorized()){
    $arFavorites = unserialize($APPLICATION->get_cookie("favorites"));
} else {
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
    $arFavorites = $arUser['UF_FAVORITES'];
}
?>

<div class="basket-line">
<?if (!$compositeStub && $arParams['SHOW_AUTHOR'] == 'Y'):?>
	<div class="mb-1 basket-line-block">
		<?if ($USER->IsAuthorized()):
			$name = trim($USER->GetFullName());
			if (! $name)
				$name = trim($USER->GetLogin());
			?>
			<a class="basket-line-block-icon-profile" href="<?=$arParams['PATH_TO_PROFILE']?>"><?=htmlspecialcharsbx($name)?></a>
			<a style='margin-right: 0;' href="?logout=yes&<?=bitrix_sessid_get()?>"><?=GetMessage('TSB1_LOGOUT')?></a>
		<?else:
			$arParamsToDelete = array(
				"login",
				"login_form",
				"logout",
				"register",
				"forgot_password",
				"change_password",
				"confirm_registration",
				"confirm_code",
				"confirm_user_id",
				"logout_butt",
				"auth_service_id",
				"clear_cache",
				"backurl",
			);

			$currentUrl = urlencode($APPLICATION->GetCurPageParam("", $arParamsToDelete));
			if ($arParams['AJAX'] == 'N')
			{
				?><script type="text/javascript"><?=$cartId?>.currentUrl = '<?=$currentUrl?>';</script><?
			}
			else
			{
				$currentUrl = '#CURRENT_URL#';
			}

			$pathToAuthorize = $arParams['PATH_TO_AUTHORIZE'];
			$pathToAuthorize .= (mb_stripos($pathToAuthorize, '?') === false ? '?' : '&');
			$pathToAuthorize .= 'login=yes&backurl='.$currentUrl;
			?>
			<a class="basket-line-block-icon-profile" href="<?=$pathToAuthorize?>"><?=GetMessage('TSB1_LOGIN')?></a>
			<?
			if ($arParams['SHOW_REGISTRATION'] === 'Y')
			{
				$pathToRegister = $arParams['PATH_TO_REGISTER'];
				$pathToRegister .= (mb_stripos($pathToRegister, '?') === false ? '?' : '&');
				$pathToRegister .= 'register=yes&backurl='.$currentUrl;
				?>
				<a style="margin-right: 0;" href="<?=$pathToRegister?>"><?=GetMessage('TSB1_REGISTER')?></a>
				<?
			}
			?>
		<?endif?>
	</div>
<?endif?>
    <?
        $basketCountClass = '';
        $basketCount = '';
        if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y')){
            $basketCountClass = "basket__counter";
            $basketCount = $arResult['NUM_PRODUCTS'];
        }
    ?>
    <ul class="navigation__right">
        <li class="nav-item">
            <a class="nav-link favorite" href="/personal/favorite/">
                <span id="favorite-count" class="<?=count($arFavorites) > 0 ? 'favorite__counter': ''?>"><?=count($arFavorites) > 0 ? count($arFavorites) : '' ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link basket" href="<?=$arParams['PATH_TO_BASKET']?>">
                <span class="<?=$basketCountClass?>"><?=$basketCount?></span>
            </a>
        </li>
        <?if(!$USER->IsAuthorized()):?>
        <li class="nav-item d-block d-sm-none">
            <a class="nav-link auth" href="<?=$pathToAuthorize?>"></a>
        </li>
        <?endif;?>
    </ul>
</div>
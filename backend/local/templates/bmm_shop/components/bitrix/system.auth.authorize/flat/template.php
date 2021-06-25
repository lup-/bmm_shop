<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");

?>
<div class="bx-authform">
<div class="modal modal-shop modal-shop__login fade show">
  <div class="modal-backdrop show"></div>
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">
      <div class="modal-header">
        <img src="/images/logo.svg">
          <button type="button"  class="close" data-dismiss="modal" onclick="var popup = BX.PopupWindowManager.getCurrentPopup(); popup.close();"></button>
      </div>
      <div class="modal-body">
        <h5 class="modal-title">Личный кабинет <img class="modal-title__icon" src="/images/bmm_icon.svg"></h5>

        <form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if ($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>
		<div class="form-group">
            <input class="form-control" name="USER_LOGIN" type="text" maxlength="255" placeholder="Логин" value="<?=$arResult["LAST_LOGIN"]?>" />
          </div>
          <div class="form-group">
		  <?if($arResult["SECURE_AUTH"]):?>
				<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none">
				<div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

			<script type="text/javascript">
			document.getElementById('bx_auth_secure').style.display = '';
			</script>
			<?endif?>
            <input class="form-control" name="USER_PASSWORD" maxlength="255" type="password" placeholder="Пароль" autocomplete="off">
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" >
            <label class="form-check-label" for="remember">Запомнить меня</label>
          </div>
          <div class="form-buttons d-flex flex-row mt-4">
            <input type="submit" class="btn btn-success" name="Login" value="Войти" />
            <?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
            <a class="btn btn-text btn-text-success" href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a>
            <?endif?>
          </div>
            <!--a href="#" class="btn btn-text btn_altlogin">Войти через телефон</a-->
            <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
            <a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="btn btn-text btn_altlogin" rel="nofollow">Восстановление пароля</a>
            <?endif?>
        </form>
      </div>
	  <?if($arResult["AUTH_SERVICES"]):?>
<?/*
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form",
	"flat",
	array(
		"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
		"AUTH_URL" => $arResult["AUTH_URL"],
		"POST" => $arResult["POST"],
	),
	$component,
	array("HIDE_ICONS"=>"Y")
);*/
?>
<?endif?>
      <div class="modal-footer">
        <hr class="modal-separator">
        <h6 class="">Войти через соцсети</h6>
        <div class="soclogin_list">
          <a href="#"><img class="soclogin_list__icon" src="/images/auth/facebook.svg"></img> Facebook</a>
          <a href="#"><img class="soclogin_list__icon" src="/images/auth/vk.svg"></img> ВКонтакте</a>
          <a href="#"><img class="soclogin_list__icon" src="/images/auth/google.svg"></img> Google</a>
          <a href="#"><img class="soclogin_list__icon" src="/images/auth/apple.svg"></img> Apple</a>
          <a href="#"><img class="soclogin_list__icon" src="/images/auth/instagram.svg"></img> Instagram</a>
        </div>
      </div>
	  <?if(!empty($arParams["~AUTH_RESULT"])):
			$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
		?>
			<div class="modal-info modal-info__error"><?=nl2br(htmlspecialcharsbx($text))?></div>
		<?endif?>
		<?if($arResult['ERROR_MESSAGE'] <> ''):
			$text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);
		?>
		<div class="modal-info modal-info__error"><?=nl2br(htmlspecialcharsbx($text))?></div>
		<?endif?>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
<?if ($arResult["LAST_LOGIN"] <> ''):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>


<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init(['phone_auth', 'jquery']);
}

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>
<div class="bx-authform">
<noindex>
    <div class="modal modal-shop modal-shop__login fade show">
        <div class="modal-backdrop show"></div>

  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <img src="/images/logo.svg">
        <button type="button"  class="close" data-dismiss="modal" onclick="var popup = BX.PopupWindowManager.getCurrentPopup(); popup.close();"></button>
      </div>
      <div class="modal-body">
        <h5 class="modal-title">Регистрация<img class="modal-title__icon" src="/images/bmm_icon.svg"></h5>
        <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="regform">
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="REGISTRATION" />
          <div class="form-group">
            <input id='req-login' class="form-control" type="hidden" name="USER_LOGIN" value="<?=$arResult["USER_LOGIN"]?>">
            <input id='reg-email' class="form-control" name="USER_EMAIL" maxlength="255"  type="text" value="<?=$arResult["USER_EMAIL"]?>" placeholder="Электронная почта" onkeyup="">

          </div>
          <div class="form-group">
			<?if($arResult["SECURE_AUTH"]):?>
				<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

				<script type="text/javascript">
				document.getElementById('bx_auth_secure').style.display = '';
				</script>
			<?endif?>
            <input class="form-control" type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" placeholder="Пароль">
          </div>
		  <div class="form-group">
			<?if($arResult["SECURE_AUTH"]):?>
				<div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

				<script type="text/javascript">
					document.getElementById('bx_auth_secure_conf').style.display = '';
				</script>
			<?endif?>
				<input class="form-control" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" placeholder="Подтверждение пароля"/>
		  </div>
		  <input type="submit" class="btn btn-success mt-4 d-block" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" />
        </form>
      </div>
        <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
            <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>

                <div class="bx-authform-formgroup-container">
                    <div class="bx-authform-label-container"><?if ($arUserField["MANDATORY"]=="Y"):?><span class="bx-authform-starrequired">*</span><?endif?><?=$arUserField["EDIT_FORM_LABEL"]?></div>
                    <div class="bx-authform-input-container">
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:system.field.edit",
                            $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                            array(
                                "bVarsFromForm" => $arResult["bVarsFromForm"],
                                "arUserField" => $arUserField,
                                "form_name" => "bform"
                            ),
                            null,
                            array("HIDE_ICONS"=>"Y")
                        );
                        ?>
                    </div>
                </div>

            <?endforeach;?>
        <?endif;?>
	  <?if(!empty($arParams["~AUTH_RESULT"])):
		$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
		?>
			<div class="modal-info  <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"modal-info__error")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
		<?endif?>
    </div>
  </div>
</div>
    <script>

    </script>
<script type="text/javascript">
    console.log(document);
	//document.regform.USER_NAME.focus();
</script>
</noindex>
</div>

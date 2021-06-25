<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
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
                <button type="button"  class="close" data-dismiss="modal" onclick="var popup = BX.PopupWindowManager.getCurrentPopup(); popup.close();"></button>            </div>
            <div class="modal-body">
                <h5 class="modal-title">Восстановление пароля <img class="modal-title__icon" src="/images/bmm_icon.svg"></h5>

                <?if(empty($arParams["~AUTH_RESULT"]) || $arParams["~AUTH_RESULT"]["TYPE"] != "OK")?>

                <h6>На эелектронную почту будет отправлено письмо с ссылкой для восстановления пароля </h6>

                <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                    <?if($arResult["BACKURL"] <> ''):?>
                        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                    <?endif?>
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="SEND_PWD">

                    <div class="form-group">
                        <input class="form-control" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" />
                        <input type="hidden" name="USER_EMAIL" />
                    </div>
                    <input type="submit" class="btn btn-success mt-4 d-block" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
                </form>
            </div>
            <?if(!empty($arParams["~AUTH_RESULT"])):
                $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
            ?>
            <div class="modal-info <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"modal-info__error")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
            <?endif?>
            <e
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
document.bform.USER_LOGIN.focus();
</script>

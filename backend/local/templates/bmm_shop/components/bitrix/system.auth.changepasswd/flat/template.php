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

if($arResult["PHONE_REGISTRATION"])
{
	CJSCore::Init('phone_auth');
}
?>
<div class="bx-authform">
 <div class="modal modal-shop modal-shop__login fade show">
    <div class="modal-backdrop show"></div>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <img src="/images/logo.svg">
                <button type="button" class="close" data-dismiss="modal"  onclick="var popup = BX.PopupWindowManager.getCurrentPopup(); popup.close();"></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title"><?=GetMessage("AUTH_CHANGE_PASSWORD")?> <img class="modal-title__icon" src="/images/bmm_icon.svg"></h5>
                <?if($arResult["SHOW_FORM"]):?>
                    <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
                        <?if ($arResult["BACKURL"] <> ''): ?>
                            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                        <? endif ?>
                        <input type="hidden" name="AUTH_FORM" value="Y">
                        <input type="hidden" name="TYPE" value="CHANGE_PWD">

                        <div class="form-group">
                            <input class="form-control" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>"  placeholder="<?=$arResult["LAST_LOGIN"]?>">
                        </div>

                        <?
                        if($arResult["USE_PASSWORD"]):
                            ?>

                            <div class="bx-authform-formgroup-container">
                                <div class="bx-authform-label-container"><?echo GetMessage("system_change_pass_current_pass")?></div>
                                <div class="bx-authform-input-container">
                                    <?if($arResult["SECURE_AUTH"]):?>
                                        <div class="bx-authform-psw-protected" id="bx_auth_secure_pass" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

                                        <script type="text/javascript">
                                            document.getElementById('bx_auth_secure_pass').style.display = '';
                                        </script>
                                    <?endif?>
                                    <input type="password" name="USER_CURRENT_PASSWORD" maxlength="255" value="<?=$arResult["USER_CURRENT_PASSWORD"]?>" autocomplete="new-password" />
                                </div>
                            </div>
                        <?
                        else:
                            ?>
                            <div class="form-group">
                                <input class="form-control" type="hidden" name="USER_CHECKWORD" maxlength="255" value="<?=$arResult["USER_CHECKWORD"]?>" autocomplete="off">
                            </div>
                        <?
                        endif;
                        ?>

                        <div class="form-group">
                            <?if($arResult["SECURE_AUTH"]):?>
                                <div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

                                <script type="text/javascript">
                                    document.getElementById('bx_auth_secure').style.display = '';
                                </script>
                            <?endif?>
                            <input class="form-control" type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="new-password" placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>">
                        </div>
                        <div class="form-group">
                            <?if($arResult["SECURE_AUTH"]):?>
                                <div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

                                <script type="text/javascript">
                                    document.getElementById('bx_auth_secure_conf').style.display = '';
                                </script>
                            <?endif?>
                            <input class="form-control" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="new-password" placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>">
                        </div>
                        <input type="submit" class="btn btn-success mt-4 d-block" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
                    </form>

                    <script type="text/javascript">
                        document.bform.USER_CHECKWORD.focus();
                    </script>
                <?endif;?>

            </div>

            <?if(!empty($arParams["~AUTH_RESULT"])):
                $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
            ?>
                <div class="modal-info <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"modal-info__error")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
            <?endif?>
        </div>
    </div>
</div>
</div>



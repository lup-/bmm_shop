<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

?>

<div class="bx_profile">
    <h1>Мои данные </h1>
	<?
	ShowError($arResult["strProfileError"]);

	if ($arResult['DATA_SAVED'] == 'Y')
	{
		ShowNote(Loc::getMessage('PROFILE_DATA_SAVED'));
	}

	?>
	<form method="post" name="form1" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data" role="form">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
		<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
		<div class="main-profile-block-shown" id="user_div_reg">
			<div class="row">
				<div class="col-12">
					<?
					if (!in_array(LANGUAGE_ID,array('ru', 'ua')))
					{
						?>
						<div class="row">
							<div class="col align-items-center">
								<div class="form-group">
									<label class="main-profile-form-label" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></label>
									<input class="form-control" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
								</div>
							</div>
						</div>
						<?
					}
					?>
					<div class="form-group row">
						<div class="col-sm-8 col-md-6">
							<input class="form-control" type="text" name="NAME" maxlength="50" id="main-profile-name" placeholder="<?=Loc::getMessage('NAME')?>"  value="<?=$arResult["arUser"]["NAME"]?>" />
						</div>
					</div>
                    <div class="form-group row">
                        <div class="col-sm-8 col-md-6">
                            <input class="form-control" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" placeholder="<?=Loc::getMessage('LAST_NAME')?>" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 col-md-6">
                            <input class="form-control" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" placeholder="<?=Loc::getMessage('SECOND_NAME')?>" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 col-md-6">
                            <input class="form-control" type="text" name="EMAIL" maxlength="50" id="main-profile-email" placeholder="<?=Loc::getMessage('EMAIL')?>" value="<?=$arResult["arUser"]["EMAIL"]?>" />
                        </div>
                    </div>

					<?
					if ($arResult['CAN_EDIT_PASSWORD'])
					{
						?>
                        <div class="form-group row">
                            <div class="col-sm-8 col-md-6">
                                <input class=" form-control bx-auth-input main-profile-password" type="password" name="NEW_PASSWORD"
                                       maxlength="50" id="main-profile-password" placeholder="<?=Loc::getMessage('NEW_PASSWORD_REQ')?>" value="" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8 col-md-6">
                                <input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" placeholder="<?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?>" autocomplete="off" />
                            </div>
                        </div>
						<?
					}
					?>
				</div>
			</div>

		</div>
		<div class="form-group row">
            <div class="form-buttons d-flex flex-row mt-4">
                <input type="submit" class="btn btn-success" name="save" value="<?=(($arResult["ID"]>0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
                <input type="submit" class="btn btn-themes btn-link btn-md"  name="reset" value="<?echo GetMessage("MAIN_RESET")?>">
            </div>
		</div>
	</form>


	<?
	$disabledSocServices = isset($arParams['DISABLE_SOCSERV_AUTH']) && $arParams['DISABLE_SOCSERV_AUTH'] === 'Y';

	if (!$disabledSocServices)
	{
		?>
		<div class="col-sm-12 main-profile-social-block">
			<?
			if ($arResult["SOCSERV_ENABLED"])
			{
				$APPLICATION->IncludeComponent(
					"bitrix:socserv.auth.split",
					".default",
					[
						"SHOW_PROFILES" => "Y",
						"ALLOW_DELETE" => "Y",
					],
					false
				);
			}
			?>
		</div>
		<?
	}
	?>
	<div class="clearfix"></div>
	<script>
		BX.Sale.PrivateProfileComponent.init();
	</script>
</div>

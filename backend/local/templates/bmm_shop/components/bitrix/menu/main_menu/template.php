<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

if (empty($arResult["MENU_STRUCTURE"]))
	return;

CUtil::InitJSCore();
?>

<div class="header__container">
  <div class="header-menu menu">
    <div id="main-menu"></div>
  </div>
</div>

<script>
  BX.ready(function() {
    var menuStructure = new menuVue(<?=json_encode($arResult["MENU_STRUCTURE"])?>);
  })
</script>


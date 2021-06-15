<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$uri = new \Bitrix\Main\Web\Uri($request->getRequestUri());
$uri->addParams(['sort'=> 'price_up']);
$arResult["PRICE_UP"] = $uri->getQuery();
$uri->addParams(['sort'=>'price_down']);
$arResult["PRICE_DOWN"] = $uri->getQuery();
$uri->addParams(['sort'=>'rating']);
$arResult["RATING"] = $uri->getQuery();

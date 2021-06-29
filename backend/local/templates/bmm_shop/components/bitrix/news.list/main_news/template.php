<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';
$largeNews = array_slice($arResult['ITEMS'], 0, 4);
$mediumNews = count($arResult['ITEMS']) > 4 ? array_slice($arResult['ITEMS'], 4, 14) : null;
?>
<div class="dropdown dropdown__navigation d-sm-none">
    <button class="btn btn-text dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Новости
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Новости</a>
        <a class="dropdown-item" href="#">Архив новостей</a>
    </div>
</div>
<div class="row news">
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?><br />
    <?endif;?>
    <div class="col-12 col-md-7 col-lg-5 news__list_large">
        <?foreach ($largeNews as $arItem):?>
            <?$this->AddEditAction(
            $arItem['ID'],
            $arItem['EDIT_LINK'],
            CIBlock::GetArrayByID(
            $arItem["IBLOCK_ID"],
            "ELEMENT_EDIT"
            )
            );
            $this->AddDeleteAction(
            $arItem['ID'],
            $arItem['DELETE_LINK'],
            CIBlock::GetArrayByID(
            $arItem["IBLOCK_ID"],
            "ELEMENT_DELETE"),
            array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
            );?>
            <div class="news__list-item">
                <?if($arItem["PREVIEW_PICTURE"]["SRC"]):?>
                <a class="news__list-item_image" href="<?=$arItem['PROPERTIES']['LINK']['VALUE'] ? $arItem['PROPERTIES']['LINK']['VALUE'] : $arItem["DETAIL_PAGE_URL"]?>">

                    <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"]?>"
                         title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                    ></a>
                    <?endif;?>
                <div class="news__list-item_descr">
                    <?if($arItem["NAME"]):?>
                        <a class="news__list-item_title" href="<?=$arItem['PROPERTIES']['LINK']['VALUE'] ? $arItem['PROPERTIES']['LINK']['VALUE'] : $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                    <?endif;?>
                    <span class="news__list-item_date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
                </div>
            </div>
        <?endforeach;?>
    </div>

    <?if($mediumNews):?>
        <div class="col-12 col-md-5 col-lg-7 news__list_normal">
        <?foreach ($mediumNews as $index => $arItem):?>
            <?$this->AddEditAction(
                $arItem['ID'],
                $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID(
                    $arItem["IBLOCK_ID"],
                    "ELEMENT_EDIT"
                )
            );
            $this->AddDeleteAction(
                $arItem['ID'],
                $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID(
                    $arItem["IBLOCK_ID"],
                    "ELEMENT_DELETE"),
                array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
            );?>
            <div class="news__list-item <?if( $index == 7 ) echo 'news__list-item-round'?>">
                <?if($arItem["PREVIEW_PICTURE"]["SRC"]):?>
                <a class="news__list-item_image" href="<?=$arItem['PROPERTIES']['LINK']['VALUE'] ? $arItem['PROPERTIES']['LINK']['VALUE'] : $arItem["DETAIL_PAGE_URL"]?>">
                    <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"]?>"
                         title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>
                          alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                    ></a>
                <?endif;?>
                <div class="news__list-item_descr">
                    <?if($arItem["NAME"]):?>
                        <a class="news__list-item_title" href="<?=$arItem['PROPERTIES']['LINK']['VALUE'] ? $arItem['PROPERTIES']['LINK']['VALUE'] : $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                    <?endif;?>
                    <span class="news__list-item_date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
                </div>
            </div>
        <?endforeach;?>

    </div>
    <?endif;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <div class="catalog row">
    <div class="catalog__main col-12 col-md-9">
        <div class="catalog-footer row">
                <div class="col-12 col-lg-9">
                    <?=$arResult['NAV_STRING']?>
                </div>
        </div>
    </div>
</div>
<?endif;?>



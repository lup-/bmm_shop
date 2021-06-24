<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>

<div class="wrapper">
    <div class="content">
        <div class="container">
            <div class="bx-sbb-empty-cart-container">
                <h2 class="bx-sbb-empty-cart-text"><?=Loc::getMessage("SBB_EMPTY_BASKET_TITLE")?></h2>
                <?if (!empty($arParams['EMPTY_BASKET_HINT_PATH'])):?>
                <div class="bx-sbb-empty-cart-desc">
                    <a href="<?=$arParams['EMPTY_BASKET_HINT_PATH']?>">
                        <?=Loc::getMessage('SBB_EMPTY_BASKET_HINT', ['#A1#' => '', '#A2#' => ''])?>
                    </a>
                </div>
                <?endif?>
            </div>
        </div>
    </div>
</div>

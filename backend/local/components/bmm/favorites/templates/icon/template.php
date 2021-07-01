<?php
/**
 * @global array $arParams
 * @global array $arResult
 * @global CUser $USER
 * @global CMain $APPLICATION
 */
?>
<a class="nav-link favorite" href="<?=$arParams['FAVORITE_DETAILS_URL']?>">
    <span id="favorite-count" class="<?=$arResult['HAS_FAVORITES'] ? 'favorite__counter': ''?>">
        <?=$arResult['HAS_FAVORITES'] ? $arResult['FAVORITES_COUNT'] : '' ?>
    </span>
</a>
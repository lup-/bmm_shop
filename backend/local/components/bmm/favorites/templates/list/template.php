<?php
/**
 * @global array $arParams
 * @global array $arResult
 * @global CUser $USER
 * @global CMain $APPLICATION
 */
?>
<div class="basket-items basket">
    <ul class="list-group list-group-flush">
        <?foreach ($arResult['FAVORITES'] as $favoriteElement):?>
        <li class="list-group-item d-flex py-4 fav-item" data-item-id="<?=$favoriteElement['ID']?>">
            <div class="d-flex flex-column w-100">
                <div class="d-flex">
                    <div class="basket-items__image mr-3 mr-sm-5">
                        <img src="<?=$favoriteElement['DETAIL_PICTURE']['SRC']?>">
                    </div>
                    <div class="basket-items__info-actions d-flex flex-fill flex-column justify-content-between">
                        <div class="basket-items__info-top d-flex justify-content-between">
                            <div class="d-flex-inline flex-column">
                                <div class="basket-items__info_title">
                                    <a href="<?=$favoriteElement['DETAIL_PAGE_URL']?>"><?=$favoriteElement['NAME']?></a>
                                </div>
                                <div class="basket-items__info_author"><?=$favoriteElement['DISPLAY_PROPERTIES']['AUTHOR']['VALUE']?></div>
                            </div>
                            <div class="basket-items__price-count d-none d-md-flex">
                                <div class="d-flex-inline flex-column mr-4">
                                    <div class="basket-items__price"><?=$favoriteElement['PRICE']?>&nbsp;₽</div>
                                </div>
                            </div>
                            <div class="basket-items_fav d-block d-sm-none">
                                <button
                                    class="btn btn-text btn-fav btn-fav__active"
                                    data-item="<?=$favoriteElement['ID']?>"
                                    onclick="removeFavorite(<?=$favoriteElement['ID']?>)"
                                >
                                    <i class="btn-fav__icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="basket-items__info-bottom d-flex justify-content-between align-items-end flex-column flex-sm-row mt-4">
                            <button
                                class="btn btn-text btn-fav btn-fav__active d-none d-sm-inline-flex"
                                data-item="<?=$favoriteElement['ID']?>"
                                onclick="removeFavorite(<?=$favoriteElement['ID']?>)"
                            >
                                <i class="btn-fav__icon"></i>
                                <span>Убрать из избранного</span>
                            </button>
                            <div class="basket-items__info_isbn">
                                <p class="mb-0"><?=$favoriteElement['DISPLAY_PROPERTIES']['ISBN']['VALUE']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="basket-items__price-count d-flex d-sm-none mt-4 justify-content-end">
                    <div class="d-flex-inline flex-column mr-4">
                        <div class="basket-items__price"><?=$favoriteElement['PRICE']?>&nbsp;₽</div>
                    </div>
                </div>
            </div>
        </li>
        <?endforeach;?>
    </ul>
</div>
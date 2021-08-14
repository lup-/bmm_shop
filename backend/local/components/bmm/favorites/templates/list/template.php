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
        <li class="list-group-item d-flex py-4 px-0 fav-item" data-item-id="<?=$favoriteElement['ID']?>">
            <div class="d-flex flex-column w-100">
                <div class="d-flex">
                    <div class="basket-items__image mr-3 mr-sm-5">
                        <a href="<?=$favoriteElement['DETAIL_PAGE_URL']?>"><img src="<?=$favoriteElement['DETAIL_PICTURE']['SRC']?>"></a>
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
                                <div class="d-flex align-items-start">
                                    <div class="basket-items__price mr-4"><?=$favoriteElement['PRICE']?>&nbsp;₽</div>
                                    <?if ($favoriteElement['QUANTITY'] > 0 && $favoriteElement['ACTIVE'] == 'Y'): ?>
                                        <button
                                                class="btn btn-primary btn-cart"
                                                data-item="<?=$favoriteElement['ID']?>"
                                                onclick="add2Basket(<?=$favoriteElement['ID']?>)"
                                        >
                                            Добавить в корзину
                                        </button>
                                    <?else:?>
                                        <span class="text-muted">Нет в наличии</span>
                                    <?endif;?>
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
                                <p class="mb-0">ISBN <?=$favoriteElement['DISPLAY_PROPERTIES']['ISBN']['VALUE']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="basket-items__price-count d-flex d-sm-none mt-4 justify-content-end">
                    <div class="d-flex-inline flex-column">
                        <div class="basket-items__price text-right"><?=$favoriteElement['PRICE']?>&nbsp;₽</div>
                    </div>
                </div>
                <button
                        class="btn btn-primary btn-cart d-sm-none mt-4"
                        data-item="<?=$favoriteElement['ID']?>"
                        onclick="add2Basket(<?=$favoriteElement['ID']?>)"
                >
                    Добавить в корзину
                </button>
            </div>
        </li>
        <?endforeach;?>
    </ul>
</div>
<?foreach ($arResult['FAVORITES'] as $favoriteElement):?>
    <div id="modal-fav-<?=$favoriteElement['ID']?>" class="modal modal-shop fade">
        <div class="modal-backdrop show"></div>
        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header">
                    <button onclick="destroyModal(<?=$favoriteElement['ID']?>)" type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title">Спасибо</h5>
                    Товар успешно добавлен в корзину.
                </div>
                <div class="modal-footer">
                    <button onclick="basketRedirect(<?=$favoriteElement['ID']?>)" type="button" class="btn btn-success">Оформить заказ</button>
                    <button onclick="destroyModal(<?=$favoriteElement['ID']?>)" type="button" class="btn btn-text" data-dismiss="modal">Продолжить покупки</button>
                </div>
            </div>
        </div>
    </div>
    <script>document.body.append(document.getElementById("modal-fav-<?=$favoriteElement['ID']?>"))</script>
<?endforeach;?>


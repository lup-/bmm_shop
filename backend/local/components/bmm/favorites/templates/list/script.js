function removeFavorite(productId) {
    let favoriteUrl = '/local/ajax/favorite.php?id=' + productId + '&action=remove';
    BX.ajax({
        method: 'GET',
        dataType: 'html',
        url: favoriteUrl,
        onsuccess: favoriteResult.bind(null, productId)
    });
}

function favoriteResult(productId, arResult) {
    let result = BX.parseJSON(arResult);
    BX.onCustomEvent('OnBasketChange');

    if (result.status === 'remove') {
        let favListElement = document.querySelector(`.fav-item[data-item-id="${productId}"]`);
        favListElement.remove();
    }
}

function add2Basket(productId){
    let url = '/?action=ADD2BASKET&id=' + productId;
    let basketParams = {
        'ajax_basket': 'Y'
    };
    this.productId = productId;

    BX.ajax({
        method: 'POST',
        dataType: 'json',
        url: url,
        data: basketParams,
        onsuccess: BX.proxy(basketResult, this)
    });


}
function basketResult (arResult)
{
    var successful = arResult.STATUS === 'OK';
    if (successful)
    {

        BX.onCustomEvent('OnBasketChange');
        BX.addClass('modal-fav-'+ this.productId, 'show');
    }
}

function basketRedirect (productId)
{
    BX.removeClass('modal-fav-'+ productId, 'show');
    location.href = '/personal/cart/';
}

function destroyModal (productId)
{
    BX.removeClass('modal-fav-'+ productId, 'show');
}

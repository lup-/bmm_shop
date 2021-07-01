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
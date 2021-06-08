(function (window){
	'use strict';

	if (window.JCCatalogItem)
		return;

	window.JCCatalogItem = function(arParams) {
		this.basketAction = 'ADD';
		this.favoriteAction = 'ADD';
		this.canBuy = true;
		this.obPopupWin = null;
		this.basketUrl = '';
		this.favoriteUrl = '';
		this.errorCode = 0;
		this.basketParams = {};
		this.visual = {
			ID: ''
		};
		this.product = {
			canBuy: true,
			name: '',
			id: 0,
			addUrl: '',
			buyUrl: ''
		};
		this.basketMode = '';
		this.basketData = {
			useProps: false,
			emptyProps: false,
			quantity: 'quantity',
			props: 'prop',
			basketUrl: '',
			sku_props: '',
			sku_props_var: 'basket_props',
			add_url: '',
			buy_url: ''
		};

		this.product.canBuy = arParams.PRODUCT.CAN_BUY;
		this.canBuy = this.product.canBuy;
		if (typeof arParams === 'object') {
			this.visual = arParams.VISUAL;
		}

		this.product.name = arParams.PRODUCT.NAME;
		this.product.id = arParams.PRODUCT.ID;
		this.product.DETAIL_PAGE_URL = arParams.PRODUCT.DETAIL_PAGE_URL;

		if (arParams.ADD_TO_BASKET_ACTION)
		{
			this.basketAction = arParams.ADD_TO_BASKET_ACTION;
		}
		if (arParams.BASKET.BASKET_URL)
		{
			this.basketData.basketUrl = arParams.BASKET.BASKET_URL;
		}
		if (arParams.BASKET.ADD_URL_TEMPLATE)
		{
			this.basketData.add_url = arParams.BASKET.ADD_URL_TEMPLATE;
		}

		if (arParams.BASKET.BUY_URL_TEMPLATE)
		{
			this.basketData.buy_url = arParams.BASKET.BUY_URL_TEMPLATE;
		}

		if (this.basketData.add_url === '' && this.basketData.buy_url === '')
		{
			this.errorCode = -1024;
		}
		BX.ready(BX.delegate(this.init,this));
	}

	window.JCCatalogItem.prototype = {
		init: function(){
			this.obBasketActions = BX(this.visual.BASKET_ACTIONS_ID);
			this.favoriteBtn = BX(this.visual.FAVORITE_ID);

			if (this.obBasketActions)
			{
				if (this.visual.BUY_ID)
				{
					this.obBuyBtn = BX(this.visual.BUY_ID);
				}
			}

			if (this.obBuyBtn)
			{
				if (this.basketAction === 'ADD')
				{
					BX.bind(this.obBuyBtn, 'click', BX.proxy(this.add2Basket, this));
				}
				else
				{
					BX.bind(this.obBuyBtn, 'click', BX.proxy(this.buyBasket, this));
				}
			}

			BX.bind(this.favoriteBtn, 'click', BX.proxy(this.addFavorite, this));
			BX.bind(BX('close-modal-'+this.product.id), 'click', BX.proxy(this.destroyModal, this));
			BX.bind(BX('exit-modal-'+this.product.id), 'click', BX.proxy(this.destroyModal, this));
			BX.bind(BX('order-modal-'+this.product.id), 'click', BX.delegate(this.basketRedirect, this));
		},

		addFavorite: function() {
			this.favoriteUrl = '/local/ajax/favorite.php?id=' + this.product.id + '&action=add';
			BX.ajax({
				method: 'GET',
				dataType: 'html',
				url: this.favoriteUrl,
				onsuccess: BX.proxy(this.favoriteResult, this)
			});
		},

		favoriteResult: function(arResult){
			var result = BX.parseJSON(arResult);
			BX.onCustomEvent('OnBasketChange');
			if(result.status == 'add'){
				BX.addClass(this.favoriteBtn, 'btn-fav__active');

			} else if (result.status == 'remove'){
				BX.removeClass(this.favoriteBtn, 'btn-fav__active');
			}
		},

		initBasketUrl: function()
		{
			this.basketUrl = (this.basketMode === 'ADD' ? this.basketData.add_url : this.basketData.buy_url);
			this.basketUrl = this.basketUrl.replace('#ID#', this.product.id.toString());
			this.basketParams = {
				'ajax_basket': 'Y'
			};
		},

		add2Basket: function()
		{
			this.basketMode = 'ADD';
			this.sendToBasket();
		},

		sendToBasket: function()
		{
			if (!this.canBuy)
			{
				return;
			}
			this.initBasketUrl();

			BX.ajax({
				method: 'POST',
				dataType: 'json',
				url: this.basketUrl,
				data: this.basketParams,
				onsuccess: BX.proxy(this.basketResult, this)
			});
		},
		basketResult: function(arResult)
		{

			var successful = arResult.STATUS === 'OK';
			if (successful)
			{

				BX.onCustomEvent('OnBasketChange');
				BX.addClass('modal-'+ this.product.id, 'show');
			}
		},
		basketRedirect: function()
		{
			BX.removeClass('modal-'+this.product.id, 'show');
			location.href = (this.basketData.basketUrl ? this.basketData.basketUrl : BX.message('BASKET_URL'));
		},
		destroyModal: function ()
		{
			BX.removeClass('modal-'+this.product.id, 'show');
		}
	}
})(window);
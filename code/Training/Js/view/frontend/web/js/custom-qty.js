define([
    'uiComponent',
    'jquery',
    'ko'
], function (Component, $, ko) {
    'use strict';

    return Component.extend({
        url: '',
        isDisplaying: ko.observable(false),
        productQty: ko.observable(),

        initialize: function () {
            this._super();
            return this;

        },

        getQty: function () {
            this.isDisplaying(true);
            var self = this;
            $.ajax({
                url: self.url,
                type: 'post',
                dataType: 'json',
                data: {
                    productId: this.getProductId()
                }
            }).done(function (data) {
                if (data.qty) {
                    self.isDisplaying(true);
                    self.productQty(data.qty);
                }
            }).fail(function(sender, message, details) {
                //todo
            })
        },

        getProductId: function () {
            return $('#product_addtocart_form input[name="product"]').val();
        },

    });
});

require(['jquery', 'Magento_Customer/js/customer-data'], function ($, customerData) {
    'use strict';
    $(document).ready(function(){

        /*Real Time Live Search*/
        const varLenght = 5;
        $("#skuSearch").on('input', function () {
            if($(this).val().length >= varLenght) {
                $.ajax({
                    type: 'POST',
                    url: "extension/search/index",
                    data: $('#sku-form').serialize(),
                    showLoader: true,
                    success: function (resp) {
                        console.log(resp.items);
                        $.each(resp.items, function (i, item) {
                            $('#products-list').show();
                            $("#products-list").append("<li class='item-list' data-item=" + item + ">"+ item+"</li>");
                        });

                        $('#products-list li').on('click', function(){
                           $('#skuSearch').val($(this).text());
                           $('#products-list').hide();
                        });

                    },
                    fail: function (e) {
                        console.log(e);
                    }
                })
            }
        });

        /*AddToCart Ajax Request*/
        $('#sku-form').on('submit', function(e){
                $.ajax({
                    type: 'POST',
                    url: "extension/cart/add",
                    data: $('#sku-form').serialize(),
                    showLoader: true,
                    success: function(resp) {
                        console.log(resp);
                        var sections = ['cart'];

                        alert('Товар добавлен в корзину!');
                        // The mini cart reloading
                        customerData.invalidate(sections);
                        customerData.reload(sections, true);

                        $('#skuSearch').val('');
                    },
                    fail: function (resp) {
                        console.log(resp);
                        alert('Ошибка, товар не добавлен в корзину!');
                    }
                });
                return false;
        });


    });
});
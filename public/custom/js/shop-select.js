(function (window, document, $) {
    'use strict';

    let shops = [];

    const shopSelect = $('#shop');
    const shopSelectArea = $('#shop-area');
    const shopSelectLoader = $('#shop-loader');

    shopSelectLoader.show();

    shopSelectArea.hide();

    const shopsUrl = shopSelect.data('url');
    const selectedShopId = shopSelect.data('old');

    ajaxRequest(shopsUrl)
        .then((response)  => {
            shops = response;
            loadShopSelect(selectedShopId);
        })
        .catch((error) => {
            console.log({error});
        })
        .finally(() => {
            shopSelectLoader.hide();
            shopSelectArea.show();
        });

    function loadShopSelect(selectedShopId = '') {
        let content = '';

        shops.forEach((shop) => {
            content += `
                <option value="${shop.id}" ${(selectedShopId === shop.id) && 'selected'}>
                    ${shop.name}
                </option>
            `;
        });

        shopSelect.html(content);
    }

})(window, document, jQuery);
(function (window, document, $) {
    'use strict';

    let countries = [];

    const shopSelect = $('#shop');
    const shopSelectArea = $('#shop-area');
    const shopSelectLoader = $('#shop-loader');

    shopSelectLoader.show();

    shopSelectArea.hide();

    const countriesUrl = shopSelect.data('url');
    const selectedCountryId = shopSelect.data('old');

    ajaxRequest(countriesUrl)
        .then((response)  => {
            countries = response;
            loadCountrySelect(selectedCountryId);
        })
        .catch((error) => {
            console.log({error});
        })
        .finally(() => {
            shopSelectLoader.hide();
            shopSelectArea.show();
        });

    function loadCountrySelect(selectedCountryId = '') {
        let content = '';

        countries.forEach((shop) => {
            content += `
                <option value="${shop.id}" ${(selectedCountryId === shop.id) && 'selected'}>
                    ${shop.name}
                </option>
            `;
        });

        shopSelect.html(content);
    }

})(window, document, jQuery);
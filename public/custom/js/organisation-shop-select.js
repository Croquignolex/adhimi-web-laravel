(function (window, document, $) {
    'use strict';

    let organisations = [];
    let shops = [];

    const organisationSelect = $('#organisation');
    const organisationSelectArea = $('#organisation-area');
    const organisationSelectLoader = $('#organisation-loader');

    const shopSelect = $('#shop');
    const shopSelectArea = $('#shop-area');
    const shopSelectLoader = $('#shop-loader');

    organisationSelectLoader.show();
    shopSelectLoader.show();

    organisationSelectArea.hide();
    shopSelectArea.hide();

    const organisationsUrl = organisationSelect.data('url');
    const selectedOrganisationId = organisationSelect.data('old');

    const shopsUrl = shopSelect.data('url');
    const selectedShopId = shopSelect.data('old');

    organisationSelect.on('change', () => {
        const selectedOrganisationId = organisationSelect.val();
        loadShopSelect(selectedOrganisationId);
    });

    ajaxRequest(organisationsUrl)
        .then((response)  => {
            organisations = response;
            loadOrganisationSelect(selectedOrganisationId);

            ajaxRequest(shopsUrl)
                .then((response) => {
                    shops = response;
                    loadShopSelect(selectedOrganisationId, selectedShopId);
                })
                .catch((error) => {
                    console.log({error});
                })
                .finally(() => {
                    shopSelectLoader.hide();
                    shopSelectArea.show();
                });
        })
        .catch((error) => {
            console.log({error});
        })
        .finally(() => {
            organisationSelectLoader.hide();
            organisationSelectArea.show();
        });

    function loadOrganisationSelect(selectedOrganisationId = '') {
        let content = '';

        organisations.forEach((organisation) => {
            content += `
                <option value="${organisation.id}" ${(selectedOrganisationId === organisation.id) && 'selected'}>
                    ${organisation.name}
                </option>
            `;
        });

        organisationSelect.html(content);
    }

    function loadShopSelect(selectedOrganisationId = '', selectedShopId = '') {
        if(organisations.length > 0) {
            let content = '';
            let filterShops = shops;
            const organisationId = selectedOrganisationId || organisations[0].id;

            filterShops
                .filter((shop) => (shop.organisation.id === organisationId))
                .forEach((shop) => {
                    content += `
                        <option value="${shop.id}" ${(selectedShopId === shop.id) && 'selected'}>
                            ${shop.name}
                        </option>
                    `;
                });

            shopSelect.html(content);
        }
    }

})(window, document, jQuery);
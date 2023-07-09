(function (window, document, $) {
    'use strict';

    let organisations = [];

    const organisationSelect = $('#organisation');
    const organisationSelectArea = $('#organisation-area');
    const organisationSelectLoader = $('#organisation-loader');

    organisationSelectLoader.show();

    organisationSelectArea.hide();

    const organisationsUrl = organisationSelect.data('url');
    const selectedOrganisationId = organisationSelect.data('old');

    ajaxRequest(organisationsUrl)
        .then((response)  => {
            organisations = response;
            loadOrganisationSelect(selectedOrganisationId);
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

})(window, document, jQuery);
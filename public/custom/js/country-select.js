(function (window, document, $) {
    'use strict';

    let countries = [];

    const countrySelect = $('#country');
    const countrySelectArea = $('#country-area');
    const countrySelectLoader = $('#country-loader');

    countrySelectLoader.show();

    countrySelectArea.hide();

    const countriesUrl = countrySelect.data('url');
    const selectedCountryId = countrySelect.data('old');

    ajaxRequest(countriesUrl)
        .then((response)  => {
            countries = response;
            loadCountrySelect(selectedCountryId);
        })
        .catch((error) => {
            console.log({error});
        })
        .finally(() => {
            countrySelectLoader.hide();
            countrySelectArea.show();
        });

    function loadCountrySelect(selectedCountryId = '') {
        let content = '';

        countries.forEach((country) => {
            content += `
                <option value="${country.id}" ${(selectedCountryId === country.id) && 'selected'}>
                    ${country.name}
                </option>
            `;
        });

        countrySelect.html(content);
    }

})(window, document, jQuery);
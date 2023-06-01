(function (window, document, $) {
    'use strict';

    let countries = [];
    let states = [];

    const countrySelect = $('#country');
    const countrySelectArea = $('#country-area');
    const countrySelectLoader = $('#country-loader');

    const stateSelect = $('#state');
    const stateSelectArea = $('#state-area');
    const stateSelectLoader = $('#state-loader');

    countrySelectLoader.show();
    stateSelectLoader.show();

    countrySelectArea.hide();
    stateSelectArea.hide();

    const countriesUrl = countrySelect.data('url');
    const oldCountryId = countrySelect.data('old');
    const optionCountryId = countrySelect.data('option');

    const statesUrl = stateSelect.data('url');
    const oldStateId = stateSelect.data('old');
    const optionSateId = stateSelect.data('option');

    countrySelect.change(() => {
        const selectedCountryId = countrySelect.val();
        loadStateSelect(selectedCountryId);
    });

    ajaxRequest(countriesUrl)
        .then((response)  => {
            countries = response;
            const selectedCountryId = oldCountryId || optionCountryId;
            loadCountrySelect(selectedCountryId);

            ajaxRequest(statesUrl)
                .then((response) => {
                    states = response;
                    const selectedStateId = oldStateId || optionSateId;
                    loadStateSelect(selectedCountryId, selectedStateId);
                })
                .catch((error) => {
                    console.log({error});
                })
                .finally(() => {
                    stateSelectLoader.hide();
                    stateSelectArea.show();
                });
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

    function loadStateSelect(selectedCountryId = '', selectedStateId = '') {
        if(countries.length > 0) {
            let content = '';
            let filterStates = states;
            const countryId = selectedCountryId || countries[0].id;

            filterStates
                .filter((state) => (state.country.id === countryId))
                .forEach((state) => {
                    content += `
                        <option value="${state.id}" ${(selectedStateId === state.id) && 'selected'}>
                            ${state.name}
                        </option>
                    `;
                });

            stateSelect.html(content);
        }
    }

})(window, document, jQuery);
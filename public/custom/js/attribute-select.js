(function (window, document, $) {
    'use strict';

    let attributes = [];

    const attributeSelect = $('#attribute');
    const attributeSelectArea = $('#attribute-area');
    const attributeSelectLoader = $('#attribute-loader');

    attributeSelectLoader.show();

    attributeSelectArea.hide();

    const attributesUrl = attributeSelect.data('url');
    const selectedAttributeId = attributeSelect.data('old');

    ajaxRequest(attributesUrl)
        .then((response)  => {
            attributes = response;
            loadAttributeSelect(selectedAttributeId);
        })
        .catch((error) => {
            console.log({error});
        })
        .finally(() => {
            attributeSelectLoader.hide();
            attributeSelectArea.show();
        });

    function loadAttributeSelect(selectedAttributeId = '') {
        let content = '';

        attributes.forEach((attribute) => {
            content += `
                <option value="${attribute.id}" ${(selectedAttributeId === attribute.id) && 'selected'}>
                    ${attribute.name}
                </option>
            `;
        });

        attributeSelect.html(content);
    }

})(window, document, jQuery);
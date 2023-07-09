(function (window, document, $) {
    'use strict';

    let groups = [];

    const groupSelect = $('#group');
    const groupSelectArea = $('#group-area');
    const groupSelectLoader = $('#group-loader');

    groupSelectLoader.show();

    groupSelectArea.hide();

    const groupsUrl = groupSelect.data('url');
    const selectedGroupId = groupSelect.data('old');

    ajaxRequest(groupsUrl)
        .then((response)  => {
            groups = response;
            loadGroupSelect(selectedGroupId);
        })
        .catch((error) => {
            console.log({error});
        })
        .finally(() => {
            groupSelectLoader.hide();
            groupSelectArea.show();
        });

    function loadGroupSelect(selectedGroupId = '') {
        let content = '';

        groups.forEach((group) => {
            content += `
                <option value="${group.id}" ${(selectedGroupId === group.id) && 'selected'}>
                    ${group.name}
                </option>
            `;
        });

        groupSelect.html(content);
    }

})(window, document, jQuery);
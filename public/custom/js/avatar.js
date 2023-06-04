(function (window, document, $) {
    'use strict';

    const avatarChangeButton = $('#avatar-change');
    const avatarDeleteButton = $('#avatar-delete');
    const avatarChangeForm = $('#avatar-change-form');
    const avatarInput = $('#avatar-upload');

    avatarChangeButton.on('click', () => {
        avatarInput.click();
    });

    avatarInput.on('change', (e) => {
        avatarChangeForm.submit();
    });

})(window, document, jQuery);
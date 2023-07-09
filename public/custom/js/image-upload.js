(function (window, document, $) {
    'use strict';

    const logoChangeButton = $('#logo-change');
    const logoChangeForm = $('#logo-change-form');
    const logoInput = $('#logo-upload');

    const bannerChangeButton = $('#banner-change');
    const bannerChangeForm = $('#banner-change-form');
    const bannerInput = $('#banner-upload');

    const avatarChangeButton = $('#avatar-change');
    const avatarChangeForm = $('#avatar-change-form');
    const avatarInput = $('#avatar-upload');

    logoChangeButton.on('click', () => {
        logoInput.click();
    });

    bannerChangeButton.on('click', () => {
        bannerInput.click();
    });

    avatarChangeButton.on('click', () => {
        avatarInput.click();
    });

    logoInput.on('change', (e) => {
        logoChangeForm.submit();
    });

    bannerInput.on('change', (e) => {
        bannerChangeForm.submit();
    });

    avatarInput.on('change', (e) => {
        avatarChangeForm.submit();
    });

})(window, document, jQuery);
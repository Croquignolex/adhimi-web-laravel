(function (window, document, $) {
    'use strict';

    const logoChangeButton = $('#logo-change');
    const logoChangeForm = $('#logo-change-form');
    const logoInput = $('#logo-upload');

    const bannerChangeButton = $('#banner-change');
    const bannerChangeForm = $('#banner-change-form');
    const bannerInput = $('#banner-upload');

    logoChangeButton.on('click', () => {
        logoInput.click();
    });

    bannerChangeButton.on('click', () => {
        bannerInput.click();
    });

    logoInput.on('change', (e) => {
        logoChangeForm.submit();
    });

    bannerInput.on('change', (e) => {
        bannerChangeForm.submit();
    });

})(window, document, jQuery);
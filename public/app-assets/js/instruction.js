(function (window, document, $) {
    'use strict';

    const loader = $('#loader');
    const button = $('.btn-primary');
    const area = $('#instruction-area');
    const field = $('#instruction-field');

    loader.hide();

    field.on('input selectionchange', (e) => {
        const scrollHeight = e.target.scrollHeight;
        area.css({height: scrollHeight + 30});
        field.css({height: scrollHeight});
    });

    button.click((e) => {
        button.hide();
        loader.show();
    });

})(window, document, jQuery);
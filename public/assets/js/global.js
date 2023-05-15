// Laravel JQuery ajax csrf requirement
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Ajax request helper
function ajaxRequest(url, type = 'GET', data = null)
{
    let ajaxObject = {type, url};
    if(data) {
        ajaxObject.data = data;
    }

    return new Promise((resolve, reject) => {
        $.ajax({
            ...ajaxObject,
            success: (data) => resolve(data),
            error: (error) => reject(error)
        });
    });
}

(function (window, document, $) {
    'use strict';



})(window, document, jQuery);
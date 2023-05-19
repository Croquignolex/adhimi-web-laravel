// Feather mapping
$(window).on('load', function() {
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }

    $('#free-trial').modal('show');
});

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

    // Date picker
    const basicPicker = $('.flatpickr-basic');
    if (basicPicker.length) {
        basicPicker.flatpickr({
            maxDate: 'today',
            // dateFormat: 'd-m-Y'
        });
    }

    // Search select
    const searchSelect = $('.select2');
    if (searchSelect.length) {
        searchSelect.each(function () {
            const $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
    }

    // Copy text on click
    const copyAlert = $('#copy-alert');
    copyAlert.hide();

    try
    {
        const copyToClipboard = document.getElementById("copy-to-clipboard");

        copyToClipboard.onclick = () => {
            document.execCommand("copy");
        }

        copyToClipboard.addEventListener("copy", function(event) {
            event.preventDefault();
            if (event.clipboardData) {
                event.clipboardData.setData("text/plain", copyToClipboard.textContent);
                copyAlert.show();
            }
        });
    } catch (e) {}

})(window, document, jQuery);
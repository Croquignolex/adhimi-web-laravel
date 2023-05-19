(function (window, document, $) {
    'use strict';

    const loader = $('#loader');
    const errorBlock = $('#error-block');
    const phoneInput = $('#phone-input');
    const formatBlock = $('#format-block');
    const paymentForm = $('#payment-form');
    const successBlock = $('#success-block');
    const instructionsBlock = $('#instructions-block');

    loader.hide();
    errorBlock.hide();
    paymentForm.show();
    formatBlock.hide();
    successBlock.hide();
    instructionsBlock.hide();

    const makeUrl = paymentForm.data('make');
    const checkUrl = paymentForm.data('check');

    paymentForm.submit((e) => {
        e.preventDefault();

        const phone = phoneInput.val();
        errorBlock.hide();
        formatBlock.hide();
        successBlock.hide();

        if(goodPhoneFormat(phone)) makePayment(phone);
        else formatBlock.show();
    });

    /**
     *
     * @param phone
     */
    const makePayment = (phone) => {
        loader.show();
        paymentForm.hide();
        instructionsBlock.show();

        ajaxRequest(makeUrl, 'POST', {phone})
            .then((response)  => {
                checkPayment(response.payment, response.provider, phone)
            })
            .catch((error) => {
                errorEvent(error);
            })
    };

    /**
     *
     * @param payment
     * @param provider
     * @param phone
     */
    const checkPayment = (payment, provider, phone) => {
        ajaxRequest(checkUrl, 'POST', {payment, provider, phone})
            .then((response)  => {
                const retry = response.retry;

                if(retry) setTimeout(() => checkPayment(payment, provider, phone), 5000);
                else {
                    loader.hide();
                    successBlock.show();
                    instructionsBlock.hide();
                    setTimeout(() => window.location.reload(), 3000);
                }
            })
            .catch((error) => {
                errorEvent(error);
            })
    };

    /**
     *
     * @param error
     */
    const errorEvent = (error) => {
        loader.hide();
        errorBlock.show();
        paymentForm.show();
        instructionsBlock.hide();

        console.log({error});
    };

    /**
     *
     * @param input
     * @returns {boolean}
     */
    const goodPhoneFormat = (input) => {
        const str = input?.toString();
        const regexp = new RegExp('^6');

        return (str.length === 9) && (regexp.test(str));
    };

})(window, document, jQuery);
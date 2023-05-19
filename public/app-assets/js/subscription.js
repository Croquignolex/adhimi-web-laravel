(function (window, document, $) {
    'use strict';

    const weeklyCheck = $('#weekly-check');
    const monthlyCheck = $('#monthly-check');
    const yearlyCheck = $('#yearly-check');

    const basicPrice = $('#basic-price');
    const premiumPrice = $('#premium-price');
    const ultimatePrice = $('#ultimate-price');

    const basicRange = $('#basic-period');
    const premiumRange = $('#premium-period');
    const ultimateRange = $('#ultimate-period');

    const upgradePremiumModalInput = $('#upgrade-premium-modal-input');
    const upgradeUltimateModalInput = $('#upgrade-ultimate-modal-input');

    weeklyCheck.change(() => {
        basicPrice.html("0");
        premiumPrice.html("250");
        ultimatePrice.html("500");

        basicRange.html("/ week");
        premiumRange.html("/ week");
        ultimateRange.html("/ week");
    });

    monthlyCheck.change(() => {
        basicPrice.html("0");
        premiumPrice.html("500");
        ultimatePrice.html("1,000");

        basicRange.html("/ month");
        premiumRange.html("/ month");
        ultimateRange.html("/ month");
    });

    yearlyCheck.change(() => {
        basicPrice.html("0");
        premiumPrice.html("2,500");
        ultimatePrice.html("5,000");

        basicRange.html("/ year");
        premiumRange.html("/ year");
        ultimateRange.html("/ year");
    });

    $('#upgrade-premium').click(() => {
        let check;

        if(weeklyCheck.is(':checked')) {
            check = {price: 250, period: 'week'};
            upgradePremiumModalInput.val(weeklyCheck.val());
        } else if(monthlyCheck.is(':checked')) {
            check = {price: 500, period: 'month'};
            upgradePremiumModalInput.val(monthlyCheck.val());
        } else {
            check = {price: '2,500', period: 'year'};
            upgradePremiumModalInput.val(yearlyCheck.val());
        }

        $('#upgrade-premium-modal-content').html(`
            <p>
                Purchase package 
                <span class="badge badge-light-warning">Premium</span>
                for <strong>one ${check.period}</strong> at <strong>FCFA ${check.price}</strong>
            </p>
        `)

        $('#upgrade-premium-modal').modal('show');
    });

    $('#upgrade-ultimate').click(() => {
        let check;

        if(weeklyCheck.is(':checked')) {
            check = {price: 500, period: 'week'};
            upgradeUltimateModalInput.val(weeklyCheck.val());
        } else if(monthlyCheck.is(':checked')) {
            check = {price: '1,000', period: 'month'};
            upgradeUltimateModalInput.val(monthlyCheck.val());
        } else {
            check = {price: '5,000', period: 'year'};
            upgradeUltimateModalInput.val(yearlyCheck.val());
        }

        $('#upgrade-ultimate-modal-content').html(`
            <p>
                Purchase package 
                <span class="badge badge-light-info">Ultimate</span>
                for <strong>one ${check.period}</strong> at <strong>FCFA ${check.price}</strong>
            </p>
        `)

        $('#upgrade-ultimate-modal').modal('show');
    });

})(window, document, jQuery);
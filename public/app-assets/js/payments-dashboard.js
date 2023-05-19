(function (window, document, $) {
    'use strict';

    const selectedRange = $('#payments-selected-range');
    const errorAlert = $('#payments-error-alert');
    const loader = $('.payments-loader');
    let chart = null;

    const paymentsAmount = $('#payments-amount');

    const paymentsChart = $('#payments-chart');
    const url = paymentsChart.data('url');

    const charOptions = {
        responsive: true,
        backgroundColor: false,
        legend: {display: false},
        maintainAspectRatio: false,
        tooltips: {enabled: false},
        scales: {
            xAxes: [{
                ticks: {fontColor: "#7367F0", beginAtZero: true},
                gridLines: { color: "#6c757d", zeroLineColor: "#6c757d"}
            }],
            yAxes: [{
                ticks: {fontColor: "#7367F0", beginAtZero: true},
                gridLines: {color: "#6c757d", zeroLineColor: "#6c757d"}
            }]
        }
    };

    const sendRequest = (range) => {
        selectedRange.hide();
        errorAlert.hide();
        loader.show();

        paymentsAmount.hide();
        paymentsChart.hide();

        ajaxRequest(url, 'POST', {range})
            .then((response)  => {
                paymentsAmount.text(response.amount);

                let amount = [];
                let labels = [];

                response.data.forEach(function (chart) {
                    amount.push(chart.amount);
                    labels.push(chart.label);
                });

                if (chart) chart.destroy();
                chart = new Chart(paymentsChart, {
                    type: 'line',
                    options: charOptions,
                    data: {
                        labels,
                        datasets: [
                            {
                                data: amount,
                                borderColor: "#FF922A",
                                backgroundColor: "#FF922A33",
                                borderWidth: 1,
                            }
                        ]
                    }
                });

                paymentsAmount.show();
                paymentsChart.show();
            })
            .catch((error) => {
                errorAlert.show();
                console.log({error});
            })
            .finally(() => {
                loader.hide();
                selectedRange.show();
            });
    }

    sendRequest(selectedRange.data('range'));

    $('.payments-range').click((e) => {
        const item = $(e.target);
        selectedRange.text(item.text());
        sendRequest(item.data('range'));
    });

})(window, document, jQuery);
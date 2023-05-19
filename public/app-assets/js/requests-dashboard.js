(function (window, document, $) {
    'use strict';

    const selectedRange = $('#requests-selected-range');
    const errorAlert = $('#requests-error-alert');
    const loader = $('.requests-loader');
    let chart = null;

    const successfulRequestsPercentage = $('#successful-requests-percentage');
    const failedRequestsPercentage = $('#failed-requests-percentage');
    const successfulRequests = $('#successful-requests');
    const failedRequests = $('#failed-requests');
    const requestsChart = $('#requests-chart');
    const url = requestsChart.data('url');

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

        successfulRequestsPercentage.hide();
        failedRequestsPercentage.hide();
        successfulRequests.hide();
        failedRequests.hide();
        requestsChart.hide();

        ajaxRequest(url, 'POST', {range})
            .then((response)  => {
                successfulRequestsPercentage.css('width', `${response.success.percentage}%`);
                failedRequestsPercentage.css('width', `${response.failed.percentage}%`);
                successfulRequests.text(response.success.value);
                failedRequests.text(response.failed.value);

                let success = [];
                let failed = [];
                let labels = [];

                response.data.forEach(function (chart) {
                    success.push(chart.success);
                    failed.push(chart.failed);
                    labels.push(chart.label);
                });

                if (chart) chart.destroy();
                chart = new Chart(requestsChart, {
                    type: 'line',
                    options: charOptions,
                    data: {
                        labels,
                        datasets: [
                            {
                                data: success,
                                borderColor: "#24B263",
                                backgroundColor: "#24B26333",
                                borderWidth: 1,
                            },
                            {
                                data: failed,
                                borderColor: "#EA5455",
                                backgroundColor: "#EA545533",
                                borderWidth: 1,
                            },
                        ]
                    }
                });

                successfulRequestsPercentage.show();
                failedRequestsPercentage.show();
                successfulRequests.show();
                failedRequests.show();
                requestsChart.show();
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

    $('.requests-range').click((e) => {
        const item = $(e.target);
        selectedRange.text(item.text());
        sendRequest(item.data('range'));
    });

})(window, document, jQuery);
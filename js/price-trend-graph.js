function calculateFuturePrice(prevAvgPrices, years) {
    var arrLength = prevAvgPrices.length; //all parameters are the same length
    var totalDifferences = 0;

    //calculate increases and decreases in price over the year
    for (i = arrLength - 1; i > 0; i--) {
        totalDifferences = prevAvgPrices[i].y - prevAvgPrices[i - 1].y + totalDifferences;
    }
    var averageDifference = totalDifferences / (arrLength - 1);
    var predictedPrice = Math.round(prevAvgPrices[arrLength - 1].y + averageDifference);

    //put price in correct data format for graph
    // x is the label name ie the year, y is the price value
    var predictedPriceCoordinates = [];
    //need to add null values here, so that years in tooltips match 2017 and 2018, else uses earliest  years
    for (i = 0; i < arrLength-1; i++)
    {
        predictedPriceCoordinates.push(
            {
                x: years[i],
                y: null
            }
        );
    }
    //add price for latest year in data for estimation graph line
    predictedPriceCoordinates.push(prevAvgPrices[arrLength-1]);
    //add estimated price data for 2018
    predictedPriceCoordinates.push(
        {
            x: "2018",
            y: predictedPrice
        }
    );
    return predictedPriceCoordinates;
}

function generateGraph(dataRows) {

    //data rows passed in already sorted by year through SQL query
    var years = [];
    var avgTotal = [];
    var avgCovered = [];
    var avgMedicare = [];

    for (let row of dataRows) {
        years.push(row.year);
        avgTotal.push(
            {
                x: row.year,
                y: Math.round(row.averageTotalPayments)
            });
        avgCovered.push(
            {
                x: row.year,
                y: Math.round(row.averageCoveredCharges)
            });
        avgMedicare.push(
            {
                x: row.year,
                y: Math.round(row.averageMedicarePayments)
            });
    }

    let graphDataSet = [
        {
            data: avgTotal,
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#2471a3',
            borderWidth: 4,
            pointBackgroundColor: '#2471a3',
            label: 'Average Total Payments'
        },
        {
            data: avgCovered,
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#8e44ad',
            borderWidth: 4,
            pointBackgroundColor: '#8e44ad',
            label: 'Average Covered Charges'
        },
        {
            data: avgMedicare,
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#52be80',
            borderWidth: 4,
            pointBackgroundColor: '#52be80',
            label: 'Average Medicare Payments'
        }
    ];

    let graphTitle = 'Price Trends between ' + years[0] + ' - ' + years[years.length - 1];

    if (years.length <= 2) {
        //insufficient data, can't make appropriate estimation
    } else {
        //calculate estimated data
        let estimatedAvgTotal = calculateFuturePrice(avgTotal, years);
        let estimatedAvgCovered = calculateFuturePrice(avgCovered, years);
        let estimatedAvgMedicare = calculateFuturePrice(avgMedicare, years);
        //add extra year (for x-axis labels)
        years.push("2018");

        //set estimate data in correct format for graph
        var dataEstimatedAvgTotal =
            {
                data: estimatedAvgTotal,
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#2471a3',
                borderWidth: 4,
                borderDash: [5, 5],
                pointBackgroundColor: '#2471a3',
                label: 'Estimated Avg. Total Payments'
            };
        let dataEstimatedAvgCovered =
            {
                data: estimatedAvgCovered,
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#8e44ad',
                borderWidth: 4,
                borderDash: [5, 5],
                pointBackgroundColor: '#8e44ad',
                label: 'Estimated Covered Charges'
            };
        let dataEstimatedAvgMedicare =
            {
                data: estimatedAvgMedicare,
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#52be80',
                borderWidth: 4,
                borderDash: [5, 5],
                pointBackgroundColor: '#52be80',
                label: 'Estimated Medicare Payments'
            };

        graphDataSet.push(dataEstimatedAvgTotal);
        graphDataSet.push(dataEstimatedAvgCovered);
        graphDataSet.push(dataEstimatedAvgMedicare);

        //append to title
        graphTitle += ' and an Estimated Price for 2018'
    }

    //generate graph
    var ctx = document.getElementById("trendGraph");
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: graphDataSet
        },
        options: {
            title: {
                display: true,
                text: graphTitle,
                fontSize: 25
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: true,
                onHover: function (event, legendItem) {
                    document.getElementById("trendGraph").style.cursor = 'pointer';
                },
                onLeave: function (event, legendItem) {
                    document.getElementById("trendGraph").style.cursor = 'default';
                },
                labels: {
                    fontSize: 15
                },
                position: 'bottom'
            },
            tooltips: {
                custom: function (tooltip) {
                    document.getElementById("trendGraph").style.cursor = 'default';
                    return;
                }
            }
        }
    });
}

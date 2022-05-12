// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");

let chartRevenueData = [];

const chartDataRevenueObj = ctx?.getAttribute('data-revenue') ? JSON.parse(ctx.getAttribute('data-revenue')) : null;

let offlineData = 0;
let onlineData  = 0;
let totalData   = 0;

if (chartDataRevenueObj){
    offlineData = chartDataRevenueObj?.offline?.total_yearly_sold_qty ?? 0; 
    onlineData  = chartDataRevenueObj?.online?.total_yearly_order_qty ?? 0; 
    totalData   = Number(offlineData) + Number(onlineData);
}

// console.log(chartDataRevenueObj, offlineData, onlineData);
let offlinePercentage= Math.round((100 * offlineData) / totalData);
let onlinePercentage = Math.round((100 * onlineData) / totalData);

console.log(onlinePercentage, totalData);

var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Online Sale", "Offline Sale"],
        datasets: [{
            // data: [onlineData, offlineData],
            data: [onlinePercentage, offlinePercentage],
            backgroundColor: ['#4e73df', '#1cc88a'],
            hoverBackgroundColor: ['#2e59d9', '#17a673'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function (tooltipItem, chart) {
                    var currentLabel = chart.labels[tooltipItem.index] ?? '';
                    var currentData = chart.datasets[tooltipItem.datasetIndex]['data'][tooltipItem.index] || '';
                    return `${currentLabel} : ` + currentData + `%`;
                },
                beforeLabel: function (context, chart){
                    // console.log(chart);
                    return 'Revenue Source';
                }
            }
        },
        legend: {
            display: true,
            position: 'bottom'
        },
        cutoutPercentage: 80,
        title: {
            display: true,
            text: 'Online & Offline Sale Percentage'
        }
    },
});
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-financial"></script>
    <title>Bitcoin Recommendation System</title>
    <style>
        .chart-container {
            width: 100%;
            height: 500px;
        }
        .mt-4-custom {
            margin-top: 1rem;
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Bitcoin Recommendation System</h1>

        <a href="/recommendations" class="block mt-4-custom text-center w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Get Buy Recommendations Now
        </a>

        <div class="mb-6">
            <label for="timePeriod" class="block text-lg font-medium mb-2">Select Time Period:</label>
            <select id="timePeriod" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="30">1 Month</option>
                <option value="90">3 Months</option>
                <option value="180">6 Months</option>
                <option value="365" selected>1 Year</option>
                <option value="100000">All Time</option>
            </select>
        </div>

        <div class="mt-6">
            <h2 class="font-bold text-lg">Bitcoin Price Plot:</h2>
            <div id="chart" class="chart-container mt-2 rounded-md shadow-md"></div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chartContainer = document.getElementById('chart');
                const chart = LightweightCharts.createChart(chartContainer, {
                    width: chartContainer.offsetWidth,
                    height: 500,
                    layout: {
                        backgroundColor: '#ffffff',
                        textColor: 'rgba(33, 56, 77, 1)',
                    },
                    grid: {
                        vertLines: {
                            color: 'rgba(197, 203, 206, 0.5)',
                        },
                        horzLines: {
                            color: 'rgba(197, 203, 206, 0.5)',
                        },
                    },
                    crosshair: {
                        mode: LightweightCharts.CrosshairMode.Normal,
                    },
                    rightPriceScale: {
                        borderColor: 'rgba(197, 203, 206, 1)',
                    },
                    timeScale: {
                        borderColor: 'rgba(197, 203, 206, 1)',
                    },
                    watermark: {
                        visible: false,
                    }
                });
        
                const candleSeries = chart.addCandlestickSeries({
                    upColor: '#26a69a',
                    downColor: '#ef5350',
                    borderVisible: false,
                    wickUpColor: '#26a69a',
                    wickDownColor: '#ef5350',
                });
        
                async function fetchData(days) {
                    const response = await fetch(`http://127.0.0.1:5000/bitcoin_price?days=${days}`);
                    const data = await response.json();
        
                    return data.map(item => ({
                        time: item.date,
                        open: item.open,
                        high: item.high,
                        low: item.low,
                        close: item.close
                    }));
                }
        
                async function updateChart(days) {
                    const data = await fetchData(days);
                    candleSeries.setData(data);
                }
        
                updateChart(365);
        
                const timePeriodSelect = document.getElementById('timePeriod');
                timePeriodSelect.addEventListener('change', function () {
                    const days = timePeriodSelect.value;
                    updateChart(days);
                });
        
                window.addEventListener('resize', function() {
                    chart.applyOptions({ width: chartContainer.offsetWidth });
                });
            });
        </script>

        <a href="/forecast" class="block mt-4 text-center w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Get Bitcoin Forecast
        </a>

    </div>


    

</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/1.2.1/chartjs-plugin-zoom.min.js"></script>

<script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>

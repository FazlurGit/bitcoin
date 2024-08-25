<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitcoin Recommendation System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .recommendation-card {
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .recommendation-card h2 {
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Bitcoin Recommendation System</h1>

        @isset($recommendation)
            <div class="recommendation-card bg-green-100 text-green-800">
                <h2 class="font-bold text-xl mb-2">Recommendation:</h2>
                <div class="flex items-start mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m3.9-12.5a9 9 0 11-1.8 0A10.5 10.5 0 014.2 14.8M6 18a4 4 0 111.5-2.8m11 0A4 4 0 1119.6 16M16 6a4 4 0 01.8-1.6A9 9 0 0112 4a4 4 0 014 4z"/>
                    </svg>
                    <p class="text-lg font-semibold">{{ $recommendation }}</p>
                </div>
                <p class="text-gray-700 mb-4">{{ $reason }}</p>
                <div class="grid grid-cols-2 gap-4 text-gray-800">
                    <div class="flex items-center">
                        <span class="font-semibold mr-2">Current Price:</span>
                        <span>$ {{ number_format($currentPrice, 2) }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold mr-2">MA50:</span>
                        <span>$ {{ number_format($ma50, 2) }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold mr-2">MA200:</span>
                        <span>$ {{ number_format($ma200, 2) }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold mr-2">Date:</span>
                        <span>{{ $date }}</span>
                    </div>
                </div>
            </div>
        @else
            <p class="text-red-600 text-center">No recommendation data available.</p>
        @endisset

        <div class="mt-6 text-center">
            <a href="/" class="inline-block bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out">Back to Home</a>
        </div>
    </div>
</body>
</html>

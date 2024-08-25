<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Alerts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold mb-8 text-center text-indigo-600">Price Alerts</h1>

        <!-- Price alerts list -->
        @if(isset($alerts) && count($alerts) > 0)
            <ul class="list-disc pl-5">
                @foreach($alerts as $alert)
                    <li class="mb-3 flex justify-between text-lg">
                        <span class="font-semibold">Alert for ${{ number_format($alert['price'], 2) }}</span>
                        <span>{{ $alert['status'] }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-red-600 text-center text-lg">No price alerts set.</p>
        @endif

        <!-- Set/remove alert form -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Set/Remove Price Alert</h2>
            <form action="/price-alerts/set" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="alertPrice" class="block text-lg font-medium">Price to Alert:</label>
                    <input type="number" id="alertPrice" name="price" class="p-2 border border-gray-300 rounded-lg" step="0.01" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700">Set Alert</button>
            </form>

            <form action="/price-alerts/remove" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="removeAlertPrice" class="block text-lg font-medium">Price to Remove Alert:</label>
                    <input type="number" id="removeAlertPrice" name="price" class="p-2 border border-gray-300 rounded-lg" step="0.01" required>
                </div>
                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-red-700">Remove Alert</button>
            </form>
        </div>

        <!-- Back button -->
        <div class="mt-8 text-center">
            <a href="/" class="inline-block bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out">Back to Home</a>
        </div>
    </div>
</body>
</html>

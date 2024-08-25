<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Price Alerts</title>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold mb-8 text-center text-indigo-600">Price Alerts</h1>

        <!-- Set Price Alert -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Set Price Alert</h2>
            <form action="/set-alert" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="alertPrice" class="block text-lg font-medium mb-2">Price Alert Threshold</label>
                    <input type="number" id="alertPrice" name="alertPrice" class="p-2 border border-gray-300 rounded-lg w-full" step="0.01" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700">Set Alert</button>
            </form>
        </div>

        <!-- Back button -->
        <div class="mt-8 text-center">
            <a href="/" class="inline-block bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out">Back to Home</a>
        </div>
    </div>
</body>
</html>

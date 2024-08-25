<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold mb-8 text-center text-indigo-600">Your Portfolio</h1>

        <!-- Portfolio list -->
        @if(isset($portfolio) && count($portfolio) > 0)
            <ul class="list-disc pl-5">
                @foreach($portfolio as $item)
                    <li class="mb-3 flex justify-between text-lg">
                        <span class="font-semibold">{{ $item['name'] }}</span>
                        <span>${{ number_format($item['value'], 2) }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-red-600 text-center text-lg">No assets in portfolio.</p>
        @endif

        <!-- Add/remove form -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Add/Remove Asset</h2>
            <form action="/portfolio/add" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium">Asset Name:</label>
                    <input type="text" id="name" name="name" class="p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="value" class="block text-lg font-medium">Asset Value:</label>
                    <input type="number" id="value" name="value" class="p-2 border border-gray-300 rounded-lg" step="0.01" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700">Add Asset</button>
            </form>

            <form action="/portfolio/remove" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="removeName" class="block text-lg font-medium">Asset Name to Remove:</label>
                    <input type="text" id="removeName" name="name" class="p-2 border border-gray-300 rounded-lg" required>
                </div>
                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-red-700">Remove Asset</button>
            </form>
        </div>

        <!-- Back button -->
        <div class="mt-8 text-center">
            <a href="/" class="inline-block bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out">Back to Home</a>
        </div>
    </div>
</body>
</html>

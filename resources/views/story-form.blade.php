<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* No Glass Effect, Simple Design */
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white flex items-center justify-center">

    <!-- Card Container -->
    <div class="w-full max-w-lg p-8 bg-opacity-80 bg-gray-800 rounded-lg shadow-xl">
        <!-- Title -->
        <h2 class="text-3xl font-semibold text-center mb-6 text-blue-300">
            Generate Your Story
        </h2>

        <!-- Form -->
        <form action="/generate-story" method="POST" class="space-y-6">
            @csrf
            <!-- Book Name -->
            <div>
                <label for="bookName" class="block text-sm font-medium mb-2 text-gray-300">Book Name</label>
                <input type="text" id="bookName" name="bookName" placeholder="Enter book name"
                    class="w-full px-4 py-3 rounded-md bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    autocomplete="off">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium mb-2 text-gray-300">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Enter a brief description"
                    class="w-full px-4 py-3 rounded-md bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    autocomplete="off"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition duration-200 ease-in-out focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-md">
                    Generate Story
                </button>
            </div>
        </form>
    </div>

</body>
</html>

<?php
require 'navbar.php';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>About Us</title>
</head>
<body class="bg-gray-50 text-gray-800">

    <header class="bg-blue-500 text-white py-8">
        <div class="container mx-auto text-center">
            <h1 class="text-3xl font-bold">About Us</h1>
            <p class="mt-1 text-base opacity-75">Our mission and values</p>
        </div>
    </header>
    <main class="container mx-auto mt-8 px-4 space-y-10">
        <section class="p-4 border-l-4 border-blue-500 bg-white shadow-sm">
            <h2 class="text-xl font-semibold text-blue-600">Our Mission</h2>
            <p class="text-gray-600 mt-2">
                We are committed to creating content that inspires, educates, and entertains our audience. Our mission is to make a positive impact on readers’ lives.
            </p>
        </section>

        <section class="p-4 border-l-4 border-blue-500 bg-white shadow-sm">
            <h2 class="text-xl font-semibold text-blue-600">What We Offer</h2>
            <p class="text-gray-600 mt-2">
                From informative articles to engaging stories, we cover a range of topics to cater to all interests and provide unique insights.
            </p>
        </section>
        <section class="p-4 border-l-4 border-blue-500 bg-white shadow-sm">
            <h2 class="text-xl font-semibold text-blue-600">Meet the Team</h2>
            <div class="flex flex-col md:flex-row justify-center gap-6 mt-6">
                <div class="text-center">
                    <img src="image/IMG_0704.jpg" alt="Team Member 1" class="w-24 h-24 rounded-full mx-auto border-2 border-blue-500">
                    <h3 class="text-lg font-semibold mt-2">Kareem</h3>
                    <p class="text-blue-500 text-sm">Editor-in-Chief</p>
                </div>
            </div>
        </section>
    </main>

    <?php require 'footer.php'; ?>
</body>
</html>

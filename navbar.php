<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Navbar</title>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex items-center">
                <a href="index.php" class="text-2xl font-extrabold text-blue-600 transition-transform transform hover:scale-105">Generous</a>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="index.php" class="text-gray-700 hover:text-blue-600 transition duration-300">Home</a>
                <a href="create.php" class="text-gray-700 hover:text-blue-600 transition duration-300">Blog</a>
                <a href="about.php" class="text-gray-700 hover:text-blue-600 transition duration-300">About</a>
            </div>
            <div class="space-x-4 flex items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold">
                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                    </span>
                    <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Login</a>
                    <a href="register.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition duration-300">Register</a>
                <?php endif; ?>
            </div>
            <button class="md:hidden text-gray-700 focus:outline-none" id="menu-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </nav>
    <div class="md:hidden">
        <div id="mobile-menu" class="hidden bg-white shadow-md">
            <a href="index.php" class="block text-gray-700 hover:text-blue-600 py-2 px-4">Home</a>
            <a href="create.php" class="block text-gray-700 hover:text-blue-600 py-2 px-4">Blog</a>
            <a href="about.php" class="block text-gray-700 hover:text-blue-600 py-2 px-4">About</a>
        </div>
    </div>
    <script>
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>

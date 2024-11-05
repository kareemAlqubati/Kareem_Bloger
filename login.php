<?php
include 'config.php'; 
require 'navbar.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $username; 
            header("Location: index.php");
            exit; 
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "No user found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <nav class="w-full">
        <div class="max-w-md w-full bg-white shadow-lg rounded-xl p-8 mt-32 mx-auto">
            <h2 class="text-3xl font-extrabold text-center text-blue-600 mb-8">Welcome Back!</h2>
            <form method="POST" action="login.php">
                <div class="mb-5">
                    <label for="username" class="block text-gray-800 text-sm font-semibold mb-2">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300" />
                </div>
                <div class="mb-5">
                    <label for="password" class="block text-gray-800 text-sm font-semibold mb-2">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300" />
                </div>
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 rounded-lg w-full hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                    Login
                </button>
            </form>
            <?php if (isset($error_message)): ?>
                <p class="text-red-600 text-center mt-4"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <p class="text-center text-gray-600 text-sm mt-4">
                Don't have an account? 
                <a href="register.php" class="text-blue-600 hover:text-blue-800 transition duration-300 font-semibold">Sign up</a>
            </p>
        </div>
    </nav>  
</body>
</html>

<?php
include 'config.php'; 
require 'navbar.php';

$errorMessages = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $role = 'author'; 
    if (empty($username)) {
        $errorMessages[] = "Username is required.";
    } elseif (strlen($username) < 10) {
        $errorMessages[] = "Username must be at least 10 characters long.";
    }
    if (empty($email)) {
        $errorMessages[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errorMessages[] = "Password is required.";
    } elseif (strlen($password) < 15) {
        $errorMessages[] = "Password must be at least 15 characters long.";
    }
    if (empty($errorMessages)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $errorMessages[] = "Error preparing the SQL statement: " . $conn->error;
        } else {
            $stmt->bind_param("ssss", $username, $email, $passwordHash, $role);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['role'] = $role;
                $_SESSION['username'] = $username; 
                header("Location: index.php");
                exit();

            } else {
                $errorMessages[] = "Error: " . $stmt->error;
            }
            $stmt->close(); 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Register</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container mx-auto">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-8 mt-32">
            <h2 class="text-3xl font-bold text-center mb-6 text-blue-600">Create an Account</h2>
            <?php if (!empty($errorMessages)): ?>
                <div class="mb-4">
                    <?php foreach ($errorMessages as $error): ?>
                        <p class="text-red-500"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="register.php">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required class="border border-gray-300 p-3 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your Email" required class="border border-gray-300 p-3 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required class="border border-gray-300 p-3 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded w-full hover:bg-blue-700 transition duration-200">Register</button>
            </form>
            <p class="text-center text-gray-600 text-sm mt-4">
                Already have an account? 
                <a href="login.php" class="text-blue-500 hover:text-blue-700">Login</a>
            </p>
        </div>
    </div>
</body>
</html>

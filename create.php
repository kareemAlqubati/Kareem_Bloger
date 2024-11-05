<?php
include 'config.php';
require 'navbar.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];
    $category_id = $_POST['category_id'];
    $imageName = '';
    $uploadDir = 'uploads/';

    if (empty($category_id)) {
        echo "<p class='text-red-600 text-center'>Please select a category.</p>";
        exit; 
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $destPath = $uploadDir . $imageName;

        if (move_uploaded_file($imageTmpPath, $destPath)) {
            echo "<p class='text-green-600 text-center'>Image uploaded successfully!</p>";
        } else {
            echo "<p class='text-red-600 text-center'>Error uploading image.</p>";
        }
    }

    $sql = "INSERT INTO posts (title, content, author_id, category_id, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $title, $content, $author_id, $category_id, $imageName);

    if ($stmt->execute()) {
        echo "<p class='text-green-600 text-center'>Post created successfully!</p>";
    } else {
        echo "<p class='text-red-600 text-center'>Error: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Create a New Post</title>
</head>
<body class="bg-gray-50 text-gray-800">
    
<div class="container mx-auto mt-10">
    <h1 class="text-4xl font-extrabold text-center text-blue-600 mb-8">Create a New Post</h1>
    <form method="POST" action="create.php" enctype="multipart/form-data" class="bg-white max-w-2xl mx-auto p-8 rounded-lg shadow-lg">
        <div class="mb-6">
            <label for="title" class="block text-gray-700 text-sm font-medium mb-2">Post Title</label>
            <input type="text" name="title" id="title" placeholder="Enter post title" required class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div class="mb-6">
            <label for="content" class="block text-gray-700 text-sm font-medium mb-2">Post Content</label>
            <textarea name="content" id="content" placeholder="Write your content here..." required class="border border-gray-300 p-3 rounded-lg w-full h-40 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>
        <div class="mb-6">
            <label for="category" class="block text-gray-700 text-sm font-medium mb-2">Select Category</label>
            <select name="category_id" id="category" required class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" disabled selected>Select a category</option>
                <?php
                $categories = $conn->query("SELECT * FROM categories");
                while ($category = $categories->fetch_assoc()) {
                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-6">
            <label for="image" class="block text-gray-700 text-sm font-medium mb-2">Upload Image</label>
            <input type="file" name="image" id="image" class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200">Create Post</button>
    </form>
</div>
<?php require 'footer.php'; ?>
</body>
</html>

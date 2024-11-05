<?php
include 'config.php';
require 'navbar.php';

if (!isset($_POST['post_id'])) {
    echo "Invalid request: post_id not set.";
    header("Location: index.php");
    exit();
}
$post_id = $_POST['post_id'];
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "Post not found.";
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Post</title>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto my-10 max-w-2xl">
        <h1 class="text-4xl font-extrabold text-center text-blue-600 mb-8">Edit Your Post</h1>
        <form method="POST" action="update.php" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg space-y-6">
            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">            
            <div>
                <label for="title" class="block text-lg font-medium mb-2">Post Title</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($post['title']); ?>" required class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter post title" />
            </div>
            <div>
                <label for="content" class="block text-lg font-medium mb-2">Post Content</label>
                <textarea name="content" id="content" required class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 h-48 resize-none" placeholder="Write your content here..."><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <div>
                <label for="category" class="block text-lg font-medium mb-2">Select Category</label>
                <select name="category_id" id="category" required class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled>Select a category</option>
                    <?php
                    $categories = $conn->query("SELECT * FROM categories");
                    while ($category = $categories->fetch_assoc()) {
                        $selected = ($category['id'] == $post['category_id']) ? 'selected' : '';
                        echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="image" class="block text-lg font-medium mb-2">Upload Image</label>
                <input type="file" name="image" id="image" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200">Update Post</button>
        </form>
    </div>
    <?php require 'footer.php'; ?>
</body>
</html>

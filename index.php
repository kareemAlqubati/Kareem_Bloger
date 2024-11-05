<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';
require 'navbar.php';

$sql = "SELECT posts.id, posts.title, posts.content, posts.created_at, posts.image, users.username, categories.name AS category_name 
        FROM posts 
        JOIN users ON posts.author_id = users.id 
        JOIN categories ON posts.category_id = categories.id 
        ORDER BY posts.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Blog</title>
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="bg-blue-600 text-white py-11 ">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-extrabold">مرحبًا بك في مدونة كريم</h1>
            <p class="mt-2 text-lg opacity-90">اكتشف مقالات مثيرة ومواضيع متنوعة!</p>
            <img src="image/5396346.jpg" alt="Welcome Image" class="mt-6 mx-auto rounded-lg shadow-lg" style="max-width: 300px;">
        </div>
    </header>
    <main class="container mx-auto py-10 px-4 lg:px-0 ">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mx-8">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($post = $result->fetch_assoc()) {
                    ?>
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                        <?php if (!empty($post['image'])): ?>
                            <img src="<?php echo htmlspecialchars('uploads/' . $post['image']); ?>" class="w-full h-56 object-cover rounded mb-4">
                        <?php endif ?>
                        <h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?></p>
                        <p class="text-sm text-gray-500 mb-2">Category: <span class="text-blue-600"><?php echo htmlspecialchars($post['category_name']); ?></span></p>
                        <p class="text-sm text-gray-500 mb-4">By <span class="font-semibold"><?php echo htmlspecialchars($post['username']); ?></span> on <?php echo date('d M Y', strtotime($post['created_at'])); ?></p>
                        <a href="post.php?id=<?php echo $post['id']; ?>" class="text-blue-600 font-semibold hover:underline">Read More</a>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center text-gray-700'>لا توجد منشورات.</p>";
            }
            ?>
        </div>
    </main>

    <?php require 'footer.php'; ?>
</body>
</html>

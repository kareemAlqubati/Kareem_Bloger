<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';
require 'navbar.php';

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);

    if ($conn) {
        $sql = "SELECT posts.title, posts.content, posts.created_at, posts.author_id, posts.image, users.username, categories.name AS category_name 
                FROM posts 
                JOIN users ON posts.author_id = users.id 
                JOIN categories ON posts.category_id = categories.id 
                WHERE posts.id = ?";
        
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $post = $result->fetch_assoc();
            } else {
                echo "<p class='text-center'>لا توجد منشورات بهذه الهوية.</p>";
                exit();
            }
        } 
    } 
} 

$is_author = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['author_id'];
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>
<body class="bg-gray-100">

    <main class="container mx-auto mt-6">
        <div class="bg-white p-6 rounded-lg shadow-lg flex">
            <?php if (!empty($post['image'])): ?>
                <div class="w-1/3 pr-4">
                    <img src="<?php echo htmlspecialchars('uploads/' . $post['image']); ?>" class="w-full h-auto rounded-lg object-cover">
                </div>
            <?php endif; ?>
            <div class="<?php echo !empty($post['image']) ? 'w-2/3' : 'w-full'; ?>">
                <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($post['title']); ?></h1>
                <p class="text-gray-700 mb-2">Category: <span class="font-semibold"><?php echo htmlspecialchars($post['category_name']); ?></span></p>
                <p class="text-gray-600 mb-2"><small>by <?php echo htmlspecialchars($post['username']); ?> at <?php echo date('d M Y', strtotime($post['created_at'])); ?></small></p>
                <p class="mt-4 text-gray-800"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

                <?php if ($is_author || $is_admin): ?>
                    <div class="flex gap-4 mt-6">
                        <form action="edit.php" method="POST">
                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit Post</button>
                        </form>
                        <form action="delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete Post</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p class="text-center text-red-500">You do not have permission to edit or delete this post.</p>
                <?php endif; ?>

                <a href="index.php" class="text-blue-500 hover:underline mt-4 block">Back to Home</a>
            </div>
        </div>
    </main>
    <?php require 'footer.php'; ?>
</body>
</html>

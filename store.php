<?php
    include 'config.php';

    $sql = "SELECT posts.*, users.username, categories.name AS category_name FROM posts 
            JOIN users ON posts.author_id = users.id
            JOIN categories ON posts.category_id = categories.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($post = $result->fetch_assoc()) {
            echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
            echo "<p>" . htmlspecialchars($post['content']) . "</p>";
            echo "<p>By: " . htmlspecialchars($post['username']) . " in " . htmlspecialchars($post['category_name']) . "</p>";
        }
    } else {
        echo "<p>No posts found.</p>";
    }
?>

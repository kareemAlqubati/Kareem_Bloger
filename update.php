<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && isset($_POST['post_id']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category_id'])) {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];  
    $uploadDir = 'uploads/';
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $originalImageName = basename($_FILES['image']['name']);
        $imageName = time() . '_' . $originalImageName; 
        $destination = $uploadDir . $imageName;

        if (!move_uploaded_file($imageTmpPath, $destination)) {
            echo "Error uploading image.";
            exit();
        }
    }
    if ($imageName) {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, image = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("sssii", $title, $content, $imageName, $category_id, $post_id);
    } else {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $title, $content, $category_id, $post_id);
    }
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating post.";
    }
} else {
    echo "Invalid request.";
}
?>

<?php
// comments.php - Gestión de comentarios

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $comment_content = trim($_POST['comment_content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($comment_content)) {
        $query = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $post_id, $user_id, $comment_content);
        $stmt->execute();
    }
}

header("Location: posts.php");
exit;
?>

<?php
// posts.php - Gestión de publicaciones

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'config/db.php';

$user_id = $_SESSION['user_id'];

// Crear nueva publicación
if (isset($_POST['create_post'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $error = "El título y el contenido son obligatorios.";
    } else {
        $query = "INSERT INTO posts (author_id, title, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $user_id, $title, $content);

        if ($stmt->execute()) {
            $success = "Publicación creada con éxito.";
        } else {
            $error = "Ocurrió un error al crear la publicación.";
        }
    }
}

// Obtener publicaciones
$query = "
    SELECT p.id, p.title, p.content, p.created_at, u.username, u.avatar,
           (SELECT COUNT(*) FROM likes WHERE likes.post_id = p.id) AS likes_count,
           (SELECT COUNT(*) FROM comments WHERE comments.post_id = p.id) AS comments_count
    FROM posts p
    JOIN users u ON p.author_id = u.id
    ORDER BY p.created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones - FC Barcelona</title>
    <link rel="stylesheet" href="styles/posts.css">
</head>
<body>
    <header class="posts-header">
        <h1>Publicaciones</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>

    <main class="posts-main">
        <section id="create-post">
            <h2>Crear Nueva Publicación</h2>
            <?php if (isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="success-message"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form action="posts.php" method="POST" class="create-post-form">
                <div>
                    <label for="title">Título:</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div>
                    <label for="content">Contenido:</label>
                    <textarea id="content" name="content" rows="5" required></textarea>
                </div>

                <div>
                    <button type="submit" name="create_post">Publicar</button>
                </div>
            </form>
        </section>

        <section id="posts-list">
            <h2>Publicaciones Recientes</h2>
            <?php while ($post = $result->fetch_assoc()): ?>
                <article class="post">
                    <h3><?= htmlspecialchars($post['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    <p><small><img src="<?= htmlspecialchars($post['avatar']) ?>" alt="Avatar" class="avatar"> Por <?= htmlspecialchars($post['username']) ?> el <?= htmlspecialchars($post['created_at']) ?></small></p>
                    <div class="post-actions">
                        <form action="likes.php" method="POST" class="like-form">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <button type="submit" name="like_post">👍 Me gusta (<?= htmlspecialchars($post['likes_count']) ?>)</button>
                        </form>
                        <button onclick="toggleCommentForm(<?= $post['id'] ?>)">💬 Comentar (<?= htmlspecialchars($post['comments_count']) ?>)</button>
                    </div>
                    <section class="comments" id="comments-<?= $post['id'] ?>" style="display: none;">
                        <h4>Comentarios:</h4>

                        <!-- Cargar comentarios existentes -->
                        <?php
                        $comment_query = "SELECT c.content, u.username, u.avatar, c.created_at 
                                          FROM comments c 
                                          JOIN users u ON c.user_id = u.id 
                                          WHERE c.post_id = ? 
                                          ORDER BY c.created_at ASC";
                        $comment_stmt = $conn->prepare($comment_query);
                        $comment_stmt->bind_param("i", $post['id']);
                        $comment_stmt->execute();
                        $comment_result = $comment_stmt->get_result();
                        ?>

                        <?php while ($comment = $comment_result->fetch_assoc()): ?>
                            <div class="comment">
                                <p><small><img src="<?= htmlspecialchars($comment['avatar']) ?>" alt="Avatar" class="avatar"> <?= nl2br(htmlspecialchars($comment['content'])) ?></small></p>
                                <p><small>Por <?= htmlspecialchars($comment['username']) ?> el <?= htmlspecialchars($comment['created_at']) ?></small></p>
                            </div>
                        <?php endwhile; ?>

                        <form action="comments.php" method="POST" class="comment-form">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <textarea name="comment_content" rows="2" placeholder="Escribe un comentario..." required></textarea>
                            <button type="submit">Comentar</button>
                        </form>
                    </section>
                </article>
            <?php endwhile; ?>
        </section>
    </main>

    <footer class="posts-footer">
        <p>&copy; 2024 FC Barcelona. Todos los derechos reservados.</p>
    </footer>

    <script>
        function toggleCommentForm(postId) {
            var commentSection = document.getElementById('comments-' + postId);
            if (commentSection.style.display === 'none') {
                commentSection.style.display = 'block';
            } else {
                commentSection.style.display = 'none';
            }
        }
    </script>
</body>
</html>

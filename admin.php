<?php
// admin.php - Panel de Administración

session_start();
require_once 'config/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Funcionalidades de administración

// Deshabilitar cuenta de usuario
if (isset($_POST['disable_user'])) {
    $user_id = $_POST['user_id'];
    $query = "UPDATE users SET status = 'disabled' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Habilitar cuenta de usuario
if (isset($_POST['enable_user'])) {
    $user_id = $_POST['user_id'];
    $query = "UPDATE users SET status = 'active' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Convertir usuario a administrador
if (isset($_POST['make_admin'])) {
    $user_id = $_POST['user_id'];
    $query = "UPDATE users SET role = 'admin' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Eliminar publicación
if (isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];
    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
}

// Eliminar comentario
if (isset($_POST['delete_comment'])) {
    $comment_id = $_POST['comment_id'];
    $query = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
}

// Cambiar contraseña de usuario
if (isset($_POST['change_password'])) {
    $user_id = $_POST['user_id'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $query = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $new_password, $user_id);
    $stmt->execute();
}

// Obtener todos los usuarios, publicaciones y comentarios
$users = $conn->query("SELECT * FROM users");
$posts = $conn->query("SELECT * FROM posts");
$comments = $conn->query("SELECT * FROM comments");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - FC Barcelona</title>
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Gestión de Usuarios</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['status']) ?></td>
                        <td>
                            <?php if ($user['status'] == 'active'): ?>
                                <form action="admin.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="disable_user">Deshabilitar</button>
                                </form>
                            <?php else: ?>
                                <form action="admin.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="enable_user">Habilitar</button>
                                </form>
                            <?php endif; ?>
                            <?php if ($user['role'] == 'user'): ?>
                                <form action="admin.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="make_admin">Convertir en Admin</button>
                                </form>
                            <?php endif; ?>
                            <button onclick="toggleChangePasswordForm(<?= $user['id'] ?>)">Cambiar Contraseña</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <div id="change-password-form" style="display:none;">
                <h3>Cambiar Contraseña</h3>
                <form action="admin.php" method="POST">
                    <input type="hidden" id="change-password-user-id" name="user_id">
                    <div class="input-group">
                        <label for="new_password">Nueva Contraseña:</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <button type="submit" name="change_password">Guardar Cambios</button>
                </form>
            </div>
        </section>

        <section>
            <h2>Gestión de Publicaciones</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($post = $posts->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($post['id']) ?></td>
                        <td><?= htmlspecialchars($post['title']) ?></td>
                        <td><?= htmlspecialchars($post['author_id']) ?></td>
                        <td><?= htmlspecialchars($post['created_at']) ?></td>
                        <td>
                            <form action="admin.php" method="POST" style="display:inline;">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <button type="submit" name="delete_post">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </section>

        <section>
            <h2>Gestión de Comentarios</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Comentario</th>
                    <th>Usuario</th>
                    <th>Publicación</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($comment = $comments->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($comment['id']) ?></td>
                        <td><?= htmlspecialchars($comment['content']) ?></td>
                        <td><?= htmlspecialchars($comment['user_id']) ?></td>
                        <td><?= htmlspecialchars($comment['post_id']) ?></td>
                        <td><?= htmlspecialchars($comment['created_at']) ?></td>
                        <td>
                            <form action="admin.php" method="POST" style="display:inline;">
                                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                <button type="submit" name="delete_comment">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 FC Barcelona. Todos los derechos reservados.</p>
    </footer>

    <script>
        function toggleChangePasswordForm(userId) {
            var form = document.getElementById('change-password-form');
            var userIdField = document.getElementById('change-password-user-id');
            userIdField.value = userId;
            form.style.display = 'block';
        }
    </script>
</body>
</html>

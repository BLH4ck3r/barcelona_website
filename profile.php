<?php
// profile.php - Editar Perfil

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'config/db.php';

$user_id = $_SESSION['user_id'];

// Obtener información del usuario
$query = "SELECT username, email, avatar FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Actualizar información del usuario
if (isset($_POST['update_profile'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $avatar = $_POST['avatar'];

    if (empty($username) || empty($email)) {
        $error = "El nombre de usuario y el correo electrónico son obligatorios.";
    } else {
        $update_query = "UPDATE users SET username = ?, email = ?, avatar = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("sssi", $username, $email, $avatar, $user_id);

        if ($update_stmt->execute()) {
            $success = "Perfil actualizado con éxito.";
        } else {
            $error = "Ocurrió un error al actualizar el perfil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - FC Barcelona</title>
    <link rel="stylesheet" href="styles/profile.css">
</head>
<body>
    <header>
        <h1>Editar Perfil</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <div class="current-avatar">
            <p>Avatar Actual:</p>
            <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar Actual">
        </div>
        <form action="profile.php" method="POST">
            <?php if (isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="success-message"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <div>
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div>
                <label>Selecciona tu avatar:</label>
                <div class="avatar-selection">
                    <label>
                        <input type="radio" name="avatar" value="images/avatar1.png" <?= $user['avatar'] == 'images/avatar1.png' ? 'checked' : '' ?>>
                        <img src="images/avatar1.png" alt="Avatar 1">
                    </label>
                    <label>
                        <input type="radio" name="avatar" value="images/avatar2.jpg" <?= $user['avatar'] == 'images/avatar2.jpg' ? 'checked' : '' ?>>
                        <img src="images/avatar2.jpg" alt="Avatar 2">
                    </label>
                    <label>
                        <input type="radio" name="avatar" value="images/avatar3.jpg" <?= $user['avatar'] == 'images/avatar3.jpg' ? 'checked' : '' ?>>
                        <img src="images/avatar3.jpg" alt="Avatar 3">
                    </label>
                    <label>
                        <input type="radio" name="avatar" value="images/avatar4.jpg" <?= $user['avatar'] == 'images/avatar4.jpg' ? 'checked' : '' ?>>
                        <img src="images/avatar4.jpg" alt="Avatar 4">
                    </label>
                </div>
            </div>
            <button type="submit" name="update_profile">Actualizar Perfil</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 FC Barcelona. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

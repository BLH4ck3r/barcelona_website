<?php
// login.php - Sistema de autenticación

session_start();
require_once 'config/db.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Consulta de autenticación
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verificar contraseña
            if (password_verify($password, $user['password'])) {
                // Verificar estado de la cuenta
                if ($user['status'] == 'disabled') {
                    $error = "La cuenta está deshabilitada.";
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    if ($user['role'] == 'admin') {
                        header("Location: admin.php");
                    } else {
                        header("Location: dashboard.php");
                    }
                    exit;
                }
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FC Barcelona</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header>
        <h1>FC Barcelona</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="register.php">Registrarse</a>
        </nav>
    </header>

    <main class="login-container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="submit-group">
                    <button type="submit" name="login">Iniciar Sesión</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 FC Barcelona. D1CKH4CK3R.</p>
    </footer>
</body>
</html>

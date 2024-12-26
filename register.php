<?php
// register.php - Sistema de registro de usuarios

session_start();
require_once 'config/db.php';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "El usuario o correo ya está en uso.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($insert_stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Ocurrió un error al registrar el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header class="header">
	<h1>REGISTRARSE</h1>
        <nav>
            <a href="index.php" class="nav-link">Inicio</a>
            <a href="login.php" class="nav-link">Iniciar Sesión</a>
        </nav>
    </header>

    <main class="main-content">
        <div class="form-container">
            <h2>Crear Cuenta</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="input-group1">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group1">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="input-group1">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="input-group1">
                    <label for="confirm_password">Confirmar Contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="submit-group">
                    <button type="submit" name="register">Registrarse</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2024 FC Barcelona. D1CKH4CK3R.</p>
    </footer>
</body>
</html>

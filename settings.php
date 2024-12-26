<?php
// settings.php - Configuración de la cuenta

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'config/db.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_settings'])) {
    // Aquí puedes manejar la lógica para actualizar la configuración de la cuenta
    $privacy = $_POST['privacy'];
    // Guardar la configuración de privacidad u otras configuraciones en la base de datos
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de la Cuenta - FC Barcelona</title>
    <link rel="stylesheet" href="styles/settings.css">
</head>
<body>
    <header>
        <h1>Configuración de la Cuenta</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <form action="settings.php" method="POST">
            <div>
                <label for="privacy">Configuración de Privacidad:</label>
                <select id="privacy" name="privacy">
                    <option value="public">Público</option>
                    <option value="private">Privado</option>
                </select>
            </div>
            <button type="submit" name="update_settings">Guardar Configuración</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 FC Barcelona. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

<?php
// dashboard.php - Panel de usuario

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'config/db.php';

$user_id = $_SESSION['user_id'];

// Obtener información del usuario, incluyendo el avatar
$query = "SELECT username, avatar FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Obtener el número de publicaciones del usuario
$post_query = "SELECT COUNT(*) AS post_count FROM posts WHERE author_id = ?";
$post_stmt = $conn->prepare($post_query);
$post_stmt->bind_param("i", $user_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();
$post_count = $post_result->fetch_assoc()['post_count'];

// Obtener el número de comentarios del usuario
$comment_query = "SELECT COUNT(*) AS comment_count FROM comments WHERE user_id = ?";
$comment_stmt = $conn->prepare($comment_query);
$comment_stmt->bind_param("i", $user_id);
$comment_stmt->execute();
$comment_result = $comment_stmt->get_result();
$comment_count = $comment_result->fetch_assoc()['comment_count'];

// Obtener el número de "me gusta" dados por el usuario actual
$like_given_query = "SELECT COUNT(*) AS like_given_count FROM likes WHERE user_id = ?";
$like_given_stmt = $conn->prepare($like_given_query);
$like_given_stmt->bind_param("i", $user_id);
$like_given_stmt->execute();
$like_given_result = $like_given_stmt->get_result();
$like_given_count = $like_given_result->fetch_assoc()['like_given_count'];

// Obtener el número de "me gusta" recibidos por las publicaciones del usuario
$like_received_query = "SELECT COUNT(*) AS like_received_count FROM likes WHERE post_id IN (SELECT id FROM posts WHERE author_id = ?)";
$like_received_stmt = $conn->prepare($like_received_query);
$like_received_stmt->bind_param("i", $user_id);
$like_received_stmt->execute();
$like_received_result = $like_received_stmt->get_result();
$like_received_count = $like_received_result->fetch_assoc()['like_received_count'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FC Barcelona</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header class="dashboard-header">
        <div class="user-info-header">
            <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="User Icon" class="user-icon">
            <div>
                <h1>Bienvenido, <?= htmlspecialchars($user['username']) ?></h1>
                <nav>
                    <a href="index.php">Inicio</a>
                    <a href="posts.php">Publicaciones</a>
                    <a href="profile.php">Editar Perfil</a>
                    <a href="logout.php">Cerrar Sesión</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="dashboard-main">
        <section id="overview" class="card">
            <h2>Resumen Rápido</h2>
            <canvas id="statsChart"></canvas>
        </section>

        <section id="quick-links" class="card">
            <h2>Accesos Rápidos</h2>
            <ul>
                <li><a href="posts.php">Ver Publicaciones</a></li>
                <li><a href="profile.php">Editar Perfil</a></li>
                <li><a href="settings.php">Configuración de la Cuenta</a></li>
            </ul>
        </section>

        <section id="welcome-message" class="card">
            <h2>Bienvenido al FC Barcelona</h2>
            <p>Nos alegra tenerte de vuelta, <?= htmlspecialchars($user['username']) ?>. Explora las últimas publicaciones, actualiza tu perfil y ajusta la configuración de tu cuenta.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 FC Barcelona. D1CKH4CK3R.</p>
    </footer>

    <script>
        const ctx = document.getElementById('statsChart').getContext('2d');
        const statsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Publicaciones', 'Comentarios', 'Likes Recibidos', 'Likes Dados'],
                datasets: [{
                    label: 'Estadísticas del Usuario',
                    data: [<?= $post_count ?>, <?= $comment_count ?>, <?= $like_received_count ?>, <?= $like_given_count ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

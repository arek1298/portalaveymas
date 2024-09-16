<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'ave2';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    exit;
}

// Obtener el ID del usuario actual
$id_usuario = $_SESSION['id_usuario'];

// Consultar notificaciones no leídas
$sql = "SELECT id, mensaje FROM notificaciones WHERE id_usuario = :id_usuario AND leido = FALSE";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
$notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar el número de notificaciones no leídas
$num_notificaciones = count($notificaciones);

// Marcar notificaciones como leídas
$sql = "UPDATE notificaciones SET leido = TRUE WHERE id_usuario = :id_usuario AND leido = FALSE";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #000;
        }
        .notification-bell {
            position: relative;
            display: inline-block;
        }
        .notification-bell .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #dc3545;
            color: #fff;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 12px;
        }
        .card-custom {
            margin-bottom: 20px;
        }
        .card-notification {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <a class="navbar-brand" href="#">Mi Empresa</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard_it.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-user"></i> Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-cogs"></i> Configuración</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../destruir.php"><i class="fas fa-off"></i> Salir del sistema</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link notification-bell" href="#" onclick="toggleNotifications(); return false;">
                        <i class="fas fa-bell"></i>
                        <?php if ($num_notificaciones > 0): ?>
                            <span class="badge"><?php echo $num_notificaciones; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h1 class="text-center">Dashboard</h1>

        <!-- Alerta de notificaciones -->
        <div id="alert-notificaciones" class="card card-custom d-none">
            <div class="card-body">
                <h5 class="card-title">Notificaciones</h5>
                <?php if (!empty($notificaciones)): ?>
                    <?php foreach ($notificaciones as $notificacion): ?>
                        <div class="card-notification">
                            <div class="alert alert-info" role="alert">
                                <?php echo htmlspecialchars($notificacion['mensaje']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes nuevas notificaciones.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tarjetas de acción -->
        <div class="row mt-4">
            <div class="col-md-4">
                <a href="asignar_tareas.php" class="text-decoration-none">
                    <div class="card card-custom bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-tachometer-alt"></i> Asignar Tareas</h5>
                            <p class="card-text">Asignar nuevas tareas a los usuarios.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="ver_tareas.php" class="text-decoration-none">
                    <div class="card card-custom bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-calendar-check"></i> Ver Tareas Pendientes</h5>
                            <p class="card-text">Revisar y gestionar tus tareas pendientes.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="estadisticas.php" class="text-decoration-none">
                    <div class="card card-custom bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-chart-line"></i> Estadísticas</h5>
                            <p class="card-text">Consultar estadísticas y datos de rendimiento.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleNotifications() {
            var alertElement = document.getElementById('alert-notificaciones');
            if (alertElement.classList.contains('d-none')) {
                alertElement.classList.remove('d-none');
            } else {
                alertElement.classList.add('d-none');
            }
        }
    </script>
</body>
</html>

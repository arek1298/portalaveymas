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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .card-custom {
            margin-bottom: 20px;
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
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Inicio</a>
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
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">Mi Empresa</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="dashboard_it.php" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="perfil.php" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Perfil</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Configuración</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../destruir.php" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Salir del sistema</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Alerta de notificaciones -->
                <div id="alert-notificaciones" class="card card-custom d-none">
                    <div class="card-body">
                        <h5 class="card-title">Notificaciones</h5>
                        <?php if (!empty($notificaciones)): ?>
                            <?php foreach ($notificaciones as $notificacion): ?>
                                <div class="alert alert-info" role="alert">
                                    <?php echo htmlspecialchars($notificacion['mensaje']); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No tienes nuevas notificaciones.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tarjetas de acción -->
                <div class="row">
                    <div class="col-lg-4 col-12">
                        <a href="asignar_tareas.php" class="text-decoration-none">
                            <div class="card card-custom bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-tachometer-alt"></i> Asignar Tareas</h5>
                                    <p class="card-text">Asignar nuevas tareas a los usuarios.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-12">
                        <a href="ver_tareas.php" class="text-decoration-none">
                            <div class="card card-custom bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-calendar-check"></i> Ver Tareas Pendientes</h5>
                                    <p class="card-text">Revisar y gestionar tus tareas pendientes.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-12">
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
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
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

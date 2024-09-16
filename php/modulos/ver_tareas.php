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

// Consultar tareas pendientes para el usuario
try {
    $sql = "SELECT t.id, t.descripcion, t.fecha_limite, t.archivo, t.id_asignador, u.nombre AS nombre_asignador
            FROM tareas t
            JOIN usuarios u ON t.id_asignador = u.id
            WHERE t.persona = :id_persona AND t.completada = 0";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_persona', $id_usuario);
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($tareas)) {
        $no_tareas_msg = "No se encontraron tareas pendientes para el usuario.";
    }

} catch (PDOException $e) {
    $error_msg = "Error al obtener tareas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Pendientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                <a href="dashboard_it.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Perfil</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Configuración</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="../destruir.php" class="nav-link">Salir del sistema</a>
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
                        <a href="#" class="nav-link">
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
                        <h1 class="m-0">Tareas Pendientes</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($no_tareas_msg)): ?>
                                    <div class="alert alert-info"><?php echo htmlspecialchars($no_tareas_msg); ?></div>
                                <?php elseif (isset($error_msg)): ?>
                                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_msg); ?></div>
                                <?php else: ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Descripción</th>
                                                <th>Fecha Límite</th>
                                                <th>Archivo</th>
                                                <th>Asignador</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($tareas)): ?>
                                                <?php foreach ($tareas as $tarea): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($tarea['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($tarea['descripcion']); ?></td>
                                                        <td><?php echo htmlspecialchars($tarea['fecha_limite']); ?></td>
                                                        <td>
                                                            <?php if (!empty($tarea['archivo'])): ?>
                                                                <a href="../uploads/<?php echo htmlspecialchars($tarea['archivo']); ?>" target="_blank">Ver Archivo</a>
                                                            <?php else: ?>
                                                                No hay archivo
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            ID: <?php echo htmlspecialchars($tarea['id_asignador']); ?><br>
                                                            Nombre: <?php echo htmlspecialchars($tarea['nombre_asignador']); ?>
                                                        </td>
                                                        <td>
                                                            <a href="completar_tarea.php?id=<?php echo htmlspecialchars($tarea['id']); ?>" class="btn btn-primary">Completar</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No tienes tareas pendientes.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
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
</body>
</html>

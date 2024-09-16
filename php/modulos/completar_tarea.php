<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Tarea</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- FontAwesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap (opcional si AdminLTE ya está cargado, puedes prescindir de esto) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .navbar-custom {
            background-color: #000;
        }

        .content-wrapper {
            margin-top: 30px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-custom">
            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="dashboard_it.php" class="nav-link"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link"><i class="fas fa-user"></i> Perfil</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link"><i class="fas fa-cogs"></i> Configuración</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../destruir.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Salir del sistema</a>
                </li>
            </ul>
        </nav>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Card de AdminLTE -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Completar Tarea</h3>
                                </div>
                                <!-- Formulario dentro de la card-body -->
                                <form action="../../php/procesar_completar_tarea.php" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="tarea_id" value="<?php echo htmlspecialchars($tarea['id']); ?>">
                                        <div class="form-group">
                                            <label for="archivo_actualizado">Subir documento actualizado:</label>
                                            <input type="file" class="form-control" name="archivo_actualizado" id="archivo_actualizado" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nota">Nota:</label>
                                            <textarea class="form-control" name="nota" id="nota" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <!-- Botón de envío -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block">Completar Tarea</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

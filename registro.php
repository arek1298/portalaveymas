<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .register-page {
            background: #f4f6f9;
            height: 100vh;
        }
        .register-box {
            width: 360px;
            margin: 7% auto;
        }
        .register-logo img {
            width: 150px;
        }
    </style>
</head>
<body class="register-page">
    <div class="register-box">
        <div class="register-logo text-center">
            <!-- Espacio para el logo de la empresa -->
            <img src="images/logo.png" alt="Logo de la empresa">
        </div>
        <!-- /.register-logo -->
        <div class="card">
            <div class="card-body register-card-body">
                <h2 class="register-box-msg">Registro de Usuarios</h2>

                <form action="php/insertar.php" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre completo" required>
                    </div>

                    <div class="form-group">
                        <label for="area">Área:</label>
                        <select class="form-control" name="area" id="area" required>
                            <option value="" disabled selected>Seleccione un área</option>
                            <option value="IT">IT</option>
                            <option value="RH">Recursos Humanos (RH)</option>
                            <option value="Calidad">Calidad</option>
                            <option value="Producción">Producción</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Nombre de usuario" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        </div>
                    </div>

                    <a href="login.php"> Entrar al sistema </a>
                </form>
            </div>
            <!-- /.register-card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- AdminLTE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>

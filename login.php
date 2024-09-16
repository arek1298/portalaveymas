<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Login</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .login-page {
            background: #f4f6f9;
            height: 100vh;
        }
        .login-box {
            width: 360px;
            margin: 7% auto;
        }
        .login-logo img {
            width: 150px;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo text-center">
            <!-- Espacio para el logo de la empresa -->
            <img src="images/logo.png" alt="Logo de la empresa">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <h2 class="login-box-msg">Iniciar Sesión</h2>

                <form action="php/login.php" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                        </div>
                    </div>
                    <a href="registro.php"> Regístrate</a>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- AdminLTE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>

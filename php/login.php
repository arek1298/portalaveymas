<?php
session_start(); // Iniciar la sesión

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ave2";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario, la contraseña y el área
    $sql = "SELECT id, password, area FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();
    
    // Verificar si el usuario existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $area);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            // Si la contraseña es correcta, iniciar sesión
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id_usuario'] = $id;
            $_SESSION['area'] = $area;

            // Consultar tareas pendientes
            $sql = "SELECT COUNT(*) AS tareas_pendientes FROM tareas WHERE persona = ? AND completada = FALSE";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($tareas_pendientes);
            $stmt->fetch();

            // Guardar el número de tareas pendientes en la sesión
            $_SESSION['tareas_pendientes'] = $tareas_pendientes;

            // Redirigir a un dashboard según el área
            switch ($area) {
                case 'IT':
                    header("Location: modulos/dashboard_it.php");
                    break;
                case 'RH':
                    header("Location: modulos/dashboard_rh.php");
                    break;
                case 'Calidad':
                    header("Location: modulos/dashboard_calidad.php");
                    break;
                case 'Producción':
                    header("Location: modulos/dashboard_produccion.php");
                    break;
                default:
                    header("Location: modulos/dashboard_general.php"); // Para otras áreas o áreas nuevas
                    break;
            }
            exit();
        } else {
            // Contraseña incorrecta
            $_SESSION['error_message'] = "Contraseña incorrecta.";
            header("Location: login.php"); // Redirigir al formulario de login
            exit();
        }
    } else {
        // Usuario no encontrado
        $_SESSION['error_message'] = "Usuario no encontrado.";
        header("Location: login.php"); // Redirigir al formulario de login
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

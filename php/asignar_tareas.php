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

// Conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    exit;
}

// Obtener el ID del usuario actual que asigna la tarea
$id_asignador = $_SESSION['id_usuario'];

// Obtener datos del formulario
$descripcion = $_POST['descripcion'];
$fecha_limite = $_POST['fecha_limite'];
$persona = $_POST['persona'];  // ID del usuario a quien se le asigna la tarea

// Manejo del archivo subido
$archivo = '';
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
    $archivo = $_FILES['archivo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($archivo);

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $target_file)) {
        // Archivo subido exitosamente
    } else {
        echo 'Error al subir el archivo.';
        exit;
    }
}

// Insertar datos en la base de datos
$sql = "INSERT INTO tareas (descripcion, fecha_limite, archivo, persona, id_asignador) 
        VALUES (:descripcion, :fecha_limite, :archivo, :persona, :id_asignador)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':descripcion' => $descripcion,
        ':fecha_limite' => $fecha_limite,
        ':archivo' => $archivo,
        ':persona' => $persona,
        ':id_asignador' => $id_asignador  // Asigna el usuario que está logueado
    ]);
    echo 'Tarea asignada exitosamente.';
} catch (PDOException $e) {
    echo 'Error al insertar la tarea: ' . $e->getMessage();
}
?>

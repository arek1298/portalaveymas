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

// Obtener el ID de la tarea completada y otros datos del formulario
$id_tarea = $_POST['tarea_id'];
$nota = $_POST['nota'];  // Nota sobre la tarea
$archivo_actualizado = $_FILES['archivo_actualizado']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($archivo_actualizado);

// Mover el archivo a la carpeta de uploads
if (!move_uploaded_file($_FILES['archivo_actualizado']['tmp_name'], $target_file)) {
    echo 'Error al subir el archivo.';
    exit;
}

// Actualizar la tarea como completada en la base de datos
$sql = "UPDATE tareas SET estado = 'completada', archivo_actualizado = :archivo_actualizado, nota = :nota WHERE id = :id_tarea";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':archivo_actualizado', $archivo_actualizado);
$stmt->bindParam(':nota', $nota);
$stmt->bindParam(':id_tarea', $id_tarea);

if (!$stmt->execute()) {
    echo 'Error al actualizar la tarea.';
    exit;
}

// Obtener el ID del usuario al que se le asignó la tarea
#$sql = "SELECT persona FROM tareas WHERE id = :id_tarea";
#$stmt = $pdo->prepare($sql);
#$stmt->bindParam(':id_tarea', $id_tarea);
#$stmt->execute();
#$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

#if ($resultado === false) {
    #echo 'No se encontró el usuario asignado.';
    #exit;
#}


// Consultar el usuario que asignó la tarea
$sql = "SELECT id_asignador FROM tareas WHERE id = :id_tarea";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_tarea', $id_tarea);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado === false) {
    echo 'No se encontró el asignador de la tarea.';
    exit;
}

$id_asignador = $resultado['id_asignador'];


$id_persona_asignada = $resultado['persona'];

// Obtener el correo electrónico del usuario asignado
$sql = "SELECT correo FROM usuarios WHERE id = :id_persona_asignada";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_persona_asignada', $id_persona_asignada);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado === false) {
    echo 'No se encontró el correo del usuario asignado.';
    exit;
}

$correo_asignado = $resultado['correo'];

// Mensaje de la notificación
$mensaje_notificacion = "La tarea con ID $id_tarea ha sido actualizada por el usuario con ID $id_usuario. Nota: $nota";

// Insertar la notificación en la base de datos
$sql = "INSERT INTO notificaciones (id_usuario, mensaje, leido) VALUES (:id_usuario, :mensaje, FALSE)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_usuario', $id_persona_asignada);
$stmt->bindParam(':mensaje', $mensaje_notificacion);

if (!$stmt->execute()) {
    echo 'Error al insertar la notificación.';
    exit;
}

echo 'Tarea completada y notificación enviada.';
?>

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si tienes un usuario diferente
$password = ""; // Contraseña de MySQL (deja vacío si no tienes)
$dbname = "ave2";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $area = $_POST['area'];
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Verificar si el usuario ya existe
    $sql = "SELECT id FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "El nombre de usuario ya existe.";
    } else {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO usuarios (nombre, area, usuario, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $area, $usuario, $password);

        if ($stmt->execute()) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>

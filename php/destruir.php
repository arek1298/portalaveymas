<?php
session_start(); // Iniciar sesión

// Eliminar todas las variables de sesión
$_SESSION = array();

// Si se usa una cookie de sesión, eliminarla
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio o de login
header("Location: ../login.php");
exit();
?>

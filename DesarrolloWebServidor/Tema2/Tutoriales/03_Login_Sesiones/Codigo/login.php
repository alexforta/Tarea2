<?php
//Comprobacion estricta de de tipos
declare(strict_types=1);
//Inicia o recupera la sesion
session_start();
require_once __DIR__ . '/usuarios.php';

/**
 * Comprueba si hay un nombre guardado en la sesion para saber si ya ha iniciado sesion
 * Redirecciona a zona.php
 */
if (isset($_SESSION['nombre'])) {
    header('Location: zona.php');
    exit;
}

//posible mensaje de error
$error = '';

/**
 * Comprueba si el metodo es post
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * Validaciones
     */
    $email = trim((string) ($_POST['email'] ?? ''));
    $clave = (string) ($_POST['clave'] ?? '');
    $nombre = autenticar($email, $clave);

    /**
     * Si nombre no es null.
     * Genera un nuevo id.
     * Guarda el nombre de usuario en $_SESSION.
     * Abre zona.php y detiene este php
     */
    if ($nombre !== null) {
        session_regenerate_id(true);
        $_SESSION['nombre'] = $nombre;
        header('Location: zona.php');
        exit;
    }
    $error = 'Credenciales incorrectas.';
}
?>
<!-- SE EJECUTA PRIMERO -->
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acceso</title>
</head>
<body>
    <h1>Club de lectura</h1>
    <!-- Si hay un error lo muestra -->
    <?php if ($error !== ''): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label>Correo
            <input name="email" type="email" required>
        </label>
        <label>Contraseña
            <input name="clave" type="password" required>
        </label>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>

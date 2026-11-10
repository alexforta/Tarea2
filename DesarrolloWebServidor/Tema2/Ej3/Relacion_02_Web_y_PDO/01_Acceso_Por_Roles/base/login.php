<?php

declare(strict_types=1);
require_once __DIR__ . '/usuarios.php';
require_once __DIR__ . '/incidencias.php';
// TODO: iniciar o recuperar la sesión.
session_start();
// TODO: si el usuario ya está identificado, redirigir a panel.php.
if (isset($_SESSION['nombre'])) {
    header('Location: panel.php');
    exit;
}

$error = '';
// TODO: validar las credenciales recibidas por POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $clave = (string) ($_POST['clave'] ?? '');
    $nombre = autenticar($email, $clave);

    if ($nombre !== null) {
        session_regenerate_id(true);
        $_SESSION['nombre'] = $nombre;
        header('Location: panel.php');
        exit();
    }
}
// TODO: regenerar el ID, guardar los datos necesarios y redirigir.
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Acceso a incidencias</title>
</head>

<body>
    <h1>Acceso al panel de incidencias</h1>
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
    <!-- TODO: mostrar errores y el formulario con correo y contraseña. -->
</body>

</html>
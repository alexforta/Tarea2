<?php

declare(strict_types=1);
require_once __DIR__ . '/sesion.php';
require_once __DIR__ . '/cuentas.php';
if (isset($_SESSION['correo'])) {
    header('Location: panel.php');
    exit;
}
$error = '';
$ahora = time();
if (($_SESSION['bloqueado_hasta'] ?? 0) <= $ahora && isset($_SESSION['bloqueado_hasta'])) {
    unset($_SESSION['bloqueado_hasta']);
    $_SESSION['intentos'] = 0;
}
$restante = max(0, (int)($_SESSION['bloqueado_hasta'] ?? 0) - $ahora);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($restante > 0) {
        $error = "Acceso bloqueado. Quedan unos $restante segundos.";
    } else {
        $correo = strtolower(trim((string)($_POST['correo'] ?? '')));
        $clave = (string)($_POST['clave'] ?? '');
        if ($correo !== '' && $clave !== '') {
            $cuentas = obtenerCuentas();
            if (isset($cuentas[$correo]) && password_verify($clave, $cuentas[$correo]['hash'])) {
                session_regenerate_id(true);
                $_SESSION['correo'] = $correo;
                $_SESSION['nombre'] = $cuentas[$correo]['nombre'];
                $_SESSION['movimientos'] = [];
                $_SESSION['ultima_actividad'] = time();
                $_SESSION['intentos'] = 0;
                unset($_SESSION['bloqueado_hasta']);
                header('Location: panel.php');
                exit;
            }
            $_SESSION['intentos'] = (int)($_SESSION['intentos'] ?? 0) + 1;
            if ($_SESSION['intentos'] >= 3) {
                $_SESSION['bloqueado_hasta'] = time() + 90;
                $error = 'Tres intentos fallidos. Acceso bloqueado durante 90 segundos.';
            } else {
                $error = 'Datos de acceso incorrectos.';
            }
        } else {
            $error = 'Introduce correo y contraseña.';
        }
    }
}
if (($_GET['motivo'] ?? '') === 'expirada') {
    $error = 'La sesión ha caducado por inactividad.';
}
function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Acceso a turnos</title>
</head>

<body>
    <h1>Identificación</h1><?php if ($error !== ''): ?><p role="alert"><?= e($error) ?></p><?php endif; ?>
    <form method="post"><label>Correo <input name="correo" type="email" required></label>
        <label>Contraseña <input name="clave" type="password" required></label><button>Entrar</button>
    </form>
</body>

</html>
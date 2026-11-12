<?php
declare(strict_types=1);
// TODO: rechazar los métodos distintos de POST con HTTP 405.
// TODO: abrir la sesión, vaciar sus datos, caducar su cookie y destruirla.
// TODO: redirigir a login.php.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}
session_start();
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $parametros = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 3600,
        'path' => $parametros['path'],
        'domain' => $parametros['domain'],
        'secure' => $parametros['secure'],
        'httponly' => $parametros['httponly'],
        'samesite' => $parametros['samesite'] ?? 'Lax'
    ]);
}
session_destroy();
header('Location: login.php');
exit;
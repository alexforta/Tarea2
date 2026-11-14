<?php

declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
function cerrarSesion(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', ['expires' => time() - 3600, 'path' => $p['path'], 'domain' => $p['domain'], 'secure' => $p['secure'], 'httponly' => $p['httponly'], 'samesite' => $p['samesite'] ?? 'Lax']);
    }
    session_destroy();
}
function exigirSesion(): void
{
    if (!isset($_SESSION['correo'], $_SESSION['nombre'])) {
        header('Location: acceso.php');
        exit;
    }
    if (time() - (int)($_SESSION['ultima_actividad'] ?? 0) > 180) {
        cerrarSesion();
        header('Location: acceso.php?motivo=expirada');
        exit;
    }
    $_SESSION['ultima_actividad'] = time();
}

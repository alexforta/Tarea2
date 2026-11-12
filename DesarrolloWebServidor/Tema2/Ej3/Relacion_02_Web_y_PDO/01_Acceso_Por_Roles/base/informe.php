<?php
declare(strict_types=1);
require_once __DIR__ . '/incidencias.php';
// TODO: iniciar sesión, comprobar autenticación y perfil coordinacion.
session_start();
// TODO: devolver 403 si el perfil no tiene permiso.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}
// TODO: calcular revisadas y pendientes.
?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><title>Informe</title></head><body>
<h1>Informe de incidencias</h1>
<!-- TODO: mostrar los dos recuentos y regresar al panel. -->
</body></html>

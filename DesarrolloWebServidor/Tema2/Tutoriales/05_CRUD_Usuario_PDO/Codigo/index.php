<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/UsuarioRepositorio.php';

function h(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

$error = '';
$usuarios = [];
try {
    $repo = new UsuarioRepositorio(conectar());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Comprueba la accion pulsada en el formulario
        $accion = (string) ($_POST['accion'] ?? '');
        //Compueba que el numero enviado en el formulario sea mayor o igual a 1
        $id = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );
        /**
         * Comprueba lo que llega de la variable accion y ejecuta segun lo que se le ha pedido su funcion
         */
        if ($accion === 'crear') {
            $repo->crear(
                (string) ($_POST['email'] ?? ''),
                (string) ($_POST['nombre'] ?? ''),
                (string) ($_POST['clave'] ?? '')
            );
        } elseif ($accion === 'renombrar' && $id !== false) {
            $repo->renombrar($id, (string) ($_POST['nombre'] ?? ''));
        } elseif ($accion === 'borrar' && $id !== false) {
            $repo->borrar($id);
        } else {
            throw new InvalidArgumentException('Acción no válida.');
        }
        header('Location: index.php');
        exit;
    }
    $usuarios = $repo->listar();
} catch (InvalidArgumentException $errorValidacion) {
    http_response_code(400);
    $error = $errorValidacion->getMessage();
} catch (PDOException $errorBD) {
    http_response_code(500);
    $error = 'No se pudo completar la operación. Revisa la conexión o los datos duplicados.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>CRUD de usuarios</title>
</head>
<body>
    <h1>Usuarios</h1>
    <?php if ($error !== ''): ?>
        <p><?= h($error) ?></p>
    <?php endif; ?>

    <h2>Crear usuario</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="accion" value="crear">
        <input type="email" name="email" placeholder="Correo" required>
        <input name="nombre" placeholder="Nombre" required>
        <input type="password" name="clave" minlength="8" placeholder="Contraseña" required>
        <button type="submit">Crear</button>
    </form>

    <h2>Listado</h2>
    <ul>
        <?php foreach ($usuarios as $usuario): ?>
            <li>
                <?= h($usuario['nombre']) ?> (<?= h($usuario['email']) ?>)
                <form action="index.php" method="post" style="display:inline">
                    <input type="hidden" name="accion" value="renombrar">
                    <input type="hidden" name="id" value="<?= (int) $usuario['id'] ?>">
                    <input name="nombre" value="<?= h($usuario['nombre']) ?>" required>
                    <button type="submit">Renombrar</button>
                </form>
                <form action="index.php" method="post" style="display:inline">
                    <input type="hidden" name="accion" value="borrar">
                    <input type="hidden" name="id" value="<?= (int) $usuario['id'] ?>">
                    <button type="submit">Borrar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

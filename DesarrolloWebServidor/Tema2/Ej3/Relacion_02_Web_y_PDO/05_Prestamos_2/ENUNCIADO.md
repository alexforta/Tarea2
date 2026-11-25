# Ejercicio 5 · Préstamos de equipos

**Objetivo.** Gestiona préstamos de material del centro con PHP, PDO y dos tablas relacionadas. Muestra qué equipo se ha prestado a cada persona mediante una consulta con INNER JOIN.

## Preparación

Importa schema.sql en phpMyAdmin. Se crearán la base de datos ud2_prestamos y las tablas equipo(id, nombre, unidades) y prestamo(id, equipo_id, persona, devuelto). El campo devuelto vale 0 mientras el préstamo está abierto y 1 cuando se devuelve.

## Métodos requeridos

| Método | Operación |
|---|---|
| `listarEquipos(): array` | Devuelve todos los equipos, con id, nombre, unidades y disponibles. Los disponibles se calculan restando a las unidades el número de préstamos abiertos; utiliza los arrays obtenidos con PDO y recorridos foreach. |
| `listarPrestamos(): array` | Devuelve el ID del préstamo, el nombre del equipo, la persona y su estado. Utiliza INNER JOIN entre prestamo y equipo y ordena por ID descendente. |
| `prestar(int $equipoId, string $persona): void` | Comprueba que el equipo existe y que todavía quedan unidades libres. Si es posible, crea un préstamo con devuelto = 0. Si no quedan, lanza una excepción. |
| `devolver(int $prestamoId): bool` | Si existe un préstamo abierto, cambia devuelto a 1 y devuelve true. Si no existe o ya estaba devuelto, devuelve false. |

## Requisitos

1. En index.php, muestra una tabla con Equipo, Unidades y Disponibles.
2. Añade un formulario para prestar un equipo. Elige el equipo mediante un select y recoge el nombre de la persona; no admitas nombres vacíos ni identificadores incorrectos.
3. Muestra los préstamos en otra tabla. El nombre del equipo debe proceder de la consulta con INNER JOIN, no de un texto almacenado en prestamo.
4. Para los préstamos abiertos, muestra un botón Devolver. Envía las operaciones mediante POST y, después de un cambio correcto, vuelve al listado mediante una redirección.
5. Si no quedan unidades, muestra el mensaje «No quedan unidades disponibles.» y no crees el préstamo. Un préstamo ya devuelto no puede devolverse otra vez.
6. Las clases de repositorio deben devolver datos o realizar cambios; la salida HTML se construye en index.php. Escapa los textos que imprimas y no muestres errores técnicos de MySQL.

## Pruebas

- El equipo con una unidad admite un préstamo abierto y rechaza un segundo.
- Al devolverlo, vuelve a estar disponible esa unidad.
- Los equipos sin préstamos aparecen igualmente en el listado.
- En el listado de préstamos aparece correctamente el nombre del equipo gracias al JOIN.

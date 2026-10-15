# 01. Agenda electoral con filtros

**Objetivo:** combinar filtros GET sobre un repositorio fijo de 18 actos ficticios, y separar la lógica PHP de la tabla de salida.

**Archivos:** `agenda.html` (formulario), `datosActos.php` (datos), `filtrarAgenda.php` (lógica), `vistas/agendaResultado.php` (HTML de resultados).

1. Completa el formulario: provincia (`Todas`, Granada, Sevilla, Málaga), partido (`Todos` o uno de los cinco), tipo (`Todos`, Mitin, Debate, Encuentro) y `limite` (1-10, inicialmente 5). Usa **GET**.
2. El PHP debe rechazar métodos distintos de GET, provincias/partidos/tipos inventados y límites fuera de rango. No basta con `required` o `min` en HTML.
3. Recorre `$actos` (ya ordenados por fecha) y conserva solo los que cumplen simultáneamente los tres filtros. `Todos` / `Todas` significa no aplicar ese filtro.
4. Calcula **el número total de coincidencias y la suma de sus aforos** ANTES de limitar el número de filas visibles.
5. Muestra únicamente los primeros `limite` actos en una tabla HTML (fecha, hora, provincia, partido, tipo, lugar y aforo), construida en la vista. Si no hay coincidencias, informa claramente.
6. Incluye enlace al formulario. No uses CSS, JavaScript ni `echo` para construir una página HTML completa.

**Pruebas:** Granada + Todos + Todos + límite 2 → hay 6 coincidencias, aforo total 870 y solo 2 filas visibles. Sevilla + PP + Debate → 1 acto. Málaga + Podemos + Mitin → 0. Límite 11 → error.

**Practicas:** GET, arrays de arrays, `foreach`, condiciones acumulativas, validaciones, `array_slice` y tablas HTML.

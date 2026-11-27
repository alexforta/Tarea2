# Ejercicio 6 · Talleres y lista de espera

**Objetivo.** Desarrolla una aplicación de inscripciones a talleres. Cada taller tiene un número limitado de plazas y las personas restantes quedan en lista de espera.

## Preparación

Importa schema.sql en phpMyAdmin. Se crearán ud2_talleres, la tabla taller(id, titulo, plazas) y la tabla inscripcion(id, taller_id, nombre, email, estado). estado puede ser confirmada o espera. El par taller_id/email no puede repetirse.

## Métodos requeridos

| Método | Operación |
|---|---|
| `listarTalleres(): array` | Devuelve cada taller con sus plazas y el número de inscripciones confirmadas y en espera. Puedes recorrer los arrays recuperados con PDO para contar cada estado. |
| `listarInscripciones(): array` | Devuelve las inscripciones mostrando el título del taller. Utiliza INNER JOIN entre inscripcion y taller y ordena por taller e ID. |
| `inscribir(int $tallerId, string $nombre, string $email): string` | Comprueba los datos y los duplicados. Si quedan plazas, inserta la inscripción como confirmada; si no, como espera. Devuelve el estado asignado. |
| `cancelar(int $inscripcionId): bool` | Elimina la inscripción indicada. Si era confirmada y había personas en espera para el mismo taller, cambia a confirmada la que tenga el ID más pequeño. Devuelve false si la inscripción no existía. |

## Requisitos

1. En index.php, muestra una tabla con el título del taller, sus plazas, las inscripciones confirmadas y las personas en espera.
2. Crea un formulario con taller, nombre y correo electrónico. Comprueba que el nombre no está vacío y valida el correo con filter_var().
3. No admitas dos inscripciones con el mismo correo en un mismo taller. Sí se puede utilizar ese correo en talleres distintos.
4. Muestra las inscripciones en otra tabla con el título del taller obtenido mediante INNER JOIN, nombre, correo, estado y un botón Cancelar.
5. Al cancelar una inscripción confirmada, asigna su plaza a la primera persona en espera (la de ID más pequeño). Si se cancela una inscripción en espera, las demás conservan su estado.
6. Utiliza POST para inscribir y cancelar. Tras realizar un cambio válido, redirige al listado. Las consultas SQL estarán en TallerRepositorio.php y la presentación en index.php.

## Pruebas

- En un taller de dos plazas, las dos primeras inscripciones quedan confirmadas y la tercera en espera.
- Al cancelar a una persona confirmada, la tercera pasa a confirmada.
- Cancelar a una persona en espera no altera el resto.
- Un correo repetido en el mismo taller no genera una segunda inscripción.

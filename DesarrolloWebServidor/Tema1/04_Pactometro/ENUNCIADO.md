# 04. Pactómetro de asambleas ficticias

**Objetivo:** comprobar mayorías y evaluar qué ocurre al añadir un único partido a una coalición.

**Archivos:** `pactos.html`, `datosEscenarios.php`, `funciones.php`, `analizarPacto.php`, `vistas/informe.php`.

1. Completa el formulario POST con un select `escenario` (`sierra`, `costa`, `vega`) y los cinco checkboxes de partidos usando `name="socios[]"`. Se debe escoger entre **1 y 3 partidos**.
2. En PHP valida método, escenario y socios. Rechaza socios repetidos, partidos inventados, cero seleccionados y más de tres seleccionados.
3. Los escaños se consultan exclusivamente en `datosEscenarios.php`. Crea `calcularMayoria($totalEscanos)`, que devuelve `intdiv($totalEscanos, 2) + 1`.
4. Suma escaños del pacto. Di si alcanza mayoría absoluta y cuántos escaños sobran (o faltan). No confundas la mitad de escaños con mayoría absoluta.
5. Recorre los partidos que están **fuera** del pacto. Para cada uno calcula el total del pacto si se incorporara SOLO ese partido y marca si alcanzaría mayoría. Presenta una tabla de alternativas.
6. Si el pacto carece de mayoría, indica el partido externo que, sumándose por sí solo, **aportaría menos escaños y aun así daría mayoría**. Si no existe, dilo. Si ya hay mayoría, no necesita socios adicionales.
7. Muestra el informe con `vistas/informe.php`; HTML sencillo sin CSS. **No se calculan escaños: ya vienen asignados en los datos ficticios.**

**Pruebas:** Sierra tiene 41 escaños, mayoría 21. PSOE (14) + Sumar (5) = 19, faltan 2; Podemos (+3) es el socio mínimo que permite mayoría. PP (12) + Vox (7) = 19, también faltan 2; Podemos (+3) sirve. PSOE + PP = 26, ya hay mayoría. Partido duplicado y cuatro socios → error.

**Practicas:** POST, `checkbox[]`, mapas anidados, validaciones, bucles, funciones, condiciones y búsqueda de mínimo.

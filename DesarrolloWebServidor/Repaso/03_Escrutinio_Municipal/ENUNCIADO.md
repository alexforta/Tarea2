# 03. Escrutinio municipal ficticio

**Objetivo:** validar un recuento completo, calcular tasas y porcentajes, ordenar resultados y detectar empates.

**Archivos:** `escrutinio.html`, `datosPartidos.php`, `procesarEscrutinio.php`, `vistas/resultados.php`.

1. Completa el formulario POST con `censo` entero de 1 a 100000, cinco números de votos con `name="votos[PSOE]"`, `votos[PP]`, `votos[Vox]`, `votos[Sumar]`, `votos[Podemos]`, más `blancos` y `nulos`. Todos los votos son enteros no negativos.
2. En PHP verifica que el array votos contiene **exactamente los cinco partidos**, sin ninguno inventado. Rechaza valores negativos, textos, campos vacíos y total de votos emitidos superior al censo. Exige al menos un voto a candidaturas.
3. Calcula votos a candidaturas; votos válidos = candidaturas + blancos; emitidos = válidos + nulos; abstención = censo - emitidos; participación = emitidos × 100 / censo.
4. Para cada partido, calcula su % sobre **votos válidos** (no sobre censo ni emitidos). Muestra tabla de mayor a menor número de votos usando `arsort`.
5. Detecta si hay un ganador único o empate en el primer puesto. Cuenta los partidos con un porcentaje **igual o superior a 5 %**. Ese porcentaje es un umbral didáctico, NO un reparto real de escaños.
6. Muestra resumen y tabla en la vista. No uses CSS ni D'Hondt.

**Pruebas:** censo 1000; PSOE 300, PP 250, Vox 100, Sumar 50, Podemos 25, blancos 25, nulos 10 → 760 emitidos, 750 válidos, 240 abstenciones, participación 76 %. Empate: PSOE y PP 100 cada uno, demás 0, censo 300 → deben aparecer dos líderes. Un recuento de 1001 votos con censo 1000 es inválido.

**Practicas:** formularios con arrays, validación de enteros, `array_sum`, `arsort`, porcentajes, empates y salida HTML.

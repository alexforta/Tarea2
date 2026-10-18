# 02. Pedido de propaganda de campaña

**Objetivo:** gestionar un formulario con radios, checkboxes y cantidad; obtener un presupuesto desglosado desde un catálogo PHP.

**Archivos:** `pedido.html`, `catalogo.php`, `funciones.php`, `procesarPedido.php`, `vistas/ticket.php`.

1. Completa los campos del formulario: partido (ya iniciado); un `pack` obligatorio (`basico`, `movil`, `completo`); `unidades` de 1 a 8; `extras[]` opcionales (`chapas`, `pegatinas`, `lanyards`, `folletos`); `transporte` obligatorio (`recogida`, `normal`, `urgente`); y `codigo` de texto opcional. Usa **POST**.
2. Valida el método HTTP, partido, pack, transporte, cantidad y extras contra `catalogo.php`. Evita cobrar dos veces los extras repetidos. Si no hay extras, es correcto.
3. Calcula precio unitario **sin IVA** sumando pack y extras; multiplícalo por las unidades. Los extras se cobran **por unidad**, el transporte **una sola vez**.
4. Un código `LOCAL2026` descuenta 5 % y `VOLUNTARIADO` 10 % de **la mercancía, antes del transporte**. Código vacío o incorrecto = 0 %; indícalo sin impedir el pedido.
5. Suma el transporte a la mercancía ya descontada; calcula IVA (21 %) y total. Advierte si supera el límite ficticio de **500 € IVA incluido**.
6. Escribe las funciones `euros()` y `escapar()` en `funciones.php`. Presenta el ticket con HTML en `vistas/ticket.php`, sin diseñar estilos.

**Pruebas:** pack básico, 2 unidades, sin extras, recogida, sin código → mercancía 70 €, IVA 14,70 €, total 84,70 €. Kit completo, 5 unidades, lanyards, envío urgente, VOLUNTARIADO → mercancía 610 €, descuento 61 €, transporte 28 €, base 577 €, IVA 121,17 €, total 698,17 € (supera 500). Código inválido no descuenta. Extras repetidos no se cobran dos veces.

**Practicas:** POST, radio/checkbox, arrays asociativos, precios, descuentos, IVA, funciones y validación.

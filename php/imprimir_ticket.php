<?php
// Incluir la conexión para poder restar stock
include '../config/db.php';

$lista_json = isset($_POST['lista_items']) ? $_POST['lista_items'] : '[]';
$total = isset($_POST['total_venta']) ? $_POST['total_venta'] : '0.00';
$items = json_decode($lista_json, true);

date_default_timezone_set('America/Mexico_City');
$fecha = date('d/m/Y');
$hora = date('h:i A');

// --- LÓGICA DE DESCUENTO DE STOCK ---
if ($items && count($items) > 0) {
    try {
        $pdo->beginTransaction();
        
        // Preparamos la sentencia SQL para restar stock
        $sql_update = "UPDATE Producto SET stock = stock - 1 WHERE id_Producto = ? AND stock > 0";
        $stmt = $pdo->prepare($sql_update);

        foreach ($items as $item) {
            // Solo restamos si es un producto (tiene ID y tipo producto)
            if (isset($item['tipo']) && $item['tipo'] == 'producto' && isset($item['id'])) {
                $stmt->execute([$item['id']]);
            }
        }
        
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        // Opcional: manejar error, pero para el ticket seguimos adelante
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Venta</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; margin: 0; padding: 20px; background: #eee; }
        .ticket { width: 300px; background: white; padding: 20px; margin: 0 auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .linea { border-bottom: 1px dashed #000; margin: 10px 0; }
        .tabla-items { width: 100%; font-size: 12px; border-collapse: collapse; }
        .tabla-items th { text-align: left; border-bottom: 1px solid #000; }
        .tabla-items td { padding: 5px 0; }
        .total-row { font-size: 16px; font-weight: bold; margin-top: 10px; }
        
        @media print {
            body { background: white; }
            .ticket { box-shadow: none; width: 100%; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">🖨 IMPRIMIR TICKET</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">CERRAR</button>
    </div>

    <div class="ticket">
        <div class="text-center">
            <h2 style="margin:0;">VETERINARIA</h2>
            <p style="margin:5px 0;">Comprobante de Pago</p>
            <p style="font-size: 12px;">Fecha: <?= $fecha ?> - Hora: <?= $hora ?></p>
        </div>

        <div class="linea"></div>

        <table class="tabla-items">
            <thead>
                <tr>
                    <th>Cant.</th>
                    <th>Descripción</th>
                    <th class="text-right">Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php if($items): ?>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td>1</td>
                        <td><?= $item['nombre'] ?></td>
                        <td class="text-right">$<?= number_format($item['precio'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">Sin ítems</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="linea"></div>

        <div class="text-right total-row">
            TOTAL: $<?= $total ?>
        </div>

        <div class="linea"></div>

        <div class="text-center" style="font-size: 12px; margin-top: 20px;">
            <p>¡Gracias por su preferencia!</p>
            <p>Cuide a su mascota.</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        }
    </script>
</body>
</html>
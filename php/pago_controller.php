<?php
include '../config/db.php';

// 1. DEFINIR SERVICIOS FIJOS (Según tus precios)
$servicios_fijos = [
    ['nombre' => 'Consulta General', 'precio' => 80],
    ['nombre' => 'Vacunación', 'precio' => 200],
    ['nombre' => 'Urgencia', 'precio' => 180],
    ['nombre' => 'Control', 'precio' => 40],
    ['nombre' => 'Cirugía', 'precio' => 650]
];

// 2. OBTENER PRODUCTOS DEL INVENTARIO
// Solo traemos los que tienen Stock positivo (> 0)
$sql = "SELECT id_Producto, nom_Producto, cost_Producto, stock FROM Producto WHERE stock > 0 ORDER BY nom_Producto ASC";
$stmt = $pdo->query($sql);
$productos_inv = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
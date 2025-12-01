<?php
include '../config/db.php';

// 1. FECHA SELECCIONADA (Por defecto HOY)
$fecha_seleccionada = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
$id_consulta_sel = isset($_GET['id_Consul']) ? $_GET['id_Consul'] : null;

$lista_consultas = [];
$detalle_consulta = null;

// 2. OBTENER LISTA DE CONSULTAS DE LA FECHA
$sql_lista = "SELECT c.id_Consul, c.hora_Consul, m.nom_Mas, p.nom_Prop 
              FROM Consulta c 
              INNER JOIN Mascota m ON c.id_Mas = m.id_Mas
              INNER JOIN Propietario p ON m.id_Prop = p.id_Prop
              WHERE c.fecha_Consul = ?
              ORDER BY c.hora_Consul ASC";
$stmt = $pdo->prepare($sql_lista);
$stmt->execute([$fecha_seleccionada]);
$lista_consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. SI SELECCIONÓ UNA CONSULTA, TRAER TODOS LOS DETALLES
if ($id_consulta_sel) {
    $sql_detalle = "SELECT c.*, m.*, p.nom_Prop, p.tel_Prop 
                    FROM Consulta c 
                    INNER JOIN Mascota m ON c.id_Mas = m.id_Mas 
                    INNER JOIN Propietario p ON m.id_Prop = p.id_Prop 
                    WHERE c.id_Consul = ?";
    $stmt_det = $pdo->prepare($sql_detalle);
    $stmt_det->execute([$id_consulta_sel]);
    $detalle_consulta = $stmt_det->fetch(PDO::FETCH_ASSOC);
}
?>
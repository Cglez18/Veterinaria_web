<?php
include '../config/db.php';

// Variables
$mascotas_lista = [];
$historial = [];
$mascota_info = null;
$id_seleccionado = isset($_GET['id_Mas']) ? $_GET['id_Mas'] : '';

// 1. CARGAR LISTA DE MASCOTAS (Para el Combobox)
// Traemos también el nombre del dueño para distinguir (ej: "Firulais - Dueño: Juan")
$sql_mascotas = "SELECT m.id_Mas, m.nom_Mas, p.nom_Prop 
                 FROM Mascota m 
                 JOIN Propietario p ON m.id_Prop = p.id_Prop 
                 ORDER BY m.nom_Mas ASC";
$stmt = $pdo->query($sql_mascotas);
$mascotas_lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. SI HAY UNA MASCOTA SELECCIONADA, CARGAR SU HISTORIAL
if ($id_seleccionado != '') {
    
    // A. Obtener datos básicos de la mascota
    $sql_info = "SELECT m.*, p.nom_Prop 
                 FROM Mascota m 
                 JOIN Propietario p ON m.id_Prop = p.id_Prop 
                 WHERE m.id_Mas = ?";
    $stmt_info = $pdo->prepare($sql_info);
    $stmt_info->execute([$id_seleccionado]);
    $mascota_info = $stmt_info->fetch(PDO::FETCH_ASSOC);

    // B. Obtener todas sus consultas (Ordenadas de la más reciente a la más antigua)
    $sql_historial = "SELECT * FROM Consulta 
                      WHERE id_Mas = ? 
                      ORDER BY fecha_Consul DESC, hora_Consul DESC";
    $stmt_hist = $pdo->prepare($sql_historial);
    $stmt_hist->execute([$id_seleccionado]);
    $historial = $stmt_hist->fetchAll(PDO::FETCH_ASSOC);
}
?>
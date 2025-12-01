<?php
include '../config/db.php';

// Variables para llenar el select
$mascotas_lista = [];
$sql = "SELECT id_Mas, nom_Mas FROM Mascota ORDER BY nom_Mas ASC";
$stmt = $pdo->query($sql);
$mascotas_lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

$consultas_historial = [];

// --- GUARDAR CONSULTA ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_mascota = $_POST['id_Mas'];
    
    // Datos de la consulta
    $fecha = $_POST['fecha_Consul'];
    $hora = $_POST['hora_Consul'];
    $tipo = $_POST['tipo_Consul'];
    $diagnostico = $_POST['diag_Consul'];
    $tratamiento = $_POST['trat_Consul'];
    $prox_cita = $_POST['prox_Consul']; // Opcional
    
    // Dato para actualizar peso
    $nuevo_peso = $_POST['pes_Mas_Actual'];

    try {
        // 1. Insertar la Consulta
        $sql_insert = "INSERT INTO Consulta (id_Mas, fecha_Consul, hora_Consul, diag_Consul, trat_Consul, prox_Consul, tipo_Consul) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql_insert);
        $stmt->execute([$id_mascota, $fecha, $hora, $diagnostico, $tratamiento, $prox_cita, $tipo]);

        // 2. Actualizar el Peso en la tabla Mascota
        $sql_update = "UPDATE Mascota SET pes_Mas = ? WHERE id_Mas = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$nuevo_peso, $id_mascota]);

        // Redirigir
        header("Location: ../views/consultas.php?mensaje=guardado");
        
    } catch (Exception $e) {
        die("Error al guardar: " . $e->getMessage());
    }
}
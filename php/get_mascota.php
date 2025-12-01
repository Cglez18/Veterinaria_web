<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Buscamos mascota y dueño
    $sql = "SELECT m.*, p.nom_Prop 
            FROM Mascota m 
            INNER JOIN Propietario p ON m.id_Prop = p.id_Prop 
            WHERE m.id_Mas = ?";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $mascota = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Devolvemos la respuesta en formato JSON
    echo json_encode($mascota);
}
?>
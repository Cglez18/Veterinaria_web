<?php
include '../config/db.php';

// Inicializar variables
$mascotas = [];
$propietarios = [];
$accion = "guardar";

// --- 1. CARGAR LISTA DE PROPIETARIOS (Para el Combobox) ---
// Necesitamos esto siempre, para poder elegir dueño al crear/editar
$sql_props = "SELECT id_Prop, nom_Prop FROM Propietario ORDER BY nom_Prop ASC";
$stmt_props = $pdo->query($sql_props);
$propietarios = $stmt_props->fetchAll(PDO::FETCH_ASSOC);

// --- 2. ELIMINAR MASCOTA ---
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM Mascota WHERE id_Mas = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    header("Location: ../views/mascotas.php");
}

// --- 3. GUARDAR O EDITAR ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_Mas']) ? $_POST['id_Mas'] : null;
    $nombre = $_POST['nom_Mas'];
    $especie = $_POST['esp_Mas'];
    $raza = $_POST['raz_Mas'];
    $edad = $_POST['edad_Mas'];
    $sexo = $_POST['sex_Mas'];
    $peso = $_POST['pes_Mas'];
    $id_prop = $_POST['id_Prop']; // Este viene del Combobox
    
    $es_edicion = $_POST['accion'] == 'editar';

    if ($es_edicion && $id) {
        $sql = "UPDATE Mascota SET nom_Mas=?, esp_Mas=?, raz_Mas=?, edad_Mas=?, sex_Mas=?, pes_Mas=?, id_Prop=? WHERE id_Mas=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $especie, $raza, $edad, $sexo, $peso, $id_prop, $id]);
    } else {
        $sql = "INSERT INTO Mascota (nom_Mas, esp_Mas, raz_Mas, edad_Mas, sex_Mas, pes_Mas, id_Prop) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $especie, $raza, $edad, $sexo, $peso, $id_prop]);
    }
    header("Location: ../views/mascotas.php");
}

// --- 4. BUSCAR Y LISTAR MASCOTAS ---
// Usamos INNER JOIN para traer el NOMBRE del dueño, no solo su ID
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
if ($busqueda != "") {
    $sql = "SELECT m.*, p.nom_Prop 
            FROM Mascota m 
            INNER JOIN Propietario p ON m.id_Prop = p.id_Prop 
            WHERE m.nom_Mas LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$busqueda%"]);
} else {
    $sql = "SELECT m.*, p.nom_Prop 
            FROM Mascota m 
            INNER JOIN Propietario p ON m.id_Prop = p.id_Prop";
    $stmt = $pdo->query($sql);
}
$mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
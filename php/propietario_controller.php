<?php
include '../config/db.php';

$propietarios = [];
$accion = "guardar"; 

//1. ELIMINAR
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar']; // Obtiene el ID del propietario a eliminar
    $sql = "DELETE FROM Propietario WHERE id_Prop = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    header("Location: ../views/propietarios.php"); // Redirige a la lista de propietarios
}

//2. GUARDAR O EDITAR
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // El ID puede venir vacío si es nuevo registro
    $id = isset($_POST['id_Prop']) ? $_POST['id_Prop'] : null;
    $nombre = $_POST['nom_Prop'];
    $direccion = $_POST['direc_Prop'];
    $telefono = $_POST['tel_Prop'];
    $email = $_POST['mail_Prop'];
    
    // Verificamos la acción
    $es_edicion = $_POST['accion'] == 'editar';

    if ($es_edicion && $id) {
        // ACTUALIZAR
        $sql = "UPDATE Propietario SET nom_Prop=?, direc_Prop=?, tel_Prop=?, mail_Prop=? WHERE id_Prop=?";
        $stmt = $pdo->prepare($sql); // Preparar la consulta para evitar inyección SQL
        $stmt->execute([$nombre, $direccion, $telefono, $email, $id]); //sirve para ejecutar la consulta
    } else {
        // CREAR NUEVO
        $sql = "INSERT INTO Propietario (nom_Prop, direc_Prop, tel_Prop, mail_Prop) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $direccion, $telefono, $email]);
    }
    header("Location: ../views/propietarios.php");
}

// 3. BUSCAR / LISTAR
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : ""; // Obtiene el valor de búsqueda
if ($busqueda != "") {
    $sql = "SELECT * FROM Propietario WHERE nom_Prop LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$busqueda%"]);
} else {
    $sql = "SELECT * FROM Propietario";
    $stmt = $pdo->query($sql);
}
$propietarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los propietarios
?>
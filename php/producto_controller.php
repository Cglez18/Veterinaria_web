<?php
include '../config/db.php';

// Variables para los listados
$medicinas = [];
$comidas = [];
$accesorios = [];

// --- 1. ELIMINAR ---
if (isset($_GET['eliminar']) && isset($_GET['tipo'])) {
    $id = $_GET['eliminar'];
    $tipo = $_GET['tipo'];
    
    try {
        $pdo->beginTransaction();
        if($tipo == 'Medicina') $pdo->prepare("DELETE FROM Medicina WHERE id_Producto = ?")->execute([$id]);
        elseif($tipo == 'Comida') $pdo->prepare("DELETE FROM COMIDA WHERE id_Producto = ?")->execute([$id]);
        elseif($tipo == 'Accesorio') $pdo->prepare("DELETE FROM Accesorios WHERE id_Producto = ?")->execute([$id]);
        
        $pdo->prepare("DELETE FROM Producto WHERE id_Producto = ?")->execute([$id]);
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
    header("Location: ../views/producto_lista.php"); // Redirigir a la lista
    exit;
}

// --- 2. GUARDAR (REGISTRO) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_producto = $_POST['tipo_seleccionado'];
    $nombre = $_POST['nom_Producto'];
    $costo = $_POST['cost_Producto'];
    $stock = $_POST['stock']; // <--- NUEVO CAMPO

    try {
        $pdo->beginTransaction();

        // A. Insertar en Producto (Padre)
        $stmt = $pdo->prepare("INSERT INTO Producto (nom_Producto, cost_Producto, stock) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $costo, $stock]);
        $id_nuevo = $pdo->lastInsertId();

        // B. Insertar en Hija
        if ($tipo_producto == 'Medicina') {
            $sql = "INSERT INTO Medicina (id_Producto, fvenci_Medicina, pres_Medicina, admin_Medicina, especie_Medicina, tipo_Medicina, fabri_Medicina) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $pdo->prepare($sql)->execute([$id_nuevo, $_POST['fvenci_Medicina'], $_POST['pres_Medicina'], $_POST['admin_Medicina'], $_POST['especie_Medicina'], $_POST['tipo_Medicina'], $_POST['fabri_Medicina']]);
        } 
        elseif ($tipo_producto == 'Comida') {
            $sql = "INSERT INTO COMIDA (id_Producto, tipo_Comida, vida_Comida, especie_Comida) VALUES (?, ?, ?, ?)";
            $pdo->prepare($sql)->execute([$id_nuevo, $_POST['tipo_Comida'], $_POST['vida_Comida'], $_POST['especie_Comida']]);
        }
        elseif ($tipo_producto == 'Accesorio') {
            $sql = "INSERT INTO Accesorios (id_Producto, tipo_Accesorio, mate_Accesorio, talla_Accesorio, descrip_Accesorio) VALUES (?, ?, ?, ?, ?)";
            $pdo->prepare($sql)->execute([$id_nuevo, $_POST['tipo_Accesorio'], $_POST['mate_Accesorio'], $_POST['talla_Accesorio'], $_POST['descrip_Accesorio']]);
        }
        
        $pdo->commit();
        // Redirigir a la LISTA para ver lo creado
        header("Location: ../views/producto_lista.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}

// --- 3. CONSULTAR TODO (Para la vista de Lista) ---
// Obtenemos Medicinas
$stmt = $pdo->query("SELECT p.*, m.* FROM Producto p JOIN Medicina m ON p.id_Producto = m.id_Producto");
$medicinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtenemos Comidas
$stmt = $pdo->query("SELECT p.*, c.* FROM Producto p JOIN COMIDA c ON p.id_Producto = c.id_Producto");
$comidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtenemos Accesorios
$stmt = $pdo->query("SELECT p.*, a.* FROM Producto p JOIN Accesorios a ON p.id_Producto = a.id_Producto");
$accesorios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
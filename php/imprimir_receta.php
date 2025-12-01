<?php
include '../config/db.php';

if (!isset($_GET['id'])) {
    die("Error: No se especificó consulta.");
}

$id = $_GET['id'];

// Obtener datos completos
$sql = "SELECT c.*, m.*, p.nom_Prop, p.tel_Prop 
        FROM Consulta c 
        INNER JOIN Mascota m ON c.id_Mas = m.id_Mas 
        INNER JOIN Propietario p ON m.id_Prop = p.id_Prop 
        WHERE c.id_Consul = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$datos) die("Consulta no encontrada.");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta Médica - <?= $datos['nom_Mas'] ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #666; }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .info-group {
            flex: 1;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: block;
            font-size: 12px;
            text-transform: uppercase;
        }
        .value {
            font-size: 16px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 5px;
            display: block;
            width: 95%;
        }
        
        .section-title {
            margin-top: 30px;
            font-size: 18px;
            background: #eee;
            padding: 5px 10px;
            border-left: 5px solid #333;
        }
        
        .content-box {
            border: 1px solid #ddd;
            padding: 15px;
            min-height: 100px;
            margin-top: 10px;
            white-space: pre-wrap; /* Mantiene saltos de línea */
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .firma {
            margin-top: 80px;
            text-align: right;
        }
        .linea-firma {
            display: inline-block;
            width: 200px;
            border-top: 1px solid #333;
            text-align: center;
            padding-top: 5px;
        }

        /* Ocultar botón al imprimir */
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer;">IMPRIMIR / DESCARGAR PDF</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #ddd; border: none; cursor: pointer;">CERRAR</button>
    </div>

    <!-- MEMBRETE -->
    <div class="header">
        <h1>Clínica Veterinaria</h1>
        <p>Dr. Veterinario Responsable</p>
        <p>Dirección: Av. Principal 123 - Tel: 555-0000</p>
    </div>

    <!-- DATOS PACIENTE Y DUEÑO -->
    <div class="info-row">
        <div class="info-group">
            <span class="label">Paciente:</span>
            <span class="value"><?= $datos['nom_Mas'] ?> (<?= $datos['esp_Mas'] ?>)</span>
        </div>
        <div class="info-group">
            <span class="label">Raza:</span>
            <span class="value"><?= $datos['raz_Mas'] ?></span>
        </div>
        <div class="info-group">
            <span class="label">Peso:</span>
            <span class="value"><?= $datos['pes_Mas'] ?> Kg</span>
        </div>
    </div>

    <div class="info-row">
        <div class="info-group">
            <span class="label">Propietario:</span>
            <span class="value"><?= $datos['nom_Prop'] ?></span>
        </div>
        <div class="info-group">
            <span class="label">Fecha Consulta:</span>
            <span class="value"><?= $datos['fecha_Consul'] ?> - <?= $datos['hora_Consul'] ?></span>
        </div>
    </div>

    <!-- CONTENIDO MÉDICO -->
    <div class="section-title">DIAGNÓSTICO</div>
    <div class="content-box" style="min-height: 50px;">
        <?= $datos['diag_Consul'] ?>
    </div>

    <div class="section-title">TRATAMIENTO Y PRESCRIPCIÓN (Receta)</div>
    <div class="content-box" style="min-height: 200px; font-size: 1.1rem;">
        <?= $datos['trat_Consul'] ?>
    </div>

    <?php if($datos['prox_Consul']): ?>
    <div style="margin-top: 20px; font-weight: bold; border: 1px dashed #333; padding: 10px; text-align: center;">
        PRÓXIMA CITA SUGERIDA: <?= $datos['prox_Consul'] ?>
    </div>
    <?php endif; ?>

    <div class="firma">
        <div class="linea-firma">
            Firma y Sello del Médico
        </div>
    </div>

    <div class="footer">
        Este documento es un comprobante de atención médica veterinaria.<br>
        Generado el <?= date('d/m/Y H:i') ?>
    </div>

    <script>
        // Abrir diálogo de impresión automáticamente al cargar
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
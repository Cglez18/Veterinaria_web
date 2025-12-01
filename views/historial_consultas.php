<?php include '../php/historial_controller.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Clínico</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/img/veterinario.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos estilo "Timeline" para el historial */
        .timeline-item {
            border-left: 4px solid #1abc9c;
            margin-bottom: 20px;
            padding-left: 20px;
            position: relative;
        }
        .timeline-item::before {
            content: '';
            width: 15px; height: 15px;
            background: #1abc9c;
            border-radius: 50%;
            position: absolute;
            left: -9.5px; top: 0;
        }
        .fecha-badge {
            background: #2c3e50; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;
        }
        .tipo-badge {
            background: #3498db; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem; margin-left: 5px;
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-header">
            <span><i class="fa-solid fa-paw"></i> VETERINARIA</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../index.php"><i class="fa-solid fa-home"></i> Inicio</a></li>
            <li><a href="propietarios.php"><i class="fa-solid fa-user"></i> Propietarios</a></li>
            <li><a href="mascotas.php"><i class="fa-solid fa-dog"></i> Mascotas</a></li>
            <li><a href="consultas.php"><i class="fa-solid fa-stethoscope"></i> Consultas</a></li>
             <li><a href="producto_lista.php"><i class="fa-solid fa-boxes-stacked"></i> Ver Inventario</a></li>
            <li><a href="producto_registro.php"><i class="fa-solid fa-plus-circle"></i> Nuevo Producto</a></li>
            <li><a href="prescripciones.php"><i class="fa-solid fa-print"></i> Prescripciones</a></li>
            <li><a href="pagos.php"><i class="fa-solid fa-file-invoice-dollar"></i> Pagos</a></li>
            <li><a href="historial_consultas.php" class="active"><i class="fa-solid fa-clock"></i> Historial Clínico</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <div class="top-bar">
            <span class="menu-toggle"><i class="fa-solid fa-bars"></i></span>
            <span style="margin-left: auto; font-weight: bold;">Historial Médico</span>
        </div>

        <div class="container-flex" style="flex-direction: column;">
            
            <div class="form-panel" style="width: 100%;">
                <h3><i class="fa-solid fa-search"></i> Seleccionar Paciente</h3>
                <form action="" method="GET">
                    <label>Mascota:</label>
                    <select name="id_Mas" class="form-control" onchange="this.form.submit()" style="width: 100%; padding: 10px; font-size: 1.1rem;">
                        <option value="">-- Seleccione para ver historial --</option>
                        <?php foreach($mascotas_lista as $m): ?>
                            <option value="<?= $m['id_Mas'] ?>" <?= ($id_seleccionado == $m['id_Mas']) ? 'selected' : '' ?>>
                                <?= $m['nom_Mas'] ?> (Dueño: <?= $m['nom_Prop'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <?php if ($mascota_info): ?>
                
                <div class="info-card" style="background: white; padding: 20px; border-radius: 8px; display: flex; gap: 20px; align-items: center; border: 1px solid #ddd;">
                    <div style="font-size: 3rem; color: #1abc9c;">
                        <?php if($mascota_info['esp_Mas'] == 'Perro'): ?>
                            <i class="fa-solid fa-dog"></i>
                        <?php else: ?>
                        <i class="fa-solid fa-cat"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h2 style="margin: 0;"><?= $mascota_info['nom_Mas'] ?></h2>
                        <p style="color: #7f8c8d;">
                            <?= $mascota_info['esp_Mas'] ?> - <?= $mascota_info['raz_Mas'] ?> | 
                            <strong>Dueño:</strong> <?= $mascota_info['nom_Prop'] ?> |
                            <strong>Peso Actual:</strong> <?= $mascota_info['pes_Mas'] ?> Kg
                        </p>
                    </div>
                </div>

                <div class="table-panel" style="width: 100%;">
                    <h3>Historial de Visitas</h3>
                    
                    <?php if (count($historial) > 0): ?>
                        <div style="margin-top: 20px;">
                            <?php foreach($historial as $c): ?>
                                <div class="timeline-item">
                                    <div style="margin-bottom: 5px;">
                                        <span class="fecha-badge"><i class="fa-regular fa-calendar"></i> <?= $c['fecha_Consul'] ?></span>
                                        <span class="fecha-badge"><i class="fa-regular fa-clock"></i> <?= $c['hora_Consul'] ?></span>
                                        <span class="tipo-badge"><?= $c['tipo_Consul'] ?></span>
                                    </div>
                                    
                                    <h4 style="margin-top: 10px;">Diagnóstico:</h4>
                                    <p style="background: #f9f9f9; padding: 10px; border-radius: 5px;"><?= $c['diag_Consul'] ?></p>
                                    
                                    <h4 style="margin-top: 10px;">Tratamiento:</h4>
                                    <p style="background: #eef2f3; padding: 10px; border-radius: 5px; color: #2980b9;">
                                        <?= $c['trat_Consul'] ?>
                                    </p>

                                    <?php if($c['prox_Consul']): ?>
                                        <p style="color: #e67e22; font-weight: bold; font-size: 0.9rem;">
                                            <i class="fa-solid fa-bell"></i> Próxima Cita Sugerida: <?= $c['prox_Consul'] ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <hr style="border: 0; border-top: 1px dashed #ccc; margin: 20px 0;">
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px; color: #7f8c8d;">
                            <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 10px;"></i>
                            <p>Esta mascota aún no tiene consultas registradas.</p>
                        </div>
                    <?php endif; ?>
                </div>

            <?php elseif ($id_seleccionado != '' && !$mascota_info): ?>
                <p>Mascota no encontrada.</p>
            <?php endif; ?>

        </div>
    </main>

    <script src="../assets/js/main.js"></script>
</body>
</html>
<?php include '../php/prescripcion_controller.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Prescripción</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/img/veterinario.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .lista-consultas { list-style: none; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden; }
        .item-consulta { padding: 10px; border-bottom: 1px solid #eee; cursor: pointer; transition: 0.2s; display: block; text-decoration: none; color: #333; }
        .item-consulta:hover { background: #f1f1f1; }
        .item-consulta.active { background: #1abc9c; color: white; border-left: 5px solid #16a085; }
        
        /* Estilo para campos de solo lectura */
        .readonly-view { background-color: #f8f9fa; border: 1px solid #ced4da; color: #2c3e50; font-weight: 500; }
        textarea.readonly-view { resize: none; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
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
            <li><a href="prescripciones.php" class="active"><i class="fa-solid fa-print"></i> Prescripciones</a></li>
            <li><a href="pagos.php"><i class="fa-solid fa-file-invoice-dollar"></i> Pagos</a></li>
            <li><a href="historial_consultas.php"><i class="fa-solid fa-clock"></i> Historial Clínico</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <div class="top-bar">
            <span class="menu-toggle"><i class="fa-solid fa-bars"></i></span>
            <span style="margin-left: auto; font-weight: bold;">Generador de Recetas</span>
        </div>

        <div class="container-flex">
            
            <!-- COLUMNA IZQUIERDA: CALENDARIO Y LISTA -->
            <div class="form-panel" style="flex: 1; min-width: 250px;">
                <h3><i class="fa-regular fa-calendar"></i> Buscar por Fecha</h3>
                
                <!-- Formulario para cambiar fecha -->
                <form action="" method="GET">
                    <label>Seleccionar Día:</label>
                    <input type="date" name="fecha" value="<?= $fecha_seleccionada ?>" onchange="this.form.submit()" class="form-control" style="width: 100%;">
                </form>

                <hr style="margin: 15px 0;">
                
                <h4>Consultas del Día</h4>
                <?php if (count($lista_consultas) > 0): ?>
                    <div class="lista-consultas">
                        <?php foreach($lista_consultas as $c): ?>
                            <a href="?fecha=<?= $fecha_seleccionada ?>&id_Consul=<?= $c['id_Consul'] ?>" 
                               class="item-consulta <?= ($id_consulta_sel == $c['id_Consul']) ? 'active' : '' ?>">
                                <strong><i class="fa-regular fa-clock"></i> <?= $c['hora_Consul'] ?></strong> - <?= $c['nom_Mas'] ?><br>
                                <small>Dueño: <?= $c['nom_Prop'] ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: #7f8c8d; font-style: italic;">No hay consultas este día.</p>
                <?php endif; ?>
            </div>

            <!-- COLUMNA DERECHA: VISTA PREVIA Y BOTÓN -->
            <div class="form-panel" style="flex: 3;">
                <?php if ($detalle_consulta): ?>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3><i class="fa-solid fa-file-prescription"></i> Detalle de Consulta</h3>
                        
                        <!-- BOTÓN DE ACCIÓN PRINCIPAL -->
                        <a href="../php/imprimir_receta.php?id=<?= $detalle_consulta['id_Consul'] ?>" 
                           target="_blank" 
                           class="btn btn-blue" 
                           style="padding: 10px 20px; font-size: 1.1rem;">
                            <i class="fa-solid fa-print"></i> Imprimir / Generar PDF
                        </a>
                    </div>

                    <!-- DATOS DEL PACIENTE -->
                    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label>Paciente:</label>
                            <input type="text" value="<?= $detalle_consulta['nom_Mas'] ?>" class="readonly-view" readonly style="width: 100%;">
                        </div>
                        <div style="flex: 1;">
                            <label>Especie/Raza:</label>
                            <input type="text" value="<?= $detalle_consulta['esp_Mas'] ?> - <?= $detalle_consulta['raz_Mas'] ?>" class="readonly-view" readonly style="width: 100%;">
                        </div>
                        <div style="flex: 1;">
                            <label>Peso (Kg):</label>
                            <input type="text" value="<?= $detalle_consulta['pes_Mas'] ?>" class="readonly-view" readonly style="width: 100%;">
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <div style="flex: 2;">
                            <label>Propietario:</label>
                            <input type="text" value="<?= $detalle_consulta['nom_Prop'] ?>" class="readonly-view" readonly style="width: 100%;">
                        </div>
                        <div style="flex: 1;">
                            <label>Fecha Consulta:</label>
                            <input type="text" value="<?= $detalle_consulta['fecha_Consul'] ?> a las <?= $detalle_consulta['hora_Consul'] ?>" class="readonly-view" readonly style="width: 100%;">
                        </div>
                    </div>

                    <!-- DATOS MÉDICOS -->
                    <label>Diagnóstico:</label>
                    <textarea rows="3" class="readonly-view" readonly style="width: 100%; margin-bottom: 15px;"><?= $detalle_consulta['diag_Consul'] ?></textarea>

                    <label>Tratamiento / Receta:</label>
                    <textarea rows="5" class="readonly-view" readonly style="width: 100%; border-left: 5px solid #3498db;"><?= $detalle_consulta['trat_Consul'] ?></textarea>

                <?php else: ?>
                    <div style="text-align: center; padding: 50px; color: #95a5a6;">
                        <i class="fa-solid fa-arrow-left" style="font-size: 3rem;"></i>
                        <h2>Selecciona una consulta</h2>
                        <p>Elige una fecha y una consulta del listado para visualizar los datos y generar la receta.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>
    <script src="../assets/js/main.js"></script>
</body>
</html>
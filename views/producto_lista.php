<?php include '../php/producto_controller.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario General</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/img/veterinario.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos para las Pestañas (Tabs) */
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #ddd; }
        .tab-btn {
            padding: 10px 20px;
            background: #ecf0f1;
            border: none;
            border-radius: 5px 5px 0 0;
            cursor: pointer;
            font-weight: bold;
            color: #7f8c8d;
        }
        .tab-btn.active { background: #3498db; color: white; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        
        /* Semáforo de Stock */
        .stock-bajo { color: #e74c3c; font-weight: bold; }
        .stock-ok { color: #27ae60; font-weight: bold; }
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
            <li><a href="producto_lista.php" class="active"><i class="fa-solid fa-boxes-stacked"></i> Ver Inventario</a></li>
            <li><a href="producto_registro.php"><i class="fa-solid fa-plus-circle"></i> Nuevo Producto</a></li>
            <li><a href="prescripciones.php"><i class="fa-solid fa-print"></i> Prescripciones</a></li>
            <li><a href="pagos.php"><i class="fa-solid fa-file-invoice-dollar"></i> Pagos</a></li>
            <li><a href="historial_consultas.php"><i class="fa-solid fa-clock"></i> Historial Clínico</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <div class="top-bar">
            <span class="menu-toggle"><i class="fa-solid fa-bars"></i></span>
            <span style="margin-left: auto; font-weight: bold;">Inventario Total</span>
        </div>

        <div class="table-panel">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3>Existencias en Almacén</h3>
                <a href="producto_registro.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Registrar Entrada</a>
            </div>

            <div class="tabs" style="margin-top: 20px;">
                <button class="tab-btn active" onclick="abrirTab('tab1', this)">Medicinas</button>
                <button class="tab-btn" onclick="abrirTab('tab2', this)">Comida</button>
                <button class="tab-btn" onclick="abrirTab('tab3', this)">Accesorios</button>
            </div>

            <div id="tab1" class="tab-content active">
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Costo</th>
                                <th>Presentación</th>
                                <th>Vencimiento</th>
                                <th>Vía Admin</th>
                                <th>Tipo</th>
                                <th>Lab.</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($medicinas as $m): ?>
                            <tr>
                                <td><?= $m['nom_Producto'] ?></td>
                                <td class="<?= $m['stock'] < 5 ? 'stock-bajo' : 'stock-ok' ?>">
                                    <?= $m['stock'] ?> u.
                                </td>
                                <td>$<?= $m['cost_Producto'] ?></td>
                                <td><?= $m['pres_Medicina'] ?></td>
                                <td><?= $m['fvenci_Medicina'] ?></td>
                                <td><?= $m['admin_Medicina'] ?></td>
                                <td><?= $m['tipo_Medicina'] ?></td>
                                <td><?= $m['fabri_Medicina'] ?></td>
                                
                                <td>
                                    <a href="../php/producto_controller.php?eliminar=<?= $m['id_Producto'] ?>&tipo=Medicina" 
                                       class="btn btn-red" onclick="return confirm('¿Eliminar?');"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="tab2" class="tab-content">
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Costo</th>
                                <th>Tipo</th>
                                <th>Etapa Vida</th>
                                <th>Especie</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($comidas as $c): ?>
                            <tr>
                                <td><?= $c['nom_Producto'] ?></td>
                                <td class="<?= $c['stock'] < 5 ? 'stock-bajo' : 'stock-ok' ?>">
                                    <?= $c['stock'] ?> u.
                                </td>
                                <td>$<?= $c['cost_Producto'] ?></td>
                                <td><?= $c['tipo_Comida'] ?></td>
                                <td><?= $c['vida_Comida'] ?></td>
                                <td><?= $c['especie_Comida'] ?></td>
                                <td>
                                    <a href="../php/producto_controller.php?eliminar=<?= $c['id_Producto'] ?>&tipo=Comida" 
                                       class="btn btn-red" onclick="return confirm('¿Eliminar?');"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="tab3" class="tab-content">
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Costo</th>
                                <th>Tipo</th>
                                <th>Material</th>
                                <th>Talla</th>
                                <th>Descripción</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($accesorios as $a): ?>
                            <tr>
                                <td><?= $a['nom_Producto'] ?></td>
                                <td class="<?= $a['stock'] < 5 ? 'stock-bajo' : 'stock-ok' ?>">
                                    <?= $a['stock'] ?> u.
                                </td>
                                <td>$<?= $a['cost_Producto'] ?></td>
                                <td><?= $a['tipo_Accesorio'] ?></td>
                                <td><?= $a['mate_Accesorio'] ?></td>
                                <td><?= $a['talla_Accesorio'] ?></td>
                                <td><?= $a['descrip_Accesorio'] ?></td>
                                <td>
                                    <a href="../php/producto_controller.php?eliminar=<?= $a['id_Producto'] ?>&tipo=Accesorio" 
                                       class="btn btn-red" onclick="return confirm('¿Eliminar?');"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script src="../assets/js/main.js"></script>
    <script>
        function abrirTab(idTab, btn) {
            // 1. Ocultar todos los contenidos
            document.querySelectorAll('.tab-content').forEach(div => div.classList.remove('active'));
            // 2. Quitar clase active de todos los botones
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            
            // 3. Activar el seleccionado
            document.getElementById(idTab).classList.add('active');
            btn.classList.add('active');
        }
    </script>
</body>
</html>
<?php include '../php/mascota_controller.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Mascotas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/img/veterinario.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-header">
            <span><i class="fa-solid fa-paw"></i> VETERINARIA</span>
            <span class="close-btn"><i class="fa-solid fa-times"></i></span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../index.php"><i class="fa-solid fa-home"></i> Inicio</a></li>
            <li><a href="propietarios.php"><i class="fa-solid fa-user"></i> Propietarios</a></li>
            <li><a href="mascotas.php" class="active"><i class="fa-solid fa-dog"></i> Mascotas</a></li>
            <li><a href="consultas.php"><i class="fa-solid fa-stethoscope"></i> Consultas</a></li>
            <li><a href="producto_lista.php"><i class="fa-solid fa-boxes-stacked"></i> Ver Inventario</a></li>
            <li><a href="producto_registro.php"><i class="fa-solid fa-plus-circle"></i> Nuevo Producto</a></li>
            <li><a href="prescripciones.php"><i class="fa-solid fa-print"></i> Prescripciones</a></li>
            <li><a href="pagos.php"><i class="fa-solid fa-file-invoice-dollar"></i> Pagos</a></li>
            <li><a href="historial_consultas.php"><i class="fa-solid fa-clock"></i> Historial Clínico</a></li>
        </ul>
    </nav>

    <main class="main-content">
        
        <div class="top-bar">
            <span class="menu-toggle"><i class="fa-solid fa-bars"></i> Menú</span>
            <span style="margin-left: auto; font-weight: bold;">Mascotas</span>
        </div>

        <h2 style="padding: 0 10px;">Gestión de Mascotas</h2>

        <div class="container-flex">
            
            <div class="form-panel">
                <h3><i class="fa-solid fa-dog"></i> Datos de la Mascota</h3>
                <form action="../php/mascota_controller.php" method="POST">
                    <input type="hidden" name="accion" value="guardar" id="accion">
                    
                    <label>ID Mascota:</label>
                    <input type="text" name="id_Mas" id="id_Mas" readonly placeholder="Automático" 
                           style="background-color: #e9ecef; cursor: not-allowed; color: #6c757d;">
                    
                    <label>Dueño:</label>
                    <select name="id_Prop" id="id_Prop" required style="width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;">
                        <option value="">-- Seleccione un Dueño --</option>
                        <?php foreach($propietarios as $p): ?>
                            <option value="<?= $p['id_Prop'] ?>">
                                <?= $p['nom_Prop'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label>Nombre Mascota:</label>
                    <input type="text" name="nom_Mas" id="nom_Mas" required placeholder="Ej. Firulais">
                    
                    <div style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label>Especie:</label>
                            <select name="esp_Mas" id="esp_Mas" required style="width: 100%; padding: 10px; margin-bottom: 15px; border:1px solid #ccc; border-radius:4px;">
                                <option value="Perro">Perro</option>
                                <option value="Gato">Gato</option>
                                <option value="Ave">Ave</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label>Sexo:</label>
                            <select name="sex_Mas" id="sex_Mas" required style="width: 100%; padding: 10px; margin-bottom: 15px; border:1px solid #ccc; border-radius:4px;">
                                <option value="Macho">Macho</option>
                                <option value="Hembra">Hembra</option>
                            </select>
                        </div>
                    </div>

                    <label>Raza:</label>
                    <input type="text" name="raz_Mas" id="raz_Mas" required placeholder="Ej. Labrador">
                    
                    <div style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label>Edad (Años):</label>
                            <input type="number" name="edad_Mas" id="edad_Mas" required>
                        </div>
                        <div style="flex: 1;">
                            <label>Peso (Kg):</label>
                            <input type="number" step="0.1" name="pes_Mas" id="pes_Mas" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-green" style="width: 100%;">Guardar Mascota</button>
                    <button type="button" class="btn btn-blue" style="width: 100%; margin-top: 5px;" onclick="limpiar()">Nueva / Limpiar</button>
                </form>
            </div>

            <div class="table-panel">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <h3>Lista de Pacientes</h3>
                    <form action="" method="GET" style="display: flex; flex: 1; max-width: 300px;">
                        <input type="text" name="busqueda" placeholder="Buscar mascota..." style="margin-bottom: 0;">
                        <button type="submit" class="btn btn-blue"><i class="fa-solid fa-search"></i></button>
                    </form>
                </div>

                <div style="overflow-x: auto; margin-top: 10px;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Especie</th>
                                <th>Dueño</th> <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($mascotas as $m): ?>
                            <tr>
                                <td><?= $m['id_Mas'] ?></td>
                                <td><?= $m['nom_Mas'] ?></td>
                                <td><?= $m['esp_Mas'] ?> (<?= $m['raz_Mas'] ?>)</td>
                                <td><?= $m['nom_Prop'] ?></td> <td style="display: flex; gap: 5px;">
                                    <button class="btn btn-blue" onclick="editar(
                                        '<?= $m['id_Mas'] ?>', 
                                        '<?= $m['nom_Mas'] ?>', 
                                        '<?= $m['esp_Mas'] ?>', 
                                        '<?= $m['raz_Mas'] ?>', 
                                        '<?= $m['edad_Mas'] ?>', 
                                        '<?= $m['sex_Mas'] ?>', 
                                        '<?= $m['pes_Mas'] ?>', 
                                        '<?= $m['id_Prop'] ?>'
                                    )"><i class="fa-solid fa-pen"></i></button>

                                    <a href="../php/mascota_controller.php?eliminar=<?= $m['id_Mas'] ?>" 
                                       class="btn btn-red" onclick="return confirm('¿Seguro que deseas eliminar a esta mascota?');">
                                       <i class="fa-solid fa-trash"></i>
                                    </a>
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
        function editar(id, nombre, especie, raza, edad, sexo, peso, idProp) {
            document.getElementById('id_Mas').value = id;
            document.getElementById('nom_Mas').value = nombre;
            document.getElementById('esp_Mas').value = especie;
            document.getElementById('raz_Mas').value = raza;
            document.getElementById('edad_Mas').value = edad;
            document.getElementById('sex_Mas').value = sexo;
            document.getElementById('pes_Mas').value = peso;
            
            // Aquí seleccionamos automáticamente al dueño en el Combobox
            document.getElementById('id_Prop').value = idProp;

            document.getElementById('accion').value = 'editar';
        }

        function limpiar() {
            document.getElementById('id_Mas').value = '';
            document.getElementById('nom_Mas').value = '';
            document.getElementById('raz_Mas').value = '';
            document.getElementById('edad_Mas').value = '';
            document.getElementById('pes_Mas').value = '';
            document.getElementById('id_Prop').value = ''; // Resetear combobox
            document.getElementById('accion').value = 'guardar';
        }
    </script>
</body>
</html>
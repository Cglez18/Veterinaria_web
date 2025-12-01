<?php include '../php/propietario_controller.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Gestión de Propietarios</title>
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
            <li><a href="propietarios.php" class="active"><i class="fa-solid fa-user"></i> Propietarios</a></li>
            <li><a href="mascotas.php"><i class="fa-solid fa-dog"></i> Mascotas</a></li>
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
            <span style="margin-left: auto; font-weight: bold;">Propietarios</span>
        </div>

        <h2 style="padding: 0 10px;">Gestión de Propietarios</h2>

        <div class="container-flex">
            
            <div class="form-panel">
                <h3><i class="fa-solid fa-user-plus"></i> Datos</h3>
                <form action="../php/propietario_controller.php" method="POST">
                    <input type="hidden" name="accion" value="guardar" id="accion">
                    
                    <label>ID:</label>
                    <input type="text" name="id_Prop" id="id_Prop" readonly placeholder="Automático" 
                           style="background-color: #e9ecef; cursor: not-allowed; color: #6c757d;">
                    
                    <label>Nombre:</label>
                    <input type="text" name="nom_Prop" id="nom_Prop" required placeholder="Juan Pérez">
                    
                    <label>Dirección:</label>
                    <input type="text" name="direc_Prop" id="direc_Prop" placeholder="Dirección">
                    
                    <label>Teléfono:</label>
                    <input type="text" name="tel_Prop" id="tel_Prop" required placeholder="55-12345678">
                    
                    <label>Email:</label>
                    <input type="email" name="mail_Prop" id="mail_Prop" required placeholder="example@dominio">

                    <button type="submit" class="btn btn-green" style="width: 100%;">Guardar</button>
                    <button type="button" class="btn btn-blue" style="width: 100%; margin-top: 5px;" onclick="limpiar()">Nuevo / Limpiar</button>
                </form>
            </div>

            <div class="table-panel">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <h3>Lista</h3>
                    <form action="" method="GET" style="display: flex; flex: 1; max-width: 300px;">
                        <input type="text" name="busqueda" placeholder="Buscar..." style="margin-bottom: 0;">
                        <button type="submit" class="btn btn-blue"><i class="fa-solid fa-search"></i></button>
                    </form>
                </div>

                <div style="overflow-x: auto; margin-top: 10px;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($propietarios as $prop): ?>
                            <tr>
                                <td><?= $prop['id_Prop'] ?></td>
                                <td><?= $prop['nom_Prop'] ?></td>
                                <td><?= $prop['tel_Prop'] ?></td>
                                <td><?= $prop['mail_Prop'] ?></td>
                                <td style="display: flex; gap: 5px;">
                                    <button class="btn btn-blue" onclick="editar(
                                        '<?= $prop['id_Prop'] ?>', '<?= $prop['nom_Prop'] ?>', '<?= $prop['direc_Prop'] ?>', '<?= $prop['tel_Prop'] ?>', '<?= $prop['mail_Prop'] ?>'
                                    )"><i class="fa-solid fa-pen"></i></button>

                                    <a href="../php/propietario_controller.php?eliminar=<?= $prop['id_Prop'] ?>" 
                                       class="btn btn-red" onclick="return confirm('¿Eliminar?');">
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
        function editar(id, nombre, direc, tel, mail) {
            document.getElementById('id_Prop').value = id;
            document.getElementById('id_Prop').readOnly = true;
            document.getElementById('nom_Prop').value = nombre;
            document.getElementById('direc_Prop').value = direc;
            document.getElementById('tel_Prop').value = tel;
            document.getElementById('mail_Prop').value = mail;
            document.getElementById('accion').value = 'editar';
        }
        function limpiar() {
            document.getElementById('id_Prop').value = '';
            document.getElementById('id_Prop').readOnly = false;
            document.getElementById('nom_Prop').value = '';
            document.getElementById('direc_Prop').value = '';
            document.getElementById('tel_Prop').value = '';
            document.getElementById('mail_Prop').value = '';
            document.getElementById('accion').value = 'guardar';
        }
    </script>
</body>
</html>
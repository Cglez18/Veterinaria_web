<?php include '../config/db.php'; // Solo necesitamos conexión, el post va al controller ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/img/veterinario.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .seccion-especifica { display: none; padding: 15px; background: #f8f9fa; border-left: 4px solid #1abc9c; margin-bottom: 15px; }
        .mostrar { display: block; }
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
            <li><a href="producto_registro.php" class="active"><i class="fa-solid fa-plus-circle"></i> Nuevo Producto</a></li>
            <li><a href="prescripciones.php"><i class="fa-solid fa-print"></i> Prescripciones</a></li>
            <li><a href="pagos.php"><i class="fa-solid fa-file-invoice-dollar"></i> Pagos</a></li>
            <li><a href="historial_consultas.php"><i class="fa-solid fa-clock"></i> Historial Clínico</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <div class="top-bar">
            <span class="menu-toggle"><i class="fa-solid fa-bars"></i></span>
            <span style="margin-left: auto; font-weight: bold;">Registrar Entrada de Almacén</span>
        </div>

        <div class="form-panel" style="max-width: 800px; margin: 0 auto;">
            <h3><i class="fa-solid fa-cart-plus"></i> Nuevo Producto</h3>
            
            <form action="../php/producto_controller.php" method="POST">
                <input type="hidden" name="tipo_seleccionado" id="tipo_seleccionado_input" value="Medicina">

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label>Tipo de Producto:</label>
                        <select id="selector_tipo" class="form-control" onchange="cambiarFormulario(this.value)" style="width: 100%; padding: 10px;">
                            <option value="Medicina">Medicina</option>
                            <option value="Comida">Comida</option>
                            <option value="Accesorio">Accesorio</option>
                        </select>
                    </div>
                    <div style="flex: 2;">
                        <label>Nombre del Producto:</label>
                        <input type="text" name="nom_Producto" required placeholder="Ej. Amoxicilina 500mg">
                    </div>
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label>Costo Unitario ($):</label>
                        <input type="number" step="0.01" name="cost_Producto" required placeholder="0.00">
                    </div>
                    <div style="flex: 1;">
                        <label style="color: #2980b9; font-weight: bold;">Cantidad Inicial (Stock):</label>
                        <input type="number" name="stock" required placeholder="0" style="border: 2px solid #2980b9;">
                    </div>
                </div>

                <div id="form_Medicina" class="seccion-especifica mostrar">
                    <h4>Detalles de Medicina</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <input type="text" name="fvenci_Medicina" placeholder="Fecha Vencimiento (DD/MM/AAAA)">
                        <input type="text" name="pres_Medicina" placeholder="Presentación (Ej. Caja 10 tabs)">
                        <input type="text" name="admin_Medicina" placeholder="Vía Administración (Ej. Oral)">
                        <input type="text" name="especie_Medicina" placeholder="Uso en (Perro/Gato)">
                        <input type="text" name="tipo_Medicina" placeholder="Tipo (Antibiótico, Analgésico)">
                        <input type="text" name="fabri_Medicina" placeholder="Laboratorio / Fabricante">
                    </div>
                </div>

                <div id="form_Comida" class="seccion-especifica">
                    <h4>Detalles de Alimento</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <input type="text" name="tipo_Comida" placeholder="Tipo (Seca, Húmeda, Premios)">
                        <input type="text" name="vida_Comida" placeholder="Etapa (Cachorro, Adulto)">
                        <input type="text" name="especie_Comida" placeholder="Especie Destino">
                    </div>
                </div>

                <div id="form_Accesorio" class="seccion-especifica">
                    <h4>Detalles de Accesorio</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <input type="text" name="tipo_Accesorio" placeholder="Tipo (Correa, Juguete, Cama)">
                        <input type="text" name="mate_Accesorio" placeholder="Material">
                        <input type="text" name="talla_Accesorio" placeholder="Talla (S, M, L, XL)">
                        <input type="text" name="descrip_Accesorio" placeholder="Descripción breve">
                    </div>
                </div>

                <hr>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="submit" class="btn btn-green" style="padding: 12px 30px; font-size: 1rem;">
                        <i class="fa-solid fa-save"></i> Registrar Entrada
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script src="../assets/js/main.js"></script>
    <script>
        function cambiarFormulario(tipo) {
            document.querySelectorAll('.seccion-especifica').forEach(div => div.classList.remove('mostrar'));
            document.getElementById('form_' + tipo).classList.add('mostrar');
            document.getElementById('tipo_seleccionado_input').value = tipo;
        }
    </script>
</body>
</html>
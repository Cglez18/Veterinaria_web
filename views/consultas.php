<?php include '../php/consulta_controller.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Consulta</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/img/veterinario.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos extra para los bloques de información */
        .info-card {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .info-card h4 { margin-bottom: 10px; color: #2c3e50; border-bottom: 2px solid #1abc9c; display: inline-block; }
        
        .readonly-field { background-color: #e9ecef; border: 1px solid #ced4da; color: #495057; }
        
        textarea {
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; resize: vertical; min-height: 80px;
        }
    </style>
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
            <li><a href="mascotas.php"><i class="fa-solid fa-dog"></i> Mascotas</a></li>
            <li><a href="consultas.php" class="active"><i class="fa-solid fa-stethoscope"></i> Consultas</a></li>
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
            <span style="margin-left: auto; font-weight: bold;">Nueva Consulta Médica</span>
        </div>

        <div class="container-flex">
            <div class="form-panel" style="flex: 3;"> <form action="../php/consulta_controller.php" method="POST">
                    
                    <div class="info-card">
                        <h4><i class="fa-solid fa-search"></i> Selección de Paciente</h4>
                        <div style="display: flex; gap: 10px; align-items: flex-end;">
                            <div style="flex: 1;">
                                <label>Buscar Mascota Registrada:</label>
                                <select name="id_Mas" id="select_mascota" class="form-control" required onchange="cargarDatosMascota(this.value)" style="width: 100%; padding: 10px;">
                                    <option value="">-- Seleccione Mascota --</option>
                                    <?php foreach($mascotas_lista as $m): ?>
                                        <option value="<?= $m['id_Mas'] ?>"><?= $m['nom_Mas'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <a href="mascotas.php" class="btn btn-blue" title="Registrar Nueva Mascota"><i class="fa-solid fa-plus"></i> Mascota Nueva</a>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                        
                        <div class="info-card" style="flex: 1; min-width: 250px;">
                            <h4><i class="fa-solid fa-dog"></i> Datos del Paciente</h4>
                            
                            <label>Dueño:</label>
                            <input type="text" id="txt_propietario" class="readonly-field" readonly>
                            
                            <label>Raza/Especie:</label>
                            <input type="text" id="txt_raza" class="readonly-field" readonly>
                            
                            <label>Peso Registrado (Kg):</label>
                            <input type="text" id="txt_peso_anterior" class="readonly-field" readonly>
                            
                            <label style="color: #e74c3c; font-weight: bold;">Actualizar Peso (Kg):</label>
                            <input type="number" step="0.1" name="pes_Mas_Actual" id="txt_peso_actual" required style="border: 2px solid #1abc9c;">
                        </div>

                        <div class="info-card" style="flex: 2; min-width: 300px;">
                            <h4><i class="fa-solid fa-user-doctor"></i> Detalle Médico</h4>
                            
                            <div style="display: flex; gap: 10px;">
                                <div style="flex: 1;">
                                    <label>Fecha:</label>
                                    <input type="date" name="fecha_Consul" id="fecha_Consul" required class="readonly-field">
                                </div>
                                <div style="flex: 1;">
                                    <label>Hora:</label>
                                    <input type="time" name="hora_Consul" id="hora_Consul" required class="readonly-field">
                                </div>
                                <div style="flex: 1;">
                                    <label>Tipo:</label>
                                    <select name="tipo_Consul" required style="width: 100%; padding: 10px;">
                                        <option value="Consulta">Consulta General</option>
                                        <option value="Vacunacion">Vacunación</option>
                                        <option value="Urgencia">Urgencia</option>
                                        <option value="Control">Control</option>
                                        <option value="Cirugia">Cirugía</option>
                                    </select>
                                </div>
                            </div>

                            <label>Diagnóstico:</label>
                            <textarea name="diag_Consul" rows="3" placeholder="Escriba el diagnóstico..." required></textarea>

                            <label>Tratamiento:</label>
                            <textarea name="trat_Consul" rows="3" placeholder="Medicamentos, dosis, indicaciones..." required></textarea>
                            
                            <label>Próxima Cita (Opcional):</label>
                            <input type="date" name="prox_Consul">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-green" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 10px;">
                        <i class="fa-solid fa-save"></i> Guardar Consulta y Actualizar Peso
                    </button>

                </form>
            </div>
            

        </div>
    </main>

    <script src="../assets/js/main.js"></script>
    <script>
        //Poner Fecha y Hora Automática al cargar
        document.addEventListener('DOMContentLoaded', () => {
            const ahora = new Date();
            // Formato fecha YYYY-MM-DD
            document.getElementById('fecha_Consul').value = ahora.toISOString().split('T')[0];
            // Formato hora HH:MM
            const hora = ahora.getHours().toString().padStart(2, '0') + ':' + ahora.getMinutes().toString().padStart(2, '0');
            document.getElementById('hora_Consul').value = hora;
        });

        //Función para cargar datos de la mascota
        function cargarDatosMascota(id) {
            if(!id) {
                limpiarCampos();
                return;
            }

            // Llamada al archivo PHP que devuelve datos de la mascota
            fetch(`../php/get_mascota.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if(data) {
                        document.getElementById('txt_propietario').value = data.nom_Prop;
                        document.getElementById('txt_raza').value = data.esp_Mas + " - " + data.raz_Mas;
                        document.getElementById('txt_peso_anterior').value = data.pes_Mas;
                        
                        // Por defecto, ponemos el peso actual igual al anterior, para que solo lo edite si cambió
                        document.getElementById('txt_peso_actual').value = data.pes_Mas;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function limpiarCampos() {
            document.getElementById('txt_propietario').value = "";
            document.getElementById('txt_raza').value = "";
            document.getElementById('txt_peso_anterior').value = "";
            document.getElementById('txt_peso_actual').value = "";
        }
    </script>
</body>
</html>
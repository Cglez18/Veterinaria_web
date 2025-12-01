<?php include '../php/pago_controller.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja / Pagos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/img/veterinario.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .grid-servicios { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; margin-bottom: 20px; }
        .btn-servicio { padding: 15px 10px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer; text-align: center; transition: 0.2s; font-size: 0.9rem; }
        .btn-servicio:hover { background: #2980b9; transform: translateY(-2px); }
        .btn-servicio span { display: block; font-weight: bold; font-size: 1.1rem; margin-top: 5px; }

        .lista-productos { max-height: 300px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px; }
        .item-producto { display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid #eee; cursor: pointer; }
        .item-producto:hover { background: #f9f9f9; }
        /* Clase para deshabilitar visualmente si no hay stock */
        .sin-stock { opacity: 0.5; pointer-events: none; background: #eee; }

        .ticket-panel { background: white; border: 2px solid #2c3e50; display: flex; flex-direction: column; height: 100%; }
        .ticket-header { background: #2c3e50; color: white; padding: 10px; text-align: center; }
        .ticket-body { flex: 1; padding: 10px; overflow-y: auto; }
        .ticket-row { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px dashed #ccc; }
        .ticket-footer { background: #ecf0f1; padding: 20px; text-align: right; }
        .total-price { font-size: 2rem; font-weight: bold; color: #27ae60; }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-header"><span><i class="fa-solid fa-paw"></i> VETERINARIA</span></div>
        <ul class="sidebar-menu">
            <li><a href="../index.php"><i class="fa-solid fa-home"></i> Inicio</a></li>
            <li><a href="propietarios.php"><i class="fa-solid fa-user"></i> Propietarios</a></li>
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
            <span class="menu-toggle"><i class="fa-solid fa-bars"></i></span>
            <span style="margin-left: auto; font-weight: bold;">Punto de Venta</span>
        </div>

        <div class="container-flex">
            
            <div style="flex: 2; display: flex; flex-direction: column; gap: 20px;">
                
                <div class="form-panel">
                    <h3><i class="fa-solid fa-user-doctor"></i> Servicios Clínicos</h3>
                    <div class="grid-servicios">
                        <?php foreach($servicios_fijos as $s): ?>
                            <button class="btn-servicio" onclick="agregarServicio('<?= $s['nombre'] ?>', <?= $s['precio'] ?>)">
                                <?= $s['nombre'] ?>
                                <span>$<?= $s['precio'] ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-panel" style="flex: 1;">
                    <h3><i class="fa-solid fa-box-open"></i> Productos</h3>
                    <input type="text" id="buscador" placeholder="Buscar producto..." onkeyup="filtrarProductos()" style="width: 100%; margin-bottom: 10px; padding: 10px;">
                    
                    <div class="lista-productos" id="listaProd">
                        <?php foreach($productos_inv as $p): ?>
                            <div class="item-producto" 
                                 onclick="agregarProducto(<?= $p['id_Producto'] ?>, '<?= $p['nom_Producto'] ?>', <?= $p['cost_Producto'] ?>, <?= $p['stock'] ?>)">
                                <div>
                                    <strong><?= $p['nom_Producto'] ?></strong><br>
                                    <small style="color: #7f8c8d;">
                                        Stock: <span id="stock_display_<?= $p['id_Producto'] ?>"><?= $p['stock'] ?></span>
                                    </small>
                                </div>
                                <div style="font-weight: bold; color: #2980b9;">
                                    $<?= $p['cost_Producto'] ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <form action="../php/imprimir_ticket.php" method="POST" target="_blank" class="ticket-panel">
                    <div class="ticket-header">
                        <h3>Orden de Pago</h3>
                        <small><?= date('d/m/Y') ?></small>
                    </div>

                    <div class="ticket-body" id="ticket-body">
                        <p style="text-align: center; color: #999; margin-top: 20px;">Lista vacía</p>
                    </div>

                    <div class="ticket-footer">
                        <div>TOTAL A PAGAR:</div>
                        <div class="total-price">$<span id="txt-total">0.00</span></div>
                        
                        <input type="hidden" name="lista_items" id="input_lista">
                        <input type="hidden" name="total_venta" id="input_total">

                        <button type="submit" class="btn btn-green" style="width: 100%; margin-top: 15px; font-size: 1.2rem;" onclick="setTimeout(()=>location.reload(), 1000)">
                            <i class="fa-solid fa-print"></i> PAGAR Y GENERAR TICKET
                        </button>
                        <button type="button" onclick="limpiarTodo()" class="btn btn-red" style="width: 100%; margin-top: 5px;">
                            <i class="fa-solid fa-trash"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>
    
    <script src="../assets/js/main.js"></script>
    <script>
        let carrito = [];

        // AGREGAR SERVICIO (Sin límite de stock)
        function agregarServicio(nombre, precio) {
            carrito.push({ 
                tipo: 'servicio', // Marcamos que es servicio
                id: null,
                nombre: nombre, 
                precio: parseFloat(precio) 
            });
            renderizarTicket();
        }

        // AGREGAR PRODUCTO (Con validación de stock)
        function agregarProducto(id, nombre, precio, stockMaximo) {
            // Contamos cuántos de este producto hay ya en el carrito
            const cantidadEnCarrito = carrito.filter(item => item.id === id).length;

            if (cantidadEnCarrito >= stockMaximo) {
                alert("¡No puedes agregar más! Stock insuficiente.");
                return; // Detiene la función
            }

            carrito.push({ 
                tipo: 'producto', // Marcamos que es producto
                id: id,
                nombre: nombre, 
                precio: parseFloat(precio),
                stockMax: stockMaximo 
            });
            renderizarTicket();
        }

        function eliminarItem(index) {
            carrito.splice(index, 1);
            renderizarTicket();
        }

        function limpiarTodo() {
            carrito = [];
            renderizarTicket();
        }

        function renderizarTicket() {
            const contenedor = document.getElementById('ticket-body');
            const txtTotal = document.getElementById('txt-total');
            const inputLista = document.getElementById('input_lista');
            const inputTotal = document.getElementById('input_total');
            
            contenedor.innerHTML = '';
            let total = 0;

            if(carrito.length === 0) {
                contenedor.innerHTML = '<p style="text-align: center; color: #999; margin-top: 20px;">Lista vacía</p>';
            }

            carrito.forEach((item, index) => {
                total += item.precio;
                
                const div = document.createElement('div');
                div.className = 'ticket-row';
                div.innerHTML = `
                    <span>${item.nombre}</span>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <span>$${item.precio.toFixed(2)}</span>
                        <i class="fa-solid fa-times" style="color:red; cursor:pointer;" onclick="eliminarItem(${index})"></i>
                    </div>
                `;
                contenedor.appendChild(div);
            });

            txtTotal.innerText = total.toFixed(2);
            inputTotal.value = total.toFixed(2);
            inputLista.value = JSON.stringify(carrito);
        }

        function filtrarProductos() {
            const texto = document.getElementById('buscador').value.toLowerCase();
            const items = document.querySelectorAll('.item-producto');
            items.forEach(item => {
                const nombre = item.innerText.toLowerCase();
                item.style.display = nombre.includes(texto) ? 'flex' : 'none';
            });
        }
    </script>
</body>
</html>
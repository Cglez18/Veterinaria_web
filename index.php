<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Sistema Veterinaria</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="../assets/img/veterinario.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-header">
            <span><i class="fa-solid fa-paw"></i> VETERINARIA</span>
            <span class="close-btn"><i class="fa-solid fa-times"></i></span> </div>
        <ul class="sidebar-menu">
            <li><a href="index.php" class="active"><i class="fa-solid fa-home"></i> Inicio</a></li>
            <li><a href="views/propietarios.php"><i class="fa-solid fa-user"></i> Propietarios</a></li>
            <li><a href="views/mascotas.php"><i class="fa-solid fa-dog"></i> Mascotas</a></li>
            <li><a href="views/consultas.php"><i class="fa-solid fa-stethoscope"></i> Consultas</a></li>
            <li><a href="views/producto_registro.php"><i class="fa-solid fa-box-open"></i> Inventario</a></li>  
            <li><a href="views/prescripciones.php"><i class="fa-solid fa-print"></i> Prescripciones</a></li>
            <li><a href="views/pagos.php"><i class="fa-solid fa-file-invoice-dollar"></i> Pagos</a></li>
            <li><a href="views/historial_consultas.php"><i class="fa-solid fa-clock"></i> Historial Clínico</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <div class="top-bar">
            <span class="menu-toggle"><i class="fa-solid fa-bars"></i> Menú</span>
        </div>

        <div class="hero-section">
            <h1>Bienvenido a Veterinaria</h1>
            <p>Sistema de Gestión Integral</p>
            <a href="views/consultas.php" class="btn btn-green" style="margin-top: 20px;">Nueva Consulta</a>
        </div>
    </main>

    <script src="assets/js/main.js"></script>
</body>
</html>
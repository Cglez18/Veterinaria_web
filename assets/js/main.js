document.addEventListener('DOMContentLoaded', () => {
    // 1. Resaltar enlace activo
    const links = document.querySelectorAll('.sidebar-menu a');
    links.forEach(link => {
        if(link.href === window.location.href){
            link.classList.add('active');
        }
    });

    // 2. Lógica del Menú Hamburguesa (Mobile)
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.querySelector('.menu-toggle'); // Botón abrir
    const closeBtn = document.querySelector('.close-btn');     // Botón cerrar (X)
    
    // Abrir menú
    if(menuToggle){
        menuToggle.addEventListener('click', () => {
            sidebar.classList.add('active');
        });
    }

    // Cerrar menú
    if(closeBtn){
        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    }

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
        if(window.innerWidth < 768) { 
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
});
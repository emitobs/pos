// Deshabilitar el clic derecho
document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});

// Deshabilitar la tecla F12 y otras teclas de acceso rápido
document.addEventListener('keydown', function (e) {
    if (e.key === 'F12' || e.ctrlKey || e.shiftKey || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
        e.preventDefault();
    }
});

// Bloquear la inspección de elementos y las herramientas de desarrollo
document.addEventListener('keydown', function (e) {
    if ((e.ctrlKey && e.shiftKey && e.key === 'C') || // Bloquear inspeccionar elementos
        (e.ctrlKey && e.shiftKey && e.key === 'J') || // Bloquear consola JavaScript
        (e.ctrlKey && e.shiftKey && e.key === 'U') || // Bloquear ver código fuente
        (e.ctrlKey && e.key === 'U') || // Bloquear ver código fuente en Chrome
        (e.ctrlKey && e.key === 'S')) { // Bloquear guardar página
        e.preventDefault();
    }
});

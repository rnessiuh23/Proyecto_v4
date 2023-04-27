
  // Seleccionar el elemento de preloader
const preloader = document.querySelector('.preloader');

// Seleccionar la barra de progreso
const progressBar = document.querySelector('.progress-bar');

// Agregar la clase 'loaded' al elemento de preloader después de que se haya cargado la página
window.addEventListener('load', function() {
  // Animar la barra de progreso
  let width = 0;
  let interval = setInterval(function() {
    if (width >= 100) {
      clearInterval(interval);
      setTimeout(function() {
        // Ocultar el preloader después de 1 segundo
        preloader.classList.add('loaded');
      }, 0);
    } else {
      width += 5;
      progressBar.style.width = width + '%';
    }
  }, 50);
});
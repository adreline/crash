document.addEventListener('DOMContentLoaded', () => {

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    document.getElementById('burger').addEventListener('click', () => {
        document.getElementById('burger').classList.toggle('is-active');
        document.getElementById('menu').classList.toggle('is-active');
      });
  });
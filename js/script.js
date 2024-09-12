// Navbar
function toggleNavbar() {
    const navbar = document.getElementById('navbar');
    const menuIcon = document.getElementById('menu-icon');

    // Toggle the visibility of the navbar
    navbar.classList.toggle('hidden');

    // Toggle between bars and cross icon
    if (navbar.classList.contains('hidden')) {
      menuIcon.classList.remove('fa-times');
      menuIcon.classList.add('fa-bars');
    } else {
      menuIcon.classList.remove('fa-bars');
      menuIcon.classList.add('fa-times');
    }
  }
  function toggleShop() {
    const shop = document.getElementById('shop');
    const menu = document.getElementById('menu');

    // Check if the menu currently has the 'hidden' class
    if (menu.classList.contains('hidden')) {
        // Remove 'hidden' and add 'grid' class
        menu.classList.remove('hidden');
        menu.classList.add('grid');
    } else {
        // Remove 'grid' and add 'hidden' class
        menu.classList.remove('grid');
        menu.classList.add('hidden');
    }
}

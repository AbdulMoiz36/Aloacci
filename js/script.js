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


// Product Details
 // Function to change the main image source
 function changeImage(src) {
  document.getElementById('mainImage').src = src;
}

// Increment function
function increment() {
  var qty = document.getElementById('quantity');
  qty.value = parseInt(qty.value) + 1;
}

// Decrement function
function decrement() {
  var qty = document.getElementById('quantity');
  if (qty.value > 1) {
      qty.value = parseInt(qty.value) - 1;
  }
}

// Function to show the clicked tab's content
function showTab(tabId) {
  // Hide all content
  const allContent = document.querySelectorAll('.tab-content');
  allContent.forEach(content => content.classList.remove('active'));

  // Remove active state from all tab buttons
  const allTabs = document.querySelectorAll('.tab-button');
  allTabs.forEach(tab => tab.classList.remove('active-tab'));

  // Show the selected tab content
  document.getElementById(tabId).classList.add('active');

  // Add active state to the clicked tab button
  event.target.classList.add('active-tab');
}
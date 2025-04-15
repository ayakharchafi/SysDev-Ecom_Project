// tern_application/public/js/main.js
document.addEventListener('DOMContentLoaded', function() {
    // Get Elements
    const functionsButton = document.getElementById('functionsButton');
    const functionsDropdown = document.getElementById('functionsDropdown');
    const functionsArrow = document.getElementById('functionsArrow');
    
    const clientsButton = document.getElementById('clientsButton');
    const clientsDropdown = document.getElementById('clientsDropdown');
    const clientsArrow = document.getElementById('clientsArrow');
  
    // Toggle Functions Menu
    functionsButton.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleMenu(functionsDropdown, functionsArrow);
      closeOtherMenu(clientsDropdown, clientsArrow);
    });
  
    // Toggle Clients Menu
    clientsButton.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleMenu(clientsDropdown, clientsArrow);
      closeOtherMenu(functionsDropdown, functionsArrow);
    });
  
    // Close All Menus on Outside Click
    document.addEventListener('click', function() {
      closeMenu(functionsDropdown, functionsArrow);
      closeMenu(clientsDropdown, clientsArrow);
    });
  
    // Helper Functions
    function toggleMenu(menu, arrow) {
      const isActive = menu.classList.contains('active');
      menu.classList.toggle('active', !isActive);
      arrow.classList.toggle('rotated', !isActive);
    }
  
    function closeOtherMenu(menu, arrow) {
      menu.classList.remove('active');
      arrow.classList.remove('rotated');
    }
  
    function closeMenu(menu, arrow) {
      menu.classList.remove('active');
      arrow.classList.remove('rotated');
    }
  });
function getTheme() {
  var theme = localStorage.getItem('preferredTheme');
  if (theme === 'dark') {
   document.documentElement.style.setProperty('--bg', '#1e1e1e');
   document.documentElement.style.setProperty('--text', '#f0f0f0');
   document.documentElement.style.setProperty('--sidebar-bg', '#121212');
   document.documentElement.style.setProperty('--button-bg', '#444');
   document.documentElement.style.setProperty('--button-hover', '#666');
   document.documentElement.style.setProperty('--exit-bg', '#222');
   document.documentElement.style.setProperty('--exit-hover', '#444');
   document.documentElement.style.setProperty('--bg2', '#2c2b2b');
 } else {
   document.documentElement.style.setProperty('--bg', '#ffffff');
   document.documentElement.style.setProperty('--text', '#333');
   document.documentElement.style.setProperty('--sidebar-bg', 'whitesmoke');
   document.documentElement.style.setProperty('--button-bg', '#3498db');
   document.documentElement.style.setProperty('--button-hover', '#2980b9');
   document.documentElement.style.setProperty('--exit-bg', 'black');
   document.documentElement.style.setProperty('--exit-hover', '#333');
   document.documentElement.style.setProperty('--bg2', '#2c2b2b');
 }
   
}

function changeTheme(theme) {
  if (theme === 'dark') {
    document.documentElement.style.setProperty('--bg', '#1e1e1e');
    document.documentElement.style.setProperty('--text', '#f0f0f0');
    document.documentElement.style.setProperty('--sidebar-bg', '#121212');
    document.documentElement.style.setProperty('--button-bg', '#444');
    document.documentElement.style.setProperty('--button-hover', '#666');
    document.documentElement.style.setProperty('--exit-bg', '#222');
    document.documentElement.style.setProperty('--exit-hover', '#444');
  } else {
    document.documentElement.style.setProperty('--bg', '#ffffff');
    document.documentElement.style.setProperty('--text', '#333');
    document.documentElement.style.setProperty('--sidebar-bg', 'whitesmoke');
    document.documentElement.style.setProperty('--button-bg', '#3498db');
    document.documentElement.style.setProperty('--button-hover', '#2980b9');
    document.documentElement.style.setProperty('--exit-bg', 'black');
    document.documentElement.style.setProperty('--exit-hover', '#333');
  }
  
  // Save theme preference to localStorage
  localStorage.setItem('preferredTheme', theme);
}

// Add this function to handle table row selection
function setupTableRowSelection(tableId) {
  const table = document.getElementById(tableId);
  if (!table) return;
  
  const rows = table.querySelectorAll('tbody tr');
  
  rows.forEach(row => {
    // Add click event listener to each row
    row.addEventListener('click', function(e) {
      // Skip if clicking on action buttons or checkboxes
      if (e.target.closest('.action-btn') || e.target.type === 'checkbox') {
        return;
      }
      
      // Remove 'selected' class from all rows
      rows.forEach(r => r.classList.remove('selected'));
      
      // Add 'selected' class to clicked row
      this.classList.add('selected');
    });
  });
}

document.addEventListener("DOMContentLoaded", () => {
  // Existing DOM Elements
  const clientsBtn = document.getElementById("clientsBtn")
  const clientsContent = document.getElementById("clientsContent")
  const functionsBtn = document.getElementById("functionsBtn")
  const functionsDropdown = document.getElementById("functionsDropdown")
  const settingsBtn = document.getElementById("settingsBtn")
  const logoutBtn = document.getElementById("logoutBtn")
  const logoutModal = document.getElementById("logoutModal")
  const cancelLogoutBtn = document.getElementById("cancelLogoutBtn")
  const confirmLogoutBtn = document.getElementById("confirmLogoutBtn")
  const searchInput = document.getElementById("searchInput")
  const dataTable = document.getElementById("dataTable")
  const closeModalBtns = document.querySelectorAll(".close-modal")
  const usersBtn = document.querySelector(".sidebar-item:not(.collapsible) span").parentElement
  const contentArea = document.querySelector(".content")
  const subItems = document.querySelectorAll(".sub-item")

  // Initialize row selection for the default table
  setupTableRowSelection("dataTable");

  // Toggle Clients dropdown with animation
  clientsBtn.addEventListener("click", () => {
    clientsContent.classList.toggle("active")
    const icon = clientsBtn.querySelector("i")

    // Rotate the chevron icon smoothly
    if (clientsContent.classList.contains("active")) {
      icon.style.transform = "rotate(180deg)"
      icon.style.transition = "transform 0.3s ease"
    } else {
      icon.style.transform = "rotate(0deg)"
      icon.style.transition = "transform 0.3s ease"
    }
  })

  // Toggle Functions dropdown with animation
  functionsBtn.addEventListener("click", (e) => {
    e.stopPropagation()
    functionsDropdown.classList.toggle("active")

    // Rotate the chevron icon smoothly
    const icon = functionsBtn.querySelector("i")
    if (functionsDropdown.classList.contains("active")) {
      icon.style.transform = "rotate(180deg)"
      icon.style.transition = "transform 0.3s ease"
    } else {
      icon.style.transform = "rotate(0deg)"
      icon.style.transition = "transform 0.3s ease"
    }
  })

  // Close Functions dropdown when clicking outside
  document.addEventListener("click", (e) => {
    if (!functionsBtn.contains(e.target) && !functionsDropdown.contains(e.target)) {
      functionsDropdown.classList.remove("active")
      const icon = functionsBtn.querySelector("i")
      icon.style.transform = "rotate(0deg)"
    }
  })

  // Handle Functions dropdown items
  const dropdownItems = functionsDropdown.querySelectorAll(".dropdown-item")
  dropdownItems.forEach((item) => {
    item.addEventListener("click", function () {
      alert(`Function selected: ${this.textContent}`)
      functionsDropdown.classList.remove("active")
      const icon = functionsBtn.querySelector("i")
      icon.style.transform = "rotate(0deg)"
    })
  })

  // Settings Button - Redirect to settings.html
  settingsBtn.addEventListener("click", async function() {
    try {
      const response = await fetch('/tern_app/SysDev-Ecom_Project/app/Views/utilities/settings.php');
      //console.log(await response.text());
      const tableRowsHTML = await response.text();

      if (response.ok) {

        contentArea.innerHTML = "";
        
        contentArea.innerHTML = tableRowsHTML;

        setupTableRowSelection("dataTable");
      } else {
        console.error("Failed to fetch settings:", settings.error || "Unknown error");
      }
    } catch (error) {
      console.error("Error fetching settings:", error);
    } 
  });

  // Logout Modal
  logoutBtn.addEventListener("click", () => {
    logoutModal.style.display = "flex"
  })

  cancelLogoutBtn.addEventListener("click", () => {
    logoutModal.style.display = "none"
  })

  confirmLogoutBtn.addEventListener("click", () => {
    // Send a request to your logout endpoint
    fetch('/tern_app/SysDev-Ecom_Project/logout', {
        method: 'POST',
        credentials: 'same-origin' // Important for session cookies
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
        }
    })
    .catch(error => console.error('Error:', error));
  });

  // Close modals with X button
  closeModalBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      const modal = this.closest(".modal")
      modal.style.display = "none"
    })
  })

  // Close modals when clicking outside
  window.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal")) {
      e.target.style.display = "none"
    }
  })

  // Search functionality
  searchInput.addEventListener("keyup", function () {
    const searchTerm = this.value.toLowerCase()
    const tableRows = dataTable.querySelectorAll("tbody tr")

    tableRows.forEach((row) => {
      let found = false
      const cells = row.querySelectorAll("td")

      cells.forEach((cell) => {
        const text = cell.textContent.toLowerCase()
        if (text.includes(searchTerm)) {
          found = true
        }
      })

      if (found) {
        row.style.display = ""
      } else {
        row.style.display = "none"
      }
    })
  })


  // Users button click handler - Show users table
  usersBtn.addEventListener("click", async function() {
    try {
      const response = await fetch('/tern_app/SysDev-Ecom_Project/app/Controllers/UserController.php');
      //console.log(await response.text());
      const tableRowsHTML = await response.text();

      if (response.ok) {

        contentArea.innerHTML = "";
        
        contentArea.innerHTML = tableRowsHTML;

        setupTableRowSelection("dataTable");
      } else {
        console.error("Failed to fetch users:", users.error || "Unknown error");
      }
    } catch (error) {
      console.error("Error fetching users:", error);
    }    
  });

  // Client sub-items click handler - Show client-specific tables
  subItems.forEach((item, index) => {
    item.addEventListener("click", function() {
      const clientName = this.textContent.trim();
      
      // Generate client-specific table HTML
      const clientTableHTML = `
        <div class="table-container">
          <h2>${clientName} Data</h2>
          <p>Showing data for ${clientName}</p>
          <table id="dataTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>${index}01</td>
                <td>Product A</td>
                <td>Electronics</td>
                <td>$${(Math.random() * 1000).toFixed(2)}</td>
                <td>${Math.floor(Math.random() * 100)}</td>
                <td>Active</td>
                <td>2023-${(index + 1).toString().padStart(2, '0')}-15</td>
                <td>
                  <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                  <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>${index}02</td>
                <td>Product B</td>
                <td>Furniture</td>
                <td>$${(Math.random() * 1000).toFixed(2)}</td>
                <td>${Math.floor(Math.random() * 100)}</td>
                <td>Active</td>
                <td>2023-${(index + 1).toString().padStart(2, '0')}-20</td>
                <td>
                  <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                  <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>${index}03</td>
                <td>Product C</td>
                <td>Clothing</td>
                <td>$${(Math.random() * 1000).toFixed(2)}</td>
                <td>${Math.floor(Math.random() * 100)}</td>
                <td>Inactive</td>
                <td>2023-${(index + 1).toString().padStart(2, '0')}-25</td>
                <td>
                  <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                  <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>${index}04</td>
                <td>Product D</td>
                <td>Food</td>
                <td>$${(Math.random() * 1000).toFixed(2)}</td>
                <td>${Math.floor(Math.random() * 100)}</td>
                <td>Active</td>
                <td>2023-${(index + 1).toString().padStart(2, '0')}-30</td>
                <td>
                  <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                  <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      `;
      
      // Update content area with client-specific table
      contentArea.innerHTML = clientTableHTML;
      
      // Initialize row selection for the new table
      setupTableRowSelection("dataTable");
      
      // Reattach search functionality to the new table
      const newDataTable = document.getElementById("dataTable");
      if (newDataTable && searchInput.value) {
        const searchTerm = searchInput.value.toLowerCase();
        const tableRows = newDataTable.querySelectorAll("tbody tr");
        
        tableRows.forEach((row) => {
          let found = false;
          const cells = row.querySelectorAll("td");
          
          cells.forEach((cell) => {
            const text = cell.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
              found = true;
            }
          });
          
          if (found) {
            row.style.display = "";
          } else {
            row.style.display = "none";
          }
        });
      }
    });
  });

  // Handle sidebar item clicks
  const sidebarItems = document.querySelectorAll(".sidebar-item:not(.collapsible), .sub-item")
  sidebarItems.forEach((item) => {
    item.addEventListener("click", function () {
      if (this.textContent.trim() !== "Settings" && this.textContent.trim() !== "Log Out") {
        // This is handled by specific event listeners above
      }
    })
  })
})


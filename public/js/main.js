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
  settingsBtn.addEventListener("click", () => {
    window.location.href = "/tern_app/SysDev-Ecom_Project/app/Views/utilities/settings.html"
  })

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
      const users = await response.json();

      if (response.ok) {
        let usersTableHTML = `
        <div class="table-container">
          <h2>Users Management</h2>
          <p>Showing all system users</p>
          <table id="dataTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
              </tr>
            </thead>
            <tbody>
        `;

        users.forEach(user => {
          usersTableHTML += `
            <tr>
              <td>${user.user_id}</td>
              <td>${user.user_name}</td>
              <td>${user.user_email}</td>
              <td>${user.password}</td>
              <td>
                <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
              </td>
            </tr>
          `;
        });

        usersTableHTML += `
            </tbody>
          </table>
        </div>
        `;

        contentArea.innerHTML = usersTableHTML;
        setupTableRowSelection("dataTable");
        
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
        } else {
          console.error("Failed to fetch users:", users.error || "Unknown error");
        }
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



 // UI switching
const exportBtn = document.getElementById('exportBtn');
const importBtn = document.getElementById('importBtn');
const exportSection = document.getElementById('exportSection');
const importSection = document.getElementById('importSection');

exportBtn.onclick = () => {
 exportSection.style.display = 'block';
 importSection.style.display = 'none';
 exportBtn.classList.add('active');
 importBtn.classList.remove('active');
};

importBtn.onclick = () => {
 exportSection.style.display = 'none';
 importSection.style.display = 'block';
 importBtn.classList.add('active');
 exportBtn.classList.remove('active');
};

// Export location handler
function triggerExportPath() {
 document.getElementById('exportPathInput').click();
}

function setExportLocation() {
 const input = document.getElementById('exportPathInput');
 if (input.files.length > 0) {
   // Show the folder name
   const path = input.files[0].webkitRelativePath;
   const folder = path.split('/')[0];
   document.getElementById('exportLocation').value = "C:/Users/Documents/" + folder;
 }
}

// Export
function exportTable() {
const client = document.getElementById('exportClient').value;
const location = document.getElementById('exportLocation').value;

if (!client || !location) {
alert("Please select a client and a location.");
return;
}

showModal("Export Successful", `Client ${client}'s data exported to:\n${location}`);

// Clear after success
document.getElementById('exportClient').value = '';
document.getElementById('exportLocation').value = '';
document.getElementById('exportPathInput').value = '';
}
function triggerImportFile() {
document.getElementById('importFileInput').click();
}

function handleImportFile() {
const fileInput = document.getElementById('importFileInput');
if (fileInput.files.length > 0) {
document.getElementById('importFileName').value = fileInput.files[0].name;
}
}


// Import
function importTable() {
const client = document.getElementById('importClient').value;
const fileName = document.getElementById('importFileName').value;

if (!client || !fileName) {
alert("Please select a client and a file to import.");
return;
}

showModal("Import Successful", `Imported "${fileName}" into ${client}`);

// Clear after success
document.getElementById('importClient').value = '';
document.getElementById('importFileName').value = '';
document.getElementById('importFileInput').value = '';
}

// Modal
function showModal(title, message) {
 document.getElementById('modalTitle').textContent = title;
 document.getElementById('modalMessage').textContent = message;
 document.getElementById('modal1').classList.add('show');
 document.getElementById('overlay').classList.add('show');
}

function closeModal() {
 document.getElementById('modal1').classList.remove('show');
 document.getElementById('overlay').classList.remove('show');
}

document.getElementById('exportBtn').addEventListener('click', function () {
  showSection('export');
});

document.getElementById('importBtn').addEventListener('click', function () {
  showSection('import');
});

function showSection(section) {
  // Hide all sections
  document.getElementById('tableContent').style.display = 'none';
  document.getElementById('importSection').style.display = 'none';
  document.getElementById('exportSection').style.display = 'none';

  // Reset active state for buttons
  document.getElementById('exportBtn').classList.remove('active');
  document.getElementById('importBtn').classList.remove('active');

  // Show selected section
  if (section === 'import') {
    document.getElementById('importSection').style.display = 'block';
    document.getElementById('importBtn').classList.add('active');
  } else if (section === 'export') {
    document.getElementById('exportSection').style.display = 'block';
    document.getElementById('exportBtn').classList.add('active');
  }
}

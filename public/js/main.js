// Add this function to handle table row selection
function setupTableRowSelection(tableId) {
  const table = document.getElementById(tableId)
  if (!table) return

  const rows = table.querySelectorAll("tbody tr")

  rows.forEach((row) => {
    // Add click event listener to each row
    row.addEventListener("click", function (e) {
      // Skip if clicking on action buttons or checkboxes
      if (e.target.closest(".action-btn") || e.target.type === "checkbox") {
        return
      }

      // Remove 'selected' class from all rows
      rows.forEach((r) => r.classList.remove("selected"))

      // Add 'selected' class to clicked row
      this.classList.add("selected")
    })
  })
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
  const searchResults = document.getElementById("searchResults")

  // Initialize row selection for the default table
  setupTableRowSelection("dataTable")

  // Load MK clients by default
  loadMkClients()

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
    if (item.classList.contains("create-client-btn")) {
      item.addEventListener("click", function () {
        const clientType = this.getAttribute("data-client-type")
        loadCreateClientForm(clientType)
        functionsDropdown.classList.remove("active")
        const icon = functionsBtn.querySelector("i")
        icon.style.transform = "rotate(0deg)"
      })
    } else {
      item.addEventListener("click", function () {
        alert(`Function selected: ${this.textContent}`)
        functionsDropdown.classList.remove("active")
        const icon = functionsBtn.querySelector("i")
        icon.style.transform = "rotate(0deg)"
      })
    }
  })

  // Settings Button - Redirect to settings.html
  settingsBtn.addEventListener("click", async () => {
    try {
      const response = await fetch("/tern_app/SysDev-Ecom_Project/app/Views/utilities/settings.php")
      //console.log(await response.text());
      const tableRowsHTML = await response.text()

      if (response.ok) {
        contentArea.innerHTML = ""
        contentArea.innerHTML = tableRowsHTML
        setupTableRowSelection("dataTable")

        insertAndRunScripts(contentArea);
      } else {
        const settings = await response.json()
        console.error("Failed to fetch settings:", settings.error || "Unknown error")
      }
    } catch (error) {
      console.error("Error fetching settings:", error)
    }
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
    fetch("/tern_app/SysDev-Ecom_Project/logout", {
      method: "POST",
      credentials: "same-origin", // Important for session cookies
    })
      .then((response) => {
        if (response.redirected) {
          window.location.href = response.url
        }
      })
      .catch((error) => console.error("Error:", error))
  })

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

  // Enhanced Search functionality with autocomplete
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      const searchTerm = this.value.trim()

      if (searchTerm.length > 2) {
        fetchSearchResults(searchTerm)
      } else {
        if (searchResults) {
          searchResults.style.display = "none"
        }

        // Fall back to basic filtering for short search terms
        const tableRows = dataTable ? dataTable.querySelectorAll("tbody tr") : []
        tableRows.forEach((row) => {
          let found = false
          const cells = row.querySelectorAll("td")

          cells.forEach((cell) => {
            const text = cell.textContent.toLowerCase()
            if (text.includes(searchTerm.toLowerCase())) {
              found = true
            }
          })

          if (found || searchTerm === "") {
            row.style.display = ""
          } else {
            row.style.display = "none"
          }
        })
      }
    })
  }

  // Close search results when clicking outside
  document.addEventListener("click", (event) => {
    if (searchResults && !event.target.closest(".search-container")) {
      searchResults.style.display = "none"
    }
  })

  // Users button click handler - Show users table
  usersBtn.addEventListener("click", async () => {
    try {
      const response = await fetch("/tern_app/SysDev-Ecom_Project/app/Controllers/UserController.php")
      //console.log(await response.text());
      const tableRowsHTML = await response.text()

      if (response.ok) {
        contentArea.innerHTML = ""
        contentArea.innerHTML = tableRowsHTML
        setupTableRowSelection("dataTable")
      } else {
        const users = await response.json()
        console.error("Failed to fetch users:", users.error || "Unknown error")
      }
    } catch (error) {
      console.error("Error fetching users:", error)
    }
  })

  // Client sub-items click handler - Show client-specific tables
  subItems.forEach((item) => {
    item.addEventListener("click", function () {
      const clientType = this.getAttribute("data-client-type")

      if (clientType && !this.classList.contains("create-client-btn")) {
        loadClientsByType(clientType)
      } else if (this.classList.contains("create-client-btn")) {
        loadCreateClientForm(clientType)
      }
    })
  })

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

// Update the loadMkClients function to use the correct route
function loadMkClients() {
  const contentArea = document.querySelector(".content")
  if (!contentArea) return

  fetch("/tern_app/SysDev-Ecom_Project/mk-clients")
    .then((response) => response.text())
    .then((data) => {
      contentArea.innerHTML = `
        <div class="table-container">
          <div class="table-header">
            <h2>MK Clients</h2>
            <button id="createMkClientBtn" class="btn btn-primary">
              <i class="fa-solid fa-plus"></i> Create MK Client
            </button>
          </div>
          <table id="dataTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Location ID</th>
                <th>Address</th>
                <th>Location</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Premium</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              ${data}
            </tbody>
          </table>
        </div>
      `

      // Add event listener to the create button
      const createBtn = document.getElementById("createMkClientBtn")
      if (createBtn) {
        createBtn.addEventListener("click", () => {
          loadCreateClientForm("mk")
        })
      }

      setupTableRowSelection("dataTable")
    })
    .catch((error) => {
      console.error("Error loading clients:", error)
      contentArea.innerHTML = '<div class="error-message">Error loading clients. Please try again.</div>'
    })
}

// Function to load clients by type
function loadClientsByType(clientType) {
  // Currently only MK is implemented
  if (clientType === "mk") {
    loadMkClients()
  } else {
    const contentArea = document.querySelector(".content")
    if (contentArea) {
      contentArea.innerHTML = `
        <div class="table-container">
          <h2>${clientType.toUpperCase()} Data</h2>
          <p>Showing data for ${clientType.toUpperCase()}</p>
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
                <td>001</td>
                <td>Product A</td>
                <td>Electronics</td>
                <td>$${(Math.random() * 1000).toFixed(2)}</td>
                <td>${Math.floor(Math.random() * 100)}</td>
                <td>Active</td>
                <td>2023-01-15</td>
                <td>
                  <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                  <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>002</td>
                <td>Product B</td>
                <td>Furniture</td>
                <td>$${(Math.random() * 1000).toFixed(2)}</td>
                <td>${Math.floor(Math.random() * 100)}</td>
                <td>Active</td>
                <td>2023-02-20</td>
                <td>
                  <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                  <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      `
      setupTableRowSelection("dataTable")
    }
  }
}

// Update the loadCreateClientForm function to use the correct route
function loadCreateClientForm(clientType) {
  const contentArea = document.querySelector(".content")
  if (!contentArea) return

  // Currently only MK is implemented
  if (clientType === "mk") {
    fetch("/tern_app/SysDev-Ecom_Project/create-client")
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`)
        }
        return response.text()
      })
      .then((data) => {
        contentArea.innerHTML = data

        // Set up form submission handler
        const createClientForm = document.getElementById("createClientForm")
        if (createClientForm) {
          createClientForm.addEventListener("submit", (e) => {
            e.preventDefault()
            submitCreateClientForm()
          })
        }

        // Set up cancel button
        const cancelBtn = document.getElementById("cancelBtn")
        if (cancelBtn) {
          cancelBtn.addEventListener("click", () => {
            loadMkClients() // Go back to clients list
          })
        }
      })
      .catch((error) => {
        console.error("Error loading create client form:", error)
        contentArea.innerHTML = `
          <div class="error-message">
            Error loading form. Please try again. Details: ${error.message}
          </div>
        `
      })
  } else {
    contentArea.innerHTML = `<div class="error-message">Create client form for ${clientType} not implemented yet.</div>`
  }
}

// Update the submitCreateClientForm function to use the correct route
function submitCreateClientForm() {
  const form = document.getElementById("createClientForm")
  if (!form) {
    console.error("Form not found")
    return
  }

  const formData = new FormData(form)

  // Log the form data for debugging
  console.log("Submitting form data:")
  for (const [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`)
  }

  fetch("/tern_app/SysDev-Ecom_Project/mk-clients", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`)
      }
      return response.json()
    })
    .then((data) => {
      if (data.success) {
        alert("Client created successfully!")
        loadMkClients() // Go back to clients list
      } else {
        alert("Error: " + (data.message || "Unknown error occurred"))
      }
    })
    .catch((error) => {
      console.error("Error creating client:", error)
      alert("An error occurred while creating the client. Please check the console for details.")
    })
}

// Function to fetch search results
function fetchSearchResults(searchTerm) {
  const searchResults = document.getElementById("searchResults");
  if (!searchResults) return;

  fetch(`/tern_app/SysDev-Ecom_Project/mkclient/search?search=${encodeURIComponent(searchTerm)}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.length > 0) {
        let resultsHtml = "";
        data.forEach((client) => {
          resultsHtml += `
            <div class="search-result-item" data-id="${client.id}">
              ${client.location_id} - ${client.location_address}, ${client.location_city}
            </div>
          `;
        });

        searchResults.innerHTML = resultsHtml;
        searchResults.style.display = "block";

        // Add click event to each item
        const resultItems = document.querySelectorAll(".search-result-item");
        resultItems.forEach((item) => {
          item.addEventListener("click", function () {
            const clientId = this.getAttribute("data-id");
            highlightClient(clientId);
            searchResults.style.display = "none";
            document.getElementById("searchInput").value = this.textContent.trim();
          });
        });
      } else {
        searchResults.innerHTML = '<div class="search-result-item">No results found</div>';
        searchResults.style.display = "block";
      }
    })
    .catch((error) => {
      console.error("Error fetching search results:", error);
      searchResults.innerHTML = '<div class="search-result-item">Error fetching results</div>';
      searchResults.style.display = "block";
    });
}

// Also update the highlightClient function to use the correct ID field

function highlightClient(clientId) {
  // First, load MK clients if not already loaded
  loadMkClients()

  // Wait a bit for the table to load, then highlight the row
  setTimeout(() => {
    const rows = document.querySelectorAll("#tableBody tr")
    rows.forEach((row) => {
      row.classList.remove("highlighted")

      const idCell = row.querySelector("td:first-child")
      if (idCell && idCell.textContent === clientId) {
        row.classList.add("highlighted")
        row.scrollIntoView({ behavior: "smooth", block: "center" })
      }
    })
  }, 500)
}

function getTheme(theme) {

  theme =  localStorage.getItem('preferredTheme');

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
    document.documentElement.style.setProperty('--sidebar-bg', '#2c3e50');
    document.documentElement.style.setProperty('--button-bg', '#3498db');
    document.documentElement.style.setProperty('--button-hover', '#2980b9');
    document.documentElement.style.setProperty('--exit-bg', 'black');
    document.documentElement.style.setProperty('--exit-hover', '#333');
  }
  
  // Save theme preference to localStorage
  localStorage.setItem('preferredTheme', theme);
}

function insertAndRunScripts(container) {

  // Find all script tags
  const scripts = container.querySelectorAll('script');
  scripts.forEach(oldScript => {
      const newScript = document.createElement('script');

      // Copy attributes like src and type
      Array.from(oldScript.attributes).forEach(attr => {
          newScript.setAttribute(attr.name, attr.value);
      });

      // If it's inline script, copy the content
      newScript.textContent = oldScript.textContent;

      // Replace old with new to force execution
      oldScript.parentNode.replaceChild(newScript, oldScript);
  });
}

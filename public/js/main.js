document.addEventListener("DOMContentLoaded", () => {
  // DOM Elements
  const clientsBtn = document.getElementById("clientsBtn")
  const clientsContent = document.getElementById("clientsContent")
  const functionsBtn = document.getElementById("functionsBtn")
  const functionsDropdown = document.getElementById("functionsDropdown")
  const settingsBtn = document.getElementById("settingsBtn")
  const settingsModal = document.getElementById("settingsModal")
  const closeSettingsBtn = document.getElementById("closeSettingsBtn")
  const logoutBtn = document.getElementById("logoutBtn")
  const logoutModal = document.getElementById("logoutModal")
  const cancelLogoutBtn = document.getElementById("cancelLogoutBtn")
  const confirmLogoutBtn = document.getElementById("confirmLogoutBtn")
  const searchInput = document.getElementById("searchInput")
  const dataTable = document.getElementById("dataTable")
  const closeModalBtns = document.querySelectorAll(".close-modal")

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

  // Settings Modal
  settingsBtn.addEventListener("click", () => {
    settingsModal.style.display = "flex"
  })

  closeSettingsBtn.addEventListener("click", () => {
    settingsModal.style.display = "none"
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

  // Handle sidebar item clicks
  const sidebarItems = document.querySelectorAll(".sidebar-item:not(.collapsible), .sub-item")
  sidebarItems.forEach((item) => {
    item.addEventListener("click", function () {
      if (this.textContent.trim() !== "Settings" && this.textContent.trim() !== "Log Out") {
        alert(`Navigating to: ${this.textContent.trim()}`)
      }
    })
  })
})

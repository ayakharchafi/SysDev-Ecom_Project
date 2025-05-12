const cfunctionsBtn = document.getElementById("cfunctionsBtn")
const cfunctionsDropdown = document.getElementById("cfunctionsDropdown")
const CreateModal = document.getElementById("CreateModal")
const createUserBtn = document.getElementById("createUserBtn")
const deleteUserBtn = document.getElementById("deleteUserBtn")
const roleBox = document.getElementById("roleBox")
const externalInput = document.getElementById("externalInput")
const CreateBtn = document.getElementById("CreateBtn")
const closeModalBtns = document.querySelectorAll(".close-modal")

  // Toggle Functions dropdown with animation
  cfunctionsBtn.addEventListener("click", (e) => {
    e.stopPropagation()
    cfunctionsDropdown.classList.toggle("active")

    // Rotate the chevron icon smoothly
    const icon = cfunctionsBtn.querySelector("i")
    if (cfunctionsDropdown.classList.contains("active")) {
      icon.style.transform = "rotate(180deg)"
      icon.style.transition = "transform 0.3s ease"
    } else {
      icon.style.transform = "rotate(0deg)"
      icon.style.transition = "transform 0.3s ease"
    }
  })

  // Close Functions dropdown when clicking outside
  document.addEventListener("click", (e) => {
    if (!cfunctionsBtn.contains(e.target) && !cfunctionsDropdown.contains(e.target)) {
        cfunctionsDropdown.classList.remove("active")
      const icon = cfunctionsBtn.querySelector("i")
      icon.style.transform = "rotate(0deg)"
    }
  })

  // Handle Functions dropdown items
  const cdropdownItems = cfunctionsDropdown.querySelectorAll(".dropdown-item")
  cdropdownItems.forEach((item) => {
    if (item.classList.contains("create-client-btn")) {
      item.addEventListener("click", function () {
        const clientType = this.getAttribute("data-client-type")
        loadCreateClientForm(clientType)
        cfunctionsDropdown.classList.remove("active")
        const icon = cfunctionsBtn.querySelector("i")
        icon.style.transform = "rotate(0deg)"
      })
    } else {
      item.addEventListener("click", function () {
        alert(`Function selected: ${this.textContent}`)
        cfunctionsDropdown.classList.remove("active")
        const icon = cfunctionsBtn.querySelector("i")
        icon.style.transform = "rotate(0deg)"
      })
    }
  })

  createUserBtn.addEventListener("click", async () => {
    try {
      const response = await fetch("/tern_app/SysDev-Ecom_Project/app/Views/utilities/create_user.php")
      //console.log(await response.text());
      const tableRowsHTML = await response.text()

      if (response.ok) {
        contentArea.innerHTML = ""
        contentArea.innerHTML = tableRowsHTML
        setupTableRowSelection("dataTable")

        insertAndRunScripts(contentArea);
      } else {
        const settings = await response.json()
        console.error("Failed to fetch create_user:", settings.error || "Unknown error")
      }
    } catch (error) {
      console.error("Error fetching create_user:", error)
    }
  })

  CreateBtn.addEventListener("click", () => {
    CreateModal.style.display = "flex"
  })

  closeModalBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      const modal = this.closest(".modal")
      modal.style.display = "none"
    })
  })

  function showExternalInput(){
    if(roleBox.options[roleBox.selectedIndex].text == "External"){
      externalInput.style.display = "flex"
    }else{
           externalInput.style.display = "none"
    }
  }

  createUserBtn.addEventListener("click", async () => {
    try {
      const response = await fetch("/tern_app/SysDev-Ecom_Project/app/Views/utilities/create_user.php")
      //console.log(await response.text());
      const tableRowsHTML = await response.text()

      if (response.ok) {
        contentArea.innerHTML = ""
        contentArea.innerHTML = tableRowsHTML
        setupTableRowSelection("dataTable")

        insertAndRunScripts(contentArea);
      } else {
        const settings = await response.json()
        console.error("Failed to fetch create_user:", settings.error || "Unknown error")
      }
    } catch (error) {
      console.error("Error fetching create_user:", error)
    }
  })

  deleteUserBtn.addEventListener("click", async () => {
    try {
      const response = await fetch("/tern_app/SysDev-Ecom_Project/app/Views/utilities/delete_user.php")
      //console.log(await response.text());
      const tableRowsHTML = await response.text()

      if (response.ok) {
        contentArea.innerHTML = ""
        contentArea.innerHTML = tableRowsHTML
        setupTableRowSelection("dataTable")

        insertAndRunScripts(contentArea);
      } else {
        const settings = await response.json()
        console.error("Failed to fetch create_user:", settings.error || "Unknown error")
      }
    } catch (error) {
      console.error("Error fetching create_user:", error)
    }
  })

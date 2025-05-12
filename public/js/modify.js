const mfunctionsBtn = document.getElementById("mfunctionsBtn")
const mfunctionsDropdown = document.getElementById("mfunctionsDropdown")
const createUserBtn = document.getElementById("createUserBtn")
const deleteUserBtn = document.getElementById("deleteUserBtn")
const contentArea = document.querySelector(".content")
//const CreateBtn = document.getElementById("logoutBtn")
//const CreateModal = document.getElementById("logoutModal")

  // Toggle Functions dropdown with animation
  mfunctionsBtn.addEventListener("click", (e) => {
    e.stopPropagation()
    mfunctionsDropdown.classList.toggle("active")

    // Rotate the chevron icon smoothly
    const icon = mfunctionsBtn.querySelector("i")
    if (mfunctionsDropdown.classList.contains("active")) {
      icon.style.transform = "rotate(180deg)"
      icon.style.transition = "transform 0.3s ease"
    } else {
      icon.style.transform = "rotate(0deg)"
      icon.style.transition = "transform 0.3s ease"
    }
  })

  // Close Functions dropdown when clicking outside
  document.addEventListener("click", (e) => {
    if (!mfunctionsBtn.contains(e.target) && !mfunctionsDropdown.contains(e.target)) {
      mfunctionsDropdown.classList.remove("active")
      const icon = mfunctionsBtn.querySelector("i")
      icon.style.transform = "rotate(0deg)"
    }
  })

  // Handle Functions dropdown items
  const mdropdownItems = mfunctionsDropdown.querySelectorAll(".dropdown-item")
  mdropdownItems.forEach((item) => {
    if (item.classList.contains("create-client-btn")) {
      item.addEventListener("click", function () {
        const clientType = this.getAttribute("data-client-type")
        loadCreateClientForm(clientType)
        mfunctionsDropdown.classList.remove("active")
        const icon = mfunctionsBtn.querySelector("i")
        icon.style.transform = "rotate(0deg)"
      })
    } else {
      item.addEventListener("click", function () {
        alert(`Function selected: ${this.textContent}`)
        mfunctionsDropdown.classList.remove("active")
        const icon = mfunctionsBtn.querySelector("i")
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

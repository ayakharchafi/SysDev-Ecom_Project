function changeLanguage(lang) {
  const t = translations[lang];
  for (const key in t) {
    const el = document.getElementById(key);
    if (el) el.textContent = t[key];
  }

  localStorage.setItem("preferredLanguage", lang);
}

function changeTheme(theme) {
  if (theme === "dark") {
    document.documentElement.style.setProperty("--bg", "#1e1e1e");
    document.documentElement.style.setProperty("--text", "#f0f0f0");
    document.documentElement.style.setProperty("--sidebar-bg", "#121212");
    document.documentElement.style.setProperty("--button-bg", "#444");
    document.documentElement.style.setProperty("--button-hover", "#666");
    document.documentElement.style.setProperty("--exit-bg", "#222");
    document.documentElement.style.setProperty("--exit-hover", "#444");
    document.documentElement.style.setProperty("--bg2", "#2c2b2b");
  } else {
    document.documentElement.style.setProperty("--bg", "#ffffff");
    document.documentElement.style.setProperty("--text", "#333");
    document.documentElement.style.setProperty("--sidebar-bg", " #2c3e50");
    document.documentElement.style.setProperty("--button-bg", "#3498db");
    document.documentElement.style.setProperty("--button-hover", "#2980b9");
    document.documentElement.style.setProperty("--exit-bg", "black");
    document.documentElement.style.setProperty("--exit-hover", "#333");
    document.documentElement.style.setProperty("--bg2", "#2c2b2b");
  }

  // Save theme preference to localStorage
  localStorage.setItem("preferredTheme", theme);
}

document.querySelectorAll("#languageForm button").forEach((button) => {
  button.addEventListener("click", function () {
    let language = this.getAttribute("value");

    fetch(
      "/tern_app/SysDev-Ecom_Project/app/Controllers/LanguageController.php",
      {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `lang=${language}`,
      }
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Language changed successfully!");
          location.reload();
        }
      })
      .catch((error) => console.error("Error:", error));
  });
});

// Apply saved preferences on page load
document.addEventListener("DOMContentLoaded", function () {
  // Apply saved language if available
  const savedLanguage = localStorage.getItem("preferredLanguage");
  if (savedLanguage) {
    changeLanguage(savedLanguage);
  }

  // Apply saved theme if available
  const savedTheme = localStorage.getItem("preferredTheme");
  if (savedTheme) {
    changeTheme(savedTheme);
  }

  // Get the exit button
  const exitBtn = document.getElementById("exitBtn");

  // Add click event listener to exit button
  exitBtn.addEventListener("click", function () {
    // Redirect back to main.php
    window.location.href =
      "http://localhost/tern_app/SysDev-Ecom_Project/dashboard";
  });

  // Also handle the sidebar buttons to navigate back
  const btnClients = document.getElementById("btnClients");
  const btnUsers = document.getElementById("btnUsers");
  const btnExport = document.getElementById("btnExport");
  const btnImport = document.getElementById("btnImport");

  // Add click event listeners to sidebar buttons
  [btnClients, btnUsers, btnExport, btnImport].forEach((btn) => {
    btn.addEventListener("click", function () {
      window.location.href = "/tern_app/SysDev-Ecom_Project/main.php";
    });
  });

  const archivedClientsLink = document.getElementById("archivedClients");
  if (archivedClientsLink) {
    archivedClientsLink.addEventListener("click", (e) => {
      e.preventDefault();
      loadArchivedClients();
    });
  }
  const deactivatedUsersBtn = document.getElementById("deactivatedUsers");
  if (deactivatedUsersBtn) {
    deactivatedUsersBtn.addEventListener("click", (e) => {
      e.preventDefault();
      loadDeactivatedUsers(); // this now fetches via /deactivated-users
    });
  }
});

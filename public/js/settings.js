const translations = {
    english: {
      sidebarUsername: "Username",
      sidebarTables: "Tables",
      btnClients: "Clients",
      btnUsers: "Users",
      fileManager: "File Manager",
      btnExport: "Export",
      btnImport: "Import",
      settingsHeader: "⚙ Settings",
      logout: "⎋ Log out",
      settingsTitle: "Settings",
      themeTitle: "🎨 Theme",
      themeDescription: "Select your display preferences",
      languageTitle: "🗣 Language",
      languageDescription: "Select your preferred language",
      archivedClients: "🗃 Archived Clients",
      deactivatedUsers: "⏸ Deactivated Users",
      exitBtn: "Exit"
    },
    french: {
      sidebarUsername: "Nom d'utilisateur",
      sidebarTables: "Tables",
      btnClients: "Clients",
      btnUsers: "Utilisateurs",
      fileManager: "Gestionnaire de fichiers",
      btnExport: "Exporter",
      btnImport: "Importer",
      settingsHeader: "⚙ Paramètres",
      logout: "⎋ Se déconnecter",
      settingsTitle: "Paramètres",
      themeTitle: "🎨 Thème",
      themeDescription: "Sélectionnez vos préférences d'affichage",
      languageTitle: "🗣 Langue",
      languageDescription: "Sélectionnez votre langue préférée",
      archivedClients: "🗃 Clients archivés",
      deactivatedUsers: "⏸ Utilisateurs désactivés",
      exitBtn: "Quitter"
    }
  };
  
  function changeLanguage(lang) {
    const t = translations[lang];
    for (const key in t) {
      const el = document.getElementById(key);
      if (el) el.textContent = t[key];
    }
    
    // Save language preference to localStorage
    localStorage.setItem('preferredLanguage', lang);
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
      document.documentElement.style.setProperty('--sidebar-bg', '#2c3e50');
      document.documentElement.style.setProperty('--button-bg', '#3498db');
      document.documentElement.style.setProperty('--button-hover', '#2980b9');
      document.documentElement.style.setProperty('--exit-bg', 'black');
      document.documentElement.style.setProperty('--exit-hover', '#333');
    }
    
    // Save theme preference to localStorage
    localStorage.setItem('preferredTheme', theme);
  }
  
  // Apply saved preferences on page load
  document.addEventListener("DOMContentLoaded", function() {
    // Apply saved language if available
    const savedLanguage = localStorage.getItem('preferredLanguage');
    if (savedLanguage) {
      changeLanguage(savedLanguage);
    }
    
    // Apply saved theme if available
    const savedTheme = localStorage.getItem('preferredTheme');
    if (savedTheme) {
      changeTheme(savedTheme);
    }
    
    // Get the exit button
    const exitBtn = document.getElementById("exitBtn");
    
    // Add click event listener to exit button
    exitBtn.addEventListener("click", function() {
      // Redirect back to main.php
      window.location.href = "http://localhost/tern_app/SysDev-Ecom_Project/dashboard";
    });
    
    // Also handle the sidebar buttons to navigate back
    const btnClients = document.getElementById("btnClients");
    const btnUsers = document.getElementById("btnUsers");
    const btnExport = document.getElementById("btnExport");
    const btnImport = document.getElementById("btnImport");
    
    // Add click event listeners to sidebar buttons
    [btnClients, btnUsers, btnExport, btnImport].forEach(btn => {
      btn.addEventListener("click", function() {
        window.location.href = "/tern_app/SysDev-Ecom_Project/main.php";
      });
    });
    
    // Get the Archived Clients button
    const archivedClientsBtn = document.getElementById("archivedClients");
    
    // Add click event listener to redirect to archived_clients.html
    archivedClientsBtn.addEventListener("click", function() {
      window.location.href = "/tern_app/SysDev-Ecom_Project/app/Views/utilities/archived_clients.html";
    });
    
    // Get the Deactivated Users button (for future implementation)
    const deactivatedUsersBtn = document.getElementById("deactivatedUsers");
    
    // Add click event listener for future implementation
    deactivatedUsersBtn.addEventListener("click", function() {
      window.location.href = "/tern_app/SysDev-Ecom_Project/app/Views/utilities/desactivate_users.html";
    });
  });
<?php
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: /tern_app/SysDev-Ecom_Project/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/tern_app/SysDev-Ecom_Project/public/css/style_main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Left Sidebar -->
        <div class="sidebar">
            <div class="user-profile">
                <div class="avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span class="username"><?php 
                    echo htmlspecialchars($_SESSION['user']) ?>
                </span>
            </div>

            <div class="sidebar-section">
                <h3>Tables</h3>
                <div class="sidebar-item collapsible" id="clientsBtn">
                    <span>Clients</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="collapsible-content" id="clientsContent">
                    <div class="sub-item">Client 1</div>
                    <div class="sub-item">Client 2</div>
                    <div class="sub-item">Client 3</div>
                    <div class="sub-item">Client 4</div>
                    <div class="sub-item">Client 5</div>
                </div>
                <div class="sidebar-item">
                    <span>Users</span>
                </div>
            </div>

            <div class="sidebar-section">
                <h3>File Manager</h3>
                <div class="sidebar-item">
                    <span>Export</span>
                </div>
                <div class="sidebar-item">
                    <span>Import</span>
                </div>
            </div>

            <div class="sidebar-footer">
                <div class="sidebar-item" id="settingsBtn">
                    <i class="fa-solid fa-gear"></i>
                    <span>Settings</span>
                </div>
                <div class="sidebar-item" id="logoutBtn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Log Out</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="top-bar">
                <div class="search-container">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search">
                </div>
                <div class="action-buttons">
                    <button class="btn btn-primary">
                        <span>Back-Up</span>
                        <i class="fa-solid fa-download"></i>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" id="functionsBtn">
                            <span>Functions</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-content" id="functionsDropdown">
                            <div class="dropdown-item">Data Tracking</div>
                            <div class="dropdown-item">Modify User</div>
                            <div class="dropdown-item">Create Report</div>
                            <div class="dropdown-item">Batch Update</div>
                            <div class="dropdown-item">Create Client</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="table-container">
                    <table id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>(555) 123-4567</td>
                                <td>Active</td>
                                <td>2023-01-15</td>
                                <td>2023-04-20</td>
                                <td>
                                    <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td>(555) 987-6543</td>
                                <td>Inactive</td>
                                <td>2023-02-10</td>
                                <td>2023-03-15</td>
                                <td>
                                    <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Robert Johnson</td>
                                <td>robert@example.com</td>
                                <td>(555) 456-7890</td>
                                <td>Active</td>
                                <td>2023-03-05</td>
                                <td>2023-05-12</td>
                                <td>
                                    <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Emily Davis</td>
                                <td>emily@example.com</td>
                                <td>(555) 234-5678</td>
                                <td>Active</td>
                                <td>2023-04-20</td>
                                <td>2023-05-01</td>
                                <td>
                                    <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Michael Wilson</td>
                                <td>michael@example.com</td>
                                <td>(555) 876-5432</td>
                                <td>Inactive</td>
                                <td>2023-05-15</td>
                                <td>2023-06-10</td>
                                <td>
                                    <button class="action-btn"><i class="fa-solid fa-edit"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="settingsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Settings</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <p>This is a placeholder for the settings page. The actual settings functionality will be implemented in the future.</p>
                <div class="settings-section">
                    <h3>General Settings</h3>
                    <div class="form-group">
                        <label>Theme</label>
                        <select>
                            <option>Light</option>
                            <option>Dark</option>
                            <option>System Default</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Language</label>
                        <select>
                            <option>English</option>
                            <option>Spanish</option>
                            <option>French</option>
                        </select>
                    </div>
                </div>
                <div class="settings-section">
                    <h3>Notification Settings</h3>
                    <div class="form-group">
                        <label>Email Notifications</label>
                        <input type="checkbox" checked>
                    </div>
                    <div class="form-group">
                        <label>Push Notifications</label>
                        <input type="checkbox">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="closeSettingsBtn">Cancel</button>
                <button class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Logout</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to log out?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelLogoutBtn">Cancel</button>
                <button class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
            </div>
        </div>
    </div>

    <script src="/tern_app/SysDev-Ecom_Project/public/js/main.js"></script>
</body>
</html>
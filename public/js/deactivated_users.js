// public/js/deactivated_users.js

// 1) Pull in the fragment & append your “Activate” button wiring
function loadDeactivatedUsers() {
  const contentArea = document.querySelector('.content');
 fetch('/tern_app/SysDev-Ecom_Project/deactivated-users')
  .then(r => r.text())
  .then(html => {
    contentArea.innerHTML = html;
    setupTableRowSelection('dataTable');

      // bind “select all” toggle
      document.getElementById('selectAllDeact')
        .addEventListener('change', e => {
          document
            .querySelectorAll('#dataTable tbody input[type=checkbox]')
            .forEach(cb => cb.checked = e.target.checked);
        });

      // bind activation action
      document.getElementById('activateUsersBtn')
        .addEventListener('click', activateSelectedUsers);
    })
    .catch(console.error);
}

// 2) Handle “Activate Users Selected”
function activateSelectedUsers() {
  const checks = document.querySelectorAll(
    '#dataTable tbody input[type="checkbox"]:checked'
  );
  if (!checks.length) {
    return alert('Please select at least one user to activate.');
  }
  if (!confirm(`Activate ${checks.length} user(s)?`)) return;

  const ids = Array.from(checks).map(cb => cb.value);

  fetch('/tern_app/SysDev-Ecom_Project/restore-users', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ ids })
  })
  .then(r => r.json())
  .then(({ success, message }) => {
    alert(message);
    if (success) loadDeactivatedUsers();
  })
  .catch(err => {
    console.error(err);
    alert('Unexpected error activating users.');
  });
}

// expose for dynamic injection
window.loadDeactivatedUsers    = loadDeactivatedUsers;
window.activateSelectedUsers   = activateSelectedUsers;

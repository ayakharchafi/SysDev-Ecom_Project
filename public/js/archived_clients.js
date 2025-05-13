// 1) Load archived clients and inject a Restore button
function loadArchivedClients() {
  const contentArea = document.querySelector('.content');
  fetch('/tern_app/SysDev-Ecom_Project/mk-clients?archived=1')
    .then(res => res.text())
    .then(html => {
      contentArea.innerHTML = html;
      setupTableRowSelection('dataTable');

      // Append Restore button
      const btn = document.createElement('button');
      btn.id = 'restoreClientsBtn';
      btn.className = 'btn btn-primary';
      btn.innerHTML = '<i class="fa-solid fa-undo"></i> Restore Clients Selected';
      contentArea.querySelector('.table-container').insertAdjacentElement('beforeend', btn);

      btn.addEventListener('click', restoreSelectedClients);
    })
    .catch(err => console.error('Error loading archived clients:', err));
}

// 2) Restore selected archived clients
function restoreSelectedClients() {
  const checks = document.querySelectorAll(
    '#dataTable tbody input[type="checkbox"]:checked'
  );
  if (!checks.length) return alert('Please select at least one client to restore.');
  if (!confirm(`Restore ${checks.length} client(s)?`)) return;

  const ids = Array.from(checks).map(cb => cb.value);

  fetch('/tern_app/SysDev-Ecom_Project/restore-clients', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ ids })
  })
  .then(res => res.json())
  .then(({ success, message }) => {
    alert(message);
    if (success) loadArchivedClients();
  })
  .catch(err => {
    console.error('Restore error:', err);
    alert('Unexpected error restoring clients.');
  });
}

// Expose for settings loader
window.loadArchivedClients = loadArchivedClients;
window.restoreSelectedClients = restoreSelectedClients;
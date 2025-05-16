
function loadArchivedClients() {
  const contentArea = document.querySelector('.content');
  fetch('/tern_app/SysDev-Ecom_Project/app/Views/utilities/archived_clients.php ')
    .then(res => res.text())
    .then(html => {
      // it puts the html content in the page
      contentArea.innerHTML = html;
      setupTableRowSelection('dataTable');
      // restore btn
      contentArea.querySelector('.table-container').insertAdjacentElement('beforeend', btn);

    })
    .catch(err => console.error('Error loading archived clients:', err));
}
  
      var btn = document.getElementById('restoreBtn')
      btn.addEventListener('click', restoreSelectedClients);


function restoreSelectedClients() {
// for all the rows that are checked/selected
  const checks = document.querySelectorAll(
    '#dataTable tbody .selected #idBox'
  );

  if (!checks.length) return alert('Please select at least one client to archive.');
  // confirmation message
  if (!confirm(`Archive ${checks.length} client(s)?`)) return;
// takes all the ids of the checked clients in an array
  const ids = Array.from(checks).map(cb => cb.innerHTML);
  fetch(`/tern_app/SysDev-Ecom_Project/app/Views/utilities/restore_clients.php ${ids}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body:  JSON.parse(JSON.stringify({ ids }))
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
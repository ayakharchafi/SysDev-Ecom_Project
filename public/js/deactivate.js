
document.addEventListener('DOMContentLoaded', () => {
    const deactivateBtn = document.getElementById('deactivateBtn');
    const checkboxes = document.querySelectorAll('.userCheckbox');
    const selectAll = document.getElementById('selectAll');

    selectAll.addEventListener('click', () => {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    });

    deactivateBtn.addEventListener('click', () => {
        const selected = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (selected.length === 0) {
            alert('Please select at least one user.');
            return;
        }

        if (!confirm(`Are you sure you want to deactivate ${selected.length} user(s)?`)) {
            return;
        }

        fetch('/tern_app/SysDev-Ecom_Project/deactivate-users', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ user_ids: selected })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            location.reload();
        });
    });
});

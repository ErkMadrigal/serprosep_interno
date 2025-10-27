document.getElementById('checkboxSearch').addEventListener('input', function() {
    const searchTerm = this.value.trim().toLowerCase();
    const checkboxes = document.querySelectorAll('.custom-control.custom-checkbox');

    checkboxes.forEach(checkbox => {
        const label = checkbox.querySelector('.custom-control-label').textContent.toLowerCase();
        if (searchTerm === '' || label.includes(searchTerm)) {
            checkbox.style.display = 'block';
        } else {
            checkbox.style.display = 'none';
        }
    });
});
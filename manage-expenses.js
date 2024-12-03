document.addEventListener('DOMContentLoaded', () => {
    const deleteIcons = document.querySelectorAll('.delete-icon');
    const editForm = document.getElementById('edit-expense-form');
    
    const editFormInputs = {
        id: document.getElementById('updrec'),
        item: document.getElementById('item'),
        cost: document.getElementById('costitem'),
        date: document.getElementById('dateexpense'),
        category: document.getElementById('category') // Add category input field
    };

    // Handle delete icon click
    deleteIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const expenseId = icon.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this expense?')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.innerHTML = `<input type="hidden" name="delrec" value="${expenseId}">`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Handle edit icon click for each row
    const editIcons = document.querySelectorAll('.edit-icon');
    editIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const expenseId = icon.getAttribute('data-id');
            const expenseRow = icon.closest('tr');
            const expenseItem = expenseRow.querySelector('td:nth-child(1)').innerText;
            const expenseCost = expenseRow.querySelector('td:nth-child(2)').innerText.replace('₱', '');
            const expenseDate = expenseRow.querySelector('td:nth-child(3)').innerText;
            const expenseCategory = expenseRow.querySelector('td:nth-child(4)').innerText;

            editFormInputs.id.value = expenseId;
            editFormInputs.item.value = expenseItem;
            editFormInputs.cost.value = expenseCost;
            editFormInputs.date.value = expenseDate;
            editFormInputs.category.value = expenseCategory; // Set category value

            editForm.style.display = 'block';
        });
    });

    // Hide the edit form when clicking outside of it
    document.addEventListener('click', (e) => {
        if (e.target !== editForm && !editForm.contains(e.target) && !e.target.classList.contains('edit-icon')) {
            editForm.style.display = 'none';
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("expense-search");
        const searchButton = document.getElementById("search-button");
        const table = document.querySelector("table tbody");
    
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = table.querySelectorAll("tr");
    
            rows.forEach(row => {
                const cells = row.querySelectorAll("td");
                let match = false;
    
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        match = true;
                    }
                });
    
                if (match) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    
        searchButton.addEventListener("click", (e) => {
            e.preventDefault();
            filterTable();
        });
    
        searchInput.addEventListener("keyup", filterTable);
    });
    
});


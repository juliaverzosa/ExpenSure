document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('table-search');
    const searchButton = document.getElementById('search-btn');
    const tableBody = document.querySelector('#expense-table tbody');

    searchButton.addEventListener('click', () => {
        const keyword = searchInput.value;
        fetch('search-expenses.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `keyword=${keyword}`
        })
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = '';
            if (data.length > 0) {
                data.forEach(expense => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${expense.Item}</td>
                        <td>₱${expense.Cost}</td>
                        <td>${expense.CategoryName}</td>
                        <td>${expense.Date}</td>
                        <td>
                            <i class='edit-icon bx bx-edit' data-id='${expense.ExpenseID}'></i>
                            <i class='delete-icon bx bx-trash-alt' data-id='${expense.ExpenseID}'></i>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                const noResultsRow = document.createElement('tr');
                const noResultsCell = document.createElement('td');
                noResultsCell.colSpan = 5;
                noResultsCell.textContent = 'No matching expenses found.';
                noResultsRow.appendChild(noResultsCell);
                tableBody.appendChild(noResultsRow);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

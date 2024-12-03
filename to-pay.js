document.addEventListener('DOMContentLoaded', () => {
    const addPaymentBtn = document.getElementById('add-payment-btn');
    const addPaymentForm = document.getElementById('add-payment-form');
    const paymentForm = document.getElementById('payment-form');
    const paymentList = document.getElementById('payment-list');

    addPaymentBtn.addEventListener('click', () => {
        addPaymentForm.style.display = 'block';
    });

    paymentForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const itemName = document.getElementById('item-name').value;
        const itemCost = document.getElementById('item-cost').value;
        const itemDue = document.getElementById('item-due').value;

        const newItem = document.createElement('li');
        newItem.innerHTML = `
            <div class="payment-details">
                <div class="item-info">
                    <span class="item-name">${itemName}</span>
                    <span class="item-cost">PHP ${itemCost}</span>
                    <span class="item-due">Due: ${itemDue}</span>
                </div>
                <input type="checkbox" class="payment-checkbox">
            </div>
        `;

        paymentList.appendChild(newItem);
        addPaymentForm.style.display = 'none';
        paymentForm.reset();
    });

    document.addEventListener('change', (e) => {
        if (e.target.classList.contains('payment-checkbox')) {
            const itemCost = parseInt(e.target.parentElement.querySelector('.item-cost').innerText.replace('PHP ', ''));
            if (e.target.checked) {
                addToDashboard(itemCost);
            } else {
                subtractFromDashboard(itemCost);
            }
        }
    });

    function addToDashboard(cost) {
        let currentTotal = parseInt(document.getElementById('dashboard-total').innerText);
        currentTotal += cost;
        document.getElementById('dashboard-total').innerText = currentTotal;
    }

    function subtractFromDashboard(cost) {
        let currentTotal = parseInt(document.getElementById('dashboard-total').innerText);
        currentTotal -= cost;
        document.getElementById('dashboard-total').innerText = currentTotal;
    }
});

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="to-pay.css">
</head>
<body>
    <!-- To-Pay List -->
    <div class="to-pay">
        <div class="header">
            <i class='bx bx-credit-card'></i>
            <h3>To-Pay List</h3>
            <i class='bx bx-plus' id="add-payment-btn"></i>
        </div>
        <ul class="payment-list" id="payment-list">
            <!-- Payment items will be added here -->
        </ul>
    </div>

    <!-- Add Payment Form (Initially Hidden) -->
    <div class="add-payment-form" id="add-payment-form" style="display: none;">
        <form id="payment-form">
            <label for="item-name">Item:</label>
            <input type="text" id="item-name" name="item-name" required>
            <label for="item-cost">Cost:</label>
            <input type="text" id="item-cost" name="item-cost" required>
            <label for="item-due">Due Date:</label>
            <input type="date" id="item-due" name="item-due" required>
            <button type="submit">Done</button>
        </form>
    </div>

    <script src="index.js"></script>
    <script src="to-pay.js"></script>

</body>
</html>

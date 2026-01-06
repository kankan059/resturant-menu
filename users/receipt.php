<?php
include "../config/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$order_id = (int) ($_GET['id'] ?? 0);

/* fetch order */
$order = $conn->query(
    "SELECT * FROM orders WHERE id = $order_id"
)->fetch_assoc();

if (!$order) {
    die("Invalid Order");
}

/* fetch items */
$items = $conn->query(
    "SELECT * FROM order_items WHERE order_id = $order_id"
);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Receipt</title>
  <link rel="stylesheet" href="../assests/cs/index.css">
</head>
<body>

<div class="receipt-box">

  <h2>Restaurant Receipt</h2>
  <p class="sub">Thank you for dining with us</p>

  <div class="receipt-meta">
    <p>Order ID: <b>#<?= $order_id ?></b></p>
    <p>Date: <?= date("d M Y, h:i A", strtotime($order['created_at'])) ?></p>
  </div>

  <table class="receipt-table">
    <tr>
      <th>Item</th>
      <th>Qty</th>
      <th>Price</th>
    </tr>

    <?php while ($item = $items->fetch_assoc()): ?>
    <tr>
      <td><?= $item['item_name'] ?></td>
      <td><?= $item['quantity'] ?></td>
      <td>₹<?= $item['price'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

  <div class="receipt-total">
    Total: ₹<?= number_format($order['total_amount'], 2) ?>
  </div>

  <p class="pay-note">Please pay at the counter</p>

  <button onclick="window.print()">Print Receipt</button>

  <a href="menu.php" class="back-link">New Order</a>

</div>

</body>
</html>

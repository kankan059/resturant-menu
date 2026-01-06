<?php
include "../config/db.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../auth/login.php");
  exit;
}

$order_id = $_GET['id'];

$order = $conn->query(
  "SELECT * FROM orders WHERE id=$order_id"
)->fetch_assoc();

$items = $conn->query(
  "SELECT * FROM order_items WHERE order_id=$order_id"
);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Order Details</title>
  <link rel="stylesheet" href="../assests/cs/view_order.css">
  <link rel="stylesheet" href="../assests/cs/index.css">
</head>

<body>

  <div class="order-details">
    <div class="order-meta">
      <h2>Order #<?= $order_id ?></h2>
      <p class="order-total">Total: ₹<?= $order['total_amount'] ?></p>
      <p>Date: <?= $order['created_at'] ?></p>
    </div>
    <table>
      <tr>
        <th>Item</th>
        <th>Price</th>
        <th>Qty</th>
      </tr>

      <?php while ($item = $items->fetch_assoc()): ?>
        <tr>
          <td><?= $item['item_name'] ?></td>
          <td>₹<?= $item['price'] ?></td>
          <td><?= $item['quantity'] ?></td>
        </tr>
      <?php endwhile; ?>

    </table>

    <a class="back-btn" href="dashboard.php"> Back</a>

  </div>
</body>

</html>
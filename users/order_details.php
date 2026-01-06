<?php
include "../config/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$order_id = $_GET['id'];
$user_id  = $_SESSION['user']['id'];

/* security: user sirf apna order dekh sake */
$order = $conn->query(
    "SELECT * FROM orders
     WHERE id=$order_id AND user_id=$user_id"
)->fetch_assoc();

if (!$order) {
    die("Unauthorized access");
}

$items = $conn->query(
    "SELECT * FROM order_items WHERE order_id=$order_id"
);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Order Details</title>
  <link rel="stylesheet" href="../assests/cs/index.css">
  <link rel="stylesheet" href="../assests/cs/order.css">
</head>
<body>

<h2>Order #<?= $order_id ?></h2>
<p>Total: ₹<?= $order['total_amount'] ?></p>
<p>Date: <?= $order['created_at'] ?></p>

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

<a href="profile.php">⬅ Back</a>

</body>
</html>

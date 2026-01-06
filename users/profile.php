<?php
include "../config/db.php";

/* login guard */
if (!isset($_SESSION['user']['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$userId = (int) $_SESSION['user']['id'];

/* fetch user orders */
$sql = "SELECT id, total_amount, created_at 
        FROM orders 
        WHERE user_id = $userId 
        ORDER BY id DESC";

$orders = $conn->query($sql);

if ($orders === false) {
    die("SQL Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Orders</title>
  <link rel="stylesheet" href="../assests/cs/index.css">
  <link rel="stylesheet" href="../assests/cs/profile.css">
</head>
<body>

<header class="top-bar">
  <h2>My Orders</h2>
  <a href="menu.php">⬅ Back to Menu</a>
</header>

<section class="orders-wrapper">

<?php if ($orders->num_rows === 0): ?>

  <p class="empty">No orders yet</p>

<?php else: ?>

<table class="orders-table">
  <thead>
    <tr>
      <th>Order ID</th>
      <th>Total</th>
      <th>Date</th>
      <th>Details</th>
    </tr>
  </thead>

  <tbody>
  <?php while ($row = $orders->fetch_assoc()): ?>
    <tr>
      <td>#<?= $row['id'] ?></td>
      <td>₹<?= number_format($row['total_amount'], 2) ?></td>
      <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
      <td>
        <a class="btn-view" href="order_details.php?id=<?= $row['id'] ?>">
          View
        </a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

<?php endif; ?>

</section>

</body>
</html>

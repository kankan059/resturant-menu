<?php
include "../config/db.php";

/* security */
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* total orders */
$totalOrders = $conn->query("SELECT COUNT(*) AS total FROM orders")
                    ->fetch_assoc()['total'];

/* total revenue */
$totalRevenue = $conn->query("SELECT SUM(total_amount) AS revenue FROM orders")
                     ->fetch_assoc()['revenue'] ?? 0;

/* today orders */
$todayOrders = $conn->query(
    "SELECT COUNT(*) AS today 
     FROM orders 
     WHERE DATE(created_at) = CURDATE()"
)->fetch_assoc()['today'];

/* latest orders */
$latestOrders = $conn->query(
    "SELECT * FROM orders ORDER BY id DESC LIMIT 5"
);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assests/cs/dashboard.css">
  <link rel="stylesheet" href="../assests/cs/index.css">
</head>
<body>

<header class="admin-header">
  <h1>Admin Dashboard</h1>
  <div>
    <a href="../admin/menu_manage.php">manage menu</a>
    <a href="../auth/logout.php">Logout</a>
  </div>
</header>

<!-- STATS -->
<section class="stats">

  <div class="card">
    <h3>Total Orders</h3>
    <p><?= $totalOrders ?></p>
  </div>

  <div class="card">
    <h3>Total Revenue</h3>
    <p>₹<?= $totalRevenue ?></p>
  </div>

  <div class="card">
    <h3>Today Orders</h3>
    <p><?= $todayOrders ?></p>
  </div>

</section>

<!-- LATEST ORDERS -->
<section class="orders-section">
  <h2>Latest Orders</h2>

  <table>
    <tr>
      <th>Order ID</th>
      <th>Total</th>
      <th>Date</th>
      <th>View</th>
    </tr>

    <?php while ($row = $latestOrders->fetch_assoc()): ?>
    <tr>
      <td>#<?= $row['id'] ?></td>
      <td>₹<?= $row['total_amount'] ?></td>
      <td><?= $row['created_at'] ?></td>
      <td>
        <a href="view_order.php?id=<?= $row['id'] ?>">View</a>
      </td>
    </tr>
    <?php endwhile; ?>

  </table>
</section>

</body>
</html>

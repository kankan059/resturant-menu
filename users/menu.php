<?php
// session_start();
include "../config/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$result = $conn->query("SELECT * FROM menu_items");

$user  = $_SESSION['user'];
$count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Menu</title>
  <link rel="stylesheet" href="../assests/cs/index.css">
  <link rel="stylesheet" href="../assests/cs/menu.css">
</head>
<body>

<header class="top-bar">
  <h1>Restaurant Menu</h1>

  <div class="right">
    <span>👤 <?= htmlspecialchars($user['name']) ?></span>
    <a href="profile.php">My Orders</a>
    <span>🛒 <?= $count ?></span>
    <a href="bill.php">Bill</a>
    <a href="../auth/logout.php">Logout</a>
  </div>
</header>

<?php if (isset($_SESSION['added'])): ?>
  <div class="alert">
    <?= $_SESSION['added'] ?> added to order
  </div>
<?php unset($_SESSION['added']); endif; ?>

<section class="menu-container">

<?php if ($result->num_rows == 0): ?>
  <p>No items available</p>
<?php endif; ?>

<?php while ($item = $result->fetch_assoc()): ?>
  <div class="menu-item">
    <h3><?= $item['name'] ?></h3>
    <p><?= $item['category'] ?></p>
    <span>₹<?= $item['price'] ?></span>
    <a href="cart.php?id=<?= $item['id'] ?>">Add</a>
  </div>
<?php endwhile; ?>

</section>

</body>
</html>

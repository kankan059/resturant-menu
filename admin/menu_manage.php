<?php
include "../config/db.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $sql = "INSERT INTO menu_items (name, price, category)
            VALUES ('$name', '$price', '$category')";

    if ($conn->query($sql)) {
        $msg = "Item added successfully";
    } else {
        $msg = "Error adding item";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Menu</title>
  <link rel="stylesheet" href="../assests/cs/menu-mamange.css">
  <link rel="stylesheet" href="../assests/cs/index.css">
</head>
<body>

<h2>Add Menu Item</h2>

<p><?= $msg ?></p>

<form method="post">
  <label>Item Name</label>
  <input type="text" name="name">

  <label>Price</label>
  <input type="number" name="price">

  <label>Category</label>
  <input type="text" name="category">

  <button type="submit">Add Item</button>
</form>

<hr>

<h3>Menu List</h3>

<table border="1">
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Price</th>
  <th>Category</th>
  <th>Action</th>
</tr>


<?php
$res = $conn->query("SELECT * FROM menu_items");
while ($row = $res->fetch_assoc()):
?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['name'] ?></td>
  <td>₹<?= $row['price'] ?></td>
  <td><?= $row['category'] ?></td>
  <td>
    <a href="delete-menu.php?id=<?= $row['id'] ?>"
       onclick="return confirm('Delete this item?')"
       class="delete-btn">
       Remove
    </a>
  </td>
</tr>

<?php endwhile; ?>

</table>

</body>
</html>

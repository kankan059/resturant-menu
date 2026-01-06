<?php
include "../config/db.php";

$cart = $_SESSION['cart'] ?? [];
$total = 0;

/* confirm order */
if (isset($_POST['confirm']) && !empty($cart)) {

    // calculate total
    foreach ($cart as $item) {
        $total += $item['price'];
    }

    // insert into orders
    $user_id = $_SESSION['user']['id'];

    $conn->query(
        "INSERT INTO orders (user_id, total_amount)
   VALUES ($user_id, $total)"
    );
    $order_id = $conn->insert_id;

    // insert order items
    foreach ($cart as $item) {
        $name  = $item['name'];
        $price = $item['price'];

        $conn->query(
            "INSERT INTO order_items (order_id, item_name, price, quantity)
           VALUES ($order_id, '$name', '$price', 1)"
        );
    }

    // clear cart
    unset($_SESSION['cart']);

    // success redirect
    header("Location: receipt.php?id=$order_id");

    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Bill</title>
    <link rel="stylesheet" href="../assests/cs/index.css">
    <link rel="stylesheet" href="../assests/cs/bill.css">
</head>

<body>

    <h2>Current Bill</h2>

    <?php if (empty($cart)): ?>
        <p>No items added</p>
    <?php else: ?>

        <table border="1">
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Price</th>
                <th>Action</th>
            </tr>

            <?php foreach ($cart as $i => $item):
                $total += $item['price']; ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $item['name'] ?></td>
                    <td>₹<?= $item['price'] ?></td>
                    <td>
                        <a href="remove_item.php?index=<?= $i ?>">❌ Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

        <h3>Total: ₹<?= $total ?></h3>

        <form method="post">
            <button type="submit" name="confirm">Confirm Order</button>
        </form>

    <?php endif; ?>

</body>

</html>
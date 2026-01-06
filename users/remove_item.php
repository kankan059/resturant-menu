<?php
include "../config/db.php";

if (!isset($_GET['index'])) {
    header("Location: bill.php");
    exit;
}

$index = $_GET['index'];

/* remove item */
if (isset($_SESSION['cart'][$index])) {
    unset($_SESSION['cart'][$index]);

    // reindex array (IMPORTANT)
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: bill.php");
exit;

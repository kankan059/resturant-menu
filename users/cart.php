<?php
include "../config/db.php";

$id = $_GET['id'];

$item = $conn->query("SELECT * FROM menu_items WHERE id=$id")->fetch_assoc();

$_SESSION['cart'][] = $item;

/* feedback flag */
$_SESSION['added'] = $item['name'];

header("Location: menu.php");
exit;

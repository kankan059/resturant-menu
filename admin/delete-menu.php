<?php
include "../config/db.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: menu_manage.php");
    exit;
}

$id = (int) $_GET['id'];

/* delete item */
$conn->query("DELETE FROM menu_items WHERE id = $id");

header("Location: menu_manage.php");
exit;

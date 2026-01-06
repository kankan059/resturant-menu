<?php
include "config/db.php";

/* Not logged in */
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

/* Logged in */
$user = $_SESSION['user'];

/* Role based redirect */
if ($user['role'] === 'admin') {
    header("Location: admin/dashboard.php");
} else {
    header("Location: user/menu.php");
}
exit;
?>
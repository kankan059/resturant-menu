<?php
$conn = new mysqli("localhost", "root", "", "restaurant_app");
if ($conn->connect_error) {
    die("DB Error");
}

session_start();

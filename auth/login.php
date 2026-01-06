<?php
include "../config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email == "" || $password == "") {
        $error = "Email and password required";
    } else {

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result === false) {
            die("SQL Error: " . $conn->error);
        }

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // verify password
            if (password_verify($password, $user['password'])) {

                $_SESSION['user'] = $user;

                // role based redirect
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../users/menu.php");
                }
                exit;

            } else {
                $error = "Wrong password";
            }
        } else {
            $error = "User not found";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="../assests/cs/index.css">
  <link rel="stylesheet" href="../assests/cs/login.css">
</head>
<body>

<div class="auth-box">
  <h2>Login</h2>

  <?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
  <?php endif; ?>

  <form method="post">
    <label>Email</label>
    <input type="email" name="email">

    <label>Password</label>
    <input type="password" name="password">

    <button type="submit">Login</button>
  </form>

  <p>
    New user?
    <a href="signup.php">Create account</a>
  </p>
</div>

</body>
</html>

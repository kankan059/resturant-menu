<?php
include "../config/db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if ($name == "" || $email == "" || $password == "") {
        $error = "All fields are required";
    } else {

        // check email already exists
        $check = $conn->query("SELECT id FROM users WHERE email='$email'");
        if ($check === false) {
            die("SQL Error: " . $conn->error);
        }

        if ($check->num_rows > 0) {
            $error = "Email already registered";
        } else {

            // password hash
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // insert user
            $sql = "INSERT INTO users (name, email, password, role)
                    VALUES ('$name', '$email', '$hash', 'user')";

            if ($conn->query($sql)) {
                $success = "Signup successful. You can login now.";
            } else {
                $error = "Signup failed";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
    <link rel="stylesheet" href="../assests/cs/index.css">
    <link rel="stylesheet" href="../assests/cs/signup.css">
</head>

<body>

    <div class="auth-box">
        <h2>Create Account</h2>

        <?php if ($error): ?>
            <p style="color:red"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color:green"><?= $success ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Name</label>
            <input type="text" name="name">

            <label>Email</label>
            <input type="email" name="email">

            <label>Password</label>
            <input type="password" name="password">

            <button type="submit">Sign Up</button>
        </form>

        <p>Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>

</body>

</html>
<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Login berhasil: arahkan ke halaman index.php
            header("Location: formconsul.php");
            exit(); // Menghentikan eksekusi script setelah redirect
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/loginstyle.css">
    <title>Login</title>
</head>
<body>
    <div class="login-page">
        <div class="form-section">
            <div class="form-container">
                <img src="assets/imgs/avatar.png" alt="Logo" class="logo">
                <h1>Login to Ndrella Agro Distribution</h1>
                <form method="POST">
                    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                    <input type="text" name="username" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <p><a href="#">Forgot Password?</a></p>
                    <button type="submit">Login</button>
                </form>
                <div class="social-login">
                    <p>Or login with:</p>
                    <div class="social-buttons">
                        <button class="google">G</button>
                        <button class="facebook">F</button>
                    </div>
                </div>
                <p>Don’t have an Account? <a href="register.php">Register</a></p>
            </div>
        </div>
    </div>
</body>
</html>

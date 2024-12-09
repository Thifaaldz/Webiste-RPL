<?php
// Include file koneksi database
include 'db.php';

// Variabel untuk menyimpan pesan error atau sukses
$error = '';
$success = '';

// Proses jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password dan confirm password
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query insert data ke tabel users
        $query = "INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $fullname, $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $success = "Registration successful! You can now login.";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/registrasi.css">
    <title>Register | Ndrella Agro Distribution</title>
</head>
<body>
    <div class="register-container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="logo">
                <img src="assets/imgs/avatar.png" alt="Ndrella Agro Logo">
            </div>
            <h1>Ndrella Agro Distribution</h1>
            <p>Start Growing with Us</p>
            <img class="promo-image" src="assets/imgs/field1.jpg" alt="Farming Image">
            <div class="social-links">
                <a href="#"><img src="assets/imgs/instagramw.png" alt="Instagram"></a>
                <a href="#"><img src="assets/imgs/xw.png" alt="Twitter"></a>
                <a href="#"><img src="assets/imgs/linkedinw.png" alt="LinkedIn"></a>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <h2>REGISTER PAGE</h2>

            <!-- Tampilkan pesan error atau sukses -->
            <?php if (!empty($error)) { ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php } ?>
            <?php if (!empty($success)) { ?>
                <p style="color: green;"><?= $success; ?></p>
            <?php } ?>

            <form method="POST" action="">
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "Noisyboy18";
$dbname = "Perkebunan";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data supplier berdasarkan ID
$sql = "SELECT nomor_resi FROM supplier WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomor_resi = $row['nomor_resi'];
} else {
    die("Data tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="assets/css/resistyles.css">
    <title>Nomor Resi</title>
</head>
<body>
    <div class="container">
        <h1>Nomor Resi Pengiriman</h1>
        <p>Nomor Resi Anda: <strong><?php echo $nomor_resi; ?></strong></p>
        <p>Terima kasih atas pembayaran Anda. Pengiriman akan segera diproses.</p>
        <a href="index.php">Kembali ke Beranda</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>

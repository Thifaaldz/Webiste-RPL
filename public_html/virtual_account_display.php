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
$sql = "SELECT virtual_account FROM supplier WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $virtual_account = $row['virtual_account'];
} else {
    die("Data tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/vastyles.css">
    <title>Virtual Account</title>
</head>
<body>
    <h1>Nomor Virtual Account</h1>
    <p>Nomor Virtual Account Anda: <strong><?php echo $virtual_account; ?></strong></p>
    
    <form action="upload_receipt.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="bukti">Unggah Bukti Pembayaran:</label>
        <input type="file" name="bukti" id="bukti" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>

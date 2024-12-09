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

// Variabel untuk menyimpan hasil pencarian
$data = null;
$error_message = null;

// Proses pencarian berdasarkan nomor resi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomor_resi = $conn->real_escape_string($_POST['nomor_resi']);

    $sql = "SELECT * FROM supplier WHERE nomor_resi = '$nomor_resi'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        $error_message = "Data dengan nomor resi tersebut tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Nomor Resi</title>
    <link rel="stylesheet" href="assets/css/pegirimanstyles.css">
</head>
<body>
    <div class="container">
        <h1>Cari Data Pemesanan</h1>
        <form method="POST" action="">
            <label for="nomor_resi">Masukkan Nomor Resi:</label>
            <input type="text" id="nomor_resi" name="nomor_resi" placeholder="Contoh: RESI12345" required>
            <button type="submit">Cari</button>
        </form>

        <?php if ($data): ?>
            <h2>Data Pemesanan</h2>
            <table>
                <tr><th>Nama Perusahaan</th><td><?php echo htmlspecialchars($data['nama_perusahaan']); ?></td></tr>
                <tr><th>Email</th><td><?php echo htmlspecialchars($data['email']); ?></td></tr>
                <tr><th>Telepon</th><td><?php echo htmlspecialchars($data['telepon']); ?></td></tr>
                <tr><th>Produk</th><td><?php echo htmlspecialchars($data['produk']); ?></td></tr>
                <tr><th>Jumlah</th><td><?php echo htmlspecialchars($data['jumlah']); ?></td></tr>
                <tr><th>Alamat Pengiriman</th><td><?php echo htmlspecialchars($data['alamat_pengiriman']); ?></td></tr>
                <tr><th>Metode Pengiriman</th><td><?php echo htmlspecialchars($data['metode_pengiriman']); ?></td></tr>
                <tr><th>Kendaraan</th><td><?php echo htmlspecialchars($data['kendaraan']); ?></td></tr>
                <tr><th>Tanggal Pengiriman</th><td><?php echo htmlspecialchars($data['tanggal_pengiriman']); ?></td></tr>
                <tr><th>Catatan</th><td><?php echo htmlspecialchars($data['catatan']); ?></td></tr>
            </table>
            <a href="details.php?nomor_resi=<?php echo urlencode($data['nomor_resi']); ?>" class="button">Periksa Lebih Lanjut</a>
        <?php elseif ($error_message): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

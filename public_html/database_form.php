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

// Ambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$produk = $_POST['produk'];
$jumlah = $_POST['jumlah'];
$alamat = $_POST['alamat'];
$metode = $_POST['metode'];
$kendaraan = $_POST['Kendaraan'];
$tanggal = $_POST['tanggal'];
$catatan = $_POST['catatan'];

// Generate virtual account
$virtual_account = 'VA-' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

// Simpan ke database
$sql = "INSERT INTO supplier (nama_perusahaan, email, telepon, produk, jumlah, alamat_pengiriman, metode_pengiriman, kendaraan, tanggal_pengiriman, catatan, virtual_account)
        VALUES ('$nama', '$email', '$telepon', '$produk', '$jumlah', '$alamat', '$metode', '$kendaraan', '$tanggal', '$catatan', '$virtual_account')";

if ($conn->query($sql) === TRUE) {
    // Ambil ID yang baru saja dimasukkan
    $last_id = $conn->insert_id;

    // Redirect ke halaman virtual account
    header("Location: virtual_account_display.php?id=$last_id");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>

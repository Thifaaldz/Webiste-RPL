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
$id = $_POST['id'];
$target_dir = "uploads/";

// Pastikan direktori tujuan ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // Buat direktori jika belum ada
}

$original_file_name = $_FILES["bukti"]["name"];
$clean_file_name = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $original_file_name); // Hilangkan karakter khusus
$target_file = $target_dir . uniqid() . "_" . $clean_file_name;

// Simpan file
if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
    // Generate nomor resi
    $nomor_resi = 'RESI-' . strtoupper(substr(md5(time()), 0, 8));

    // Simpan path bukti pembayaran dan nomor resi ke database
    $sql = "UPDATE supplier SET bukti_pembayaran='$target_file', nomor_resi='$nomor_resi' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman resi
        header("Location: resi_display.php?id=$id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Terjadi kesalahan saat mengupload file. Pastikan direktori 'uploads/' memiliki izin tulis.";
}

// Tutup koneksi
$conn->close();
?>

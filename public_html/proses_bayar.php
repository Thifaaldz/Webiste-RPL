<?php
$host = "localhost";
$user = "root";
$pass = "Noisyboy18";
$db = "perkebunan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $total_bayar = $_POST['total_bayar'];
    $payment_method = $_POST['payment_method'];

    // Simpan pembayaran
    $sql = "INSERT INTO payments (order_id, total_bayar, payment_method, payment_status) VALUES (?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $order_id, $total_bayar, $payment_method);
    $stmt->execute();

    echo "Pembayaran berhasil diproses. Silakan lanjutkan pembayaran melalui metode yang dipilih.";
}
?>

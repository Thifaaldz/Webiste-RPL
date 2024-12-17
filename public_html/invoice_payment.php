<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "Noisyboy18";
$db = "perkebunan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Ambil data order berdasarkan order_id (dari GET atau POST)
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : (isset($_POST['order_id']) ? $_POST['order_id'] : null);
if (!$order_id) {
    die("Order ID tidak valid!");
}

// Query data orders, bahan_baku, dan payments
$stmt = $conn->prepare("
    SELECT o.*, 
           b.nama AS item_name, 
           b.harga AS item_price, 
           p.payment_method, 
           p.payment_status, 
           p.total_bayar 
    FROM orders o 
    JOIN bahan_baku b ON o.bahan_id = b.id
    LEFT JOIN payments p ON p.order_id = o.id
    WHERE o.id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Order tidak ditemukan!");
}
$order = $result->fetch_assoc();

// Perhitungan biaya
$subtotal = $order['item_quantity'] * $order['item_price'];
$shipping_cost = isset($_POST['shipping_cost']) ? $_POST['shipping_cost'] : 1200000; // Default ongkos kirim
$protection_fee = 450000; // Biaya proteksi
$app_fee = 2000; // Biaya aplikasi
$total = $subtotal + $shipping_cost + $protection_fee + $app_fee;

// Cetak PDF menggunakan Dompdf
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .info, .details { margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        .total { font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 12px; color: gray; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ndrella Agro Distribution</h1>
        <p><strong>Invoice ID:</strong> INV20240604/MPL/' . $order_id . '</p>
        <p><strong>Status Pembayaran:</strong> ' . ucfirst($order['payment_status'] ?? 'Belum Dibayar') . '</p>
    </div>

    <div class="info">
        <p><strong>Nama Pelanggan:</strong> ' . htmlspecialchars($order['full_name']) . '</p>
        <p><strong>Alamat Pengiriman:</strong> ' . htmlspecialchars($order['shipping_address']) . ', ' . htmlspecialchars($order['city']) . ', ' . htmlspecialchars($order['province']) . ', ' . htmlspecialchars($order['postal_code']) . '</p>
        <p><strong>Metode Pembayaran:</strong> ' . htmlspecialchars($order['payment_method'] ?? "Belum Dipilih") . '</p>
    </div>

    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga per Kg</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>' . htmlspecialchars($order['item_name']) . '</td>
            <td>' . $order['item_quantity'] . ' Kg</td>
            <td>Rp ' . number_format($order['item_price'], 0, ",", ".") . '</td>
            <td>Rp ' . number_format($subtotal, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td colspan="3">Subtotal</td>
            <td>Rp ' . number_format($subtotal, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td colspan="3">Ongkos Kirim</td>
            <td>Rp ' . number_format($shipping_cost, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td colspan="3">Proteksi Barang</td>
            <td>Rp ' . number_format($protection_fee, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td colspan="3">Biaya Aplikasi</td>
            <td>Rp ' . number_format($app_fee, 0, ",", ".") . '</td>
        </tr>
        <tr class="total">
            <td colspan="3">Total Tagihan</td>
            <td>Rp ' . number_format($total, 0, ",", ".") . '</td>
        </tr>
    </table>

    <div class="footer">
        <p>Pembayaran dapat dilakukan melalui Transfer Bank BCA<br>
        A/C: 164-077-017<br>
        A/N: PT NDRELLA AGRO DISTRIBUTION</p>
    </div>
</body>
</html>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("invoice_payment_$order_id.pdf", ["Attachment" => false]);
?>
    
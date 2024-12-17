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

// Ambil data bahan baku
$bahan_baku = [];
$sql_bahan_baku = "SELECT * FROM bahan_baku";
$result_bahan_baku = $conn->query($sql_bahan_baku);
if ($result_bahan_baku->num_rows > 0) {
    while ($row = $result_bahan_baku->fetch_assoc()) {
        $bahan_baku[] = $row;
    }
}

// Simpan data pesanan jika formulir dikirim
$order_summary = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input
    if (empty($_POST['bahan_baku']) || empty($_POST['item_quantity'])) {
        echo "<script>alert('Harap pilih bahan baku dan tentukan jumlah barang!');</script>";
    } else {
        $bahan_id = $_POST['bahan_baku'];
        $item_quantity = $_POST['item_quantity'];

        // Ambil data bahan baku
        $stmt = $conn->prepare("SELECT * FROM bahan_baku WHERE id = ?");
        $stmt->bind_param("i", $bahan_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            die("Bahan baku tidak ditemukan!");
        } else {
            $bahan = $result->fetch_assoc();

            // Ambil data formulir
            $full_name = $_POST['full_name'];
            $company_name = $_POST['company_name'];
            $email = $_POST['email'];
            $shipping_address = $_POST['shipping_address'];
            $city = $_POST['city'];
            $province = $_POST['province'];
            $postal_code = $_POST['postal_code'];
            $additional_message = $_POST['additional_message'];
            $item_name = $bahan['nama'];
            $item_price = $bahan['harga'];
            $total_price = $item_price * $item_quantity;

            // Simpan ke database orders
            $sql_insert = "INSERT INTO orders (full_name, company_name, email, shipping_address, city, province, postal_code, additional_message, item_name, item_price, item_quantity, total_price, bahan_id) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param(
                "sssssssssdidi",
                $full_name, $company_name, $email, $shipping_address, $city,
                $province, $postal_code, $additional_message, $item_name, 
                $item_price, $item_quantity, $total_price, $bahan_id
            );
            $stmt->execute();

            // Ambil ringkasan pesanan
            $last_id = $conn->insert_id;
            $summary_sql = "SELECT * FROM orders WHERE id = ?";
            $stmt = $conn->prepare($summary_sql);
            $stmt->bind_param("i", $last_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $order_summary = $result->fetch_assoc();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pembayaran</title>
    <link rel="stylesheet" href="assets/css/pesanan.css">
</head>
<body>
    <header>
    <div class="header">
    <img src="assets/imgs/avatar.png" alt="Logo Ndrella Agro Distribution" class="logo">
    <h1>Ndrella Agro Distribution</h1>
</div>
    </header>

    <div class="container">
        <form method="POST" action="">
            <h2>Formulir Pembayaran</h2>
            <div class="row">
                <div>
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" required>
                </div>
                <div>
                    <label>Nama Perusahaan</label>
                    <input type="text" name="company_name">
                </div>
            </div>
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Alamat Pengiriman</label>
            <input type="text" name="shipping_address" required>

            <div class="row">
                <div>
                    <label>Kota</label>
                    <input type="text" name="city" required>
                </div>
                <div>
                    <label>Provinsi</label>
                    <input type="text" name="province" required>
                </div>
                <div>
                    <label>Kode Pos</label>
                    <input type="text" name="postal_code" required>
                </div>
            </div>

            <label>Pilih Bahan Baku</label>
            <select name="bahan_baku" required>
                <option value="">-- Pilih Bahan Baku --</option>
                <?php foreach ($bahan_baku as $bahan): ?>
                    <option value="<?php echo $bahan['id']; ?>">
                        <?php echo $bahan['nama'] . " - Rp " . number_format($bahan['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Jumlah Barang</label>
            <input type="number" name="item_quantity" value="1" min="1" required>

            <label>Pesan Tambahan</label>
            <textarea name="additional_message"></textarea>

            <button type="submit">PEMBAYARAN</button>
        </form>

        <!-- Ringkasan Pesanan -->
        <?php if (!empty($order_summary)): ?>
        <div class="summary">
            <h2>Ringkasan Pesanan</h2>
            <p><strong>Nama:</strong> <?php echo $order_summary['full_name']; ?></p>
            <p><strong>Nama Perusahaan:</strong> <?php echo $order_summary['company_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $order_summary['email']; ?></p>
            <p><strong>Alamat Pengiriman:</strong> <?php echo $order_summary['shipping_address']; ?></p>
            <p><strong>Kota:</strong> <?php echo $order_summary['city']; ?></p>
            <p><strong>Provinsi:</strong> <?php echo $order_summary['province']; ?></p>
            <p><strong>Kode Pos:</strong> <?php echo $order_summary['postal_code']; ?></p>
            <p><strong>Pesan Tambahan:</strong> <?php echo $order_summary['additional_message']; ?></p>
            <p><strong>Nama Barang:</strong> <?php echo $order_summary['item_name']; ?></p>
            <p><strong>Harga:</strong> Rp <?php echo number_format($order_summary['item_price'], 0, ',', '.'); ?></p>
            <p><strong>Jumlah:</strong> <?php echo $order_summary['item_quantity']; ?></p>
            <p><strong>Total Harga:</strong> Rp <?php echo number_format($order_summary['item_price'] * $order_summary['item_quantity'], 0, ',', '.'); ?></p>
             <button >Bayar</button>
        </div>
        <form method="POST" action="payment.php">
        <input type="hidden" name="order_id" value="<?php echo $order_summary['id']; ?>">
        <input type="hidden" name="total_price" value="<?php echo $order_summary['total_price']; ?>">
        <input type="hidden" name="full_name" value="<?php echo $order_summary['full_name']; ?>">
        <input type="hidden" name="company_name" value="<?php echo $order_summary['company_name']; ?>">
        <input type="hidden" name="email" value="<?php echo $order_summary['email']; ?>">
        <input type="hidden" name="shipping_address" value="<?php echo $order_summary['shipping_address']; ?>">
        <input type="hidden" name="city" value="<?php echo $order_summary['city']; ?>">
        <input type="hidden" name="province" value="<?php echo $order_summary['province']; ?>">
        <input type="hidden" name="postal_code" value="<?php echo $order_summary['postal_code']; ?>">
        <input type="hidden" name="additional_message" value="<?php echo $order_summary['additional_message']; ?>">
        <input type="hidden" name="item_name" value="<?php echo $order_summary['item_name']; ?>">
        <input type="hidden" name="item_price" value="<?php echo $order_summary['item_price']; ?>">
        <input type="hidden" name="item_quantity" value="<?php echo $order_summary['item_quantity']; ?>">
        <button type="submit">Bayar Sekarang</button>
    </form>
    </form>
        <?php endif; ?>
    </div>
</body>
</html>

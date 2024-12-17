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

// Ambil data order terakhir berdasarkan order_id
$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : null;
if ($order_id) {
    $stmt = $conn->prepare("SELECT o.*, b.nama AS item_name, b.harga AS item_price, b.gambar AS item_image FROM orders o JOIN bahan_baku b ON o.bahan_id = b.id WHERE o.id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die("Order tidak ditemukan!");
    }
    $order = $result->fetch_assoc();
} else {
    die("Order ID tidak valid!");
}

// Daftar opsi pengiriman
$shipping_options = [
    "Mobil Wingbox" => 1200000,
    "Truk Engkel" => 800000,
    "Pickup" => 500000
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pembayaran</title>
    <link rel="stylesheet" href="assets/css/payment.css"> <!-- Link ke file CSS -->
</head>
<body>

    <!-- Header -->
    <header>
        <div class="header">
            <img src="assets/imgs/avatar.png" alt="Logo Ndrella Agro Distribution" class="logo">
            <h1>Ndrella Agro Distribution</h1>
        </div>
    </header>

    <!-- Content -->
    <div class="content">
        <!-- Kiri -->
        <div class="left-section">
            <div class="product">
                <img src="<?php echo $order['item_image']; ?>" alt="<?php echo $order['item_name']; ?>">
                <div>
                    <p><strong><?php echo $order['item_name']; ?></strong></p>
                    <p><?php echo $order['item_quantity']; ?> Kg</p>
                    <p>Rp <?php echo number_format($order['item_price'], 0, ',', '.'); ?></p>
                </div>
            </div>

            <div class="location">
                <p><strong>Alamat Pengiriman:</strong></p>
                <p><?php echo $order['shipping_address']; ?></p>
            </div>

            <div class="shipping">
                <label for="shipping_method">Pilih Pengiriman:</label>
                <select name="shipping_method" id="shipping_method" required>
                    <option value="">Pilih Opsi</option>
                    <?php foreach ($shipping_options as $method => $cost): ?>
                        <option value="<?php echo $cost; ?>"><?php echo $method; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="payment">
                <label>Metode Pembayaran:</label>
                <button id="openModal" class="btn-popup">Pilih Metode Pembayaran</button>
                <p id="selectedMethod" style="margin-top: 10px;"><strong>Metode Terpilih: -</strong></p>
            </div>

        </div>

        <form method="POST" action="invoice_payment.php">
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
    <input type="hidden" name="total_bill" id="hidden_total_bill" value="0">
    <input type="hidden" name="payment_method" id="payment_method" value="">
    
    <!-- Kontainer untuk Ringkasan -->
    <div class="right-section">
        <div class="summary">
            <p><strong>Subtotal Harga Barang:</strong> Rp <?php echo number_format($order['item_price'] * $order['item_quantity'], 0, ',', '.'); ?></p>
            <p><strong>Ongkos Kirim:</strong> Rp <span id="shipping_cost">0</span></p>
            <p><strong>Proteksi Barang:</strong> Rp 450.000</p>
            <p><strong>Grand Total:</strong> Rp <span id="grand_total">0</span></p>
            <p><strong>Biaya Jasa Aplikasi:</strong> Rp 2.000</p>
            <h3><strong>Total Tagihan:</strong> Rp <span id="total_bill">0</span></h3>
        </div>
        <!-- Tombol Bayar -->
        <button type="submit" class="btn-bayar" id="btn_bayar">Bayar</button>
    </div>
</form>

<!-- Modal Popup -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h3 class="modal-title">Pilih Pembayaran</h3>

        <!-- Virtual Account Section -->
        <div class="modal-section">
            <h4>Virtual Account</h4>
            <div class="payment-option" data-method="BCA Virtual Account">
                <img src="assets/imgs/bca.png" alt="BCA">
                <span>BCA Virtual Account</span>
                <span class="arrow">&gt;</span>
            </div>
            <div class="payment-option" data-method="Mandiri Virtual Account">
                <img src="assets/imgs/mandiri.png" alt="Mandiri">
                <span>Mandiri Virtual Account</span>
                <span class="arrow">&gt;</span>
            </div>
            <div class="payment-option" data-method="BRI Virtual Account">
                <img src="assets/imgs/bri.png" alt="BRI">
                <span>BRI Virtual Account</span>
                <span class="arrow">&gt;</span>
            </div>
        </div>

        <!-- Transfer Bank Section -->
        <div class="modal-section">
            <h4>Transfer Bank</h4>
            <div class="payment-option" data-method="Bank BCA">
                <img src="assets/imgs/bca.png" alt="BCA">
                <span>Bank BCA</span>
                <span class="arrow">&gt;</span>
            </div>
            <div class="payment-option" data-method="Bank Mandiri">
                <img src="assets/imgs/mandiri.png" alt="Mandiri">
                <span>Bank Mandiri</span>
                <span class="arrow">&gt;</span>
            </div>
        </div>
    </div>
</div>

<script>
// Dapatkan elemen-elemen modal
const modal = document.getElementById("paymentModal");
const openModal = document.getElementById("openModal");
const closeModal = document.getElementById("closeModal");
const paymentOptions = document.querySelectorAll('.payment-option');
const selectedMethod = document.getElementById('selectedMethod');

// Event: buka modal
openModal.onclick = function () {
    modal.style.display = "flex"; /* Menggunakan flex untuk memastikan modal berada di tengah */
};

// Event: tutup modal
closeModal.onclick = function () {
    modal.style.display = "none"; /* Menutup modal */
};

// Tutup modal jika klik di luar modal-content
window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};

// Mengupdate metode pembayaran terpilih
paymentOptions.forEach(option => {
    option.addEventListener('click', function () {
        const method = option.getAttribute('data-method');
        selectedMethod.innerHTML = `<strong>Metode Terpilih:</strong> ${method}`;
        modal.style.display = "none";  // Menutup modal setelah memilih
    });
});

    // Script untuk menghitung total harga berdasarkan pengiriman yang dipilih
    const shippingMethod = document.getElementById('shipping_method');
    const shippingCost = document.getElementById('shipping_cost');
    const grandTotal = document.getElementById('grand_total');
    const totalBill = document.getElementById('total_bill');

    const itemPrice = <?php echo $order['item_price'] * $order['item_quantity']; ?>;
    const protectionCost = 450000;
    const appFee = 2000;

    shippingMethod.addEventListener('change', () => {
        const selectedShippingCost = parseInt(shippingMethod.value) || 0;
        const calculatedGrandTotal = itemPrice + selectedShippingCost + protectionCost;
        const calculatedTotalBill = calculatedGrandTotal + appFee;

        shippingCost.textContent = selectedShippingCost.toLocaleString('id-ID');
        grandTotal.textContent = calculatedGrandTotal.toLocaleString('id-ID');
        totalBill.textContent = calculatedTotalBill.toLocaleString('id-ID');
    });
</script>

</body>
</html>

<?php
include 'db.php';


// Ambil riwayat pemesanan dari tabel orders
$sql = "SELECT * FROM orders ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .status-paid {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Riwayat Pemesanan</h1>

<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Alamat Pengiriman</th>
                <th>Nama Barang</th>
                <th>Harga Barang</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Status Pembayaran</th>
                <th>Provider Pengiriman</th>
                <th>Nomor Resi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['shipping_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                    <td>Rp<?php echo number_format($row['item_price'], 2, ',', '.'); ?></td>
                    <td><?php echo $row['item_quantity']; ?></td>
                    <td>Rp<?php echo number_format($row['total_price'], 2, ',', '.'); ?></td>
                    <td class="status-<?php echo strtolower($row['payment_status']); ?>">
                        <?php echo $row['payment_status']; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['shipping_provider'] ?: '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['tracking_number'] ?: '-'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Tidak ada riwayat pemesanan.</p>
<?php endif; ?>

<?php $conn->close(); ?>

</body>
</html>

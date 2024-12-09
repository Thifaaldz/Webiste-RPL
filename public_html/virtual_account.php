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

// Ambil data supplier
$sql = "SELECT id, virtual_account, bukti_pembayaran, nomor_resi FROM supplier";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Account dan Pembayaran</title>
</head>
<body>
    <h1>Daftar Virtual Account</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Virtual Account</th>
            <th>Bukti Pembayaran</th>
            <th>Nomor Resi</th>
            <th>Upload Bukti Pembayaran</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['virtual_account']}</td>
                        <td>" . ($row['bukti_pembayaran'] ? "<a href='{$row['bukti_pembayaran']}'>Lihat Bukti</a>" : "Belum diupload") . "</td>
                        <td>" . ($row['nomor_resi'] ? $row['nomor_resi'] : "Belum tersedia") . "</td>
                        <td>
                            <form action='upload_bukti.php' method='post' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='file' name='bukti' required>
                                <button type='submit'>Upload</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>

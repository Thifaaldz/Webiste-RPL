<?php
// Konfigurasi koneksi database
$host = "localhost";
$user = "root";
$pass = "Noisyboy18";
$db = "perkebunan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Fungsi untuk mengambil semua data tracking
function getAllTracking($conn) {
    $sql = "SELECT st.id, st.tracking_number, st.status, st.last_updated, o.full_name AS sender_name, o.company_name AS receiver_name FROM shipping_tracking st JOIN orders o ON st.tracking_number = o.tracking_number";
    $result = $conn->query($sql);
    $trackings = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $trackings[] = $row;
        }
    }
    return $trackings;
}

// Fungsi untuk memperbarui status tracking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tracking_id = $_POST['tracking_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE shipping_tracking SET status = ?, last_updated = NOW() WHERE id = ?");
    $stmt->bind_param("si", $status, $tracking_id);

    if ($stmt->execute()) {
        $message = "Status berhasil diperbarui.";
    } else {
        $message = "Gagal memperbarui status.";
    }
}

$trackings = getAllTracking($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tracking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #f1f1f1;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manajemen Tracking Pengiriman</h1>

        <?php if (isset($message)): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Nomor Resi</th>
                    <th>Pengirim</th>
                    <th>Penerima</th>
                    <th>Status</th>
                    <th>Terakhir Diperbarui</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trackings as $tracking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tracking['tracking_number']); ?></td>
                        <td><p>PT.Nderrla Argo Distribution</p></td>
                        <td><?php echo htmlspecialchars($tracking['receiver_name']); ?></td>
                        <td><?php echo htmlspecialchars($tracking['status']); ?></td>
                        <td><?php echo htmlspecialchars($tracking['last_updated']); ?></td>
                        <td>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="tracking_id" value="<?php echo htmlspecialchars($tracking['id']); ?>">
                                <select name="status">
                                    <option value="Diproses" <?php echo $tracking['status'] === 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
                                    <option value="Dikemas" <?php echo $tracking['status'] === 'Dikemas' ? 'selected' : ''; ?>>Dikemas</option>
                                    <option value="Dikirim" <?php echo $tracking['status'] === 'Dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                                    <option value="Diterima" <?php echo $tracking['status'] === 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

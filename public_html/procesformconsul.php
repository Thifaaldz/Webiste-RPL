<?php
include 'db.php';


// Ambil data dari formulir
$name = $_POST['name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$location = $_POST['location'];
$size = $_POST['size'];
$crops = $_POST['crops'];
$consultation = $_POST['consultation'];
$time = $_POST['time'];
$notes = $_POST['notes'];

// SQL untuk menyimpan data
$sql = "INSERT INTO submissions (name, contact, email, location, size, crops, consultation, time, notes) 
        VALUES ('$name', '$contact', '$email', '$location', $size, '$crops', '$consultation', '$time', '$notes')";

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    // Tampilkan halaman sukses
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pengisian Berhasil</title>
        <link rel="stylesheet" href="assets/css/formconsulberhasil.css">
    </head>
    <body>
        <div class="container">
            <h1>Pengisian Berhasil!</h1>
            <p>Terima kasih, ' . htmlspecialchars($name) . ', telah mengisi formulir. Kami akan segera menghubungi Anda.</p>
            <p>Jika Anda membutuhkan bantuan segera, hubungi kami melalui WhatsApp dengan mengklik tombol di bawah:</p>
            <a href="https://wa.me/6282124397545" class="button" target="_blank">Hubungi Kami via WhatsApp</a>
            <a href="index.php" class="button" target="_blank">Kembali Ke Beranda</a>
        </div>
    </body>
    </html>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>

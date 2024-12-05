<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Consultancy Form</title>
    <!-- Menghubungkan file CSS -->
    <link rel="stylesheet" href="assets/css/formconsul.css">
</head>
<body>

<div class="form-container">
    <h1>Expert Farm Consultancy</h1>
    <form action="procesformconsul.php" method="post">
        <!-- Informasi Pribadi -->
        <div class="form-group">
            <label for="name">Nama Lengkap:</label>
            <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required>
        </div>

        <div class="form-group">
            <label for="contact">Nomor Kontak:</label>
            <input type="text" id="contact" name="contact" placeholder="Masukkan nomor telepon/WhatsApp" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
        </div>

        <!-- Informasi Pertanian -->
        <div class="form-group">
            <label for="location">Alamat Pertanian:</label>
            <input type="text" id="location" name="location" placeholder="Masukkan alamat lokasi lahan Anda" required>
        </div>

        <div class="form-group">
            <label for="size">Luas Lahan (hektar):</label>
            <input type="number" id="size" name="size" placeholder="Contoh: 2.5" step="0.1" required>
        </div>

        <div class="form-group">
            <label for="crops">Jenis Tanaman yang Dibudidayakan:</label>
            <textarea id="crops" name="crops" rows="3" placeholder="Contoh: Padi, Jagung, Gandum"></textarea>
        </div>

        <!-- Jenis Konsultasi -->
        <div class="form-group">
            <label for="consultation">Jenis Konsultasi yang Dibutuhkan:</label>
            <select id="consultation" name="consultation" required>
                <option value="yield">Optimalisasi Hasil Panen</option>
                <option value="soil">Kesehatan Tanah</option>
                <option value="pest">Pengelolaan Hama dan Penyakit</option>
                <option value="irrigation">Manajemen Air dan Irigasi</option>
                <option value="other">Lainnya</option>
            </select>
        </div>

        <!-- Waktu Konsultasi -->
        <div class="form-group">
            <label for="time">Waktu yang Diinginkan:</label>
            <input type="datetime-local" id="time" name="time" required>
        </div>

        <!-- Catatan Tambahan -->
        <div class="form-group">
            <label for="notes">Catatan Tambahan:</label>
            <textarea id="notes" name="notes" rows="4" placeholder="Tambahkan informasi penting lainnya (opsional)"></textarea>
        </div>

        <!-- Submit -->
        <div class="form-group">
            <button type="submit">Kirim Permintaan Konsultasi</button>
        </div>
    </form>
</div>

</body>
</html>

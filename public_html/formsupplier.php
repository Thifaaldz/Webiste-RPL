<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Distribusi</title>
    <link rel="stylesheet" href="assets/css/form.css">
</head>
<body>

<div class="container">
    <h2>Formulir Distribusi</h2>
    <form action="database_form.php" method="POST">
        <label for="nama">Nama Perusahaan:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="email">Alamat Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="telepon">Nomor Telepon:</label>
        <input type="text" id="telepon" name="telepon" required>

        <label for="produk">Jenis Produk:</label>
        <select class="produk" id="produk" name="produk">
            <option value="buah">Buah</option>
            <option value="sayuran">Sayuran</option>
            <option value="bibit">Bibit</option>
            <option value="pupuk">Pupuk</option>
        </select>

        <label for="jumlah">Jumlah Produk (kg/ton):</label>
        <input type="number" id="jumlah" name="jumlah" required min="0">

        <label for="alamat">Alamat Pengiriman:</label>
        <textarea id="alamat" name="alamat" rows="3" required></textarea>

        <label for="metode">Metode Pengiriman:</label>
        <select class="metode" id="metode" name="metode">
            <option value="Pengiriman Darat">Pengiriman Darat</option>
        </select>

        <label for="Kendaraan pengiriman">Pilih Kendaraaan pengiriman:</label>
        <select class="kendaraan" id="Kendaraan" name="Kendaraan">
            <option value="Wing Box">Wing Box</option>
            <option value="Truck">Truck</option>
            <option value="Pick Up">Pick Up</option>
        </select>

        <label for="tanggal">Tanggal Pengiriman:</label>
        <input class="date" type="date" id="tanggal" name="tanggal" required>

        <label for="catatan">Catatan Tambahan:</label>
        <textarea id="catatan" name="catatan" rows="4"></textarea>

        <button type="submit">Kirim</button>
    </form>
</div>

</body>
</html>

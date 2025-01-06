<?php
// Konfigurasi database
$host = 'localhost';       // Server database
$dbname = 'perkebunan'; // Nama database
$username = 'root';        // Username database
$password = 'Noisyboy18';            // Password database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

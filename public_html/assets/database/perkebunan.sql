-- Membuat database
CREATE DATABASE IF NOT EXISTS perkebunan;
USE perkebunan;
drop database perkebunan;
-- Tabel pengguna
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel pengajuan konsultasi
CREATE TABLE submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    location TEXT NOT NULL,
    size FLOAT NOT NULL,
    crops TEXT,
    consultation VARCHAR(50) NOT NULL,
    time DATETIME NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
select * from submissions;
-- Tabel bahan baku
CREATE TABLE bahan_baku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    gambar VARCHAR(255) NOT NULL
);

-- Tabel pesanan
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    company_name VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    shipping_address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    additional_message TEXT,
    item_name VARCHAR(255) NOT NULL,
    item_price DECIMAL(10,2) NOT NULL,
    item_quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    bahan_id INT NOT NULL,
    payment_proof VARCHAR(255),
    payment_status ENUM('Pending', 'Paid') DEFAULT 'Pending',
    shipping_provider VARCHAR(100),
    tracking_number VARCHAR(100),
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id)
);
CREATE TABLE shipping_tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_number VARCHAR(100) NOT NULL UNIQUE,
    status VARCHAR(100) NOT NULL DEFAULT 'Diproses',
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Data awal bahan baku
INSERT INTO bahan_baku (nama, harga, gambar)
VALUES
    ('Kopi Robusta', 50000, 'assets/imgs/produk/kopi_robusta.png'),
    ('Kopi Arabika', 60000, 'assets/imgs/produk/kopi_arabika.png'),
    ('Teh Hitam', 30000, 'assets/imgs/produk/teh_hitam.png'),
    ('Teh Hijau', 35000, 'assets/imgs/produk/teh_hijau.png'),
    ('Kelapa Sawit', 10000, 'assets/imgs/produk/kelapa_sawit.png'),
    ('Karet Lateks', 25000, 'assets/imgs/produk/karet_lateks.png'),
    ('Kakao Fermentasi', 70000, 'assets/imgs/produk/kakao_fermentasi.png'),
    ('Kakao Non-Fermentasi', 65000, 'assets/imgs/produk/kakao_non_fermentasi.png'),
    ('Cengkeh', 80000, 'assets/imgs/produk/cengkeh.png'),
    ('Pala', 75000, 'assets/imgs/produk/pala.png'),
    ('Kayu Manis', 55000, 'assets/imgs/produk/kayu_manis.png'),
    ('Lada Hitam', 90000, 'assets/imgs/produk/lada_hitam.png'),
    ('Lada Putih', 95000, 'assets/imgs/produk/lada_putih.png'),
    ('Sagu Basah', 12000, 'assets/imgs/produk/sagu_basah.png'),
    ('Sagu Kering', 15000, 'assets/imgs/produk/sagu_kering.png'),
    ('Tebu', 8000, 'assets/imgs/produk/tebu.png'),
    ('Kelapa Tua', 6000, 'assets/imgs/produk/kelapa_tua.png'),
    ('Kopra', 12000, 'assets/imgs/produk/kopra.png'),
    ('Santan Kelapa', 20000, 'assets/imgs/produk/santan_kelapa.png'),
    ('Minyak Kelapa', 25000, 'assets/imgs/produk/minyak_kelapa.png'),
    ('Temulawak', 30000, 'assets/imgs/produk/temulawak.png'),
    ('Jahe Merah', 35000, 'assets/imgs/produk/jahe_merah.png'),
    ('Jahe Gajah', 28000, 'assets/imgs/produk/jahe_gajah.png'),
    ('Lengkuas', 15000, 'assets/imgs/produk/lengkuas.png'),
    ('Kunyit', 14000, 'assets/imgs/produk/kunyit.png'),
    ('Serai', 10000, 'assets/imgs/produk/serai.png'),
    ('Tembakau Virginia', 45000, 'assets/imgs/produk/tembakau_virginia.png'),
    ('Tembakau Burley', 40000, 'assets/imgs/produk/tembakau_burley.png'),
    ('Buah Kakao Kering', 60000, 'assets/imgs/produk/buah_kakao_kering.png'),
    ('Daun Teh Kering', 25000, 'assets/imgs/produk/daun_teh_kering.png');
select * from orders;
CREATE TABLE bahan_bakubibit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    gambar VARCHAR(255) NOT NULL
);
CREATE TABLE orders_bibit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    company_name VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    shipping_address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    additional_message TEXT,
    item_name VARCHAR(255) NOT NULL,
    item_price DECIMAL(10,2) NOT NULL,
    item_quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    bahan_id INT NOT NULL,
    payment_proof VARCHAR(255),
    payment_status ENUM('Pending', 'Paid') DEFAULT 'Pending',
    shipping_provider VARCHAR(100),
    tracking_number VARCHAR(100),
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id)
);

INSERT INTO bahan_bakubibit (nama, harga, gambar)
VALUES
    ('Bibit Kopi Robusta', 50000, 'assets/imgs/produk/bibit_kopi_robusta.png'),
    ('Bibit Kopi Arabika', 60000, 'assets/imgs/produk/bibit_kopi_arabika.png'),
    ('Bibit Teh Hitam', 30000, 'assets/imgs/produk/bibit_teh_hitam.png'),
    ('Bibit Teh Hijau', 35000, 'assets/imgs/produk/bibit_teh_hijau.png'),
    ('Bibit Kelapa Sawit', 10000, 'assets/imgs/produk/bibit_kelapa_sawit.png'),
    ('Bibit Karet Lateks', 25000, 'assets/imgs/produk/bibit_karet_lateks.png'),
    ('Bibit Kakao Fermentasi', 70000, 'assets/imgs/produk/bibit_kakao_fermentasi.png'),
    ('Bibit Kakao Non-Fermentasi', 65000, 'assets/imgs/produk/bibit_kakao_non_fermentasi.png'),
    ('Bibit Cengkeh', 80000, 'assets/imgs/produk/bibit_cengkeh.png'),
    ('Bibit Pala', 75000, 'assets/imgs/produk/bibit_pala.png'),
    ('Bibit Kayu Manis', 55000, 'assets/imgs/produk/bibit_kayu_manis.png'),
    ('Bibit Lada Hitam', 90000, 'assets/imgs/produk/bibit_lada_hitam.png'),
    ('Bibit Lada Putih', 95000, 'assets/imgs/produk/bibit_lada_putih.png'),
    ('Bibit Sagu Basah', 12000, 'assets/imgs/produk/bibit_sagu_basah.png'),
    ('Bibit Sagu Kering', 15000, 'assets/imgs/produk/bibit_sagu_kering.png'),
    ('Bibit Tebu', 8000, 'assets/imgs/produk/bibit_tebu.png'),
    ('Bibit Kelapa Tua', 6000, 'assets/imgs/produk/bibit_kelapa_tua.png'),
    ('Bibit Kopra', 12000, 'assets/imgs/produk/bibit_kopra.png'),
    ('Bibit Santan Kelapa', 20000, 'assets/imgs/produk/bibit_santan_kelapa.png'),
    ('Bibit Minyak Kelapa', 25000, 'assets/imgs/produk/bibit_minyak_kelapa.png'),
    ('Bibit Temulawak', 30000, 'assets/imgs/produk/bibit_temulawak.png'),
    ('Bibit Jahe Merah', 35000, 'assets/imgs/produk/bibit_jahe_merah.png'),
    ('Bibit Jahe Gajah', 28000, 'assets/imgs/produk/bibit_jahe_gajah.png'),
    ('Bibit Lengkuas', 15000, 'assets/imgs/produk/bibit_lengkuas.png'),
    ('Bibit Kunyit', 14000, 'assets/imgs/produk/bibit_kunyit.png'),
    ('Bibit Serai', 10000, 'assets/imgs/produk/bibit_serai.png'),
    ('Bibit Tembakau Virginia', 45000, 'assets/imgs/produk/bibit_temabakau_virginia.png'),
    ('Bibit Tembakau Burley', 40000, 'assets/imgs/produk/bibit_temabakau_burley.png'),
    ('Bibit Buah Kakao Kering', 60000, 'assets/imgs/produk/bibit_buah_kakao_kering.png'),
    ('Bibit Daun Teh Kering', 25000, 'assets/imgs/produk/bibit_daun_teh_kering.png');

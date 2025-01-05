CREATE DATABASE perkebunan;
drop database perkebunan;
USE perkebunan;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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
select *from users;


-- Tabel bahan_baku
CREATE TABLE bahan_baku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    gambar VARCHAR(255) NOT NULL
);  

-- Tabel orders
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
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id)
);

-- Data awal bahan_baku
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


CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    total_bayar DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_status VARCHAR(20) DEFAULT 'pending',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



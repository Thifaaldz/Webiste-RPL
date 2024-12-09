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
select * from submissions;

select * from users;

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_perusahaan VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telepon VARCHAR(20) NOT NULL,
    produk VARCHAR(50) NOT NULL,
    jumlah DECIMAL(10, 2) NOT NULL,
    alamat_pengiriman TEXT NOT NULL,
    metode_pengiriman VARCHAR(50) NOT NULL,
    kendaraan VARCHAR(50) NOT NULL,
    tanggal_pengiriman DATE NOT NULL,
    catatan TEXT,
    virtual_account VARCHAR(20) UNIQUE,
    bukti_pembayaran VARCHAR(255), -- Path untuk bukti pembayaran
    nomor_resi VARCHAR(50) unique, -- Nomor resi
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

select * from supplier;
CREATE TABLE tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_resi VARCHAR(50) NOT NULL unique,
    status VARCHAR(255) NOT NULL,
    lokasi VARCHAR(255) NOT NULL,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nomor_resi) REFERENCES supplier(nomor_resi)
);

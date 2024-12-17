<?php
// Syntaks yang digunakan untuk menghubungkan front end kedalam database
$servername = "localhost";
$username = "root"; // ganti dengan username database Anda
$password = ""; // ganti dengan password database Anda
$dbname = "aplikasi_umkm"; // ganti dengan nama database Anda

// Coba koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
echo "Koneksi berhasil ke database $dbname dengan username $username";
$conn->close();
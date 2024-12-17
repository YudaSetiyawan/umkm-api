<?php
// Menambahkan header untuk mengizinkan CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "aplikasi_umkm"; // Nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data produk dari tabel products
$sql = "SELECT id, name, price FROM products"; // Sesuaikan dengan nama tabel dan kolom Anda
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo json_encode([]);
}

// Mengirimkan data produk sebagai JSON
header('Content-Type: application/json');
echo json_encode($products);

// Menutup koneksi
$conn->close();
?>

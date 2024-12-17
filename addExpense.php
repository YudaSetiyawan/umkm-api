<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Menambahkan header untuk mengizinkan CORS, karena file front end tidak berada di satu lokasi dengan API nya
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$dbname = "aplikasi_umkm"; // Sesuaikan dengan nama database Anda

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Membaca data dari body permintaan
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data yang dikirim
if ( !isset($data['nama_kategori']) || !isset($data['nama']) || !isset($data['jumlah'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
    exit;
}


$nama_kategori = $data['nama_kategori'];
$nama = $data['nama'];
$jumlah = $data['jumlah'];
$created_at = $data['created_at']; // Timestamp saat data ditambahkan

// Query untuk menyimpan data pengeluaran
$stmt = $conn->prepare("INSERT INTO data_expenses ( nama_kategori, nama, jumlah, created_at) VALUES ( ?, ?, ?, ?)");
$stmt->bind_param("ssis", $nama_kategori, $nama, $jumlah, $created_at);

// Eksekusi query dan cek kesalahan
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Data Pengeluaran berhasil ditambahkan"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add expense", "error" => $stmt->error]);
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
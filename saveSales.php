<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikasi_umkm";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menerima data dari frontend (POST request)
$data = json_decode(file_get_contents("php://input"), true);

// Debug: Simpan data yang diterima ke file log
file_put_contents("debug_log.txt", date("Y-m-d H:i:s") . " - Received data: " . json_encode($data) . PHP_EOL, FILE_APPEND);

// Validasi data yang diterima
if (
    isset($data['outlet_id']) && 
    isset($data['outlet_name']) && // Tambahkan outlet_name
    isset($data['product_id']) && 
    isset($data['product_name']) && // Tambahkan product_name
    isset($data['price']) && 
    isset($data['quantity']) && 
    isset($data['total_price'])
) {
    $outlet_id = $data['outlet_id'];
    $outlet_name = $data['outlet_name']; // Ambil outlet_name
    $product_id = $data['product_id'];
    $product_name = $data['product_name']; // Ambil product_name
    $price = $data['price'];
    $quantity = $data['quantity'];
    $total_price = $data['total_price'];

    // Menyiapkan query dengan prepared statement
    $stmt = $conn->prepare("INSERT INTO sales (outlet_id, outlet_name, product_id, product_name, price, quantity, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isisiii", $outlet_id, $outlet_name, $product_id, $product_name, $price, $quantity, $total_price);


    // Mengeksekusi query
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Penjualan berhasil ditambahkan."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Terjadi kesalahan dalam menambahkan penjualan."]);
    }

    // Menutup koneksi dan statement
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap."]);
}

$conn->close();
?>

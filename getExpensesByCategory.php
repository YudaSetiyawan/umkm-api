<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Validasi apakah parameter 'category_id' ada
if (!isset($_GET['category_id']) || empty($_GET['category_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Parameter 'category_id' is required."]);
    exit();
}

$categoryId = $_GET['category_id'];

// Informasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikasi_umkm";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Menggunakan prepared statement untuk mencegah SQL Injection
$sql = "SELECT id, nama FROM expenses WHERE kategori_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to prepare statement."]);
    exit();
}

$stmt->bind_param("i", $categoryId);
$stmt->execute();
$result = $stmt->get_result();

// Inisialisasi array kosong
$expenses = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }
}

// Mengembalikan data sebagai JSON
echo json_encode($expenses);

// Menutup koneksi
$stmt->close();
$conn->close();
?>

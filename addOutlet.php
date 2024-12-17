<?php
// Tampilkan pesan error untuk debugging
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

$response = [];

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Cek koneksi
    if ($conn->connect_error) {
        throw new Exception("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari request body
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validasi data sebelum digunakan
    if (empty($data['outlet_name']) || empty($data['outlet_location'])) {
        $response = ["success" => false, "message" => "Nama dan lokasi outlet harus diisi"];
        echo json_encode($response);
        exit;
    }
    
    $outlet_name = $data['outlet_name'];
    $outlet_location = $data['outlet_location'];

    // Query untuk menambahkan data outlet
    $query = "INSERT INTO outlets (name, location) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        throw new Exception("Gagal mempersiapkan statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $outlet_name, $outlet_location);
    
    if ($stmt->execute()) {
        $response = ["success" => true, "message" => "Outlet berhasil ditambahkan"];
    } else {
        $response = ["success" => false, "message" => "Gagal menambahkan outlet: " . $stmt->error];
    }

    // Tutup statement
    $stmt->close();
} catch (Exception $e) {
    $response = ["success" => false, "message" => $e->getMessage()];
} finally {
    // Tutup koneksi
    $conn->close();
}

// Kembalikan respon dalam format JSON
echo json_encode($response);
?>

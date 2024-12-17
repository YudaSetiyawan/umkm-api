<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikasi_umkm";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT id, nama_kategori, nama, created_at, jumlah FROM data_expenses";
$result = $conn->query($sql);

$data = [];
$total = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
        $total += (int)$row['jumlah']; // Menjumlahkan semua nilai jumlah
    }
}

$response = [
    "expenses" => $data,
    "total" => $total
];

echo json_encode($response);
$conn->close();
?>

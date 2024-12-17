<?php
// Menambahkan header untuk mengizinkan CORS, karena file front end tidak berada di satu lokasi dengan API nya
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

// Ambil data outlet dari tabel outlets
$sql = "SELECT name, location FROM outlets";
$result = $conn->query($sql);

$outlets = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $outlets[] = $row;
    }
  } else {
    echo json_encode([]);
  }

// Mengirimkan data sebagai JSON
header('Content-Type: application/json');
echo json_encode($outlets);


// Menutup koneksi
$conn->close();
?>

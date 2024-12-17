<?php
// Menambahkan header untuk mengizinkan CORS
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=Data Pengeluaran.csv");
header("Pragma: no-cache");
header("Expires: 0");

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$dbname = "aplikasi_umkm"; // Sesuaikan dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Query untuk mengambil data pengeluaran
$sql = "SELECT nama_kategori, nama, jumlah, created_at FROM data_expenses";
$result = $conn->query($sql);

// Membuat file CSV
$output = fopen('php://output', 'w');
fputcsv($output, ['Nama Kategori', 'Nama Pengeluaran', 'Jumlah', 'Tanggal']); 

// Header CSV
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [$row['nama_kategori'], $row['nama'], $row['jumlah'], $row['created_at']]);
    }
} else {
    echo "Tidak ada data pengeluaran";
}

fclose($output);
$conn->close();
?>

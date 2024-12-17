<?php

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=Data Penjualan.csv");
header("Pragma: no-cache");
header("Expires: 0");

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikasi_umkm";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);


// Query untuk mengambil data penjualan dari tabel sales
$sql = "SELECT outlet_name,product_name, price, quantity, total_price, payment_method, created_at from sales";
$result = $conn->query($sql);

// Membuat file CSV
$output = fopen('php://output', 'w');
fputcsv($output, [ 'outlet name','product name', 'price', 'quantity', 'total price', 'payment method', 'created at']); // Header CSV

// Header CSV
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [$row['outlet_name'], $row['product_name'], $row['price'], $row['quantity'],$row['total_price'],$row['payment_method'],$row['created_at']]);
    }
} else {
    echo "Tidak ada data pengeluaran";
}

fclose($output);
$conn->close();
?>

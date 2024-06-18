<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QL_Guixe";

// Tạo kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$biensoxe = $_POST['biensoxe'];
$khoa = $_POST['khoa'];
$lop = $_POST['lop'];

// Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng Thongtin
$sql = "INSERT INTO Thongtin (Biensoxe, Khoa, Lop) VALUES ('$biensoxe', '$khoa', '$lop')";

if ($conn->query($sql) === TRUE) {
    header("Location: inthongtin.php");
    exit();
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}

// Đóng kết nối
$conn->close();

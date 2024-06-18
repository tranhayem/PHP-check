<?php
$servername = "localhost"; // Đổi thành tên server của bạn
$username = "root"; // Đổi thành username của bạn
$password = ""; // Đổi thành password của bạn
$dbname = "QL_Docgia"; // Đổi thành tên database của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$TenKH = $_POST['TenKH'];
$DiaChi = $_POST['DiaChi'];
$Sosachmuon = $_POST['Sosachmuon'];

// Chuẩn bị câu lệnh SQL
$sql = "INSERT INTO Thongtin (TenKH, DiaChi, Sosachmuon) VALUES ('$TenKH', '$DiaChi', $Sosachmuon)";

if ($conn->query($sql) === TRUE) {
    header("Location: inthongtin.php");
    exit();
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}

// Đóng kết nối
$conn->close();

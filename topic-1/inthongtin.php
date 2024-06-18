<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QL_Docgia";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Thiết lập số bản ghi trên mỗi trang
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Chuẩn bị câu lệnh SQL để lấy tổng số bản ghi
$total_records_sql = "SELECT COUNT(*) FROM Thongtin WHERE Sosachmuon >= 3";
$total_records_result = $conn->query($total_records_sql);
$total_records_row = $total_records_result->fetch_row();
$total_records = $total_records_row[0];
$total_pages = ceil($total_records / $records_per_page);

// Chuẩn bị câu lệnh SQL để lấy bản ghi cho trang hiện tại
$sql = "SELECT * FROM Thongtin WHERE Sosachmuon >= 3 LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="../table.css">
    <title>Quản lý mượn sách</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5">Bảng khách hàng mượn từ 3 quyển sách trở lên</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Mã KH</th>
                    <th>Tên KH</th>
                    <th>Địa chỉ</th>
                    <th>Số sách mượn</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='text-center align-middle'>" . $row["MaKH"] . "</td>
                                <td>" . $row["TenKH"] . "</td>
                                <td>" . $row["DiaChi"] . "</td>
                                <td class='text-center align-middle'>" . $row["Sosachmuon"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Không có khách hàng nào mượn 3 quyển sách trở lên.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Phân trang -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? "active" : "";
                    echo "<li class='page-item $active'><a class='page-link' href='inthongtin.php?page=$i'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
// Đóng kết nối
$conn->close();
?>
<?php
$servername = "localhost"; // Thay đổi thành tên server của bạn
$username = "root"; // Thay đổi thành username của bạn
$password = ""; // Thay đổi thành password của bạn
$dbname = "QL_Guixe"; // Thay đổi thành tên database của bạn

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
$sql_total = "SELECT COUNT(*) AS total FROM Thongtin WHERE Khoa = 'Công nghệ thông tin'";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $records_per_page);

// Chuẩn bị câu lệnh SQL để lấy bản ghi cho trang hiện tại
$sql = "SELECT * FROM Thongtin WHERE Khoa = 'Công nghệ thông tin' LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="../table.css">
    <title>Quản lý gửi xe</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5">Bảng sinh viên tham gia gửi xe khoa Công nghệ thông tin</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã sinh viên</th>
                    <th>Biển số xe</th>
                    <th>Khoa</th>
                    <th>Lớp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = ($page - 1) * $records_per_page + 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='text-center align-middle'>" . $stt++ . "</td>
                                <td class='text-center align-middle'>" . $row["MaSV"] . "</td>
                                <td class='text-center align-middle'>" . $row["Biensoxe"] . "</td>
                                <td class='text-center align-middle'>" . $row["Khoa"] . "</td>
                                <td class='text-center align-middle'>" . $row["Lop"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Không có sinh viên nào từ khoa Công nghệ thông tin tham gia gửi xe.</td></tr>";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>
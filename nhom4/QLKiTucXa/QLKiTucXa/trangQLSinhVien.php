<?php
include 'conn.php';

// Số lượng sinh viên trên mỗi trang
$limit = 6;

// Trang hiện tại
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Tính toán offset
$offset = ($page - 1) * $limit;

// Truy vấn dữ liệu sinh viên với LIMIT và OFFSET
$sql = "SELECT * FROM SinhVien LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Truy vấn tổng số sinh viên
$total_sql = "SELECT COUNT(*) FROM SinhVien";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->execute();
$total_rows = $total_stmt->fetchColumn();

// Tính toán tổng số trang
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sinh Viên</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 200px;
            background: #f8f9fa;
            padding: 15px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }
        .main-content {
            margin-left: 220px;
            padding: 15px;
            width: calc(100% - 220px);
        }
        .menu-header {
            font-weight: bold;
            margin-top: 20px;
        }
        .sidebar a {
            display: block;
            padding: 5px 0;
            color: #007bff;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="sidebar">
<?php
session_start(); // Bắt đầu session

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(isset($_SESSION['HoTen'])) {
    $tenNguoiDangNhap = $_SESSION['HoTen'];
    echo "Xin chào $tenNguoiDangNhap!"; // Hiển thị tên người đăng nhập
} else {
    echo "Chưa đăng nhập";
}
?>
    <div class="menu-header">Quản lý phòng KTX</div>
    <a href="trangQLKiTucXa.php">Quản lý KTX</a>
    <div class="menu-header">Quản lý danh mục</div>
    <a href="trangQLKhuVuc.php" data-content="content-khu-vuc">Quản lý khu vực</a>
    <a href="trangQLPhong.php">Quản lý phòng</a>
    <a href="trangQLLoaiPhong.php">Quản lý loại phòng</a>
    <a href="trangQLHopDong.php">Quản lý hợp đồng</a>
    <a href="trangQLHoaDon.php">Quản lý hóa đơn</a>
    <div class="menu-header">Quản lý sinh viên</div>
    <a href="trangQLSinhVien.php">Quản lý sinh viên</a>
    <div class="menu-header">Quản lý nhân viên</div>
    <a href="trangQLQuanLy.php">Quản lý nhân viên</a>
</div>
<div class="main-content">
    <center><h3 class="mt-2">Quản Lý Sinh Viên</h3></center>
    <button type="button" class="btn btn-success m-2 float-end" data-toggle="modal" data-target="#addModal">
        Thêm mới
    </button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Quê quán</th>
                <th>Điện thoại</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($result) > 0) {
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>{$row['SinhVienID']}</td>";
                    echo "<td>{$row['HoTen']}</td>";
                    echo "<td>{$row['GioiTinh']}</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row['NgaySinh'])) . "</td>";
                    echo "<td>{$row['QueQuan']}</td>";
                    echo "<td>{$row['DienThoai']}</td>";
                    echo "<td>";
                    echo "<button type='button' class='btn btn-light mr-1' data-toggle='modal' data-target='#editModal' onclick='editClick(" . json_encode($row) . ")'>";
                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>";
                    echo "<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>";
                    echo "<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>";
                    echo "</svg>";
                    echo "</button>";

                    echo "<button type='button' class='btn btn-light mr-1' onclick='deleteSinhVien({$row['SinhVienID']})'>";
                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>";
                    echo "<path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>";
                    echo "</svg>";
                    echo "</button>";

                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <a href="trangQLKiTucXa.php" class="btn btn-primary">Trang chủ</a>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm sinh viên</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addFormSinhVien" action="themSinhVien.php" method="post">
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Họ tên</span>
                            <input type="text" class="form-control" id="addHoTen" name="HoTen" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Giới tính</span>
                            <div class="form-check form-check-inline col-2 ms-4 mt-2">
                                <input type="radio" class="form-check-input" id="addMaleGender" name="GioiTinh" value="Nam" />
                                <label class="form-check-label" for="addMaleGender">Nam</label>
                            </div>
                            <div class="form-check form-check-inline col-2 mt-2">
                                <input type="radio" class="form-check-input" id="addFemaleGender" name="GioiTinh" value="Nữ" />
                                <label class="form-check-label" for="addFemaleGender">Nữ</label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Ngày sinh</span>
                            <input type="date" class="form-control" id="addNgaySinh" name="NgaySinh" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Quê quán</span>
                            <input type="text" class="form-control" id="addQueQuan" name="QueQuan" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Điện thoại</span>
                            <input type="text" class="form-control" id="addDienThoai" name="DienThoai" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" />
                            <div id="phoneError" class="invalid-feedback" style="display: none;">Số điện thoại phải có 10 chữ số.</div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa sinh viên</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editFormSinhVien" action="suaSinhVien.php" method="post">
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">ID</span>
                            <input type="text" class="form-control" id="editSinhVienID" name="SinhVienID" readonly />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Họ tên</span>
                            <input type="text" class="form-control" id="editHoTen" name="HoTen" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Giới tính</span>
                            <div class="form-check form-check-inline col-2 ms-4 mt-2">
                                <input type="radio" class="form-check-input" id="editMaleGender" name="GioiTinh" value="Nam" />
                                <label class="form-check-label" for="editMaleGender">Nam</label>
                            </div>
                            <div class="form-check form-check-inline col-2 mt-2">
                                <input type="radio" class="form-check-input" id="editFemaleGender" name="GioiTinh" value="Nữ" />
                                <label class="form-check-label" for="editFemaleGender">Nữ</label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Ngày sinh</span>
                            <input type="date" class="form-control" id="editNgaySinh" name="NgaySinh" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Quê quán</span>
                            <input type="text" class="form-control" id="editQueQuan" name="QueQuan" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">Điện thoại</span>
                            <input type="text" class="form-control" id="editDienThoai" name="DienThoai" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" />
                            <div id="phoneError" class="invalid-feedback" style="display: none;">Số điện thoại phải có 10 chữ số.</div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function editClick(sinhVien) {
    document.getElementById('editSinhVienID').value = sinhVien.SinhVienID;
    document.getElementById('editHoTen').value = sinhVien.HoTen;
    if (sinhVien.GioiTinh === 'Nam') {
        document.getElementById('editMaleGender').checked = true;
    } else {
        document.getElementById('editFemaleGender').checked = true;
    }
    document.getElementById('editNgaySinh').value = sinhVien.NgaySinh;
    document.getElementById('editQueQuan').value = sinhVien.QueQuan;
    document.getElementById('editDienThoai').value = sinhVien.DienThoai;
}

function deleteSinhVien(id) {
    if (confirm("Bạn có chắc chắn muốn xóa sinh viên này?")) {
        window.location.href = "xoaSinhVien.php?id=" + id;
    }
}
function validateForm() {
    var phoneInput = document.getElementById("addDienThoai");
    var phoneError = document.getElementById("phoneError");

    if (phoneInput.value.length !== 10) {
        phoneInput.classList.add("is-invalid");
        phoneError.style.display = "block";
        return false;
    } else {
        phoneInput.classList.remove("is-invalid");
        phoneError.style.display = "none";
        return true;
    }
}
</script>
</body>
</html>

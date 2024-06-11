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
    <center><h3 class="mt-2">Quản Lý Nhân Viên</h3></center>
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
                <th>Điện thoại</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'conn.php';
            $sql = "SELECT * FROM QuanLy";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>{$row['QuanLyID']}</td>";
                    echo "<td>{$row['HoTen']}</td>";
                    echo "<td>{$row['GioiTinh']}</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row['NgaySinh'])) . "</td>";
                    echo "<td>{$row['DienThoai']}</td>";
                    echo "<td>";
                    echo "<button type='button' class='btn btn-light mr-1' data-toggle='modal' data-target='#editModal' onclick='editClick(" . json_encode($row) . ")'>";
                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>";
                    echo "<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>";
                    echo "<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>";
                    echo "</svg>";
                    echo "</button>";

                    echo "<button type='button' class='btn btn-light mr-1' onclick='deleteQuanLy({$row['QuanLyID']})'>";
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
    <a href="trangQLKiTucXa.php" class="btn btn-primary">Trang chủ</a>
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm nhân viên</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addFormQuanLy" action="themQuanLy.php" method="post">
                        
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
                    <h5 class="modal-title">Sửa nhân viên</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editFormQuanLy" action="suaQuanLy.php" method="post">
                        <div class="input-group mb-3">
                            <span class="input-group-text col-2">ID</span>
                            <input type="text" class="form-control" id="editQuanLyID" name="QuanLyID" readonly />
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
                        <span class="input-group-text col-2">Điện thoại</span>
                        <input type="text" class="form-control" id="addDienThoai" name="DienThoai" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" />
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
function editClick(quanLy) {
    document.getElementById('editQuanLyID').value = quanLy.QuanLyID;
    document.getElementById('editHoTen').value = quanLy.HoTen;
    if (quanLy.GioiTinh === 'Nam') {
        document.getElementById('editMaleGender').checked = true;
    } else {
        document.getElementById('editFemaleGender').checked = true;
    }
    document.getElementById('editNgaySinh').value = quanLy.NgaySinh;
    document.getElementById('editDienThoai').value = quanLy.DienThoai;
}

function deleteQuanLy(id) {
    if (confirm("Bạn có chắc chắn muốn xóa sinh viên này?")) {
        window.location.href = "xoaQuanLy.php?id=" + id;
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

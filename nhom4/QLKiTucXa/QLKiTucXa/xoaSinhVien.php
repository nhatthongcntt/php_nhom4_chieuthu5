<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $SinhVienID = $_GET['id'];

    $sql = "DELETE FROM SinhVien WHERE SinhVienID = :SinhVienID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SinhVienID', $SinhVienID);

    if ($stmt->execute()) {
        header("Location: trangQLSinhVien.php?message=Xóa sinh viên thành công");
    } else {
        echo "Lỗi khi xóa sinh viên.";
    }
} else {
    echo "Không có ID sinh viên để xóa.";
}
?>

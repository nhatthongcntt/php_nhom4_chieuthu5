<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $QuanLyID = $_GET['id'];

    $sql = "DELETE FROM QuanLy WHERE QuanLyID = :QuanLyID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':QuanLyID', $QuanLyID);

    if ($stmt->execute()) {
        header("Location: trangQLQuanLy.php?message=Xóa nhân viên thành công");
    } else {
        echo "Lỗi khi xóa nhân viên.";
    }
} else {
    echo "Không có ID nhân viên để xóa.";
}
?>

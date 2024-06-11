<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $LoaiPhongID = $_GET['id'];

    $sql = "DELETE FROM LoaiPhong WHERE LoaiPhongID = :LoaiPhongID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':LoaiPhongID', $LoaiPhongID);

    try {
        $stmt->execute();
        header("Location: trangQLLoaiPhong.php?message=Xóa phòng thành công");
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') { // 23000 is the SQLSTATE code for integrity constraint violation
            echo "<script>alert('Lỗi khóa ngoại.'); window.location.href='trangQLLoaiPhong.php';</script>";
        } else {
            echo "Lỗi khi xóa phòng: " . $e->getMessage();
        }
    }
} else {
    echo "Không có ID phòng để xóa.";
}
?>
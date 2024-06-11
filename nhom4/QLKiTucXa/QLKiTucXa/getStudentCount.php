<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $phongID = $_GET['id'];
    $sql = "SELECT COUNT(*) as studentCount FROM HopDong WHERE PhongID = :phongID";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['phongID' => $phongID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $result['studentCount'];
}
?>

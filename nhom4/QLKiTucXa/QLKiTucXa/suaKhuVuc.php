<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $KhuVucID = $_POST['KhuVucID'];
    $TenKhuVuc = $_POST['TenKhuVuc'];

    $sql = "UPDATE KhuVuc SET TenKhuVuc = ? WHERE KhuVucID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$TenKhuVuc, $KhuVucID]);

    header('Location: trangQLKhuVuc.php');
    exit();
}
?>

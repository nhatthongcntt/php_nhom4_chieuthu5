<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $KhuVucID = $_GET['id'];

    $sql = "DELETE FROM KhuVuc WHERE KhuVucID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$KhuVucID]);

    header('Location: trangQLKhuVuc.php');
    exit();
}
?>

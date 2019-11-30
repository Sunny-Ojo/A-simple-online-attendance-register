<?php

include "php_files/db_conn.php";

$id = $_GET['id'];
$stmt = $conn->prepare('DELETE FROM present where id=' . $id);
$result = $stmt->execute();
if ($result) {
    header("Location: dashboard.php");
}
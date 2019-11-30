<?php
// echo $_GET['id'];
// echo "<br>";
// echo $_GET["names"];
include "php_files/db_conn.php";

$id = $_GET['id'];
$stmt = $conn->('DELETE FROM present where id='.$id);
$result = $stmt->execute();
if($result){
    header("Location: dashboard.php");
}

?>

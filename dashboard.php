<?php
session_start();
if (isset($_SESSION["name"]) && $_SESSION["name"] == 'true') {

    // header("location: dashboard.php");

} else {
    echo "<script>alert('Access Denied!!! You must be logged in ')</script>";
    header("location: admin.php");

}
include "php_files/db_conn.php";
include "php_files/menu.php";
?>

<div class="col-md-10 offset-md-1">
    <?php

$stmt = $conn->query('SELECT * FROM present');
$result = $stmt->fetchAll();

?>

    <table border="1" class="table table-active table-responsive">
        <tr>
            <th>ID</th>
            <th>Full name</th>
            <th>Factory ID</th>
            <th>Clocked In</th>
        </tr>
        <?php
foreach ($result as $data) {
    echo "<tr>
        <td>" . $data['id'] . "</td>
        <td>" . $data['fullname'] . "</td>
        <td>" . $data['factoryid'] . "</td>
        <td>" . $data['clockedin'] . "</td>
        <td><a href='readmore.php?id=" . $data['id'] . "'>Delete</a></td>
    </tr>";

}
// echo mb_substr()

?>

    </table>


</div>


</div>
<?php include "php_files/footer.php"; ?>
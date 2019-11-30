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
<div class="row container dashboard">
    <h2 class="welcome text-center">Welcome Admin, Here you can view the workers that clocked in for today</h2>
    <div class="col-md-12 offset-1 ">
        <?php

$stmt = $conn->query('SELECT * FROM present');
$result = $stmt->fetchAll();

?>

        <table border="1" class="table table-hover ">
            <tr>
                <th>ID</th>
                <th>Full name</th>
                <th>Factory ID</th>
                <th>Clocked In</th>
                <th>Action</th>
            </tr>
            <?php
foreach ($result as $data) {
    echo "<tr>
        <td>" . $data['id'] . "</td>
        <td>" . $data['fullname'] . "</td>
        <td>" . $data['factoryid'] . "</td>
        <td>" . $data['clockedin'] . "</td>
        <td><a href='delete.php?id=" . $data['id'] . "'>Delete</a></td>
    </tr>";

}

?>

        </table>


    </div>


</div>
</div>
<?php include "php_files/footer.php"; ?>
<?php
session_start();
$user = 'sunny';
$pas = 'hello';
if (isset($_POST["submit"])) {
    $admin = $_POST["admin"];
    $pass = $_POST["password"];
    if ($admin == $user && $pass == $pas) {
        $_SESSION["name"] = 'true';
        header("location: dashboard.php");
    } else {

        echo "<script>alert('Access Denied!!!password is incorrect ');</script>";
        // header("location: admin.php");
    }
}
include "php_files/menu.php";
?>
<div class="col-md-6 offset-md-3 admin">

    <form method="post" action="admin.php">
        <div class="lead text-center">ADMIN LOGIN <span class='glyphicon glyphicon-pencil'></span></div>
        <div class="form-group">
            <label> Full Name:</label>
            <input class="form-control" type="text" name="admin" />
        </div>

        <div class="form-group">
            <label> Password:</label>
            <input class="form-control" type="text" name="password" />
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-block btn-outline-success">
                Login
            </button>
        </div>
</div>
</form>
<?php include "php_files/footer.php"; ?>
<?php
session_start();
$user = 'sunny';
$pas = 'hello';
$admin = '';
$pass = '';
$incorrect = '';
if (isset($_POST["submit"])) {
    $admin = $_POST["admin"];
    $pass = $_POST["password"];
    if ($admin == $user && $pass == $pas) {
        $_SESSION["name"] = 'true';
        header("location: dashboard.php");
    } else {

        $incorrect = "<div class='bg-danger text-white'>Access Denied!!! Password or Username is incorrect</div>";
        // header("location: admin.php");
    }
}
include "php_files/menu.php";
?>
<div class="col-md-4 offset-md-4 main">
    <form action="admin.php" method="post">
        <div class="form-group">
            <h2>Admin Login</h2>
        </div>
        <?php echo $incorrect . '<br>' ?>

        <div class="form-group">
            <input type="text" name="admin" class="form-control" placeholder="Enter Your Username"
                value="<?php echo $admin; ?>" />
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Enter Your Password"
                value="<?php echo $pass; ?>" />
        </div>

        <div class="form-group">
            <input type="submit" value="Login" class="btn btn-warning btn-block" name="submit" />
        </div>

    </form>
</div>
</div>
</div>
<?php include "php_files/footer.php"; ?>
<?php
session_start();
include "php_files/db_Conn.php";
include "php_files/menu.php";

$name = "";
$phone = "";
$email = "";
$pass1 = "";
$pass2 = "";
$errors = [];
$successmsg = "";
if (isset($_POST["submit"])) {

    $name = $_POST["username"];
    $factoryid = $_POST["factoryid"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    if (empty($name)) {
        $errors['name'] = "Username is required";
    }

    if (empty($factoryid)) {
        $errors['factoryid'] = "Factory ID is required";
    }
    if (empty($phone)) {
        $errors['phone'] = "Phone Number is required";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['wrongemail'] = "Email is not valid";
    }

    $emailcheck = $conn->prepare("SELECT * FROM workers WHERE email=?");
    $emailcheck->execute([$email]);
    $check = $emailcheck->fetch();
    if ($check > 0) {
        $errors['emailexist'] = "Email already exists";
    }
    $errorsfound = count($errors);
    if (count($errors) == 0) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $factoryid = filter_var($factoryid, FILTER_SANITIZE_STRING);
        $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $stmt = $conn->prepare("INSERT INTO workers (fullname,factoryid,phoneNumber, email) VALUES(?,?,?,?)");
        $stmt->execute([$name, $factoryid, $phone, $email]);
        if ($stmt) {
            $_SESSION["username"] = $name;
            $successmsg = "You have successfully been registered";
            header("refresh:2; url=index.php");
        } else {
            $errors['error'] = "Sorry, something went wrong during registration, pleasse try again later";
        }
        exit();
    }
}

?>

<div class="container ">
    <div class="row">
        <div class="col-md-4 offset-md-4 main">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="header">
                    <h2 class="text-capitalize text-info text-center">
                        sign up
                    </h2>
                </div>
                <?php if (count($errors) > 0): ?>
                <div class="alert bg-danger text-white ">
                    <?php
if (count($errors) == 1) {
    echo $errorsfound . " Error was encountered:";
} else {
    echo $errorsfound . " Errors were encountered:";
}
?>

                    <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php if (isset($suceessmsg)) {
    echo $suceessmsg;

}
?>



                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Enter Your Fullname"
                        value="<?php echo $name ?>" />
                </div>
                <div class="form-group">
                    <input type="text" name="factoryid" class="form-control" placeholder="Enter Your Factory ID"
                        value="<?php echo $email; ?>" />
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" placeholder="Enter Your Phone Number"
                        value="<?php echo $phone ?>" />
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email"
                        value="<?php echo $email ?>" />
                </div>

                <div class="form-group">
                    <input type="submit" value="REGISTER" class="btn btn-warning btn-block" name="submit" />
                </div>
                <p class="text-capitalize text-center">
                    Already have an account?
                    <a href="index.php" class="btn btn-primary">Go and Clock in</a>
                </p>
            </form>
        </div>
    </div>
</div>
</body>

</html>
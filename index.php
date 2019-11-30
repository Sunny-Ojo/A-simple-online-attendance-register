<?php
session_start();
// including the database connection
include "php_files/db_conn.php";

// setting some variables to empty to avoid unnecessary errors when page loads

$fullname = '';
$factoryid = '';
$errors = [];
$emailerr = [];
$loggedOK = '';
$emailReg = '';
//changing the default time zone to africa's timezone since the default is different

$setTime = date_default_timezone_set('Africa/Lagos');
$day = date('l');
$time = date('h:i');

// checking if the user has clicked the clock in button

if (isset($_POST["submit"])) {
    $fullname = $_POST["fullName"];
    $factoryid = $_POST["idNum"];
    if (empty($fullname)) {
        $errors['name'] = ucwords('fullname is required');
    }
    if (empty($factoryid)) {
        $errors['idnum'] = ucwords('factory id is required');
    }
    $fullname = filter_var($fullname, FILTER_SANITIZE_STRING);
    $factoryid = filter_var($factoryid, FILTER_SANITIZE_STRING);
    if ($time > '7:00' || $time > '8:15') {
        $errors['time'] = ucwords('sorry, you cannot clock in by this time ') . '<br>';
    }
    if ($day == 'Saturda\y' || $day == 'Sund\ay') {
        $errors['day'] = ucwords('sorry, you cannot clock in during weekends');
    }
    $checkuser = $conn->prepare('SELECT * FROM workers WHERE fullname=? AND factoryId=?');
    $checkuser->execute([$fullname, $factoryid]);
    $fetchUser = $checkuser->fetch();
    if ($fetchUser == 0) {

        $errors['userNotFound'] = ucwords('no such user found, please contact the admin');

    }
    $confirmUser = $conn->prepare('SELECT * FROM present WHERE fullname =?');
    $confirmUser->execute([$fullname]);
    $get = $confirmUser->fetch();
    if ($get > 0) {
        $errors['alreadypresent'] = ucwords('you have already clocked in  today');
    }
    // echo date('Y');
    if (count($errors) === 0) {

        $insertUser = $conn->prepare('INSERT INTO present (fullname, factoryid) VALUES(?,?)');
        $insertUser->execute([$fullname, $factoryid]);
        if ($insertUser) {
            $loggedOK = ucwords('you have successfully cloacked  in');
        }
    }

}
if (isset($_POST["emaillist"])) {
    $email = $_POST["email"];
    if (empty($email)) {
        $emailerr['null'] = ucwords('Email is required');
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $emailerr['invalid'] = ucwords("email is invalid");
    }
    $checkEmail = $conn->prepare('SELECT * FROM emaillist WHERE email =?');
    $checkEmail->execute([$email]);
    $check = $checkEmail->fetch();
    if ($check > 0) {
        $emailerr['alreadysubscribe'] = ucwords('your email has been registered already ');
    }
    if (count($emailerr) === 0) {
        $stmt = $conn->prepare('INSERT INTO emaillist (email) VALUES(?)');
        $stmt->execute([$email]);
        if ($stmt) {
            $emailReg = ucwords('you have successfully been registered');
        }
    }

}
include "php_files/menu.php"; ?>

<div name="carouselExampleCaptions" class="carousel slide " data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/images/slide1.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption">
                <h2 class="caption">HNG TECH</h2>
                <p class="caption">WE ARE LOOKING FOR TALENTED DEVELOPERS</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/slide2.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption">
                <h2 class="caption">REGISTER WITH US</h2>
                <p class="caption">
                    WE WILL TAKE CARE OF YOUR ACCOMODATION, FEEDING AND TEACH YOU
                    EVERYTHING
                </p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/slide3.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption">
                <h2 class="caption">THE BEST WILL GET A JOB IMMEDIATELY</h2>
                <p class="caption">WHAT ARE YOU WAITING FOR? JOIN US NOW!!!</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div class="container-fluid main">
    <h3>Welcome, your services are highly appreciated and rewarded...</h3>
    <p>
        clocking in helps us to serve you better and also give you the best
        experience you'll ever have.
    </p>
    <h3 class="text-warning">clock-in now!!!</h3>
    <div class="col-6 offset-3">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <?php
foreach ($errors as $error) {
    echo '<div class="bg-danger text-white">' . $error . '</div>';
}
echo "<div class='text-white bg-success'>" . $loggedOK . "</div>";
?>
                <label for="fullName">Full Name:</label>
                <input type="text" class="form-control" name="fullName" value="<?php echo $fullname; ?>" />
            </div>
            <div class="form-group">
                <label for="idNum">Factory ID Number:</label>
                <input type="text" class="form-control" name="idNum" value="<?php echo $factoryid; ?>" />

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning" name="submit">
                    Clock In
                </button>
            </div>
        </form>
    </div>
    <div class="  newsletter">
        <form action="#" method="post">
            <div class="col-6 offset-3">

                <?php
foreach ($emailerr as $emailerrors) {
    echo "<li class='bg-danger text-white'> " . $emailerrors . "</li>";
}
echo "<div class='bg-success text-white'>" . $emailReg . "</div>";
?>
                <h4 class="text-center after">subscribe to our weekly newsletter</h4>
                <label for="email" class="label">Enter Email:</label>
                <input type="email" class="input-email" name="email" />
                <button class=" btn btn-secondary" name="emaillist" type="submit">
                    Subscribe
                </button>
            </div>
        </form>
    </div>
    <?php include "php_files/footer.php"; ?>

</div>
<?php
$root_path = "../";
$page_title = "Login";
include "header.php";

if ($sRole == "Admin" || $sRole == "User") {
    header("location:singleuserview.php?id=$sUserID");
}
if (isset($_GET["msg"])) {
if ($_GET["msg"] == "incorrectdetails") {
    ?>
    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
        The details you entered were incorrect.
    </div>
    <?php
}}
?>

<div class="container row m-auto pt-2">
    <div class="col-12 col-lg-6 my-3 m-auto">
        <h3 class="text-primary pb-0 pb-md-0 p-md-5 p-3">Enter your details</h3>
        <form class="container p-md-5 pb-md-5 pt-2 pt-md-3 pb-3 p-2" action="../controller/logincontroller.php" method="POST">
            <div class="form-group mb-3">
                <label for="Username" class="form-label">Username</label>
                <input type="text" class="form-control" id="Username" name="Username" placeholder="Enter Username">
            </div>
            <div class="form-group mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php
include "footer.php";
?>
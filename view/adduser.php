<?php
$root_path = "../";
$page_title = "Add User";
include "header.php";
$errors = [];
if (isset($_GET["msg"])) {
    $error_msgs = explode("|", $_GET["msg"]);
    foreach ($error_msgs as $value) {
        $error_item = explode(":", $value);
        $errors += [$error_item[0] => $error_item[1]];
    }
}
if (isset($_GET["m"])) {
    ?>
    <div class="alert alert-success" role="alert" onclick="dismiss(this)">
    This user has been added successfully.
    </div>
    <?php
}
?>

<main class="container row m-auto pt-2">
    <div class="col-12 col-lg-6 m-auto">
        <h3 class="text-primary pb-0 pb-md-0 p-md-5 p-3">Add a new user</h3>
        <form action="../controller/addusercontroller.php" method="POST" enctype="multipart/form-data"  class="container p-md-5 pb-md-5 pt-2 pt-md-3 pb-3 p-2">

            <div class="mb-3">
                <label for="Username" class="form-label required">Username</label>
                <input type="text" class="form-control" id="Username" name="Username">
                <?php if (isset($errors["UsernameErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["UsernameErr"] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label required">Password</label>
                <input type="password" id="Password" class="form-control"   aria-describedby="passwordHelpBlock" name="Password">
                <div id="passwordHelpBlock" class="form-text">
                    Your password must be 8-20 characters long, contain letters and numbers, and must not   contain spaces, special characters,   or emoji.
                </div>
                <?php if (isset($errors["PasswordErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["PasswordErr"] ?>
                    </div>
                <?php } ?>
            </div>

            <div class="mb-3 row">
                <div class="col-12 col-md-6">
                    <label for="FirstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="FirstName" name="FirstName">
                    <?php if (isset($errors["FirstNameErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["FirstNameErr"] ?>
                    </div>
                <?php } ?>
                </div>
                <div class="col-12 col-md-6">
                    <label for="LastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="LastName" name="LastName">
                    <?php if (isset($errors["LastNameErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["LastNameErr"] ?>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Role" id="Admin" value="Admin">
                        <label class="form-check-label" for="Admin">Admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Role" id="User" value="User"     checked>
                        <label class="form-check-label" for="User">User</label>
                    </div>
                    <?php if (isset($errors["RoleErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["RoleErr"] ?>
                    </div>
                <?php } ?>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>

        </form>
    </div>
</main>


<?php
include "footer.php";
?>
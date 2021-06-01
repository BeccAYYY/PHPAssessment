<?php
$root_path = "../";
$page_title = "Users";
include "header.php";
include "../controller/usersdisplaycontroller.php";

if ($sRole !== "Admin" && $sUserID !== $userdetails["UserID"]) {
    header("location:../index.php?msg=unauthorised");
}

if (isset($_GET["msg"])) {
    $error_item = explode(":", $_GET["msg"]);
?>
    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
        <p><?php echo "Cannot update $error_item[0]: $error_item[1]"; ?></p>
    </div>
<?php
    }
    if (isset($_GET["m"])) { ?>
    <div class="alert alert-success" role="alert" onclick="dismiss(this)">
        <p class="m-0">Saved successfully.</p>
    </div>
    <?php
    }
?>
<div class="container pt-3">
    <?php 
        if ($sRole == "Admin")  {
            ?>
    <div>
        <p><a href="usersdisplay.php">&laquo; Back to all users</a></p>
    </div>
    <?php
        } 
    ?>


    <div class="m-auto col-12 col-lg-6 border bg-light p-3 d-flex flex-column align-items-center">

        <div id="username-div" class="editable-div position-relative rounded" onclick="editBox(this)">
            <h2 class="text-primary text-center p-2"><?php echo $userdetails["Username"]; ?></h2>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>

        <div id="name-div" class="editable-div position-relative p-2 rounded" onclick="editBox(this)">
            <p class="m-0"><b>Name: </b><?php  
            if (!empty($userdetails["FirstName"]) && !empty($userdetails["LastName"])) {
                echo $userdetails["FirstName"] . " " . $userdetails["LastName"]; 
            } elseif (!empty($userdetails["FirstName"]) || !empty($userdetails["LastName" ])) {
                echo $userdetails["FirstName"] . $userdetails["LastName"]; 
            } else {
                echo "Anonymous";
            }
            ?></p>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>
        <?php if ($sRole == "Admin") { ?>
        <div id="role-div" class="editable-div position-relative p-2 rounded" onclick="editBox(this)">
            <p class="m-0"><b>Role: </b><?php echo $userdetails["Role"]; ?></p>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>
        <?php } ?>
        <div class="p-2">
            <p class="text-muted small m-0"><b>Created: </b><?php echo $userdetails["CreatedDate"]; ?></p>
        </div>
    <?php if ($sUserID == $userdetails["UserID"]) { ?>
        <div class="btn btn-primary text-white m-3" id="password-btn" onclick="editBox(this)">
            <p class="m-0">Change Password</p>
        </div>
        <?php } ?>
        <div class="btn btn-primary text-white m-3" id="delete-btn" onclick="editBox(this)">
            <p class="m-0">Delete User</p>
        </div>
        </div>
    </div>
</div>





<div id="edit-overlay" onclick="exitEditForm()">
</div>
<div id="edit-box" class="border rounded py-3 p-1 px-sm-2 px-md-3 p-lg-5 text-center">

        <div id="username-edit" class="edit-form">
            <label for="Username">Edit Username</label>
            <form id="username-edit-form" action="../controller/editusercontroller.php" method="POST">
                <input type="text" class="form-control my-3" id="Username" name="Username" value="<?php echo $userdetails["Username"]; ?>">
                <input type="hidden" value="<?php echo $userdetails["UserID"]; ?>" name="UserID">
                <input type="submit" class="btn btn-primary text-white d-inline">
            </form>
        </div>

        <div id="name-edit" class="edit-form">Edit Name
            <form id="name-edit-form" action="../controller/editusercontroller.php" method="POST">
                <div class="text-start">
                    <label for="FirstName" class="text-muted small">First Name</label>
                    <input type="text" id="FirstName" name="FirstName" class="form-control mb-3" value="<?php echo $userdetails  ["FirstName"]; ?>">
                    <label for="LastName" class="text-muted small">Last Name</label>
                    <input type="text" id="LastName" name="LastName" class="form-control mb-3" value="<?php echo $userdetails   ["LastName"]; ?>">
                </div>
                <input type="hidden" value="<?php echo $userdetails["UserID"]; ?>" name="UserID">
                <input type="submit" class="btn btn-primary text-white d-inline text-center">
            </form>
        </div>

        <?php if ($sRole == "Admin") { ?>
        <div id="role-edit" class="edit-form">Edit Role
            <form id="role-edit-form" action="../controller/editusercontroller.php" method="POST">
            <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Role" id="Admin" value="Admin"  <?php if ($userdetails["Role"] == "Admin") echo "checked"; ?>>
                        <label class="form-check-label" for="Admin">Admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Role" id="User" value="User" <?php if ($userdetails["Role"] == "User") echo "checked"; ?>>
                        <label class="form-check-label" for="User">User</label>
                    </div>
                <input type="hidden" value="<?php echo $userdetails["UserID"]; ?>" name="UserID">
                <input type="submit" class="btn btn-primary text-white d-inline">
            </form>
        </div>
        <?php }
        if ($sRole == "User") { ?>
        <div id="password-edit" class="edit-form">Edit Password
            <form id="password-edit-form" action="../controller/editusercontroller.php" method="POST">
                <div class="text-start">
                    <label for="CurrentPassword" class="text-muted small">Current Password</label>
                    <input type="password" id="CurrentPassword" name="CurrentPassword" class="form-control mb-3">
                    <label for="Password" class="text-muted small">New Password</label>
                    <input type="password" id="Password" name="Password" class="form-control mb-3">
                    <label for="Password2" class="text-muted small">Repeat New Password</label>
                    <input type="password" id="Password2" name="Password2" class="form-control mb-3">
                </div>
                <input type="hidden" value="<?php echo $userdetails["UserID"]; ?>" name="UserID">
                <input type="submit" class="btn btn-primary text-white d-inline">
            </form>
        </div>
        <?php } ?>
        <div id="delete-confirm" class="edit-form">
            <p>Are you sure you wish to delete <?php echo $userdetails["Username"] ?>?</p>
            <form id="delete-confirmation-form" action="../controller/editusercontroller.php" method="POST">
                <input type="hidden" value="<?php echo $userdetails["UserID"]; ?>" name="UserID">
                <input type="submit" class="btn btn-primary text-white d-inline" name="Delete" value="Delete">
                <div class="btn btn-primary text-white d-inline" id="delete-cancel" onclick="exitEditForm()">Cancel</div>
            </form>
        </div>
    </div>

<?php
include "footer.php";
?>
<?php
$root_path = "../";
include "header.php";
?>

<main>
    <form action="../controller/addusercontroller.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Add a New User</legend>
            <div class="field">
                <label for="Username">USERNAME</label>
                <input type="text" name="Username">
            </div>
            <div class="field">
                <label for="Password">PASSWORD</label>
                <input type="text" name="Password">
            </div>
            <div class="field">
                <label for="FirstName">FIRST NAME</label>
                <input type="text" name="FirstName">
            </div>
            <div class="field">
                <label for="LastName">LAST NAME</label>
                <input type="text" name="LastName">
            </div>
            <div>
                <label>ROLE</label>
                <input type="radio" id="Admin" name="Role" value="Admin">
                <label for="Admin">Admin</label>
                <input type="radio" id="User" name="Role" value="User">
                <label for="User">User</label>
            </div>
            <input type="submit" value="Create">
        </fieldset>
    </form>
</main>


<?php
include "footer.php";
?>
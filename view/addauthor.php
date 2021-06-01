<?php
$root_path = "../";
$page_title = "Add Author";
include "header.php";

if ($sRole !== "Admin" && $sRole !== "User") {
    header("location:../index.php?msg=unauthorised");
}
$errors = [];
if (isset($_GET["msg"])) {
    $error_msgs = explode("|", $_GET["msg"]);
    foreach ($error_msgs as $value) {
        $error_item = explode(":", $value);
        $errors += [$error_item[0] => $error_item[1]];
    }
}
?>
<main class="container row m-auto pt-2">
    <div class="col-12 col-lg-6 m-auto">
        <h3 class="text-primary pb-0 pb-md-0 p-md-5 p-3">Add a new Author</h3>
        <form action="../controller/addauthorcontroller.php" method="POST" enctype="multipart/form-data" class="container p-md-5 pb-md-5 pt-2 pt-md-3 pb-3 p-2">
            <div class="form-group mb-3">
                <label for="Name" class="form-label required">Name</label>
                <input type="text" name="Name" class="form-control">
                <?php if (isset($errors["NameErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["NameErr"] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group mb-3">
                <label for="BirthYear" class="form-label required">Birth Year</label>
                <input type="number" name="BirthYear" class="form-control" placeholder="YYYY">
                <?php if (isset($errors["BirthYearErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["BirthYearErr"] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group mb-3">
                <label for="DeathYear" class="form-label d-block">Death Year</label>
                <div class="form-check form-switch">
                    <input type="Checkbox" id="Deceased" name="Deceased" class="form-check-input" value="Deceased">
                    <label for="Alive" class="form-check-label small text-muted">Deceased?</label>
                    <input type="number" name="DeathYear" id="DeathYear" value="" class="form-control" placeholder="YYYY">
                </div>
                <?php if (isset($errors["DeathYearErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["DeathYearErr"] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group mb-3">
                <label for="Bio" class="form-label">Bio</label>
                <textarea name="Bio" id="Bio" cols="30" rows="10" class="form-control"></textarea>
                <?php if (isset($errors["BioErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $errors["BioErr"] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group mb-3">
                <label for="ImagePath" class="form-label">Image</label>
                <input type="file" name="ImagePath" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
    </form>
</main>


<?php
include "footer.php";
?>
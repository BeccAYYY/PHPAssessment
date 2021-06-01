<?php
$root_path = "../";
$page_title = "Add Book";
include "header.php";
include "../controller/authorsdisplaycontroller.php";

if ($sRole !== "Admin" && $sRole !== "User") {
    header("location:../index.php?msg=unauthorised");
}
$authorRedirect = "";
if (isset($_GET["author"])) {
    $authorRedirect = $_GET["author"];
}
$authorErrors = [];
if (isset($_GET["authorMsg"])) {
    $error_msgs = explode("|", $_GET["authorMsg"]);
    foreach ($error_msgs as $value) {
        $error_item = explode(":", $value);
        $authorErrors += [$error_item[0] => $error_item[1]];
    }
}

?>

<main class="container row m-auto pt-2">
    <div class="col-12 col-lg-6 m-auto">
        <h3 class="text-primary pb-0 pb-md-0 p-md-5 p-3">Add a New Book</h3>
        <form action="../controller/addbookcontroller.php" method="POST">
            <div class="form-group mb-3">
                <label for="" class="form-label">Author</label>
                <select id="AuthorID" name="AuthorID" class="form-select" onchange="bookFormSelector()">
                    <option id="select-option">Select...</option>
                    <option id="new-option"<?php if ($authorRedirect == "new") echo "selected"; ?>>Add New Author</option>
                    <?php foreach ($row as $v) { ?>
                        <option value="<?php echo $v["AuthorID"]; ?>" <?php if ($authorRedirect == $v['AuthorID']) echo "selected"; ?>><?php echo $v["Name"]; ?></option>
                    <?php } ?>
                </select>
            </div>


            <div id="book-form">
                <div class="form-group mb-3">
                    <label for="Title" class="form-label">Title</label>
                    <input type="text" name="Title" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="PublishedYear" class="form-label">Year Published</label>
                    <input type="number" name="PublishedYear" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="Image" class="form-label">Cover Photo</label>
                    <input type="file" name="ImagePath" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="CopiesSold" class="form-label">Copies Sold</label>
                    <input type="text" name="CopiesSold" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="Summary" class="form-label">Summary</label>
                    <textarea name="Summary" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Create</button>
            </div>
        </form>


        <form action="../controller/addauthorcontroller.php?redirect=true" method="POST" enctype="multipart/form-data" class="container p-md-5 pb-md-5 pt-2 pt-md-3 pb-3 p-2 bg-light border mb-3" id="author-form">
            <div class="form-group mb-3">
                <label for="Name" class="form-label required">Author Name</label>
                <input type="text" name="Name" class="form-control">
                <?php if (isset($authorErrors["NameErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $authorErrors["NameErr"] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group mb-3">
                <label for="BirthYear" class="form-label required">Birth Year</label>
                <input type="number" name="BirthYear" class="form-control" placeholder="YYYY">
                <?php if (isset($authorErrors["BirthYearErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $authorErrors["BirthYearErr"] ?>
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
                <?php if (isset($authorErrors["DeathYearErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $authorErrors["DeathYearErr"] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group mb-3">
                <label for="Bio" class="form-label">Author Bio</label>
                <textarea name="Bio" id="Bio" cols="30" rows="10" class="form-control"></textarea>
                <?php if (isset($authorErrors["BioErr"])) {
                    ?>
                    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
                    <?php echo $authorErrors["BioErr"] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group mb-3">
                <label for="ImagePath" class="form-label">Author Image</label>
                <input type="file" name="ImagePath" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
    </form>


    </div>
</main>


<?php
include "footer.php";
?>
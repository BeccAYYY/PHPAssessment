<?php
$root_path = "../";
include "../controller/authorsdisplaycontroller.php";
$page_title = $authordetails["Name"] . " - Author";
include "header.php";

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
    <div>
        <p><a href="authorsdisplay.php">&laquo; Back to all Authors</a></p>
    </div>


    <div class="m-auto col-12 col-lg-6 border bg-light p-3 d-flex flex-column align-items-center mb-5">

        <div id="name-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative rounded" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <h2 class="text-primary text-center p-2"><?php echo $authordetails["Name"]; ?></h2>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>
        

        <div id="birth-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative p-2 rounded" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <p class="text-muted mb-0">
                <?php echo $authordetails["BirthYear"] . " - ";
                if ($authordetails["DeathYear"] == NULL) {
                    echo "Present";
                } else {
                    echo $authordetails["DeathYear"];
                }?>
            </p>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>


        <div id="image-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative p-2 rounded" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <img src="<?php echo $authordetails['ImagePath']; ?>" class="img-fluid">
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>


        <div id="bio-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative p-2 rounded" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <p class="<?php if (empty($authordetails["Bio"])) echo "text-muted font-italic"; ?> m-0">
                <?php if (empty($authordetails["Bio"])) {
                    echo "No biography.";
                } else {
                    echo $authordetails["Bio"]; 
                }?>
            </p>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>


        <div class="p-2">
            <p class="text-muted small m-0"><b>Created: </b><?php echo $authordetails["CreatedDate"]; ?></p>
        </div>
    </div>
</div>


<div id="edit-overlay" onclick="exitEditForm()">
</div>
<div id="edit-box" class="border rounded py-3 p-1 px-sm-2 px-md-3 p-lg-5 text-center">

        <div id="name-edit" class="edit-form">
            <label for="Name">Edit Name</label>
            <form id="name-edit-form" action="../controller/editauthorcontroller.php" method="POST">
                <input type="text" class="form-control my-3" id="Name" name="Name" value="<?php echo $authordetails['Name']; ?>">
                <input type="hidden" value="<?php echo $authordetails["AuthorID"]; ?>" name="AuthorID">
                <input type="submit" class="btn btn-primary text-white d-inline">
            </form>
        </div>

        <div id="birth-edit" class="edit-form">
            <label>Edit Birth/Death Year</label>
            <form id="birth-edit-form" action="../controller/editauthorcontroller.php" method="POST">
                <div class="text-start">
                    <label for="BirthYear" class="text-muted small">Birth Year</label>
                    <input type="number" id="BirthYear" name="BirthYear" class="form-control" value="<?php echo $authordetails['BirthYear']; ?>">
                    <label for="DeathYear" class="form-label d-block">Death Year</label>
                    <div class="form-check form-switch">
                        <input type="Checkbox" id="Deceased" name="Deceased" class="form-check-input" value="Deceased"
                        <?php if (!empty($authordetails["DeathYear"])) {
                            echo "checked"; 
                        } ?>
                        >
                        <label for="Alive" class="form-check-label small text-muted">Deceased?</label>
                        <input type="number" name="DeathYear" id="DeathYear" value="<?php if (!empty($authordetails["DeathYear"])) echo $authordetails['DeathYear']; ?>" class="form-control mb-3" placeholder="YYYY">
                </div>
        
                </div>
                <input type="hidden" value="<?php echo $authordetails["AuthorID"]; ?>" name="AuthorID">
                <input type="submit" class="btn btn-primary text-white d-inline text-center">
            </form>
        </div>

        <?php if ($sRole == "Admin") { ?>
        <div id="image-edit" class="edit-form">
        <form id="image-edit-form" action="../controller/editauthorcontroller.php" method="POST" enctype="multipart/form-data">
            <label>Edit Image</label>
            <form id="image-edit-form" action="../controller/editauthorcontroller.php" method="POST">
                <input type="file" name="ImagePath" class="form-control my-3">
                <input type="hidden" value="<?php echo $authordetails["AuthorID"]; ?>" name="AuthorID">
                <input type="submit" class="btn btn-primary text-white d-inline text-center">
                
            </form>
        </div>
        
        <div id="bio-edit" class="edit-form">
            <label for="Bio">Edit Bio</label>
            <form id="bio-edit-form" action="../controller/editauthorcontroller.php" method="POST">
                <textarea name="Bio" id="Bio" cols="30" rows="10" class="form-control my-3"><?php echo $authordetails["Bio"]; ?></textarea>
                <input type="hidden" value="<?php echo $authordetails["AuthorID"]; ?>" name="AuthorID">
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
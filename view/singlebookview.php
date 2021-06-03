<?php
$root_path = "../";
include "../controller/booksdisplaycontroller.php";
$page_title = $bookdetails["Title"] . " - Book";
include "header.php";

if (isset($_GET["msg"])) {
    $error_item = explode(":", $_GET["msg"]);
?>
    <div class="alert alert-danger" role="alert" onclick="dismiss(this)">
        <p class="m-0"><?php echo "Cannot update $error_item[0]: $error_item[1]"; ?></p>
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
        <p><a href="booksdisplay.php">&laquo; Back to all Books</a></p>
    </div>

<div class="container row m-auto">
    

    <div class="m-auto col-12 col-lg-6 border bg-light p-3 d-flex flex-column align-items-center mb-5">

        <div id="title-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative rounded p-2" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <h2 class="text-primary text-center m-0"><?php echo $bookdetails["Title"]; ?></h2>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>

        <div id="author-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative rounded p-2" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <p class="m-0">By <a href="singleauthorview.php?id=<?php echo $bookdetails["AuthorID"]; ?>"><?php echo $bookdetails["Name"] ?></a></p>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>

        <div id="published-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative rounded p-2" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <p class="m-0"><b>Published: </b><?php echo $bookdetails["PublishedYear"]; ?></p>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>

        <div id="image-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative rounded p-2" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <img src="<?php echo $bookdetails['ImagePath']; ?>" class="img-fluid">
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>

        <div id="sold-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative rounded p-2" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <p class="m-0"><b>Copies sold: </b><?php echo $bookdetails["CopiesSold"]; ?></p>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>

        <div id="summary-div" class="<?php if ($sRole == "User" || $sRole == "Admin") echo "editable-div"; ?> position-relative rounded p-2" <?php if ($sRole == "User" || $sRole == "Admin") echo 'onclick="editBox(this)"'; ?>>
            <p class="m-0 <?php if (empty($bookdetails['Summary'])) echo 'text-muted text-italic'; ?>">
            <?php 
            if (empty($bookdetails["Summary"])) {
                echo "No Summary.";
            } else {
                echo $bookdetails["Summary"]; 
            }
            ?>
            </p>
            <i class="fas fa-pen-square position-absolute fs-5"></i>
        </div>
        <?php if ($sRole == "Admin" || $sRole == "User") { ?>
        <p class="text-muted m-0">Created on <?php echo $bookdetails["EntryCreated"]; ?></p>
        <p>Viewed <?php echo $bookdetails["Clicks"]; ?> times</p>

        <div class="btn btn-primary text-white m-3" id="delete-btn" onclick="editBox(this)">
            <p class="m-0">Delete Book</p>
        </div>
        <?php } ?>
    </div>
<?php if ($sRole == "Admin") { ?>
    <div class="col-12 col-lg-6 border bg-light p-3 mb-5 mt-0 align-self-start m-auto">
        <h5 class="text-primary">Logs</h5>
        <?php 
            if (empty($logs)) {
                ?><p class="text-muted"> No logs.
            <?php } 
            foreach ($logs as $v) { ?>
            <div class="row text-center">
                <div class="col"><p><?php echo $v["Date"]; ?></p></div>
                <div class="col"><p><a href="singleuserdisplay.php?id=<?php echo $v["UserID"];?>"><?php echo $v["Username"]; ?></a></p></div>
                <div class="col"><p><b><?php echo $v["ColumnName"]; ?></b></p></div>
                <div class="col-12">
                    <p><?php echo $v["FromValue"]; ?><b> => </b><?php echo $v["ToValue"]; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>

<div id="edit-overlay" onclick="exitEditForm()">
</div>

<div id="edit-box" class="border rounded py-3 p-1 px-sm-2 px-md-3 p-lg-5 text-center">

    <div id="title-edit" class="edit-form">
        <label for="Title">Edit Title</label>
        <form id="title-edit-form" action="../controller/editbookcontroller.php" method="POST">
            <input type="text" class="form-control my-3" id="Title" name="Title" value="<?php echo $bookdetails['Title']; ?>">
            <input type="hidden" value="<?php echo $bookdetails["BookID"]; ?>" name="BookID">
            <input type="submit" class="btn btn-primary text-white d-inline">
        </form>
    </div>

    <div id="author-edit" class="edit-form">
        <label for="AuthorID">Edit Author</label>
        <form id="author-edit-form" action="../controller/editbookcontroller.php" method="POST">
            <select id="AuthorID" name="AuthorID" class="form-select my-3">
                <?php foreach ($authorsrow as $v) { ?>
                    <option value="<?php echo $v["AuthorID"]; ?>" <?php if ($bookdetails == $v['AuthorID']) echo "selected"; ?>><?php echo $v["Name"]; ?></option>
                <?php } ?>
            </select>
            <input type="hidden" value="<?php echo $bookdetails["BookID"]; ?>" name="BookID">
            <input type="submit" class="btn btn-primary text-white d-inline">
        </form>
    </div>

    <div id="published-edit" class="edit-form">
        <label for="PublishedYear">Edit Published Year</label>
        <form id="author-edit-form" action="../controller/editbookcontroller.php" method="POST">
            <input type="number" name="PublishedYear" class="form-control my-3">
            <input type="hidden" value="<?php echo $bookdetails["BookID"]; ?>" name="BookID">
            <input type="submit" class="btn btn-primary text-white d-inline">
        </form>
    </div>


    <div id="image-edit" class="edit-form">
        <form id="image-edit-form" action="../controller/editbookcontroller.php" method="POST" enctype="multipart/form-data">
            <label>Edit Image</label>
            <form id="image-edit-form" action="../controller/editbookcontroller.php" method="POST">
                <input type="file" name="ImagePath" class="form-control my-3">
                <input type="hidden" value="<?php echo $bookdetails["BookID"]; ?>" name="BookID">
                <input type="submit" class="btn btn-primary text-white d-inline text-center">
        </form>
    </div>

    <div id="sold-edit" class="edit-form">
        <label for="CopiesSold">Edit Copies Sold</label>
        <form id="sold-edit-form" action="../controller/editbookcontroller.php" method="POST">
            <input type="text" class="form-control my-3" id="CopiesSold" name="CopiesSold" value="<?php echo $bookdetails['CopiesSold']; ?>">
            <input type="hidden" value="<?php echo $bookdetails["BookID"]; ?>" name="BookID">
            <input type="submit" class="btn btn-primary text-white d-inline">
        </form>
    </div>

    <div id="summary-edit" class="edit-form">
        <label for="Summary">Edit Summary</label>
        <form id="summary-edit-form" action="../controller/editbookcontroller.php" method="POST">
            <textarea name="Summary" cols="30" rows="10" class="form-control my-3"><?php echo $bookdetails['Summary']; ?></textarea>
            <input type="hidden" value="<?php echo $bookdetails["BookID"]; ?>" name="BookID">
            <input type="submit" class="btn btn-primary text-white d-inline">
        </form>
    </div>

    <div id="delete-confirm" class="edit-form">
            <p>Are you sure you wish to delete <?php echo $bookdetails["Title"] ?>?</p>
            <form id="delete-confirmation-form" action="../controller/editbookcontroller.php" method="POST">
                <input type="hidden" value="<?php echo $bookdetails["BookID"]; ?>" name="BookID">
                <input type="submit" class="btn btn-primary text-white d-inline" name="Delete" value="Delete">
                <div class="btn btn-primary text-white d-inline" id="delete-cancel" onclick="exitEditForm()">Cancel</div>
            </form>
        </div>

</div>

<?php 
    include "footer.php";
?>
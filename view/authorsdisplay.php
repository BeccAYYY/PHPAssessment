<?php
$root_path = "../";
$page_title = "Authors";
include "header.php";
include "../controller/authorsdisplaycontroller.php";

if (isset($_GET["msg"])) { 
    if ($_GET["msg"] = "AuthorDeleted") {?>
<div class="alert alert-success" role="alert" onclick="dismiss(this)">
    <p class="m-0">Author deleted successfully.</p>
</div>
<?php
    }
}
?>
<div class="container mt-5">
    <h4 class="text-primary">All Authors</h4>
</div>
<div class="container row m-auto my-5">

<?php
foreach ($row as $v) {
    ?>
    <div class="col-12 col-md-6 col-lg-4 border p-3">
        <a class="h4" href="singleauthorview.php?id=<?php echo $v["AuthorID"] ?>"><p><?php echo $v["Name"]; ?></p></a>
        <p><?php echo $v["BirthYear"] . " - ";
            if ($v["DeathYear"] == NULL) {
            echo "Present";
        } else {
            echo $v["DeathYear"];
        }
        ?></p>
        <img src="<?php echo $v['ImagePath']; ?>" class="img-fluid">
    </div>
    <?php
}
?>
</div>

<?php
include "footer.php";
?>
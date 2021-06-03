<?php
$root_path = "../";
include "../controller/booksdisplaycontroller.php";
$page_title = "Books";
include "header.php";
if (isset($_GET["msg"])) { 
    if ($_GET["msg"] = "BookDeleted") {?>
<div class="alert alert-success" role="alert" onclick="dismiss(this)">
    <p class="m-0">Book deleted successfully.</p>
</div>
<?php
    }
}
?>
<div class="container mt-5">
    <h4 class="text-primary">All Books</h4>
</div>
<div class="container row m-auto my-5">

<?php
foreach ($row as $v) {
    ?>
    <div class="col-12 col-md-6 col-lg-4 border p-3">
        <a class="h4" href="singlebookview.php?id=<?php echo $v["BookID"] ?>"><p><?php echo $v["Title"]; ?></p></a>
        <p>By <a href="singleauthorview.php?id=<?php echo $v["AuthorID"] ?>"><?php echo $v["Name"] ?></a> (<?php echo $v["PublishedYear"]; ?>)</p>
        <img src="<?php echo $v['ImagePath']; ?>" class="img-fluid">
    </div>
    <?php
}
?>
</div>

<?php
include "footer.php";
?>

<?php
include "footer.php";
?>
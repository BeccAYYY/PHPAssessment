<?php
$root_path = "";
$page_title = "Home";
include "view/header.php";
include "controller/homepagecontroller.php";
?>

<main>

<div class="container mt-5">
    <h4 class="text-primary">Most Viewed Books</h4>
    <div class="d-flex justify-content-end">
        <p><a href="view/booksdisplay.php">View all Books &raquo;</a></p>
    </div>
</div>
<div class="container row m-auto">

<?php
foreach ($homeBooks as $v) {
    ?>
    <div class="col-12 col-md-6 col-lg-4 border p-3">
        <a class="h4" href="view/singlebookview.php?id=<?php echo $v["BookID"]; ?>"><p><?php echo $v["Title"]; ?></p></a>
        <p>By <a href="view/singleauthorview.php?id=<?php echo $v["AuthorID"]; ?>"><?php echo $v["Name"]; ?></a> (<?php echo $v["PublishedYear"]; ?>)</p>
        <img src="<?php echo $v['ImagePath']; ?>" class="img-fluid">
        <p class="text-muted">Viewed <?php echo $v["Clicks"]; ?> times</p>
    </div>
    <?php
}
?>
</div>

<div class="container mt-5">
    <h4 class="text-primary">Recently Added Authors</h4>
    <div class="d-flex justify-content-end">
        <p><a href="view/authorsdisplay.php">View all Authors &raquo;</a></p>
    </div>
</div>
<div class="container row m-auto mb-5">
<?php
foreach ($homeAuthors as $v) {
    ?>
    <div class="col-12 col-md-6 col-lg-4 border p-3">
        <a class="h4" href="view/singleauthorview.php?id=<?php echo $v["AuthorID"] ?>"><p><?php echo $v["Name"]; ?></p></a>
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
</main>


<?php
include "view/footer.php";
?>
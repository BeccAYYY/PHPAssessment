<?php
$root_path = "../";
$page_title = "Users";
include "header.php";
include "../controller/usersdisplaycontroller.php";

if ($sRole !== "Admin") {
    header("location:../index.php?msg=unauthorised");
}
    if (isset($_GET["msg"])) { 
        if ($_GET["msg"] = "UserDeleted") {?>
    <div class="alert alert-success" role="alert" onclick="dismiss(this)">
        <p class="m-0">User deleted successfully.</p>
    </div>
    <?php
        }
    }
?>

<div class="container mt-5">
    <h4 class="text-primary">All Users</h4>
</div>
<div class="container row m-auto my-5">



<?php
foreach ($row as $v) {
    ?>
    <div class="col-12 col-md-6 col-lg-4 border p-3">
        <a class="h4" href="singleuserview.php?id=<?php echo $v["UserID"] ?>"><p><?php echo $v["Username"]; ?></p></a>
        <p><b>Name: </b><?php  
        if (!empty($v["FirstName"]) && !empty($v["LastName"])) {
            echo $v["FirstName"] . " " . $v["LastName"]; 
        } elseif (!empty($v["FirstName"]) || !empty($v["LastName" ])) {
            echo $v["FirstName"] . $v["LastName"]; 
        } else {
            echo "Anonymous";
        }
        ?></p>
        <p><b>Role: </b><?php echo $v["Role"]; ?></p>
        <p><b>Created: </b><?php echo $v["CreatedDate"]; ?></p>
    </div>
    <?php
}
?>
</div>

<?php
include "footer.php";
?>
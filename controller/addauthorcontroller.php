<?php
include "../model/connection.php";
include "../model/authors.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$author = new authors;

if (isset($_GET["redirect"])) {
    try {
        $Deceased = NULL;
        if (isset($_POST["Deceased"])) {
            $Deceased = "Deceased";
        }
        if ($_FILES["ImagePath"]["size"] !== 0) {
            $imageName = mt_rand() . $_FILES["ImagePath"]["name"];
            $ImagePath = "../view/img/" . $imageName;
            move_uploaded_file($_FILES["ImagePath"]["tmp_name"],$ImagePath);
            $image_path = "http://localhost/PHPAssessment/view/img/" . $imageName;
        } else {
            $image_path = "http://localhost/PHPAssessment/view/img/anonymous.png";
        }
        $author->get_information($Name, $Bio, $BirthYear, $DeathYear, $image_path, $Deceased);
        $errors = [];
        $errors = $author->validate();
        if (!empty($errors)) {
            $msg = implode("|", $errors);
            header("location:../view/addbook.php?author=new&authorMsg=$msg");
            } else {
            $author->insert_author($pdo);
            $latestID = $author->get_last_id($pdo);
            header("location:../view/addbook.php?author=$latestID");
            }
    } catch (exception $e) {
        header("location:../view/addauthor.php?msg=" . $e->getMessage());
    }
} else {
    try {
        $Deceased = NULL;
        if (isset($_POST["Deceased"])) {
            $Deceased = "Deceased";
        }
        if ($_FILES["ImagePath"]["size"] !== 0) {
            $imageName = mt_rand() . $_FILES["ImagePath"]["name"];
            $ImagePath = "../view/img/" . $imageName;
            move_uploaded_file($_FILES["ImagePath"]["tmp_name"],$ImagePath);
            $image_path = "http://localhost/PHPAssessment/view/img/" . $imageName;
        } else {
            $image_path = "http://localhost/PHPAssessment/view/img/anonymous.png";
        }
        $author->get_information($Name, $Bio, $BirthYear, $DeathYear, $image_path, $Deceased);
        $errors = [];
        $errors = $author->validate();
        if (!empty($errors)) {
            $msg = implode("|", $errors);
            header("location:../view/addauthor.php?msg=$msg");
            } else {
            $author->insert_author($pdo);
            header("location:../view/addauthor.php?m=Saved");
            }
    } catch (exception $e) {
        header("location:../view/addauthor.php?msg=" . $e->getMessage());
    }
}
?>
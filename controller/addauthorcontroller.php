<?php
include "../model/connection.php";
include "../model/authors.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$author = new authors;

    try {
        if ($_FILES["ImagePath"]["size"] !== 0) {
            $imageName = mt_rand() . $_FILES["ImagePath"]["name"];
            $ImagePath = "../view/img/" . $imageName;
            move_uploaded_file($_FILES["ImagePath"]["tmp_name"],$ImagePath);
            $image_path = "http://localhost/PHPAssessment/view/img/" . $imageName;
        } else {
            $image_path = "http://localhost/PHPAssessment/view/img/anonymous.png";
        }
        $author->get_information($Name, $Bio, $BirthYear, $DeathYear, $image_path);
        $author->insert_author($pdo);
        header("location:../view/addauthor.php?msg=Saved");
    } catch (exception $e) {
        header("location:../view/addauthor.php?msg=" . $e->getMessage());
    }
?>
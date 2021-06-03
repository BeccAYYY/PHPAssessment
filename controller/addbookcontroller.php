<?php
include "../model/connection.php";
include "../model/books.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$book = new books;

try {
    if ($_FILES["ImagePath"]["size"] !== 0) {
        $imageName = mt_rand() . $_FILES["ImagePath"]["name"];
        $ImagePath = "../view/img/" . $imageName;
        move_uploaded_file($_FILES["ImagePath"]["tmp_name"],$ImagePath);
        $image_path = "http://localhost/PHPAssessment/view/img/" . $imageName;
    } else {
        $image_path = "http://localhost/PHPAssessment/view/img/unknown-book.jpg";
    }
    $book->get_information($Title, $AuthorID, $PublishedYear, $image_path, $CopiesSold, $Summary);
    $errors = [];
        $errors = $book->validate($pdo);
        if (!empty($errors)) {
        $msg = implode("|", $errors);
        header("location:../view/addbook.php?msg=$msg&author=$AuthorID");
        } else {
        $book->insert_book($pdo);
        header("location:../view/addbook.php?m=Saved");
        }
} catch (exception $e) {
    header("location:../view/addbook.php?msg=" . $e->getMessage());
}
?>
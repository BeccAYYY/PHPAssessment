<?php
include "../model/connection.php";
include "../model/authors.php";
include "../model/books.php";
include "../model/logs.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$author = new authors;
$book = new books;
$log = new logs;

try {
    $id = $_POST["AuthorID"];
    if (isset($_POST["Name"])) {
        $error = $author->update_name($pdo, $_POST["Name"], $id);
    } elseif (isset($_POST["BirthYear"])) {
        $Deceased = NULL;
        if (isset($_POST["Deceased"])) {
            $Deceased = "Deceased";
        }
        $error = $author->update_birth($pdo, $_POST["BirthYear"], $_POST["DeathYear"], $Deceased ,$id);
    } elseif (isset($_FILES["ImagePath"])) {
        if ($_FILES["ImagePath"]["size"] !== 0) {
            $imageName = mt_rand() . $_FILES["ImagePath"]["name"];
            $ImagePath = "../view/img/" . $imageName;
            move_uploaded_file($_FILES["ImagePath"]["tmp_name"],$ImagePath);
            $image_path = "http://localhost/PHPAssessment/view/img/" . $imageName;
        } else {
            $image_path = "http://localhost/PHPAssessment/view/img/anonymous.png";
        }
        $error = $author->update_image($pdo, $image_path, $id);
    } elseif (isset($_POST["Bio"])) {
        $error = $author->update_bio($pdo, $_POST["Bio"], $id);
    } elseif (isset($_POST["Delete"])) {

        $deleteBooks = $book->search_book_by_author($pdo, $id);
        foreach ($deleteBooks as $v) {
            $log->delete_books_logs($pdo, $v["BookID"]);
        }
        $book->delete_authors_books($pdo, $id);
        $author->delete_author($pdo, $id);

        header("location:../view/authorsdisplay.php?msg=AuthorDeleted");
        exit();
    }
    if (!empty($error)) {
    $msg = $error;
    header("location:../view/singleauthorview.php?msg=$msg&id=$id");
    } else {
    header("location:../view/singleauthorview.php?m=Saved&id=$id");
    }
} catch (exception $e) {
    header("location:../view/addbook.php?msg=" . $e->getMessage());
}
?>
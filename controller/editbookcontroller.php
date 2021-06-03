<?php
session_start();
include "../model/connection.php";
include "../model/books.php";
include "../model/logs.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$book = new books;
$log = new logs;

try {
    $id = $_POST["BookID"];
    $previousData = $book->search_book_by_id($pdo, $id);
    if (isset($_POST["Title"])) {
        $error = $book->update_title($pdo, $_POST["Title"], $id);
        if (empty($error)) {
            $log->add_log($pdo, $_SESSION["UserID"], $id, "Title", $previousData["Title"], $_POST["Title"]);
        }
    } elseif (isset($_POST["AuthorID"])) {
        $error = $book->update_author($pdo, $_POST["AuthorID"], $id);
        if (empty($error)) {
            $log->add_log($pdo, $_SESSION["UserID"], $id, "AuthorID", $previousData["AuthorID"], $_POST["AuthorID"]);
        }
    } elseif (isset($_POST["PublishedYear"])) {
        $error = $book->update_published($pdo, $_POST["PublishedYear"], $id);
        if (empty($error)) {
            $log->add_log($pdo, $_SESSION["UserID"], $id, "PublishedYear", $previousData["PublishedYear"], $_POST["PublishedYear"]);
        }
    } elseif (isset($_FILES["ImagePath"])) {
        if ($_FILES["ImagePath"]["size"] !== 0) {
            $imageName = mt_rand() . $_FILES["ImagePath"]["name"];
            $ImagePath = "../view/img/" . $imageName;
            move_uploaded_file($_FILES["ImagePath"]["tmp_name"],$ImagePath);
            $image_path = "http://localhost/PHPAssessment/view/img/" . $imageName;
        } else {
            $image_path = "http://localhost/PHPAssessment/view/img/unknown-book.jpg";
        }
        $error = $book->update_image($pdo, $image_path, $id);
        if (empty($error)) {
            $log->add_log($pdo, $_SESSION["UserID"], $id, "ImagePath", $previousData["ImagePath"], $image_path);
        }
    } elseif (isset($_POST["CopiesSold"])) {
        $error = $book->update_sold($pdo, $_POST["CopiesSold"], $id);
        if (empty($error)) {
            $log->add_log($pdo, $_SESSION["UserID"], $id, "CopiesSold", $previousData["CopiesSold"], $_POST["CopiesSold"]);
        }
    } elseif (isset($_POST["Summary"])) {
        $error = $book->update_summary($pdo, $_POST["Summary"], $id);
        if (empty($error)) {
            $log->add_log($pdo, $_SESSION["UserID"], $id, "Summary", $previousData["Summary"], $_POST["Summary"]);
        }
    } elseif (isset($_POST["Delete"])) {
        $log->delete_books_logs($pdo, $id);
        $book->delete_book($pdo, $id);
        header("location:../view/booksdisplay.php?msg=BookDeleted");
        exit();
    }
    if (!empty($error)) {
    $msg = $error;
    header("location:../view/singlebookview.php?msg=$msg&id=$id");
    } else {
    header("location:../view/singlebookview.php?m=Saved&id=$id");
    }
} catch (exception $e) {
    header("location:../view/addbook.php?msg=" . $e->getMessage());
}
?>
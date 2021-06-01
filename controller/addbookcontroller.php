<?php
include "../model/connection.php";
include "../model/books.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$book = new books;

try {
    $book->get_information($BookID, $Title, $AuthorID, $PublishedYear, $ImagePath, $CopiesSold, $Summary, $Clicks, $EntryCreated, $EntryLastUpdated);
    $book->insert_book($pdo);
    header("location:../view/addbook.php?msg=Saved");
} catch (exception $e) {
    header("location:../view/addbook.php?msg=" . $e->getMessage());
}
?>
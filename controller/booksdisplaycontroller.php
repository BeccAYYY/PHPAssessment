<?php
include "../model/connection.php";
include "../model/books.php";
include "../model/authors.php";
include "../model/logs.php";
$conn = new connection;
$pdo = $conn->connect_db();
$book = new books;
$author = new authors;
$log = new logs;





$row = $book->get_all_books($pdo);
if (isset($_GET["id"])) {
    $bookdetails = $book->search_book_by_id($pdo, $_GET["id"]);
    if (!isset($_GET["msg"]) && !isset($_GET["m"])) {
        $book->add_click($pdo, $_GET["id"]);
    }
    $logs = $log->logs_by_book($pdo, $_GET["id"]);

}

$authorsrow = $author->get_all_authors($pdo);
<?php
include "../model/connection.php";
include "../model/books.php";
include "../model/authors.php";
$conn = new connection;
$pdo = $conn->connect_db();
$book = new books;
$author = new authors;


$row = $book->get_all_books($pdo);
if (isset($_GET["id"])) {
    $bookdetails = $book->search_book_by_id($pdo, $_GET["id"]);
}

$authorsrow = $author->get_all_authors($pdo);
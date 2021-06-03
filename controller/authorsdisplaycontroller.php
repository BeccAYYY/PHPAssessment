<?php
include "../model/connection.php";
include "../model/authors.php";
include "../model/books.php";
$conn = new connection;
$pdo = $conn->connect_db();
$author = new authors;
$book = new books;


$row = $author->get_all_authors($pdo);
if (isset($_GET["id"])) {
    $authordetails = $author->search_author_by_id($pdo, $_GET["id"]);
    $bookRow = $book->search_book_by_author($pdo, $_GET["id"]);

}
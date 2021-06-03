<?php
include "model/connection.php";
include "model/books.php";
include "model/authors.php";

$conn = new connection;
$pdo = $conn->connect_db();
$book = new books;
$author = new authors;

$homeBooks = $book->books_by_clicks($pdo);
$homeAuthors = $author->authors_by_created($pdo);
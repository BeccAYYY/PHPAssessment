<?php
include "../model/connection.php";
include "../model/authors.php";
$conn = new connection;
$pdo = $conn->connect_db();
$author = new authors;


$row = $author->get_all_authors($pdo);
if (isset($_GET["id"])) {
    $authordetails = $author->search_author_by_id($pdo, $_GET["id"]);
}
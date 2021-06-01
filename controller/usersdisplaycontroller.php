<?php
include "../model/connection.php";
include "../model/users.php";
$conn = new connection;
$pdo = $conn->connect_db();
$user = new users;
$row = $user->get_all_users($pdo);

if (isset($_GET["id"])) {
    $userdetails = $user->search_user_by_id($pdo, $_GET["id"]);
}

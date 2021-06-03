<?php
include "../model/connection.php";
include "../model/users.php";
include "../model/logs.php";
$conn = new connection;
$pdo = $conn->connect_db();
$user = new users;
$log = new logs;


$row = $user->get_all_users($pdo);

if (isset($_GET["id"])) {
    $userdetails = $user->search_user_by_id($pdo, $_GET["id"]);
    $logs = $log->logs_by_user($pdo, $_GET["id"]);
}

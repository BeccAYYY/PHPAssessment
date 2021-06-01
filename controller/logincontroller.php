<?php
include "../model/connection.php";
include "../model/users.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$user = new users;

try {
    $id = $user->get_userid_from_username($pdo, $_POST["Username"])["UserID"];
    $pw = $_POST["Password"];
    if (empty($pw) || empty($id) || !$user->check_password($pdo, $pw, $id)) {
        header("location:../view/login.php?msg=incorrectdetails");
    } else {
        session_start();
        $details = $user->search_user_by_id($pdo, $id);
        $_SESSION["UserID"] = $id;
        $_SESSION["Username"] = $details["Username"];
        $_SESSION["Role"] = $details["Role"];
        header("location:../index.php");
    }
} catch (exception $e) {
    header("location:../view/login.php?msg=" . $e->getMessage());
}
?>
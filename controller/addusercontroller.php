<?php
include "../model/connection.php";
include "../model/users.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$user = new users;

    try {
        $user->get_information($Username, $FirstName, $LastName, $Password, $Role);
        $errors = [];
        $errors = $user->validate($pdo);
        $msg = implode("|", $errors);
        $user->insert_user($pdo);
        header("location:../view/adduser.php?msg=$msg");
    } catch (exception $e) {
        //header("location:../view/addbook.php?msg=" . $e->getMessage());
    }
?>
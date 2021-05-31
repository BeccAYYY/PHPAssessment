<?php
include "../model/connection.php";
include "../model/users.php";
extract($_POST);
$conn = new connection;
$pdo = $conn->connect_db();
$user = new users;

try {
    $id = $_POST["UserID"];
    if (isset($_POST["Username"])) {
        $error = $user->update_username($pdo, $_POST["Username"], $id);
    } elseif (isset($_POST["FirstName"])) {
        $error = $user->update_name($pdo, $_POST["FirstName"], $_POST["LastName"], $id);
    } elseif (isset($_POST["Role"])) {
        $error = $user->update_role($pdo, $_POST["Role"], $id);
    } elseif (isset($_POST["Password"])) {
        $error = $user->update_password($pdo, $_POST["CurrentPassword"], $_POST["Password"], $_POST["Password2"], $id);
    }
    if (!empty($error)) {
    $msg = $error;
    header("location:../view/singleuserview.php?msg=$msg&id=$id");
    } else {
    header("location:../view/singleuserview.php?m=Saved&id=$id");
    }
} catch (exception $e) {
    header("location:../view/addbook.php?msg=" . $e->getMessage());
}
?>
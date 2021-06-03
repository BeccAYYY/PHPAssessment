<?php
class logs {



    public function delete_books_logs($pdo, $BookID) {
        $query = "DELETE FROM logs WHERE BookID = $BookID;";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
    }

    public function logs_by_book($pdo, $BookID) {
        $query = "SELECT l.ColumnName, l.FromValue, l.ToValue, l.Date, u.Username, u.UserID FROM logs AS l INNER JOIN users AS u ON l.UserID = u.UserID WHERE BookID = $BookID ORDER BY Date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    public function logs_by_user($pdo, $UserID) {
        $query = "SELECT l.ColumnName, l.FromValue, l.ToValue, l.Date, b.Title, b.BookID FROM logs AS l INNER JOIN books AS b ON l.BookID = b.BookID WHERE UserID = $UserID ORDER BY Date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }


public function add_log($pdo, $UserID, $BookID, $ColumnName, $FromValue, $ToValue) {
    if (empty($FromValue)) {
        $FromValue = null;
    }
    if (empty($ToValue)) {
        $ToValue = null;
    }
        $query="INSERT INTO logs (UserID, BookID, ColumnName, FromValue, ToValue) VALUES ('$UserID', '$BookID', '$ColumnName', '$FromValue', '$ToValue')";
        $stmt=$pdo->prepare($query);
        $stmt->execute() or die(print_r($stmt->errorInfo(),true));
}
}

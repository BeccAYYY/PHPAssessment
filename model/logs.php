<?php
class logs {




public function delete_authors_logs($pdo, $AuthorID) {
    $query = "DELETE FROM logs WHERE AuthorID = $AuthorID";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
}















}
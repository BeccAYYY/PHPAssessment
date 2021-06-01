<?php
class books {
//Definining properties for within this class
    Private $BookID;
    Private $Title;
    Private $AuthorID;
    Private $PublishedYear;
    Private $ImagePath;
    Private $CopiesSold;
    Private $Summary;
    Private $Clicks;
    Private $EntryCreated;
    Private $EntryLastUpdated;

//Data here comes from the form. "$this" refers to the current class. The variables in the brackets are parameters for this functions that will be fed in later.
    public function get_information($Title, $AuthorID, $PublishedYear, $ImagePath, $CopiesSold, $Summary) {
        $this->Title=$Title;
        $this->AuthorID=$AuthorID;
        $this->PublishedYear=$PublishedYear;
        $this->ImagePath=$ImagePath;
        $this->CopiesSold=$CopiesSold;
        $this->Summary=$Summary;
    }

//The function to run the insert query after the previous function has got the information.
    public function insert_book($pdo) {
        $query="INSERT INTO books (Title, AuthorID, PublishedYear, ImagePath, CopiesSold, Summary) VALUES (:t, :aid, :py, :ip, :cs, :s)";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":t", $this->Title);
        $stmt->bindParam(":aid", $this->AuthorID);
        $stmt->bindParam(":py", $this->PublishedYear);
        $stmt->bindParam(":ip", $this->ImagePath);
        $stmt->bindParam(":cs", $this->CopiesSold);
        $stmt->bindParam(":s", $this->Summary);
        $stmt->execute();
    }

    public function search_books_by_id($pdo, $BookID) {
        $query = "SELECT * FROM books WHERE BookID=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($BookID));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}






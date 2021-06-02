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


//W3Schools function for sanitizing inputs.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



//Data here comes from the form. "$this" refers to the current class. The variables in the brackets are parameters for this functions that will be fed in later.
    public function get_information($Title, $AuthorID, $PublishedYear, $ImagePath, $CopiesSold, $Summary) {
        $this->Title=$this->test_input($Title);
        $this->AuthorID=intval($this->test_input($AuthorID));
        $this->PublishedYear=intval($this->test_input($PublishedYear));
        $this->ImagePath=$this->test_input($ImagePath);
        $this->CopiesSold=intval($this->test_input($CopiesSold));
        $this->Summary=$this->test_input($Summary);
    }

    function check_authorID($pdo, $AuthorID) {
        $query = "SELECT COUNT(*) FROM authors WHERE AuthorID='" . $AuthorID . "'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["COUNT(*)"];
    }

    Private $columns = [];
    Private $errors = [];


    public function validate($pdo) {
        if ($this->Title == "") {
            $this->errors[] = "TitleErr:Title is required";
        } elseif (preg_match('/[\^£$%}{@#~><>,|=_¬]/', $this->Title)) {
            $this->errors[] = "TitleErr:Title cannot contain special characters.";
        } elseif (strlen($this->Title) > 255) {
            $this->errors[] = "TitleErr:Title cannot be over 200 characters.";
        } else {
            $this->columns[] = "Title";
        } 
        if (intval($this->check_authorID($pdo, $this->AuthorID)) !== 1) {
            $this->errors[] = "AuthorIDErr:Please select an author.";
        } else {
            $this->columns[] = "AuthorID";
        } 
        
        if ($this->PublishedYear == "") {
            $this->errors[] = "PublishedYearErr:Please enter a published year.";
        } elseif ($this->PublishedYear > date("Y") || $this->PublishedYear < 0000) { 
            $this->errors[] = "PublishedYearErr:Please enter a year between 0000 and the current year";
        } else {
            $this->columns[] = "PublishedYear";
        } 
        
        if ($this->ImagePath !== NULL) {
            $this->columns[] = "ImagePath";
        }  
        
        if (empty($this->CopiesSold)) {
            $this->errors[] = "CopiesSoldErr:Please fill this field.";
        } elseif (!is_int($this->CopiesSold)) {
            $this->errors[] = "CopiesSoldErr:Please enter a number.";
        } else {
            $this->columns[] = "CopiesSold";
        }

        if (strlen($this->Summary) > 400) {
            $this->errors[] = "SummaryErr:The summary should be below 400 characters.";
        } elseif ($this->Summary !== "") {
            $this->columns[] = "Summary";
        } 
        return $this->errors;
    }

//Function that outputs the list for the columns section of the SQL INSERT statement
    function columns($columns) {
        $array_values = array_values($columns);
        $last_value = end($array_values);
        $result = "";
        foreach($columns as $v) {
            if ($v !== $last_value) {
                $result = $result . "`$v`, ";
            } else {
                $result = $result . "`$v`";
            }
        }
        return $result;
    }

//Function that outputs the list for the VALUES section of the SQL INSERT statement
    function values($columns) {
        $array_values = array_values($columns);
        $last_value = end($array_values);
        $result = "";
        foreach($columns as $v) {
            if ($v !== $last_value) {
                $result = $result . ":$v, ";
            } else {
                $result = $result . ":$v";
            }
        }
        return $result;
    }

//The function to run the insert query after the previous function has got the information.
    public function insert_book($pdo) {
        $query="INSERT INTO books (" . $this->columns($this->columns) . ") VALUES (" . $this->values($this->columns). ")";
        $stmt=$pdo->prepare($query);
        foreach($this->columns as $v) {
            $stmt->bindParam(":$v", $this->$v);
        }
        $stmt->execute() or die(print_r($stmt->errorInfo(),true));
    }

    public function search_books_by_id($pdo, $BookID) {
        $query = "SELECT * FROM books WHERE BookID=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($BookID));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function delete_authors_books($pdo, $AuthorID) {
        $query = "DELETE FROM books WHERE AuthorID = $AuthorID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
}






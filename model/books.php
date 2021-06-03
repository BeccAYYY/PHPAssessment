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

    public function search_book_by_id($pdo, $BookID) {
        $query = "SELECT b.BookID, b.Title, b.AuthorID, b.PublishedYear, b.ImagePath, b.CopiesSold, b.Summary, b.Clicks, b.EntryCreated, a.Name  FROM books AS b INNER JOIN authors AS a on b.AuthorID = a.AuthorID WHERE BookID=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($BookID));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function search_book_by_author($pdo, $AuthorID) {
        $query = "SELECT * FROM books WHERE AuthorID=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($AuthorID));
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function delete_authors_books($pdo, $AuthorID) {
        $query = "DELETE FROM books WHERE AuthorID = $AuthorID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }

    public function get_all_books($pdo) {
        $query = "SELECT b.BookID, b.Title, b.AuthorID, b.PublishedYear, b.ImagePath, b.CopiesSold, b.Summary, b.Clicks, b.EntryCreated, a.Name  FROM books AS b INNER JOIN authors AS a on b.AuthorID = a.AuthorID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function update_title($pdo, $Title, $BookID) {
        $Title = $this->test_input($Title);
        $errors = "";
        if ($Title == "") {
            $errors = "Title:Title is required";
        } elseif (preg_match('/[\^£$%}{@#~><>,|=_¬]/', $Title)) {
            $errors = "Title:Title cannot contain special characters.";
        } elseif (strlen($Title) > 255) {
            $errors = "Title:Title cannot be over 200 characters.";
        } else {
            $query = "UPDATE books SET title = '$Title' WHERE BookID = $BookID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
        return $errors;
    }

    public function update_author($pdo, $AuthorID, $BookID) {
        $AuthorID = intval($this->test_input($AuthorID));
        $errors = "";
        if (intval($this->check_authorID($pdo, $AuthorID)) !== 1) {
            $errors = "Author ID:Please select an author.";
        } else {
            $query = "UPDATE books SET AuthorID = '$AuthorID' WHERE BookID = $BookID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
        return $errors;
    }

    public function update_published($pdo, $PublishedYear, $BookID) {
        $PublishedYear = intval($this->test_input($PublishedYear));
        $errors = "";
        if ($PublishedYear == "") {
            $errors = "Published Year:Please enter a published year.";
        } elseif ($PublishedYear > date("Y") || $PublishedYear < 0000) { 
            $errors = "Published Year:Please enter a year between 0000 and the current year";
        } else {
            $query = "UPDATE books SET PublishedYear = '$PublishedYear' WHERE BookID = $BookID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
        return $errors;
    }

    public function update_image($pdo, $ImagePath, $BookID) {
        $errors = "";
        $query = "UPDATE books SET ImagePath = '$ImagePath' WHERE BookID = $BookID;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $errors;
    }

    public function update_sold($pdo, $CopiesSold, $BookID) {
        $CopiesSold = intval($this->test_input($CopiesSold));
        $errors = "";
        if (empty($CopiesSold)) {
            $errors = "Copies Sold:Please fill this field.";
        } elseif (!is_int($CopiesSold)) {
            $errors = "Copies Sold:Please enter a number.";
        } else {
            $query = "UPDATE books SET CopiesSold = '$CopiesSold' WHERE BookID = $BookID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
        return $errors;
    }

    public function update_summary($pdo, $Summary, $BookID) {
        $Summary = $this->test_input($Summary);
        $errors = "";
        if (strlen($Summary) > 400) {
            $errors = "Summary:The summary should be below 400 characters.";
        } else {
        $query = "UPDATE books SET Summary = '$Summary' WHERE BookID = $BookID;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    return $errors;
    }

    public function delete_book($pdo, $BookID) {
        $query = "DELETE FROM books WHERE BookID = $BookID;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }

    public function add_click($pdo, $BookID) {
        $row = $this->search_book_by_id($pdo, $BookID);
        $newClicks = $row["Clicks"] + 1;
        $query = "UPDATE books SET Clicks = '$newClicks' WHERE BookID = $BookID;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }

    public function books_by_clicks($pdo) {
        $query = "SELECT b.BookID, b.Title, b.AuthorID, b.PublishedYear, b.ImagePath, b.CopiesSold, b.Summary, b.Clicks, b.EntryCreated, a.Name  FROM books AS b INNER JOIN authors AS a on b.AuthorID = a.AuthorID ORDER BY Clicks DESC LIMIT 3";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
}






<?php
class authors {
//Definining properties for within this class
    Private $AuthorID;
    Private $Name;
    Private $Bio;
    Private $BirthYear;
    Private $DeathYear;
    Private $ImagePath;
    Private $Deceased;

//W3Schools function for sanitizing inputs.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Data here comes from the form. "$this" refers to the current class. The variables in the brackets are parameters for this functions that will be fed in later.
    public function get_information($Name, $Bio, $BirthYear, $DeathYear, $ImagePath, $Deceased) {
        $this->Name=$this->test_input($Name);
        $this->Bio=$this->test_input($Bio);
        $this->BirthYear=intval($this->test_input($BirthYear));
        $this->DeathYear=intval($this->test_input($DeathYear));
        $this->ImagePath=$this->test_input($ImagePath);
        $this->Deceased=$this->test_input($Deceased);
    }

    Private $columns = [];
    Private $errors = [];


    public function validate() {
        if ($this->Name == "") {
            $this->errors[] = "NameErr:Name is required";
        } elseif (preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬]/', $this->Name)) {
            $this->errors[] = "NameErr:Name cannot contain special characters.";
        } elseif (strlen($this->Name) > 40 or strlen($this->Name) < 3) {
            $this->errors[] = "NameErr:Please enter a name between 3 and 40 characters long.";
        } else {
            $this->columns[] = "Name";
        } 
        
        if (strlen($this->Bio) > 400) {
            $this->errors[] = "BioErr:The Bio should be below 400 characters.";
        } elseif ($this->Bio !== "") {
            $this->columns[] = "Bio";
        } 
        
        if ($this->BirthYear == "") {
            $this->errors[] = "BirthYearErr:Please enter a birth year.";
        } elseif ($this->BirthYear > date("Y") || $this->BirthYear < 0000) { 
            $this->errors[] = "BirthYearErr:Please enter a year between 0000 and the current year";
        } else {
            $this->columns[] = "BirthYear";
        } 
        
        if ($this->Deceased == NULL) {
        } elseif ($this->DeathYear > date("Y") || $this->DeathYear <= $this->BirthYear) { 
            $this->errors[] = "DeathYearErr:Please enter a year between the Birth Year and the current year or unchecked 'Deceased'";
        } elseif ($this->DeathYear == "") {
            $this->errors[] = "DeathYearErr:Please enter a year or unchecked 'Deceased'";
        } else {
            $this->columns[] = "DeathYear";
        }  
        
        if ($this->ImagePath !== null) {
            $this->columns[] = "ImagePath";
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
    public function insert_author($pdo) {
        $query="INSERT INTO authors (" . $this->columns($this->columns) . ") VALUES (" . $this->values($this->columns). ")";
        $stmt=$pdo->prepare($query);
        foreach($this->columns as $v) {
            $stmt->bindParam(":$v", $this->$v);
        }
        $stmt->execute() or die(print_r($stmt->errorInfo(),true));
    }

    public function search_author_by_id($pdo, $AuthorID) {
        $query = "SELECT * FROM authors WHERE AuthorID=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($AuthorID));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function get_all_authors($pdo) {
        $query = "SELECT * FROM authors";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function get_last_id($pdo) {
        $query = "SELECT MAX(AuthorID) FROM authors";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["MAX(AuthorID)"];
    }

    function update_name($pdo, $Name, $AuthorID) {
        $Name = $this->test_input($Name);
        $errors = "";
        if ($Name == "") {
            $errors = "Name:Name is required";
        } elseif (preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬]/', $Name)) {
            $errors = "Name:Name cannot contain special characters.";
        } elseif (strlen($Name) > 40 or strlen($Name) < 3) {
            $errors = "Name:Please enter a name between 3 and 40 characters long.";
        }  else {
        $query = "UPDATE authors SET Name = '$Name' WHERE AuthorID = $AuthorID;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        }
        return $errors;
    }

    function update_birth($pdo, $BirthYear, $DeathYear, $Deceased, $AuthorID) {
        $BirthYear = intval($this->test_input($BirthYear));
        $DeathYear = intval($this->test_input($DeathYear));
        $updateDY = false;
        $errors = "";
        if ($Deceased == NULL) {
            $query = "UPDATE authors SET DeathYear = NULL WHERE AuthorID = $AuthorID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        } elseif ($DeathYear > date("Y") || $DeathYear <= $BirthYear) { 
            $errors = "Death Year:Please enter a year between the Birth Year and the current year or unchecked 'Deceased'";
        } elseif ($DeathYear == "") {
            $errors = "Death Year:Please enter a year or unchecked 'Deceased'";
        } else {
            $updateDY = true;
        }
        if ($BirthYear == "") {
            $errors = "Birth Year:Please enter a birth year.";
        } elseif ($this->BirthYear > date("Y") || $this->BirthYear < 0000) { 
            $errors = "Birth Year:Please enter a year between 0000 and the current year";
        } elseif ($updateDY) {
            $query = "UPDATE authors SET DeathYear = $DeathYear, BirthYear = $BirthYear WHERE AuthorID = $AuthorID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        } 
        return $errors;
    }

    function update_image($pdo, $ImagePath, $AuthorID) {
        $errors = "";
        $query = "UPDATE authors SET ImagePath = '$ImagePath' WHERE AuthorID = $AuthorID;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $errors;
    }

    function update_bio($pdo, $Bio, $AuthorID) {
        $Bio = $this->test_input($Bio);
        $errors = "";
        if (strlen($Bio) > 400) {
            $errors = "Bio:The Bio should be below 400 characters.";
        } else {
        $query = "UPDATE authors SET Bio = '$Bio' WHERE AuthorID = $AuthorID;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        }
        return $errors;
    }
    
}
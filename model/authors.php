<?php
class authors {
//Definining properties for within this class
    Private $AuthorID;
    Private $Name;
    Private $Bio;
    Private $BirthYear;
    Private $DeathYear;
    Private $ImagePath;

//Data here comes from the form. "$this" refers to the current class. The variables in the brackets are parameters for this functions that will be fed in later.
    public function get_information($Name, $Bio, $BirthYear, $DeathYear, $ImagePath) {
        $this->Name=$Name;
        $this->Bio=$Bio;
        $this->BirthYear=$BirthYear;
        $this->DeathYear=$DeathYear;
        $this->ImagePath=$ImagePath;
    }

    Private $columns = [];

    public function validate() {
        if ($this->Name !== null) {
            $this->columns[] = "Name";
        } if ($this->Bio !== null) {
            $this->columns[] = "Bio";
        } if ($this->BirthYear !== null) {
            $this->columns[] = "BirthYear";
        } if ($this->DeathYear !== null) {
            $this->columns[] = "DeathYear";
        } if ($this->ImagePath !== null) {
            $this->columns[] = "ImagePath";
        }
    }
    function columns($columns) {
        $array_values = array_values($columns);
        $last_value = end($array_values);
        foreach($columns as $v) {
        if ($v !== $last_value) {
        echo "`$v`, ";
        } else {
        echo "`$v`";
        }
}
    }
//The function to run the insert query after the previous function has got the information.
    public function insert_author($pdo) {
        $query="INSERT INTO authors (" . $this->columns($this->columns) . ") VALUES (:Name, :Bio, :BirthYear, :DeathYear, :ImagePath)";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Bio", $this->Bio);
        $stmt->bindParam(":BirthYear", $this->BirthYear);
        $stmt->bindParam(":DeathYear", $this->DeathYear);
        $stmt->bindParam(":ImagePath", $this->ImagePath);
        $stmt->execute();
    }

    public function search_author_by_id($pdo, $AuthorID) {
        $query = "SELECT * FROM authors WHERE AuthorID=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($AuthorID));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
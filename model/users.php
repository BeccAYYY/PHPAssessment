<?php
class users {
//Definining properties for within this class
    Private $Username;
    Private $FirstName;
    Private $LastName;
    Private $Password;
    Private $Role;

//Data here comes from the form. "$this" refers to the current class. The variables in the brackets are parameters for this functions that will be fed in later.
    public function get_information($Username, $FirstName, $LastName, $Password, $Role) {
        $this->Username=$Username;
        $this->FirstName=$FirstName;
        $this->LastName=$LastName;
        $this->Password=$Password;
        $this->Role=$Role;
    }

//The function to run the insert query after the previous function has got the information.
    public function insert_user($pdo) {
        $query = "INSERT INTO users (`Username`, `FirstName`, `LastName`, `Password`, `Role`) VALUES (:u, :fn, :ln, :p, :r)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":u", $this->Username);
        $stmt->bindParam(":fn", $this->FirstName);
        $stmt->bindParam(":ln", $this->LastName);
        $stmt->bindParam(":p", $this->Password);
        $stmt->bindParam(":r", $this->Role);
        $stmt->execute();
    }

    public function search_user_by_username($pdo, $Username) {
        $query = "SELECT * FROM users WHERE Username=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($Username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
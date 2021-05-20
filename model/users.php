<?php
class users {
//Definining properties for within this class
    Private $Username;
    Private $FirstName;
    Private $LastName;
    Private $Password;
    Private $Role;
    Private $CreatedDate;

//Data here comes from the form. "$this" refers to the current class. The variables in the brackets are parameters for this functions that will be fed in later.
    public function get_information($Username, $FirstName, $LastName, $Password, $Role) {
        $this->Username=$Username;
        $this->FirstName=$FirstName;
        $this->LastName=$LastName;
        $this->Password=$Password;
        $this->Role=$Role;
    }

    Private $columns = [];

    public function validate() {
        if ($this->Username !== "") {
            $this->columns[] = "Username";
        } if ($this->FirstName !== "") {
            $this->columns[] = "FirstName";
        } if ($this->LastName !== "") {
            $this->columns[] = "LastName";
        } if ($this->Password !== "") {
            $this->columns[] = "Password";
        } if ($this->Role !== "") {
            $this->columns[] = "Role";
        }
    }

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
    public function insert_user($pdo) {
        

        $query = "INSERT INTO users (" . $this->columns($this->columns) . ") VALUES (" . $this->values($this->columns). ")";
        $stmt = $pdo->prepare($query);
        foreach($this->columns as $v) {
            $stmt->bindParam(":$v", $this->$v);
        }
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
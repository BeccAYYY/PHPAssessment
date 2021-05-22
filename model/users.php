<?php
class users {
//Definining properties for within this class
    Private $Username;
    Private $FirstName;
    Private $LastName;
    Private $Password;
    Private $Role;
    Private $CreatedDate;

//W3Schools function for sanitizing inputs.
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

//Data here comes from the form. "$this" refers to the current class. The variables in the brackets are parameters for this functions that will be fed in later.
    public function get_information($Username, $FirstName, $LastName, $Password, $Role) {
        $this->Username=$this->test_input($Username);
        $this->FirstName=$this->test_input($FirstName);
        $this->LastName=$this->test_input($LastName);
        $this->Password=$this->test_input($Password);
        $this->Role=$this->test_input($Role);
    }

    Private $columns = [];
    Private $errors = [];

//Validation for each form field, which adds it to the $columns array if it is validated and not null and adds one error for each field to the $errors array if one exists.
    public function validate() {
        if ($this->Username == "") {
            $this->errors += ["Username" => "Username is required"];
        } elseif (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $this->Username)) {
            $this->errors  += ["Username" => "Username cannot contain special characters."];
        } elseif (strlen($this->Username) > 40 or strlen($this->Username) < 3) {
            $this->errors += ["Username" => "Please enter a username between 3 and 20 characters long."];
        }  else {
            $this->columns[] = "Username";
        } 
        
        if ($this->FirstName !== "") {
            $this->columns[] = "FirstName";
        } 
        
        if ($this->LastName !== "") {
            $this->columns[] = "LastName";
        } 
        
        if ($this->Password !== "") {
            $this->columns[] = "Password";
        } 
        
        if ($this->Role !== "") {
            $this->columns[] = "Role";
        }
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
    public function insert_user($pdo) {
        $query = "INSERT INTO users (" . $this->columns($this->columns) . ") VALUES (" . $this->values($this->columns). ")";
        $stmt = $pdo->prepare($query);
        foreach($this->columns as $v) {
            $stmt->bindParam(":$v", $this->$v);
        }
        $stmt->execute();
    }

//Function to search for a user by the primary key; Username.
    public function search_user_by_username($pdo, $Username) {
        $query = "SELECT * FROM users WHERE Username=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($Username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
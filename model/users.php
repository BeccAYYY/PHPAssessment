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

//Function to check if the username already exists in the database.
function check_username($pdo, $Username) {
    $query = "SELECT COUNT(*) FROM users WHERE Username='" . $Username . "'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["COUNT(*)"];
}

    Private $columns = [];
    Private $errors = [];

//Validation for each form field, which adds it to the $columns array if it is validated and not null and adds one error for each field to the $errors array if one exists.
    public function validate($pdo) {
        if ($this->Username == "") {
            $this->errors[] = "UsernameErr:Username is required";
        } elseif (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $this->Username)) {
            $this->errors[] = "UsernameErr:Username cannot contain special characters.";
        } elseif (strlen($this->Username) > 40 or strlen($this->Username) < 3) {
            $this->errors[] = "UsernameErr:Please enter a username between 3 and 20 characters long.";
        } elseif ($this->check_username($pdo, $this->Username) > 0) {
            $this->errors[] = "UsernameErr:That username is already in use.";
        } else {
            $this->columns[] = "Username";
        } 
        
        if (!preg_match('/^[a-z]*$/i', $this->FirstName )) {
            $this->errors[] = "FirstNameErr:First name should contain only letters.";
        } elseif ($this->FirstName !== "") {
            $this->columns[] = "FirstName";
        }
        
        if (!preg_match('/^[a-z]*$/i', $this->LastName )) {
            $this->errors[] = "LastNameErr:Last name should contain only letters.";
        } elseif ($this->LastName !== "") {
            $this->columns[] = "LastName";
        } 
        
        if ($this->Password == "") {
            $this->errors[] = "PasswordErr:Please enter a password";
        } elseif (strlen($this->Password) < 8 || !preg_match('@[0-9]@', $this->Password) || !preg_match('@[A-Z]@', $this->Password) || !preg_match('@[a-z]@', $this->Password)) {
            $this->errors[] = "PasswordErr:Please enter a password that is at least 8 characters long, contains one uppercase and one lowercase character and one number.";
        } elseif ($this->Password !== "") {
            $this->columns[] = "Password";
            $this->Password = password_hash($this->Password, PASSWORD_DEFAULT);
        } 
        
        if ($this->Role == "Admin" || $this->Role == "User") {
            $this->columns[] = "Role";
        } else {
            $this->errors[] = "RoleErr:You have not selected a valid option.";
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
    function insert_user($pdo) {
        $query = "INSERT INTO users (" . $this->columns($this->columns) . ") VALUES (" . $this->values($this->columns). ")";
        $stmt = $pdo->prepare($query);
        foreach($this->columns as $v) {
            $stmt->bindParam(":$v", $this->$v);
        }
        $stmt->execute();
    }

//Function to search for a user by the primary key; UserID.
    function search_user_by_id($pdo, $UserID) {
        $query = "SELECT * FROM users WHERE UserID=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($UserID));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

//Function to get all users from users table
    function get_all_users($pdo) {
        $query = "SELECT * FROM users";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    function update_username($pdo, $Username, $UserID) {
        $this->test_input($Username);
        $errors = "";
        if ($Username == "") {
            $errors = "Username:Username cannot be empty";
        } elseif (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $Username)) {
            $errors = "Username:Username cannot contain special characters.";
        } elseif (strlen($Username) > 40 or strlen($Username) < 3) {
            $errors = "Username:Username must be between 3 and 20 characters long.";
        } elseif ($this->check_username($pdo, $Username) > 0) {
            $errors = "Username:That username is already in use.";
        } else {
        $query = "UPDATE users SET Username = '$Username' WHERE UserID = $UserID;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        }
        return $errors;
    }

    function update_name($pdo, $FirstName, $LastName, $UserID) {
        $this->test_input($FirstName);
        $this->test_input($LastName);
        if (!preg_match('/^[a-z]*$/i', $FirstName) || !preg_match('/^[a-z]*$/i', $LastName)) {
            $errors = "Name:Names should contain only letters.";
        } else {
            $query = "UPDATE users SET FirstName = '$FirstName', LastName = '$LastName' WHERE UserID = $UserID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
        return $errors;
    }

    function update_role($pdo, $Role, $UserID) {
        $this->test_input($Role);
        if (!($Role == "Admin" || $Role == "User")) {
            $errors = "Role:You have not selected a valid option.";
        } else {
            $query = "UPDATE users SET Role = '$Role' WHERE UserID = $UserID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
        return $errors;
    }

    function check_password($pdo, $Password, $UserID) {
        $row = $this->search_user_by_id($pdo, $UserID);
        $hash = $row["Password"];
        return password_verify($Password, $hash);
    }

    function update_password($pdo, $CurrentPassword, $Password, $Password2, $UserID) {
        $this->test_input($Password);
        if (! $this->check_password($pdo, $CurrentPassword, $UserID)) {
            $errors = "Password:Your details are incorrect.";
        } elseif ($Password !== $Password2) {
            $errors = "Password:Passwords do not match.";
        } elseif ($Password == "") {
            $errors = "Password:Please enter a password.";
        } elseif (strlen($Password) < 8 || !preg_match('@[0-9]@', $Password) || !preg_match('@[A-Z]@', $Password) || !preg_match('@[a-z]@', $Password)) {
            $errors = "Password:Please enter a password that is at least 8 characters long, contains one uppercase and one lowercase character and one number.";
        } else {
            $Password = password_hash($Password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET Password = '$Password' WHERE UserID = $UserID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
        return $errors;
    }
}
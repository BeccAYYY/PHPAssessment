<?php
class connection
{
    private $pdo;

    //Establish a connection with the library database
    public function connect_db()
    {

        $dsn = "mysql:dbname=library;host=localhost;port=3306";
        $username = "root";
        $password = "";
        try {
            $pdo = new PDO($dsn, $username, $password);
            return $pdo;
        } catch (PDOException $e) {
            header("location:../index.php?msg=DatabaseError" . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href=<?php echo "\"" . $root_path . "view/css/style.css\"" ?>>
</head>
<body>
    <header>
        <h1>Header</h1>
        <nav>
            <ul>
                <li>
                    <a href=<?php echo "\"" . $root_path . "\"" ?>>Home</a>
                </li>
                <li>
                    <a href=<?php echo "\"" . $root_path . "view/addbook.php\"" ?>>Add Book</a>
                </li>
                <li>
                    <a href=<?php echo "\"" . $root_path . "view/addauthor.php\"" ?>>Add Author</a>
                </li>
                <li>
                    <a href=<?php echo "\"" . $root_path . "view/adduser.php\"" ?>>Add User</a>
                </li>
            </ul>
        </nav>
    </header>

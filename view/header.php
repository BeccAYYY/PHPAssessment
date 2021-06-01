<?php session_start(); 
$sRole = "";
$sUserID = "";
$sUsername = "";
    if (isset($_SESSION)) {
        if (isset($_SESSION["UserID"])) {
            $sRole = $_SESSION["Role"];
            $sUserID = $_SESSION["UserID"];
            $sUsername = $_SESSION["Username"];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo $root_path . "view/css/style.css" ?>">
    <script src="<?php echo $root_path . "view/node_modules/bootstrap/dist/js/bootstrap.bundle.js" ?>" defer></script>
    <script src="<?php echo $root_path . "view/js/js.js" ?>" defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $root_path ?>">Books</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo $root_path ?>"">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $root_path . "view/booksdisplay.php" ?>">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $root_path . "view/authorsdisplay.php" ?>">Authors</a>
                    </li>
                <?php
                    if ($sRole == "Admin") { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $root_path . "view/usersdisplay.php" ?>">Users</a>
                    </li>
                    <?php } 
                    if ($sRole == "Admin" || $sRole == "User") {?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Site
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo $root_path . "view/addbook.php" ?>">Add Book</a></li>
                            <li><a class="dropdown-item" href="<?php echo $root_path . "view/addauthor.php" ?>">Add Author</a></li>
                        <?php }
                        if ($sRole == "Admin") { ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo $root_path . "view/adduser.php" ?>">Add User</a></li>
                        <?php } ?>
                        </ul>
                    </li>
                </ul>
                <div class="row align-items-start">
                <form class="d-flex col-10">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <ul class="navbar-nav col-2">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if (empty($sUserID)) { ?>
                            <li><a class="dropdown-item" href="<?php echo $root_path . "view/login.php" ?>">Log In</a></li>
                            <?php } else { ?>
                            <li><a class="dropdown-item" href="<?php echo $root_path . "view/singleuserview.php?id=$sUserID" ?>">View Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo $root_path . "controller/logoutcontroller.php" ?>">Log Out</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
                </div>


                    
            </div>
        </div>
    </nav>

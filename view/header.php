<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Books</title>
    <link rel="stylesheet" href="<?php echo $root_path . "view/css/style.css" ?>">
    <script src="<?php echo $root_path . "view/node_modules/bootstrap/dist/js/bootstrap.bundle.js" ?>" defer></script>
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
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $root_path . "view/usersdisplay.php" ?>">Users</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Site
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo $root_path . "view/addbook.php" ?>">Add Book</a></li>
                            <li><a class="dropdown-item" href="<?php echo $root_path . "view/addauthor.php" ?>">Add Author</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo $root_path . "view/adduser.php" ?>">Add User</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

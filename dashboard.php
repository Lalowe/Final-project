<?php
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM users WHERE user_status != '$status'";
$result = mysqli_query($connect, $sql);

//this variable will hold the body for the table
$tbody = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail rounded' src='" . $row['image'] . "' alt=" . $row['first_name'] . "></td>
            <td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
            <td>" . $row['email'] . "</td>
            <td><a href='adm_crud/update.php?id=" . $row['users_id'] . "'><button class='btn btn-primary btn-sm m-2' type='button'>Edit</button></a>
             <a href='adm_crud/delete.php?id=" . $row['users_id'] . "'><button class='btn btn-danger btn-sm m-2' type='button'>Delete</button></a></td>
            </tr>";
    }
} else {
    $tbody = "<tr><td colspan='6'><center>No Data Available </center></td></tr>";
}
$sql1 = "SELECT * FROM users where user_status = 'adm'";
$result1 = mysqli_query($connect, $sql1);
//this variable will hold the body for the Admin
$tbody1 = '';
if (mysqli_num_rows($result1)  > 0) {
    while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
        $tbody1 .= "<tr>
            <td>" . $row1['first_name'] . ' ' . $row1['last_name'] . "</td>
            </tr>";
    }
}

$sql2 = "SELECT * FROM users where user_status = 'adm'";
$result2 = mysqli_query($connect, $sql2);
//this variable will hold the body for the Admin
$tbody2 = '';
if (mysqli_num_rows($result2)  > 0) {
    while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        $tbody2 .= $row2['image'];
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <script src="https://kit.fontawesome.com/34a8e65dca.js" crossorigin="anonymous"></script>
    <?php require_once 'components/bootstrap.php' ?>
    <style type="text/css">
        .img-thumbnail {
            width: 100px !important;
            height: 100px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
            padding: 10px;
        }

        tr {
            text-align: left;
            padding: 10px;
        }

        .userImage {
            width: 125px;
            height: auto;
        }

        .btn{
            width: 5vw;
            padding: 10px;
        }
    </style>
</head>

<body>
    <!-- navbar for admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MealPlanner</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="recipes.php">Recipes</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="adm_crud/create.php">Create a user</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="logout.php?logout">Sign out</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>



    <div class="container">
        <div class="row">
            <div class="col-2 mt-2">
                <img class="userImage mt-5 rounded" src="<?= $tbody2 ?>" alt="Adm avatar">

                <h4 class="my-0"><?= $tbody1 ?></h4>
                <p class="lead">(Administrator)</p>

            </div>
            <div class="col-8 mt-2">
                <p class='h2 display-6 mt-5 mb-5'>User Information</p>
                <table class='table table-striped bg-light'>
                    <thead class='table-secondary'>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Email</th>


                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <?php require_once 'footer.php' ?>
</body>

</html>
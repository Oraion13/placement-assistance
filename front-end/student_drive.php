<?php
session_start();

if ($_SESSION["username"]) {
    echo "Welcome, " . $_SESSION['username'] . "!";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "placement";
    $row = "";
    // Create connection
    $conn = new mysqli("localhost", "root", "", "placement_assistance");
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `placement_students_profile` WHERE USN = '$username'";

    $result = $conn->query($sql);

    // Associative array
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "<script>window.alert('please fill your details')</script>";
        header("location: ./studprofile.php");
        die();
    }

    $_SESSION['student_id'] = $row['student_id'];
} else {
    // header("location: index.php");
    die("You must be Log in to view this page <a href='index.php'>Click here</a>");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--favicon-->
    <link rel="shortcut icon" href="favicon.ico" type="image/icon">
    <link rel="icon" href="favicon.ico" type="image/icon">

    <link rel="shortcut icon" href="favicon.ico" type="image/icon">
    <link rel="icon" href="favicon.ico" type="image/icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AccountLogin</title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</head>

<body>
    <!-- Left column -->
    <div class="templatemo-flex-row">
        <div class="templatemo-sidebar">
            <header class="templatemo-site-header">
                <div class="square"></div>

                <?php
                $Welcome = "Welcome";
                echo "<h1>" . $Welcome . "<br>" . $_SESSION['username'] . "</h1>";
                ?>
            </header>
            <div class="profile-photo-container">
                <img src="images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">
                <div class="profile-photo-overlay"></div>
            </div>
            <!-- Search box -->
            <form class="templatemo-search-form" role="search">
                <div class="input-group">
                    <button type="submit" class="fa fa-search"></button>
                    <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                </div>
            </form>
            <div class="mobile-menu-icon">
                <i class="fa fa-bars"></i>
            </div>
            <nav class="templatemo-left-nav">
                <ul>
                    <li>
                        <a href="./student_drive.php"><i class="fa fa-bar-chart fa-fw"></i>Placement Drives</a>
                    </li>
                    <li>
                        <a href="./studprofile.php" class="active"><i class="fa fa-sliders fa-fw"></i>Edit Profile</a>
                    </li>
                    <li>
                        <a href="update.php"><i class="fa fa-sliders fa-fw"></i>UPDATE PROFILE</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Main content -->
        <div class="templatemo-content col-1 light-gray-bg">
            <div class="templatemo-top-nav-container">
                <div class="row">
                    <nav class="templatemo-top-nav col-lg-12 col-md-12">
                        <ul class="text-uppercase">
                            <li>
                                <a href="../../Homepage/index.html">Home AURCT-PMS</a>
                            </li>
                            <li>
                                <a href="">Drives Homepage</a>
                            </li>
                            <li>
                                <a href="">Overview</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="templatemo-content-container">
            <div class="templatemo-content-widget white-bg">
                <!-- table  -->
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Job Description</th>
                            <th scope="col">About Company</th>
                            <th scope="col">Eligibilty Criteria</th>
                            <th scope="col">Last Date</th>
                            <th scope="col">Document</th>
                            <th scope="col">Enroll</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">

                    </tbody>
                </table>

            </div>
        </div>
        <!-- JS -->
        <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
        <!-- jQuery -->
        <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>
        <!-- http://markusslima.github.io/bootstrap-filestyle/ -->
        <script type="text/javascript" src="js/templatemo-script.js"></script>
        <!-- Templatemo Script -->
</body>
<script src="./js/student_drive.js"></script>

</html>
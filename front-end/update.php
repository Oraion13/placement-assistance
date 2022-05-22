<?php
  session_start();
  if($_SESSION["username"]){
    echo "Welcome, ".$_SESSION['username']."!";
  }
   else {
	   header("location: index.php");
   die("You must be Log in to view this page <a href='index.php'>Click here</a>");}
   
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
    </head>

    <body>
        <!-- Left column -->
        <div class="templatemo-flex-row">
            <div class="templatemo-sidebar">
                <header class="templatemo-site-header">
                    <div class="square"></div>

                    <?php
		  $Welcome = "Welcome";
          echo "<h1>" . $Welcome . "<br>". $_SESSION['username']. "</h1>";
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
                            <a href="#"><i class="fa fa-bar-chart fa-fw"></i>Placement Drives</a>
                        </li>
                        <li>
                            <a href="#" class="active"><i class="fa fa-sliders fa-fw"></i>Edit Profile</a>
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
                <div class="templatemo-content-container">
                    <div class="templatemo-content-widget white-bg">
                        <h2 class="margin-bottom-10">Profile</h2>
                        <p>Update Your Details</p>
                        <form action="pref1.php" class="templatemo-login-form" method="post" enctype="multipart/form-data">
                            <div class="row form-group">
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="inputFirstName">First Name</label>
                                    <input type="text" name="Fname" value='$row->fname' class="form-control" id="inputFirstName" placeholder="Ram">
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="inputLastName">Last Name</label>
                                    <input type="text" name="Lname" value = '$row->lname' class="form-control" id="inputLastName" placeholder="Laxman">
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="inputUserName">User Name</label>
                                    <input type="text" name="USERNAME" value ='$row->USN' class="form-control" id="inputUserName" placeholder="Enter your UserName">
                                </div>

                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="usn">Register Number</label>
                                    <input type="text" name="RegNo" value = '$row->REGNO' class="form-control" id="reg" placeholder="9500XXXXXXXX">
                                </div>

                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="Phone">Phone:</label>
                                    <input type="text" name="Num" value = '$row->phno' class="form-control" id="Phone" placeholder="91xxxxxxxx">
                                </div>

                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="Email">Email</label>
                                    <input type="Email" name="Email" value = '$row->email' class="form-control" id="Email" placeholder="abc@example.com">
                                </div>

                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="DOB">Date of Birth</label>
                                    <input type="date" name="DOB" value ='$row->date' class="form-control" id="DOB" placeholder="DD/MM/YYYY">
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label class="control-label templatemo-block">Current Semester</label>
                                    <select name="Cursem" value = '$row->cursem' class="form-control">
                    <option value="select">Semester</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                  </select>
                                </div>


                                <div class="col-lg-6 col-md-6 form-group">
                                    <label class="control-label templatemo-block">Branch of Study</label>
                                    <select name="Branch" value = '$row->branch' class="form-control">
                    <option value="select">Branch</option>
                    <option value="MECH">ME</option>
                    <option value="GEO">GEOINFORMATICS</option>
                    <option value="CSE">CSE</option>
                    <option value="EEE">EEE</option>
                    <option value="MBA">MBA</option>
                    <option value="MCA">MCA</option>
                  </select>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="sslc">SSLC/10th Aggregate</label>
                                    <input type="text" name="Percentage" value = '$row->per' class="form-control" id="sslc" placeholder="">
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="Pu">12th/Diploma Aggregate</label>
                                    <input type="text" name="Puagg" value = '$row->puagg' class="form-control" id="Pu" placeholder="">
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="BE">BE Aggregate</label>
                                    <input type="text" name="Beagg" value = '$row->beaggregate' class="form-control" id="BE" placeholder="">
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="BE">PG Aggregate(If you are pursing)</label>
                                    <input type="text" name="Pgagg" value = '$row->pgaggregate' class="form-control" id="BE" placeholder="">
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label class="control-label templatemo-block">Current Backlogs</label>
                                    <select name="Backlogs" value = '$row->back' class="form-control">
                    <option value="select">Numbers</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                  </select>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label class="control-label templatemo-block">History of Backlogs</label>
                                    <select name="History" value = '$row->hisofbk' class="form-control">
                    <option value="Y/N">Y/N</option>
                    <option value="Y">Y</option>
                    <option value="N">N</option>
                  </select>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label class="control-label templatemo-block">Detained Years</label>
                                    <select name="Dety" value = '$row->detyear' class="form-control">
                    <option value="select">Years</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                  </select>
                                </div>

                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="usn">Annual Income</label>
                                    <input type="text" name="income" value = '.$row->income.' class="form-control" id="reg" placeholder="">
                                </div>

                            </div>
                    </div>
                    <!--div class="row form-group">
                        <div class="col-lg-12">
                            <label class="control-label templatemo-block">Upload your Profile Pic</label>
                            <!-- <input type="file" name="fileToUpload" id="fileToUpload" class="margin-bottom-10">
                            <input type="file" name="fileToUpload" id="photo" class="filestyle">
                            <p>Maximum upload size is 5 MB.</p>
                             </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label class="control-label templatemo-block">Upload your Resume</label>
                                <!-- <input type="file" name="fileToUpload" id="fileToUpload" class="margin-bottom-10">
                                <input type="file" name="fileToUpload2" id="resume" class="filestyle">
                                <p>Maximum upload size is 5 MB.</p>
                            </div>
                        </div -->
                        <div class="form-group text-right">

                        <button type="submit" name="submit" class="templatemo-blue-button">add</button>
                            <button type="reset" class="templatemo-white-button">Reset</button>
                        </div>
                        </form>
                </div>
                <!-- JS -->
                <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
                <!-- jQuery -->
                <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>
                <!-- http://markusslima.github.io/bootstrap-filestyle/ -->
                <script type="text/javascript" src="js/templatemo-script.js"></script>
                <!-- Templatemo Script -->
    </body>

    </html>
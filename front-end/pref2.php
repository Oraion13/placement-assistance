<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "placement_assistance";

// Create connection
$conn = new mysqli("localhost", "root", "", "placement_assistance");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['update']) || isset($_POST['USERNAME'])) {
  $fname = $_POST['Fname'];
  $lname = $_POST['Lname'];
  $USN = $_POST['USERNAME'];
  $REGNO = $_POST['RegNo'];
  $phno = $_POST['Num'];
  $email = $_POST['Email'];
  $date = $_POST['DOB'];
  $cursem = $_POST['Cursem'];
  $branch = $_POST['Branch'];
  $per = $_POST['Percentage'];
  $puagg = $_POST['Puagg'];
  $beaggregate = $_POST['Beagg'];
  $pgaggregate = $_POST['Pgagg'];
  $back = $_POST['Backlogs'];
  $hisofbk = $_POST['History'];
  $detyear = $_POST['Dety'];
  $income = $_POST['income'];
  if ($USN != '' || $email != '') {
    $sql = mysqli_query($connect, "SELECT * FROM `placement`.`studentprofile` WHERE `USN`='$USN'");
    if (mysqli_num_rows($sql) == 1) {
      $sql = "UPDATE `placement_students_profile` SET `first_name`, `last_name`, `USN`, `register_umber`, `department_id`, `phone`, `mail`, `date_of_birth`, `current_semester`, `sslc_ggregate`, `12th_diploma_aggregate`, `ug_aggregate`, `pg_ggregate`, `current_backlogs`, `history_of_backlogs`,`detained_years`, `annual_income`  FROM `placement_students_profile`
           WHERE `placement_students_profile`.`USN` = '$USN'"; {
        echo "<center>Data Updated successfully...!!</center>";
      }
    } else echo "<center>NO record found for update</center>";
  } else
    echo "<center>enter your usn only</center>";
}
mysqli_close($conn);

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "placement_assistance";

// Create connection
$conn = new mysqli("localhost", "root","", "placement_assistance");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM `placement_students_profile` WHERE student_id = " . $_SESSION['student_id'];
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
  }
} else {
  echo "0 results";
}
$sql = "SELECT `first_name`, `last_name`, `USN`, `register_umber`, `department_id`, `phone`, `mail`, `date_of_birth`, `current_semester`, `sslc_ggregate`, `12th_diploma_aggregate`, `ug_aggregate`, `pg_ggregate`, `current_backlogs`, `history_of_backlogs`,`detained_years`, `annual_income`  FROM `placement_students_profile` WHERE USN = " . $_POST['USERNAME'] ;
if (isset($_POST['update']) || isset($_POST['USERNAME']))
{ 
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
   // $sql = mysqli_query($conn,"SELECT * FROM `placement`.`studentprofile` WHERE `USN`='hms345'");
    $upd = "UPDATE `studentprofile` SET `first_name` = '$fname', `last_name` ='$lname' , `phone` = '$phno', `mail` = '$email', `date_of_Birth` = '$date', `current_semester` = '$cursem', `department_id` = '$branch', `sslc_aggregate` = '$per', `12th_diploma_aggregate` = '$puagg', `ug_aggregate` = '$beaggregate', `pg_aggregate` = '$pgaggregate', `current_backlogs` = '$back', `history_of_backlogs` = '$hisofbk', `detained_years` ='$detyear', `annual_income` = '$income'      
	 WHERE `placement_students_profile`.`USN` = '$USN' ";
		   if (mysqli_query($conn, $upd)) {
			   echo "Record upated";
		   } else {
			   echo "Error" .mysqli_error($conn);
		   }
		}	
          mysqli_close($conn);
          ?>
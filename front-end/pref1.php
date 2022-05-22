<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "placement";
$row = "";
// Create connection
$conn = new mysqli("localhost", "root","", "placement_assistance");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM `placement_students_profile` WHERE USN = '".$_SESSION['username']."'" ;
$result = $conn->query($sql);

// Associative array
$row = $result->fetch_assoc();
//printf ("%s (%s)\n", $row["last_name"], $r);

// Free result set
$result->free_result();


if (isset($_POST['submit']))
{ 
$fname = $_POST['Fname'];
$lname = $_POST['Lname'];
$USN = $_SESSION['username'];
$REGNO = $_POST['RegNo'];
$phno = $_POST['Num'];
$email = $_POST['Email'];
$date = $_POST['DOB'];
$cursem = $_POST['Cursem'];
print_r($_POST['Branch']);
$branch = $_POST['Branch'];
$per = $_POST['Percentage'];
$puagg = $_POST['Puagg'];
$beaggregate = $_POST['Beagg'];
$pgaggregate = $_POST['Pgagg'];
$back = $_POST['Backlogs'];
$hisofbk = $_POST['History']; 
$detyear = $_POST['Dety'];
$income = $_POST['income'];  
if($USN !=''||$email !='')
{
$sql = "INSERT INTO `placement_students_profile` ( `first_name`, `last_name`, `USN`, `register_number`, `department_id`, `phone`, `mail`, `date_of_birth`, `current_semester`, `sslc_aggregate`, `12th_diploma_aggregate`, `ug_aggregate`, `pg_aggregate`, `current_backlogs`, `history_of_backlogs`,`detained_years`, `annual_income`)
	     VALUES ('$fname', '$lname', '$USN', '$REGNO', '$branch', '$phno', '$email', '$date', '$cursem', '$per', '$puagg', '$beaggregate', '$pgaggregate', '$back', '$hisofbk', '$detyear', '$income')";
if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}
}

$conn->close();
?>


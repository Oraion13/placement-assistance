<?php
	session_start();
	$username = $_POST['username'];
	$password  = $_POST['password'];
	
	if ($username&&$password)
	{
		$connect = mysqli_connect("localhost","root","") or die("Couldn't Connect");
		mysqli_select_db($connect,"placement_assistance") or die("Cant find DB");
		
		$query = mysqli_query($connect,"SELECT * FROM slogin WHERE USN='$username'");
		
		$numrows = mysqli_num_rows($query);
		
		if ($numrows!=0)
		{
			while($row = mysqli_fetch_assoc($query))
			{
				// print_r($row);
			if ($username == $row['USN'] && password_verify($password, $row['PASSWORD']))
			{
				  echo "<center>Login Successfull..!! <br/>Redirecting you to HomePage! </br>If not Goto <a href='index.php'> Here </a></center>";
				$_SESSION['username'] = $row['USN'];
				header('location: ./studprofile.php');
				//$_SESSION['Name'] = mysqli_query("SELECT Name FROM slogin WHERE USN='$username'");
			} else{
				header('location: ./index.php');
				
			
  			 echo "<script type='text/javascript'>alert(incorrecr usn or passwaord);</script>";
			//echo "<center>Redirecting you back to Login Page! If not Goto <a href='index.php'> Here </a></center>";
			// echo "<meta http-equiv='refresh' content ='1; url=index.php'>";
			}
		}
			die("User not exist");
	}
}
	else
	die("Please enter USN and Password");
	?>
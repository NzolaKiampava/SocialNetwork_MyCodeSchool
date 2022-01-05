<?php 

include("includes/connection.php");

	if (isset($_POST['sign_up'])) {
		# code...
		$first_name = htmlentities(mysqli_real_escape_string($con, $_POST['first_name'])); #taking the data, in security propose
		$last_name  = htmlentities(mysqli_real_escape_string($con, $_POST['last_name'])); 
		$pass       = htmlentities(mysqli_real_escape_string($con, $_POST['u_pass'])); 
		$email      = htmlentities(mysqli_real_escape_string($con, $_POST['u_email'])); 
		$country    = htmlentities(mysqli_real_escape_string($con, $_POST['u_country'])); 
		$gender     = htmlentities(mysqli_real_escape_string($con, $_POST['u_gender'])); 
		$birthday   = htmlentities(mysqli_real_escape_string($con, $_POST['u_birthday'])); 
		$status     = "verified";
		$posts      = "NO";
		$newgid     = sprintf('%05d', rand(0, 999999)); #(newgenerateid)will generate random number among 0-999999

		$username   = strtolower($first_name . "_" . $last_name . "_" . $newgid); #the name of user after signup

		#verifying the username with respective email
		$check_username_query = "SELECT user_name from users where u_email = '$email'";
		$run_username = mysqli_query($con, $check_username_query);

		#verifying the password if is less than 9 char
		if (strlen($pass) < 9) {
			# code...
			echo "<script>alert('Password should be minimun 9 characters!')</script>";
			exit();  //allow you user to be permanent in the current page, allow him to stop there
		}

		#verifying all the email one by one
		$check_email = "SELECT * from users where user_email = 'email'";
		$run_email = mysqli_query($con, $check_email);
		$check = mysqli_num_rows($run_email);    #the numbers of rows of the table users in collumn of email

		if ($check == 1) { #if check is equal of any email from database
			# code...
			echo "<script>alert('Email already exist, please try using another email!')</script>";
			echo "<script>window.open('signup.php', '_self')</script>";
			exit();
		}


		/*$rand = rand(1, 3);  #random number between 1 to 3

		if ($rand == 1) 
			$profile_pic = "codingcafe1.png";
		elseif ($rand == 2) 
			$profile_pic = "codingcafe2.png";
		elseif ($rand == 3)
			$profile_pic = "user_gender_male.jpg";
		*/

		//$recovery_account = "Iwanttoputading intheuniverse.";
		$insert = "INSERT INTO users (f_name,l_name,user_name,describe_user,Relationship,user_pass,user_email,user_country,user_gender,user_birthday,user_cover,user_reg_date,status,posts,recovery_account)
		VALUES('$first_name','$last_name','$username','Hello MyCode School.This is my default status!','...','$pass','$email','$country','$gender','$birthday','oficial_default_cover.jpg',NOW(),'$status','$posts','Iwanttoputading intheuniverse')";

		$query = mysqli_query($con, $insert);

		if ($query) {
			# code...
			echo "<script>alert('Well Done $first_name, you are good to go.')</script>";
			echo "<script>window.open('signin.php', '_self')</script>";
		}
		else{
			echo "<script>alert('Registration failed, please try again!')</script>";
			echo "<script>window.open('signup.php', '_self')</script>";
		}
	}


?>
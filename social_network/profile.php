<!DOCTYPE html>
<?php
	session_start();
	include("includes/header.php");

	if (!isset($_SESSION['user_email'])) {
		header("location: index.php");
	}
?>
<html>
<head>
	<?php
		$user = $_SESSION['user_email'];
		$get_user = "SELECT * FROM users WHERE user_email = '$user'";
		$run_user = mysqli_query($con, $get_user);
		$row = mysqli_fetch_array($run_user);
		$user_name = $row['user_name'];
	?>
	<title><?php echo "$user_name";?></title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<style type="text/css">
	#cover-img{
		height: 400px;
		width: 100%;
	}
	#profile-img{
		position: absolute;
		top: 165px;
		left: 40px;
	}
	/*
	#update_profile{
		position: relative;
		top: -25px;
		cursor: pointer;
		left: 93px;
		border-radius: 4px;
		background-color: rgba(0,0,0,0.1);
		transform: translate(-50%, -50%);
	}*/
	#button_profile{
		position: absolute;
		top: 87%;
		left: 50%;
		cursor: pointer;
		transform: translate(-50%, -50%);
	}
	#own_posts{
		border: 5px solid #e6e6e6;
		padding: 40px 50px;
	}
	#post_img{

	}
</style>
<body>
<div class="row">
	<div class="col-sm-2">   <!-- giving a space-->
	</div>
	<div class="col-sm-8">
		<?php
			echo"
			<div>
				<div><img id='cover-img' class='img-rounded' src='cover/$user_cover' alt='cover'></div>
				<form action='profile.php?u_id=$user_id' method='post' enctype='multipart/form-data'>
					
					<ul class='nav pull-left' style='position:absolute;top:10px;left:40px;'>
						<li class='dropdown'>
							<button class='dropdown-toggle btn btn-default' data-toggle='dropdown'>Change Cover</button>
							<div class='dropdown-menu'>
								<center>
									<p>Click <strong>Select Cover</strong> and then click the <br> <strong>Update Cover</strong></p>
									<label class='btn btn-info'>Select Cover
									<input type='file' name='u_cover' size='40'/>
									</label><br><br>
									<button name='submit' class='btn btn-info'>Update Cover</button>
								</center>
							</div>
						</li>
					</ul>
				</form>
			</div>
			<div id='profile-img'>
				<label for='profile'><img src='users/$user_image' alt='Profile' class='img-circle' width='180px' height='185px'></label>
				<form action='profile.php?u_id='$user_id'' method='post' enctype='multipart/form-data'>
					<input id='profile' type='file' name='u_image' size='40'/>
					<!--<label id='update_profile'>Select Profile
					<input id='pr' type='file' name='u_image' size='40'/>
					</label>--><br><br>
					<button id='button_profile' name='update' class='btn btn-info'>Update Profile</button>
				</form>
			</div><br>
			";
		?>
		<?php

			#updating cover image

			if (isset($_POST['submit'])) {
				$u_cover = "";
				$image_tmp = "";
				if(isset($_FILES['u_cover']) && $_FILES['u_cover']['name']){

					if($_FILES['u_cover']['type'] == "image/jpeg" || $_FILES['u_cover']['type'] == "image/png"){
						$u_cover = $_FILES['u_cover']['name'];
						$image_tmp = $_FILES['u_cover']['tmp_name'];
						$random_number = rand(1,100); #random number between 1 to 100
						move_uploaded_file($image_tmp, "cover/$random_number.$u_cover");
						
					}else{
						echo "<script>alert('This file is not allowed. Try JPG or PNG file!')</script>";
						echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
						exit();
					}
					$update = "UPDATE users SET user_cover = '$random_number.$u_cover' WHERE user_id = '$user_id'";
					$run = mysqli_query($con, $update);

					if ($run){
						echo "<script>alert('Your Cover Updated')</script>";
						echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
					}

				}

				if($u_cover == ''){
					echo "<script>alert('Please Select Cover Image')</script>";
					echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
					exit();
				}
						
			}

		?>
	</div>
	<?php

		#updating profile image

		if (isset($_POST['update'])) {

			$u_image = "";
			$image_tmp = "";
			if(isset($_FILES['u_image']) && $_FILES['u_image']['name']){

				if($_FILES['u_image']['type'] == "image/jpeg" || $_FILES['u_image']['type'] == "image/png"){
					$u_image = $_FILES['u_image']['name'];
					$image_tmp = $_FILES['u_image']['tmp_name'];
					$random_number = rand(1,100); #random number between 1 to 100
					move_uploaded_file($image_tmp, "users/$random_number.$u_image");
					
				}else{
					echo "<script>alert('This file is not allowed. Try JPG or PNG file!')</script>";
					echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
					exit();
				}
				$update = "UPDATE users SET user_image = '$random_number.$u_image' WHERE user_id = '$user_id'";
				$run = mysqli_query($con, $update);

				if ($run){
					echo "<script>alert('Your Profile Updated')</script>";
					echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
				}

			}

			if($u_image == ''){
				echo "<script>alert('Please Select Profile Image on clicking on your profile image')</script>";
				echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
				exit();
			}
		}

	?>
	<div class="col-sm-2">
	</div>
</div>
<div class="row">
	<div class="col-sm-2">
	</div>
	<div class="col-sm-2" style="background-color: #e6e6e6; text-align: center; left: 0.9%; border-radius: 5px;">
		<?php
			echo "
				<center><h2><strong>About</strong></h2></center>
				<center><h4><strong>$first_name $last_name</strong></h4></center>
				<p><strong><i style='color:grey;'>$describe_user</i></strong></p><br>
				<p><strong>Relationship Status: </strong> $Relationship_status</p><br>
				<p><strong>Lives In: </strong> $user_country</p><br>
				<p><strong>Member Since: </strong> $register_date</p><br>
				<p><strong>Gender: </strong> $user_gender</p><br>
				<p><strong>Date of Birth: </strong> $user_birthday</p><br>
			";

		?>
	</div>
	<div class="col-sm-6">
		<!-- Display user posts-->
		<?php
			global $con;

			if (isset($_GET['u_id'])) {
				$u_id = $_GET['u_id'];
			}

			$get_posts = "SELECT * FROM posts WHERE user_id = '$u_id' ORDER BY 1 DESC LIMIT 5";
			$run_posts = mysqli_query($con, $get_posts);

			while ($row_posts = mysqli_fetch_array($run_posts)) {
				
				$post_id = $row_posts['post_id'];
				$user_id = $row_posts['user_id'];
				$content = $row_posts['post_content'];
				$upload_image = $row_posts['upload_image'];
				$post_date = $row_posts['post_date'];

				$user = "SELECT * FROM users WHERE user_id = '$user_id' AND posts = 'YES'";
				$run_user = mysqli_query($con, $user);
				$row_user = mysqli_fetch_array($run_user);

				$user_name = $row_user['user_name'];
				$user_image = $row_user['user_image'];

				//Now we will display the posts
				if ($content == "NO" && strlen($upload_image) >= 1) {
					echo "

					<div id='own_posts'>
						<div class='row'>
							<div class='col-sm-2'>
								<p><img src='users/$user_image' class='img-circle' width='90px' height='90px'></p>
							</div>
							<div class='col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
								<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
							</div>
							<div class='col-sm-4'>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-12'>
								<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
							</div>
						</div><br>
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>View</button></a>
						<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>
					</div><br>
					";
				}

				else if (strlen($content) >= 1 && strlen($upload_image) >= 1) {
					echo "

					<div id='own_posts'>
						<div class='row'>
							<div class='col-sm-2'>
								<p><img src='users/$user_image' class='img-circle' width='90px' height='90px'></p>
							</div>
							<div class='col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
								<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
							</div>
							<div class='col-sm-4'>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-12'>
								<p>$content</p>
								<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
							</div>
						</div><br>
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>View</button></a>
						<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>
					</div><br>
					";
				}

				else {
					echo "

					<div id='own_posts'>
						<div class='row'>
							<div class='col-sm-2'>
								<p><img src='users/$user_image' class='img-circle' width='90px' height='90px'></p>
							</div>
							<div class='col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
								<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
							</div>
							<div class='col-sm-4'>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-2'>
							</div>
							<div class='col-sm-6'>
								<h3><p>$content</p></h3>
							</div>
							<div class='col-sm-4'>
							</div><br>
						</div>
					
					";

					global $con;

					if (isset($_GET['u_id'])) {
						$user_id = $_GET['u_id'];
					}

					// verifying if the user is that which is loged in
					$get_posts = "SELECT user_email FROM users WHERE user_id = '$user_id'";
					$run_user = mysqli_query($con, $get_posts);
					$row = mysqli_fetch_array($run_user);

					$user_email = $row['user_email'];

					$user = $_SESSION['user_email'];
					$get_user = "SELECT * FROM users WHERE user_email = '$user'";
					$run_user = mysqli_query($con, $get_user);
					$row = mysqli_fetch_array($run_user);

					$user_id = $row['user_id'];
					$u_email = $row['user_email'];

					//if the user try to change the value of url link to another userid
					if ($u_email != $user_email) {
						//he will get is own userid, not allow him to see to another one userid
						echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
					}else{
						echo "
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>View</button></a>
						<a href='edit_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Edit</button></a>
						<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>
						</div><br>
						";
					}
				}

				include("functions/delete_post.php");
			}
		?>
	</div>
	<div class="col-sm-2">
	</div>
</div>
</body>
</html>
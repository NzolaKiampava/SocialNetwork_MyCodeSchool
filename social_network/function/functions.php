<?php
$con = mysqli_connect('localhost', 'root', '', 'social_network') or die("Connection was not established");  #conecting to the database
	
	#Function for inserting posts
	function insertPost() {
		if (isset($_POST['sub'])) {
			global $con;
			global $user_id;

			$content = htmlentities($_POST['content']);

			$upload_image = $_FILES['upload_image']['name'];
			$image_tmp = $_FILES['upload_image']['tmp_name'];
			
			$random_number = rand(1, 100);

			if (strlen($content) > 250) {
				echo "<script>alert('Please use 250 or less than 260 words!')</script>";
				echo "<script>window.open('home.php', '_self')</script>";
			}
			else{
				if(strlen($upload_image) >= 1 && strlen($content)) {   #if the user select an image and type content
					move_uploaded_file($image_tmp, "imagepost/$random_number.$upload_image");

					$insert = "INSERT INTO posts (user_id, post_content, upload_image, post_date) values('$user_id', '$content', '$random_number.$upload_image', NOW())";

					$run = mysqli_query($con, $insert);

					if($run){
						echo "<script>alert('Your Post Updated a moment ago!')</script>";
						echo "<script>window.open('home.php', '_self')</script>";

						$update = "UPDATE users SET posts = 'YES' WHERE user_id = '$user_id'";
						$run_update = mysqli_query($con, $update);
					}
					exit();
				}
				else{
					if($upload_image == '' && $content == ''){ #if users dont select image and content on clicking post button
						echo "<script>alert('Error Occured while uploading!')</script>";
						echo "<script>window.open('home.php', '_self')</script>";
					}
					else{
						if($content == ''){ #if users dont type an content, just image
							move_uploaded_file($image_tmp, "imagepost/$random_number.$upload_image");

							$insert = "INSERT INTO posts (user_id, post_content, upload_image, post_date) values('$user_id', 'NO', '$random_number.$upload_image', NOW())";

							$run = mysqli_query($con, $insert);

							if($run){
								echo "<script>alert('Your Post Updated a moment ago!')</script>";
								echo "<script>window.open('home.php', '_self')</script>";

								$update = "UPDATE users SET posts = 'YES' WHERE user_id = '$user_id'";
								$run_update = mysqli_query($con, $update);
							}
							exit();
						}
						else{ #if users dont select an image, just content
							$insert = "INSERT INTO posts (user_id, post_content, post_date) values('$user_id', '$content', NOW())";

							$run = mysqli_query($con, $insert);

							if($run){
								echo "<script>alert('Your Post Updated a moment ago!')</script>";
								echo "<script>window.open('home.php', '_self')</script>";

								$update = "UPDATE users SET posts = 'YES' WHERE user_id = '$user_id'";
								$run_update = mysqli_query($con, $update);
							}
							exit();
						}
					}	
				}
			}
		}
	}

	#FUNCTION TO DISPLAY POSTS
	function get_posts(){
		global $con;
		$per_page = 4; #for each page only 4 posts ou seja quantidade de itens por cada pagina

		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}else{
			$page = 1;
		}

		$start_from = ($page - 1) * $per_page;

		$get_posts = "SELECT * FROM posts ORDER BY 1 DESC LIMIT $start_from, $per_page";
		$run_posts = mysqli_query($con, $get_posts);

		## taking information posts from all each user
		while($row_posts = mysqli_fetch_array($run_posts)){

			$post_id = $row_posts['post_id'];
			$user_id = $row_posts['user_id'];
			$content = substr($row_posts['post_content'], 0,40); #we will just show 40 words for each post (0,40)
			$upload_image = $row_posts['upload_image'];
			$post_date = $row_posts['post_date'];

			#taking for each user their atributes on table users
			$user = "SELECT * FROM users WHERE user_id = '$user_id' AND posts = 'YES'";
			$run_user = mysqli_query($con, $user);
			$row_user = mysqli_fetch_array($run_user);

			$user_name = $row_user['user_name'];
			$user_image = $row_user['user_image'];

			//NOW DISPLAYING POSTS FROM DATABASE

			if($content=="NO" && strlen($upload_image) >= 1){
				echo"
				<div class='row'>
					<div class='col-sm-3'>
					</div>
					<div id='posts' class='col-sm-6'>
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
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
					</div>
					<div class='col-sm-3'>
					</div>
				</div><br><br>
				";
			}

			else if(strlen($content) >= 1 && strlen($upload_image) >= 1){
				echo"
				<div class='row'>
					<div class='col-sm-3'>
					</div>
					<div id='posts' class='col-sm-6'>
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
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
					</div>
					<div class='col-sm-3'>
					</div>
				</div><br><br>
				";
			}

			else{
				echo"
				<div class='row'>
					<div class='col-sm-3'>
					</div>
					<div id='posts' class='col-sm-6'>
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
								<h3><p>$content</p></h3>
							</div>
						</div><br>
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
					</div>
					<div class='col-sm-3'>
					</div>
				</div><br><br>
				";
			}
		}

		include("pagination.php");
	}
?>
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
	<title>Find New People</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">	
</head>
<body>
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-4"><!--giving space-->
		</div>
		<div class="col-sm-4">
			<form class="search_form" action="">
				<input type="text" placeholder="Search Friend" name="search_user">
				<button class="btn btn-info" type="submit" name="search_user_btn">Search</button>
			</form>
		</div><br>
		<div class="col-sm-4">
		</div><br><br><br>
	</div>
	<?php search_user();?>
</body>
</html>
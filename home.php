<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'social_media';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>PHP Test Demo</a></h1>
				<a href="home.php"><i class="fas fa-user-circle"></i>Home</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div> 
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
		</div>
		<div class="content">
		<?php 					
			$query = $con->prepare("SELECT * FROM `result` ORDER BY id DESC LIMIT 1");
			$query->execute();
	        $result = $query->get_result();
	        while($row = $result->fetch_assoc()){ 
		?>			
			<textarea class="form-control" cols="100" rows="5" id="textarea"><?php echo $row['text']; ?></textarea><br>
		<?php } ?>
			<button class="btn btn-warning" id="onclick">Publish</button>
		</div>
		<br>
		<div class="content">
			<h2><i class="fa fa-comments"></i> Comments..</h2>
		</div>
        <div class="content">
	    	<div class="entrycontent clearfix">
				<div class="detail">
					<h3 class="post-title" style="display:none;    text-align: justify;" id=show>
						<i class="fa fa-comments"></i>
						<span id="show1"></span>
						<hr>
					</h3>
                   
					<?php 
					
					$query = $con->prepare("SELECT * FROM result ORDER BY id DESC");
					$query->execute();
			        $result = $query->get_result();
			        while($row = $result->fetch_assoc()){ 
					?>
					<h3 class="post-title" style="    text-align: justify;">
						<i class="fa fa-comments"></i>
						<span> <?php echo $row['text']; ?></span>
						 <span style="color: red;font-size: 11px;"> (<?php 
						 	$date = new DateTime($row['date']);
                            echo $date->format('j F, Y, g:i A');
						?>)</span> 
					</h3>
					<hr>
	                <?php } ?>
	            </div>
	        </div>
	    </div>
<script>
var x=0;	
$(document).ready(function() {
var count = 0;
$('#onclick').on('click', function() {
 count++;
var textarea = $('#textarea').val();

if(textarea != ""){
	$.ajax({
		url: "insert_data.php",
		type: "POST",
		data: {
			textarea:textarea			
		},
		cache: false,
		success: function(dataResult){
            
            if(dataResult == "Inserted")
            {
                
                $('#textarea').html('');
                $('#textarea').append(textarea);            	
            }				
		}
	});
	}
	else{
		alert('Please fill text area !');
	}
});
});
</script>
	</body>
</html>

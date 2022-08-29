<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
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
			<textarea class="form-control" cols="100" rows="5" id="textarea" onclick="javascript:if($(this).val() == 'textarea') {$(this).val() = '';} return false;"></textarea><br>
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
					$DATABASE_HOST = 'localhost';
					$DATABASE_USER = 'root';
					$DATABASE_PASS = '';
					$DATABASE_NAME = 'social_media';
					$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
					if (mysqli_connect_errno()) {
						exit('Failed to connect to MySQL: ' . mysqli_connect_error());
					}

					$query = $con->prepare("SELECT * FROM result ORDER BY id DESC");
					$query->execute();
			        $result = $query->get_result();
			        while($row = $result->fetch_assoc()){ 
					?>
					<h3 class="post-title" style="    text-align: justify;">
						<i class="fa fa-comments"></i>
						<span> <?php echo $row['text']; ?></span>
						<!-- <span> (<?php 
						//$yrdata= strtotime($row['text']);
                        //echo date('d-M-Y', $yrdata); ?>)</span> -->
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
                $("#show").show();
                $('#show').html('');
                $('#show').append('<i class="fa fa-comments"></i><a href="#" id="show1">'+ textarea +'</a><hr>');
            	document.getElementById("textarea").value = "";
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

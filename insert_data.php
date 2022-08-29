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


$id    = $_SESSION['id'];
$text  = mysqli_real_escape_string($con, htmlspecialchars($_POST['textarea']));

$query = $con->prepare("INSERT INTO `result`(`user_id`, `text`) VALUES (?,?)");
$query->bind_param("ss", $id, $text);
if($query->execute())
{
  echo  'Inserted';
}else
{
  echo  'Not Inserted'; 
}

?>
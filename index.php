<?php
session_start();
include "connection.php";
?>
<?php 
if (isset($_SESSION['id'])) {
	header("location: home.php");
}
?>
<?php
if (isset($_POST['email'])) {
$email = mysqli_real_escape_string($conn , $_POST['email']);
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$checkmail = "SELECT * from users WHERE email = '$email'";
	$runcheck = mysqli_query($conn , $checkmail) or die(mysqli_error($conn));
	if (mysqli_num_rows($runcheck) > 0) {
		$played_on = date('Y-m-d H:i:s');
		$update = "UPDATE users SET played_on = '$played_on' WHERE email = '$email' ";
		$runupdate = mysqli_query($conn , $update) or die(mysqli_error($conn));
		$row = mysqli_fetch_array($runcheck);
			$id = $row['id'];
			$_SESSION['id'] = $id;
			$_SESSION['email'] = $row['email'];
		header("location: home.php");
	}
	else {
		$played_on = date('Y-m-d H:i:s');
	$query = "INSERT INTO users(email,played_on) VALUES ('$email','$played_on')";
	$run = mysqli_query($conn, $query) or die(mysqli_error($conn)) ;
	if (mysqli_affected_rows($conn) > 0) {
		$query2 = "SELECT * FROM users WHERE email = '$email' ";
		$run2 = mysqli_query($conn , $query2) or die(mysqli_error($conn));
		if (mysqli_num_rows($run2) > 0) {
			$row = mysqli_fetch_array($run2);
			$id = $row['id'];
			$_SESSION['id'] = $id;
			$_SESSION['email'] = $row['email'];
			header("location: home.php");
		}
}
	else {
		echo "<script> alert('something is wrong'); </script>";
	}
}
}
else {
	echo "<script> alert('Invalid Email'); </script>";
}
}



?>
<html>
	<head>
		<title>Quiz</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<style>
		

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

header {
    background: #333;
    color: #fff;
    padding-top: 30px;
    min-height: 70px;
    border-bottom: #77aaff 3px solid;
}

header h1 {
    text-align: center;
    margin: 0;
    font-size: 36px;
    letter-spacing: 2px;
}

header a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    margin: 0 10px;
    padding: 5px 10px;
    background: #77aaff;
    border-radius: 5px;
}

header a:hover {
    background: #5588ee;
}

main {
    background: #fff;
    padding: 30px;
    margin-top: 30px;
    box-shadow: 0 0 10px #ccc;
}

main h2 {
    text-align: center;
    font-size: 28px;
    color: #333;
}

form {
    text-align: center;
    margin-top: 20px;
}

input[type="email"] {
    padding: 10px;
    width: 300px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 18px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #77aaff;
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 18px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #5588ee;
}

footer {
    background: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    margin-top: 30px;
}

footer p {
    margin: 0;
}

		</style>

	<body>
		<header>
			<div class="container">
				<h1>Quiz</h1>
				<a href="index.php" class="start">Home</a>
				<a href="admin.php" class="start">Admin Panel</a>

			</div>
		</header>

		<main>
		<div class="container">
				<h2>Enter Your Email</h2>
				<form method="POST" action="">
				<input type="email" name="email" required="" >
				<input type="submit" name="submit" value="PLAY NOW">

			</div>


		</main>

		<footer>
			<div class="container">
				Copyright @2024 Quiz
			</div>
		</footer>

	</body>
</html>
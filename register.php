<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>

<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f9;
			color: #333;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
		}

		h1 {
			text-align: center;
			color: #2c3e50;
			margin-bottom: 50px;
			margin-right: 100;
		}

		form {
			background-color: #fff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			width: 100%;
			max-width: 400px;
		}

		form p {
			margin-bottom: 15px;
		}

		label {
			display: block;
			margin-bottom: 5px;
			font-weight: bold;
			color: #2c3e50;
		}

		input[type="text"],
		input[type="password"] {
			width: 100%;
			padding: 10px;
			margin-top: 5px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 1em;
			box-sizing: border-box;
		}

		input[type="submit"] {
			background-color: #3498db;
			color: #fff;
			padding: 10px 15px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 1em;
		}

		input[type="submit"]:hover {
			background-color: #2980b9;
		}

		/* Success and Error Messages */
		h1[style*="color: green"] {
			text-align: center;
			font-size: 1.2em;
		}

		h1[style*="color: red"] {
			text-align: center;
			font-size: 1.2em;
		}
	</style>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<h1>Register here!</h1>
	<?php  
	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

		if ($_SESSION['status'] == "200") {
			echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
		}

		else {
			echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
		}

	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username">
		</p>
		<p>
			<label for="username">First Name</label>
			<input type="text" name="first_name">
		</p>
		<p>
			<label for="username">Last Name</label>
			<input type="text" name="last_name">
		</p>
		<p>
			<label for="username">Password</label>
			<input type="password" name="password">
		</p>
		<p>
			<label for="username">Confirm Password</label>
			<input type="password" name="confirm_password">
			<input type="submit" name="insertNewUserBtn" style="margin-top: 25px;">
		</p>
		<p>Don't have an account? You may login <a href="login.php">here</a></p>
</body>
	</form>
</body>
</html>
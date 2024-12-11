
<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>

<style>
		/* General Styles */
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f9;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		/* Form Container */
		.container {
			display: flex;
			flex-direction: row;
			align-items: center;
			background-color: #f4f4f9;
		}

		.container h1 {
			margin-right: 50px;
			color: #2c3e50;
			font-size: 24px;
			margin-right: 100;
		}

		form {
			background-color: #fff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			width: 300px;
		}

		label {
			display: block;
			font-size: 14px;
			margin-bottom: 5px;
			font-weight: bold;
			color: #333;
		}

		input[type="text"],
		input[type="password"] {
			width: 100%;
			padding: 10px;
			margin-bottom: 15px;
			border: 1px solid #ddd;
			border-radius: 4px;
			box-sizing: border-box;
			font-size: 14px;
		}

		input[type="submit"] {
			width: 100%;
			padding: 10px;
			background-color: #007bff;
			color: #fff;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
			margin-top: 10px;
		}

		input[type="submit"]:hover {
			background-color: #0056b3;
		}

		p {
			
			margin-top: 15px;
			font-size: 14px;
		}

		p a {
			color: #007bff;
			text-decoration: none;
		}

		p a:hover {
			text-decoration: underline;
		}

		h1{
			margin-right: 100;
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
	<h1>Login Now!</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username">
		</p>
		<p>
			<label for="username">Password</label>
			<input type="password" name="password">
			<input type="submit" name="loginUserBtn" style="margin-top: 25px; ">
		</p>

			<p>Don't have an account? You may register <a href="register.php">here</a></p>
	</form>

</body>
</html>
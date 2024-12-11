<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$addToAlbum = isset($_POST['addToAlbum']) ? $_POST['addToAlbum'] : 'no';
$getAllPhotos = getAllPhotos($pdo); 
?>

<style>
	/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

h1, h2, h4 {
    margin: 0;
    padding: 0;
}

a {
    text-decoration: none;
    color: #3498db;
}

a:hover {
    text-decoration: underline;
}

/* Navbar */
nav {
    background-color: #333;
    color: #fff;
    padding: 10px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav a {
    color: #fff;
    margin: 0 10px;
}

/* Forms */
form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

form p {
    margin: 10px 0;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"], input[type="file"], select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

input[type="submit"] {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #2980b9;
}

/* Photo Container */
.images {
    display: flex;
    justify-content: center;
    margin: 25px 0;
}

.photoContainer {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 50%;
}

.photoContainer img {
    width: 100%;
    display: block;
}

.photoDescription {
    padding: 20px;
    text-align: center;
}

.photoDescription h2 {
    margin-bottom: 10px;
}

.photoDescription p {
    color: #666;
    margin: 5px 0;
}

.photoDescription a {
    display: inline-block;
    margin-top: 10px;
    font-size: 14px;
    font-weight: bold;
}

/* Responsive Design */
@media (max-width: 768px) {
    .photoContainer {
        width: 90%;
    }

    form {
        padding: 15px;
    }
}

</style>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="stylesheet" href="styles/styles.css">
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
	<?php include 'navbar.php'; ?>
	<form action="" method="POST" enctype="multipart/form-data">
	    <p>
	        <label for="addToAlbum">Would you like to create an album?</label>
	        <select id="addToAlbum" name="addToAlbum" onchange="this.form.submit()">
	            <option value="no" <?php echo $addToAlbum === 'no' ? 'selected' : ''; ?>>No</option>
	            <option value="yes" <?php echo $addToAlbum === 'yes' ? 'selected' : ''; ?>>Yes</option>
	        </select>
	    </p>
	</form>

	<form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
	    <?php if ($addToAlbum === 'yes'): ?>
	        <p>
	            <label for="albumName">Album Name</label>
	            <input type="text" name="albumName" placeholder="Enter album name">
	        </p>
	        <p>
	            <label for="photoDescription">Description</label>
	            <input type="text" name="albumDescription" placeholder="Album description">
	        </p>
	        <p>
	            <label for="photos">Upload Photos</label>
	            <input type="file" name="photos[]" multiple>
	        </p>
	    <?php else: ?>
	        <p>
	            <label for="photoDescription">Description</label>
	            <input type="text" name="photoDescription" placeholder="Photo description">
	        </p>
	        <p>
	            <label for="singlePhoto">Upload Photo</label>
	            <input type="file" name="image">
	        </p>
	    <?php endif; ?>
	    <input type="hidden" name="addToAlbum" value="<?php echo $addToAlbum; ?>">
	    <input type="submit" name="insertPhotoBtn" value="Publish" style="margin-top: 10px;">
	</form>

	<?php foreach ($getAllPhotos as $row): ?>
	    <div class="images" style="display: flex; justify-content: center; margin-top: 25px;">
	        <div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">

	            <img src="images/<?php echo $row['photo_name']; ?>" alt="" style="width: 100%;">

	            <div class="photoDescription" style="padding:25px;">
	                <a href="profile.php?username=<?php echo $row['username']; ?>">
	                    <h2><?php echo $row['username']; ?></h2>
	                </a>
	                <p><i><?php echo $row['date_added']; ?></i></p>

	                <?php if (!empty($row['album_id'])): ?>
	                    <?php $albumDetails = getAlbumDetails($pdo, $row['album_id']); ?>
	                    <?php if ($albumDetails): ?>
	                        <h4><?php echo htmlspecialchars($albumDetails['album_name']); ?></h4>
	                        <p><?php echo htmlspecialchars($albumDetails['album_description']); ?></p>
	                    <?php endif; ?>
	                <?php else: ?>
	                    <h4><?php echo htmlspecialchars($row['description']); ?></h4>
	                <?php endif; ?>

	                <?php if ($_SESSION['username'] == $row['username']): ?>
	                    <a href="editphoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Edit </a>
	                    <br><br>
	                    <a href="deletephoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Delete</a>
	                <?php endif; ?>
	            </div>
	        </div>
	    </div>
	<?php endforeach; ?>

</body>
</html>
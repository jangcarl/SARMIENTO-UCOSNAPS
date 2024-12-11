
<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$addToAlbum = isset($_POST['addToAlbum']) ? $_POST['addToAlbum'] : 'no'; 
$getPhotoByID = getPhotoByID($pdo, $_GET['photo_id']); 
$albums = getAllAlbums($pdo, $_SESSION['username']);
?>


<style>
	/* General Styles */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #eef2f7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.editPhotoForm {
    width: 100%;
    max-width: 550px;
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    margin-top: 20px;
    animation: fadeIn 0.3s ease-in-out;
}

/* Form Header */
.editPhotoForm h1 {
    text-align: center;
    color: #333333;
    margin-bottom: 20px;
    font-size: 24px;
}

/* Labels and Inputs */
.editPhotoForm label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 8px;
    color: #555;
}

.editPhotoForm input[type="text"],
.editPhotoForm input[type="file"],
.editPhotoForm select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    transition: all 0.3s ease-in-out;
    box-sizing: border-box;
}

.editPhotoForm input[type="text"]:focus,
.editPhotoForm input[type="file"]:focus,
.editPhotoForm select:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

/* Submit Button */
.editPhotoForm input[type="submit"] {
    width: 100%;
    padding: 14px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

.editPhotoForm input[type="submit"]:hover {
    background-color: #0056b3;
    transform: translateY(-1px);
}

/* Dropdown and File Input */
.editPhotoForm select,
.editPhotoForm input[type="file"] {
    background-color: #f9f9f9;
}

.editPhotoForm select:hover {
    background-color: #f1f1f1;
}

/* Navbar Styles */
nav {
    background-color: #1a1a2e;
    padding: 10px 20px;
    text-align: center;
    position: absolute;
    top: 0;
    width: 100%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 10;
}

nav a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    font-size: 16px;
}

nav a:hover {
    text-decoration: underline;
}

/* Success and Error Messages */
.editPhotoForm .success-message {
    color: #28a745;
    font-size: 14px;
    text-align: center;
    margin-bottom: 15px;
}

.editPhotoForm .error-message {
    color: #dc3545;
    font-size: 14px;
    text-align: center;
    margin-bottom: 15px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .editPhotoForm {
        padding: 20px;
    }

    .editPhotoForm h1 {
        font-size: 20px;
    }

    nav a {
        font-size: 14px;
        margin: 0 10px;
    }
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="editPhotoForm">
        <form action="" method="POST" enctype="multipart/form-data">
            <p>
                <label for="addToAlbum">Do you want to add this photo to an album?</label>
                <select id="addToAlbum" name="addToAlbum" onchange="this.form.submit()">
                    <option value="no" <?php echo $addToAlbum === 'no' ? 'selected' : ''; ?>>No</option>
                    <option value="yes" <?php echo $addToAlbum === 'yes' ? 'selected' : ''; ?>>Yes</option>
                </select>
            </p>
        </form>
		<form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
	    <?php if ($addToAlbum === 'no'): ?>
	        <p>
	            <label for="photoDescription">Description</label>
	            <input type="text" name="photoDescription" value="<?php echo $getPhotoByID['description']; ?>" placeholder="Enter photo description">
	        </p>
	        <p>
	            <label for="singlePhoto">Upload Photo</label>
	            <input type="file" name="image">
	        </p>
	    <?php else: ?>
	        <p>
	            <label for="album">Assign to Album</label>
	            <select name="album_id">
	                <option value="">No Album</option>
	                <?php foreach ($albums as $album) { ?>
	                    <option value="<?php echo $album['album_id']; ?>" 
	                        <?php echo $getPhotoByID['album_id'] == $album['album_id'] ? 'selected' : ''; ?>>
	                        <?php echo htmlspecialchars($album['album_name']); ?>
	                    </option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
	            <label for="photos">Upload Photo</label>
	            <input type="file" name="image">
	        </p>
	    <?php endif; ?>

	    <input type="hidden" name="addToAlbum" value="<?php echo $addToAlbum; ?>">
	    <input type="hidden" name="photo_id" value="<?php echo $_GET['photo_id']; ?>">
	    <input type="submit" name="updatePhotoBtn" value="Update" style="margin-top: 10px;">
	</form>
    </div>
</body>
</html>
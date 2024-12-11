<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<?php  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<?php 
$album_id = $_GET['album_id'];
$getAlbumByID = getAlbumByID($pdo, $album_id);
?>

<style>
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

/* Navbar Styling (if needed) */
nav {
    background-color: #333;
    color: white;
    padding: 10px;
    text-align: center;
}

nav a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
}

nav a:hover {
    text-decoration: underline;
}

/* Edit Album Form Container */
.editAlbumForm {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 50vh;
}

/* Form Container */
.formContainer {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 50%;
}

.formContainer h2 {
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

/* Input Fields */
input[type="text"], 
input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
}

/* Input Submit Button */
input[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Placeholder Styles */
input::placeholder {
    color: #aaa;
}

/* Error or Success Messages */
p {
    color: #666;
    text-align: center;
}

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="editAlbumForm" style="display: flex; justify-content: center;">
        <div class="formContainer" style="width: 50%; border: 1px solid #ddd; padding: 20px;">
            <h2>Edit Album</h2>
            <?php if ($getAlbumByID): ?>
                <form action="core/handleForms.php" method="POST">
                    <input type="hidden" name="album_id" value="<?php echo $getAlbumByID['album_id']; ?>">
                    <p>
                        <label for="album_name">Album Name</label>
                        <input type="text" name="album_name" value="<?php echo htmlspecialchars($getAlbumByID['album_name']); ?>" placeholder="Enter album name" required>
                    </p>
                    <p>
                        <label for="album_description">Album Description</label>
                        <input type="text" name="album_description" value="<?php echo htmlspecialchars($getAlbumByID['album_description']); ?>" placeholder="Enter album description">
                    </p>
                    <input type="submit" name="editAlbumBtn" value="Update" style="margin-top: 10px;">
                </form>
            <?php else: ?>
                <p>Album not found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
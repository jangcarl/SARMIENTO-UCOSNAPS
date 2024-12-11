
<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$albums = getAllAlbums($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albums</title>
    <link rel="stylesheet" href="styles/styles.css">
    <style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
    }

    h1, h2 {
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

    /* Album Container */
    .album-container {
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 90%;
    }

    .album-header h2 {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .album-description p {
        color: #7f8c8d;
        font-style: italic;
        margin-bottom: 10px;
    }

    .edit-delete-buttons {
        position: absolute;
        bottom: 10px;
        right: 10px;
        font-size: 0.9em;
    }

    .edit-delete-buttons a {
        color: #e74c3c;
        margin-right: 10px;
    }

    .edit-delete-buttons a:hover {
        text-decoration: underline;
    }

    /* Photo Gallery */
    .photo-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
    }

    .photo-container {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        width: calc(25% - 15px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .photo-container:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .photo-container img {
        width: 100%;
        border-radius: 4px;
    }

    .photo-description {
        margin-top: 10px;
        font-size: 0.9em;
        color: #7f8c8d;
    }

    .photo-description a {
        color: #3498db;
        font-size: 0.9em;
    }

    .photo-description a:hover {
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .album-container {
            max-width: 100%;
        }

        .photo-container {
            width: calc(50% - 15px);
        }
    }

    @media (max-width: 480px) {
        .photo-container {
            width: 100%;
        }
    }
</style>

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
    <?php foreach ($albums as $album): ?>
        <?php
        $photos = getAllPhotosByAlbum($pdo, $album['album_id']);
        
        if (count($photos) > 0): ?>
            <div class="album-container" style="position: relative;">
                <div class="album-header">
                    <h2><?php echo htmlspecialchars($album['username']); ?>'s Album: <?php echo htmlspecialchars($album['album_name']); ?></h2>
                </div>
                <div class="album-description">
                    <p><i><?php echo htmlspecialchars($album['album_description']); ?></i></p>
                </div>

                <?php if ($_SESSION['username'] == $album['username']): ?>
                    <div class="edit-delete-buttons">
                        <a href="editalbum.php?album_id=<?php echo $album['album_id']; ?>" style="margin-right: 10px;">Edit Album</a> |
                        <a href="deletealbum.php?album_id=<?php echo $album['album_id']; ?>">Delete Album</a>
                    </div>
                <?php endif; ?>

                <div class="photo-gallery">
                    <?php foreach ($photos as $photo): ?>
                        <div class="photo-container">
                            <img src="images/<?php echo $photo['photo_name']; ?>" alt="Photo" style="width: 100%;">
                            <div class="photo-description">
                                <p><i>Uploaded on: <?php echo $photo['date_added']; ?></i></p>
                                <?php if ($_SESSION['username'] == $photo['username']) { ?>
                                    <a href="editphoto.php?photo_id=<?php echo $photo['photo_id']; ?>">Edit</a> |
                                    <a href="deletephoto.php?photo_id=<?php echo $photo['photo_id']; ?>">Delete</a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>
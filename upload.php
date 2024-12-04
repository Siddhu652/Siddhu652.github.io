<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<form action="upload.php" method="post">
            <input type="submit" name="fetch_data" value="Fetch Data" class="fetch-button">
            
        </form>
        <button class="fetch-button" onclick="window.location.href='index.html'">Go Back to Home</button>
        <div id="infoContainer"></div>
</body>
</html>


<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require("connection.php");
require_once("functions.php");

define('MIN_LAT', 40.6700);
define('MAX_LAT', 42.6900);
define('MIN_LNG', 20.6700);
define('MAX_LNG', 22.6900);



if(isset($_POST['validate'])){
    $user_id = $_POST['user_Id'];

    $_SESSION['user_id'] = $user_id;

    
    $latitude = filter_var($_POST['Latitude'], FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($_POST['longitude'], FILTER_VALIDATE_FLOAT);


    if (!$latitude || !$longitude) {
    echo "Invalid latitude or longitude.";
    exit;
    }


    $image_info = $_FILES['image_upload'];
    
    echo "User Latitude: $latitude<br>";
    echo "User Longitude: $longitude<br>";

    $image_name = $_FILES['image_upload']['name'];
    $image_tmp = $_FILES['image_upload']['tmp_name'];

    $imageData = file_get_contents($image_tmp); //used for database value


    $image_size = $_FILES['image_upload']['size'];
    $max_file_size = 1024 * 1024;

    $image_type = $_FILES['image_upload']['type'];
    $image_ext = explode("/", $image_type);
    $image_actual_one = strtolower(end($image_ext));

    $allowed_ext = array('jpg', 'jpeg', 'png');

    if(in_array($image_actual_one,$allowed_ext)){
        //continues
        if($_FILES['image_upload']['error'] === 0) {
            echo "<br>Validation Success...image has no errors<br>";
            if($image_size < $max_file_size){
                //continues
                echo "<br>Validation Success....file is in correct size<br>";
                if(isWithinRange($latitude, $longitude)){
                    echo "<br>Validation...values are within the range<br>";
                    $prepare_query = $pdo->prepare('INSERT INTO location_upload (user_id, latitude, longitude, image_file) values (:user_id, :latitude, :longitude, :image_file)');
                    $prepare_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $prepare_query->bindParam(':latitude', $latitude);
                    $prepare_query->bindParam(':longitude', $longitude);
                    $prepare_query->bindParam(':image_file', $imageData, PDO::PARAM_LOB);
                    if($prepare_query->execute()) {
                        echo "<br>Data successfully saved!<br>";
                    } else {
                        echo "<br>Database error<br>";
                    }
                }
                else{
                  echo "<br>Error: Your location is outside the allowed area.<br>";
                }
            }
            else{
                echo "<br>Error: The File is too large! <br> please upload a file size within 1MB<br>";
            }
        }
        else{
            echo "<br>Error: There was an error uploading the file<br>";
        }
    }
    else{
        echo "<br>Error :Please choose any one of these file types to upload :- .jpg, .jpeg, .png<br>";
    }

}






if (isset($_POST['fetch_data'])) {
    // Fetch user data from the database
    $query = $pdo->prepare('SELECT * FROM location_upload WHERE user_id = :user_id');
    $query->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Convert image to base64
        $imageData = base64_encode($result['image_file']);

        
        echo "<p><strong>Latitude:</strong> {$result['latitude']}</p>
            <p><strong>Longitude:</strong> {$result['longitude']}</p>
                        <p><strong>Date-Time :</strong> {$result['uploaded_timestamp']}</p>
            <img src='data:image; base64,$imageData' alt='Uploaded Image' style='max-width:700px; height:700px; background-size:cover; border-radius:10px;'>";
    } else {
        echo "<p>No data found for this user.</p>";
    }
}
?>



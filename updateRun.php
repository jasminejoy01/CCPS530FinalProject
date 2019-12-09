<?php 
    session_start();
    $servername = "localhost";
    $username = "jjoyport_dict_user";
    $password = "Temp123##!!";
    $dbname="jjoyport_dictionary";
      
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); }
    
    $def = addslashes($_POST["def"]);
    $imgURL = addslashes($_POST["img_url"]);
    $wavURL =addslashes($_POST["audio_url"]);
    $cap = addslashes($_POST["caption"]);
    $ID = $_POST["key"];
    
    $sql = "Update `wordTable` SET `definition` = '$def' , `image_url` = '$imgURL', `audio_url` = '$wavURL', `image_caption` = '$cap' WHERE `ID` = $ID";

    if ($conn->query($sql) === TRUE) {echo "Record Updated";} 
    else { echo $conn->error;}
    
    require("history.php");

?>



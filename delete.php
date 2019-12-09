<?php 

    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    
    $url.= $_SERVER['HTTP_HOST'];   
    $url.= $_SERVER['REQUEST_URI'];    
      
    $OriginalString = $url; 
    $id = (explode("=",$OriginalString)[1]); 


    $servername = "localhost";
    $username = "jjoyport_dict_user";
    $password = "Temp123##!!";
    $dbname="jjoyport_dictionary";
      
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); }
    
    $sql = "Delete from wordTable where ID = $id";
    if ($conn->query($sql) === TRUE) {echo "Record deleted";} 
    else { echo $conn->error;}
    
    require("history.php");

?>



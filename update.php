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
    
    $sql_word = "SELECT `ID`, `word`, `definition`, `image_url`, `audio_url`, `image_caption` FROM `wordTable` WHERE `ID` = $id";
    $result = $conn->query($sql_word);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
              $id = $row["ID"];
              $word = $row["word"];
              $def = str_replace(' ', "&nbsp;", $row["definition"]);
              $img_url =  addslashes($row['image_url']);
              $audio_url = $row["audio_url"];
              $caption = str_replace(' ', "&nbsp;", $row["image_caption"]);
                    };
    }    
    
    echo "<!DOCTYPE html>
<html lang='en'>
<title>Edit Mode: Update</title>
<div class='w3headerwithimage' style='background-image: url('download.jpg'); background-size: cover'>
    <h1>Update Record</h1> 
</div>

<head>  <meta name='viewport' content='width=device-width, initial-scale=1'>
  
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>
  <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js'></script>
	<style>
			body {font-family: Arial, Helvetica, sans-serif;}
			
			#myImg {
			border-radius: 5px;
			cursor: pointer;
			transition: 0.3s;
			}
			.popup {
              position: relative;
              display: inline-block;
              cursor: pointer;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
              }
        
              /* The actual popup */
              .popup .popuptext {
              visibility: hidden;
              width: 160px;
              background-color: #555;
              color: #fff;
              text-align: center;
              border-radius: 6px;
              padding: 8px 0;
              position: absolute;
              z-index: 1;
              bottom: 125%;
              left: 50%;
              margin-left: -80px;
              }

          /* Toggle this class - hide and show the popup */
          .popup .show {
            visibility: visible;
            -webkit-animation: fadeIn 1s;
            animation: fadeIn 1s;
            }
    
          /* Add animation (fade in the popup) */
          @-webkit-keyframes fadeIn {
            from {opacity: 0;} 
            to {opacity: 1;}
            }
    
          @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity:1 ;}
          }
            #myImg:hover {opacity: 0.7;}
			
			/* The Modal (background) */
			.modal {
			display: none; /* Hidden by default */
			position: fixed; /* Stay in place */
			z-index: 1; /* Sit on top */
			padding-top: 100px; /* Location of the box */
			left: 0;
			top: 0;
			width: 100%; /* Full width */
			height: 100%; /* Full height */
			overflow: auto; /* Enable scroll if needed */
			background-color: rgb(0,0,0); /* Fallback color */
			background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
			}
			
			/* Modal Content (image) */
			.modal-content {
			margin: auto;
			display: block;
			width: 80%;
			max-width: 700px;
			}
			
			/* Caption of Modal Image */
			#caption {
			margin: auto;
			display: block;
			width: 80%;
			max-width: 700px;
			text-align: center;
			color: #ccc;
			padding: 10px 0;
			height: 150px;
			}
			
			/* Add Animation */
			.modal-content, #caption {  
			-webkit-animation-name: zoom;
			-webkit-animation-duration: 0.6s;
			animation-name: zoom;
			animation-duration: 0.6s;
			}
			
			@-webkit-keyframes zoom {
			from {-webkit-transform:scale(0)} 
			to {-webkit-transform:scale(1)}
			}
			
			@keyframes zoom {
			from {transform:scale(0)} 
			to {transform:scale(1)}
			}
			
			/* The Close Button */
			.close {
			position: absolute;
			top: 15px;
			right: 35px;
			color: #f1f1f1;
			font-size: 40px;
			font-weight: bold;
			transition: 0.3s;
			}
			
			.close:hover,
			.close:focus {
			color: #bbb;
			text-decoration: none;
			cursor: pointer;
			}
			
			/* 100% Image Width on Smaller Screens */
			@media only screen and (max-width: 700px){
			.modal-content {
				width: 100%;
			}
			
			.table-layout {
                text-align: center;
                border: 1px solid black;
                border-collapse: collapse;
                font-family:'Trebuchet MS';
                margin: 0 auto 0;
            }
            .table-layout td, .table-layout th {
                border: 1px solid grey;
                padding: 5px 5px 0;
            }
            .table-layout td {
                text-align: left;
            }
            .selected {
                color: red;
			}
      }
	</style>
</head>

<div class='myNavBar w3-black'>
  <a href='home.php' class='w3-bar-item w3-button'>Home</a>
  <a href='history.php' class='w3-bar-item w3-button'>History</a>
</div>
<body>
    <div>
        <fieldset>
            <form action='updateRun.php' method='post'>
                <h2>".$id.", ".$word."</h2>
                <input type='hidden' id='key' name='key' value=".$id.">
                Definition:<br> 
                <input type='text' name='def' value=".addslashes($def).">  
                <br>
                Image URL: <br> 
                <input type='text'  name='img_url' value=".addslashes($img_url).">  
                 <br>
                Audio URL:<br>  
                <input type='text'  name='audio_url' value=".addslashes($audio_url).">  <br>
                Caption:<br> 
                <input type='text' name='caption' value=".addslashes($caption)."> 
                <br>  <br>                
                <input type = 'submit' value='Update Record'>
                <br>
            </form>
        </fieldset>
    </div>
</body>

<footer> <br> &copy; 2010-<?php echo date('Y');?>  </footer>
</html>";

?>


     
    

 
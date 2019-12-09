<?php 
    if($_POST['word']){  
      $word = $_POST['word'];
      $word = strtolower($word);
      
      $servername = "localhost";
        $username = "jjoyport_dict_user";
        $password = "Temp123##!!";
        $dbname="jjoyport_dictionary";
      
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); }
        
      $handle = curl_init();
      $key = "52bb8deb-6d3a-462c-907a-e8113d58aa7f";
      $url = "https://www.dictionaryapi.com/api/v3/references/collegiate/json/$word?key=".$key;

      // Set the url
      curl_setopt($handle, CURLOPT_URL, $url);
      // Set the result output to be a string.
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
      $output = curl_exec($handle);
      curl_close($handle);
      //convert json to array
      $arr = json_decode($output, true);

      $definition = $arr[0][shortdef][0];
      $capt = $arr[0][art][capt];
      $art = $arr[0][art][artid];
      $audio_url = "https://media.merriam-webster.com/soundc11/$word[0]/";
      $audio_file = $arr[0][hwi][prs][0][sound][audio].".wav";
      $audio_url = $audio_url.$audio_file;
      
      $image_url = "https://www.merriam-webster.com/assets/mw/static/art/dict/";
      $image_file = $arr[0][art][artid].".gif";
      $image_url = $image_url.$image_file;
    
      $sql_check = ("SELECT * FROM wordTable WHERE word = '$word'"); 
      $result = $conn->query($sql_check);
      
      if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rowcount=mysqli_num_rows($result);
                printf("Record exists. Found %d rows.\n",$row); 
            }
        } 
        else {
            echo "Found 0 results. \n";
            $sql = " INSERT INTO `wordTable` (`ID`, `word`, `definition`, `image_url`, `audio_url`, `image_caption`) VALUES ('', '$word', '$definition','$image_url', '$audio_url', '$capt');";
            if ($conn->query($sql) === TRUE) {
                 echo "New record created successfully";
                } else { 
                    echo $conn->error;} 
        }
}
?>

<!DOCTYPE html>
<html>
<title>Dictionary</title>
<div class="w3headerwithimage" style="background-image: url('download.jpg'); background-size: cover">
    <h1>Dictionary</h1> 
</div>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<meta http-equiv="X-UA-Compatible" content="ie=edge">

<div class="myNavBar w3-black">
  <a href="home.php" class="active" class="w3-bar-item w3-button">Home</a>
  <a href="history.php" class="w3-bar-item w3-button">History</a>
</div>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			body {font-family: Arial, Helvetica, sans-serif;}
			
			#myImg {
			border-radius: 5px;
			cursor: pointer;
			transition: 0.3s;
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
			}
		</style>
</head>

<body>
  <div class="w3-row">
    <div class="container">  
    <div class="w3-col w3-container m8 l9">  
    
        <div class="page-header">
          <div class="row">
            <div class="span8">
              <form action="home.php" method="post">
                <br>
                <b>Input Word: </b>
                <input type="text" class="span6" name="word" id="word" value="<?php echo$_POST['word'];?>">
                <input type="submit" value="Submit">
              </form>
              <br>
            </div>
          </div>
        </div>
      
        <div class="w3-col w3-container m8 l9">
              <fieldset>
                <?php 
                      $sql_check = ("SELECT ID, word, definition, image_url, audio_url, image_caption FROM wordTable WHERE word = '$word'");
                      $result = $conn->query($sql_check);
                      if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo " <div class='row'>
                              <p>Definition: <b> " . $row["definition"]. " </b>.</p>
                              <audio controls>
                                <source src=" . $row['audio_url']. " type='audio/wav'>
                                Your browser does not support the audio element.
                              </audio>
                                <style>
                        body {font-family: Arial, Helvetica, sans-serif;}
    
                        #myImg {
                          border-radius: 5px;
                          cursor: pointer;
                          transition: 0.3s;
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
                        }
                  </style>
                              <br>
                              <img id='myImg'  src=". $row['image_url'].">
                              <div id='myModal' class='modal'>
                                    <span class='close'>&times;</span>
                                    <img class='modal-content' id='img01'>
                                    <div id=" . $row['image_caption']. "></div>
                                </div>
                                <script>
                        var modal = document.getElementById('myModal');
                            var img = document.getElementById('myImg');
                            var modalImg = document.getElementById('img01');
                            var captionText = document.getElementById('caption');
                            img.onclick = function(){
                              modal.style.display = 'block';
                              modalImg.src = this.src;
                              captionText.innerHTML = this.alt;}
                            var span = document.getElementsByClassName('close')[0];
                            span.onclick = function() { 
                              modal.style.display = 'none';}
                    </script>
                                <h6>" . $row['image_caption']. "</h6>
                            </div>";
                            }
                      
                         $conn->close(); 
                      }
                     else {
                        if($_POST['word']){ 
                          echo("<div class='row'>
                              <p>Definition: <b> '$definition' </b>.</p>
                              <audio controls>
                                <source src='$audio_url' type='audio/wav'>
                                Your browser does not support the audio element.
                              </audio>
        
                              <style>
                                    body {font-family: Arial, Helvetica, sans-serif;}
                
                                    #myImg {
                                      border-radius: 5px;
                                      cursor: pointer;
                                      transition: 0.3s;
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
                                    }
                              </style>
                          <br>
                          <img id='myImg'  src=$image_url>
                            <div id='myModal' class='modal'>
                                <span class='close'>&times;</span>
                                <img class='modal-content' id='img01'>
                                <div id='$capt'></div>
                            </div>
                            <script>
                                var modal = document.getElementById('myModal');
                                    var img = document.getElementById('myImg');
                                    var modalImg = document.getElementById('img01');
                                    var captionText = document.getElementById('caption');
                                    img.onclick = function(){
                                      modal.style.display = 'block';
                                      modalImg.src = this.src;
                                      captionText.innerHTML = this.alt;}
                                    var span = document.getElementsByClassName('close')[0];
                                    span.onclick = function() { 
                                      modal.style.display = 'none';}
                            </script>
                            <h6>'$capt'.</h6>
                        </div>");    
                      }                     }
                ?>
              </fieldset>
              <footer> <br> &copy; 2010-<?php echo date("Y");?>  </footer>
          </div>
    </div>
    
    <div class="w3-col w3-container m4 l2">
    <h3 background-size="cover">About</h3>
    <p> This app works as a dictionary. Click on the images to expand.  </p>
  </div>
    </div>
  
    
  </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<title>Table</title>
<div class="w3headerwithimage" style="background-image: url('download.jpg'); background-size: cover">
    <h1>Table</h1> 
</div>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<style>
			body {font-family: Arial, Helvetica, sans-serif;
			    
			}
			.scrolldiv{
    overflow:scroll;
}
			
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

      /* Popup arrow */
      .popup .popuptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
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
                font-family:"Trebuchet MS";
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

<div class="myNavBar w3-black">
  <a href="home.php" class="w3-bar-item w3-button">Home</a>
  <a href="history.php" class="w3-bar-item w3-button">History</a>
</div>

<body>
  <div class="scrolldiv">      
    <br>
      <div class="w3-col">
          <fieldset>
              <?php 
                $servername = "localhost";
                $username = "jjoyport_dict_user";
                $password = "Temp123##!!";
                $dbname="jjoyport_dictionary";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error); }

                $sql = " SELECT ID, word, definition, image_url, audio_url, image_caption FROM wordTable";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<div class='table-responsive' >
                    
                    <table class='table-layout' border-collapse='collapse' id='display-table' >
                    <tr>
                    <th border-collapse='collapse'>ID</th>
                    <th border-collapse='collapse'>Word</th>
                    <th border-collapse='collapse'>Definition</th>
                    <th border-collapse='collapse'>Image</th>
                    <th border-collapse='collapse'>Audio</th>
                    <th border-collapse='collapse'>Image Caption</th>
                    <th border-collapse='collapse'>  </th>
                    <th border-collapse='collapse'>  </th>
                    </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr id=num_rows>
                        <td border-collapse='collapse' id = 'identify'>" . $row["ID"]. "</td>
                        <td border-collapse='collapse'>" . $row["word"]. "</td>
                        <td border-collapse='collapse'> <textarea rows='6' cols='30' wrap='hard'>" . $row["definition"]. "</textarea></td>
                        <td border-collapse='collapse'><img class='img-responsive' style='width:150px;height:150px' src='" . $row['image_url']. "'></td>
                        <td border-collapse='collapse'><audio controls>
                          <source src='" . $row["audio_url"]. "' type='audio/wav'>
                          Your browser does not support the audio element.
                          </audio>
                        </td>
                        <td border-collapse='collapse'>                       
                            <h6><textarea rows='6' cols='30' wrap='hard'>". $row["image_caption"]."</textarea></h6>
                        </td>
                        <td>
                            <a href='update.php?id=".$row["ID"]."' type='button' class='deletebtn' style='display:block; padding:4px'> Edit </a>
                        </td>
                        <td>
                            <a href='delete.php?id=".$row["ID"]."'  type='button' class='deletebtn' style='display:block; padding:4px'> Delete </a>
                        </td>
                        </tr>
                        ";
                    }
                    echo "</table>
                    </div>
                    <script>
                    $(document).ready(function() {
                     var bodyWidth = $(window).width();
                     $('.scrolldiv').css('width',bodyWidth);
                    });
                    </script>
                    ";
                    
                  } 
                else {
                    echo "0 results";
                  }
                $conn->close();
              ?>
          </fieldset>
          <footer> <br> &copy; 2010-<?php echo date("Y");?>  </footer>
      </div>
    </div>
  </div>


</body>

</html>

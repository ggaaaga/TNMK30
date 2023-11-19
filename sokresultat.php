<!DOCTYPE html>

<!--Grupp 14
Uppgift 1

Gayathri Naranath (gayna875)
Amar Beganovic (amabe923)
Todel Touma (todto213)
Filip Silversten Wärn (filsi640) -->

<html lang="en">
	<head>
	
		<meta charset="utf-8">
		<title>Search results</title>
		<link href="style.css" media="screen" rel="stylesheet" type="text/css"/>
		<script	src="script.js"></script>  
	
	</head>
	
	<body>
	
		<?php include "meny.txt" ?>
		<?php include "search.txt" ?>
		
		
		<?php
			
			//Ställ queryn
			$conn = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
			$search = $_GET['ftext'];
			
			if (is_numeric($search[0])) {
				
				$arg = "SetID LIKE '%$search%'";
				
			} else {
				
				$arg = "Setname LIKE '%$search%'";
			}
			
			$result = mysqli_query($conn, "SELECT * FROM  sets WHERE " . $arg  );
			
			
			//Visa resultaten
			echo "<div id= 'results'>";
			
				while ($row = mysqli_fetch_array($result)) {	

					$setname = $row['Setname'];
					$year = $row['Year'];
					$setid = $row['SetID'];
					
					//Hämta information om bilden från images mha setid
					$resultImg = mysqli_query($conn, "SELECT images.has_gif, images.has_jpg FROM images WHERE ItemID ='$setid' ");
					$ImgInfo = mysqli_fetch_array($resultImg);
					
					
					//Kolla vilket format bilden har
					if ($ImgInfo['has_gif']) {
						
						$filename = "S/$setid.gif";
						
					} else if ($ImgInfo['has_jpg']) {
						
						$filename = "S/$setid.jpg";
						
					} else { 
					
						$filename = "noimage_small.png";
					}
					
					//Visa bilderna på setten
					$ImgLink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
					
					$setnameurl = urlencode($setname); // Hämtades från https://www.php.net/urlencode och transformerar en string så den kan användas i en url
					
					echo //Lånad Kod för att passera information till nästa sida genom url:en https://stackoverflow.com/questions/31040459/hyperlinks-pass-data-to-next-page-in-php
						"<a href= 'bitsidan.php?SetID={$setid}&SetName={$setnameurl}' > 
							<div class= 'box'>
								<img src= \"$ImgLink$filename\" alt=\" Picture of Set\">
								<h3>$setname - $setid</h3> $year
							</div>
						</a>";
						
						
				}
				
			echo "</div>";
			
		?>
		
		
	</body>
	
</html>
	
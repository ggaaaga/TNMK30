<!DOCTYPE html>

<!--Grupp 14
Uppgift 1

Gayathri Naranath (gayna875)
Amar Beganovic (amabe923)
Todel Touma (todto213)
Filip Silversten Wärn (filsi640) -->

<html lang="en">
	<head >
		<meta charset="utf-8">
		<title>Set</title>
		<link href="style.css" media="screen" rel="stylesheet" type="text/css"/>
		<script	src="script.js"></script>
		
	</head>
    <body>
	
		<?php include "meny.txt" ?>
		<?php include "search.txt" ?>

		
		<?php 
		
			$conn = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
			$setid = $_GET['SetID'];
			$setname = $_GET['SetName'];
			
			//Bitar query
			$resultbit = mysqli_query($conn, "SELECT inventory.Quantity, inventory.ItemID, colors.Colorname, 
									parts.Partname, colors.ColorID FROM inventory, colors, parts WHERE inventory.SetID='$setid' 
									AND inventory.ItemtypeID='P' AND colors.ColorID=inventory.ColorID 
									AND parts.PartID=inventory.ItemID"); //Lånad kod från kurshemsidan
									
			
			//Minifigurer query
			$resultminifig = mysqli_query($conn, "SELECT inventory.Quantity, inventory.ItemID, minifigs.Minifigname FROM inventory, minifigs 
											WHERE inventory.SetID='$setid' AND inventory.ItemtypeID='M' 
											AND minifigs.MinifigID=inventory.ItemID");
			
			$resultImgset = mysqli_query($conn, "SELECT images.has_largegif, images.has_largejpg FROM images WHERE ItemID='$setid'");
			$ImgInfoset = mysqli_fetch_array($resultImgset);
			
			//Kolla vilket format bilden har
			if ($ImgInfoset['has_largegif']) {
					$filename = "SL/$setid.gif";
					
				} else if ($ImgInfoset['has_largejpg']) {
					
					$filename = "SL/$setid.jpg";
					
				} else { 
				
					$filename = "noimage_small.png"; 
				}
			
			echo "<div class='textbox' id='bitbox'>";
			$ImgLink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
			echo "<h1>{$setname}</h1> <img src= \"$ImgLink$filename\" alt=\" Picture of set\">";
			
			//Visa bitarna
			while ($row = mysqli_fetch_array($resultbit)){
				
				$quantity = $row['Quantity'];
				$colorname = $row['Colorname'];
				$colorid = $row['ColorID'];
				$partname = $row['Partname'];
				$itemid = $row['ItemID'];
				
				$resultImg = mysqli_query($conn, "SELECT images.has_gif, images.has_jpg, images.ItemTypeID FROM images WHERE ItemID='$itemid' AND ColorID='$colorid'");
				$ImgInfo = mysqli_fetch_array($resultImg);
				$itemtypeid = $ImgInfo['ItemTypeID'];
				
				//Kolla vilket format bilden har
				if ($ImgInfo['has_gif']) {
					$filename = "$itemtypeid/$colorid/$itemid.gif";
					
				} else if ($ImgInfo['has_jpg']) {
					$filename = "$itemtypeid/$colorid/$itemid.jpg";
					
				} else {
					$filename = "noimage_small.png"; 
				}
				
				//Timer
				if ($timer > 1) {
						$timer = 0;
					}
					
				if ($timer == 0) {
					
					echo "<div class='bit even'>";
					echo "<div class='bitContent'> <img src= \"$ImgLink$filename\" alt=\" Picture of bit\"> <div class='bitName'>  <p> $quantity X $colorname </p> : <h3>$partname</h3> </div></div>" ;

					echo "</div>";
				}
				
				else {
					echo "<div class='bit odd'>";
					echo "<div class='bitContent'> <img src= \"$ImgLink$filename\" alt=\" Picture of bit\"> <div class='bitName'>  <p> $quantity X $colorname </p> : <h3>$partname</h3> </div></div>" ;
				    echo "</div>";
				}
				
				$timer += 1;
			}
			
			//Visa minifigurer
			if (mysqli_num_rows($resultminifig) !== 0) {
				echo "<br><h3>Minifigures:</h3>";
			}
	
			while ($row2 = mysqli_fetch_array($resultminifig)) {
				
				$minifigname = $row2['Minifigname'];
				$itemid = $row2['ItemID'];
				$minifigquantity = $row2['Quantity'];
				
				
				$imgMinifigs = mysqli_query($conn, "SELECT images.has_gif, images.has_jpg, images.ItemTypeID FROM images WHERE ItemID='$itemid'");
				$MinifigInfo = mysqli_fetch_array($imgMinifigs);
				
				
				if ($MinifigInfo['has_gif']) {
						$filename = "M/$itemid.gif";
						
					} else if ($MinifigInfo['has_jpg']) {
						
						$filename = "M/$itemid.jpg";
						
					} else { 
					
						$filename = "noimage_small.png"; 
					}	
					
					if ($timer > 1) {
						$timer = 0;
					}
					
				if ($timer == 0) {
					
					echo "<div class='bit even'>";
					echo "<div class='bitContent'> <img src= \"$ImgLink$filename\" alt=\" Picture of mini figure\"> <div class='bitName'> <p> $minifigquantity X <h3>$minifigname</h3></div></div>";
					echo "</div>";
				}
				
				else {
					echo "<div class='bit odd'>";
					echo "<div class='bitContent'> <img src= \"$ImgLink$filename\" alt=\" Picture of mini figure\"> <div class='bitName'> <p> $minifigquantity X <h3>$minifigname</h3></div></div>";
				    echo "</div>";
				}
				
				$timer += 1;
			
			}
				
				echo "</div>";
		?>
		
	</body>
</html>










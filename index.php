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
		<title>Legodatabasen</title>
		<link href="style.css" media="screen" rel="stylesheet" type="text/css"/>
		<script	src="script.js"></script> 
		
    </head>
      
    <body>
	
		<?php include "meny.txt" ?>

		<div class = "searchMain">
			<form action= "sokresultat.php" method="GET">
			<input type="text" class="ftext" name= "ftext" placeholder="Search LEGO-set...">
			<input type="submit" id= "searchbutton" value="🔎" >
		</form>
			
		</div>
		

    </body>
</html>
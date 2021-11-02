<?php
	$nickname = $_POST['nicknameid'];
	$userComment = $_POST['commentid'];


	$databaseAuthFile = fopen($_SERVER['DOCUMENT_ROOT'].'/databaseAuth.txt', 'r');
	if(!databaseAuthFile)
	{
	echo "Sorry, database maintainence is needed! Please try again later";
	exit;
	}
	$databaseUsername = fgets($databaseAuthFile);	
	$databasePassword = fgets($databaseAuthFile);
	$formattedUsername = substr($databaseUsername, 0, strlen($databaseUsername)-1);
	$formattedPassword = substr($databasePassword, 0, strlen($databasePassword)-1);
	$mysql2 = mysqli_connect("localhost", $formattedUsername 
					   , $formattedPassword);
	if(!$mysql2)
	{
	     echo "Cannot connect to database.";	
	     exit;
	}	
	$commentDB = mysqli_select_db($mysql2, "auth");
	if(!$commentDB)
	{
		echo "Cannot select database(Comments).";
		exit;
	}
	
	$query1 = "select * from auth.comments";
	$commentResult = mysqli_query($mysql2, $query1);
	if(!$commentResult) { echo "Failed to query database"; exit;}
	$num_results = mysqli_num_rows($commentResult);
	if(!$num_results)
	{
		echo "No Comments<br />";
	}
	for($i = 0; $i < $num_results; $i++)
	{      
	       $row = $commentResult->fetch_assoc();
	       echo ($i+1).". ";
	       echo htmlspecialchars(stripslashes($row['nickname']));
	       echo " said: <br \>";
	       echo stripslashes($row['comments']);
	       echo "<br />";	       
	       
	}
	
	$query2 = "insert into auth.comments values ('".$nickname."', '".$userComment."')";
	$insertResult = mysqli_query($mysql2, $query2);
	
	if($insertResult)
	{
		echo "<p><strong>Your Comment is uploaded!</strong></p>";	
	}	
	mysqli_close($mysql2);	
?>
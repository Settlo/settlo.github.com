<?php
session_start();

#GetClientIP
$Address = $_SERVER['REMOTE_ADDR'];

$Cooldown = 5;

#CLEAN
include 'Cleaner.php';

if (isset($_REQUEST["inputText"]))
	$inputText = xss_clean($_REQUEST["inputText"]);
if (isset($_REQUEST["inputSpeech"]))
	$inputSpeech = xss_clean($_REQUEST["inputSpeech"]);

#Check if request already exists
$found = false;
$conn = mysqli_connect("localhost", "root", "", "mtron");

mysqli_query($conn, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci';");

$result = mysqli_query($conn, "SELECT * FROM voicegenqueue");
while($row = mysqli_fetch_row($result))
{
	if (session_id() == $row[1])
	{
		$found = true;
		break;
	}
}

if (!$found)
{
	if (isset($_REQUEST['inputText']) && isset($_REQUEST['inputSpeech']))
	{
		#COOLDOWN
		if (isset($_SESSION))
		{
			if ( !isset($_SESSION["LastUse"]) || ($_SESSION["LastUse"] + $Cooldown < time()) )
			{
				$text = $inputText;
				
				#PROCESS REQUEST
				$outputarea .= '"'.$text.'"';
				if (!empty($text)) 
				{
					#Limit characters to 500
					$text = substr($text, 0, 500);
					
					$text = str_replace(array('x', 'X'), 'kss', $text);
					$text = str_replace(array('v', 'V'), 'w', $text);
					$text = str_replace(array('q', 'Q'), 'k', $text);
					$text = str_replace(array("\n", "\r", "\b", "\r\n"), '.', $text);
					
					#Czech support
					$text = str_replace(array('č', 'Č'), 'ć', $text);
					$text = str_replace(array('š', 'Š'), 'ś', $text);
					$text = str_replace(array('í', 'Í'), 'i', $text);
					$text = str_replace(array('á', 'Á'), 'a', $text);
					$text = str_replace(array('ý', 'Ý'), 'y', $text);
					
					$text .= '.';
					
					$_SESSION["LastUse"] = time();
					
					$TextArg = mysqli_real_escape_string($conn, $text);
					$SpeechArg = mysqli_real_escape_string($conn, $inputSpeech);
					
					#log to file
					$fp = fopen('logs/LastLog.txt', 'a');
					fwrite($fp, "[".$Address."] ");
					fwrite($fp, $_REQUEST["inputText"]);
					fwrite($fp, "\n");
					fclose($fp);
					
					#launch client
					$result = mysqli_query($conn, "INSERT INTO voicegenqueue(VGQueue_Session, VGQueue_InputText, VGQueue_SpeechFile, VGQueue_Denoise, VGQueue_RemoteAddress) VALUES('".session_id()."', '".$TextArg."', '".$SpeechArg."', 1, '".$Address."');");
					$id = mysqli_insert_id($conn);
					$_SESSION["QueueID"] = $id;
					
					echo "Inserted";
				}
			}
		}
	}
}
mysqli_close($conn);
?>
<?php
session_start();

$outputarea = '';
$outputFilename = '';

if (isset($_SESSION["QueueID"]))
{
	$conn = mysqli_connect("localhost", "root", "", "mtron");
	mysqli_query($conn, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci';");
	$result = mysqli_query($conn, "SELECT * FROM voicegenreceive WHERE VGReceive_QueueID = ".$_SESSION["QueueID"].";");
	
	$filename = 'null.wav';
	$text = 'null';

	if($row = mysqli_fetch_row($result))
	{
		$text = $row[2];
		$filename = $row[3];
		$reachedMax = $row[4];
		
		if ($reachedMax == '1')
			$outputarea .= '<a class="error">Przekroczono limit 15 sekund! Otrzymany głos może okazać się wadliwy.</a><br>';
		$outputarea .= '"'.$text.'"';
		$outputarea .= '<pre>Output: <a href="gens/'.$filename.'" download>'.$filename.'</a></pre>';
		#$outputarea .= '<div><audio controls><source src="gens/'.$filename.'" type="audio/wav"></audio></div>';
		
		mysqli_query($conn, "DELETE FROM voicegenreceive WHERE VGReceive_QueueID = ".$_SESSION["QueueID"].";");
		
		$outputFilename = $filename;
	}
	
	mysqli_close($conn);
}
echo json_encode(array(
	"html" => $outputarea,
	"filename" => $outputFilename,
));
?>
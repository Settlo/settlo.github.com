<?php
session_start();

$queue = '';

#DB
$queuePos = 1;
$found = false;
$conn = mysqli_connect("localhost", "root", "", "mtron");
$result = mysqli_query($conn, "SELECT * FROM voicegenqueue");
while($row = mysqli_fetch_row($result))
{
	if (session_id() == $row[1])
	{
		$found = true;
		break;
	}
	$queuePos++;
}
mysqli_close($conn);

if ($found)
	$queue .= 'Pozycja w kolejce: '.$queuePos;

echo $queue;
?>
var multiplier = document.currentScript.getAttribute('multiplier');

var sendRequestButton = document.getElementById("SendRequest");
var outputArea = document.getElementById("OutputArea");
var outputWaveformDiv = document.getElementById("outputWaveformDiv");
var playButton = document.getElementById("playButton");

sendRequestButton.addEventListener('click', function() { event.preventDefault(); outputArea.innerHTML = ""; breakWaitLoop = false; ClearOutputWave(); QueueInsert(); } );
sendRequestButton.disabled = true;
setTimeout(function() { sendRequestButton.disabled = false }, 1000 * multiplier);

var waitLoopIter = 0;
var waitLoopBaseString = "Proszę czekać";
var breakWaitLoop = true;
function WaitLoop()
{
	if (!breakWaitLoop)
	{
		ClearOutputWave();
		if (waitLoopIter > 3)
			waitLoopIter = 0;
		
		var waitLoopString = waitLoopBaseString;
		for(var i=0; i<waitLoopIter; i++)
			waitLoopString += ".";
		
		outputArea.innerHTML = waitLoopString;
		
		sendRequestButton.disabled = true;
	}
	setTimeout(function() { WaitLoop(); waitLoopIter++; }, 350);
}
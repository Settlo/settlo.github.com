function Clean(inputString)
{
	var lt = /</g, 
    gt = />/g, 
    ap = /'/g, 
    ic = /"/g;
	var value = inputString.toString().replace(lt, "&lt;").replace(gt, "&gt;").replace(ap, "&#39;").replace(ic, "&#34;");
	return value;
}

var queuePosInfoDiv = document.getElementById("QueuePosInfoDiv");
function ListenQueue() //Checks if user is already in queue, gets user position in queue.
{
	$.ajax({
		type: "POST",
		url: 'Queue.php',
		success: function(response)
		{
			if (response == "")
			{
				ClearOutputWave();
				breakWaitLoop = true;
				outputArea.innerHTML = "";
				queuePosInfoDiv.innerHTML = "";
				sendRequestButton.disabled = false;
			}
			else
			{
				breakWaitLoop = false;
				queuePosInfoDiv.innerHTML = response;		
			}
			
			if (breakWaitLoop)
			{
				QueueReceive();
				return;
			}
			
			setTimeout( function() { ListenQueue(); }, 1000);
		}
	});
}
ListenQueue();
WaitLoop();

//Play button logic 7581409883.wav
playButton.addEventListener('click', function() {
{
	event.preventDefault();
	TogglePlayback();
}
});

function TogglePlayback()
{
	if (playButton.disabled == false && outputWave != null)
	{
		if (outputWave.isPlaying())
		{
			outputWave.pause();
			playButton.innerHTML =  "Wznów";
		}
		else
		{
			outputWave.play();
			playButton.innerHTML =  "Pauza";
		}
	}
}

function ClearOutputWave()
{
	if (outputWave != null)
		outputWave.destroy();
	outputWaveformDiv.style["border-style"] = "none";
	playButton.innerHTML = "Odtwórz";
	playButton.disabled = true;
}

var outputWave;
function QueueReceive()
{
	$.ajax({
		type: "POST",
		url: 'QueueReceive.php',
		success: function(receive)
		{
			var data = JSON.parse(receive);
			
			if (data.html != '' && data.filename != '')
			{
				outputArea.innerHTML = data.html;
				
				ClearOutputWave();
				
				outputWaveformDiv.style["border-style"] = "solid";
				outputWave = WaveSurfer.create({
					container: '#outputWaveform',
					waveColor: '#ddd',
					cursorColor: 'fff',
					plugins: [WaveSurfer.cursor.create()],
					mediaControls: true,
					progressColor: '#d4ca98'
				});
				outputWave.on('seek', function () {
					if (outputWave.isPlaying())
						outputWave.play();
				});
				outputWave.on('finish', function () {
					playButton.innerHTML = "Odtwórz";
				});
				outputWave.load('gens/' + data.filename);
				
				playButton.disabled = false;
			}
		}
	});
}

function QueueInsert()
{
	var inputText = Clean(document.getElementById("inputText").value);
	var inputModel = Clean(document.getElementById("inputModel").value);
	$.ajax({
		type: "POST",
		url: 'QueueInsert.php',
		data: {inputText: inputText, inputSpeech: inputModel},
		success: function(response)
		{
			if (response != "Inserted")
			{
				breakWaitLoop = true;
			}
			ListenQueue();
		}
	});
}
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	var overlays = document.getElementsByClassName('bgOverlay');
	for (var i = 0; i < overlays.length; i++) 
	{
	   overlays[i].parentNode.removeChild(overlays[i]);
	}
	var backgroundImage = document.getElementById('BackgroundImage');
	backgroundImage.style["filter"] = "none";
}
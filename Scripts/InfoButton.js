var InfoButton = document.getElementById("InfoButton");
var InfoButtonTextContainer = document.getElementById("InfoButtonTextContainer");

InfoButton.addEventListener('mouseover', function() 
{ 
	InfoButtonTextContainer.style["display"] = "block";
});

InfoButton.addEventListener('mouseleave', function() 
{ 
	InfoButtonTextContainer.style["display"] = "none";
});
var termsAcceptBtn = document.getElementById("termsAccept");
var termsRejectBtn = document.getElementById("termsReject");

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

var TermsOfUse = getCookie("TermsOfUse");
if (TermsOfUse == "Accepted")
	FooterNoticeClose();

function FooterNoticeClose()
{
	document.getElementById('gFooterNotice').style["display"] = "none";
}

termsAcceptBtn.addEventListener('click', function()
{ 
	FooterNoticeClose();
	document.cookie = "TermsOfUse=Accepted";
});
termsRejectBtn.addEventListener('click', function()
{ 
	window.location.href = "https://google.com";
});
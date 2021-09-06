var textarea = document.querySelector('textarea');

textarea.addEventListener('keydown', autosize);
			 
function autosize(){
  var el = this;
  setTimeout(function(){
	if (el.scrollHeight < 600)
	{
		el.style.cssText = 'height:auto; padding:6px;';
		el.style.cssText = 'height:' + el.scrollHeight + 'px; padding:6px;';
	}
  },1);
}
autosize.call(textarea);
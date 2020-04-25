function hide(){
	$(".container .alert-success").css("display","none");
}

function copyArticle(event){
	const range = document.createRange();
	range.selectNode(document.getElementById('image_url'));
	const selection = window.getSelection();
	if(selection.rangeCount > 0) selection.removeAllRanges();
	selection.addRange(range);
	document.execCommand('copy');
	// alert("复制成功");
	$(".container .alert-success").css("display","block");
	setTimeout('hide()', 2000);
}
window.onload = function () {
   var obt = document.getElementById("copy");
   obt.addEventListener('click', copyArticle, false);
}
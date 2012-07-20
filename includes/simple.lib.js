function parseGetParams() { 
   var $_GET = {}; 
   var __GET = window.location.search.substring(1).split("&"); 
   for(var i=0; i<__GET.length; i++) { 
      var getVar = __GET[i].split("="); 
      $_GET[getVar[0]] = typeof(getVar[1])=="undefined" ? "" : getVar[1]; 
   } 
   return $_GET; 
} 
function adjustHeight(textarea){
    var textarea=document.getElementById(textarea);
    var dif = textarea.scrollHeight - textarea.clientHeight;
    
    if (parseInt(textarea.style.height) <= 400) {
		if (dif){
			if (isNaN(parseInt(textarea.style.height))){
				textarea.style.height = textarea.scrollHeight + "px";
			}else{
				textarea.style.height = parseInt(textarea.style.height) + dif + "px";
			}
		}
	}
}


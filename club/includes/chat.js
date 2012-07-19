function rateMessage(change,mess_id,pattern,errorPattern) {
	var get=parseGetParams();
	var Handler= function(Request) {
		var answer=Request.responseText;
		if (!isNaN(answer)) {
			var rate=parseInt(answer);
			if (rate==0) document.getElementById(pattern).style.color='gray';
			if (rate>0) {
				document.getElementById(pattern).style.color='green';
				rate='+'+rate;
				}
			if (rate<0) document.getElementById(pattern).style.color='red';
				document.getElementById(pattern).innerHTML=rate;
				}
		else 
			document.getElementById(errorPattern).innerHTML=answer;
			}
	var str= 'change='+change+'&mess_id='+mess_id+'&club_id='+get['club_id']+'&action=rateMessage';
	SendRequest('post','includes/ajax.lib.php',str,Handler);
    } 

function deleteMess(mess_id,div) {
	var Handler= function(Request) {
		document.getElementById(div).style.display='none';
		}
	var str='mess_id='+mess_id+'&action=deleteMess';
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}

function sendMessage(club_id,text,answer_id,pattern,loc) {
	Handler= function(Request) {
		var answer=Request.responseText;
		if (answer.length>10) 
			document.getElementById(pattern).innerHTML=Request.responseText;
		else
			location.href=loc;
		}
		var str='club_id='+club_id+'&text='+text+'&answer_id='+answer_id+'&action=sendMessage';
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}
//Функция получает сообщения чата, которые должны быть расположены на данной странице
function setClubChatContent(page,max_page) {
	var get=parseGetParams();
	getPage= function(Request) {
		document.getElementById('chatPagePattern').innerHTML=Request.responseText;
		}	
	var str='p_num='+page+'&max_page='+max_page+'&function=setClubChatContent&action=getPage';
	
	SendRequest('post','../includes/page.lib.php',str,getPage);
	
	setContent=function(Request) {
		document.getElementById('clubChatContent').innerHTML=Request.responseText;
		}
	var str='p_num='+page+'&club_id='+get['club_id']+'&action=setClubChatContent';
	SendRequest('get','club.php',str,setContent);
	}
	
$(document).ready(function(){
	$('.mess_button').mouseover(function(){
		$(this).fadeTo('250','0.8');	  
		});
	$('.mess_button').mouseout(function(){
		$(this).fadeTo('250','0.5');
        });
});

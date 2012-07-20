//данная функция отправляет запрос на удаление пользователя из клуба
function createClub(name,loc,pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5)
			location.href=loc;
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	str="name="+name+"&action=createClub";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}
//
function leaveClub(club_id,loc,pattern) {
		Handler= function(Request) {
		if (Request.responseText.length<5)
			location.href=loc;
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	str="club_id="+club_id+"&action=leaveClub";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}	
//
function deleteClub(club_id,loc,pattern) {
	if (confirm("Вы точно хотите удалить данный клуб?")) {
		Handler= function(Request) {
			if (Request.responseText.length<5)
				location.href=loc;
			else 
				document.getElementById(pattern).innerHTML=Request.responseText;
			}
		str="club_id="+club_id+"&action=deleteClub";
		SendRequest('post','includes/ajax.lib.php',str,Handler);
		}
	}

function updateClub(pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5)
			document.getElementById(pattern).innerHTML="<font style='color:green'>Данные успешно сохранены</font>";
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	var name=document.getElementById('name').value;
	var info=document.getElementById('club_info').value;
	var canView=document.getElementById('canView').value;
	var canWrite=document.getElementById('canWrite').value;
	var canEnter=document.getElementById('canEnter').value;
	var str="name="+name+"&info="+info+"&canView="+canView+"&canWrite="+canWrite+"&canEnter="+canEnter+"&action=updateClub";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}	

//
function acceptInvite(club_id,loc,pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5)
			location.href=loc;
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	str="club_id="+club_id+"&action=acceptInvite";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}
//
function declineInvite(club_id,loc,pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5)
			location.href=loc;
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	str="club_id="+club_id+"&action=deleteInvite";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}

function addApply(club_id,user_id,loc,pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5) {
			location.href=loc;
			}
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	str="club_id="+club_id+"&user_id="+user_id+"&action=addApply";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	} 
function cancelApply(club_id,user_id,loc,pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5) {
			location.href=loc;
			}
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	str="club_id="+club_id+"&user_id="+user_id+"&action=deleteApply";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	} 
function acceptApply(user_id,div,pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5) {
			document.getElementById(div).className="okey";
			document.getElementById(div).innerHTML="Заявка принята";
			}
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	str="user_id="+user_id+"&action=acceptApply";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}

function deleteApply(club_id,user_id,div,pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5) {
			document.getElementById(div).className="okey";
			document.getElementById(div).innerHTML="Заявка отклонена";
			}
		else 
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	str="club_id="+club_id+"&user_id="+user_id+"&action=deleteApply";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}

function addUser(club_id,user_id,pattern,action) {	
	Handler = function(Request) {
		var answer=Request.responseText;
		if (answer.length<5) 
		action;
		else 
			document.getElementById(pattern).innerHTML=answer;
		}
	str="club_id="+club_id+"&user_id="+user_id+"&action=addUser";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}
function deleteUser(user_id,pattern,error_pattern) {
	Handler= function(Request) {
		if (Request.responseText.length<5)
			document.getElementById(pattern).style.display="none";
		else 
			document.getElementById(error_pattern).innerHTML=Request.responseText;
		}
	str="user_id="+user_id+"&action=deleteUser";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}
function makeAdmin(action,user_id,error_pattern) {
	Handler= function(Request) {
	if (Request.responseText.length<5) {
			document.getElementById(error_pattern).className='okey';
			if (action=='makeAdmin') {
				document.getElementById('make'+user_id).style.display="none";
				document.getElementById('unmake'+user_id).style.display="";
				document.getElementById(error_pattern).innerHTML="Пользователь добавлен в администраторы";
				}
			if (action=='unmakeAdmin') {
				document.getElementById('make'+user_id).style.display="";
				document.getElementById('unmake'+user_id).style.display="none";
				document.getElementById(error_pattern).innerHTML="Пользователь удалён из администраторов";
				}
			}
		else 
			document.getElementById(error_pattern).innerHTML=Request.responseText;
		}
	str="user_id="+user_id+"&action="+action;
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}
function muteUser(action,user_id,error_pattern) {
	Handler= function(Request) {
	if (Request.responseText.length<5) {
			document.getElementById(error_pattern).className='okey';
			if (action=='muteUser') {
				document.getElementById('mute'+user_id).style.display="none";
				document.getElementById('unmute'+user_id).style.display="";
				document.getElementById(error_pattern).innerHTML="Пользователь заблокирован";
				}
			if (action=='unmuteUser') {
				document.getElementById('mute'+user_id).style.display="";
				document.getElementById('unmute'+user_id).style.display="none";
				document.getElementById(error_pattern).innerHTML="Пользователь разблокирован";
				}
			}
		else 
			document.getElementById(error_pattern).innerHTML=Request.responseText;
		}
	str="user_id="+user_id+"&action="+action;
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}


function sendInvite(club_id,user_id,pattern) {
	Handler= function(Request) {
		var answer=Request.responseText;
		if (answer.length > 5) 
			document.getElementById(pattern).innerHTML=Request.responseText;
		else 
			document.getElementById(pattern).innerHTML="<font class='okey'>Приглашение успешно отправлено</font>";
		}
	var str= "club_id="+club_id+"&user_id="+user_id+"&action=sendInvite";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}

function deleteInvite(club_id,user_id,pattern) {
	Handler= function(Request) {
		var answer=Request.responseText;
		if (answer.length > 5) 
			document.getElementById(pattern).innerHTML=Request.responseText;
		else 
			document.getElementById(pattern).innerHTML="<font class='okey'>Приглашение удалено</font>";
		}
	var str= "club_id="+club_id+"&user_id="+user_id+"&action=deleteClubInvite";
	SendRequest('post','includes/ajax.lib.php',str,Handler);
	}

function showClub() {
	document.getElementById('my_club').style.display='';
	document.getElementById('my_invite').style.display='none';
	}
function showInvite() {
	document.getElementById('my_invite').style.display='';
	document.getElementById('my_club').style.display='none';
	}

function showInfo() {
	document.getElementById('club_info').style.display='';
	document.getElementById('club_chat').style.display='none';
	}
function showChat() {
	document.getElementById('club_chat').style.display='';
	document.getElementById('club_info').style.display='none';
	}
function member_show() {
	document.getElementById('member').style.display='';
	document.getElementById('apply').style.display='none';	
	}
function apply_show() {
	document.getElementById('member').style.display='none';
	document.getElementById('apply').style.display='';
	}
	
$(document).ready(function(){
	$('.user_club_button').mouseover(function(){
		$(this).fadeTo('250','0.8');	  
		});
	$('.user_club_button').mouseout(function(){
		$(this).fadeTo('250','0.5');
        });
});

//функция получает клубы пользователя, которые должны быть расположены на данной странице
function setUserClubContent(page,max_page) {
	getPage= function(Request) {
		document.getElementById('clubs_page_pattern').innerHTML=Request.responseText;
		}	
	var str='p_num='+page+'&max_page='+max_page+'&function=setUserClubContent&action=getPage';
	SendRequest('post','../includes/page.lib.php',str,getPage);
	setContent=function(Request) {
		document.getElementById('userClubCentent').innerHTML=Request.responseText;
		}
	var str='p_num='+page+'&action=setUserClubContent';
	SendRequest('post','index.php',str,setContent);
	}

//аналогично получаются приглашения пользователя
function setUserInviteContent(page,max_page) {
	getPage= function(Request) {
		document.getElementById('invites_page_pattern').innerHTML=Request.responseText;
		}	
	var str='p_num='+page+'&max_page='+max_page+'&function=setUserInviteContent&action=getPage';
	SendRequest('post','../includes/page.lib.php',str,getPage);
	setContent=function(Request) {
		document.getElementById('userInviteContent').innerHTML=Request.responseText;
		}
	var str='p_num='+page+'&action=setUserInviteContent';
	SendRequest('post','index.php',str,setContent);
	}
	
function searchUser(club_id,argc,pattern) {
	Handler= function(Request) {
			document.getElementById(pattern).innerHTML=Request.responseText;
		}
	var str= "club_id="+club_id+"&argc="+argc+"&action=searchUser";
	//alert(str);
	SendRequest('post','club_invite.php',str,Handler);
	}

	
	

<script type="text/javascript">
function setClubContent(page,max_page) {
	getPage= function(Request) {
		document.getElementById('clubs_page_pattern').innerHTML=Request.responseText;
		}	
	var str='p_num='+page+'&max_page='+max_page+'&function=setClubContent&action=getPage';
	SendRequest('post','../includes/page.lib.php',str,getPage);
	setContent=function(Request) {
		document.getElementById('clubCentent').innerHTML=Request.responseText;
		}
	var str='p_num='+page+'&action=setClubContent';
	SendRequest('post','all_clubs.php',str,setContent);
	
	//alert('qq');
	}
</script>

<div class='form_settings'>
<TABLE align='center'>
 	<tr>
     <td>
     <table>
      <tr>
      <td> 
      <ul id="navigation" style='width:500px'>
	   <li class='selected'><a href='#'>Клубы</a> </li>
	  </ul>
      </td>
      <td width=130px><a href='index.php'>Мои клубы</a></td>
    </tr>
    <table>
    </td>
    </tr>
    <tr id='my_club'>
       
   <td id='tab_content'>
	<table >
	 <tr>
	  <td id='tab_header'>{$club_count_name}</td>
	 </tr>
     <tr>
      <td id='clubCentent'> {$club_content} </td>
     </tr>
	<tr>
	 <td align='center' id='clubs_page_pattern'>{$clubs_page_pattern}</td>
	</tr>
	 </table>
   </td>
  </tr>
</table>
</div>

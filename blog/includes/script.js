$(document).ready(function(){
	$('.delete a, .edit a, .response a').live("mouseover", function(){
		$(this).children('img').fadeTo('250','0.8');
		});
	$('.delete a, .edit a, .response a').live("mouseout",function(){
		$(this).children('img').fadeTo('250','0.5');
		});
	$('.hide').live("click", function(e){
		e.preventDefault()	;
		$(this).parent('p').hide("slow");
		$('span.error').remove();
		$(this).siblings('e').html('Ваш ответ');
		});
	$('.delete a').live("click",function(e){
	 	e.preventDefault();
		if (confirm('Вы точно хотите удалить ваш комментарий?')) {
			deleted=$(this).parent('div').parent('div').parent('div');
			$.post('includes/comment.lib.php',{'id': deleted.attr('class').slice(5),'action':'deleteComment'}, 
				function(msg) {
					if (msg.status) {	
						deleted.children('.comment').fadeTo('250','0.5').children('p').css('font-size', '18px').siblings('.avatar, .date, .response, .edit, .delete, .rate, .up, .down').slideUp();
						deleted.children('.comment').children('p').html('Сообщение удалено.');
						}
				}
			,'json');
			}
		});	

	$('.edit a').live("click",function(e){
		e.preventDefault();
		text=$(this).parent('').siblings('p').html();
		$(this).parent('').parent('').siblings('p').show('slow').attr('id','edit').children('textarea').html(text).siblings('e').html('Исправление');
		});

	$('.up a, .down a' ).live("click", function(e) {
		e.preventDefault();
		rate=$(this).parent('').siblings('.rate');
		dir=$(this).parent('').attr('class');
		append_place=$(this).parent('').parent('');
		$.post('includes/rate.php',{'direct': dir, 'id':$(this).parent('').parent('').parent('').attr('class').slice(5), 'current': rate.html()},
			function(msg){
				if (msg.status){		
					rate.html(msg.num);
					rate.css('color',msg.color);
					}
				else  {  
					$('span.error').remove();
					$("<span class='error'>Вы не можете голосовать за это сообщение</span>").appendTo(append_place).slideDown();
					}
				}
			,'json');
		});

	$('.response a').live("click", function(e) {
		e.preventDefault();
		$(this).parent('').parent('').siblings('p').show('slow');
		});


/* The following code is executed once the DOM is loaded */
/* This flag will prevent multiple comment submits: */
	var working = false;
/* Listening for the submit event of the form: */
	$('.submit').live("click", function(ee){
		ee.preventDefault();
		if(working) 
			return false;
		working = true;
		$('.submit').val('Подождите..');
		$('span.error').remove();
		if ($(this).parent('div').attr('class')=='addCommentContainer') {
			text=$(this).siblings('textarea');	
			$.post('includes/submit.php',{ 'text': text.val(), 'ans_num': 0, 'margin': 0 },
				function(msg){
					working = false;
                    $('.submit').val('Добавить');
                    if(msg.status){
						$(msg.html).hide().insertBefore('.addCommentContainer').slideDown();
						text.val('');
						}
					else {
						$.each(msg.errors,function(k,v){
							$('label[for='+k+']').append('<span class="error">'+v+'</span>');
                            });
                        }
                }
             ,'json');
		}
	else {
		block=$(this).parent('').siblings('.comment').css('margin-left');
		block_p=$(this).parent('').parent('div').attr('class');
		textarea=$(this).siblings('textarea');
		append_place=$(this).parent('p').siblings('.comment');
		if (textarea.val()=='') { $("<span class='error'>Введите текст в поле</span>").appendTo(append_place).slideDown(); working=false; $('.submit').val('Submit'); }			
		//text=$(this).children('#text').val(); 
		/* Sending the form fileds to submit.php: */
		else {
			$.post('includes/submit.php',{ 'status': $(this).parent('p').attr('id') ,'text': $(this).siblings('textarea').val(), 'ans_num': $(this).siblings('#ans_num').val(), 'margin': block },function(msg){
			working = false;
			$('.submit').val('Добавить');
			if(msg.status){
				
				/* 
				/	If the insert was successful, add the comment
				/	below the last one on the page with a slideDown effect
				/*/
				 $('.'+block_p).children('p').hide('slow');
                                $('.'+block_p).children('p').children('textarea').val('');
				 
				next=$('.'+block_p);
                                next_comm_margin=parseInt(next.children('.comment').css('margin-left').slice(0,-2));
                           	
                                
                                while (true) {	
						next=next.next();
                                               	if (next.attr('class')=='addCommentContainer') {trueid=next.attr('class');  break;       }
                                               
                                                a=parseInt(next.children('.comment').css('margin-left').slice(0,-2));
						
                                                
                                                if (next_comm_margin>=a) {trueid=next.attr('class'); break;       }
                                        }       
 				
                                 $(msg.html).hide().insertBefore('.'+trueid).slideDown();
                                
				}
				else
				{
					  $('.'+block_p).children('p').attr('id','ans').hide('slow').siblings('.comment').children('p').html(textarea.val());
					   textarea.val('').siblings('e').html('Ваш ответ');
					   
					

				}	

/*
					
				if (msg.last=='0'){ 	
				
				if ( $(msg.id).next().attr('class')=='addCommentContainer') { $(msg.html).hide().insertBefore('.addCommentContainer').slideDown();}
				else {
				
				//trueid=$(msg.id).next().attr('class');
				next=$(msg.id);
				next_comm_res=next.children('p').children('#ans_num').val();
				alert(next_comm_res);	
				i=0;
				
				while (true) {
						i++;
						next=next.next();
						a=next.children('p').children('#ans_num').val();
						alert(a);
						if ((next_comm_res>a) || (next.attr('class')=='addCommentContainer')) {trueid=next.attr('class');  break;	}
					}	
 
				 $(msg.html).hide().insertBefore('.'+trueid).slideDown();
				}
				}
				else $(msg.html).hide().insertBefore(msg.id).slideDown();

				//$(this).parent('').parent('').after("msg.html");

				
			
			}
*/		/*	else {

				//
				//	If there were errors, loop through the
				//	msg.errors object and display them on the page 
				//
				
				$.each(msg.errors,function(k,v){
					$('label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}*/
		},'json');}
}	});
	
});

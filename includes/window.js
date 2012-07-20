
$(document).ready(function() { 
$('a[name=modal]').click(function (e) {
	//Cancel the link behavior
	e.preventDefault();
	//Get the A tag
	var id = $(this).attr('href');
	
	//Get the screen height and width
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();

	//Set heigth and width to mask to fill up the whole screen
	$('#mask').css({'width':maskWidth,'height':maskHeight});
	  
	//transition effect             
	$('#mask').fadeIn(100);        
	$('#mask').fadeTo('fast',0.8);  
	
	//Get the window height and width
	var winH = $(window).height();
	var winW = $(window).width();
	var winH2= e.pageY;
	$(id).css('top',  winH/2-$(id).height()/2);
	$(id).css('left', winW/2-$(id).width()/2);

	//transition effect
	$(id).fadeIn(200); 

});

//if close button is clicked
$('.window .closed').click(function (e) {
	//Cancel the link behavior
e.preventDefault();
	$('#mask, .window').hide();
});             

//if mask is clicked
$('#mask').click(function () {
	$(this).hide();
	$('.window').hide();
});                     

});

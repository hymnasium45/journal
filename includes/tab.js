$(document).ready(function(){
        $("ul#navigation li a").click(function() {
				$("ul#navigation li.selected").removeClass('selected');
				$("ul#navigation li").addClass('none');
			    $(this).parents().addClass('selected');
                $(this).parents().removeClass('none');
                return false;
        });
});


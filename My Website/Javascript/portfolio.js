$(function(){
	$('.expansionArrow').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		if($(this).css('background-position') == '0px -39px'){
			$(this).css('background-position', '0px 0px');
		}
		else{
			$(this).css('background-position', '0px -39px');
		}
		$(this).closest('.project').children('.expandedContent').toggle( "slide", { direction: "up" }, "normal" );
	});
});
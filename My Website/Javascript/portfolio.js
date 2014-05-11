$(function(){
	$('.expandedContent').toggle();
	$('.titleBar').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).closest('.project').children('.expandedContent').toggle( "slide", { direction: "up" }, "normal" );
	});
});
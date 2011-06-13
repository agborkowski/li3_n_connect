$(document).ready(function(){ 
	$("div#board div.move").click(function(e) {
		var move = $(this).attr("attrx");
		$("#xvalue").val(move); 
		$("#moveForm form").submit(); 
	});
});

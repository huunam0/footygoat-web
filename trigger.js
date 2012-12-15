$(document).ready(function(){
	//$("#condboard").append('<div class="onetrigger" style="overflow: auto;"> <select name="team[]" class="team"><option value="0">Home</option><option value="1">Away</option></select> <select name="trigger[]" class="chon">'+toption+'</select> <select name="operator[]" class="step2"><option>&gt;</option><option>&ge;</option><option>=</option><option>&lt;</option><option>&le;</option><option>&ne;</option></select> <input name="number[]" type="text" size="2" maxlength="3"  class="step3"/> .</div>');
	
	$("#addcond").click(function(){
		//if ($("#condboard").fi)
		var isfilled = true;
		$(".step3").each(function(){
			if (!$(this).val()) {
				isfilled=false;
				return false;
			}
		});
		if (isfilled)
		$("#condboard").append('<div class="onetrigger" style="overflow: auto;"> <select name="team[]" class="team"><option value="0">Home</option><option value="1">Away</option></select> <select name="trigger[]" class="chon">'+toption+'</select> <select name="operator[]" class="step2"><option>&gt;</option><option>&gt;=</option><option>=</option><option>&lt;</option><option>&lt;=</option><option>&lt;&gt;</option></select> <input name="number[]" type="text" size="2" maxlength="3"  class="step3"/> .</div>');
		//alert(toption);==?
	});
	$(".todo").live("click",function(){
		//if (confirm("Do you really want to delete this condition?\n"+$(this).parent().text())==true)
		$(this).parent().remove();
	});
	$(".todid").live("click",function(){
		//if (confirm("Do you really want to delete this condition?\n"+$(this).parent().text())==true)
		alert($(this).parent().find("span:first").text());
	});
	$(".onetrigger").live({
		mouseenter:function(){
			$(this).css("background-color","#afff00");
			$(this).append('<span class="todo" class="button">Delete this trigger</span> ');
		},
		mouseleave:function(){
			$(this).css("background-color","#ffffff");
			$(this).find("span.todo").remove();
		}
	});
	$(".oldtrigger").hover(
		function(){
			$(this).css("background-color","#afff00");
			$(this).append('<span class="todid" class="button">Delete this trigger</span> ');
		},
		function(){
			$(this).css("background-color","#ffffff");
			$(this).find("span.todid").remove();
		}
	);
	//$("#addcond").click();
});
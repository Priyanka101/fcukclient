function toggle(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
}
function blanket_size(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportheight = window.innerHeight;
	} else {
		viewportheight = document.documentElement.clientHeight;
	}
	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
		blanket_height = viewportheight;
	} else {
		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
			blanket_height = document.body.parentNode.clientHeight;
		} else {
			blanket_height = document.body.parentNode.scrollHeight;
		}
	}
	var blanket = document.getElementById('blanket');
	blanket.style.height = blanket_height + 'px';
	var popUpDiv = document.getElementById(popUpDivVar);
	popUpDiv_height=blanket_height/2-200;//200 is half popup's height
	popUpDiv.style.top = popUpDiv_height + 'px';
}
function window_pos(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportwidth = window.innerHeight;
	} else {
		viewportwidth = document.documentElement.clientHeight;
	}
	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
		window_width = viewportwidth;
	} else {
		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
			window_width = document.body.parentNode.clientWidth;
		} else {
			window_width = document.body.parentNode.scrollWidth;
		}
	}
	var popUpDiv = document.getElementById(popUpDivVar);
	window_width=window_width/2-200;//200 is half popup's width
	popUpDiv.style.left = window_width + 'px';
}
function popup(windowname) {
	blanket_size(windowname);
	window_pos(windowname);
	toggle('blanket');
	toggle(windowname);		
}
function getNext()
{

	var ulHeight=jQuery(".bxslider").height()-700+"px";
		
	if(ulHeight=='0px')
	{
		if (jQuery(".bxslider").css("top") == "-"+ulHeight)
		{
			jQuery(".next_a").css("display","none");
			jQuery(".prev_a").css("display","none");
				
		}//end of if 
	else
		{
			//jQuery(".prev_a").css("display","none");
		//	jQuery(".next_a").css("display","none");
		}//end of the else 
	}//end of external if
	else
	{
	if (jQuery(".bxslider").css("top") == "-"+ulHeight)
		{

			jQuery(".next_a").css("display","none");
			jQuery(".prev_a").css("display","block");
		}//end of internal if 
	else
		{	

			jQuery(".prev_a").css("display","block");
			jQuery(".bxslider").css("top","-=700px");
		}//end of internal else 

	}//end of external else
}


function getPrev(){

	if (jQuery(".bxslider").css("top") =="0px"){
		jQuery(".prev_a").css("display","none");
		jQuery(".next_a").css("display","block");
	}
	
	else{
		jQuery(".next_a").css("display","block");
		jQuery(".bxslider").css("top","+=700px");
	}
	

}
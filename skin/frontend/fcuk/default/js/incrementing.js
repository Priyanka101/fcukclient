jQuery(function(jQuery) {

    jQuery("form div.qty-price").append('<div class="inc button">+</div><div class="dec button">-</div>');

    jQuery(".button").click(function() {
        var jQuerybutton = jQuery(this);
        var oldValue = jQuerybutton.parent().find("input").val();
    
        if (jQuerybutton.text() == "+") {
    	  var newVal = parseFloat(oldValue) + 1;
		  if(newVal >10){
			newVal=10;
		  }
    	  // AJAX save would go here
    	} else {
    	  // Don't allow decrementing below zero
    	  if (oldValue >= 1) {
    	      var newVal = parseFloat(oldValue) - 1;
    	      // AJAX save would go here
    	  }else{
			var newVal = 0;
		  }
    	}
    	jQuerybutton.parent().find("input").val(newVal);
    });

});
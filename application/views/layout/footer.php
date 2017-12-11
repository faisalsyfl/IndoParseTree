		
	</div> 
			
<script>
	
	/*Other Function and Variable for CSS & JS (Visual Things)*/

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
	var timer;
	function load() {
	    timer = setTimeout(showContainer, 1000);	
	}

	function showContainer() {
	  document.getElementById("loader").style.display = "none";
	  document.getElementById("container").style.display = "block";
	}

	// Error Handling
    $('#reset').on('click',function() {
		$("#inputres").modal();
    	$("#hasil").hide("slow");
    });

    // About
  	$('.dropdown').on('show.bs.dropdown', function() {
    	$(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  	});
  	$('.dropdown').on('hide.bs.dropdown', function() {
    	$(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  	});

  	/**
  	 * toogling Full Screen for visual purposes
  	 * @return {} 
  	 */
  	function toggleFullScreen() {
	  	if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
		    if (document.documentElement.requestFullScreen) {  
		      	document.documentElement.requestFullScreen();  
		    }else if(document.documentElement.mozRequestFullScreen) {  
		      	document.documentElement.mozRequestFullScreen();  
		    }else if(document.documentElement.webkitRequestFullScreen) {  
		      	document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
		    }  
	  	}else{  
			if(document.cancelFullScreen) {  
				document.cancelFullScreen();  
			}else if(document.mozCancelFullScreen) {  
				document.mozCancelFullScreen();  
			}else if(document.webkitCancelFullScreen) {  
				document.webkitCancelFullScreen();  
			}  
	  }  
	}
</script>
</body>
</html>
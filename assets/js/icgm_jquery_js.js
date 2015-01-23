(function($){
    $(document).ready(function(){
    	$('.inner-map-image').click(

			  function() {
			  	var url, lat, longi;
			  	lat = document.getElementById($(this).attr("id")).getAttribute("data-lat");
			  	longi = document.getElementById($(this).attr("id")).getAttribute("data-longi");
				url = "https://maps.googleapis.com/maps/api/staticmap?center="+lat+","+longi+"&zoom=17&size=600x300&markers=color:red|"+lat+","+longi+"";
				$("#Static-GMap").prop('src', url);

			  });
    	$('.inner-map-image2').click(

			  function() {
			  	var url, lat, longi;
			  	lat = document.getElementById($(this).attr("id")).getAttribute("data-lat");
			  	longi = document.getElementById($(this).attr("id")).getAttribute("data-longi");
			  	params = document.getElementById($(this).attr("id")).getAttribute("data-showonce");
			  	if (params == "on") {
			  		mapID = document.getElementById($(this).attr("id")).getAttribute("data-id");
				  	url = "https://maps.googleapis.com/maps/api/staticmap?center="+lat+","+longi+"&zoom=17&size=600x300&markers=color:red|"+lat+","+longi+"";
				  	$("#"+mapID).prop('src', url);
				  }

			  });
    });
})(jQuery);
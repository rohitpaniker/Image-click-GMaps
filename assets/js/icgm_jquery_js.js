(function($){
    $(document).ready(function(){
    	$('.inner-map-image').click(

			  function() {
			  	var url, lat, longi;
			  	lat = document.getElementById($(this).attr("id")).getAttribute("data-lat");
			  	longi = document.getElementById($(this).attr("id")).getAttribute("data-longi");
			  	url = "https://maps.googleapis.com/maps/api/staticmap?center="+lat+","+longi+"&zoom=13&size=600x300&markers=color:red|"+lat+","+longi+"";
			  	$("#Static-GMap").attr('src', url);
			  });
    });
})(jQuery);
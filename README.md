# Image-click-GMaps
Upload Images, add location details to each images uploaded and save from backend. Use the generated shortcode on any page/post and save. On front end images are loaded with their corresponding lat and long location, as soon as you click on an image a Static Google Map is generated on left side of the image.

Usage :

 Method A) Shortcode to display all images with locations : [icgm_maps heading="SOME HEADING"]


 Method B) Shortcode to display a particluar single image with location without repetation : [icgm_maps imgtitle="PARTICULAR IMAGE's TITLE" showonce="true" heading="SOME HEADING" needhr="true" id="A UNIQUE ID NAME"]



Shortcode parameters :


imgtitle = This is very important paramter. The image map's title name is passed here and most important thing is the title of the image map should map with repsect to name and cases. this parameter is case sensitive. (IMPORTANT)

showonce = This will avoid the image and location to appear more than once to avoid jquery conflict issue.

heading = Here you can pass a heading title.

needhr="true/false" = It defines whether you want a Horizontal Rule over the Image and Map.

id = You have to pass a unique ID here which is different from all other IDs of your previous calling of the shortcode.
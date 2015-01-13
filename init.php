<?php
/*
Plugin Name: Image Click GMaps
Plugin URI: http://www.rohitpaniker.com/
Description: Upload Images, add location details to each images uploaded and save from backend. Use the generated shortcode on any page/post and save. On front end images are loaded with their corresponding lat and long location, as soon as you click on an image a Static Google Map is generated on left side of the image.
Version: 1.0
Author: Rohit Paniker
Author URI: http://www.facebook.com/p0rnstarc0der
License: GPLv2
*/

require_once(plugin_dir_path( __FILE__ ).'backend/icgm_admin.php');
require_once(plugin_dir_path( __FILE__ ).'frontend/icgm_ui.php');
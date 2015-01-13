<?php
function my_custom_post_map() {
  $labels = array(
    'name'               => _x( 'Image Click Google Maps', 'post type general name' ),
    'singular_name'      => _x( 'Image Click Google Maps', 'post type singular name' ),
    'add_new'            => _x( 'Add New Map', 'book' ),
    'add_new_item'       => __( 'Add New Map' ),
    'edit_item'          => __( 'Edit Map' ),
    'new_item'           => __( 'New Map' ),
    'all_items'          => __( 'All Maps' ),
    'view_item'          => __( 'View Maps' ),
    'search_items'       => __( 'Search Maps' ),
    'not_found'          => __( 'No map(s) found' ),
    'not_found_in_trash' => __( 'No map(s) found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'ICGM'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our map and map specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title'),
    'has_archive'   => true,
  );
  register_post_type( 'map', $args ); 
}
add_action( 'init', 'my_custom_post_map' );

/*function my_taxonomies_product() {
  $labels = array(
    'name'              => _x( 'Product Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Product Categories' ),
    'all_items'         => __( 'All Product Categories' ),
    'parent_item'       => __( 'Parent Product Category' ),
    'parent_item_colon' => __( 'Parent Product Category:' ),
    'edit_item'         => __( 'Edit Product Category' ), 
    'update_item'       => __( 'Update Product Category' ),
    'add_new_item'      => __( 'Add New Product Category' ),
    'new_item_name'     => __( 'New Product Category' ),
    'menu_name'         => __( 'Product Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'product_category', 'product', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );*/

add_action( 'add_meta_boxes', 'map_info_box' );
function map_info_box() {
    add_meta_box( 
        'map_info_box',
        __( 'Maping Image Information', 'myplugin_textdomain' ),
        'map_box_content',
        'map',
        'normal',
        'high'
    );
}

function map_box_content( $post ) {
	  wp_nonce_field( plugin_basename( __FILE__ ), 'map_box_content_nonce' );
	  $lat = get_post_meta( get_the_ID(), 'lat_val', true );
    $longi = get_post_meta( get_the_ID(), 'longi_val', true );
    $address = get_post_meta( get_the_ID(), 'areaAdd', true );
	  $edcbVal = get_post_meta( get_the_ID(), 'ECOD', true );
	  echo '<label for="lat_val">Enter Latitude: </label>';
	  echo '<input type="text" id="lat_val" name="lat_val" placeholder="Enter latitude" value='.$lat.'>';
	  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	  echo '<label for="longi_val">Enter Longitude: </label>';
	  echo '<input type="text" id="longi_val" name="longi_val" placeholder="Enter longitude" value='.$longi.'>';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<label for="areaAdd">Enter Area Address: </label>';
    echo '<input type="text" id="areaAdd" name="areaAdd" placeholder="Enter area address" value='.$address.'>';
	  echo '<br><label for="ECOD">Enable</label> : ';
	  if($edcbVal=="on") {
	  	$edcbVal= ' checked="on" ';
	  }else{ 
	  	$edcbVal =''; 
	  }
	  echo '<input type="checkbox" id="ECOD" name="ECOD" '. $edcbVal.'>';

	  $html = '<p class="description">';
      $html .= 'Upload Image : ';
	  $html .= '</p>';
	  $html .= '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25" />';
     
    echo $html;
	  //print_r($edcbVal);
}


add_action( 'save_post', 'map_box_save' );
function map_box_save( $post_id ) {
    /*echo "<pre>";
    print_r($_POST);*/
	  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	  return;

	  if ( !wp_verify_nonce( $_POST['map_box_content_nonce'], plugin_basename( __FILE__ ) ) )
	  return;

	  if ( 'page' == $_POST['post_type'] ) {
	    if ( !current_user_can( 'edit_page', $post_id ) )
	    return;
	  } else {
	    if ( !current_user_can( 'edit_post', $post_id ) )
	    return;
	  }
    if(isset($_POST['lat_val'])) {
	     update_post_meta( $post_id, 'lat_val', sanitize_text_field($_POST['lat_val']));
    }
    if(isset($_POST['longi_val'])) {
        update_post_meta( $post_id, 'longi_val', sanitize_text_field($_POST['longi_val']) ); 
    }
    if(isset($_POST['areaAdd'])) {
        update_post_meta( $post_id, 'areaAdd', sanitize_text_field($_POST['areaAdd']) ); 
    }
    if(!empty($_POST['ECOD'])) {
      update_post_meta( $post_id, 'ECOD', $_POST['ECOD']);
    }
    else { update_post_meta( $post_id, 'ECOD', ""); }
         
}



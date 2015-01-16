<?php



function icgm_custom_post_map() {
  $labels = array(
    'name'               => _x( 'Image Click Google Maps. USE THIS SHORTCODE : [icgm_maps]', 'post type general name' ),
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
    'supports'      => array( 'title', 'thumbnail'),
    'has_archive'   => true,
  );
  register_post_type( 'map', $args ); 
}
add_action( 'init', 'icgm_custom_post_map' );

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
    echo '<input type="text" class="widefat" id="lat_val" name="lat_val" placeholder="Enter latitude" value='.$lat.'>';
    echo '<label for="longi_val">Enter Longitude: </label>';
    echo '<input type="text" class="widefat" id="longi_val" name="longi_val" placeholder="Enter longitude" value='.$longi.'>';
    echo '<label for="areaAdd">Enter Area Address: </label>';
    echo '<textarea id="areaAdd" field="areaAdd" name="areaAdd" placeholder="Enter area address" class="widefat" value="40">'.$address."</textarea>";
    echo '<br><label for="ECOD">Enable</label> : ';
    if($edcbVal=="on") {
      $edcbVal= ' checked="on" ';
    }else{ 
      $edcbVal =''; 
    }
    echo '<input type="checkbox" id="ECOD" name="ECOD" '. $edcbVal.'>';
    //print_r($edcbVal);
}


add_action( 'save_post', 'map_box_save' );
function map_box_save( $post_id ) {
    /*echo "<pre>";
    print_r($_POST);*/
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
    return;

    if ( isset($_POST['map_box_content_nonce']) && !wp_verify_nonce( $_POST['map_box_content_nonce'], plugin_basename( __FILE__ ) ) )
    return;

    if ( 'page' == isset($_POST['map']) ) {
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


add_shortcode('icgm_maps', 'icgm_GMaps_shortcode');
function icgm_GMaps_shortcode() {
  global $post_id;
  $val = get_post_meta( $post_id, 'lat_val', true );
  echo $val;

  $args = array(
    'offset' => 0,
    'post_type' => 'map',
    'nopaging' => true 
  );
  $all_posts = new WP_Query( $args );
  //echo"<pre>";
  //print_r($all_posts);
  if ( $all_posts->have_posts() ) {
    ?>
    <div class="img-title">
      ACCOMODATIONS
    </div>
    <div class="ICGMap-Parent">
      <div class="Static-GMap">
        <img id="Static-GMap" src="https://maps.googleapis.com/maps/api/staticmap?center=40.756047,-73.9823259&zoom=13&size=600x300&markers=color:red|40.756047,-73.9823259" width="600" height="300">
      </div>
      <div id="rohit-ICGMaps-Main" class="icgmaps_main_class">
        <?php
          while ( $all_posts->have_posts() ) {
            $all_posts->the_post();
        ?>
            <div id="inner-map-image-<?php echo strtolower(str_replace(' ', '-', get_the_title())); ?>" class="inner-map-image location-images-main-<?php echo strtolower(str_replace(' ', '-', get_the_title())); ?>" data-lat="<?php echo get_post_meta(get_the_ID(),'lat_val', true); ?>" data-longi="<?php echo get_post_meta(get_the_ID(),'longi_val', true); ?>" style="cursor:pointer;">
            <?php
              echo get_the_post_thumbnail( $post_id, array(255, 94) ). '<br><div class="inner-image-title">' .get_the_title() .'</div>'. get_post_meta(get_the_ID(),'areaAdd', true).'<br>';
            ?>
            </div><br>
        <?php
          }
        ?>
      </div>
    </div>
    <?php
  } //else {
  // no posts found
  //}
}
?>
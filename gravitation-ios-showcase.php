<?php
/*
Plugin Name: Gravitation iOS Showcase
Plugin URI: https://github.com/UlisesFreitas/gravitation-ios-showcase
Description: Gravitation iOS Showcase, is a plugin to display iOS apps on your site, with ShortCodes, You can configure options.
Author: Ulises Freitas
Version: 1.0.0
Author URI: https://disenialia.com/
License: GPLv2
*/
/*-----------------------------------------------------------------------------*/
/*
	Gravitation iOS
    Copyright (C) 2015 Gravitation iOS

    This library is free software; you can redistribute it and/or
    modify it under the terms of the GNU Lesser General Public
    License as published by the Free Software Foundation; either
    version 2.1 of the License, or (at your option) any later version.

    This library is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public
    License along with this library; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
    USA


	Disenialia©, hereby disclaims all copyright interest in the
	library Gravitation iOS (a library for display iOS apps on Wordpress) 
	written by Ulises Freitas.
	
	Disenialia©, 21 October 2015
	CEO Ulises Freitas.
	
*/
/*-----------------------------------------------------------------------------*/
 
function gravitation_ios_install() {
	
    gravitation_ios_create_post_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'gravitation_ios_install' );

function gravitation_ios_deactivation() {
	
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'gravitation_ios_deactivation' );

/**
 *
 * Include Metaboxes
 */
require_once( 'custom-meta-boxes/custom-meta-boxes.php' );

function GravitationiOSShowcase($post_id){
	echo do_shortcode('[gravitation_ios_showcase ids="'.$post_id.'"]');
}

function gv_ios_hide_add_new_button() {
  global $pagenow, $post;
  if(is_admin()){
	if($pagenow == 'edit.php'){
		$gviOSShowcasePost = isset($post->post_type) ? $post->post_type : NULL;
		if($gviOSShowcasePost != NULL){
			if($gviOSShowcasePost == "gv_ios_showcase"){
				echo '<style type="text/css">h1 { display:none; }</style>';
			}
			
	
		}
	}  
  }
}

add_action('admin_menu', 'remove_add_new_post', 999);
function remove_add_new_post() {
    global $submenu;
    unset($submenu['edit.php?post_type=gv_ios_showcase'][10]);
}

function gv_ios_remove_screen_options_tab() {
    return false;
}
add_filter('screen_options_show_screen', 'gv_ios_remove_screen_options_tab');


add_filter( 'post_updated_messages', 'gv_ios_updated_messages' );
function gv_ios_updated_messages( $messages ) {
	
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['gv_ios_showcase'] = array(
		0  => '',
		1  => __( 'iOS Showcase updated.', 'gravitation-ios-showcase' ),
		2  => __( 'iOS Showcase updated.', 'gravitation-ios-showcase' ),
		3  => __( 'iOS Showcase deleted.', 'gravitation-ios-showcase' ),
		4  => __( 'iOS Showcase updated.', 'gravitation-ios-showcase' ),
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'iOSShowcase restored to revision from %s', 'gravitation-ios-showcase' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'iOS Showcase published.', 'gravitation-ios-showcase' ),
		7  => __( 'iOS Showcase saved.', 'gravitation-ios-showcase' ),
		8  => __( 'iOS Showcase submitted.', 'gravitation-ios-showcase' ),
		9  => sprintf(
			__( 'iOS Showcase scheduled for: <strong>%1$s</strong>.', 'gravitation-ios-showcase' ),
			date_i18n( __( 'M j, Y @ G:i', 'gravitation-ios-showcase' ), strtotime( $post->post_date ) )
		),
		10 => __( 'iOS Showcase draft updated.', 'gravitation-ios-showcase' )
	);

	if ( $post_type_object->publicly_queryable && $post_type == "gv_ios_showcase") {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View iOS Showcase', 'gravitation-ios-showcase' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'false', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview iOS Showcase', 'gravitation-ios-showcase' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}


function gv_ios_add_header_info() {
	
    global $pagenow ,$post;
    if($pagenow == 'edit.php' || $pagenow == 'post-new.php'){
		if($post != NULL){
			if($post->post_type == 'gv_ios_showcase'){
				$output = '<style>tfoot{display:none;}</style>';
				$output .= '<div class="my-div">';
				$output .= '<img src="'.WP_PLUGIN_URL.'/gravitation-ios-showcase/img/banner-header.png" alt="Gravitation iOS Showcase">';
				$output .= '</div>';

				echo $output;
			}
		}
	}
	$gv_ios_showcase = isset($_GET['post_type']) ? $_GET['post_type'] : NULL;
	$gv_ios_help = isset($_GET['page']) ? $_GET['page'] : NULL;
	
	if($gv_ios_showcase == "gv_ios_showcase" && $pagenow == 'edit.php' && !$post && $gv_ios_help != 'gravitation-ios-showcase.php'){
				$output .= '<div class="my-div">';
				$output .= '<img src="'.WP_PLUGIN_URL.'/gravitation-ios-showcase/img/banner-header.png" alt="Gravitation iOSShowcase">';
				$output .= '</div>';
				
				echo $output;
	}  
}
add_action('admin_notices','gv_ios_add_header_info');

add_filter( 'post_row_actions', 'gv_ios_remove_row_actions' );

function gv_ios_remove_row_actions( $actions ){

		global $post;
		
		if( $post->post_type == 'gv_ios_showcase'){
			
			unset($actions['inline hide-if-no-js']);
			unset($actions['trash']);
			unset($actions['view']);
			unset($actions['edit']);
       
			return $actions;
       }else{
	       	return $actions;
       }
}

function gv_ios_bulk_actions($actions){
		
		global $post;
		
		if( $post->post_type == 'gv_ios_showcase'){
	        unset( $actions['edit'] );
	        unset( $actions['trash'] );
	        return $actions;
        }else{
			return $actions;
		}
}
add_filter('bulk_actions-edit-gv_ios_showcase','gv_ios_bulk_actions');

add_action( 'admin_enqueue_scripts', 'gv_ios_admin_script' );
function gv_ios_admin_script() {
    wp_enqueue_script('gv_ios_admin_main_js', plugins_url( 'admin/js/main.js', __FILE__ ), array('jquery'), '1.0.0' , true );
}

function gv_ios_wp_admin_style() {
        wp_register_style( 'gv_ios_admin_style',  plugins_url( 'admin/css/admin-styles.css', __FILE__ ), false, '1.0.0' );
        wp_enqueue_style( 'gv_ios_admin_style' );
}
add_action( 'admin_enqueue_scripts', 'gv_ios_wp_admin_style' );

function gravitation_ios_showcase_stylesheet() {
	 	
	 	wp_enqueue_style( 'gravitation_ios_showcase_slider_main', plugins_url( 'css/responsiveslides.css', __FILE__ ) );
	 	wp_enqueue_style( 'gravitation_ios_showcase_style', plugins_url( 'css/gv-ios-showcase-styles.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'gravitation_ios_showcase_stylesheet', 15, 2 );

function gravitation_ios_scripts(){
	
	    wp_enqueue_script('gravitation_ios_showcase_easing', plugin_dir_url( __FILE__ ).'js/jquery.easing.1.3.js', array('jquery'), '20150212', true  );
	 	wp_enqueue_script('gravitation_ios_showcase_quicksand', plugin_dir_url( __FILE__ ).'js/jquery.quicksand.js', array('jquery'), '20150212', true  );
	    wp_enqueue_script('gravitation_ios_showcase_slider_j', plugin_dir_url(__FILE__).'js/responsiveslides.min.js',array('jquery'),'100',true );
	    wp_enqueue_script('gravitation_ios_showcase_functions', plugin_dir_url( __FILE__ ).'js/functions.js', array('jquery'), '20150212', true  );
}
add_action('wp_enqueue_scripts','gravitation_ios_scripts', 15, 2);

add_filter('widget_text', 'do_shortcode');

add_filter( 'manage_posts_columns', 'gv_ios_set_edit_columns' );

add_action( 'manage_gv_ios_showcase_posts_custom_column' , 'gv_ios_column', 10, 2 );

function gv_ios_set_edit_columns($columns) {
    
 	global $post;
    if(get_post_type( $post->ID ) == "gv_ios_showcase"){
    unset($columns['cb']);
    unset( $columns['author'] );
    unset( $columns['date'] );
	
	$columns['gv-ios-showcase-field-60'] = __('App Icon', 'gravitation-ios-showcase');
    $columns['gv-ios-showcase-field-74'] = __( 'Developer Name', 'gravitation-ios-showcase' );
    $columns['gravitation_ios_shortcode'] = __( 'Shortcode', 'gravitation-ios-showcase' );
    $columns['gv-ios-showcase-field-69'] = __( 'iTunes Link', 'gravitation-ios-showcase' );
   
    	return $columns;
    }else{
    	return $columns;
    }
}

function gv_ios_column( $column, $post_id ) {
    
    switch ( $column ) {
	    
	    	case 'gv-ios-showcase-field-69' :
	    		$urlLink = get_post_meta($post_id, 'gv-ios-showcase-field-69', true);
	    		echo '<a href="'.$urlLink.'" class="button button-primary" target="_blank">See on iTunes</a>';
	    		break;
	     
	    case 'gv-ios-showcase-field-60' :
			$icon = get_post_meta( get_the_ID(), 'gv-ios-showcase-field-60', true );
			$icon_image =  wp_get_attachment_image_src( $icon, 'full', false, '' ); 
	    	echo '<img src="'.$icon_image[0].'" width="32" alt="App Icon">';
	    	break;
	    	
	    	
		case 'gv-ios-showcase-field-74' :
			$artistName = get_post_meta($post_id, 'gv-ios-showcase-field-74', true);
			echo $artistName;
			break;
        case 'gravitation_ios_shortcode' :
        	echo '[gravitation_ios_showcase ids="' . $post_id . '"]';
            break;
    }
}

function custom_pagination($numpages = '', $pagerange = '', $paged='') {
	
	if (empty($pagerange)) {
		$pagerange = 2;
	}

	if(is_front_page()){
		$paged = (get_query_var('page')) ? get_query_var('page') : 1;
	}else{
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}
	
	if ($numpages == '') {
    	global $wp_query;
		$numpages = $wp_query->max_num_pages;
		if(!$numpages) {
        	$numpages = 1;
		}
	}

	$pagination_args = array(
		'base'            => get_pagenum_link(1) . '%_%',
		'format'          => 'page/%#%',
		'total'           => $numpages,
		'current'         => $paged,
		'show_all'        => False,
		'end_size'        => 1,
		'mid_size'        => $pagerange,
		'prev_next'       => True,
		'prev_text'       => __('&laquo;'),
		'next_text'       => __('&raquo;'),
		'type'            => 'plain',
		'add_args'        => false,
		'add_fragment'    => ''
	);

	$paginate_links = paginate_links($pagination_args);

	if ($paginate_links) {
		echo '<nav class="pagination" id="pagination">';
		//echo '<span class="page-numbers page-num">Page ' . $paged . ' of ' . $numpages . '</span>';
		echo $paginate_links;
		echo '</nav>';
	}
}

function get_gravitation_ios_showcase_single_template($single_template) {
     global $post;

     if ($post->post_type == 'gv_ios_showcase') {
          $single_template = plugin_dir_path(__FILE__). 'single-gravitation-ios-showcase.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_gravitation_ios_showcase_single_template' );

function gravitation_ios_shortcode($atts, $content=null){
   
$gv_ios_showcase_count = get_option('gv_ios_showcase_count');
$gv_ios_showcase_order = get_option('gv_ios_showcase_order');

if($gv_ios_showcase_order == '0' || $gv_ios_showcase_order == 0){
	$gv_ios_showcase_order = 'DESC';
}else{
	$gv_ios_showcase_order = 'ASC';
}

if(is_front_page()){
	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
}else{
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$args = array();

extract(shortcode_atts(array(
	    'ids' => '',
	    'category' => '',
		'count' => $gv_ios_showcase_count,
		'order' => $gv_ios_showcase_order,
		'orderby' => 'date',
        
    ), $atts)); 
    
	
	
	
	//All ios_showcases [gravitation_ios_showcase]
	if(!$ids){
		$args=array(
			
			'post_type' => 'gv_ios_showcase',
			'post_status'=> 'publish',
			'posts_per_page' => intval($count),
			'paged' => $paged,
			'order' => $order,
			'orderby' => $orderby,
			
		);
	}
	
	if( $ids && !$category ){
		$cids = explode(',', $ids);
		$aids = array();
		foreach($cids as $key => $value){	
			$aids[] = $value;
		}
		$count = count($cids);
		$args['post__in'] = implode(',', $aids);
		
		$args=array(
			
			'post_type' => 'gv_ios_showcase',
			'post__in' => $aids,
			'posts_per_page' => intval($count),
			'paged' => $paged,
			'post_status'=> 'publish',
			'order' => $order,
			'orderby' => $orderby,
		);
	}

	$query = new WP_Query($args);
	
	
    if ($query->have_posts()){ ?>
    
    <div id="ios-showcase">
        <ul id="filterOptions" class="filterOptions">
			<li class="active"><a href="#" class="all"><?php _e('All','gravitation-ios-showcase');?></a></li>
			<?php				
				
				$terms = get_terms('gravitation_ios_showcase_cat', $args);
				$terms_count = count($terms); 
				$i=0;
				$term_list = '';
				if ($terms_count > 0) {
					foreach ($terms as $term) {
						$i++;
						if($term->count !=  0){
							$term_list .= '<li><a href="#" class="ios-showcase-'. $term->slug .'">' . $term->name . ' <span></span></a></li>';
						}
						// if count is equal to i then output blank
						if ($terms_count != $i){
							$term_list .= '';
						}else{
							$term_list .= '';
						}
					}
					echo $term_list;
				}
			?>
		</ul>
		<ul class="ourHolder list-unstyled list-inline grid" id="itemContainer">
			<?php 
				while ( $query->have_posts() ) : $query->the_post(); 

				$terms = get_the_terms( get_the_ID(), 'gravitation_ios_showcase_cat' ); 
				
				$icon = get_post_meta( get_the_ID(), 'gv-ios-showcase-field-60', true );
				$icon_image =  wp_get_attachment_image_src( $icon, 'full', false, '' ); 
				
				?>
				<li class="item col-md-4" data-id="id-<?php echo get_the_ID(); ?>" data-type="ios-showcase-<?php foreach ($terms as $term) { echo $term->slug; } ?>">
				
				<a href="<?php echo get_permalink(get_the_ID()); ?>">
				
					<?php if(!empty($icon_image[0])):?>
						<img src="<?php echo $icon_image[0]; ?>" alt="<?php echo get_the_title(); ?>">
					<?php else: ?>
						<img src="<?php echo plugins_url().'/gravitation-ios-showcase/images/set_a_thumbnail.png';?>" alt="">
					<?php endif; ?>			
				
				</a>
				</li>
			<?php endwhile; ?>	
	    </ul>

		    
			<div class="clear"></div>
			<div class="holder"></div>
				<!-- pagination here -->
				    <?php
				    if (function_exists('custom_pagination')) {
				        custom_pagination($query->max_num_pages,"",$paged);
					  }
				    ?>
    </div>
		<?php
			
	wp_reset_query();
	
	}
	?>
	
<?php	
}
add_shortcode('gravitation_ios_showcase', 'gravitation_ios_shortcode');    		


add_action('admin_head','gv_ios_hide_add_new_button');

function gv_ios_add_custom_title( $title ) {
	
	global $pagenow,$post_type ;
	
	if($pagenow == 'post-new.php' && $post_type == 'gv_ios_showcase'){
		
		$appid = isset($_POST['appid']) ?  $_POST['appid'] : NULL;
		if($appid != NULL){
			$app = FindApp( $appid, 'us');
		    $title = $app['results'][0]['trackName'];
	    }
		
		
		return $title;
  	}else{
	  return $title;
  	}
}

add_filter('default_title', 'gv_ios_add_custom_title');

add_action( 'load-post-new.php', 'gv_ios_showcase_post_new' );

function gv_ios_showcase_post_new(){
    
   
	$appId = isset($_POST['appid']) ?  $_POST['appid'] : NULL;
	$countryCode = isset($_POST['countryCode']) ? $_POST['countryCode'] : 'us';
		if($appId != NULL){
			$app = FindApp( $_POST['appid'], $countryCode);
			
			if($app['resultCount'] > 0){
				
				$my_post = array(
				  'post_title'    => wp_strip_all_tags( $app['results'][0]['trackName'] ),
				  'post_content'  => $app['results'][0]['description'],
				  'post_status'   => 'publish',
				  'post_author'   => 1,
				  'post_category' => array(),
				  'post_type' => 'gv_ios_showcase',
				);
				
				
				
				$postID = wp_insert_post( $my_post );
				
				//iPhones
				//['screenshotUrls']
				if(count($app['results'][0]['screenshotUrls']) > 0){
				for($i=0;$i< count($app['results'][0]['screenshotUrls']);$i++){
					// Need to require these files
					if ( !function_exists('media_handle_upload') ) {
						require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						require_once(ABSPATH . "wp-admin" . '/includes/file.php');
						require_once(ABSPATH . "wp-admin" . '/includes/media.php');
					}
				
					$url = $app['results'][0]['screenshotUrls'][$i];
					$tmp = download_url( $url );
					if( is_wp_error( $tmp ) ){
						// download failed, handle error
					}
					$post_id = 1;
					$desc = $app['results'][0]['trackName']. '-' . $i;
					$file_array = array();
				
					// Set variables for storage
					// fix file filename for query strings
					preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches);
					$file_array['name'] = basename($matches[0]);
					$file_array['tmp_name'] = $tmp;
				
					// If error storing temporarily, unlink
					if ( is_wp_error( $tmp ) ) {
						@unlink($file_array['tmp_name']);
						$file_array['tmp_name'] = '';
					}
				
					// do the validation and storage stuff
					$id = media_handle_sideload( $file_array, $post_id, $desc );
				
					// If error storing permanently, unlink
					if ( is_wp_error($id) ) {
						@unlink($file_array['tmp_name']);
						return $id;
					}
				
					$src = wp_get_attachment_url( $id );
					
					//gv_ios_group[cmb-group-0][gv-ios-showcase-gfield-1][cmb-field-0]
					//gv_ios_group[cmb-group-1][gv-ios-showcase-gfield-1][cmb-field-0]
				
					add_post_meta( $postID, 'gv-ios-showcase-field-3'.$i, $id );
					
				}
				}
				//Ipads
				//[ipadScreenshotUrls] => Array ( ) 
				if(count($app['results'][0]['ipadScreenshotUrls']) > 0){
				for($i=0;$i< count($app['results'][0]['ipadScreenshotUrls']);$i++){
					// Need to require these files
					if ( !function_exists('media_handle_upload') ) {
						require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						require_once(ABSPATH . "wp-admin" . '/includes/file.php');
						require_once(ABSPATH . "wp-admin" . '/includes/media.php');
					}
				
					$url = $app['results'][0]['ipadScreenshotUrls'][$i];
					$tmp = download_url( $url );
					if( is_wp_error( $tmp ) ){
						// download failed, handle error
					}
					$post_id = 1;
					$desc = $app['results'][0]['trackName']. '-' . $i;
					$file_array = array();
				
					// Set variables for storage
					// fix file filename for query strings
					preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches);
					$file_array['name'] = basename($matches[0]);
					$file_array['tmp_name'] = $tmp;
				
					// If error storing temporarily, unlink
					if ( is_wp_error( $tmp ) ) {
						@unlink($file_array['tmp_name']);
						$file_array['tmp_name'] = '';
					}
				
					// do the validation and storage stuff
					$id = media_handle_sideload( $file_array, $post_id, $desc );
				
					// If error storing permanently, unlink
					if ( is_wp_error($id) ) {
						@unlink($file_array['tmp_name']);
						return $id;
					}
				
					$src = wp_get_attachment_url( $id );
					
					//gv_ios_group[cmb-group-0][gv-ios-showcase-gfield-1][cmb-field-0]
					//gv_ios_group[cmb-group-1][gv-ios-showcase-gfield-1][cmb-field-0]
				
					add_post_meta( $postID, 'gv-ios-showcase-field-4'.$i, $id );
					
				}
				}
				//[appletvScreenshotUrls] => Array ( ) 
				if(count($app['results'][0]['appletvScreenshotUrls']) > 0){
				for($i=0;$i< count($app['results'][0]['appletvScreenshotUrls']);$i++){
					// Need to require these files
					if ( !function_exists('media_handle_upload') ) {
						require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						require_once(ABSPATH . "wp-admin" . '/includes/file.php');
						require_once(ABSPATH . "wp-admin" . '/includes/media.php');
					}
				
					$url = $app['results'][0]['appletvScreenshotUrls'][$i];
					$tmp = download_url( $url );
					if( is_wp_error( $tmp ) ){
						// download failed, handle error
					}
					$post_id = 1;
					$desc = $app['results'][0]['trackName']. '-' . $i;
					$file_array = array();
				
					// Set variables for storage
					// fix file filename for query strings
					preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches);
					$file_array['name'] = basename($matches[0]);
					$file_array['tmp_name'] = $tmp;
				
					// If error storing temporarily, unlink
					if ( is_wp_error( $tmp ) ) {
						@unlink($file_array['tmp_name']);
						$file_array['tmp_name'] = '';
					}
				
					// do the validation and storage stuff
					$id = media_handle_sideload( $file_array, $post_id, $desc );
				
					// If error storing permanently, unlink
					if ( is_wp_error($id) ) {
						@unlink($file_array['tmp_name']);
						return $id;
					}
				
					$src = wp_get_attachment_url( $id );
				
					add_post_meta( $postID, 'gv-ios-showcase-field-5'.$i, $id );
					
				}
				}
								
					if ( !function_exists('media_handle_upload') ) {
						require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						require_once(ABSPATH . "wp-admin" . '/includes/file.php');
						require_once(ABSPATH . "wp-admin" . '/includes/media.php');
					}
				
					$url = $app['results'][0]['artworkUrl512'];
					$tmp = download_url( $url );
					if( is_wp_error( $tmp ) ){
						// download failed, handle error
					}
					$post_id = 1;
					$desc = $app['results'][0]['trackName'];
					$file_array = array();
				
					// Set variables for storage
					// fix file filename for query strings
					preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches);
					$file_array['name'] = basename($matches[0]);
					$file_array['tmp_name'] = $tmp;
				
					// If error storing temporarily, unlink
					if ( is_wp_error( $tmp ) ) {
						@unlink($file_array['tmp_name']);
						$file_array['tmp_name'] = '';
					}
				
					// do the validation and storage stuff
					$id = media_handle_sideload( $file_array, $post_id, $desc );
				
					// If error storing permanently, unlink
					if ( is_wp_error($id) ) {
						@unlink($file_array['tmp_name']);
						return $id;
					}
				
					
				//[artworkUrl512] => http://is1.mzstatic.com/image/thumb/Purple4/v4/70/96/6d/70966d12-5c8f-8a94-1ce0-31efdc4b6f0c/source/60x60bb.jpg 
				add_post_meta( $postID, 'gv-ios-showcase-field-60', $id );
				
				//[artistViewUrl] => https://itunes.apple.com/us/developer/ulises-freitas/id515252192?uo=4
				add_post_meta( $postID, 'gv-ios-showcase-field-61', $app['results'][0]['artistViewUrl'] );
				
				//[isGameCenterEnabled] => 
				$gameCenter = !empty($app['results'][0]['isGameCenterEnabled']) ? $app['results'][0]['isGameCenterEnabled'] : 'No';
				if($gameCenter != 'No'){
					add_post_meta( $postID, 'gv-ios-showcase-field-62', __('Yes','gv-ios-showcase') );
				}else{
					add_post_meta( $postID, 'gv-ios-showcase-field-62', __('No','gv-ios-showcase') );
				}
				
				
				//[kind] => software 
				add_post_meta( $postID, 'gv-ios-showcase-field-63', $app['results'][0]['kind'] );
				
				$supportedDevices = '';
				foreach($app['results'][0]['supportedDevices'] as $value){
					$supportedDevices .= $value.',';
				}
				//[supportedDevices]
				add_post_meta( $postID, 'gv-ios-showcase-field-64', $supportedDevices );
				//[sellerUrl]
				add_post_meta( $postID, 'gv-ios-showcase-field-65', $app['results'][0]['sellerUrl'] );
				
				//[contentAdvisoryRating] => 4+ 
				add_post_meta( $postID, 'gv-ios-showcase-field-66', $app['results'][0]['contentAdvisoryRating'] );
				
				//languageCodesISO2A
				$languages = '';
				foreach($app['results'][0]['languageCodesISO2A'] as $lang){
					$languages .= $lang.',';
				}
				add_post_meta( $postID, 'gv-ios-showcase-field-67', $languages );
				
			
				function bytesToSize($bytes) {
                $sizes = array('Bytes', 'KB', 'MB', 'GB', 'TB');
                if ($bytes == 0) return 'n/a';
                $i = intval(floor(log($bytes) / log(1000)));
                if ($i == 0) return $bytes . ' ' . $sizes[$i]; 
                return round(($bytes / pow(1000, $i)),1,PHP_ROUND_HALF_UP). ' ' . $sizes[$i];
            }
				//[fileSizeBytes]
				$sizeInMB = number_format(bytesToSize($app['results'][0]['fileSizeBytes']) ,2);
				
				add_post_meta( $postID, 'gv-ios-showcase-field-68', $sizeInMB.' MB' );
				
				
				//[trackViewUrl] => https://itunes.apple.com/us/app/everboy-data-unit/id834634254?mt=8&uo=4 
				add_post_meta( $postID, 'gv-ios-showcase-field-69',  $app['results'][0]['trackViewUrl']);
				
				
				//[formattedPrice] => Free 
				add_post_meta( $postID, 'gv-ios-showcase-field-70',  $app['results'][0]['formattedPrice']);
				
				//[minimumOsVersion] => 7.1 
				add_post_meta( $postID, 'gv-ios-showcase-field-71',  $app['results'][0]['minimumOsVersion']);
				
				//[currency] => USD 
				add_post_meta( $postID, 'gv-ios-showcase-field-72',  $app['results'][0]['currency']);
				
				//[version] => 1.0.1 
				add_post_meta( $postID, 'gv-ios-showcase-field-73',  $app['results'][0]['version']);
				
				//[artistName] => Ulises Freitas 
				add_post_meta( $postID, 'gv-ios-showcase-field-74',  $app['results'][0]['artistName']);
				
				$genres = '';
				foreach($app['results'][0]['genres'] as $genre){
					$genres .= $genre.',';
				}
				add_post_meta( $postID, 'gv-ios-showcase-field-75', $genres );
				
				//[releaseDate] => 2014-03-12T21:15:09Z 
				$date = strtotime($app['results'][0]['releaseDate']); 
				$new_date = date('d-m-Y', $date);
				
				
				add_post_meta( $postID, 'gv-ios-showcase-field-76', $new_date );
				
				//[releaseNotes] => - New Logo - Difficulty improvement - Improved game performance frame rate 
				//add_post_meta( $postID, 'gv-ios-showcase-field-77', html_specialchars($app['results'][0]['releaseNotes']) );
				
				//[sellerName] => Ulises Freitas 
				add_post_meta( $postID, 'gv-ios-showcase-field-78', $app['results'][0]['sellerName'] );
				
				wp_update_post( array( $postID ) );
				
				wp_redirect( admin_url('post.php?post='.$postID.'&action=edit') ); exit;
			}
			
			
		}
		
	
    
    
}

//wp_insert_post_data

add_filter( 'cmb_meta_boxes', 'createAppMetas' );

function createAppMetas(){
	
	$countryCode = isset($_POST['countryCode']) ? $_POST['countryCode'] : 'us';
	
	$appid = isset($_POST['appid']) ? $_POST['appid'] : NULL;
	
	$app = FindApp( $appid, $countryCode);
	//screenshotUrls
	$fields = array(
			array( 'id' => 'gv-ios-showcase-field-30',  'name' => 'Image', 'type' => 'image' ,'cols' => 4),
			array( 'id' => 'gv-ios-showcase-field-31',  'name' => 'Image', 'type' => 'image' ,'cols' => 4),
			array( 'id' => 'gv-ios-showcase-field-32',  'name' => 'Image', 'type' => 'image' ,'cols' => 4),
			array( 'id' => 'gv-ios-showcase-field-33',  'name' => 'Image', 'type' => 'image' ,'cols' => 4),
			array( 'id' => 'gv-ios-showcase-field-34',  'name' => 'Image', 'type' => 'image' ,'cols' => 4),
		);
	
		 $meta_boxes[] = array(
			'title' => 'Images iPhones',
			'pages' => 'gv_ios_showcase',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => $fields,
		);
	//iPad
	$fields = array(
			array( 'id' => 'gv-ios-showcase-field-40',  'name' => 'Image', 'type' => 'image' ),
			array( 'id' => 'gv-ios-showcase-field-41',  'name' => 'Image', 'type' => 'image' ),
			array( 'id' => 'gv-ios-showcase-field-42',  'name' => 'Image', 'type' => 'image' ),
			array( 'id' => 'gv-ios-showcase-field-43',  'name' => 'Image', 'type' => 'image' ),
			array( 'id' => 'gv-ios-showcase-field-44',  'name' => 'Image', 'type' => 'image' ),
		);
	
		 $meta_boxes[] = array(
			'title' => 'Images iPads',
			'pages' => 'gv_ios_showcase',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => $fields,
		);
	//AppleTv
	$fields = array(
			array( 'id' => 'gv-ios-showcase-field-50',  'name' => 'Image', 'type' => 'image' ),
			array( 'id' => 'gv-ios-showcase-field-51',  'name' => 'Image', 'type' => 'image' ),
			array( 'id' => 'gv-ios-showcase-field-52',  'name' => 'Image', 'type' => 'image' ),
			array( 'id' => 'gv-ios-showcase-field-53',  'name' => 'Image', 'type' => 'image' ),
			array( 'id' => 'gv-ios-showcase-field-54',  'name' => 'Image', 'type' => 'image' ),
		);
	
		 $meta_boxes[] = array(
			'title' => 'Images AppleTv',
			'pages' => 'gv_ios_showcase',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => $fields,
		);
		//ICON

	$fields = array(
			array( 'id' => 'gv-ios-showcase-field-60',  'name' => 'Icon', 'type' => 'image' ),
						
		);
	
		 $meta_boxes[] = array(
			'title' => 'Icon 512',
			'pages' => 'gv_ios_showcase',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => $fields,
		);
		
	$fields = array(
			array( 'id' => 'gv-ios-showcase-field-61',  'name' => 'Artist URL', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-62',  'name' => 'Game Center', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-63',  'name' => 'Kind of App', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-64',  'name' => 'Supported Devices', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-65',  'name' => 'Seller Url', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-66',  'name' => 'Content Advisory', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-67',  'name' => 'Languages', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-68',  'name' => 'Filesize in MB', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-69',  'name' => 'Link to this App', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-70',  'name' => 'Price', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-71',  'name' => 'Minimum iOS Version', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-72',  'name' => 'Currency', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-73',  'name' => 'App Version', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-74',  'name' => 'Artist name', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-75',  'name' => 'Genres', 'type' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-76',  'name' => 'Release Date', 'type' => 'text' ),
			//array( 'id' => 'gv-ios-showcase-field-77',  'name' => 'Release notes' => 'text' ),
			array( 'id' => 'gv-ios-showcase-field-78',  'name' => 'Seller name', 'type' => 'text' ),

		);
	
	
		 $meta_boxes[] = array(
			'title' => 'App Information',
			'pages' => 'gv_ios_showcase',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => $fields,
		);

	
	
	$fields = array(
		array( 'id' => 'gv-ios-showcase-field-80',  'name' => 'Display iPhone/iPad/Apple Tv images', 'type' => 'select', 'options' => array( 'iphone' => 'iPhone', 'ipad' => 'iPad', 'appleTv' => 'Apple Tv' ) ),
			
	);
	
	$meta_boxes[] = array(
			'title' => 'Display Images',
			'pages' => 'gv_ios_showcase',
			'context' => 'side',
			'priority' => 'low',
			'fields' => $fields,
		);
	
	return $meta_boxes;
}



add_action('admin_menu' , 'gravitation_ios_help_admin_menu'); 

function gravitation_ios_help_admin_menu() {
  
	add_submenu_page('edit.php?post_type=gv_ios_showcase', __('Search/Add App', 'gravitation-slider'), __('Search/Add App', 'gravitation-slider'), 'administrator', basename(__FILE__), 'app_search_admin_sub_page');	

	 

}


function app_add_edit_admin_sub_page(){	}

function app_search_admin_sub_page(){
	
	$countryCode = isset($_POST['countryCode']) ? $_POST['countryCode'] : 'us';
	$appid = isset($_POST['appid']) ? $_POST['appid'] : NULL;
	
	$app = FindApp( $appid, $countryCode );
	
	
	$output = '<div class="wrap">';
	$output .= '<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-1">
						<div id="post-body-content">
							<div class="left">';
							
	
	if($app['resultCount'] <= 0 ){
		
		$output .= '<form role="form" id="add-app" action="edit.php?post_type=gv_ios_showcase&page=gravitation-ios-showcase.php" method="post">
	        
		        <label for="exampleInputEmail1">App ID</label>
		        <input class="form-control" id="appid" name="appid" type="text" placeholder="Like this 834634254" value="834634254">
		        
		    	<label for="exampleInputEmail1">Country Code</label>
		        <input class="form-control" id="countryCode" name="countryCode" type="text" placeholder="Like this es - Lowercase" value="es">
		    	<button type="submit" class="button button-primary button-large" id="checkApp">Check My App</button>
				<div id="loader"></div>
				<div id="success-app"></div>
				<div id="appResult"></div>	
			
			</form>';
		
	}else{
		
		$output .= '<div><h2>'.$app['results'][0]['trackCensoredName'].'</h2><img src="'.$app['results'][0]['artworkUrl512'].'" alt="Foto" width="170" height="170"></div>';
		$output .='<form action="post-new.php?post_type=gv_ios_showcase" method="post">
			
				
				<input id="countryCode" name="countryCode" type="hidden" value="'.$countryCode.'">
				<input id="appid" name="appid" type="hidden" value="'.$app['results'][0]['trackId'].'">
				<input type="submit" name="addwork" class="button button-primary button-large" value="Add App Now!!!">';
	}
	
	$output .= '</div></div>';
	$output .= '<h2>Help</h2>';			
	$output .=	'<p>For Gravitation iOSShowcase to work you have to create a iOSShowcase over <strong>"Add New iOSShowcase"</strong></p><hr>';
	$output .= '<h2>Type of shortcodes:</h2>';
	$output .= '<strong>[gravitation_ios_showcase]</strong>';
	$output .= '</div></div></div><hr>';
	
	
	echo $output;
	
	
	if(isset($_REQUEST['update_gravitation_ios_showcase_settings'])){ 
		if ( !isset($_POST['gravitation_ios_showcase_nonce']) || !wp_verify_nonce($_POST['gravitation_ios_showcase_nonce'],'gravitation_ios_showcase_settings') ){
		    _e('Sorry, your nonce did not verify.', 'gravitation-ios-showcase');
		   exit;
		}else{
			
			update_option('gv_ios_showcase_order',$_POST['gv_ios_showcase_order']);
		  	update_option('gv_ios_showcase_count',$_POST['gv_ios_showcase_count']);
		  
		}
	}
	?>
	<form method="post" action="edit.php?post_type=gv_ios_showcase&page=gravitation-ios-showcase.php">
	<?php settings_fields( 'gravitation-ios-showcase-settings-group' ); ?>
	<?php do_settings_sections( 'gravitation-ios-showcase-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('Apps order','gravitation-ios-showcase'); ?></th>
        <td>
        <select name="gv_ios_showcase_order">
			<?php
				$check_gv_ios_showcase_order = get_option('gv_ios_showcase_order');
				for($i=0;$i<2;$i++){
					if($i == 0){
						$gv_ios_showcase_order = __('Older first','gravitation-ios-showcase');
					}else{
						$gv_ios_showcase_order = __('Latest first','gravitation-ios-showcase');
					}
					echo '<option value="'.$i.'"'.selected($check_gv_ios_showcase_order, $i, false).'>'.$gv_ios_showcase_order.'</option>';	 
				}		 
			?>										
		</select>
        </td>
        </tr>
        <tr valign="top">
        <th scope="row"><?php echo __('Number of apps to show on Showcase page','gravitation_portfolios'); ?></th>
        <td><input type="number" name="gv_ios_showcase_count" value="<?php echo esc_attr( get_option('gv_ios_showcase_count') ); ?>" /></td>
        </tr>
        
    </table>

	<?php wp_nonce_field( 'gravitation_ios_showcase_settings', 'gravitation_ios_showcase_nonce' ); ?>
    <p class="submit">
        <input class="button-primary" type="submit" name="update_gravitation_ios_showcase_settings" value="<?php _e( 'Save Settings', 'gravitation-ios-showcase' ) ?>" />
    </p> 
	</form>
	<?php
	
	
}
		

function gravitation_ios_app_search_page(){}
function gravitation_ios_help_page() {}

	
if( ! function_exists( 'gravitation_ios_create_post_type' ) ) :

	function gravitation_ios_create_post_type() {
		
		$labels = array(
		'name'                => _x( 'GV. iOS Showcase', 'Post Type General Name', 'gravitation-ios-showcase' ),
		'singular_name'       => _x( 'GV. iOS Showcase', 'Post Type Singular Name', 'gravitation-ios-showcase' ),
		'menu_name'           => __( 'GV. iOS Showcase', 'gravitation-ios-showcase' ),
		'name_admin_bar'      => __( 'GV. iOS Showcase', 'gravitation-ios-showcase' ),
		'parent_item_colon'   => __( 'Parent iOS Showcase:', 'gravitation-ios-showcase' ),
		'all_items'           => __( 'All iOS Apps', 'gravitation-ios-showcase' ),
		'add_new_item'        => __( 'Add iOS App', 'gravitation-ios-showcase' ),
		'add_new'             => __( 'Add New App', 'gravitation-ios-showcase' ),
		'new_item'            => __( 'New App', 'gravitation-ios-showcase' ),
		'edit_item'           => __( 'Edit App', 'gravitation-ios-showcase' ),
		'update_item'         => __( 'Update app', 'gravitation-ios-showcase' ),
		'view_item'           => __( 'View app', 'gravitation-ios-showcase' ),
		'search_items'        => __( 'Search app', 'gravitation-ios-showcase' ),
		'not_found'           => __( 'App Not found', 'gravitation-ios-showcase' ),
		'not_found_in_trash'  => __( 'App Not found in Trash', 'gravitation-ios-showcase' ),
	);
	
	$args = array(
		'label'               => __( 'GV. iOS Showcase', 'gravitation-ios-showcase' ),
		'description'         => __( 'GV. iOS Showcase', 'gravitation-ios-showcase' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-gallery',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'rewrite'             => array('slug' => 'gv_ios_showcase', 'with_front' => true),
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'query_var' => true,
		'capability_type'     => 'post'
		//'register_meta_box_cb' => 'gravitation_ios_add_post_type_metabox'
	);

		register_post_type( 'gv_ios_showcase', $args );
		//flush_rewrite_rules();
		
		register_taxonomy( 'gravitation_ios_showcase_cat', // register custom taxonomy - category
			'gv_ios_showcase',
			array(
				'hierarchical' => true,
				'show_in_nav_menus'   => true,
				'labels' => array(
					'name' => 'iOS Showcase Category',
					'singular_name' => 'iOS Showcase Category',
				),
				'rewrite' => array(
							'slug' => 'gravitation_ios_showcase_cat', 
							'hierarchical' => true,
							),
			)
		);
		
		
}

	add_action( 'init', 'gravitation_ios_create_post_type' );
 
/*
function gravitation_ios_add_post_type_metabox() { // add the meta box
	add_meta_box( 'gravitation_ios_metabox', 'Additionl information about this app', 'gravitation_ios_metabox', 'gv_ios_showcase', 'normal' );
}
 
function gravitation_ios_metabox() {

		global $post;
		echo '<input type="hidden" name="ios_showcase_post_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
 
}
 
function gravitation_ios_post_save_meta( $post_id, $post ) {

		 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		  return;
 
		if ( ! isset( $_POST['ios_showcase_post_noncename'] ) ) {
			return;
		}
 
		if( !wp_verify_nonce( $_POST['ios_showcase_post_noncename'], plugin_basename(__FILE__) ) ) {
			return $post->ID;
		}
 
		if( ! current_user_can( 'edit_post', $post->ID )){
			return $post->ID;
		}
}
add_action( 'save_post', 'gravitation_ios_post_save_meta', 1, 2 );

*/

endif;

function gravitation_ios_replace_submit_meta_box(){

  $items = array( 'gv_ios_showcase' => 'iOSShowcase' );
   
  foreach( $items as $item => $value ){
     remove_meta_box('submitdiv', $item, 'core');
     add_meta_box('submitdiv', sprintf( __('Save/Update %s'), $value ), 'gravitation_ios_submit_meta_box', $item, 'side', 'high');
  }
}
add_action( 'admin_menu', 'gravitation_ios_replace_submit_meta_box' );

function gravitation_ios_submit_meta_box() {
	global $action, $post;
	$post_type = $post->post_type;
	$post_type_object = get_post_type_object($post_type);
	$can_publish = current_user_can($post_type_object->cap->publish_posts);
	$items = array( 'gv_ios_showcase' => 'iOSShowcase' );
	$item = $items[$post_type];
	
	echo '<div class="submitbox" id="submitpost">';
	echo '<div id="major-publishing-actions">';
	do_action( 'post_submitbox_start' );
	echo '<div id="delete-action">';
	
	 if ( current_user_can( "delete_post", $post->ID ) ) {
	   if ( !EMPTY_TRASH_DAYS ){
	        $delete_text = __('Delete iOSShowcase');
	   }else{
	        $delete_text = __('Delete iOSShowcase');
	   }
	   echo  '<a style="position: relative;right: -150px;margin-bottom: 10px;" class="submitdelete deletion button button-large" href="' . get_delete_post_link($post->ID) . '">' . $delete_text . '</a>';
	}
	
	echo '</div>';
	echo '<div id="publishing-action"><span class="spinner"></span>';
	 
	 if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) {
	       if ( $can_publish ) :
	        	echo '<input name="original_publish" type="hidden" id="original_publish" value="Save Changes" />';
				submit_button( sprintf( __( 'Save Changes %' ), $item ), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ) );
			endif;
	} else {
		echo '<input name="original_publish" type="hidden" id="original_publish" value="Update Changes" />';
	    echo '<input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Update Changes" />';
	}
	echo '</div><div class="clear"></div></div></div>';
	
}

function FindApp( $appId, $country = 'us' ){
	
	$countryCode = $country;
	$id = $appId;
	// add the id to the url
	$apiUrl = 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsLookup?id='.$id.'&country='.$countryCode;

	// setup the cURL call
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $apiUrl);
	curl_setopt($c, CURLOPT_HEADER, false);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_TIMEOUT, 10);

	// make the call
	$content = curl_exec($c);
	curl_close($c);
	
	//return $content;
	$appJsonDecoded = json_decode($content, true);
	return $appJsonDecoded;
}
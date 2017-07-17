<?php

/** 
 * The Template for displaying all single posts type gv_ios_showcase.
 * 
 * @package Gravitation iOS Showcase
 * @author Ulises Freitas
 */
get_header(); 

global $wp_query;
$post_id = $wp_query->get_queried_object_id();
?>
<div class="container">
    <section class="project-section"> 
        <section class="row"> 
        <?php     
             echo '<article>';
            
    			while ( have_posts() ) {
    			   the_post();
                   include( plugin_dir_path(__FILE__).'content-single-gravitation-ios-showcase.php' );          
        		}	   
                    		
			echo '</article>';   
        ?>
        
        </section> <!--row end-->
    </section> <!--project-section end-->
</div><!--container end-->
<?php get_footer(); ?>
<?php
/*The template for displaying content in the single-gravitation-ios-showcase.php template
 *
 * @package Gravitation iOS Showcase
 * @author Ulises Freitas
 */

$artistUrl = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-61', true);
$gameCenter = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-62', true);
$kindOfApp = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-63', true);
$supportedDevices = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-64', true);
$sellerUrl = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-65', true);
$contentAdvisory = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-66', true);
$languages = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-67', true);
$fileSize = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-68', true);
$urlLink = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-69', true);
$price = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-70', true);
$minimumVersion = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-71', true);
$currency = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-72', true);
$appVersion = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-73', true);
$artistName = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-74', true);
$genres = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-75', true);
$releaseDate = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-76', true);
$sellerName = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-78', true);

$imgDisplay = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-80', true);

if($imgDisplay == 'iphone'){
	$all_images_iphone = array();
	for($i=0;$i<5;$i++){
		$imgID = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-3'.$i, true); 
		$all_images_iphone[] =  wp_get_attachment_image_src( $imgID, 'full', false, '' );
	}
	$meta_images_url = '';
	foreach ($all_images_iphone as $field) {
		if(!empty($field[0])){
			$meta_images_url[] = $field[0];
		}
	}
}
if($imgDisplay == 'ipad'){
	$all_images_iphone = array();
	for($i=0;$i<5;$i++){
		$imgID = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-4'.$i, true); 
		$all_images_iphone[] =  wp_get_attachment_image_src( $imgID, 'full', false, '' );
	}
	$meta_images_url = '';
	foreach ($all_images_iphone as $field) {
		if(!empty($field[0])){
			$meta_images_url[] = $field[0];
		}
	}
}
if($imgDisplay == 'appletv'){
	$all_images_iphone = array();
	for($i=0;$i<5;$i++){
		$imgID = get_post_meta(get_the_ID(), 'gv-ios-showcase-field-5'.$i, true); 
		$all_images_iphone[] =  wp_get_attachment_image_src( $imgID, 'full', false, '' );
	}
	$meta_images_url = '';
	foreach ($all_images_iphone as $field) {
		if(!empty($field[0])){
			$meta_images_url[] = $field[0];
		}
	}
}


?>

<div class="ios-col-4">
<ul class="rslides" id="slider2">
	
<?php 
	if(!empty($meta_images_url)):	
	for( $i=0; $i < count($meta_images_url); $i++ ){ 
?>
	<li><a href="#"><img src="<?php echo $meta_images_url[$i]; ?>" alt=""></a></li>
<?php 
	}
endif;
?>
</ul>
<?php if( $artistName != '' ){ ?>
<h3><?php _e('Developer name','gravitation-ios-showcase'); ?></h3>
<h4><?php echo $artistName; ?></h4>
<?php } ?>


</div>
<div class="ios-col-8 ios-col-m-12">
	 
	 	<?php if(get_the_title() != ''){ ?>
		<h1 id="ios-showcase-title"><?php echo get_the_title(); ?></h1>
		<?php } ?>
		<?php if(get_the_content() != ''){ ?>
			<p class="ios-showcase-description"><?php echo get_the_content(); ?></p>
		<?php } ?>
		
		<div class="wrapper">
		<div>
			<?php if( $supportedDevices != '' ){ ?>
			<h4><?php _e('Supported Devices','gravitation-ios-showcase'); ?></h4>
			<?php 
				
				$aDevices = explode(',', $supportedDevices);
				echo '<ul class="ios-showcase-list-unstyled inline">';
				foreach($aDevices as $value){
					if(!empty($value)){
						echo '<li class="dashicons-before dashicons-smartphone">'.$value.'</li>'; 
					}
				}
				echo '</ul>';
			?>
			
			<?php } ?>
		</div>
		<div class="clear"></div>
		<div class="divider"></div>
		<div class="clear"></div>
		<div class="ios-col-6 ios-col-m-12">
		
		<?php if( $contentAdvisory != '' ){ ?>
		<h5><?php _e('Content Advisory: ','gravitation-ios-showcase'); ?> <small><?php echo $contentAdvisory; ?></small></h5>
		<?php } ?>
		</div>
		<div class="ios-col-6 ios-col-m-12">
		<?php if( $fileSize != '' ){ ?>
		<h5><?php _e('File size: ','gravitation-ios-showcase'); ?><small><?php echo $fileSize; ?></small></h5>
		<?php } ?>
		</div>
		<div class="clear"></div>
		<div class="divider"></div>
		<div class="clear"></div>
		<div class="ios-col-6 ios-col-m-12">
		
		<?php if( $minimumVersion != '' ){ ?>
		<h5><?php _e('Minimum required version: ','gravitation-ios-showcase'); ?><small><?php echo $minimumVersion; ?></smal></h5>
		<?php } ?>
		</div>
		<div class="ios-col-6 ios-col-m-12">
		<?php if( $releaseDate != '' ){ ?>
		<h5><?php _e('Release Date: ','gravitation-ios-showcase'); ?><small><?php echo $releaseDate; ?></small></h5>
		<?php } ?>
		</div>
		
		<div class="clear"></div>
		<div class="divider"></div>
		<div class="clear"></div>
		
		<div class="ios-col-6 ios-col-m-12">
		<?php if( $gameCenter != '' ){ ?>
		<h5><?php _e('Game Center Enabled: ','gravitation-ios-showcase'); ?><small><?php echo $gameCenter; ?></small></h5>
		<?php } ?>
		</div>
		<div class="ios-col-6 ios-col-m-12">
		<?php if( $kindOfApp != '' ){ ?>
		<h5><?php _e('Kind of App: ','gravitation-ios-showcase'); ?><small><?php echo $kindOfApp; ?></small></h5>
		<?php } ?>
		</div>
		<div class="clear"></div>
		<div class="divider"></div>
		<div class="clear"></div>
		
		<div class="ios-col-6 ios-col-m-12">
		
		<?php if( $currency != '' ){ ?>
		<h5><?php _e('Currency: ','gravitation-ios-showcase'); ?><small><?php echo $currency; ?></small></h5>
		<?php } ?>
		</div>
		<div class="ios-col-6 ios-col-m-12">
		<?php if( $appVersion != '' ){ ?>
		<h5><?php _e('Current Version: ','gravitation-ios-showcase'); ?><small><?php echo $appVersion; ?></small></h5>
		<?php } ?>
		</div>
		
		<div class="clear"></div>
		<div class="divider"></div>
		<div class="clear"></div>
		
		
		<div class="company content-left ios-col-6 ios-col-m-12">
			<?php if( $artistUrl != '' && $sellerName != '' ){ ?>
			<h4><?php _e('Company','gravitation-ios-showcase'); ?></h4><a href="<?php echo $artistUrl; ?>"><?php echo $sellerName; ?></a>
			<?php } ?>
		</div>
		<div class="sellerurl content-right ios-col-6 ios-col-m-12">
			<?php if( $artistUrl != '' && $sellerUrl != '' ){ ?>
			<h4><?php _e('App Website','gravitation-ios-showcase'); ?></h4><a href="<?php echo $artistUrl; ?>"><?php echo $sellerUrl; ?></a>
			<?php } ?>
		</div>
		
		<div class="clear"></div>
		<div class="divider"></div>
		<div class="clear"></div>
		
		<div class="languages content-left ios-col-6 ios-col-m-12">
			<?php if( $languages != '' ){ ?>
				<h5><?php _e('Languages - ','gravitation-ios-showcase'); ?></h5><p><?php echo $languages;?></p>
			<?php } ?>
		</div>
		<div class="genres content-right ios-col-6 ios-col-m-12">
			<?php if( $genres != '' ){ ?>
				<h5><?php _e('Genres - ','gravitation-ios-showcase'); ?></h5><p><?php echo $genres; ?></p>
			<?php } ?>
		</div>
		<div class="clear"></div>
		<div class="divider"></div>
		<div class="clear"></div>
		<div class="content-price-and-link">
			<div class="content-left ios-col-6 ios-col-m-12">
				<?php if( $artistUrl != '' && $urlLink != '' ){ ?>
				<p><a href="<?php echo $urlLink; ?>" class="link-primary"><?php echo get_the_title(); ?><?php _e(' on iTunes','gravitation-ios-showcase'); ?></a></p>
				<?php } ?>	
			</div>
			
			<div class="content-right ios-col-6 ios-col-m-12">
				<?php if( $price != '' ){ ?>
				<p><a href="" class="link-primary"><?php _e('Price - ','gravitation-ios-showcase'); ?><?php echo $price; ?></a></p>
				<?php } ?>	
			</div>
		</div>
	</div>
</div>
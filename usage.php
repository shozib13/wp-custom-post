/***
* USER TEXONOMIES LINK AS SIDEBAR WIDGET
*/




/***
* USER TEXONOMIES LINK AS SIDEBAR WIDGET
*/

//Geting informaton as tag and category style
<?php echo get_the_term_list( $post->ID, 'app_support', ' ',', ' ); ?>


// Getig information as ul list
<?php $terms = get_terms('taxonomies_name'); ?>

<ul>
<?php foreach ($terms as $term) { ?>
	<li>
		<a href="<?php echo get_term_link($term->slug,'taxonomies_name'); ?>"><?php echo $term->name; ?></a>
	</li>
<?php } ?>
</ul>



/***
* Code For Usage upload Image
*/

<?php 
$meta = get_post_meta($post->ID, 'custom_image', true);
if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }
?>
<img src="<?php echo $image; ?>" />



/***
* Usage All Otehr text value
*/
<?php $custom_text = get_post_meta($post->ID, 'custom_text', true); ?>


/***
* USE RATING IMAGE Ratig:
*/

<?php $nb_stars = get_post_meta($post->ID, 'rating', true); ?>

<?php

<ul>
for ( $star_counter = 1; $star_counter <= 5; $star_counter++ ) {
	if ( $star_counter <= $nb_stars ) { ?>
		<li style="float:left; list-style:none;"><img src="<?php echo get_template_directory_uri() ?>/custom-post/android_apps/icon/golden-icon.png" /></li>
	<?php
	} else { ?>

	<li style="float:left; list-style:none;"><img src="<?php echo get_template_directory_uri() ?>/custom-post/android_apps/icon/gray-icon.png" /></li>

	<?php
	}
}
</ul>

?>




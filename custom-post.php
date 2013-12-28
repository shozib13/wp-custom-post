<?php 
/***
* REGISTER CUSTOM POST
*/
add_action( 'init', function(){

	register_post_type( 'android_apps',
        array(
            'labels' => array(
                'name' => 'Apps',
                'singular_name' => 'App',
                'add_new' => 'Add App',
                'add_new_item' => 'Add New App',
                'edit' => 'Edit',
                'edit_item' => 'Edit App',
                'new_item' => 'New App',
                'view' => 'View',
                'view_item' => 'View App',
                'search_items' => 'Search Apps',
                'not_found' => 'No Apps found',
                'not_found_in_trash' => 'No Apps found in Trash',
                'parent' => 'Parent App'
            ),
 
            'public' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail'),
            'taxonomies' => array( '' ),
            'menu_icon' => get_template_directory_uri().'/custom-post/android_apps/icon/android.ico',
            'has_archive' => true
        )
    );
});

/***
* REGISER CUSOTM TAXONOMI
*/

add_action( 'init', 'create_my_taxonomies', 0 );

function create_my_taxonomies() {
    register_taxonomy(
        'app_category',
        'android_apps',
        array(
            'labels' => array(
                'name' => 'Apps Category',
                'add_new_item' => 'Add New Apps Category',
                'new_item_name' => "New App Type"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    ); 
    register_taxonomy(
        'app_size',
        'android_apps',
        array(
            'labels' => array(
                'name' => 'Apps Size',
                'add_new_item' => 'Add Apps Size',
                'new_item_name' => "New App Size"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
}


// FIELD FOR CUSTOM META BOXES
$prefix = 'custom_';
$custom_meta_fields = array(
	array(
		'label'=> 'Text Input',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'text',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Footer Text',
		'desc'	=> 'A description for the field.',
		'id'	=> 'footer_text',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Textarea',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'textarea',
		'type'	=> 'textarea'
	),
	array(
		'label'=> 'Checkbox Input',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'checkbox',
		'type'	=> 'checkbox'
	),
	array(
		'label'=> 'Select Box',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'select',
		'type'	=> 'select',
		'options' => array (
			'one' => array (
				'label' => 'Option One',
				'value'	=> 'one'
			),
			'two' => array (
				'label' => 'Option Two',
				'value'	=> 'two'
			),
			'three' => array (
				'label' => 'Option Three',
				'value'	=> 'three'
			)
		)
	),


	array (
	'label' => 'Radio Group',
	'desc'	=> 'A description for the field.',
	'id'	=> $prefix.'radio',
	'type'	=> 'radio',
	'options' => array (
		'one' => array (
			'label' => 'Option One',
			'value'	=> 'one'
		),
		'two' => array (
			'label' => 'Option Two',
			'value'	=> 'two'
		),
		'three' => array (
			'label' => 'Option Three',
			'value'	=> 'three'
		)
	)
	),


	array (
	'label'	=> 'Checkbox Group',
	'desc'	=> 'A description for the field.',
	'id'	=> $prefix.'checkbox_group',
	'type'	=> 'checkbox_group',
	'options' => array (
		'one' => array (
			'label' => 'Option One',
			'value'	=> 'one'
		),
		'two' => array (
			'label' => 'Option Two',
			'value'	=> 'two'
		),
		'three' => array (
			'label' => 'Option Three',
			'value'	=> 'three'
		)
	)
	),


	/***
	* Array for upload image
	*/

	array(
	'name'	=> 'Image',
	'desc'	=> 'A description for the field.',
	'id'	=> $prefix.'image',
	'type'	=> 'image'
)
);



/***
* The Callback function for custom meat box
*/

function show_custom_meta_box() {
global $custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
					break;

					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
					break;

					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
							<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select


					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;


					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
					break;

					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break; 

					// image
					case 'image':
						$image = get_template_directory_uri().'/images/image.png';	
						echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
						if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }				
						echo	'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
										<input class="custom_upload_image_button button" type="button" value="Choose Image" />
										<small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'';
					break;

 			}//end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}


/***
* Save the Data of meta boxes
*/
function save_custom_meta($post_id) {
    global $custom_meta_fields;
	
	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($custom_meta_fields as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_custom_meta');  





/***
* This code for wordpress javaScript emplement
*/
if(is_admin()) {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-ui-custom', get_template_directory_uri().'/css/jquery-ui-custom.css');
	wp_enqueue_script('custom', get_template_directory_uri().'/custom-post/js/custom.js');

}

 ?>
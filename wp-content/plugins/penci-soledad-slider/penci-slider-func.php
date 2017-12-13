<?php
/**
 * Create meta box
 */
function pencislider_create_meta_box( $post, $meta_box ) {

	if( !is_array($meta_box) ) return false;

	if( isset($meta_box['description']) && $meta_box['description'] != '' ){
		echo '<p>'. $meta_box['description'] .'</p>';
	}

	wp_nonce_field( basename(__FILE__), 'penci_meta_box_nonce' );
	echo '<table class="form-table penci-metabox-table">';

	$count = 0;

	foreach( $meta_box['fields'] as $field ){

		$meta = get_post_meta( $post->ID, $field['id'], true );

		$inline = null;
		if(isset($field['extra'])) { $inline = true; }

		if($inline == null) {

			echo '<tr><th><label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong>
			  <span>'. $field['desc'] .'</span></label></th>';
		}


		switch( $field['type'] ){
			case 'text':
				echo '<td><input type="text" name="penci_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'" size="30" /></td>';
				break;

			case 'textarea':
				echo '<td><textarea name="penci_meta['. $field['id'] .']" id="'. $field['id'] .'" rows="8" cols="5">'. ($meta ? $meta : $field['std']) .'</textarea></td>';
				break;

			case 'file':

				echo '<td><input type="hidden" id="' . $field['id'] . '" name="penci_meta[' . $field['id'] . ']" value="' . ($meta ? $meta : $field['std']) . '" />';
				echo '<img class="penci-opts-screenshot" id="penci-opts-screenshot-' . $field['id'] . '" src="' . ($meta ? $meta : $field['std']) . '" />';
				if( ($meta ? $meta : $field['std']) == '') {$remove = ' style="display:none;"'; $upload = ''; } else {$remove = ''; $upload = ' style="display:none;"'; }
				echo ' <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);"class="penci-opts-upload button-secondary"' . $upload . ' rel-id="' . $field['id'] . '">' . __('Upload', 'pencidesign') . '</a>';
				echo ' <a href="javascript:void(0);" class="penci-opts-upload-remove button-secondary has-margin"' . $remove . ' rel-id="' . $field['id'] . '">' . __('Remove Upload', 'pencidesign') . '</a></td>';

				break;

			case 'media':

				echo '<td><input type="text" class="file_display_text" id="' . $field['id'] . '" name="penci_meta[' . $field['id'] . ']" value="' . ($meta ? $meta : $field['std']) . '" />';
				if( ($meta ? $meta : $field['std']) == '') {$remove = ' style="display:none;"'; $upload = ''; } else {$remove = ''; $upload = ' style="display:none;"'; }
				echo ' <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);"class="penci-opts-media-upload button-secondary"' . $upload . ' rel-id="' . $field['id'] . '">' . __('Add Media', 'pencidesign') . '</a>';
				echo ' <a href="javascript:void(0);" class="penci-opts-upload-media-remove"' . $remove . ' rel-id="' . $field['id'] . '">' . __('Remove Media', 'pencidesign') . '</a></td>';

				break;

			case 'color':

				echo '<td><input type="text" id="' . $field['id'] . '" name="penci_meta[' . $field['id'] . ']" value="' . ($meta ? $meta : $field['std']) . '" class=" popup-colorpicker" style="width: 70px;" data-default-color="' . ($meta ? $meta : $field['std']) . '"/></td>';

				break;

			case 'images':
				echo '<td><input type="button" class="button" name="' . $field['id'] . '" id="penci_images_upload" value="' . $field['std'] .'" /></td>';
				break;

			case 'select':
				echo'<td><select name="penci_meta['. $field['id'] .']" id="'. $field['id'] .'">';
				foreach( $field['options'] as $key => $option ){
					echo '<option value="' . $key . '"';
					if( $meta ){
						if( $meta == $key ) echo ' selected="selected"';
					} else {
						if( $field['std'] == $key ) echo ' selected="selected"';
					}
					echo'>'. $option .'</option>';
				}
				echo'</select></td>';
				break;
			case 'radio':
				echo '<td>';
				foreach( $field['options'] as $key => $option ){
					echo '<label class="radio-label"><input type="radio" name="penci_meta['. $field['id'] .']" value="'. $key .'" class="radio"';
					if( $meta ){
						if( $meta == $key ) echo ' checked="checked"';
					} else {
						if( $field['std'] == $key ) echo ' checked="checked"';
					}
					echo ' /> '. $option .'</label> ';
				}
				echo '</td>';
				break;
			case 'checkbox':
				echo '<td>';
				$val = '';
				if( $meta ) {
					if( $meta == 'on' ) $val = ' checked="checked"';
				} else {
					if( $field['std'] == 'on' ) $val = ' checked="checked"';
				}

				echo '<input type="hidden" name="penci_meta['. $field['id'] .']" value="off" />
                <input type="checkbox" id="'. $field['id'] .'" name="penci_meta['. $field['id'] .']" value="on"'. $val .' /> ';
				echo '</td>';
				break;
		}

		if($inline == null) {
			echo '</tr>';
		}
	}

	echo '</table>';
}


/**
 * Save Meta box
 */
function pencislider_save_meta_box( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( !isset($_POST['penci_meta']) || !isset($_POST['penci_meta_box_nonce']) || !wp_verify_nonce( $_POST['penci_meta_box_nonce'], basename( __FILE__ ) ) )
		return;

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) return;
	}
	else {
		if ( !current_user_can( 'edit_post', $post_id ) ) return;
	}

	foreach( $_POST['penci_meta'] as $key=>$val ){
		update_post_meta( $post_id, $key, $val );
	}

}
add_action( 'save_post', 'pencislider_save_meta_box' );
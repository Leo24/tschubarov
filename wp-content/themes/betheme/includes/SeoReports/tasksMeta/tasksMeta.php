<?php



/**
 * Register meta box(es).
 */
function wpdocs_register_meta_boxes() {
	add_meta_box( 'meta-box-id', __( 'Task Status', 'textdomain' ), 'wpdocs_my_display_callback', 'seo-client-reports' );
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback( $post ) {
	$taskFields = getTasks();
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

	if(is_array($taskFields['startup_preparation']) && !empty($taskFields['startup_preparation'])){
		echo '<h2><span>Startup preparation:</span></h2>';
		foreach($taskFields['startup_preparation'] as $value){
			$inputName = createInputName($value['startup_preparation']);
			echo '<div class="inside">
                    <p>
                        <input type="checkbox" name="'.$inputName.'" id="'.$value['startup_preparation'].'" value="'.$value['startup_preparation'].'" '.checkPostMeta($post->ID, $inputName).' />
                        <label for="my_meta_box_text">'.$value['startup_preparation'].'</label>
                    </p>
                 </div>';
		}
	}

	if(is_array($taskFields['on_page_seo']) && !empty($taskFields['on_page_seo'])){
		echo '<h2><span>On Page Seo:</span></h2>';
		foreach($taskFields['on_page_seo'] as $value){
			$inputName = createInputName($value['on_page_seo']);
			echo '<div class="inside">
                    <p>
                        <input type="checkbox" name="'.$inputName.'" id="'.$value['on_page_seo'].'" value="'.$value['on_page_seo'].'" '.checkPostMeta($post->ID, $inputName).'/>
                        <label for="my_meta_box_text">'.$value['on_page_seo'].'</label>
                    </p>
                 </div>';
		}
	}

	if(is_array($taskFields['off_page_seo']) && !empty($taskFields['off_page_seo'])){
		echo '<h2><span>Off Page SEO:</span></h2>';
		foreach($taskFields['off_page_seo'] as $value){
			$inputName = createInputName($value['off_page_seo']);
			echo '<div class="inside">
                    <p>
                        <input type="checkbox" name="'.$inputName.'" id="'.$value['off_page_seo'].'" value="'.$value['off_page_seo'].'" '.checkPostMeta($post->ID, $inputName).'/>
                        <label for="my_meta_box_text">'.$value['off_page_seo'].'</label>
                    </p>
                 </div>';
		}
	}

	if(is_array($taskFields['social_media_tasks']) && !empty($taskFields['social_media_tasks'])){
		echo '<h2><span>Social media tasks:</span></h2>';
		foreach($taskFields['social_media_tasks'] as $value){
			$inputName = createInputName($value['social_media_tasks']);
			echo '<div class="inside">
                    <p>
                        <input type="checkbox" name="'.$inputName.'" id="'.$value['social_media_tasks'].'" value="'.$value['social_media_tasks'].'" '.checkPostMeta($post->ID, $inputName).'/>
                        <label for="my_meta_box_text">'.$value['social_media_tasks'].'</label>
                    </p>
                 </div>';
		}
	}

	if(is_array($taskFields['local_businesses']) && !empty($taskFields['local_businesses'])){
		echo '<h2><span>Local Businesses:</span></h2>';
		foreach($taskFields['local_businesses'] as $value) {
			$inputName = createInputName($value['local_businesses']);
			echo '<div class="inside">
                    <p>
                        <input type="checkbox" name="'.$inputName.'" id="'.$value['local_businesses'].'" value="'.$value['local_businesses'].'" '.checkPostMeta($post->ID, $inputName).'/>
                        <label for="my_meta_box_text">'.$value['local_businesses'].'</label>
                    </p>
                 </div>';
		}
	}



}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box( $post_id ) {
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post', $post_id ) ) return;
	// now we can actually save the data
	$allowed = array(
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);
	// Probably a good idea to make sure your data is set

	$tasks = getTasks();
	$fieldList = getFieldNamesList($tasks);
	$input = $_POST;

	foreach($fieldList as $field){
			if (false == is_null($input[$field])){
				if ( ! add_post_meta( $post_id, $field, $input[$field], true ) ) {
				update_post_meta( $post_id, $field, $input[$field]);
				}
			}
			if (is_null($input[$field])){
					update_post_meta( $post_id, $field, $input[$field]);
			}
	}
}
add_action( 'save_post', 'wpdocs_save_meta_box' );


function createInputName($string){
	return strtolower(str_replace(' ', '_', $string));
}

function getTasks(){
	$task_posts = get_posts(
		array(
			'posts_per_page' => -1,
			'post_type' => 'seo-report-task',
		)
	);
	return get_fields($task_posts[0]->ID);
}
function getFieldNamesList($taskFields){
	$fieldList = array();

	if(is_array($taskFields['startup_preparation']) && !empty($taskFields['startup_preparation'])){
		echo '<h2><span>Startup preparation:</span></h2>';
		foreach($taskFields['startup_preparation'] as $value){
			$fieldList[] = createInputName($value['startup_preparation']);
		}
	}

	if(is_array($taskFields['on_page_seo']) && !empty($taskFields['on_page_seo'])){
		echo '<h2><span>On Page Seo:</span></h2>';
		foreach($taskFields['on_page_seo'] as $value){
			$fieldList[] = createInputName($value['on_page_seo']);
		}
	}

	if(is_array($taskFields['off_page_seo']) && !empty($taskFields['off_page_seo'])){
		echo '<h2><span>Off Page SEO:</span></h2>';
		foreach($taskFields['off_page_seo'] as $value){
			$fieldList[] = createInputName($value['off_page_seo']);
		}
	}

	if(is_array($taskFields['social_media_tasks']) && !empty($taskFields['social_media_tasks'])){
		echo '<h2><span>Social media tasks:</span></h2>';
		foreach($taskFields['social_media_tasks'] as $value){
			$fieldList[] = createInputName($value['social_media_tasks']);
		}
	}

	if(is_array($taskFields['local_businesses']) && !empty($taskFields['local_businesses'])){
		foreach($taskFields['local_businesses'] as $value) {
			$fieldList[] = createInputName($value['local_businesses']);
		}
	}

	return $fieldList;
}

function checkPostMeta($postID, $key){
	$postMeta = get_post_meta($postID, $key);
	if(!empty($postMeta[0])){
		return 'checked';
	}
	return false;
}

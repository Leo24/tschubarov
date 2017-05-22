<?php
/**
 * General custom meta fields.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


/*-----------------------------------------------------------------------------------*/
/*	LIST of Categories for posts or specified taxonomy
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_get_categories' ) )
{
	function mfn_get_categories( $category ) {
		$categories = get_categories( array( 'taxonomy' => $category ));
		
		$array = array( '' => __( 'All', 'mfn-opts' ) );	
		foreach( $categories as $cat ){
			if( is_object($cat) ) $array[$cat->slug] = $cat->name;
		}
			
		return $array;
	}
}


/*-----------------------------------------------------------------------------------*/
/*	LIST of Sliders (Revolution Slider)
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_get_sliders' ) )
{
	function mfn_get_sliders() {
		global $wpdb;
	
		$sliders = array( 0 => __('-- Select --', 'mfn-opts') );
	
		// Revolution Slider ----------------------------------
		if( function_exists( 'rev_slider_shortcode' ) ){
			
			
			// table prefix -----
			$table_prefix = mfn_opts_get( 'table_prefix', 'base_prefix' );
			if( $table_prefix == 'base_prefix' ){
				$table_prefix = $wpdb->base_prefix;
			} else {
				$table_prefix = $wpdb->prefix;
			}
			
			
			$table_name = $table_prefix . "revslider_sliders";
			
			
			$rs5 = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'type'");
			if( $rs5 ){			
				// Revolution Slider 5.x
				$array = $wpdb->get_results("SELECT * FROM $table_name WHERE type != 'template' ORDER BY title ASC");
			} else {			
				// Revolution Slider 4.x
				$array = $wpdb->get_results("SELECT * FROM $table_name ORDER BY title ASC");
			}
			
			
			if( is_array( $array ) ){
				foreach( $array as $v ){
					$sliders[$v->alias] = $v->title;
				}
			}
			
		}
		
		return $sliders;
	}
}


/*-----------------------------------------------------------------------------------*/
/*	LIST of Sliders (Layer Slider)
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_get_sliders_layer' ) )
{
	function mfn_get_sliders_layer(){
		global $wpdb;
	
		$sliders = array( 0 => __('-- Select --', 'mfn-opts') );
	
		// Layer Slider ----------------------------------
		if( function_exists( 'layerslider' ) ){
			
			// table prefix -----
			$table_prefix = mfn_opts_get( 'table_prefix', 'base_prefix' );
			if( $table_prefix == 'base_prefix' ){
				$table_prefix = $wpdb->base_prefix;
			} else {
				$table_prefix = $wpdb->prefix;
			}
				
			$table_name = $table_prefix . "layerslider";
			
			$array = $wpdb->get_results("SELECT * FROM $table_name WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY name ASC");
			
			if( is_array( $array ) ){
				foreach( $array as $v ){
					$sliders[$v->id] = $v->name;
				}
			}
		}
		
		return $sliders;
	}
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Single Muffin Options FIELD
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_meta_field_input' ) )
{
	function mfn_meta_field_input( $field, $meta ){
		global $MFN_Options;
	
		if( isset( $field['type'] ) ){

			// Table Row class
			if( isset( $field['class'] ) ){
				$class = $field['class'];
			} else {
				$class = '';
			}
			
			echo '<tr class="'. $class .'">';
			
				// Field Title & SubDescription
				echo '<th>';
					if( key_exists('title', $field) ) echo $field['title'];
					if( key_exists('sub_desc', $field) ) echo '<span class="description">'. $field['sub_desc'] .'</span>';
				echo '</th>';
				
				// Muffin Options Field & Description 
				echo '<td>';
					$field_class = 'MFN_Options_'.$field['type'];
					require_once( $MFN_Options->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php' );
					
					if( class_exists( $field_class ) ){
						$field_object = new $field_class( $field, $meta );
						$field_object->render( true );
					}
					
				echo '</td>';
				
			echo '</tr>';
		}	
	}
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Single Muffin Builder ITEM
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_builder_item' ) )
{
	function mfn_builder_item( $item_std, $item = false, $section_id = false ) {
		
		// input's 'name' only for existing items, not for items to clone
		$name_type 		= $item ? 'name="mfn-item-type[]"' : '';
		$name_size 		= $item ? 'name="mfn-item-size[]"' : '';
		$name_parent	= $item ? 'name="mfn-item-parent[]"' : '';
		
		$item_std['size'] = $item['size'] ? $item['size'] : $item_std['size'];
		$label = ( $item && key_exists('fields', $item) && key_exists('title', $item['fields']) ) ? $item['fields']['title'] : '';
	
		$classes = array(
			'1/6' => 'mfn-item-1-6',
			'1/5' => 'mfn-item-1-5',
			'1/4' => 'mfn-item-1-4',
			'1/3' => 'mfn-item-1-3',
			'1/2' => 'mfn-item-1-2',
			'2/3' => 'mfn-item-2-3',
			'3/4' => 'mfn-item-3-4',
			'1/1' => 'mfn-item-1-1'
		);
		
		echo '<div class="mfn-element mfn-item mfn-item-'. $item_std['type'] .' '. $classes[$item_std['size']] .'">';
								
			echo '<div class="mfn-element-content">';
				echo '<input type="hidden" class="mfn-item-type" '. $name_type .' value="'. $item_std['type'] .'">';
				echo '<input type="hidden" class="mfn-item-size" '. $name_size .' value="'. $item_std['size'] .'">';
				echo '<input type="hidden" class="mfn-item-parent" '. $name_parent .' value="'. $section_id .'" />';
				
				echo '<div class="mfn-element-header">';
					echo '<div class="mfn-item-size">';
						echo '<a class="mfn-element-btn mfn-item-size-dec" href="javascript:void(0);">-</a>';
						echo '<a class="mfn-element-btn mfn-item-size-inc" href="javascript:void(0);">+</a>';
						echo '<span class="mfn-item-desc">'. $item_std['size'] .'</span>';
					echo '</div>';
					echo '<div class="mfn-element-tools">';
						echo '<a class="mfn-element-btn mfn-fr mfn-element-edit" title="'. __('Edit','mfn-opts') .'" href="javascript:void(0);">E</a>';
						echo '<a class="mfn-element-btn mfn-fr mfn-element-clone mfn-item-clone" title="'. __('Clone','mfn-opts') .'" href="javascript:void(0);">C</a>';
						echo '<a class="mfn-element-btn mfn-fr mfn-element-delete" title="'. __('Delete','mfn-opts') .'" href="javascript:void(0);">D</a>';
					echo '</div>';
				echo '</div>';
				
				echo '<div class="mfn-item-content">';
					echo '<div class="mfn-item-icon"></div>';
					echo '<span class="mfn-item-title">'. $item_std['title'] .'</span>';
					echo '<span class="mfn-item-label">'. $label .'</span>';
				echo '</div>';
		
			echo '</div>';
			
			echo '<div class="mfn-element-meta">';
				echo '<table class="form-table">';
					echo '<tbody>';		
			 
						// Fields for Item
						foreach( $item_std['fields'] as $field ){
								
							// values for existing items
							if( $item && key_exists( 'fields', $item ) && key_exists( $field['id'], $item['fields'] ) ){
								$meta = $item['fields'][$field['id']];
							} else {
								$meta = false;
							}
							
							if( ! key_exists('std', $field) ) $field['std'] = false;
							$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
							
							// field ID
							$field['id'] = 'mfn-items['. $item_std['type'] .']['. $field['id'] .']';	
							
							// field ID except accordion, faq & tabs
							if( $field['type'] != 'tabs' ){
								$field['id'] .= '[]';					
							}
							
							// PRINT Single Muffin Options FIELD
							mfn_meta_field_input( $field, $meta );
							
						}
			 
					echo '</tbody>';
				echo '</table>';
			echo '</div>';
		
		echo '</div>';						
	}
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Single Muffin Builder SECTION
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_builder_section' ) )
{
	function mfn_builder_section( $item_std, $section_std, $section = false, $section_id = false ) {
	
		// input's 'name' only for existing sections, not for section to clone
		$name_row_id = $section ? 'name="mfn-row-id[]"' : '';
		$label = ( $section && key_exists('attr', $section) && key_exists('title', $section['attr']) ) ? $section['attr']['title'] : '';
			
		echo '<div class="mfn-element mfn-row">';
	
			echo '<div class="mfn-element-content">';
			
				// Section ID
				echo '<input type="hidden" class="mfn-row-id" '. $name_row_id .' value="'. $section_id .'" />';
	
				echo '<div class="mfn-element-header">';
					echo '<div class="mfn-item-add">';
					echo '<a class="mfn-item-add-btn" href="javascript:void(0);">'. __('Add Item','mfn-opts') .'</a>';
						echo '<ul class="mfn-item-add-list">';
						
							// List of available Items
							foreach( $item_std as $item ){
								echo '<li><a class="'. $item['type'] .'" href="javascript:void(0);">'. $item['title'] .'</a></li>';
							}
						
						echo '</ul>';
					echo '</div>';
					echo '<span class="mfn-item-label">'. $label .'</span>';
					echo '<div class="mfn-element-tools">';			
						echo '<a class="mfn-element-btn mfn-element-edit" title="'. __('Edit','mfn-opts') .'" href="javascript:void(0);">E</a>';
						echo '<a class="mfn-element-btn mfn-element-clone mfn-row-clone" title="'. __('Clone','mfn-opts') .'" href="javascript:void(0);">C</a>';
						echo '<a class="mfn-element-btn mfn-element-delete" title="'. __('Delete','mfn-opts') .'" href="javascript:void(0);">D</a>';
					echo '</div>';
				echo '</div>';
				
				// .mfn-element-droppable
				echo '<div class="mfn-droppable mfn-sortable clearfix">';
	
					// Existing Items for Section
					if( $section && key_exists('items', $section) && is_array($section['items']) ){
						foreach( $section['items'] as $item )
						{
							mfn_builder_item( $item_std[$item['type']], $item, $section_id );
						}
					}
			
				echo '</div>';
	
			echo '</div>';
			
			echo '<div class="mfn-element-meta">';
				echo '<table class="form-table" style="display: table;">';
					echo '<tbody>';
						
						// Fields for Section
						foreach( $section_std as $field ){
	
							// values for existing sections
							if( $section ){
								$meta = $section['attr'][$field['id']];
							} else {
								$meta = false;
							}
						
							if( ! key_exists('std', $field) ) $field['std'] = false;
							$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
						
							// field ID
							$field['id'] = 'mfn-rows['. $field['id'] .']';
						
							// field ID except accordion, faq & tabs
							if( $field['type'] != 'tabs' ){
								$field['id'] .= '[]';
							}
						
							// PRINT Single Muffin Options FIELD
							mfn_meta_field_input( $field, $meta );
							
						}
						
					echo '</tbody>';
				echo '</table>';
			echo '</div>';
			
		echo '</div>';
	
	}
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Muffin Builder
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_builder_show' ) )
{
	function mfn_builder_show() {
		global $post;
	
	
		// Entrance Animations -----------------------------------------------------------------------------
		$mfn_animate = array(
			'' 					=> __('- Not Animated -','mfn-opts'),
			'fadeIn' 			=> __('Fade In','mfn-opts'),
			'fadeInUp' 			=> __('Fade In Up','mfn-opts'),
			'fadeInDown' 		=> __('Fade In Down ','mfn-opts'),
			'fadeInLeft' 		=> __('Fade In Left','mfn-opts'),
			'fadeInRight' 		=> __('Fade In Right ','mfn-opts'),
			'fadeInUpLarge' 	=> __('Fade In Up Large','mfn-opts'),
			'fadeInDownLarge' 	=> __('Fade In Down Large','mfn-opts'),
			'fadeInLeftLarge' 	=> __('Fade In Left Large','mfn-opts'),
			'fadeInRightLarge' 	=> __('Fade In Right Large','mfn-opts'),
			'zoomIn' 			=> __('Zoom In','mfn-opts'),
			'zoomInUp' 			=> __('Zoom In Up','mfn-opts'),
			'zoomInDown' 		=> __('Zoom In Down','mfn-opts'),
			'zoomInLeft' 		=> __('Zoom In Left','mfn-opts'),
			'zoomInRight' 		=> __('Zoom In Right','mfn-opts'),
			'zoomInUpLarge' 	=> __('Zoom In Up Large','mfn-opts'),
			'zoomInDownLarge' 	=> __('Zoom In Down Large','mfn-opts'),
			'zoomInLeftLarge' 	=> __('Zoom In Left Large','mfn-opts'),
			'bounceIn' 			=> __('Bounce In','mfn-opts'),
			'bounceInUp' 		=> __('Bounce In Up','mfn-opts'),
			'bounceInDown' 		=> __('Bounce In Down','mfn-opts'),
			'bounceInLeft' 		=> __('Bounce In Left','mfn-opts'),
			'bounceInRight' 	=> __('Bounce In Right','mfn-opts'),
		);
		
		// Section Attributes ------------------------------------------------------------------------------
		$mfn_std_section = array(
				
			array(
				'id' 		=> 'title',
				'type' 		=> 'text',
				'title' 	=> __('Title', 'mfn-opts'),
				'desc' 		=> __('This field is used as an Section Label in admin panel only and shows after page update', 'mfn-opts'),
			),
			
			array(
				'id' 		=> 'bg_color',
				'type' 		=> 'text',
				'title' 	=> __('Background | Color', 'mfn-opts'),
				'desc' 		=> __('Use color name ( gray ) or hex ( #808080 ). Leave this field blank if you want to use transparent background', 'mfn-opts'),
				'class' 	=> 'small-text',
				'std' 		=> '',
			),
			
			array(
				'id'		=> 'bg_image',
				'type'		=> 'upload',
				'title'		=> __('Background | Image', 'mfn-opts'),
			),
			
			array(
				'id' 		=> 'bg_position',
				'type' 		=> 'select',
				'title' 	=> __('Background | Image position', 'mfn-opts'),
				'desc' 		=> __('This option can be used only with your custom image selected above', 'mfn-opts'),
				'options' 	=> mfna_bg_position(),
				'std' 		=> 'center top no-repeat',
			),
			
			array(
				'id'		=> 'bg_video_mp4',
				'type'		=> 'upload',
				'title'		=> __('Background | Video HTML5', 'mfn-opts'),
				'sub_desc'	=> __('m4v [.mp4]', 'mfn-opts'),
				'desc'		=> __('Please add both mp4 and ogv for cross-browser compatibility. Background Image will be used as video placeholder before video loads and on mobile devices', 'mfn-opts'),
				'class'		=> __('video', 'mfn-opts'),
			),
			
			array(
				'id'		=> 'bg_video_ogv',
				'type'		=> 'upload',
				'title'		=> __('Background | Video HTML5', 'mfn-opts'),
				'sub_desc'	=> __('ogg [.ogv]', 'mfn-opts'),
				'class'		=> __('video', 'mfn-opts'),
			),
			
			array(
				'id' 		=> 'column_margin',
				'type' 		=> 'select',
				'title' 	=> __('Margin | Inner Columns', 'mfn-opts'),
				'sub_desc'	=> __('Inner Columns Margin Bottom', 'mfn-opts'),
				'options' 	=> array(
					''			=> '-- Default --',
					'0px'		=> '0px',
					'10px'		=> '10px',
					'20px'		=> '20px',
					'30px'		=> '30px',
					'40px'		=> '40px',
					'50px'		=> '50px',
				),
			),
			
			array(
				'id' 		=> 'padding_top',
				'type'		=> 'text',
				'title' 	=> __('Padding | Top', 'mfn-opts'),
				'sub_desc'	=> __('Section Padding Top', 'mfn-opts'),
				'desc' 		=> __('px', 'mfn-opts'),
				'class' 	=> 'small-text',
				'std' 		=> '0',
			),
			
			array(
				'id' 		=> 'padding_bottom',
				'type'		=> 'text',
				'title' 	=> __('Padding | Bottom', 'mfn-opts'),
				'sub_desc'	=> __('Section Padding Bottom', 'mfn-opts'),
				'desc' 		=> __('px', 'mfn-opts'),
				'class' 	=> 'small-text',
				'std' 		=> '0',
			),
			
			array(
				'id' 		=> 'divider',
				'type' 		=> 'select',
				'title' 	=> __('Separator', 'mfn-opts'),
				'sub_desc'	=> __('Section Separator', 'mfn-opts'),
				'desc' 		=> __('Works only with Background Color selected above.', 'mfn-opts'),
				'options' 	=> array(
					'' 						=> 'None',
					'circle up' 			=> 'Circle Up',
					'circle down' 			=> 'Circle Down',
					'square up' 			=> 'Square Up',
					'square down' 			=> 'Square Down',
					'triangle up' 			=> 'Triangle Up',
					'triangle down' 		=> 'Triangle Down',
					'triple-triangle up' 	=> 'Triple Triangle Up',
					'triple-triangle down' 	=> 'Triple Triangle Down',
				),
			),
				
			array(
					'id' 		=> 'layout',
					'type' 		=> 'select',
					'title' 	=> __('Sidebar | Layout', 'mfn-opts'),
					'sub_desc'	=> __('Select layout for this section', 'mfn-opts'),
					'desc' 		=> __('<strong>Notice:</strong> Sidebar for section will show <strong>only</strong> if you set Full Width Page Layout in Page Options below Content Builder', 'mfn-opts'),
					'options' 	=> array(
							'no-sidebar'	=> 'Full width. No sidebar',
							'left-sidebar'	=> 'Left Sidebar',
							'right-sidebar'	=> 'Right Sidebar'
					),
					'std' 		=> 'no-sidebar',
			),
				
			array(
					'id'		=> 'sidebar',
					'type' 		=> 'select',
					'title' 	=> __('Sidebar | Select', 'mfn-opts'),
					'sub_desc' 	=> __('Select sidebar for this section', 'mfn-opts'),
					'options' 	=> mfn_opts_get( 'sidebars' ),
			),
			
			array(
				'id' 		=> 'navigation',
				'type' 		=> 'select',
				'title' 	=> __('Navigation', 'mfn-opts'),
				'options' 	=> array(
					'' 				=> 'None',
					'arrows' 		=> 'Arrows',
				),
			),
			
			array(
				'id' 		=> 'style',
				'type' 		=> 'select',
				'title' 	=> __('Style', 'mfn-opts'),
				'sub_desc'	=> __('Predefined styles for section', 'mfn-opts'),
				'desc' 		=> __('For more advanced styles please use Custom CSS field below', 'mfn-opts'),
				'options' 	=> array(
					'' 										=> '-- Default --',
					'no-margin-h'							=> 'Columns without Horizontal margins | no-margin-h',
					'no-margin'	 							=> 'Columns without Vertical margin | no-margin-v',
					'no-margin-h no-margin-v'				=> 'Columns without Any margins | no-margin-h no-margin-v',
					'dark' 									=> 'Dark | dark',
					'equal-height'							=> 'Equal Height of Columns | equal-height',
					'full-screen'	 						=> 'Full Screen | full-screen',
					'full-width'	 						=> 'Full Width | full-width',
					'full-width no-margin-h no-margin-v'	=> 'Full Width without margins | full-width no-margin-h no-margin-v',
					'highlight-left' 						=> 'Highlight Left | highlight-left',
					'highlight-right' 						=> 'Highlight Right | highlight-right',
				),
			),
			
			array(
				'id' 		=> 'class',
				'type' 		=> 'text',
				'title' 	=> __('Custom | Classes', 'mfn-opts'),
				'desc'		=> __('Multiple classes should be separated with SPACE. For sections with centered text you can use class: <strong>center</strong>', 'mfn-opts'),
			),
			
			array(
				'id' 		=> 'section_id',
				'type' 		=> 'text',
				'title' 	=> __('Custom | ID', 'mfn-opts'),
				'desc'		=> __('Use this option to create One Page sites. For example: Your Custom ID is <strong>offer</strong> and you want to open this section, please use link: <strong>your-url/#offer</strong>', 'mfn-opts'),
				'class' 	=> 'small-text',
			),
			
			array(
				'id' 		=> 'visibility',
				'type' 		=> 'select',
				'title' 	=> __('Responsive Visibility', 'mfn-opts'),
				'options' 	=> array(
					'' 							=> '-- Default --',
					'hide-desktop' 				=> 'Hide on Desktop | 960px +',			// 960 +
					'hide-tablet' 				=> 'Hide on Tablet | 768px - 959px',	// 768 - 959
					'hide-mobile' 				=> 'Hide on Mobile | - 768px',			// - 768
					'hide-desktop hide-tablet' 	=> 'Hide on Desktop & Tablet',
					'hide-desktop hide-mobile' 	=> 'Hide on Desktop & Mobile',
					'hide-tablet hide-mobile'	=> 'Hide on Tablet & Mobile',
				),
			),
		
		);
		
		// Default Items with Fields -----------------------------------------------------------------------------
		$mfn_std_items = array(
		
			// Placeholder --------------------------------------------
			'placeholder' => array(
				'type' 		=> 'placeholder',
				'title' 	=> __('- Placeholder -', 'mfn-opts'),
				'size' 		=> '1/4',
				'fields'	=> array(
		
					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('This is Muffin Builder Placeholder.', 'nhp-opts'),
					),
							
				),
			),
				
			// Accordion  --------------------------------------------
			'accordion' => array(
				'type' 		=> 'accordion',
				'title' 	=> __('Accordion', 'mfn-opts'), 
				'size' 		=> '1/4', 
				'fields'	=> array(
			
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'tabs',
						'type' 		=> 'tabs',
						'title' 	=> __('Accordion', 'mfn-opts'),
						'sub_desc' 	=> __('Manage accordion tabs.', 'mfn-opts'),
						'desc' 		=> __('You can use Drag & Drop to set the order.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'open1st',
						'type' 		=> 'select',
						'title' 	=> __('Open First', 'mfn-opts'),
						'desc' 		=> __('Open first tab at start.', 'mfn-opts'),
						'options'	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'openAll',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open All', 'mfn-opts'),
						'desc' 		=> __('Open all tabs at start', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title' 	=> __('Style', 'mfn-opts'),
						'options'	=> array( 
							'accordion'	=> 'Accordion',
							'toggle'	=> 'Toggle'
						),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
				
			// Article box  --------------------------------------------
			'article_box' => array(
				'type'		=> 'article_box',
				'title'		=> __('Article box', 'mfn-opts'),
				'size'		=> '1/3',
				'fields'	=> array(
		
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
						'sub_desc' 	=> __('Featured Image', 'mfn-opts'),
					),
				
					array(
						'id' 		=> 'slogan',
						'type' 		=> 'text',
						'title' 	=> __('Slogan', 'mfn-opts'),
					),
				
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
			
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
			
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title'		=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Blockquote --------------------------------------------
			'blockquote' => array(
				'type' 		=> 'blockquote',
				'title' 	=> __('Blockquote', 'mfn-opts'), 
				'size' 		=> '1/4', 
				'fields'	=> array(
			
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'sub_desc' 	=> __('Blockquote content.', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts')
					),
					
					array(
						'id' 		=> 'author',
						'type' 		=> 'text',
						'title' 	=> __('Author', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
						'sub_desc' 	=> __('Link to company page.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'sub_desc' 	=> __('Open link in a new window.', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
			
			// Blog --------------------------------------------
			'blog' => array(
				'type' 		=> 'blog',
				'title' 	=> __('Blog', 'mfn-opts'), 
				'size' 		=> '1/1', 
				'fields'	=> array(
			
					array(
						'id' 		=> 'count',
						'type' 		=> 'text',
						'title' 	=> __('Count', 'mfn-opts'),
						'sub_desc' 	=> __('Number of posts to show', 'mfn-opts'),
						'std' 		=> '2',
						'class' 	=> 'small-text',
					),
	
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title' 	=> __('Category', 'mfn-opts'),
						'options' 	=> mfn_get_categories( 'category' ),
						'sub_desc' 	=> __('Select posts category', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'style',
						'type'		=> 'select',
						'title'		=> 'Style',
						'options'	=> array(
							'classic'		=> 'Classic',
							'masonry'		=> 'Masonry Blog Style',
							'masonry tiles'	=> 'Masonry Tiles',
							'photo'			=> 'Photo (Horizontal Images)',
							'timeline'		=> 'Timeline',
						),
						'std'		=> 'classic',
					),
						
					array(
						'id' 		=> 'columns',
						'type' 		=> 'select',
						'title' 	=> __('Columns', 'mfn-opts'),
						'desc' 		=> __('Default: 3. Recommended: 2-4. Too large value may crash the layout.<br />This option works in style: <b>Masonry</b>', 'mfn-opts'),
						'options'	 => array(
							2	=> 2,
							3	=> 3,
							4	=> 4,
							5	=> 5,
							6	=> 6,
						),
						'std' 		=> 3,
					),
					
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'more',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Show | Read More link', 'mfn-opts'),
						'std'		=> 1,
					),
						
					array(
						'id' 		=> 'filters',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Show | Filters', 'mfn-opts'),
						'desc' 		=> __('This option works in <b>Category: All</b> and <b>Style: Masonry</b>', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'pagination',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Show | Pagination', 'mfn-opts'),
						'desc' 		=> __('<strong>Notice:</strong> Pagination will <strong>not</strong> work if you put item on Homepage of WordPress Multilangual Site.', 'mfn-opts'),
					),

					array(
						'id' 		=> 'load_more',
						'type' 		=> 'select',
						'title' 	=> __('Show | Load More button', 'mfn-opts'),
						'sub_desc' 	=> __('Show Ajax Load More button', 'mfn-opts'),  
						'desc' 		=> __('This will replace all sliders on list with featured images. Please also <b>show Pagination</b>', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
			
			// Blog News --------------------------------------------
			'blog_news' => array(
				'type' => 'blog_news',
				'title' => __('Blog News', 'mfn-opts'), 
				'size' => '1/4', 
				'fields' => array(
				
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
			
					array(
						'id' 		=> 'count',
						'type' 		=> 'text',
						'title' 	=> __('Count', 'mfn-opts'),
						'sub_desc' 	=> __('Number of posts to show', 'mfn-opts'),
						'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
						'std' 		=> '5',
						'class' 	=> 'small-text',
					),
	
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title' 	=> __('Category', 'mfn-opts'),
						'options' 	=> mfn_get_categories( 'category' ),
						'sub_desc' 	=> __('Select posts category', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Button Link', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'link_title',
						'type' 		=> 'text',
						'title' 	=> __('Button Title', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
			
			// Blog Slider --------------------------------------------
			'blog_slider' => array(
				'type' => 'blog_slider',
				'title' => __('Blog Slider', 'mfn-opts'), 
				'size' => '1/4', 
				'fields' => array(
				
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
			
					array(
						'id' 		=> 'count',
						'type' 		=> 'text',
						'title' 	=> __('Count', 'mfn-opts'),
						'sub_desc' 	=> __('Number of posts to show', 'mfn-opts'),
						'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
						'std' 		=> '5',
						'class' 	=> 'small-text',
					),
	
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title' 	=> __('Category', 'mfn-opts'),
						'options' 	=> mfn_get_categories( 'category' ),
						'sub_desc' 	=> __('Select posts category', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'more',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Show Read More button', 'mfn-opts'),
						'std'		=> 1,
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title' 	=> __('Style', 'mfn-opts'),
						'options'	=> array(
							''			=> 'Default',
							'flat'		=> 'Flat'
						),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
			
			// Call to Action --------------------------------------------------
			'call_to_action' => array(
				'type' => 'call_to_action',
				'title' => __('Call to Action', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
				
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
					
					array(
						'id'		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
					),
	
					array(
						'id'		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'button_title',
						'type' 		=> 'text',
						'title' 	=> __('Button Title', 'mfn-opts'),
						'desc' 		=> __('Leave this field blank if you want Call to Action with Big Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
					
					array(
						'id' 		=> 'class',
						'type' 		=> 'text',
						'title' 	=> __('Class', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use PrettyPhoto (prettyphoto)', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc'		=> __('Adds a target="_blank" attribute to the link', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),
			),
			
			// Chart  --------------------------------------------------
			'chart' => array(
				'type' => 'chart',
				'title' => __('Chart', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
				
					array(
						'id' 		=> 'percent',
						'type' 		=> 'text',
						'title' 	=> __('Percent', 'mfn-opts'),
						'desc' 		=> __('Number between 0-100', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'label',
						'type' 		=> 'text',
						'title' 	=> __('Chart Label', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Chart Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
					
					array(
						'id'		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Chart Image', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
			
				),
			),
			
			// Clients  --------------------------------------------
			'clients' => array(
				'type' => 'clients',
				'title' => __('Clients', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
		
					array(
						'id' 		=> 'in_row',
						'type' 		=> 'text',
						'title' 	=> __('Items in Row', 'mfn-opts'),
						'sub_desc' 	=> __('Number of items in row', 'mfn-opts'),
						'desc' 		=> __('Recommended number: 3-6', 'mfn-opts'),
						'std' 		=> 6,
						'class' 	=> 'small-text',
					),
					
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'client-types' ),
						'sub_desc'	=> __('Select the client post category.', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date',
							'menu_order' 	=> 'Menu order',
							'title'			=> 'Title',
							'rand'			=> 'Random',
						),
						'std'		=> 'menu_order'
					),
					
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'options'	=> array(
							'ASC' 	=> 'Ascending',
							'DESC' 	=> 'Descending',
						),
						'std'		=> 'ASC'
					),
					
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array(
							''			=> 'Default',
							'tiles' 	=> 'Tiles',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Clients Slider --------------------------------------------
			'clients_slider' => array(
				'type' => 'clients_slider',
				'title' => __('Clients Slider', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
	
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
				
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'client-types' ),
						'sub_desc'	=> __('Select the client post category.', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date',
							'menu_order' 	=> 'Menu order',
							'title'			=> 'Title',
							'rand'			=> 'Random',
						),
						'std'		=> 'menu_order'
					),
					
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'options'	=> array(
							'ASC' 	=> 'Ascending',
							'DESC' 	=> 'Descending',
						),
						'std'		=> 'ASC'
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Code  --------------------------------------------
			'code' => array(
				'type' 		=> 'code',
				'title' 	=> __('Code', 'mfn-opts'), 
				'size' 		=> '1/4', 
				'fields'	=> array(
			
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'class' 	=> 'full-width',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
			
			// Column  --------------------------------------------
			'column' => array(
				'type' 		=> 'column',
				'title' 	=> __('Column', 'mfn-opts'), 
				'size' 		=> '1/4', 
				'fields'	=> array(
			
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
						'desc' 		=> __('This field is used as an Item Label in admin panel only and shows after page update.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Column content', 'mfn-opts'),
						'desc' 		=> __('Shortcodes and HTML tags allowed.', 'mfn-opts'),
						'class' 	=> 'full-width sc',
						'validate' 	=> 'html',
					),				
					
					array(
						'id' 		=> 'align',
						'type' 		=> 'select',
						'title' 	=> __('Text Align', 'mfn-opts'),
						'options' 	=> array(
							''			=> 'None',
							'left'		=> 'Left',
							'right'		=> 'Right',
							'center'	=> 'Center',
							'justify'	=> 'Justify',
						),
					),
					
					array(
						'id' 		=> 'column_bg',
						'type' 		=> 'text',
						'title' 	=> __('Background color', 'mfn-opts'),
						'desc' 		=> __('Use color name ( gray ) or hex ( #808080 )', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'padding',
						'type' 		=> 'text',
						'title' 	=> __('Padding', 'mfn-opts'),
						'desc' 		=> __('Use value with <b>px</b> or <b>%</b>. Example: <b>20px</b> or <b>20px 10px 20px 10px</b> or <b>20px 1%</b>', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),															
			),
			
			// Contact box --------------------------------------------
			'contact_box' => array(
				'type' 		=> 'contact_box',
				'title' 	=> __('Contact Box', 'mfn-opts'), 
				'size' 		=> '1/4', 
				'fields' 	=> array(
			
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'address',
						'type' 		=> 'textarea',
						'title' 	=> __('Address', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'telephone',
						'type' 		=> 'text',
						'title' 	=> __('Phone', 'mfn-opts'),
						'desc' 		=> __('Phone number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),	
								
					array(
						'id' 		=> 'telephone_2',
						'type' 		=> 'text',
						'title' 	=> __('Phone 2nd', 'mfn-opts'),
						'desc' 		=> __('Additional Phone number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),

					array(
						'id' 		=> 'fax',
						'type' 		=> 'text',
						'title' 	=> __('Fax', 'mfn-opts'),
						'desc' 		=> __('Fax number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'email',
						'type' 		=> 'text',
						'title' 	=> __('Email', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'www',
						'type' 		=> 'text',
						'title' 	=> __('WWW', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Background Image', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
			
			// Content  --------------------------------------------
			'content' => array(
				'type' => 'content',
				'title' => __('Content WP', 'mfn-opts'), 
				'size' => '1/4',
				'fields' => array(
			
					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('Adding this Item will show Content from WordPress Editor above Page Options. You can use it only once per page. Please also remember to turn on "Hide The Content" option.', 'nhp-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),														
			),
			
			// Countdown  --------------------------------------------------
			'countdown' => array(
				'type' => 'countdown',
				'title' => __('Countdown', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
			
					array(
						'id' 		=> 'date',
						'type' 		=> 'text',
						'title' 	=> __('Lunch Date', 'mfn-opts'),
						'desc' 		=> __('Format: 12/30/2014 12:00:00 month/day/year hour:minute:second', 'mfn-opts'),
						'std' 		=> '12/30/2014 12:00:00',
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'timezone',
						'type' 		=> 'select',
						'title' 	=> __('UTC Timezone', 'mfn-opts'),
						'options' 	=> mfna_utc(),
						'std' 		=> '0',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
			
				),
			),
			
			// Counter  --------------------------------------------------
			'counter' => array(
				'type' => 'counter',
				'title' => __('Counter', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
			
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'std' 		=> ' icon-lamp',
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'color',
						'type' 		=> 'text',
						'title' 	=> __('Icon Color', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 )', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
	
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
						'desc' 		=> __('If you upload an image, icon will not show', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'number',
						'type' 		=> 'text',
						'title' 	=> __('Number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'prefix',
						'type' 		=> 'text',
						'title' 	=> __('Prefix', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'label',
						'type' 		=> 'text',
						'title' 	=> __('Postfix', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'type',
						'type' 		=> 'select',
						'options' 	=> array(
							'horizontal'	=> 'Horizontal',
							'vertical' 		=> 'Vertical',
						),
						'title' 	=> __('Style', 'mfn-opts'),
						'desc' 		=> __('Vertical style works only for column widths: 1/4, 1/3 & 1/2', 'mfn-opts'),
						'std'		=> 'vertical',
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
					
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
			
				),
			),
		
			// Divider  --------------------------------------------
			'divider' => array(
				'type' => 'divider',
				'title' => __('Divider', 'mfn-opts'), 
				'size' => '1/1',
				'fields' => array(
			
					array(
						'id' 		=> 'height',
						'type' 		=> 'text',
						'title' 	=> __('Divider height', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array( 
							'default'	=> 'Default',
							'dots'		=> 'Dots',
							'zigzag'	=> 'ZigZag',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'line',
						'type' 		=> 'select',
						'options' 	=> array( 
							'default'	=> 'Default',
							'narrow'	=> 'Narrow',
							'wide'		=> 'Wide',
							''			=> 'No Line',
						),
						'title' 	=> __('Line', 'mfn-opts'),
						'desc' 		=> __('This option can be used <strong>only</strong> with Style: Default.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'themecolor',
						'type' 		=> 'select',
						'options' 	=> array( 
							0			=> 'No',
							1			=> 'Yes',
						),
						'title' 	=> __('Theme Color', 'mfn-opts'),
						'desc' 		=> __('This option can be used <strong>only</strong> with Style: Default.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),														
			),	
			
			// Fancy Divider  --------------------------------------------
			'fancy_divider' => array(
				'type' => 'fancy_divider',
				'title' => __('Fancy Divider', 'mfn-opts'), 
				'size' => '1/1',
				'fields' => array(
	
					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('This item can only be used on pages <strong>Without Sidebar</strong>. Please also set Section Style to <strong>Full Width</strong>.', 'nhp-opts'),
					),
				
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array( 
							'circle up'		=> 'Circle Up',
							'circle down'	=> 'Circle Down',
							'curve up'		=> 'Curve Up',
							'curve down'	=> 'Curve Down',
							'stamp'			=> 'Stamp',
							'triangle up'	=> 'Triangle Up',
							'triangle down'	=> 'Triangle Down',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'color_top',
						'type' 		=> 'text',
						'title' 	=> __('Color Top', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 )', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> '',
					),
					
					array(
						'id' 		=> 'color_bottom',
						'type' 		=> 'text',
						'title' 	=> __('Color Bottom', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 )', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> '',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),														
			),	
			
			// Fancy Heading --------------------------------------------
			'fancy_heading' => array(
				'type' 		=> 'fancy_heading',
				'title' 	=> __('Fancy Heading', 'mfn-opts'),
				'size' 		=> '1/1',
				'fields' 	=> array(
				
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'h1',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Use H1 tag', 'mfn-opts'),
						'desc' 		=> __('Wrap title into H1 instead of H2', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'sub_desc' 	=> __('Icon Style only', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'slogan',
						'type' 		=> 'text',
						'title' 	=> __('Slogan', 'mfn-opts'),
						'sub_desc' 	=> __('Line Style only', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class' 	=> 'full-width sc',
						'validate' 	=> 'html',
					),
	
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array( 
							'icon'		=> 'Icon',
							'line'		=> 'Line',
							'arrows' 	=> 'Arrows',
						),
						'title' 	=> __('Style', 'mfn-opts'),
						'desc' 		=> __('Some fields above work on selected styles.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
			
				),
			),
	
			// FAQ  --------------------------------------------
			'faq' => array(
				'type' 		=> 'faq',
				'title' 	=> __('FAQ', 'mfn-opts'), 
				'size' 		=> '1/4', 
				'fields' 	=> array(
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'tabs',
						'type' 		=> 'tabs',
						'title' 	=> __('FAQ', 'mfn-opts'),
						'sub_desc' 	=> __('Manage FAQ tabs.', 'mfn-opts'),
						'desc' 		=> __('You can use Drag & Drop to set the order', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'open1st',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open First', 'mfn-opts'),
						'desc' 		=> __('Open first tab at start', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'openAll',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open All', 'mfn-opts'),
						'desc' 		=> __('Open all tabs at start', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
			
			// Feature List --------------------------------------------
			'feature_list' => array(
				'type' 		=> 'feature_list',
				'title' 	=> __('Feature List', 'mfn-opts'),
				'size' 		=> '1/1',
				'fields' 	=> array(
		
					array(
						'id' 	=> 'title',
						'type' 	=> 'text',
						'title' => __('Title', 'mfn-opts'),
						'desc' 	=> __('This field is used as an Item Label in admin panel only and shows after page update.', 'mfn-opts'),
					),
						
					array(
						'id' 	=> 'content',
						'type' 	=> 'textarea',
						'title' => __('Content', 'mfn-opts'),
						'desc' 	=> __('Please use <strong>[item icon="" title="" link="" target=""]</strong> shortcodes.', 'mfn-opts'),
						'std' 	=> '[item icon="icon-lamp" title="" link="" target="" animate=""]',
					),
						
					array(
						'id' 		=> 'columns',
						'type' 		=> 'select',
						'title' 	=> __('Columns', 'mfn-opts'),
						'desc' 		=> __('Default: 4. Recommended: 2-4. Too large value may crash the layout.', 'mfn-opts'),
						'options'	 => array(
							2	=> 2,
							3	=> 3,
							4	=> 4,
							5	=> 5,
							6	=> 6,
						),
						'std' 		=> 4,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Flat Box --------------------------------------------
			'flat_box' => array(
				'type' 		=> 'flat_box',
				'title' 	=> __('Flat Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'fields' 	=> array(
		
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'std' 		=> 'icon-lamp',
						'class' 	=> 'small-text',
					),
				
					array(
						'id' 		=> 'background',
						'type' 		=> 'text',
						'title' 	=> __('Icon background', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 ). Leave this field blank to use Theme Background', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),		
					),
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate'	=> 'html',
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Hover Box --------------------------------------------
			'hover_box' => array(
				'type' 		=> 'hover_box',
				'title' 	=> __('Hover Box', 'mfn-opts'),
				'size' 		=> '1/4',
				'fields'	=> array(
		
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
							
					array(
						'id' 		=> 'image_hover',
						'type' 		=> 'upload',
						'title' 	=> __('Image | Hover', 'mfn-opts'),
						'desc' 		=> __('Both images <b>must have the same size</b>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'alt',
						'type' 		=> 'text',
						'title' 	=> __('Image | Alt', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array( 
							0 				=> 'Default | _self', 
							1 				=> 'New Tab or Window | _blank' ,
							'prettyphoto' 	=> 'prettyPhoto (images and embed video)', 
						),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Hover Color --------------------------------------------------
			'hover_color' => array(
				'type' => 'hover_color',
				'title' => __('Hover Color', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
			
					array(
						'id' 		=> 'background',
						'type' 		=> 'text',
						'title' 	=> __('Background color', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 )', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> '#2991D6',
					),
			
					array(
						'id' 		=> 'background_hover',
						'type' 		=> 'text',
						'title' 	=> __('Hover Background color', 'mfn-opts'),
						'desc' 		=> __('Use color name ( blue ) or hex ( #2991D6 )', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> '#2991D6',
					),
				
					array(
						'id'		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
	
					array(
						'id'		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'class',
						'type' 		=> 'text',
						'title' 	=> __('Class', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use PrettyPhoto (prettyphoto)', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc'		=> __('Adds a target="_blank" attribute to the link', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
			
				),
			),
			
			// How It Works --------------------------------------------
			'how_it_works' => array(
				'type' 		=> 'how_it_works',
				'title' 	=> __('How It Works', 'mfn-opts'),
				'size' 		=> '1/4',
				'fields' 	=> array(
		
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Background Image', 'mfn-opts'),
						'desc' 		=> __('Recommended: Square Image with transparent background.', 'mfn-opts'),
					),
							
					array(
						'id' 		=> 'number',
						'type' 		=> 'text',
						'title' 	=> __('Number', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
	
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate'	=> 'html',
					),
					
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'title' 	=> __('Line', 'mfn-opts'),
						'sub_desc' 	=> __('Show right connecting line', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Icon Box  --------------------------------------------------
			'icon_box' => array(
				'type' => 'icon_box',
				'title' => __('Icon Box', 'mfn-opts'), 
				'size' => '1/4',
				'fields' => array(
			
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
			
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'std' 		=> 'icon-lamp',
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'icon_position',
						'type' 		=> 'select',
						'options'	=> array(
							'left'	=> 'Left',
							'top'	=> 'Top',
						),
						'title' 	=> __('Icon Position', 'mfn-opts'),
						'desc' 		=> __('Left position works only for column widths: 1/4, 1/3 & 1/2', 'mfn-opts'),
						'std'		=> 'top',
					),
					
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'title' 	=> __('Border', 'mfn-opts'),
						'sub_desc' 	=> __('Show right border', 'mfn-opts'),
						'options' 	=> array(
							0 	=> 'No',
							1 	=> 'Yes'
						),
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
					
					array(
						'id' 		=> 'class',
						'type' 		=> 'text',
						'title' 	=> __('Custom CSS classes for link', 'mfn-opts'),
						'desc' 		=> __('This option is useful when you want to use PrettyPhoto (prettyphoto) or Scroll (scroll).', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),														
			),
				
			// Image  --------------------------------------------------
			'image' => array(
				'type' => 'image',
				'title' => __('Image', 'mfn-opts'), 
				'size' => '1/4',
				'fields' => array(
			
					array(
						'id' 		=> 'src',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'width',
						'type' 		=> 'text',
						'title' 	=> __('Image Width', 'mfn-opts'),
						'desc' 		=> __('px<br />optional', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'height',
						'type' 		=> 'text',
						'title' 	=> __('Image Height', 'mfn-opts'),
						'desc' 		=> __('px<br />optional', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Border', 'mfn-opts'),
						'sub_desc' 	=> __('Show Image Border', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'align',
						'type' 		=> 'select',
						'title' 	=> __('Align', 'mfn-opts'),
						'desc' 		=> __('If you want image to be <b>resized</b> to column width use <b>align none</b>', 'mfn-opts'),
						'options' 	=> array( 
							'' 			=> 'None', 
							'left' 		=> 'Left', 
							'right' 	=> 'Right', 
							'center' 	=> 'Center', 
						),
					),
					
					array(
						'id' 		=> 'margin',
						'type' 		=> 'text',
						'title' 	=> __('Margin Top', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'alt',
						'type' 		=> 'text',
						'title' 	=> __('Alternate Text', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'caption',
						'type' 		=> 'text',
						'title' 	=> __('Caption', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'link_image',
						'type' 		=> 'upload',
						'title' 	=> __('Zoomed image', 'mfn-opts'),
						'desc' 		=> __('This image will be opened in lightbox.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
						'desc' 		=> __('This link will work only if you leave the above "Zoomed image" field empty.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'desc'		=> 'Works only for images with link',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),														
			),
			
			// Info box --------------------------------------------
			'info_box' => array(
				'type' => 'info_box',
				'title' => __('Info Box', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title'		=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
						'std' 		=> '<ul><li>list item 1</li><li>list item 2</li></ul>',
					),
	
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Background Image', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// List --------------------------------------------
			'list' => array(
				'type' 		=> 'list',
				'title'		=> __('List', 'mfn-opts'),
				'size'		=> '1/4',
				'fields'	=> array(
		
					array(
						'id' 		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Icon', 'mfn-opts'),
						'std' 		=> ' icon-lamp',
						'class'		=> 'small-text',
					),
					
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',	
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',	
						'title' 	=> __('Style', 'mfn-opts'),
						'desc' 		=> __('Only <strong>Vertical Style</strong> works for column widths 1/5 & 1/6', 'mfn-opts'),
						'options' 	=> array( 
							1 => 'With background',
							2 => 'Transparent',
							3 => 'Vertical',
							4 => 'Ordered list',
						),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),
			),
			
			// Map ---------------------------------------------
			'map' => array(
				'type'		=> 'map',
				'title'		=> __('Map', 'mfn-opts'), 
				'size'		=> '1/4',
				'fields'	=> array(
	
					array(
						'id' 		=> 'lat',
						'type' 		=> 'text',
						'title' 	=> __('Google Maps Lat', 'mfn-opts'),
						'class' 	=> 'small-text',
						'desc' 		=> __('The map will appear only if this field is filled correctly.<br />Example: <b>-33.87</b>', 'mfn-opts'), 
					),
					
					array(
						'id' 		=> 'lng',
						'type' 		=> 'text',
						'title' 	=> __('Google Maps Lng', 'mfn-opts'),
						'class' 	=> 'small-text',
						'desc' 		=> __('The map will appear only if this field is filled correctly.<br />Example: <b>151.21</b>', 'mfn-opts'), 
					),
		
					array(
						'id' 		=> 'zoom',
						'type' 		=> 'text',
						'title' 	=> __('Zoom', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> 13,
					),
					
					array(
						'id' 		=> 'height',
						'type' 		=> 'text',
						'title' 	=> __('Height', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> 200,
					),
						
					array(
						'id' 		=> 'type',
						'type' 		=> 'select',
						'title' 	=> __('Type', 'mfn-opts'),
						'options' 	=> array(
							'ROADMAP' 	=> __('Map', 'mfn-opts'),
							'SATELLITE' => __('Satellite', 'mfn-opts'),
							'HYBRID' 	=> __('Satellite + Map', 'mfn-opts'),
							'TERRAIN' 	=> __('Terrain', 'mfn-opts'),
						),
					),
						
					array(
						'id' 		=> 'controls',
						'type' 		=> 'select',
						'title' 	=> __('Controls', 'mfn-opts'),
						'options' 	=> array(
							'' 							=> __('Zoom', 'mfn-opts'),
							'mapType' 					=> __('Map Type', 'mfn-opts'),
							'streetView'				=> __('Street View', 'mfn-opts'),
							'zoom mapType' 				=> __('Zoom & Map Type', 'mfn-opts'),
							'zoom streetView' 			=> __('Zoom & Street View', 'mfn-opts'),
							'mapType streetView' 		=> __('Map Type & Street View', 'mfn-opts'),
							'zoom mapType streetView'	=> __('Zoom, Map Type & Street View', 'mfn-opts'),
							'hide'						=> __('Hide All', 'mfn-opts'),
						),
					),
						
					array(
						'id' 		=> 'draggable',
						'type' 		=> 'select',
						'title' 	=> __('Draggable', 'mfn-opts'),
						'options' 	=> array(
							'' 					=> __('Enable', 'mfn-opts'),
							'disable' 			=> __('Disable', 'mfn-opts'),
							'disable-mobile'	=> __('Disable on Mobile', 'mfn-opts'),
						),
					),
						
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'title' 	=> __('Border', 'mfn-opts'),
						'sub_desc' 	=> __('Show map border', 'mfn-opts'),
						'options' 	=> array(
							0 => __('No', 'mfn-opts'),
							1 => __('Yes', 'mfn-opts'),
						),
					),
					
					array(
						'id' 		=> 'icon',
						'type' 		=> 'upload',
						'title' 	=> __('Marker Icon', 'mfn-opts'),
						'desc' 		=> __('.png', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'styles',
						'type' 		=> 'textarea',
						'title' 	=> __('Styles', 'mfn-opts'),
						'sub_desc' 	=> __('Google Maps API styles array', 'mfn-opts'),
						'desc' 		=> __('You can get predefined styles from <a target="_blank" href="http://snazzymaps.com/">snazzymaps.com</a> or generate your own <a target="_blank" href="http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html">here</a>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'latlng',
						'type' 		=> 'textarea',
						'title' 	=> __('Additional Markers | Lat,Lng,IconURL', 'mfn-opts'),
						'desc' 		=> __('Separate Lat,Lang,IconURL[optional] with <b>coma</b> [ , ]<br />Separate multiple Markers with <b>semicolon</b> [ ; ]<br />Example: <b>-33.88,151.21,ICON_URL;-33.89,151.22</b>', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('<strong>Contact Box</strong> | Works only in Full Width', 'nhp-opts'),
					),
		
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Box | Title', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Box | Address', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'telephone',
						'type' 		=> 'text',
						'title' 	=> __('Box | Telephone', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'email',
						'type' 		=> 'text',
						'title' 	=> __('Box | Email', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'www',
						'type' 		=> 'text',
						'title' 	=> __('Box | WWW', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
						
				),														
			),
			
			// Offer Slider Full --------------------------------------------
			'offer' => array(
				'type' => 'offer',
				'title' => __('Offer Slider Full', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
		
					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('This item can only be used on pages <strong>Without Sidebar</strong>.<br />Please also set Section Style to <strong>Full Width</strong> and use one Item in one Section.', 'nhp-opts'),
					),
					
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'offer-types' ),
						'sub_desc'	=> __('Select the offer post category.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Offer Slider Thumb --------------------------------------------
			'offer_thumb' => array(
				'type' => 'offer_thumb',
				'title' => __('Offer Slider Thumb', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
		
					array(
						'id' 		=> 'info',
						'type' 		=> 'info',
						'desc' 		=> __('This item can only be used <strong>once per page</strong>.', 'nhp-opts'),
					),
					
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'offer-types' ),
						'sub_desc'	=> __('Select the offer post category.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options'	=> array(
							''			=> 'Thumbnails on the left',
							'bottom'	=> 'Thumbnails at the bottom',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Opening Hours --------------------------------------------
			'opening_hours' => array(
				'type' => 'opening_hours',
				'title' => __('Opening Hours', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
						'std' 		=> '<ul><li><label>Monday - Saturday</label><span>8am - 4pm</span></li></ul>',
					),
	
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Background Image', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Our team --------------------------------------------
			'our_team' => array(
				'type' => 'our_team',
				'title' => __('Our Team', 'mfn-opts'), 
				'size' => '1/4',
				'fields' => array(
					
					array(
						'id' 		=> 'heading',
						'type' 		=> 'text',
						'title' 	=> __('Heading', 'mfn-opts'),
					),
				
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Photo', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
						'sub_desc' 	=> __('Will also be used as the image alternative text', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'subtitle',
						'type' 		=> 'text',
						'title' 	=> __('Subtitle', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'phone',
						'type' 		=> 'text',
						'title' 	=> __('Phone', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
	
					array(
						'id' 		=> 'email',
						'type' 		=> 'text',
						'title' 	=> __('E-mail', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'facebook',
						'type' 		=> 'text',
						'title' 	=> __('Facebook', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'twitter',
						'type' 		=> 'text',
						'title' 	=> __('Twitter', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'linkedin',
						'type' 		=> 'text',
						'title' 	=> __('LinkedIn', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'vcard',
						'type' 		=> 'text',
						'title' 	=> __('vCard', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'blockquote',
						'type' 		=> 'textarea',
						'title' 	=> __('Blockquote', 'mfn-opts'),
					),	
	
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options'	=> array(
							'circle'		=> 'Circle',
							'vertical'		=> 'Vertical',
							'horizontal'	=> 'Horizontal 	[only: 1/2]',
						),
						'title' 	=> __('Style', 'mfn-opts'),
						'std'		=> 'vertical',
					),
					
					array(
						'id' 		=> 'link',
						'type'		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options'	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),														
			),
			
			// Our team list --------------------------------------------
			'our_team_list' => array(
				'type' => 'our_team_list',
				'title' => __('Our Team List', 'mfn-opts'), 
				'size' => '1/1',
				'fields' => array(
					
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Photo', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
						'sub_desc' 	=> __('Will also be used as the image alternative text', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'subtitle',
						'type' 		=> 'text',
						'title' 	=> __('Subtitle', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'phone',
						'type' 		=> 'text',
						'title' 	=> __('Phone', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
					
					array(
						'id'		=> 'blockquote',
						'type'		=> 'textarea',
						'title'		=> __('Blockquote', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'email',
						'type' 		=> 'text',
						'title' 	=> __('E-mail', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'facebook',
						'type' 		=> 'text',
						'title' 	=> __('Facebook', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'twitter',
						'type' 		=> 'text',
						'title' 	=> __('Twitter', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'linkedin',
						'type' 		=> 'text',
						'title' 	=> __('LinkedIn', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'vcard',
						'type' 		=> 'text',
						'title' 	=> __('vCard', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'link',
						'type'		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options'	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),														
			),
			
			// Photo Box --------------------------------------------
			'photo_box' => array(
				'type' => 'photo_box',
				'title' => __('Photo Box', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id'		=> 'title',
						'type'		=> 'text',
						'title'		=> __('Title', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'image',
						'type'		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
					
					array(
						'id'		=> 'align',
						'type'		=> 'select',
						'title'		=> 'Text Align',
						'options' 	=> array(
							''		=> 'Center',
							'left'	=> 'Left',
							'right'	=> 'Right',
						),
					),
					
					array(
						'id' 		=> 'link',
						'type'		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options'	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'desc'		=> 'Works only for images with link',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Portfolio --------------------------------------------
			'portfolio' => array(
				'type'		=> 'portfolio',
				'title'		=> __('Portfolio', 'mfn-opts'),
				'size'		=> '1/1',
				'fields'	=> array(
		
					array(
						'id'		=> 'count',
						'type'		=> 'text',
						'title'		=> __('Count', 'mfn-opts'),
						'std'		=> '2',
						'class'		=> 'small-text',
					),
	
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'portfolio-types' ),
						'sub_desc'	=> __('Select the portfolio post category.', 'mfn-opts'),
					),
	
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
	
					array(
						'id'		=> 'style',
						'type'		=> 'select',
						'title'		=> 'Style',
						'options' 	=> array(
							'flat'			=> 'Flat',
							'grid'			=> 'Grid',
							'masonry'		=> 'Masonry Blog Style',
							'masonry-hover'	=> 'Masonry Hover Description',
							'list'			=> 'List',
							'masonry-flat'	=> 'Masonry Flat',
						),
						'std' 		=> 'grid'	
					),
						
					array(
						'id' 		=> 'columns',
						'type' 		=> 'select',
						'title' 	=> __('Columns', 'mfn-opts'),
						'desc' 		=> __('Default: 3. Recommended: 2-4. Too large value may crash the layout.<br />This option works in styles: <b>Flat, Grid, Masonry Blog Style, Masonry Hover Details</b>', 'mfn-opts'),
						'options'	 => array(
							2	=> 2,
							3	=> 3,
							4	=> 4,
							5	=> 5,
							6	=> 6,
						),
						'std' 		=> 3,
					),
					
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'sub_desc'	=> __('Portfolio items order by column.', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date', 
							'menu_order' 	=> 'Menu order',			
							'title'			=> 'Title',
							'rand'			=> 'Random',
						),
						'std'		=> 'date'
					),
					
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'sub_desc'	=> __('Portfolio items order.', 'mfn-opts'),
						'options'	=> array(
							'ASC' 	=> 'Ascending',
							'DESC' 	=> 'Descending',
						),
						'std'		=> 'DESC'
					),
	
					array(
						'id' 		=> 'filters',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Show | Filters', 'mfn-opts'),
						'desc' 		=> __('Works only with <b>Category: All</b>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'pagination',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title' 	=> __('Show | Pagination', 'mfn-opts'),
						'desc'		=> __('<strong>Notice:</strong> Pagination will <strong>not</strong> work if you put item on Homepage of WordPress Multilangual Site.', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'load_more',
						'type' 		=> 'select',
						'title' 	=> __('Show | Load More button', 'mfn-opts'),
						'sub_desc' 	=> __('Show Ajax Load More button', 'mfn-opts'),
						'desc' 		=> __('This will replace all sliders on list with featured images. Please also <b>show Pagination</b>', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Portfolio Grid --------------------------------------------
			'portfolio_grid' => array(
				'type'		=> 'portfolio_grid',
				'title'		=> __('Portfolio Grid', 'mfn-opts'),
				'size'		=> '1/4',
				'fields'	=> array(
				
					array(
						'id'		=> 'count',
						'type'		=> 'text',
						'title'		=> __('Count', 'mfn-opts'),
						'std'		=> '4',
						'class'		=> 'small-text',
					),
			
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'portfolio-types' ),
						'sub_desc'	=> __('Select the portfolio post category.', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
			
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'sub_desc'	=> __('Portfolio items order by column.', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date', 
							'menu_order' 	=> 'Menu order',			
							'title'			=> 'Title',
							'rand'			=> 'Random',
						),
						'std'		=> 'date'
					),
					
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'sub_desc'	=> __('Portfolio items order.', 'mfn-opts'),
						'options'	=> array(
							'ASC' 	=> 'Ascending',
							'DESC' 	=> 'Descending',
						),
						'std'		=> 'DESC'
					),
					
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),
			),
			
			// Portfolio Photo --------------------------------------------
			'portfolio_photo' => array(
				'type'		=> 'portfolio_photo',
				'title'		=> __('Portfolio Photo', 'mfn-opts'),
				'size'		=> '1/1',
				'fields'	=> array(
							
					array(
						'id'		=> 'count',
						'type'		=> 'text',
						'title'		=> __('Count', 'mfn-opts'),
						'std'		=> '5',
						'class'		=> 'small-text',
					),
	
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'portfolio-types' ),
						'sub_desc'	=> __('Select the portfolio post category.', 'mfn-opts'),
					),
	
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
		
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'sub_desc'	=> __('Portfolio items order by column.', 'mfn-opts'),
						'options'	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std'		=> 'date'
					),
	
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'sub_desc'	=> __('Portfolio items order.', 'mfn-opts'),
						'options'	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std'		=> 'DESC'
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id'		=> 'greyscale',
						'type'		=> 'select',
						'title'		=> 'Greyscale Images',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Portfolio Slider --------------------------------------------
			'portfolio_slider' => array(
				'type'		=> 'portfolio_slider',
				'title'		=> __('Portfolio Slider', 'mfn-opts'),
				'size'		=> '1/1',
				'fields'	=> array(
				
					array(
						'id'		=> 'count',
						'type'		=> 'text',
						'title'		=> __('Count', 'mfn-opts'),
						'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
						'std'		=> '6',
						'class'		=> 'small-text',
					),
			
					array(
						'id'		=> 'category',
						'type'		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'portfolio-types' ),
						'sub_desc'	=> __('Select the portfolio post category.', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'category_multi',
						'type'		=> 'text',
						'title'		=> __('Multiple Categories', 'mfn-opts'),
						'sub_desc'	=> __('Categories Slugs', 'mfn-opts'),
						'desc'		=> __('Slugs should be separated with <strong>coma</strong> (,).', 'mfn-opts'),
					),
			
					array(
						'id'		=> 'orderby',
						'type'		=> 'select',
						'title'		=> __('Order by', 'mfn-opts'),
						'sub_desc'	=> __('Portfolio items order by column.', 'mfn-opts'),
						'options'	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std'		=> 'date'
					),
	
					array(
						'id'		=> 'order',
						'type'		=> 'select',
						'title'		=> __('Order', 'mfn-opts'),
						'sub_desc'	=> __('Portfolio items order.', 'mfn-opts'),
						'options'	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std'		=> 'DESC'
					),
	
					array(
						'id'		=> 'arrows',
						'type'		=> 'select',
						'title'		=> __('Navigation Arrows', 'mfn-opts'),
						'sub_desc'	=> __('Show Navigation Arrows', 'mfn-opts'),
						'options'	=> array(
							''			=> 'None',
							'hover' 	=> 'Show on hover',
							'always' 	=> 'Always show',
						),
						'std'		=> 'DESC'
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),
			),
			
			// Pricing item --------------------------------------------
			'pricing_item' => array(
				'type' => 'pricing_item',
				'title' => __('Pricing Item', 'mfn-opts'), 
				'size' => '1/4',
				'fields' => array(
			
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title' 	=> __('Image', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
						'sub_desc' 	=> __('Pricing item title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'price',
						'type' 		=> 'text',
						'title' 	=> __('Price', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'currency',
						'type'		=> 'text',
						'title' 	=> __('Currency', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'currency_pos',
						'type'		=> 'select',
						'title' 	=> __('Currency | Position', 'mfn-opts'),
						'options' 	=> array( 
							'' 			=> 'Left', 
							'right'		=> 'Right' 
						),
					),
						
					array(
						'id' 		=> 'period',
						'type' 		=> 'text',
						'title' 	=> __('Period', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id'		=> 'subtitle',
						'type'		=> 'text',
						'title'		=> __('Subtitle', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed.', 'mfn-opts'),
						'std' 		=> '<ul><li><strong>List</strong> item</li></ul>',
					),
					
					array(
						'id' 		=> 'link_title',
						'type' 		=> 'text',
						'title' 	=> __('Button Title', 'mfn-opts'),
						'desc' 		=> __('Button will appear only if this field will be filled.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Button Link', 'mfn-opts'),
						'desc' 		=> __('Button will appear only if this field will be filled.', 'mfn-opts'),
					),
						
					array(
						'id'		=> 'icon',
						'type' 		=> 'icon',
						'title' 	=> __('Button Icon', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
	
					array(
						'id' 		=> 'featured',
						'type' 		=> 'select',
						'title' 	=> __('Featured', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title' 	=> __('Style', 'mfn-opts'),
						'options' 	=> array( 
							'box'	=> 'Box',
							'label'	=> 'Table Label',
							'table'	=> 'Table',	
						),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),														
			),
			
			// Progress Bars  --------------------------------------------
			'progress_bars' => array(
				'type' => 'progress_bars',
				'title' => __('Progress Bars', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Please use <strong>[bar title="Title" value="50"]</strong> shortcodes here.', 'mfn-opts'),
						'std' 		=> '[bar title="Bar1" value="50"]'."\n".'[bar title="Bar2" value="60"]',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Promo Box --------------------------------------------
			'promo_box' => array(
				'type'		=> 'promo_box',
				'title'		=> __('Promo Box', 'mfn-opts'),
				'size'		=> '1/2',
				'fields'	=> array(
	
					array(
						'id'		=> 'image',
						'type'		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'title',
						'type'		=> 'text',
						'title'		=> __('Title', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
					),
					
					array(
						'id' 		=> 'btn_text',
						'type' 		=> 'text',
						'title' 	=> __('Button Text', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					array(
						'id' 		=> 'btn_link',
						'type' 		=> 'text',
						'title' 	=> __('Button Link', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					),
					
					array(
						'id' 		=> 'position',
						'type' 		=> 'select',
						'title' 	=> __('Image position', 'mfn-opts'),
						'options' 	=> array(
							'left' 	=> 'Left',
							'right' => 'Right'
						),
						'std'		=> 'left',
					),
					
					array(
						'id' 		=> 'border',
						'type' 		=> 'select',
						'title' 	=> __('Border', 'mfn-opts'),
						'sub_desc' 	=> __('Show right border', 'mfn-opts'),
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'std'		=> 'no_border',
					),
	
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
	
				),
			),
			
			// Quick Fact --------------------------------------------
			'quick_fact' => array(
				'type' => 'quick_fact',
				'title' => __('Quick Fact', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id' 		=> 'heading',
						'type' 		=> 'text',
						'title' 	=> __('Heading', 'mfn-opts'),
					),
				
					array(
						'id' 		=> 'number',
						'type' 		=> 'text',
						'title'		=> __('Number', 'mfn-opts'),
						'class'		=> 'small-text',
					),
						
					array(
						'id' 		=> 'prefix',
						'type' 		=> 'text',
						'title' 	=> __('Prefix', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
						
					array(
						'id' 		=> 'label',
						'type' 		=> 'text',
						'title' 	=> __('Postfix', 'mfn-opts'),
						'class' 	=> 'small-text',
					),
	
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate' 	=> 'html',
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Shop Slider --------------------------------------------
			'shop_slider' => array(
				'type' 		=> 'shop_slider',
				'title' 	=> __('Shop Slider', 'mfn-opts'),
				'size' 		=> '1/4',
				'fields' 	=> array(
						
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'count',
						'type' 		=> 'text',
						'title' 	=> __('Count', 'mfn-opts'),
						'sub_desc' 	=> __('Number of posts to show', 'mfn-opts'),
						'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
						'std' 		=> '5',
						'class' 	=> 'small-text',
					),
			
					array(
						'id' 		=> 'show',
						'type' 		=> 'select',
						'title'		=> __('Show', 'mfn-opts'),
						'options'	=> array(
							''				=> 'All (or category selected below)',
							'featured'		=> 'Featured',
							'onsale'		=> 'Onsale',
							'best-selling'	=> 'Best Selling (Order by: Sales)',
						),
					),
						
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'product_cat' ),
						'sub_desc'	=> __('Select the products category', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'orderby',
						'type' 		=> 'select',
						'title' 	=> __('Order by', 'mfn-opts'),
						'sub_desc' 	=> __('Slides order by column', 'mfn-opts'),
						'options' 	=> array(
							'date'			=> 'Date', 
							'menu_order' 	=> 'Menu order',
							'title'			=> 'Title',
						),
						'std' 		=> 'date'
					),
	
					array(
						'id' 		=> 'order',
						'type' 		=> 'select',
						'title' 	=> __('Order', 'mfn-opts'),
						'sub_desc' 	=> __('Slides order', 'mfn-opts'),
						'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std' 		=> 'DESC'
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Sidebar Widget --------------------------------------------
			'sidebar_widget' => array(
				'type' 		=> 'sidebar_widget',
				'title' 	=> __('Sidebar Widget', 'mfn-opts'),
				'size' 		=> '1/4',
				'fields' 	=> array(
					
					array(
						'id'		=> 'sidebar',
						'type' 		=> 'select',
						'title' 	=> __('Select Sidebar', 'mfn-opts'),
						'desc' 		=> __('1. Create Sidebar in Theme Options > Getting Started > Sidebars.<br />2. Add Widget.<br />3. Select your sidebar.', 'mfn-opts'),
						'options' 	=> mfn_opts_get( 'sidebars' ),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Slider --------------------------------------------
			'slider' => array(
				'type' 		=> 'slider',
				'title' 	=> __('Slider', 'mfn-opts'),
				'size' 		=> '1/1',
				'fields' 	=> array(
					
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array(
							''				=> 'Default',
							'description'	=> 'Description',
							'flat' 			=> 'Flat',
							'carousel' 		=> 'Carousel',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),
				
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'slide-types' ),
						'sub_desc'	=> __('Select the slides category', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'orderby',
						'type' 		=> 'select',
						'title' 	=> __('Order by', 'mfn-opts'),
						'sub_desc' 	=> __('Slides order by column', 'mfn-opts'),
						'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std' 		=> 'date'
					),
	
					array(
						'id' 		=> 'order',
						'type' 		=> 'select',
						'title' 	=> __('Order', 'mfn-opts'),
						'sub_desc' 	=> __('Slides order', 'mfn-opts'),
						'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std' 		=> 'DESC'
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Slider Plugin --------------------------------------------
			'slider_plugin' => array(
				'type' 		=> 'slider_plugin',
				'title' 	=> __('Slider Plugin', 'mfn-opts'),
				'size' 		=> '1/4',
				'fields' 	=> array(
					
					array(
						'id' 		=> 'rev',
						'type' 		=> 'select',
						'title' 	=> __('Slider | Revolution Slider', 'mfn-opts'),
						'desc' 		=> __('Select one from the list of available <a target="_blank" href="admin.php?page=revslider">Revolution Sliders</a>', 'mfn-opts'),
						'options' 	=> mfn_get_sliders(),
					),
					
					array(
						'id' 		=> 'layer',
						'type' 		=> 'select',
						'title' 	=> __('Slider | Layer Slider', 'mfn-opts'), 
						'desc' 		=> __('Select one from the list of available <a target="_blank" href="admin.php?page=layerslider">Layer Sliders</a>', 'mfn-opts'),
						'options' 	=> mfn_get_sliders_layer(),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Sliding Box --------------------------------------------
			'sliding_box' => array(
				'type' => 'sliding_box',
				'title' => __('Sliding Box', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title'		=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
				
			// Story Box --------------------------------------------
			'story_box' => array(
				'type' => 'story_box',
				'title' => __('Story Box', 'mfn-opts'),
				'size' => '1/2',
				'fields' => array(
		
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'options' 	=> array(
							''			=> 'Horizontal Image',
							'flat' 		=> 'Flat',
						),
						'title' 	=> __('Style', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Content', 'mfn-opts'),
						'desc' 		=> __('Some Shortcodes and HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width sc',
						'validate' 	=> 'html',
					),
					
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title'		=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Tabs --------------------------------------------
			'tabs' => array(
				'type' => 'tabs',
				'title' => __('Tabs', 'mfn-opts'), 
				'size' => '1/4', 
				'fields' => array(
			
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
				
					array(
						'id' 		=> 'tabs',
						'type' 		=> 'tabs',
						'title' 	=> __('Tabs', 'mfn-opts'),
						'sub_desc' 	=> __('To add an <strong>icon</strong> in Title field, please use the following code:<br/><br/>&lt;i class=" icon-lamp"&gt;&lt;/i&gt; Tab Title', 'mfn-opts'),
						'desc' 		=> __('You can use Drag & Drop to set the order.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'type',
						'type' 		=> 'select',
						'options' 	=> array(
							'horizontal'	=> 'Horizontal',
							'vertical' 		=> 'Vertical', 
						),
						'title' 	=> __('Style', 'mfn-opts'),
						'desc' 		=> __('Vertical tabs works only for column widths: 1/2, 3/4 & 1/1', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'uid',
						'type'		=> 'text',
						'title'		=> __('Unique ID [optional]', 'mfn-opts'),
						'sub_desc'	=> __('Allowed characters: "a-z" "-" "_"', 'mfn-opts'),
						'desc'		=> __('Use this option if you want to open specified tab from link.<br />For example: Your Unique ID is <strong>offer</strong> and you want to open 2nd tab, please use link: <strong>your-url/#offer-2</strong>', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),															
			),
				
			// Testimonials --------------------------------------------
			'testimonials' => array(
				'type' => 'testimonials',
				'title' => __('Testimonials', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
					
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'testimonial-types' ),
						'sub_desc'	=> __('Select the testimonial post category.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'orderby',
						'type' 		=> 'select',
						'title' 	=> __('Order by', 'mfn-opts'),
						'sub_desc' 	=> __('Testimonials order by column.', 'mfn-opts'),
						'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std' 		=> 'date'
					),
					
					array(
						'id' 		=> 'order',
						'type' 		=> 'select',
						'title' 	=> __('Order', 'mfn-opts'),
						'sub_desc' 	=> __('Testimonials order.', 'mfn-opts'),
						'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std' 		=> 'DESC'
					),
					
					array(
						'id' 		=> 'style',
						'type' 		=> 'select',
						'title'		=> __('Style', 'mfn-opts'),
						'options' 	=> array( 
							'' 				=> __('Default','mfn-opts'), 
							'single-photo' 	=> __('Single Photo','mfn-opts'), 
						),
					),
					
					array(
						'id' 		=> 'hide_photos',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title'		=> __('Hide Photos', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Testimonials List --------------------------------------------
			'testimonials_list' => array(
				'type' => 'testimonials_list',
				'title' => __('Testimonials List', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
					
					array(
						'id' 		=> 'category',
						'type' 		=> 'select',
						'title'		=> __('Category', 'mfn-opts'),
						'options'	=> mfn_get_categories( 'testimonial-types' ),
						'sub_desc'	=> __('Select the testimonial post category.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'orderby',
						'type' 		=> 'select',
						'title' 	=> __('Order by', 'mfn-opts'),
						'sub_desc' 	=> __('Testimonials order by column.', 'mfn-opts'),
						'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
						'std' 		=> 'date'
					),
					
					array(
						'id' 		=> 'order',
						'type' 		=> 'select',
						'title' 	=> __('Order', 'mfn-opts'),
						'sub_desc' 	=> __('Testimonials order.', 'mfn-opts'),
						'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
						'std' 		=> 'DESC'
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Timeline --------------------------------------------
			'timeline' => array(
				'type' => 'timeline',
				'title' => __('Timeline', 'mfn-opts'),
				'size' => '1/1',
				'fields' => array(
			
					array(
						'id' => 'tabs',
						'type' => 'tabs',
						'title' => __('Timeline', 'mfn-opts'),
						'sub_desc' => __('Please add <strong>date</strong> wrapped into <strong>span</strong> tag in Title field.<br/><br/>&lt;span&gt;2013&lt;/span&gt;Event Title', 'mfn-opts'),
						'desc' => __('You can use Drag & Drop to set the order.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
			
				),
			),
			
			// Trailer Box --------------------------------------------
			'trailer_box' => array(
				'type' => 'trailer_box',
				'title' => __('Trailer Box', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id' 		=> 'image',
						'type' 		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'slogan',
						'type' 		=> 'text',
						'title' 	=> __('Slogan', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'link',
						'type' 		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
						'title'		=> __('Open in new window', 'mfn-opts'),
						'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
					),
					
					array(
						'id' 		=> 'animate',
						'type' 		=> 'select',
						'title' 	=> __('Animation', 'mfn-opts'),
						'desc' 		=> __('<b>Notice:</b> In some versions of Safari browser Hover works only if you select: <b>Not Animated</b> or <b>Fade In</b>', 'mfn-opts'),
						'sub_desc' 	=> __('Entrance animation', 'mfn-opts'),
						'options' 	=> $mfn_animate,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
			// Video  --------------------------------------------
			'video' => array(
				'type' => 'video',
				'title' => __('Video', 'mfn-opts'), 
				'size' => '1/4', 
				'fields' => array(
			
					array(
						'id' 		=> 'video',
						'type' 		=> 'text',
						'title' 	=> __('YouTube or Vimeo | Video ID', 'mfn-opts'),
						'sub_desc' 	=> __('YouTube or Vimeo', 'mfn-opts'),
						'desc' 		=> __('It`s placed in every YouTube & Vimeo video, for example:<br /><b>YouTube:</b> http://www.youtube.com/watch?v=<u>WoJhnRczeNg</u><br /><b>Vimeo:</b> http://vimeo.com/<u>62954028</u>', 'mfn-opts'),
						'class' 	=> 'small-text'
					),
						
					array(
						'id' 		=> 'parameters',
						'type' 		=> 'text',
						'title' 	=> __('YouTube or Vimeo | Parameters', 'mfn-opts'),
						'sub_desc' 	=> __('YouTube or Vimeo', 'mfn-opts'),
						'desc' 		=> __('Multiple parameters should be connected with "&"<br />For example: <b>autoplay=1&loop=1</b>', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'mp4',
						'type'		=> 'upload',
						'title'		=> __('HTML5 | MP4 video', 'mfn-opts'),
						'sub_desc'	=> __('m4v [.mp4]', 'mfn-opts'),
						'desc'		=> __('Please add both mp4 and ogv for cross-browser compatibility.', 'mfn-opts'),
						'class'		=> __('video', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'ogv',
						'type'		=> 'upload',
						'title'		=> __('HTML5 | OGV video', 'mfn-opts'),
						'sub_desc'	=> __('ogg [.ogv]', 'mfn-opts'),
						'class'		=> __('video', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'placeholder',
						'type'		=> 'upload',
						'title'		=> __('HTML5 | Placeholder image', 'mfn-opts'),
						'desc'		=> __('Placeholder Image will be used as video placeholder before video loads and on mobile devices.', 'mfn-opts'),
					),
					
					array(
						'id'		=> 'html5_parameters',
						'type'		=> 'select',
						'title'		=> __('HTML5 | Parameters', 'mfn-opts'),
						'options' 	=> array(
							''			=> 'autoplay controls loop muted',
							'a;c;l;'	=> 'autoplay controls loop',
							'a;c;;m'	=> 'autoplay controls muted',
							'a;;l;m'	=> 'autoplay loop muted',
							'a;c;;'		=> 'autoplay controls',
							'a;;l;'		=> 'autoplay loop',
							'a;;;m'		=> 'autoplay muted',
							'a;;;'		=> 'autoplay',
							';c;l;m'	=> 'controls loop muted',
							';c;l;'		=> 'controls loop',
							';c;;m'		=> 'controls muted',
							';c;;'		=> 'controls',
						),
					),
					
					array(
						'id' 		=> 'width',
						'type' 		=> 'text',
						'title' 	=> __('Width', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> 700,
					),
					
					array(
						'id' 		=> 'height',
						'type' 		=> 'text',
						'title' 	=> __('Height', 'mfn-opts'),
						'desc' 		=> __('px', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> 400,
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
					
				),	
			),
			
			// Visual Editor  --------------------------------------------
			'visual' => array(
				'type' => 'visual',
				'title' => __('Visual Editor', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id' 		=> 'title',
						'type' 		=> 'text',
						'title' 	=> __('Title', 'mfn-opts'),
						'desc' 		=> __('This field is used as an Item Label in admin panel only and shows after page update.', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'content',
						'type' 		=> 'textarea',
						'title' 	=> __('Visual Editor', 'mfn-opts'),
						'param' 	=> 'editor',
						'validate' 	=> 'html',
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
				
			// Zoom Box --------------------------------------------
			'zoom_box' => array(
				'type' => 'zoom_box',
				'title' => __('Zoom Box', 'mfn-opts'),
				'size' => '1/4',
				'fields' => array(
		
					array(
						'id'		=> 'image',
						'type'		=> 'upload',
						'title'		=> __('Image', 'mfn-opts'),
					),
						
					array(
						'id' 		=> 'bg_color',
						'type' 		=> 'text',
						'title' 	=> __('Overlay background', 'mfn-opts'),
						'desc' 		=> __('Use color HEX (ie. "#000000").', 'mfn-opts'),
						'class' 	=> 'small-text',
						'std' 		=> '#000000',
					),
		
					array(
						'id'		=> 'content_image',
						'type'		=> 'upload',
						'title'		=> __('Content Image', 'mfn-opts'),
					),
	
					array(
						'id'		=> 'content',
						'type'		=> 'textarea',
						'title'		=> __('Content', 'mfn-opts'),
						'desc' 		=> __('HTML tags allowed', 'mfn-opts'),
						'class'		=> 'full-width',
					),
	
					array(
						'id' 		=> 'link',
						'type'		=> 'text',
						'title' 	=> __('Link', 'mfn-opts'),
					),
	
					array(
						'id' 		=> 'target',
						'type' 		=> 'select',
						'title' 	=> __('Link | Target', 'mfn-opts'),
						'options'	=> array( 
							0 				=> 'Default | _self', 
							1 				=> 'New Tab or Window | _blank' ,
							'prettyphoto' 	=> 'prettyPhoto (images and embed video)', 
						),
					),
						
					array(
						'id' 		=> 'classes',
						'type' 		=> 'text',
						'title' 	=> __('Custom | Classes', 'mfn-opts'),
						'sub_desc'	=> __('Custom CSS Item Classes Names', 'mfn-opts'),
						'desc'		=> __('Multiple classes should be separated with SPACE', 'mfn-opts'),
					),
		
				),
			),
			
		);
		
		// GET Sections & Items
		$mfn_items_serial = get_post_meta($post->ID, 'mfn-page-items', true);
		$mfn_tmp_fn = 'base'.'64_decode';
		$mfn_items = unserialize(call_user_func($mfn_tmp_fn, $mfn_items_serial));
	
		// OLD Content Builder 1.0 Compatibility
		if( is_array( $mfn_items ) && ! key_exists( 'attr', $mfn_items[0] ) ){
			$mfn_items_builder2 = array(
				'attr'	=> $mfn_std_section,
				'items'	=> $mfn_items
			);
			$mfn_items = array( $mfn_items_builder2 );
		}
	
	// 	print_r($mfn_items);
		$mfn_sections_count = is_array( $mfn_items ) ? count( $mfn_items ) : 0;
	
		// builder visibility
		if( $visibility = mfn_opts_get('builder-visibility') ){
			if( $visibility == 'hide' || ( ! current_user_can( $visibility ) ) ){
				return false;
			}
		}
		
		?>
		<div id="mfn-builder">
			<input type="hidden" id="mfn-row-id" value="<?php echo $mfn_sections_count; ?>" />
			<a id="mfn-go-to-top" href="javascript:void(0);">Go to top</a>
		
			<div id="mfn-content">
	
				<!-- .mfn-row-add ================================================ -->			
				<div class="mfn-row-add">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<td>
									<a class="btn-blue mfn-row-add-btn" href="javascript:void(0);"><em></em><?php _e('Add Section','mfn-opts'); ?></a>
									<div class="logo">Muffin Group | Muffin Builder</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				
				<!-- #mfn-desk ================================================== -->
				<div id="mfn-desk" class="clearfix">
				
					<?php
						for( $i = 0; $i < $mfn_sections_count; $i++ ) {
							mfn_builder_section( $mfn_std_items, $mfn_std_section, $mfn_items[$i], $i+1 );
						}
					?>
				
				</div>
				
				
				<!-- #mfn-rows ================================================= -->
				<div id="mfn-rows" class="clearfix">
					<?php mfn_builder_section( $mfn_std_items, $mfn_std_section ); ?>
				</div>
							
				
				<!-- #mfn-items =============================================== -->
				<div id="mfn-items" class="clearfix">
					<?php
						foreach( $mfn_std_items as $item ){
							mfn_builder_item( $item );
						}
					?>				
				</div>
				
				<!-- #mfn-migrate -->
				<div id="mfn-migrate">

					<div class="btn-wrapper">
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-exp"><?php _e('Export','mfn-opts'); ?></a>
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-imp"><?php _e('Import','mfn-opts'); ?></a>
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-tem btn-primary"><?php _e('Templates','mfn-opts'); ?></a>
					</div>
					<div class="migrate-wrapper export-wrapper hide">
						<textarea id="mfn-items-export" placeholder="Please remember to Publish/Update your post before Export."><?php echo $mfn_items_serial; ?></textarea>
						<span class="description"><?php _e('Copy to clipboard: Ctrl+C (Cmd+C for Mac)','mfn-opts'); ?></span>
					</div>
					
					<div class="migrate-wrapper import-wrapper hide">
						<textarea id="mfn-items-import" placeholder="Paste import data here."></textarea>
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-primary btn-import"><?php _e('Import','mfn-opts'); ?></a>	
						<select name="mfn-items-import-type">
							<option value="replace"><?php _e('REPLACE current builder content','mfn-opts'); ?></options>
							<option value="before"><?php _e('Insert BEFORE current builder content','mfn-opts'); ?></options>
							<option value="after"><?php _e('Insert AFTER current builder content','mfn-opts'); ?></options>
						</select>			
					</div>
					
					<div class="migrate-wrapper templates-wrapper hide">
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-primary btn-template"><?php _e('Use Template','mfn-opts'); ?></a>	
						<select name="mfn-items-import-template-type">
							<option value="replace"><?php _e('REPLACE current builder content','mfn-opts'); ?></options>
							<option value="before"><?php _e('Insert BEFORE current builder content','mfn-opts'); ?></options>
							<option value="after"><?php _e('Insert AFTER current builder content','mfn-opts'); ?></options>
						</select>
						<select id="mfn-items-import-template">
							<option value=""><?php _e('-- Select --','mfn-opts'); ?></options>
							<?php 
								$args = array(
									'post_type' => 'template',
									'posts_per_page'=> -1,
								);
								$templates = get_posts( $args );
									
								if( is_array( $templates ) ){
									foreach ( $templates as $v ){
										echo '<option value="'. $v->ID .'">'. $v->post_title .'</options>';
									}
								}
							?>
						</select>					
					</div>
					
				</div>
		
			</div>
			
			<!-- #mfn-popup -->
			<div id="mfn-popup">
				<a href="javascript:void(0);" class="mfn-btn-close mfn-popup-close"><?php _e('Close','mfn-opts'); ?></a>	
				<a href="javascript:void(0);" class="mfn-popup-save"><?php _e('Save changes','mfn-opts'); ?></a>	
			</div>
			
			<!-- #mfn-items-seo -->
			<div id="mfn-items-seo">
				<?php 
					$mfn_items_seo = get_post_meta($post->ID, 'mfn-page-items-seo', true);
					echo '<textarea id="mfn-items-seo-data">'. $mfn_items_seo .'</textarea>'; 
				?>
			</div>
			
		</div>
		<?php 
	
	}
}


/*-----------------------------------------------------------------------------------*/
/*	SAVE Muffin Builder
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_builder_save' ) )
{
	function mfn_builder_save($post_id) {
	
		$mfn_items = array();
// 		print_r($_POST);
// 		exit;

	
		// Fix | Visual Composer Frontend
		
		if( isset( $_POST['vc_inline'] ) ){
			return false;
		}

		
		// sections loop -------------------------------------------------------------
		if( key_exists('mfn-row-id', $_POST) && is_array($_POST['mfn-row-id']))
		{
			// foreach $_POST['mfn-row-id']
			foreach( $_POST['mfn-row-id'] as $sectionID_k => $sectionID )
			{
				$section = array();
					
				// $section['attr'] - section attributes
				if( key_exists('mfn-rows', $_POST) && is_array($_POST['mfn-rows'])){
					foreach ( $_POST['mfn-rows'] as $section_attr_k => $section_attr ){
						$section['attr'][$section_attr_k] = $section_attr[$sectionID_k];
					}
				}
					
				// $section['items'] - section items will be added in the next foreach
				$section['items'] = '';
					
				$mfn_items[] = $section;
			}
		
			$newParentSectionIDs = array_flip( $_POST['mfn-row-id'] );
		}	
		
		// items loop ----------------------------------------------------------------
		if( key_exists('mfn-item-type', $_POST) && is_array($_POST['mfn-item-type']))
		{
			$count = array();
			$tabs_count = array();
		
			$seo_content = '';
			
			foreach( $_POST['mfn-item-type'] as $type_k => $type )
			{	
				$item = array();
				$item['type'] = $type;
				$item['size'] = $_POST['mfn-item-size'][$type_k];
					
				// init count for specified item type
				if( ! key_exists($type, $count) ){
					$count[$type] = 0;
				}
				
				// init count for specified tab type
				if( ! key_exists($type, $tabs_count) ){
					$tabs_count[$type] = 0;
				}
				
				if( key_exists($type, $_POST['mfn-items']) ){	
					foreach( (array) $_POST['mfn-items'][$type] as $attr_k => $attr ){
	
						if( $attr_k == 'tabs'){
	
							// Accordion, FAQ & Tabs ----------------------------
							$item['fields']['count'] = $attr['count'][$count[$type]];
							if( $item['fields']['count'] ){
								for ($i = 0; $i < $item['fields']['count']; $i++) {
									
									$tab = array();
									$tab['title'] = stripslashes($attr['title'][$tabs_count[$type]]);
									$tab['content'] = stripslashes($attr['content'][$tabs_count[$type]]);
									$item['fields']['tabs'][] = $tab;
									
									// FIX | Yoast SEO
									$seo_val = trim( $attr['title'][$tabs_count[$type]] );
									if( $seo_val && $seo_val != 1 ) $seo_content .= stripslashes( $attr['title'][$tabs_count[$type]] ) .": ";
									$seo_val = trim( $attr['content'][$tabs_count[$type]] );
									if( $seo_val && $seo_val != 1 ) $seo_content .= stripslashes( $attr['content'][$tabs_count[$type]] ) ."\n\n";
									
									$tabs_count[$type]++;
								}
							}
						
						} else {
							$item['fields'][$attr_k] = stripslashes($attr[$count[$type]]);		
							
							// FIX | Yoast SEO
							$seo_val = trim( $attr[$count[$type]] );
							if( $seo_val && $seo_val != 1 ){
								if( $attr_k == 'image' ){
									$seo_content .= '<img src="'. stripslashes( $seo_val ) .'" alt=""/>'."\n\n";
								} elseif( $attr_k == 'link' ){
									$seo_content .= '<a href="'. stripslashes( $seo_val ) .'">'. stripslashes( $seo_val ) .'</a>'."\n\n";
								} else {
									$seo_content .= stripslashes( $seo_val ) ."\n\n";
								}
							}
							
						}
						
					}
				}
					
				// increase count for specified item type
				$count[$type] ++;
					
				// new parent section ID
				$parentSectionID = $_POST['mfn-item-parent'][$type_k];
				$newParentSectionID = $newParentSectionIDs[$parentSectionID];
					
				// $section['items']
				$mfn_items[$newParentSectionID]['items'][] = $item;
			}
		}
	// 	print_r($mfn_items);

		
		// save -----------------------------------------------
		if( $mfn_items ){
			$mfn_tmp_fn = 'base'.'64_encode';
			$new 		= call_user_func($mfn_tmp_fn, serialize($mfn_items));		
		}
		
		
		// migrate --------------------------------------------
		if( key_exists('mfn-items-import', $_POST) || key_exists('mfn-items-import-template', $_POST)  ){

			if( key_exists('mfn-items-import', $_POST) ){
				// Import -----------------------
				
				$import 		= htmlspecialchars(stripslashes( $_POST['mfn-items-import'] ));
				$import_type 	= htmlspecialchars(stripslashes( $_POST['mfn-items-import-type'] ));
				
			} else {
				// Template ---------------------
				
				$template 		= htmlspecialchars(stripslashes( $_POST['mfn-items-import-template'] ));
				$import			= get_post_meta( $template, 'mfn-page-items', true );
				$import_type 	= htmlspecialchars(stripslashes( $_POST['mfn-items-import-template-type'] ));
			}

			if( $import ){
				if( $import_type == 'replace' ){				
					// REPLACE current builder content
					
					$new = $import;
					
				} else {
					// Insert BEFORE/AFTER current builder content
					
					$mfn_tmp_fn = 'base'.'64_decode';
					$import 	= unserialize(call_user_func($mfn_tmp_fn, $import));
					
					if( $import_type == 'before' ){
						$mfn_items = array_merge ( $import, $mfn_items );
					} else {
						$mfn_items = array_merge ( $mfn_items, $import );
					}
					
					$mfn_tmp_fn = 'base'.'64_encode';
					$new = call_user_func($mfn_tmp_fn, serialize($mfn_items));	
					
				}
			}	
		}
	
		
		// "quick edit" fix -----------------------------------
		if( key_exists('mfn-items', $_POST) )
		{
			$field['id'] = 'mfn-page-items';
			$old = get_post_meta($post_id, $field['id'], true);

			if( isset($new) && $new != $old ) {
	
				// update post meta if there is at least one builder section
				update_post_meta($post_id, $field['id'], $new);
	
			} elseif( $old && ( ! isset($new) || ! $new ) ) {
	
				// delete post meta if builder is empty
				delete_post_meta($post_id, $field['id'], $old);
				
			}
			
			// "Yoast SEO" fix
			if( isset($new) ){
				update_post_meta($post_id, 'mfn-page-items-seo', $seo_content);
			}
			
		}
	
	}
}


/*-----------------------------------------------------------------------------------*
 * PRINT Muffin Builder - FRONTEND WordPress Editor Content
 *-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_builder_print_content' ) )
{
	function mfn_builder_print_content( $post_id, $content_field = false ){

		$class = get_post_field( 'post_content', $post_id ) ? 'has_content' : 'no_content' ;
		
		echo '<div class="section the_content '. $class .'">';
			if( ! get_post_meta( $post_id, 'mfn-post-hide-content', true )){
				echo '<div class="section_wrapper">';
					echo '<div class="the_content_wrapper">';
						if( $content_field ){
							echo apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
						} else {
							the_content();
						}
					echo '</div>';
				echo '</div>';
			}
		echo '</div>';
	}
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Muffin Builder - FRONTEND
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_builder_print' ) )
{
	function mfn_builder_print( $post_id, $content_field = false ){

		// Sizes for Items
		$classes = array(
			'1/6' => 'one-sixth',
			'1/5' => 'one-fifth',
			'1/4' => 'one-fourth',
			'1/3' => 'one-third',
			'1/2' => 'one-second',
			'2/3' => 'two-third',
			'3/4' => 'three-fourth',
			'1/1' => 'one'
		);
	
		// Sidebars list
		$sidebars = mfn_opts_get( 'sidebars' );
		
		// GET Sections & Items
		$mfn_items = get_post_meta( $post_id, 'mfn-page-items', true );
		$mfn_tmp_fn = 'base'.'64_decode';
		$mfn_items = unserialize(call_user_func($mfn_tmp_fn, $mfn_items));
		
	// 	print_r($mfn_items);
	
		// WordPress Editor Content -------------------------------------
		if( mfn_opts_get('display-order') == 1 ) mfn_builder_print_content( $post_id, $content_field );
		
		// Content Builder
		if( post_password_required( ) ){
			
			// prevents duplication of the password form
			if( get_post_meta( $post_id, 'mfn-post-hide-content', true ) ){
				echo '<div class="section the_content">';
					echo '<div class="section_wrapper">';
						echo '<div class="the_content_wrapper">';
							echo get_the_password_form( );
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
	
		} elseif( is_array( $mfn_items ) ){
	
			// Sections
			foreach( $mfn_items as $section ){
			
	// 			print_r($section['attr']);
	
				// section attributes -----------------------------------
	
				// Sidebar for section -------------
				if( ( ! mfn_sidebar_classes() ) && // don't show sidebar for section if sidebar for page is set
					( ( $section['attr']['layout'] == 'right-sidebar' ) || ( $section['attr']['layout'] == 'left-sidebar' ) ) )
				{
					$section_sidebar = $section['attr']['layout'];
				} else {
					$section_sidebar = false;
				}
	
				// classes ------------------------
				$section_class 		= array();
				
				$section_class[]	= $section_sidebar;
				$section_class[]	= $section['attr']['style'];
				$section_class[]	= $section['attr']['class'];
				
				if( key_exists( 'visibility', $section['attr']) ){
					$section_class[] = $section['attr']['visibility'];
				}
				if( key_exists( 'bg_video_mp4', $section['attr'] ) && $section['attr']['bg_video_mp4'] ){
					$section_class[] = 'has-video';
				}
				if( key_exists( 'navigation', $section['attr'] ) && $section['attr']['navigation'] ){
					$section_class[] = 'has-navi';
				}
				if( key_exists( 'column_margin', $section['attr'] ) && $section['attr']['column_margin'] ){
					$section_class[] = 'column-margin-'. $section['attr']['column_margin'];
				}
				
				$section_class		= implode(' ', $section_class);
			
				// styles -------------------------
				$section_style 		= '';
	
				$section_style[] 	= 'padding-top:'. intval( $section['attr']['padding_top'] ) .'px';
				$section_style[] 	= 'padding-bottom:'. intval( $section['attr']['padding_bottom'] ) .'px';
				$section_style[] 	= 'background-color:'. $section['attr']['bg_color'];
				
				// background image attributes
				if( $section['attr']['bg_image'] ){
					$section_style[] 	= 'background-image:url('. $section['attr']['bg_image'] .')';
					$section_bg_attr 	= explode(';', $section['attr']['bg_position']);
					$section_style[] 	= 'background-repeat:'. $section_bg_attr[0];
					$section_style[] 	= 'background-position:'. $section_bg_attr[1];
					$section_style[] 	= 'background-attachment:'. $section_bg_attr[2];
					$section_style[] 	= 'background-size:'. $section_bg_attr[3];
					$section_style[] 	= '-webkit-background-size:'. $section_bg_attr[3];
				}
				
				$section_style 		= implode('; ', $section_style );
				
				// parallax -------------------------
				$parallax = false;
				if( $section['attr']['bg_image'] && ( $section_bg_attr[2] == 'fixed' ) ){
					if( ! key_exists(4, $section_bg_attr) || $section_bg_attr[4] != 'still' ){
						$parallax = 'data-stellar-background-ratio="0.5"';
					}
				}
				
				// IDs ------------------------------
				if( key_exists('section_id', $section['attr']) && $section['attr']['section_id'] ){
					$section_id = 'id="'. $section['attr']['section_id'] .'"';
				} else {
					$section_id = false;
				}
				
				// print ------------------------------------------------
				
				echo '<div class="section '. $section_class .'" '. $section_id .' style="'. $section_style .'" '. $parallax .'>'; // 100%
				
					// Video ------------------------
					if( key_exists( 'bg_video_mp4', $section['attr'] ) && $mp4 = $section['attr']['bg_video_mp4'] ){
						echo '<div class="section_video">';
						
							echo '<div class="mask"></div>';
							
							$poster = $section['attr']['bg_image'];
							
							echo '<video poster="'. $poster .'" controls="controls" muted="muted" preload="auto" loop="true" autoplay="true">';
								
								echo '<source type="video/mp4" src="'. $mp4 .'" />';
								if( key_exists( 'bg_video_ogv', $section['attr'] ) && $ogv = $section['attr']['bg_video_ogv'] ){
									echo '<source type="video/ogg" src="'. $ogv .'" />';
								}
								
								echo '<object width="1900" height="1060" type="application/x-shockwave-flash" data="'. THEME_URI .'/js/flashmediaelement.swf">';
									echo '<param name="movie" value="'. THEME_URI .'/js/flashmediaelement.swf" />';
									echo '<param name="flashvars" value="controls=true&file='. $mp4 .'" />';
									echo '<img src="'. $poster .'" title="No video playback capabilities" />';
								echo '</object>';
								
							echo '</video>';
							
						echo '</div>';
					}
					
					// Separator ------------------------
					if( key_exists( 'divider', $section['attr'] ) && $divider = $section['attr']['divider'] ){
						echo '<div class="section-divider '. $divider .'"></div>';
					}
					
					// Navigation ------------------------
					if( key_exists( 'navigation', $section['attr'] ) && $divider = $section['attr']['navigation'] ){
						echo '<div class="section-nav prev"><i class="icon-up-open"></i></div>';
						echo '<div class="section-nav next"><i class="icon-down-open"></i></div>';
					}
				
					echo '<div class="section_wrapper clearfix">'; // WIDTH + margin: 0 auto
						
						// Items ------------------------
						echo '<div class="items_group clearfix">'; // 100% || WIDTH (sidebar)
							if( is_array( $section['items'] ) ){			
								foreach( $section['items'] as $item ){
								
									if( function_exists( 'mfn_print_'. $item['type'] ) ){
									
										$class  = $classes[$item['size']];				// Item | Size
										$class .= ' column_'. $item['type'];			// Item | Type
										
										if( isset( $item['fields']['classes'] ) ){
											$class .= ' '. $item['fields']['classes'];	// Item | Custom Classes
										}
	
										echo '<div class="column '. $class .'">';
											call_user_func( 'mfn_print_'. $item['type'], $item );
										echo '</div>';
									}
			
								}
							}
						echo '</div>';
						
						// Sidebar for section -----------
						if( $section_sidebar ){
							echo '<div class="four columns section_sidebar">';
								echo '<div class="widget-area clearfix">';
									dynamic_sidebar( $sidebars[$section['attr']['sidebar']] );
								echo '</div>';
							echo '</div>';
						}
						
					echo '</div>';
				echo '</div>';
			}
		}
		
		// WordPress Editor Content -------------------------------------
		if( mfn_opts_get('display-order') == 0 ) mfn_builder_print_content( $post_id, $content_field );
	}
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Item - FRONTEND
/*-----------------------------------------------------------------------------------*/

// ---------- [accordion] -----------
if( ! function_exists( 'mfn_print_accordion' ) )
{
	function mfn_print_accordion( $item ) {
		echo sc_accordion( $item['fields'] );
	}
}

// ---------- [article_box] -----------
if( ! function_exists( 'mfn_print_article_box' ) )
{
	function mfn_print_article_box( $item ) {
		echo sc_article_box( $item['fields'] );
	}
}

// ---------- [blockquote] -----------
if( ! function_exists( 'mfn_print_blockquote' ) )
{
	function mfn_print_blockquote( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_blockquote( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [blog] -----------
if( ! function_exists( 'mfn_print_blog' ) )
{
	function mfn_print_blog( $item ) {
		echo sc_blog( $item['fields'] );
	}
}

// ---------- [blog_news] -----------
if( ! function_exists( 'mfn_print_blog_news' ) )
{
	function mfn_print_blog_news( $item ) {
		echo sc_blog_news( $item['fields'] );
	}
}

// ---------- [blog_slider] -----------
if( ! function_exists( 'mfn_print_blog_slider' ) )
{
	function mfn_print_blog_slider( $item ) {
		echo sc_blog_slider( $item['fields'] );
	}
}

// ---------- [call_to_action] -----------
if( ! function_exists( 'mfn_print_call_to_action' ) )
{
	function mfn_print_call_to_action( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_call_to_action( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [chart] -----------
if( ! function_exists( 'mfn_print_chart' ) )
{
	function mfn_print_chart( $item ) {
		echo sc_chart( $item['fields'] );
	}
}

// ---------- [clients] -----------
if( ! function_exists( 'mfn_print_clients' ) )
{
	function mfn_print_clients( $item ) {
		echo sc_clients( $item['fields'] );
	}
}

// ---------- [clients_slider] -----------
if( ! function_exists( 'mfn_print_clients_slider' ) )
{
	function mfn_print_clients_slider( $item ) {
		echo sc_clients_slider( $item['fields'] );
	}
}

// ---------- [code] -----------
if( ! function_exists( 'mfn_print_code' ) )
{
	function mfn_print_code( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_code( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [column] -----------
if( ! function_exists( 'mfn_print_column' ) )
{
	function mfn_print_column( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		
		$column_class 	= '';
		$column_attr 	= '';
		$style 			= '';
		
		// align
		if( key_exists('align', $item['fields']) && $item['fields']['align'] ){
			$column_class	.= ' align_'. $item['fields']['align'];
		}	
		
		// animate
		if( key_exists('animate', $item['fields']) && $item['fields']['animate'] ){
			$column_class	.= ' animate';
			$column_attr	.= ' data-anim-type="'. $item['fields']['animate'] .'"'; 
		}

		// background
		if( key_exists('column_bg', $item['fields']) && $item['fields']['column_bg'] ){
			$style .= ' background-color:'. $item['fields']['column_bg'] .';';
		}
		
		// padding
		if( key_exists('padding', $item['fields']) && $item['fields']['padding'] ){
			$style .= ' padding:'. $item['fields']['padding'] .';';
		}
		
		echo '<div class="column_attr'. $column_class .'" '. $column_attr .' style="'. $style .'">';
			echo do_shortcode( $item['fields']['content'] );
		echo '</div>';
	}
}

// ---------- [contact_box] -----------
if( ! function_exists( 'mfn_print_contact_box' ) )
{
	function mfn_print_contact_box( $item ) {
		echo sc_contact_box( $item['fields'] );
	}
}

// ---------- [content] -----------
if( ! function_exists( 'mfn_print_content' ) )
{
	function mfn_print_content( $item ) {
		echo '<div class="the_content">';
			echo '<div class="the_content_wrapper">';
				the_content();
			echo '</div>';
		echo '</div>';
	}
}

// ---------- [countdown] -----------
if( ! function_exists( 'mfn_print_countdown' ) )
{
	function mfn_print_countdown( $item ) {
		echo sc_countdown( $item['fields'] );
	}
}

// ---------- [counter] -----------
if( ! function_exists( 'mfn_print_counter' ) )
{
	function mfn_print_counter( $item ) {
		echo sc_counter( $item['fields'] );
	}
}

// ---------- [divider] -----------
if( ! function_exists( 'mfn_print_divider' ) )
{
	function mfn_print_divider( $item ) {
		echo sc_divider( $item['fields'] );
	}
}

// ---------- [fancy_divider] -----------
if( ! function_exists( 'mfn_print_fancy_divider' ) )
{
	function mfn_print_fancy_divider( $item ) {
		echo sc_fancy_divider( $item['fields'] );
	}
}

// ---------- [fancy_heading] -----------
if( ! function_exists( 'mfn_print_fancy_heading' ) )
{
	function mfn_print_fancy_heading( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_fancy_heading( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [faq] -----------
if( ! function_exists( 'mfn_print_faq' ) )
{
	function mfn_print_faq( $item ) {
		echo sc_faq( $item['fields'] );
	}
}

// ---------- [feature_list] -----------
if( ! function_exists( 'mfn_print_feature_list' ) )
{
	function mfn_print_feature_list( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_feature_list( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [flat_box] -----------
if( ! function_exists( 'mfn_print_flat_box' ) )
{
	function mfn_print_flat_box( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_flat_box( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [hover_box] -----------
if( ! function_exists( 'mfn_print_hover_box' ) )
{
	function mfn_print_hover_box( $item ) {
		echo sc_hover_box( $item['fields'] );
	}
}

// ---------- [hover_color] -----------
if( ! function_exists( 'mfn_print_hover_color' ) )
{
	function mfn_print_hover_color( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_hover_color( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [how_it_works] -----------
if( ! function_exists( 'mfn_print_how_it_works' ) )
{
	function mfn_print_how_it_works( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_how_it_works( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [icon_box] -----------
if( ! function_exists( 'mfn_print_icon_box' ) )
{
	function mfn_print_icon_box( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_icon_box( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [image] -----------
if( ! function_exists( 'mfn_print_image' ) )
{
	function mfn_print_image( $item ) {
		echo sc_image( $item['fields'] );
	}
}

// ---------- [info_box] -----------
if( ! function_exists( 'mfn_print_info_box' ) )
{
	function mfn_print_info_box( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_info_box( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [list] -----------
if( ! function_exists( 'mfn_print_list' ) )
{
	function mfn_print_list( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_list( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [map] -----------
if( ! function_exists( 'mfn_print_map' ) )
{
	function mfn_print_map( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_map( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [offer] -----------
if( ! function_exists( 'mfn_print_offer' ) )
{
	function mfn_print_offer( $item ) {
		echo sc_offer( $item['fields'] );
	}
}

// ---------- [offer_thumb] -----------
if( ! function_exists( 'mfn_print_offer_thumb' ) )
{
	function mfn_print_offer_thumb( $item ) {
		echo sc_offer_thumb( $item['fields'] );
	}
}

// ---------- [opening_hours] -----------
if( ! function_exists( 'mfn_print_opening_hours' ) )
{
	function mfn_print_opening_hours( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_opening_hours( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [our_team] -----------
if( ! function_exists( 'mfn_print_our_team' ) )
{
	function mfn_print_our_team( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_our_team( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [our_team_list] -----------
if( ! function_exists( 'mfn_print_our_team_list' ) )
{
	function mfn_print_our_team_list( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_our_team_list( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [photo_box] -----------
if( ! function_exists( 'mfn_print_photo_box' ) )
{
	function mfn_print_photo_box( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_photo_box( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [placeholder] -----------
if( ! function_exists( 'mfn_print_placeholder' ) )
{
	function mfn_print_placeholder( $item ) {
		echo '<div class="placeholder">&nbsp;</div>';
	}
}

// ---------- [portfolio] -----------
if( ! function_exists( 'mfn_print_portfolio' ) )
{
	function mfn_print_portfolio( $item ) {
		echo sc_portfolio( $item['fields'] );
	}
}

// ---------- [portfolio_grid] -----------
if( ! function_exists( 'mfn_print_portfolio_grid' ) )
{
	function mfn_print_portfolio_grid( $item ) {
		echo sc_portfolio_grid( $item['fields'] );
	}
}

// ---------- [portfolio_photo] -----------
if( ! function_exists( 'mfn_print_portfolio_photo' ) )
{
	function mfn_print_portfolio_photo( $item ) {
		echo sc_portfolio_photo( $item['fields'] );
	}
}

// ---------- [portfolio_slider] -----------
if( ! function_exists( 'mfn_print_portfolio_slider' ) )
{
	function mfn_print_portfolio_slider( $item ) {
		echo sc_portfolio_slider( $item['fields'] );
	}
}

// ---------- [pricing_item] -----------
if( ! function_exists( 'mfn_print_pricing_item' ) )
{
	function mfn_print_pricing_item( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_pricing_item( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [progress_bars] -----------
if( ! function_exists( 'mfn_print_progress_bars' ) )
{
	function mfn_print_progress_bars( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_progress_bars( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [promo_box] -----------
if( ! function_exists( 'mfn_print_promo_box' ) )
{
	function mfn_print_promo_box( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_promo_box( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [quick_fact] -----------
if( ! function_exists( 'mfn_print_quick_fact' ) )
{
	function mfn_print_quick_fact( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_quick_fact( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [shop_slider] -----------
if( ! function_exists( 'mfn_print_shop_slider' ) )
{
	function mfn_print_shop_slider( $item ) {
		echo sc_shop_slider( $item['fields'] );
	}
}

// ---------- [sidebar_widget] -----------
if( ! function_exists( 'mfn_print_sidebar_widget' ) )
{
	function mfn_print_sidebar_widget( $item ) {
		echo sc_sidebar_widget( $item['fields'] );
	}
}

// ---------- [slider] -----------
if( ! function_exists( 'mfn_print_slider' ) )
{
	function mfn_print_slider( $item ) {
		echo sc_slider( $item['fields'] );
	}
}

// ---------- [slider_plugin] -----------
if( ! function_exists( 'mfn_print_slider_plugin' ) )
{
	function mfn_print_slider_plugin( $item ) {
		echo sc_slider_plugin( $item['fields'] );
	}
}

// ---------- [sliding_box] -----------
if( ! function_exists( 'sc_sliding_box' ) )
{
	function mfn_print_sliding_box( $item ) {
		echo sc_sliding_box( $item['fields'] );
	}
}

// ---------- [story_box] -----------
if( ! function_exists( 'mfn_print_story_box' ) )
{
	function mfn_print_story_box( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_story_box( $item['fields'], $item['fields']['content'] );
	}
}

// ---------- [tabs] -----------
if( ! function_exists( 'mfn_print_tabs' ) )
{
	function mfn_print_tabs( $item ) {
		echo sc_tabs( $item['fields'] );
	}
}

// ---------- [testimonials] -----------
if( ! function_exists( 'mfn_print_testimonials' ) )
{
	function mfn_print_testimonials( $item ) {
		echo sc_testimonials( $item['fields'] );
	}
}

// ---------- [testimonials_list] -----------
if( ! function_exists( 'mfn_print_testimonials_list' ) )
{
	function mfn_print_testimonials_list( $item ) {
		echo sc_testimonials_list( $item['fields'] );
	}
}

// ---------- [timeline] -----------
if( ! function_exists( 'mfn_print_timeline' ) )
{
	function mfn_print_timeline( $item ) {
		echo sc_timeline( $item['fields'] );
	}
}

// ---------- [trailer_box] -----------
if( ! function_exists( 'mfn_print_trailer_box' ) )
{
	function mfn_print_trailer_box( $item ) {
		echo sc_trailer_box( $item['fields'] );
	}
}

// ---------- [video] -----------
if( ! function_exists( 'mfn_print_video' ) )
{
	function mfn_print_video( $item ) {
		echo sc_video( $item['fields'] );
	}
}

// ---------- [visual] -----------
if( ! function_exists( 'mfn_print_visual' ) )
{
	function mfn_print_visual( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo do_shortcode( $item['fields']['content'] );
	}
}

// ---------- [zoom_box] -----------
if( ! function_exists( 'mfn_print_zoom_box' ) )
{
	function mfn_print_zoom_box( $item ) {
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo sc_zoom_box( $item['fields'], $item['fields']['content'] );
	}
}

?>
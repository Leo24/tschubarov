<?php
/**
 * Theme Options - fields and args
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

require_once( dirname( __FILE__ ) . '/fonts.php' );
require_once( dirname( __FILE__ ) . '/options.php' );

/**
 * Options Page | Helper Functions
 */

// Header Style
if( ! function_exists( 'mfna_header_style' ) )
{
	function mfna_header_style(){
		return array(
			'modern'				=> array('title' => 'Modern',			'img' => MFN_OPTIONS_URI.'img/select/header/modern.png'),
			'classic'				=> array('title' => 'Classic',			'img' => MFN_OPTIONS_URI.'img/select/header/classic.png'),
			'plain'					=> array('title' => 'Plain',			'img' => MFN_OPTIONS_URI.'img/select/header/plain.png'),
			'stack,left'			=> array('title' => 'Stack: Left', 		'img' => MFN_OPTIONS_URI.'img/select/header/stack-left.png'),
			'stack,center'			=> array('title' => 'Stack: Center',	'img' => MFN_OPTIONS_URI.'img/select/header/stack-center.png'),
			'stack,right'			=> array('title' => 'Stack: Right', 	'img' => MFN_OPTIONS_URI.'img/select/header/stack-right.png'),
			'stack,magazine'		=> array('title' => 'Magazine', 		'img' => MFN_OPTIONS_URI.'img/select/header/magazine.png'),
			'creative'				=> array('title' => 'Creative',			'img' => MFN_OPTIONS_URI.'img/select/header/creative.png'),
			'creative,open'			=> array('title' => 'Creative: Always Open', 'img' => MFN_OPTIONS_URI.'img/select/header/creative-open.png'),
			'fixed'					=> array('title' => 'Fixed', 			'img' => MFN_OPTIONS_URI.'img/select/header/fixed.png'),
			'transparent'			=> array('title' => 'Transparent', 		'img' => MFN_OPTIONS_URI.'img/select/header/transparent.png'),
			'simple'				=> array('title' => 'Simple', 			'img' => MFN_OPTIONS_URI.'img/select/header/simple.png'),
			'simple,empty'			=> array('title' => 'Empty: Subpage without Header', 'img' => MFN_OPTIONS_URI.'img/select/header/empty.png'),
			'below'					=> array('title' => 'Below Slider', 	'img' => MFN_OPTIONS_URI.'img/select/header/below.png'),
			'split'					=> array('title' => 'Split Menu<br />(Page Options: Custom Menu is NOT supported)', 'img' => MFN_OPTIONS_URI.'img/select/header/split.png'),
			'below,split'			=> array('title' => 'Below Slider with Split Menu<br />(Page Options: Custom Menu is NOT supported)', 'img' => MFN_OPTIONS_URI.'img/select/header/below-split.png'),
			'overlay,transparent'	=> array('title' => 'Overlay Menu<br />(Sticky Header affects ONLY the menu button)', 'img' => MFN_OPTIONS_URI.'img/select/header/overlay.png'),
		);
	}
}

// Background Position
if( ! function_exists( 'mfna_bg_position' ) )
{
	function mfna_bg_position( $body = false ){
		$array = array(
			'no-repeat;center top;;' 		=> 'Center Top No-Repeat',
			'repeat;center top;;' 			=> 'Center Top Repeat',
			'no-repeat;center bottom;;' 	=> 'Center Bottom No-Repeat',
			'repeat;center bottom;;' 		=> 'Center Bottom Repeat',
				
			'no-repeat;center;;' 			=> 'Center No-Repeat',
			'repeat;center;;' 				=> 'Center Repeat',
				
			'no-repeat;left top;;' 			=> 'Left Top No-Repeat',
			'repeat;left top;;' 			=> 'Left Top Repeat',
			'no-repeat;left bottom;;' 		=> 'Left Bottom No-Repeat',
			'repeat;left bottom;;' 			=> 'Left Bottom Repeat',
				
			'no-repeat;right top;;' 		=> 'Right Top No-Repeat',
			'repeat;right top;;' 			=> 'Right Top Repeat',
			'no-repeat;right bottom;;' 		=> 'Right Bottom No-Repeat',
			'repeat;right bottom;;' 		=> 'Right Bottom Repeat',
		);
	
		if( $body ){
			$array['no-repeat;center top;fixed;;']			= 'Center No-Repeat Fixed';
			$array['no-repeat;center;fixed;cover']			= 'Center No-Repeat Fixed Cover';
		} else {
			$array['no-repeat;center top;fixed;;still']		= 'Center No-Repeat Fixed';			// Old Style Still Parallax
			$array['no-repeat;center;fixed;cover;still']	= 'Center No-Repeat Fixed Cover';	// Old Style Still Parallax Cover
			$array['no-repeat;center top;fixed;cover']		= 'Parallax';
		}
	
		return $array;
	}
}

// Skin
if( ! function_exists( 'mfna_skin' ) )
{
	function mfna_skin(){
		return array(
			'custom' 	=> '- Custom Skin -',
			'one' 		=> '- One Color Skin -',
			'blue'		=> 'Blue',
			'brown'		=> 'Brown',
			'chocolate'	=> 'Chocolate',
			'gold'		=> 'Gold',
			'green'		=> 'Green',
			'olive'		=> 'Olive',
			'orange'	=> 'Orange',
			'pink'		=> 'Pink',
			'red'		=> 'Red',
			'sea'		=> 'Seagreen',
			'violet'	=> 'Violet',
			'yellow'	=> 'Yellow',
		);
	}
}

// UTC
if( ! function_exists( 'mfna_utc' ) )
{
	function mfna_utc(){
		return array('-12'=>'-12','-11'=>'-11','-10'=>'-10','-9'=>'-9','-8'=>'-8',
				'-7'=>'-7','-6'=>'-6','-5'=>'-5','-4'=>'-4','-3'=>'-3','-2'=>'-2','-1'=>'-1',
				'0'=>'0','+1'=>'+1','+2'=>'+2','+3'=>'+3','+4'=>'+4','+5'=>'+5','+6'=>'+6',
				'+7'=>'+7','+8'=>'+8','+9'=>'+9','+10'=>'+10','+11'=>'+11','+12'=>'+12');
	}
}

// Layouts
if( ! function_exists( 'mfna_layout' ) )
{
	function mfna_layout(){
		$layouts = array( 0 => '-- Theme Options --' );
		$args = array(
			'post_type' => 'layout',
			'posts_per_page'=> -1,
		);
		$lay = get_posts( $args );

		if( is_array( $lay ) ){
			foreach ( $lay as $v ){
				$layouts[$v->ID] = $v->post_title;
			}
		}
		
		return $layouts;
	}
}

// Menu
if( ! function_exists( 'mfna_menu' ) )
{
	function mfna_menu(){
		$aMenus = array( 0 => '-- Default --' );
		$oMenus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		
		if( is_array($oMenus) ){
			foreach( $oMenus as $menu ){
				$aMenus[$menu->term_id] = $menu->name;
			}
		}
		
		return $aMenus;
	}
}


/**
 * Options Page | Fields & Args
 */
if( ! function_exists( 'mfn_opts_setup' ) )
{
	function mfn_opts_setup(){
		
		// Navigation elements
		$menu = array(	
		
			// Global --------------------------------------------
			'global' => array(
				'title' 	=> __('Global', 'mfn-opts'),
				'sections' 	=> array( 'general', 'logo', 'sliders', 'advanced', 'hooks' ),
			),
				
			// Header & Subheader --------------------------------------------
			'header-subheader' => array(
				'title' 	=> __('Header & Subheader', 'mfn-opts'),
				'sections' 	=> array( 'header', 'subheader', 'extras' ),
			),
				
			// Menu & Action Bar --------------------------------------------
			'mab' => array(
				'title' 	=> __('Menu & Action Bar', 'mfn-opts'),
				'sections' 	=> array( 'menu', 'action-bar' ),
			),
				
			// Sidebars --------------------------------------------
			'sidebars' => array(
				'title' 	=> __('Sidebars', 'mfn-opts'),
				'sections' 	=> array( 'sidebars' ),
			),
				
			// Blog, Portfolio, Shop --------------------------------------------
			'bps' => array(
				'title' 	=> __('Blog, Portfolio & Shop', 'mfn-opts'),
				'sections' 	=> array( 'bps-general', 'blog', 'portfolio', 'shop' ),
			),
				
			// Pages --------------------------------------------
			'pages' => array(
				'title' 	=> __('Pages', 'mfn-opts'),
				'sections' 	=> array( 'pages-general', 'pages-404', 'pages-under' ),
			),
				
			// Footer --------------------------------------------
			'footer' => array(
				'title' 	=> __('Footer', 'mfn-opts'),
				'sections' 	=> array( 'footer' ),
			),
				
			// Responsive --------------------------------------------
			'responsive' => array(
				'title' 	=> __('Responsive', 'mfn-opts'),
				'sections' 	=> array( 'responsive' ),
			),
				
			// SEO --------------------------------------------
			'seo' => array(
				'title' 	=> __('SEO', 'mfn-opts'),
				'sections' 	=> array( 'seo' ),
			),
				
			// Social --------------------------------------------
			'social' => array(
				'title' 	=> __('Social', 'mfn-opts'),
				'sections' 	=> array( 'social' ),
			),
				
			// Addons, Plugins --------------------------------------------
			'addons-plugins' => array(
				'title' 	=> __('Addons & Plugins', 'mfn-opts'),
				'sections' 	=> array( 'addons', 'plugins' ),
			),

			// Colors --------------------------------------------
			'colors' => array(
				'title' 	=> __('Colors', 'mfn-opts'),
				'sections' 	=> array( 'colors-general', 'colors-header', 'colors-menu', 'content', 'colors-footer', 'colors-sliding-top', 'headings', 'colors-shortcodes' ),
			),
			
			// Fonts --------------------------------------------
			'font' => array(
				'title' 	=> __('Fonts', 'mfn-opts'),
				'sections' 	=> array( 'font-family', 'font-size', 'font-custom' ),
			),
			
			// Translate --------------------------------------------
			'translate' => array(
				'title' 	=> __('Translate', 'mfn-opts'),
				'sections'	=> array( 'translate-general', 'translate-blog', 'translate-404', 'translate-wpml' ),
			),
				
			// Custom CSS, JS --------------------------------------------
			'custom' => array(
				'title' 	=> __('Custom CSS & JS', 'mfn-opts'),
				'sections' 	=> array( 'css', 'js' ),
			),
			
		);
	
		$sections = array();
	
		// Global =================================================================================
		
		// General -------------------------------------------
		$sections['general'] = array(
			'title'		=> __('General', 'mfn-opts'),
			'fields' 	=> array(
	
				array(
					'id'		=> 'style',
					'type' 		=> 'radio_img',
					'title' 	=> __('Main Style', 'mfn-opts'),
					'desc' 		=> __('BETA version | This option now includes ONLY styles for some elements and will be gradually developed', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> array('title' => 'Default', 	'img' => MFN_OPTIONS_URI .'img/select/style/default.png'),
						'simple' 	=> array('title' => 'Simple', 	'img' => MFN_OPTIONS_URI .'img/select/style/simple.png'),
					),
					'class'		=> 'wide',
				),
					
				array(
					'id'		=> 'layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Layout', 'mfn-opts'),
					'options' 	=> array(
						'full-width' 	=> array('title' => 'Full width', 	'img' => MFN_OPTIONS_URI.'img/select/style/full-width.png'),
						'boxed' 		=> array('title' => 'Boxed', 		'img' => MFN_OPTIONS_URI.'img/select/style/boxed.png'),
					),
					'std' 		=> 'full-width',
					'class'		=> 'wide',
				),
					
				array(
					'id' 		=> 'grid-width',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Grid width', 'mfn-opts'),
					'sub_desc' 	=> __('Default 1240px', 'mfn-opts'),
					'desc' 		=> __('Works only with <b>Responsive ON</b> and <b>960px Grid OFF</b>', 'mfn-opts'),
					'param'	 	=> array(
						'min' 		=> 960,
						'max' 		=> 1920,
					),
					'std' 		=> 1240,
				),
					
				array(
					'id' 		=> 'grid960',
					'type' 		=> 'switch',
					'title' 	=> __('960px Grid', 'mfn-opts'),
					'desc' 		=> __('<u><b>----- deprecated since 8.8 -----</b></u><br />This option is deprecated and will be removed in newer versions. Please use <b>Grid width</b> option above', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '0'
				),
	
				array(
					'id' 		=> 'img-page-bg',
					'type' 		=> 'upload',
					'title' 	=> __('Background Image', 'mfn-opts'),
					'desc' 		=> __('This option can be used <strong>only</strong> with Layout: <strong>Boxed</strong>', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'position-page-bg',
					'type' 		=> 'select',
					'title' 	=> __('Background Image | Position', 'mfn-opts'),
					'desc' 		=> __('This option can be used only with your custom image selected above', 'mfn-opts'),
					'options' 	=> mfna_bg_position(1),
					'std' 		=> 'center top no-repeat',
				),
					
				array(
					'id'		=> 'favicon-img',
					'type'		=> 'upload',
					'title'		=> __('Icon | Favicon', 'mfn-opts'),
					'desc'		=> __('<b>.ico</b> 32x32 pixels', 'mfn-opts')
				),
					
				array(
					'id'		=> 'apple-touch-icon',
					'type'		=> 'upload',
					'title'		=> __('Icon | Apple Touch', 'mfn-opts'),
					'desc'		=> __('<b>apple-touch-icon.png</b> 180x180 pixels', 'mfn-opts')
				),

			),
		);
		
		// Logo --------------------------------------------
		$sections['logo'] = array(
			'title' 	=> __('Logo', 'mfn-opts'),
			'fields' 	=> array(
	
				array(
					'id'		=> 'logo-img',
					'type'		=> 'upload',
					'title'		=> __('Logo', 'mfn-opts'),
				),
					
				array(
					'id'		=> 'retina-logo-img',
					'type'		=> 'upload',
					'title'		=> __('Retina Logo', 'mfn-opts'),
					'sub_desc'	=> __('optional', 'mfn-opts'),
					'desc'		=> __('Retina Logo should be 2x larger than Custom Logo', 'mfn-opts'),
				),
					
				array(
					'id'		=> 'sticky-logo-img',
					'type'		=> 'upload',
					'title'		=> __('Sticky Header | Logo', 'mfn-opts'),
					'sub_desc'	=> __('optional', 'mfn-opts'),
					'desc'		=> __('Use if you want different logo for Sticky Header', 'mfn-opts'),
				),	

				array(
					'id'		=> 'sticky-retina-logo-img',
					'type'		=> 'upload',
					'title'		=> __('Sticky Header | Retina Logo', 'mfn-opts'),
					'sub_desc'	=> __('optional', 'mfn-opts'),
					'desc'		=> __('Retina Logo should be 2x larger than Sticky Logo', 'mfn-opts'),
				),

				array(
					'id'		=> 'logo-text',
					'type'		=> 'text',
					'title'		=> __('Text Logo', 'mfn-opts'),
					'sub_desc'	=> __('optional', 'mfn-opts'),
					'desc'		=> __('Use text <b>instead</b> of graphic logo', 'mfn-opts'),
					'class'		=> 'small-text',
				),
					
				array(
					'id'		=> 'logo-width',
					'type'		=> 'text',
					'title'		=> __('SVG Logo width', 'mfn-opts'),
					'sub_desc'	=> __('optional', 'mfn-opts'),
					'desc'		=> __('Use <b>only</b> with <b>svg</b> logo', 'mfn-opts'),
					'class'		=> 'small-text',
				),
					
				array(
					'id' 		=> 'logo-link',
					'type' 		=> 'checkbox',
					'title' 	=> __('Options', 'mfn-opts'),
					'options' 	=> array(
						'link'		=> 'Link to Homepage',
						'h1-home'	=> 'Wrap into H1 tag on Homepage',
						'h1-all'	=> 'Wrap into H1 tag on All other pages',
					),
				),
	
			),
		);
		
		// Sliders --------------------------------------------
		$sections['sliders'] = array(
			'title' 	=> __('Sliders', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(
						
				array(
					'id' 		=> 'slider-blog-timeout',
					'type' 		=> 'text',
					'title' 	=> __('Blog', 'mfn-opts'),
					'sub_desc' 	=> __('Milliseconds between slide', 'mfn-opts'),
					'desc' 		=> __('<strong>0 to disable auto</strong> advance.<br />1000ms = 1s', 'mfn-opts'),
					'class'		=> 'small-text',
					'std' 		=> '0',
				),
					
				array(
					'id' 		=> 'slider-clients-timeout',
					'type' 		=> 'text',
					'title' 	=> __('Clients', 'mfn-opts'),
					'sub_desc' 	=> __('Milliseconds between slide', 'mfn-opts'),
					'desc' 		=> __('<strong>0 to disable auto</strong> advance.<br />1000ms = 1s', 'mfn-opts'),
					'class'		=> 'small-text',
					'std' 		=> '0',
				),
					
				array(
					'id' 		=> 'slider-offer-timeout',
					'type' 		=> 'text',
					'title' 	=> __('Offer', 'mfn-opts'),
					'sub_desc' 	=> __('Milliseconds between slide', 'mfn-opts'),
					'desc' 		=> __('<strong>0 to disable auto</strong> advance.<br />1000ms = 1s', 'mfn-opts'),
					'class'		=> 'small-text',
					'std' 		=> '0',
				),
					
				array(
					'id' 		=> 'slider-portfolio-timeout',
					'type' 		=> 'text',
					'title' 	=> __('Portfolio', 'mfn-opts'),
					'sub_desc' 	=> __('Milliseconds between slide', 'mfn-opts'),
					'desc' 		=> __('<strong>0 to disable auto</strong> advance.<br />1000ms = 1s', 'mfn-opts'),
					'class'		=> 'small-text',
					'std' 		=> '0',
				),
					
				array(
					'id' 		=> 'slider-shop-timeout',
					'type' 		=> 'text',
					'title' 	=> __('Shop', 'mfn-opts'),
					'sub_desc' 	=> __('Milliseconds between slide', 'mfn-opts'),
					'desc' 		=> __('<strong>0 to disable auto</strong> advance.<br />1000ms = 1s', 'mfn-opts'),
					'class'		=> 'small-text',
					'std' 		=> '0',
				),
					
				array(
					'id' 		=> 'slider-slider-timeout',
					'type' 		=> 'text',
					'title' 	=> __('Slider', 'mfn-opts'),
					'sub_desc' 	=> __('Milliseconds between slide', 'mfn-opts'),
					'desc' 		=> __('<strong>0 to disable auto</strong> advance.<br />1000ms = 1s', 'mfn-opts'),
					'class'		=> 'small-text',
					'std' 		=> '0',
				),
					
				array(
					'id' 		=> 'slider-testimonials-timeout',
					'type' 		=> 'text',
					'title' 	=> __('Testimonials', 'mfn-opts'),
					'sub_desc' 	=> __('Milliseconds between slide', 'mfn-opts'),
					'desc' 		=> __('<strong>0 to disable auto</strong> advance.<br />1000ms = 1s', 'mfn-opts'),
					'class'		=> 'small-text',
					'std' 		=> '0',
				),
						
			),
		);
		
		// Advanced -------------------------------------------
		$sections['advanced'] = array(
			'title' => __('Advanced', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
	
				array(
					'id' 		=> 'builder-visibility',
					'type' 		=> 'select',
					'title' 	=> __('Builder | Visibility', 'mfn-opts'),
					'options' 	=> array(
						'' 						=> '- Everyone -',
						'publish_posts'			=> 'Author',
						'edit_pages'			=> 'Editor',
						'edit_theme_options'	=> 'Administrator',
						'hide'					=> 'HIDE for Everyone',
// 						'disable'				=> 'DISABLE do not include builder files',
					),
				),
					
				array(
					'id' 		=> 'display-order',
					'type' 		=> 'select',
					'title' 	=> __('Content | Display Order', 'mfn-opts'),
					'options' 	=> array(
						0 => 'Muffin Builder - WordPress Editor',
						1 => 'WordPress Editor - Muffin Builder',
					),
				),
					
				array(
					'id' 		=> 'content-remove-padding',
					'type' 		=> 'switch',
					'title' 	=> __('Content | Remove Padding', 'mfn-opts'),
					'desc' 		=> __('Remove default Content Padding for <b>all</b> pages/posts without sidebar', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),
						
				array(
					'id' 		=> 'image-frame-style',
					'type' 		=> 'select',
					'title' 	=> __('Image Frame | Style', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> 'Slide Bottom',
						'overlay' 	=> 'Overlay',
					),
				),

				array(
					'id' 		=> 'math-animations-disable',
					'type' 		=> 'switch',
					'title' 	=> __('Math Animate | Disable', 'mfn-opts'),
					'sub_desc' 	=> __('Disable animations for Counter, Quick fact', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),

				array(
					'id' 		=> 'table-hover-disable',
					'type' 		=> 'switch',
					'title' 	=> __('Table Hover | Disable', 'mfn-opts'),
					'sub_desc' 	=> __('Disable hover for Table rows', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),
					
				array(
					'id' 		=> 'post-type-disable',
					'type' 		=> 'checkbox',
					'title' 	=> __('Post Type | Disable', 'mfn-opts'),
					'desc' 		=> __('If you do not want to use any of these Types, you can disable it', 'mfn-opts'),
					'options' 	=> array(
						'client'		=> 'Clients',
						'layout'		=> 'Layouts',
						'offer'			=> 'Offer',
						'portfolio'		=> 'Portfolio',
						'slide'			=> 'Slides',
						'template'		=> 'Templates',
						'testimonial'	=> 'Testimonials',
					),
				),
	
				array(
					'id' 		=> 'theme-disable',
					'type' 		=> 'checkbox',
					'title' 	=> __('Theme Functions | Disable', 'mfn-opts'),
					'desc' 		=> __('If you do not want to use any of these functions or use external plugins to do the same, you can disable it', 'mfn-opts'),
					'options' 	=> array(
						'demo-data'				=> 'BeTheme Demo Data',
						'entrance-animations'	=> 'Entrance Animations',
						'mega-menu'				=> 'Mega Menu',
					),
				),
					
				array(
					'id' 		=> 'static-css',
					'type' 		=> 'switch',
					'title' 	=> __('Static CSS', 'mfn-opts'),
					'sub_desc' 	=> __('Use Static CSS files insted of Theme Options', 'mfn-opts'),
					'desc' 		=> __('For more info please see <a href="http://themes.muffingroup.com/betheme/documentation/#static-css" target="_blank">http://themes.muffingroup.com/betheme/documentation/#static-css</a>', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '0'
				),
					
				array(
					'id' 		=> 'table_prefix',
					'type' 		=> 'select',
					'title' 	=> __('Table Prefix', 'mfn-opts'),
					'desc' 		=> __('For some <b>multisite</b> installations it is necessary to change table prefix to get Sliders List in Page Options. Please do <b>not</b> change if everything works.', 'mfn-opts'),
					'options' 	=> array(
						'base_prefix' 	=> 'base_prefix',
						'prefix' 		=> 'prefix',
					),
				),
	
			),
		);
		
		// Hooks --------------------------------------------
		$sections['hooks'] = array(
			'title' 	=> __('Hooks', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(
	
				array(
					'id' 		=> 'hook-top',
					'type' 		=> 'textarea',
					'title' 	=> __('Top', 'mfn-opts'),
					'sub_desc'	=> __('mfn_hook_top', 'mfn-opts'),
					'desc' 		=> __('Executes after the opening &lt;body&gt; tag', 'mfn-opts'),
				),

				array(
					'id' 		=> 'hook-content-before',
					'type' 		=> 'textarea',
					'title' 	=> __('Content before', 'mfn-opts'),
					'sub_desc'	=> __('mfn_hook_content_before', 'mfn-opts'),
					'desc' 		=> __('Executes before the opening &lt;#Content&gt; tag', 'mfn-opts'),
				),

				array(
					'id' 		=> 'hook-content-after',
					'type' 		=> 'textarea',
					'title' 	=> __('Content after', 'mfn-opts'),
					'sub_desc'	=> __('mfn_hook_content_after', 'mfn-opts'),
					'desc' 		=> __('Executes after the closing &lt;/#Content&gt; tag', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'hook-bottom',
					'type' 		=> 'textarea',
					'title' 	=> __('Bottom', 'mfn-opts'),
					'sub_desc'	=> __('mfn_hook_bottom', 'mfn-opts'),
					'desc' 		=> __('Executes after the closing &lt;/body&gt; tag', 'mfn-opts'),
				),
	
			),
		);
		
		// Header, Subheader ======================================================================
		
		// Header --------------------------------------------
		$sections['header'] = array(
			'title' => __('Header', 'mfn-opts'),
			'fields' => array(
	
				array(
					'id' 		=> 'header-style',
					'type' 		=> 'radio_img',
					'title' 	=> __('Style', 'mfn-opts'),
					'options'	=> mfna_header_style(),
					'std'		=> 'modern',
					'class'		=> 'wide',
				),

				array(
					'id'		=> 'header-fw',
					'type' 		=> 'checkbox',
					'title' 	=> __('Options', 'mfn-opts'),
					'options' 	=> array(
						'full-width'	=> 'Full Width (for layout: Full Width)',
						'header-boxed'	=> 'Boxed Sticky Header (for layout: Boxed)',
					),
				),

				array(
					'id' 		=> 'img-subheader-bg',
					'type' 		=> 'upload',
					'title' 	=> __('Image', 'mfn-opts'),
					'desc' 		=> __('Pages without slider. May be overridden for single page.', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'img-subheader-attachment',
					'type' 		=> 'select',
					'title' 	=> __('Image | Attachment', 'mfn-opts'),
					'options'	=> array(
						''			=> 'Default',
						'fixed'		=> 'Fixed',
						'parallax'	=> 'Parallax',
					),
				),
					
				array(
					'id'		=> 'minimalist-header',
					'type'		=> 'switch',
					'title'		=> __('Minimalist', 'mfn-opts'),
					'desc'		=> __('Header without background image & padding', 'mfn-opts'),
					'options'	=> array('1' => 'On','0' => 'Off'),
					'std'		=> '0'
				),

				array(
					'id'		=> 'sticky-header',
					'type'		=> 'switch',
					'title'		=> __('Sticky', 'mfn-opts'),
					'options'	=> array('1' => 'On','0' => 'Off'),
					'std'		=> '1'
				),

				array(
					'id'		=> 'sticky-header-style',
					'type'		=> 'select',
					'title'		=> __('Sticky | Style', 'mfn-opts'),
					'options'	=> array(
						'white'		=> 'White',
						'dark'		=> 'Dark',
					),
				),
	
			),
		);
		
		// Subheader --------------------------------------------
		$sections['subheader'] = array(
			'title' => __('Subheader', 'mfn-opts'),
			'fields' => array(

				array(
					'id' 		=> 'subheader-transparent',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Alpha (transparency)', 'mfn-opts'),
					'sub_desc' 	=> __('0 = transparent, 100 = solid', 'mfn-opts'),
					'desc' 		=> __('<strong>Important:</strong> This option can be used only with <strong>Custom</strong> or <strong>One Color Skin</strong>', 'mfn-opts'),
					'param'	 	=> array(
						'min' 		=> 0,
						'max' 		=> 100,
					),
					'std' 		=> '100',
				),
					
				array(
					'id' 		=> 'subheader-image',
					'type' 		=> 'upload',
					'title' 	=> __('Image', 'mfn-opts'),
				),

				array(
					'id'		=> 'subheader-slider-show',
					'type'		=> 'switch',
					'title'		=> __('Show with Slider', 'mfn-opts'),
					'desc'		=> __('Show Subheader on pages with Slider', 'mfn-opts'),
					'options'	=> array( '0' => 'Off', '1' => 'On' ),
					'std'		=> '0',
				),
					
				array(
					'id'		=> 'subheader-style',
					'type'		=> 'select',
					'title'		=> __('Style', 'mfn-opts'),
					'options'	=> array(
						'' 				=> 'Title on the Left',
						'title-right' 	=> 'Title on the Right',
						'both-left' 	=> 'Title & Breadcrumbs on the Left',
						'both-right' 	=> 'Title & Breadcrumbs on the Right',
						'both-center' 	=> 'Title & Breadcrumbs Centered',
					),
				),

// 				array(
// 					'id'		=> 'subheader',
// 					'type'		=> 'select',
// 					'title'		=> __('Visibility', 'mfn-opts'),
// 					'options'	=> array(
// 						'' 				=> 'Default',
// 						'breadcrumbs' 	=> 'Hide Breadcrumbs',
// 						'all' 			=> 'Hide Subheader',
// 					),
// 				),
					
				array(
					'id'		=> 'subheader',
					'type' 		=> 'checkbox',
					'title' 	=> __('Options', 'mfn-opts'),
					'options' 	=> array(
						'breadcrumbs-link'	=> 'Breadcrumbs | Last item is link (NOT for Shop)',
						'hide-breadcrumbs'	=> 'Breadcrumbs | Hide',
						'hide-subheader'	=> 'Subheader | Hide',
					),
				),

			),
		);
		
		// Extras --------------------------------------------
		$sections['extras'] = array(
			'title' => __('Extras', 'mfn-opts'),
			'fields' => array(

				array(
					'id'		=> 'header-action-title',
					'type'		=> 'text',
					'title'		=> __('Action Button | Title', 'mfn-opts'),
					'class'		=> 'small-text',
				),

				array(
					'id'		=> 'header-action-link',
					'type'		=> 'text',
					'title'		=> __('Action Button | Link', 'mfn-opts'),
				),
					
				array(
					'id'		=> 'header-action-target',
					'type' 		=> 'checkbox',
					'title' 	=> __('Action Button | Options', 'mfn-opts'),
					'options' 	=> array(
						'target'	=> 'Open in new window',
						'scroll'	=> 'Scroll to section (use #SectionID as Link)',
					),
				),

				array(
					'id' 		=> 'header-banner',
					'type' 		=> 'textarea',
					'title' 	=> __('Banner', 'mfn-opts'),
					'sub_desc' 	=> __('Header Magazine (468px x 60px) or Creative (250px x 250px) Banner code ', 'mfn-opts'),
					'desc' 		=> '&lt;a href="#" target="_blank"&gt;&lt;img src="" alt="" /&gt;&lt;/a&gt;',
				),
					
				array(
					'id'		=> 'header-search',
					'type'		=> 'select',
					'title'		=> __('Search', 'mfn-opts'),
					'options'	=> array(
						'1' 		=> 'Icon | Default',
						'shop' 		=> 'Icon | Search Shop Products only',
						'input' 	=> 'Search Field',
						'0' 		=> 'Hide',
					),
				),

				array(
					'id'		=> 'sliding-top',
					'type'		=> 'select',
					'title'		=> __('Sliding Top', 'mfn-opts'),
					'desc'		=> __('Widgetized Sliding Top position', 'mfn-opts'),
					'options'	=> array(
						'1' 		=> 'Right',
						'center' 	=> 'Center',
						'left' 		=> 'Left',
						'0' 		=> 'Hide',
					),
					'std'		=> '0',
				),
					
				array(
					'id'		=> 'sliding-top-icon',
					'type'		=> 'icon',
					'title'		=> __('Sliding Top | Icon', 'mfn-opts'),
					'std'		=> 'icon-down-open-mini',
				),
					
				array(
					'id'		=> 'header-wpml',
					'type'		=> 'select',
					'title'		=> __('WPML | Custom Switcher Style', 'mfn-opts'),
					'desc'		=> __('Custom Language Switcher is independent of WPML switcher options', 'mfn-opts'),
					'options'	=> array(
						''					=> 'Dropdown | Flags',
						'dropdown-name'		=> 'Dropdown | Language Name (native)',
						'horizontal'		=> 'Horizontal | Flags',
						'horizontal-code'	=> 'Horizontal | Language Code',
						'hide'				=> 'Hide',
					),
				),
					
				array(
					'id'		=> 'header-wpml-options',
					'type' 		=> 'checkbox',
					'title'		=> __('WPML | Custom Switcher Options', 'mfn-opts'),
					'options' 	=> array(
						'link-to-home'	=> 'Link to home of language for missing translations<span>Disable this option to skip languages with missing translation</span>',
					),
				),
	
			),
		);
		
		// Menu, Action Bar =======================================================================
		
		// Menu --------------------------------------------
		$sections['menu'] = array(
			'title' => __('Menu', 'mfn-opts'),
			'fields' => array(
	
				array(
					'id'		=> 'menu-style',
					'type'		=> 'select',
					'title'		=> __('Style', 'mfn-opts'),
					'desc'		=> __('For some header style only', 'mfn-opts'),
					'options'	=> array(
						''					=> 'Default',
						'line-below'		=> 'Line below Menu',
						'line-below-80'		=> 'Line below Link (80% width)',
						'line-below-80-1'	=> 'Line below Link (80% width, 1px height)',
						'arrow-top'			=> 'Arrow Top',
						'arrow-bottom'		=> 'Arrow Bottom',
						'highlight'			=> 'Highlight',
						'hide'				=> 'HIDE Menu',
					),
				),
					
				array(
					'id'		=> 'menu-options',
					'type' 		=> 'checkbox',
					'title' 	=> __('Options', 'mfn-opts'),
					'options' 	=> array(
						'align-right'	=> 'Align Menu to Right',
						'menu-arrows'	=> 'Menu Arrows for items with submenu',
						'hide-borders'	=> 'Hide Border between Items',
					),
				),

			),
		);
		
		// Action Bar --------------------------------------------
		$sections['action-bar'] = array(
			'title' => __('Action Bar', 'mfn-opts'),
			'fields' => array(
					
				array(
					'id'		=> 'action-bar',
					'type'		=> 'switch',
					'title'		=> __('Action Bar', 'mfn-opts'),
					'desc'		=> __('Show Action Bar above the header', 'mfn-opts'),
					'options'	=> array('1' => 'On','0' => 'Off'),
					'std'		=> '1',
				),
					
				array(
					'id'		=> 'header-slogan',
					'type'		=> 'text',
					'title'		=> __('Slogan', 'mfn-opts'),
					'class'		=> 'small-text',
				),
					
				array(
					'id'		=> 'header-phone',
					'type'		=> 'text',
					'title'		=> __('Phone', 'mfn-opts'),
					'sub_desc'	=> __('Phone number', 'mfn-opts'),
					'class'		=> 'small-text',
				),
					
				array(
					'id'		=> 'header-phone-2',
					'type'		=> 'text',
					'title'		=> __('2nd Phone', 'mfn-opts'),
					'sub_desc'	=> __('Additional Phone number', 'mfn-opts'),
					'class'		=> 'small-text',
				),
					
				array(
					'id'		=> 'header-email',
					'type'		=> 'text',
					'title'		=> __('Email', 'mfn-opts'),
					'sub_desc'	=> __('Email address', 'mfn-opts'),
					'class'		=> 'small-text',
				),
	
			),
		);
		
		// Sidebars ===============================================================================
		
		// Sidebars --------------------------------------------
		$sections['sidebars'] = array(
			'title' => __('General', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
						
				array(
					'id' 		=> 'sidebars',
					'type' 		=> 'multi_text',
					'title' 	=> __('Sidebars', 'mfn-opts'),
					'sub_desc' 	=> __('Manage custom sidebars', 'mfn-opts'),
				),

				array(
					'id' 		=> 'sidebar-width',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Width', 'mfn-opts'),
					'sub_desc' 	=> __('Sidebar width in percent', 'mfn-opts'),
					'desc' 		=> __('Default: 23%. Recommended: 20%-30%. Too small or too large value may crash the layout', 'mfn-opts'),
					'param'	 	=> array(
						'min' 		=> 10,
						'max' 		=> 50,
					),
					'std' 		=> '23',
				),
					
				array(
					'id' 		=> 'sidebar-lines',
					'type' 		=> 'select',
					'title' 	=> __('Lines', 'mfn-opts'),
					'sub_desc' 	=> __('Sidebar Lines Style', 'mfn-opts'),
					'options' 	=> array(
						''				=> 'Default',
						'lines-boxed'	=> 'Sidebar Width',
						'lines-hidden'	=> 'Hide Lines',
					),
					'std' 		=> '',
				),
					
				array(
					'id' 		=> 'single-page-layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Page | Layout', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force layout for all pages', 'mfn-opts'),
					'desc' 		=> __('This option can <strong>not</strong> be overriden and it is usefull for people who already have many pages and want to standardize their appearance.', 'mfn-opts'),
					'options' 	=> array(
						'' 				=> array('title' => 'Use Page Meta', 'img' => MFN_OPTIONS_URI.'img/question.png'),
						'no-sidebar' 	=> array('title' => 'Full width without sidebar', 'img' => MFN_OPTIONS_URI.'img/1col.png'),
						'left-sidebar'	=> array('title' => 'Left Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cl.png'),
						'right-sidebar'	=> array('title' => 'Right Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cr.png'),
						'both-sidebars' => array('title' => 'Both Sidebars', 'img' => MFN_OPTIONS_URI.'img/2sb.png'),
					),
				),
					
				array(
					'id' 		=> 'single-page-sidebar',
					'type' 		=> 'text',
					'title' 	=> __('Page | Sidebar', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force sidebar for all pages', 'mfn-opts'),
					'desc' 		=> __('Paste the name of one of the sidebars that you added in the "Sidebars" section.', 'mfn-opts'),
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'single-page-sidebar2',
					'type' 		=> 'text',
					'title' 	=> __('Page | Sidebar 2', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force sidebar for all pages', 'mfn-opts'),
					'desc' 		=> __('Paste the name of one of the sidebars that you added in the "Sidebars" section.', 'mfn-opts'),
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'single-layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Post | Layout', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force layout for all posts', 'mfn-opts'),
					'desc' 		=> __('This option can <strong>not</strong> be overriden and it is usefull for people who already have many posts and want to standardize their appearance.', 'mfn-opts'),
					'options' 	=> array(
						'' 				=> array('title' => 'Use Post Meta', 'img' => MFN_OPTIONS_URI.'img/question.png'),
						'no-sidebar' 	=> array('title' => 'Full width without sidebar', 'img' => MFN_OPTIONS_URI.'img/1col.png'),
						'left-sidebar'	=> array('title' => 'Left Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cl.png'),
						'right-sidebar'	=> array('title' => 'Right Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cr.png'),
						'both-sidebars' => array('title' => 'Both Sidebars', 'img' => MFN_OPTIONS_URI.'img/2sb.png'),
					),
				),
					
				array(
					'id' 		=> 'single-sidebar',
					'type' 		=> 'text',
					'title' 	=> __('Post | Sidebar', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force sidebar for all posts', 'mfn-opts'),
					'desc' 		=> __('Paste the name of one of the sidebars that you added in the "Sidebars" section.', 'mfn-opts'),
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'single-sidebar2',
					'type' 		=> 'text',
					'title' 	=> __('Post | Sidebar 2', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force sidebar for all posts', 'mfn-opts'),
					'desc' 		=> __('Paste the name of one of the sidebars that you added in the "Sidebars" section.', 'mfn-opts'),
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'single-portfolio-layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Portfolio | Layout', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force layout for all projects', 'mfn-opts'),
					'desc' 		=> __('This option can <strong>not</strong> be overriden and it is usefull for people who already have many projects and want to standardize their appearance.', 'mfn-opts'),
					'options' 	=> array(
						'' 				=> array('title' => 'Use Post Meta', 'img' => MFN_OPTIONS_URI.'img/question.png'),
						'no-sidebar' 	=> array('title' => 'Full width without sidebar', 'img' => MFN_OPTIONS_URI.'img/1col.png'),
						'left-sidebar'	=> array('title' => 'Left Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cl.png'),
						'right-sidebar'	=> array('title' => 'Right Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cr.png'),
						'both-sidebars' => array('title' => 'Both Sidebars', 'img' => MFN_OPTIONS_URI.'img/2sb.png'),
					),
				),
					
				array(
					'id' 		=> 'single-portfolio-sidebar',
					'type' 		=> 'text',
					'title' 	=> __('Portfolio | Sidebar', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force sidebar for all projects', 'mfn-opts'),
					'desc' 		=> __('Paste the name of one of the sidebars that you added in the "Sidebars" section.', 'mfn-opts'),
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'single-portfolio-sidebar2',
					'type' 		=> 'text',
					'title' 	=> __('Portfolio | Sidebar 2', 'mfn-opts'),
					'sub_desc' 	=> __('Use this option to force sidebar for all projects', 'mfn-opts'),
					'desc' 		=> __('Paste the name of one of the sidebars that you added in the "Sidebars" section.', 'mfn-opts'),
					'class' 	=> 'small-text',
				),
						
			),
		);
		
		// Blog, Portfolio, Shop ==================================================================
		
		// General ---------------------------------------------
		$sections['bps-general'] = array(
			'title' 	=> __('General', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				array(
					'id' 		=> 'pagination-show-all',
					'type' 		=> 'switch',
					'title' 	=> __('All pages in pagination', 'mfn-opts'),
					'desc' 		=> __('Show all of the pages instead of a short list of the pages near the current page. Blog, Portfolio', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'love',
					'type' 		=> 'switch',
					'title' 	=> __('Love Box', 'mfn-opts'),
					'sub_desc' 	=> __('Show Love Box', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio', 'mfn-opts'),
					'options' 	=> array( '1' => 'On', '0' => 'Off' ),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'prev-next-nav',
					'type' 		=> 'select',
					'title' 	=> __('Navigation Arrows', 'mfn-opts'),
					'sub_desc' 	=> __('Show Prev/Next Navigation', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio, Shop', 'mfn-opts'),
					'options' 	=> array(
						'0'				=> 'Hide',
						'1'				=> 'Show',
						'same-category'	=> 'Show | Navigate in the same category (excluding Shop)',
					),
					'std' 		=> '1'
				),
				
				array(
					'id' 		=> 'share',
					'type' 		=> 'switch',
					'title' 	=> __('Share Box', 'mfn-opts'),
					'sub_desc' 	=> __('Show Share Box', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio, Shop', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'title-heading',
					'type' 		=> 'select',
					'title' 	=> __('Title Heading', 'mfn-opts'),
					'sub_desc' 	=> __('Single Title Heading', 'mfn-opts'),
					'desc' 		=> __('Single Post, Single Project', 'mfn-opts'),
					'options' 	=> array(
						'1' => 'H1',
						'2' => 'H2',
						'3' => 'H3',
						'4' => 'H4',
						'5' => 'H5',
						'6' => 'H6',
					),
					'std' 		=> '1'
				),	
						
			),
		);
		
		// Blog --------------------------------------------
		$sections['blog'] = array(
			'title' 	=> __('Blog', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(
	
				// layout -----	
					
				array(
					'id' 		=> 'blog-info-layout',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Layout', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'blog-posts',
					'type' 		=> 'text',
					'title' 	=> __('Posts per page', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> '4',
				),
					
				array(
					'id' 		=> 'blog-layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Layout', 'mfn-opts'),
					'sub_desc' 	=> __('Layout for Blog Page', 'mfn-opts'),
					'options'	=> array(
						'classic'		=> array('title' => 'Classic',	'img' => MFN_OPTIONS_URI.'img/list.png'),
						'masonry'		=> array('title' => 'Masonry Blog Style', 'img' => MFN_OPTIONS_URI.'img/masonry.png'),
						'masonry tiles'	=> array('title' => 'Masonry Tiles (Vertical Images)', 'img' => MFN_OPTIONS_URI.'img/masonry.png'),
						'photo'			=> array('title' => 'Photo (Horizontal Images)', 	'img' => MFN_OPTIONS_URI.'img/photo.png'),
						'timeline'		=> array('title' => 'Timeline',	'img' => MFN_OPTIONS_URI.'img/timeline.png'),
					),
					'std'		=> 'classic'
				),
					
				array(
					'id' 		=> 'blog-columns',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Columns', 'mfn-opts'),
					'desc' 		=> __('Default: 3. Recommended: 2-4. Too large value may crash the layout.<br />This option works in layout <b>Masonry</b>', 'mfn-opts'),
					'param'	 	=> array(
							'min' 		=> 2,
							'max' 		=> 6,
					),
					'std' 		=> 3,
				),
					
				array(
					'id' 		=> 'blog-full-width',
					'type' 		=> 'switch',
					'title' 	=> __('Full Width', 'mfn-opts'),
					'desc' 		=> __('This option works in layout <b>Masonry</b>', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),

				// options -----
					
				array(
					'id' 		=> 'blog-info-options',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Options', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'blog-page',
					'type' 		=> 'pages_select',
					'title' 	=> __('Blog Page', 'mfn-opts'),
					'sub_desc' 	=> __('Assign page for blog', 'mfn-opts'),
					'desc' 		=> __('Use this option if you set <strong>Front page displays: Your latest posts</strong> in Settings > Reading', 'mfn-opts'),
					'args' 		=> array()
				),

				array(
					'id' 		=> 'excerpt-length',
					'type' 		=> 'text',
					'title' 	=> __('Excerpt Length', 'mfn-opts'),
					'sub_desc' 	=> __('Number of words', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> '26',
				),
					
				array(
					'id' 		=> 'blog-load-more',
					'type' 		=> 'switch',
					'title' 	=> __('Load More button', 'mfn-opts'),
					'sub_desc' 	=> __('Show Ajax Load More button', 'mfn-opts'),
					'desc' 		=> __('This will replace all sliders on list with featured images', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),
					
				array(
					'id' 		=> 'blog-meta',
					'type' 		=> 'switch',
					'title' 	=> __('Post Meta', 'mfn-opts'),
					'sub_desc' 	=> __('Show Author, Date & Categories', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),

				// single -----
					
				array(
					'id' 		=> 'blog-info-single',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Single Post', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'blog-title',
					'type' 		=> 'switch',
					'title' 	=> __('Single Post | Title', 'mfn-opts'),
					'sub_desc' 	=> __('Show Post Title', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),

				array(
					'id' 		=> 'blog-single-zoom',
					'type' 		=> 'switch',
					'title' 	=> __('Single Post | Zoom Image', 'mfn-opts'),
					'sub_desc' 	=> __('Zoom Featured Image on click', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'blog-author',
					'type' 		=> 'switch',
					'title' 	=> __('Single Post | Author Box', 'mfn-opts'),
					'sub_desc' 	=> __('Show Author Box', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'blog-related',
					'type' 		=> 'switch',
					'title' 	=> __('Single Post | Related Posts', 'mfn-opts'),
					'sub_desc' 	=> __('Show Related Posts', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'blog-comments',
					'type' 		=> 'switch',
					'title' 	=> __('Single Post | Comments', 'mfn-opts'),
					'sub_desc' 	=> __('Show Comments', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
	
				array(
					'id' 		=> 'blog-single-layout',
					'type' 		=> 'text',
					'title' 	=> __('Single Post | Layout ID', 'mfn-opts'),
					'class'		=> 'small-text',
				),
					
				array(
					'id' 		=> 'blog-single-menu',
					'type' 		=> 'select',
					'title' 	=> __('Single Post | Menu', 'mfn-opts'),
					'options'	=> mfna_menu(),
				),
					
				// advanced -----	
					
				array(
					'id' 		=> 'blog-info-advanced',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Advanced', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),

				array(
					'id' 		=> 'blog-love-rand',
					'type' 		=> 'ajax',
					'title' 	=> __('Random Love', 'mfn-opts'),
					'sub_desc' 	=> __('Generate random number of loves', 'mfn-opts'),
					'action' 	=> 'mfn_love_randomize',
				),
						
			),
		);
		
		// Portfolio --------------------------------------------
		$sections['portfolio'] = array(
			'title' 	=> __('Portfolio', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(
	
				// layout -----
					
				array(
					'id' 		=> 'portfolio-info-layout',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Layout', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
				
				array(
					'id' 		=> 'portfolio-posts',
					'type' 		=> 'text',
					'title' 	=> __('Projects per page', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> '8',
				),

				array(
					'id' 		=> 'portfolio-layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Layout', 'mfn-opts'),
					'sub_desc' 	=> __('Layout for Portfolio Pages', 'mfn-opts'),
					'options' 	=> array(
						'flat'			=> array('title' => 'Flat', 'img' => MFN_OPTIONS_URI.'img/flat.png'),
						'grid'			=> array('title' => 'Grid', 'img' => MFN_OPTIONS_URI.'img/grid.png'),
						'masonry'		=> array('title' => 'Masonry Blog Style', 'img' => MFN_OPTIONS_URI.'img/masonry.png'),					
						'masonry-hover'	=> array('title' => 'Masonry Hover Details', 'img' => MFN_OPTIONS_URI.'img/masonry.png'),
						'list'			=> array('title' => 'List | 1 column', 'img' => MFN_OPTIONS_URI.'img/list.png'),	
						'masonry-flat'	=> array('title' => 'Masonry Flat | 4 columns', 'img' => MFN_OPTIONS_URI.'img/masonry-flat.png'),
					),
					'std' 		=> 'grid'
				),
					
				array(
					'id' 		=> 'portfolio-columns',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Columns', 'mfn-opts'),
					'desc' 		=> __('Default: 3. Recommended: 2-4. Too large value may crash the layout.<br />This option works in layouts <b>Flat, Grid, Masonry Blog Style, Masonry Hover Details</b>', 'mfn-opts'),
					'param'	 	=> array(
						'min' 		=> 2,
						'max' 		=> 6,
					),
					'std' 		=> 4,
				),

				array(
					'id' 		=> 'portfolio-full-width',
					'type' 		=> 'switch',
					'title' 	=> __('Full Width', 'mfn-opts'),
					'desc' 		=> __('This option works in layouts <b>Flat, Grid, Masonry</b>', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '0'
				),
					
				// options -----
					
				array(
					'id' 		=> 'portfolio-info-options',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Options', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'portfolio-page',
					'type' 		=> 'pages_select',
					'title' 	=> __('Portfolio Page', 'mfn-opts'),
					'sub_desc' 	=> __('Assign page for portfolio', 'mfn-opts'),
					'args' 		=> array()
				),

				array(
					'id' 		=> 'portfolio-orderby',
					'type' 		=> 'select',
					'title' 	=> __('Order by', 'mfn-opts'),
					'options' 	=> array(
						'date'			=> 'Date',
						'menu_order' 	=> 'Menu order',
						'title'			=> 'Title',
						'rand'			=> 'Random',
					),
					'std' 		=> 'date'
				),

				array(
					'id' 		=> 'portfolio-order',
					'type' 		=> 'select',
					'title' 	=> __('Order', 'mfn-opts'),
					'options' 	=> array(
						'ASC' 	=> 'Ascending',
						'DESC'	=> 'Descending'
					),
					'std' 		=> 'DESC'
				),
					
				array(
					'id' 		=> 'portfolio-external',
					'type' 		=> 'select',
					'title' 	=> __('Project Link', 'mfn-opts'),
					'sub_desc' 	=> __('Image and Title Link', 'mfn-opts'),
					'options' 	=> array(
						''			=> 'Details',
						'popup'		=> 'Popup Image',
						'disable'	=> 'Disable Details | Only Popup Image',
						'_self'		=> 'Project Website | Open in the same window',
						'_blank'	=> 'Project Website | Open in new window',
					),
				),

				array(
					'id' 		=> 'portfolio-hover-title',
					'type' 		=> 'switch',
					'title' 	=> __('Hover Title', 'mfn-opts'),
					'sub_desc' 	=> __('Show Project Title instead of Hover Icons', 'mfn-opts'),
					'desc' 		=> __('Only for short project titles', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),

				array(
					'id' 		=> 'portfolio-isotope',
					'type' 		=> 'switch',
					'title' 	=> __('jQuery filtering', 'mfn-opts'),
					'desc' 		=> __('When this option is enabled, portfolio looks great with all projects on single site, so please set "Posts per page" option to bigger number', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),

				array(
					'id' 		=> 'portfolio-load-more',
					'type' 		=> 'switch',
					'title' 	=> __('Load More button', 'mfn-opts'),
					'sub_desc' 	=> __('Show Ajax Load More button', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),
	
				// options -----
					
				array(
					'id' 		=> 'portfolio-info-single',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Single Project', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'portfolio-related',
					'type' 		=> 'switch',
					'title' 	=> __('Single Project | Related Projects', 'mfn-opts'),
					'sub_desc' 	=> __('Show Related Projects', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),

				array(
					'id' 		=> 'portfolio-comments',
					'type' 		=> 'switch',
					'title' 	=> __('Single Project | Comments', 'mfn-opts'),
					'sub_desc' 	=> __('Show Comments', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),
					
				array(
					'id' 		=> 'portfolio-single-layout',
					'type' 		=> 'text',
					'title' 	=> __('Single Project | Layout ID', 'mfn-opts'),
					'class'		=> 'small-text',
				),
					
				array(
					'id' 		=> 'portfolio-single-menu',
					'type' 		=> 'select',
					'title' 	=> __('Single Project | Menu', 'mfn-opts'),
					'options'	=> mfna_menu(),
				),
					
				// options -----
					
				array(
					'id' 		=> 'portfolio-info-advanced',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Advanced', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),

				array(
					'id' 		=> 'portfolio-love-rand',
					'type' 		=> 'ajax',
					'title' 	=> __('Random Love', 'mfn-opts'),
					'sub_desc' 	=> __('Generate random number of loves', 'mfn-opts'),
					'action' 	=> 'mfn_love_randomize',
					'param'	 	=> 'portfolio',
				),
					
				array(
					'id' 		=> 'portfolio-slug',
					'type' 		=> 'text',
					'title' 	=> __('Permalink | Single Project slug', 'mfn-opts'),
					'sub_desc' 	=> __('Do not use characters not allowed in links', 'mfn-opts'),
					'desc' 		=> __('Must be different from the Portfolio site title chosen above, eg. <b>portfolio-item</b>. After change go to <b>Settings > Permalinks</b> and click <b>Save changes</b>.', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> 'portfolio-item',
				),
					
				array(
					'id' 		=> 'portfolio-tax',
					'type' 		=> 'text',
					'title' 	=> __('Permalink | Category slug', 'mfn-opts'),
					'sub_desc' 	=> __('Do not use characters not allowed in links', 'mfn-opts'),
					'desc' 		=> __('Must be different from the Portfolio site title chosen above, eg. <b>portfolio-types</b>. After change go to <b>Settings > Permalinks</b> and click <b>Save changes</b>.', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> 'portfolio-types',
				),
						
			),
		);
		
		// Shop --------------------------------------------
		$sections['shop'] = array(
			'title' 	=> __('Shop', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(
	
				array(
					'id' 		=> 'shop-info',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Shop requires free WooCommerce plugin', 'mfn-opts'),
					'class' 	=> 'mfn-info desc',
				),
					
				// layout -----	
					
				array(
					'id' 		=> 'shop-info-layout',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Layout', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'shop-products',
					'type' 		=> 'text',
					'title' 	=> __('Products per page', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> '12',
				),

				array(
					'id' 		=> 'shop-layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Layout', 'mfn-opts'),
					'sub_desc' 	=> __('Layout for Shop Pages', 'mfn-opts'),
					'options' 	=> array(
						'grid'			=> array('title' => 'Grid 3 col', 'img' => MFN_OPTIONS_URI.'img/grid.png'),
						'grid col-4'	=> array('title' => 'Grid 4 col', 'img' => MFN_OPTIONS_URI.'img/grid-4.png'),
						'masonry'		=> array('title' => 'Masonry', 'img' => MFN_OPTIONS_URI.'img/masonry.png'),
						'list'			=> array('title' => 'List', 'img' => MFN_OPTIONS_URI.'img/list.png'),
					),
					'std' 		=> 'grid'
				),

				array(
					'id' 		=> 'shop-catalogue',
					'type' 		=> 'switch',
					'title' 	=> __('Catalogue Mode', 'mfn-opts'),
					'sub_desc' 	=> __('Remove all Add to Cart buttons', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '0'
				),
	
				// options -----
					
				array(
					'id' 		=> 'shop-info-options',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Options', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'shop-excerpt',
					'type' 		=> 'switch',
					'title' 	=> __('Descriptions', 'mfn-opts'),
					'sub_desc' 	=> __('Show descriptions on shop page', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),
					
				array(
					'id' 		=> 'shop-images',
					'type' 		=> 'select',
					'title' 	=> __('Images', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> '- Default -',
						'secondary'	=> 'Show secondary image on hover',
						'plugin'	=> 'Use external plugin for featured images',
					),
				),
					
				array(
					'id' 		=> 'shop-sidebar',
					'type' 		=> 'select',
					'title' 	=> __('Shop Sidebar', 'mfn-opts'),
					'sub_desc' 	=> __('Show Shop Page Sidebar on', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> 'All (Shop, Categories, Products)',
						'shop'		=> 'Shop & Categories',
					),
				),
					
				array(
					'id' 		=> 'shop-slider',
					'type' 		=> 'select',
					'title' 	=> __('Shop Slider', 'mfn-opts'),
					'sub_desc' 	=> __('Show Shop Page Slider on', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> 'Main Shop Page',
						'all'		=> 'All (Shop, Categories, Products)',
					),
				),
	
				// layout -----
					
				array(
					'id' 		=> 'shop-info-single',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Single Product', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'shop-product-images',
					'type' 		=> 'select',
					'title' 	=> __('Product | Image', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> '- Default -',
						'plugin'	=> 'Use external plugin for featured images',
					),
				),

				array(
					'id' 		=> 'shop-related',
					'type' 		=> 'switch',
					'title' 	=> __('Product | Related', 'mfn-opts'),
					'sub_desc' 	=> __('Show Related Products', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'shop-product-style',
					'type' 		=> 'select',
					'title' 	=> __('Product | Style', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> '- Default -',
						'wide'		=> 'Wide Description below image',
					),
				),
					
				// layout -----
					
				array(
					'id' 		=> 'shop-info-advanced',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Advanced', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),

				array(
					'id' 		=> 'shop-cart',
					'type' 		=> 'icon',
					'title' 	=> __('Cart | Icon', 'mfn-opts'),
					'sub_desc' 	=> __('Header Cart Icon', 'mfn-opts'),
					'desc' 		=> __('Leave this field blank to hide cart icon', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> 'icon-basket',
				),
						
			),
		);		
		
		// Pages ==================================================================================
		
		// General -------------------------------------------
		$sections['pages-general'] = array(
			'title' 	=> __('General', 'mfn-opts'),
			'icon'		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' 	=> array(
	
				array(
					'id' 		=> 'page-comments',
					'type' 		=> 'switch',
					'title' 	=> __('Page Comments', 'mfn-opts'),
					'sub_desc' 	=> __('Show Comments for pages', 'mfn-opts'),
					'desc' 		=> __('Single Page', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),

			),
		);
		
		// Error 404 -------------------------------------------
		$sections['pages-404'] = array(
			'title' 	=> __('Error 404', 'mfn-opts'),
			'icon'		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' 	=> array(
	
				array(
					'id' 		=> 'error404-icon',
					'type' 		=> 'icon',
					'title' 	=> __('Icon', 'mfn-opts'),
					'sub_desc' 	=> __('Error 404 Page Icon', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> 'icon-traffic-cone',
				),
					
				array(
					'id' 		=> 'error404-page',
					'type' 		=> 'pages_select',
					'title' 	=> __('Custom Page', 'mfn-opts'),
					'sub_desc' 	=> __('Page Options are disabled', 'mfn-opts'),
					'desc' 		=> __('Leave this field <b>blank</b> if you want to use <b>default</b> 404 page', 'mfn-opts'),
					'args' 		=> array()
				),

			),
		);
		
		// Under Construction --------------------------------------------
		$sections['pages-under'] = array(
			'title' 	=> __('Under Construction', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(
	
				array(
					'id' 		=> 'construction',
					'type' 		=> 'switch',
					'title' 	=> __('Under Construction', 'mfn-opts'),
					'desc' 		=> __('Under Construction page will be visible for all NOT logged in users.', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '0'
				),
					
				array(
					'id' 		=> 'construction-title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mfn-opts'),
					'std' 		=> 'Coming Soon',
				),
					
				array(
					'id' 		=> 'construction-text',
					'type' 		=> 'textarea',
					'title' 	=> __('Text', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'construction-date',
					'type' 		=> 'text',
					'title' 	=> __('Launch Date', 'mfn-opts'),
					'desc' 		=> __('Format: 12/30/2014 12:00:00 month/day/year hour:minute:second<br />Leave this field <b>blank to hide the counter</b>', 'mfn-opts'),
					'std' 		=> '12/30/2014 12:00:00',
					'class' 	=> 'small-text',
				),

				array(
					'id' 		=> 'construction-offset',
					'type' 		=> 'select',
					'title' 	=> __('UTC Timezone', 'mfn-opts'),
					'options' 	=> mfna_utc(),
					'std' 		=> '0',
				),

				array(
					'id' 		=> 'construction-contact',
					'type' 		=> 'text',
					'title' 	=> __('Contact Form Shortcode', 'mfn-opts'),
					'desc' 		=> __('eg. [contact-form-7 id="000" title="Maintenance"]', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'construction-page',
					'type' 		=> 'pages_select',
					'title' 	=> __('Custom Page', 'mfn-opts'),
					'sub_desc' 	=> __('Page Options are disabled', 'mfn-opts'),
					'desc' 		=> __('Leave this field <b>blank</b> if you want to use <b>default</b> Under Construction page<br /><br /><b>Notice: </b>Plugins like Visual Composer & Gravity Forms <b>do not work</b> on this page', 'mfn-opts'),
					'args' 		=> array(),
				),
						
			),
		);		
		
		// Footer =================================================================================
		
		// Footer --------------------------------------------
		$sections['footer'] = array(
			'title'		=> __('General', 'mfn-opts'),
			'fields' 	=> array(
	
				array(
					'id'		=> 'footer-layout',
					'type'		=> 'select',
					'title'		=> __('Layout', 'mfn-opts'),
					'options'	=> array(
						''												=> 'Default',
						'4;one-fourth;one-fourth;one-fourth;one-fourth'	=> '1/4 1/4 1/4 1/4',
						'3;one-fourth;one-fourth;one-second;'			=> '1/4 1/4 1/2',
						'3;one-fourth;one-second;one-fourth;'			=> '1/4 1/2 1/4',
						'3;one-second;one-fourth;one-fourth;'			=> '1/2 1/4 1/4',
						'3;one-third;one-third;one-third;'				=> '1/3 1/3 1/3',
						'2;one-third;two-third;;'						=> '1/3 2/3',
						'2;two-third;one-third;;'						=> '2/3 1/3',
						'2;one-second;one-second;;'						=> '1/2 1/2',
						'1;one;;;'										=> '1/1',
					),
				),
					
				array(
					'id'		=> 'footer-style',
					'type'		=> 'select',
					'title'		=> __('Style', 'mfn-opts'),
					'options'	=> array(
						''			=> 'Default',
						'fixed'		=> 'Fixed',
						'sliding'	=> 'Sliding',
					),
				),

				array(
					'id' 		=> 'footer-bg-img',
					'type' 		=> 'upload',
					'title' 	=> __('Background Image', 'mfn-opts'),
				),
					
				array(
					'id'		=> 'footer-call-to-action',
					'type'		=> 'text',
					'title'		=> __('Call To Action', 'mfn-opts'),
				),

				array(
					'id'		=> 'footer-copy',
					'type'		=> 'text',
					'title'		=> __('Copyright', 'mfn-opts'),
					'desc'		=> __('Leave this field blank to show a default copyright.', 'mfn-opts'),
				),

				array(
					'id' 		=> 'footer-hide',
					'type' 		=> 'select',
					'title' 	=> __('Copyright & Social Bar', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> 'Default',
						'center' 	=> 'Center',
						'1' 		=> 'Hide Copyright & Social Bar'
					),
				),
					
				array(
					'id'		=> 'back-top-top',
					'type'		=> 'select',
					'title'		=> __('Back to Top button', 'mfn-opts'),
					'options'	=> array(
						''				=> 'Default',
						'sticky'		=> 'Sticky',
						'sticky scroll'	=> 'Sticky show on scroll',
						'hide'			=> 'Hide',
					),
				),

				array(
					'id'		=> 'popup-contact-form',
					'type'		=> 'text',
					'title'		=> __('Popup Contact Form | Shortcode', 'mfn-opts'),
					'desc'		=> __('	eg. [contact-form-7 id="000" title="Popup Contact Form"]', 'mfn-opts'),
				),
					
				array(
					'id'		=> 'popup-contact-form-icon',
					'type'		=> 'icon',
					'title'		=> __('Popup Contact Form | Icon', 'mfn-opts'),
					'std'		=> 'icon-mail-line',
				),
						
			),
		);
		
		// Responsive =================================================================================
		
		// Responsive --------------------------------------------
		$sections['responsive'] = array(
			'title'		=> __('General', 'mfn-opts'),
			'fields' 	=> array(
	
				array(
					'id' 		=> 'responsive',
					'type' 		=> 'switch',
					'title' 	=> __('Responsive', 'mfn-opts'),
					'desc' 		=> __('<b>Notice:</b> Responsive menu is working only with WordPress custom menu, please add one in Appearance > Menus and select it for Theme Locations section. <a href="http://en.support.wordpress.com/menus/" target="_blank">http://en.support.wordpress.com/menus/</a>', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'responsive-options',
					'type' 		=> 'checkbox',
					'title' 	=> __('Options', 'mfn-opts'),
					'options' 	=> array(
						'mobile-wide'	=> 'Wide Wrapper on Mobile <span>some items may look different</span>',
					),
				),
					
				array(
					'id'		=> 'responsive-logo-img',
					'type'		=> 'upload',
					'title'		=> __('Logo', 'mfn-opts'),
					'sub_desc'	=> __('optional', 'mfn-opts'),
					'desc'		=> __('Use if you want different logo for Mobile ( < 768px )', 'mfn-opts'),
				),
				
				array(
					'id'		=> 'responsive-retina-logo-img',
					'type'		=> 'upload',
					'title'		=> __('Retina Logo', 'mfn-opts'),
					'sub_desc'	=> __('optional', 'mfn-opts'),
					'desc'		=> __('Retina Logo should be 2x larger than Logo', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'font-size-responsive',
					'type' 		=> 'switch',
					'title' 	=> __('Decrease Fonts', 'mfn-opts'),
					'desc' 		=> __('Automatically decrease font size in responsive', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),
					
				array(
					'id' 		=> 'no-hover',
					'type' 		=> 'select',
					'title' 	=> __('Hover Effects', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> 'Always Enabled',
						'tablet'	=> 'Enabled on Desktop only'
					),
				),
					
				array(
					'id'		=> 'header-menu-mobile-sticky',
					'type'		=> 'switch',
					'title'		=> __('Menu Button | Sticky', 'mfn-opts'),
					'desc'		=> __('Sticky Menu Button on mobile', 'mfn-opts'),
					'options'	=> array( '0' => 'Off', '1' => 'On' ),
					'std'		=> '0',
				),
				
				array(
					'id'		=> 'header-menu-text',
					'type'		=> 'text',
					'title'		=> __('Menu Button | Text', 'mfn-opts'),
					'desc'		=> __('This text will be used instead of the menu icon', 'mfn-opts'),
					'class'		=> 'small-text',
				),
				
				array(
					'id' 		=> 'no-section-bg',
					'type' 		=> 'select',
					'title' 	=> __('Section Background Image', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> 'Always Show',
						'tablet'	=> 'Show on Desktop only'
					),
				),
				
				array(
					'id' 		=> 'responsive-top-bar',
					'type' 		=> 'select',
					'title' 	=> __('Top Bar Icons', 'mfn-opts'),
					'options' 	=> array(
						'left' 		=> 'Left',
						'center'	=> 'Center',
						'right'		=> 'Right',
						'hide'		=> 'Hide Icons & Action Button',
					),
				),
		
			),
		);
		
		// SEO ====================================================================================
		
		// SEO -------------------------------------------
		$sections['seo'] = array(
			'title' 	=> __('General', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(
					
				array(
					'id' 		=> 'google-analytics',
					'type' 		=> 'textarea',
					'title' 	=> __('Google | Analytics', 'mfn-opts'),
					'sub_desc' 	=> __('Paste your Google Analytics code here', 'mfn-opts'),
				),
				
				array(
					'id' 		=> 'google-remarketing',
					'type' 		=> 'textarea',
					'title' 	=> __('Google | Remarketing', 'mfn-opts'),
					'sub_desc' 	=> __('Paste your Google Remarketing code here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'mfn-seo',
					'type' 		=> 'switch',
					'title' 	=> __('Use built-in fields', 'mfn-opts'), 
					'desc' 		=> __('Turn it OFF if you want to use external SEO plugin', 'mfn-opts'), 
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
				
				array(
					'id' 		=> 'meta-description',
					'type' 		=> 'text',
					'title' 	=> __('Meta Description', 'mfn-opts'),
					'desc' 		=> __('These setting may be overridden for single posts & pages', 'mfn-opts'),
					'std' 		=> get_bloginfo( 'description' ),
				),
				
				array(
					'id' 		=> 'meta-keywords',
					'type' 		=> 'text',
					'title' 	=> __('Meta Keywords', 'mfn-opts'),
					'desc' 		=> __('These setting may be overridden for single posts & pages', 'mfn-opts'),
				),

			),
		);
		
		// Social Icons ===========================================================================
		
		// Social Icons --------------------------------------------
		$sections['social'] = array(
			'title' => __('General', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
						
				array(
					'id'		=> 'social-target',
					'type'		=> 'switch',
					'title'		=> __('Open links in new window', 'mfn-opts'),
					'desc'		=> __('Open social links in new window', 'mfn-opts'),
					'options'	=> array( '1' => 'On', '0' => 'Off' ),
					'std'		=> '0'
				),

				array(
					'id' 		=> 'social-skype',
					'type' 		=> 'text',
					'title' 	=> __('Skype', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Skype login here', 'mfn-opts'),
					'desc' 		=> __('You can use <strong>callto:</strong> or <strong>skype:</strong> prefix' , 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'social-facebook',
					'type' 		=> 'text',
					'title' 	=> __('Facebook', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Facebook link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-googleplus',
					'type' 		=> 'text',
					'title' 	=> __('Google +', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Google + link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-twitter',
					'type' 		=> 'text',
					'title' 	=> __('Twitter', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Twitter link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-vimeo',
					'type' 		=> 'text',
					'title' 	=> __('Vimeo', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Vimeo link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-youtube',
					'type' 		=> 'text',
					'title' 	=> __('YouTube', 'mfn-opts'),
					'sub_desc' 	=> __('Type your YouTube link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-flickr',
					'type' 		=> 'text',
					'title' 	=> __('Flickr', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Flickr link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-linkedin',
					'type' 		=> 'text',
					'title' 	=> __('LinkedIn', 'mfn-opts'),
					'sub_desc' 	=> __('Type your LinkedIn link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-pinterest',
					'type'		=> 'text',
					'title' 	=> __('Pinterest', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Pinterest link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-dribbble',
					'type' 		=> 'text',
					'title' 	=> __('Dribbble', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Dribbble link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-instagram',
					'type' 		=> 'text',
					'title' 	=> __('Instagram', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Instagram link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-behance',
					'type' 		=> 'text',
					'title' 	=> __('Behance', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Behance link here', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'social-tumblr',
					'type' 		=> 'text',
					'title' 	=> __('Tumblr', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Tumblr link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-vkontakte',
					'type' 		=> 'text',
					'title' 	=> __('VKontakte', 'mfn-opts'),
					'sub_desc' 	=> __('Type your VKontakte link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-viadeo',
					'type' 		=> 'text',
					'title' 	=> __('Viadeo', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Viadeo link here', 'mfn-opts'),
				),

				array(
					'id' 		=> 'social-xing',
					'type' 		=> 'text',
					'title' 	=> __('Xing', 'mfn-opts'),
					'sub_desc' 	=> __('Type your Xing link here', 'mfn-opts'),
				),

				array(
					'id'		=> 'social-rss',
					'type'		=> 'switch',
					'title'		=> __('RSS', 'mfn-opts'),
					'desc'		=> __('Show the RSS icon', 'mfn-opts'),
					'options'	=> array('1' => 'On','0' => 'Off'),
					'std'		=> '0'
				),
						
			),
		);
		
		// Addons, Plugins ========================================================================

		// Addons -------------------------------------------
		$sections['addons'] = array(
			'title'		=> __('Addons', 'mfn-opts'),
			'icon' 		=> MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(
					
				array(
					'id' 		=> 'nice-scroll',
					'type' 		=> 'switch',
					'title' 	=> __('Nice Scroll', 'mfn-opts'),
					'desc' 		=> __('Scrollbar with a very similar ios/mobile style', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
					
				array(
					'id' 		=> 'nice-scroll-speed',
					'type' 		=> 'text',
					'title' 	=> __('Nice Scroll | Speed', 'mfn-opts'),
					'sub_desc' 	=> __('default: 40', 'mfn-opts'),
					'desc' 		=> __('px', 'mfn-opts'),
					'class' 	=> 'small-text',
					'std' 		=> '40',
				),
					
				array(
					'id' 		=> 'sc-gallery-disable',
					'type' 		=> 'switch',
					'title' 	=> __('Gallery Shortcode | Disable', 'mfn-opts'),
					'sub_desc' 	=> __('Disable Theme Gallery Shortcode', 'mfn-opts'),
					'desc' 		=> __('Turn it ON if you want to use external gallery plugin or Jetpack', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),
					
				array(
					'id' 		=> 'prettyphoto-options',
					'type' 		=> 'checkbox',
					'title' 	=> __('Pretty Photo | Options', 'mfn-opts'),
					'options' 	=> array(
						'disable'			=> 'Disable',
						'disable-mobile'	=> 'Disable on Mobile only',
						'title'				=> 'Show image alt text above prettyPhoto frame',
					),
				),

				array(
					'id' 		=> 'prettyphoto',
					'type' 		=> 'select',
					'title' 	=> __('Pretty Photo | Style', 'mfn-opts'), 
					'desc' 		=> __('Disable prettyPhoto if you use other plugin', 'mfn-opts'), 
					'options' 	=> array(
						'pp_default' 	=> 'Default',
						'light_rounded' => 'Light Rounded',
						'dark_rounded'	=> 'Dark Rounded',
						'light_square' 	=> 'Light Square',
						'dark_square'	=> 'Dark Square',
						'facebook'		=> 'Facebook',
					),
				),
				
				array(
					'id' 		=> 'prettyphoto-width',
					'type' 		=> 'text',
					'title' 	=> __('Pretty Photo | Width', 'mfn-opts'),
					'sub_desc' 	=> __('prettyPhoto popup width for iframe video', 'mfn-opts'),
					'desc' 		=> __('px. Leave blank to use auto width', 'mfn-opts'),
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'prettyphoto-height',
					'type' 		=> 'text',
					'title' 	=> __('Pretty Photo | Height', 'mfn-opts'),
					'sub_desc' 	=> __('prettyPhoto popup height for iframe video', 'mfn-opts'),
					'desc' 		=> __('px. Leave blank to use auto height', 'mfn-opts'),
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'retina-js-disable',
					'type' 		=> 'switch',
					'title' 	=> __('Retina.js | Disable', 'mfn-opts'),
					'sub_desc' 	=> __('Disable Retina.js', 'mfn-opts'),
					'options' 	=> array( '0' => 'Off', '1' => 'On' ),
					'std' 		=> '0'
				),

			),
		);
		
		// Plugins --------------------------------------------
		$sections['plugins'] = array(
			'title' => __('Premium Plugins', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
	
				array(
					'id' 		=> 'plugins-info',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Below plugins came bundled with a theme.<br />The use of these plugins is limited to this theme only.<br /><br />Hovewer if you have <b>purchased an extra single license</b> on CodeCanyon for any of these plugins you can <b>disable "bundled"</b> option for plugin you have purchased.<br />After that you can enter your plugin purchase code on <b>plugin options page</b> to get <b>Premium Support from Plugin Author</b> and <b>Auto Updates</b>.', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'plugin-rev',
					'type' 		=> 'select',
					'title' 	=> __('Revolution Slider', 'mfn-opts'),
					'options' 	=> array(
						''			=> 'Bundled with a Theme',
						'disable'	=> 'I have purchased an extra licence on CodeCanyon',
					),
				),
					
				array(
					'id' 		=> 'plugin-layer',
					'type' 		=> 'select',
					'title' 	=> __('Layer Slider', 'mfn-opts'),
					'options' 	=> array(
						''			=> 'Bundled with a Theme',
						'disable'	=> 'I have purchased an extra licence on CodeCanyon',
					),
				),
					
				array(
					'id' 		=> 'plugin-visual',
					'type' 		=> 'select',
					'title' 	=> __('Visual Composer', 'mfn-opts'),
					'options' 	=> array(
						''			=> 'Bundled with a Theme',
						'disable'	=> 'I have purchased an extra licence on CodeCanyon',
					),
				),
						
			),
		);

		// Colors =================================================================================
		
		// General --------------------------------------------
		$sections['colors-general'] = array(
			'title' => __('General', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
								
				array(
					'id' 		=> 'skin',
					'type' 		=> 'select',
					'title' 	=> __('Theme Skin', 'mfn-opts'), 
					'sub_desc' 	=> __('Choose one of the predefined styles or set your own colors', 'mfn-opts'), 
					'desc' 		=> __('<strong>Important:</strong> Color options can be used only with the <strong>Custom Skin</strong>', 'mfn-opts'), 
					'options' 	=> mfna_skin(),
					'std' 		=> 'custom',
				),
				
				array(
					'id' 		=> 'background-body',
					'type' 		=> 'color',
					'title' 	=> __('Body background', 'mfn-opts'), 
					'std' 		=> '#FCFCFC',
				),
				
				array(
					'id' 		=> 'color-one',
					'type' 		=> 'color',
					'title' 	=> __('One Color', 'mfn-opts'), 
					'sub_desc' 	=> __('One Color Skin Generator', 'mfn-opts'), 
					'desc' 		=> __('<strong>Important:</strong> This option can be used only with the <strong>One Color Skin</strong>', 'mfn-opts'), 
					'std' 		=> '#2991D6',
				),
				
			),
		);
		
		// Header --------------------------------------------
		$sections['colors-header'] = array(
			'title' => __('Header', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
						
				array(
					'id' 		=> 'background-header',
					'type' 		=> 'color',
					'title' 	=> __('Header background', 'mfn-opts'),
					'std' 		=> '#000119',
				),
					
				array(
					'id' 		=> 'background-top-left',
					'type' 		=> 'color',
					'title' 	=> __('Top Bar Left background', 'mfn-opts'),
					'desc' 		=> __('This is also Mobile Header & Top Bar Background for some Header Styles', 'mfn-opts'),
					'std' 		=> '#ffffff',
				),
					
				array(
					'id' 		=> 'background-top-middle',
					'type' 		=> 'color',
					'title' 	=> __('Top Bar Middle background', 'mfn-opts'),
					'std' 		=> '#e3e3e3',
				),
					
				array(
					'id' 		=> 'background-top-right',
					'type' 		=> 'color',
					'title' 	=> __('Top Bar Right | background', 'mfn-opts'),
					'std' 		=> '#f5f5f5',
				),
				
				array(
					'id' 		=> 'color-top-right-a',
					'type' 		=> 'color',
					'title' 	=> __('Top Bar Right | Icon color', 'mfn-opts'),
					'std' 		=> '#444444',
				),
					
				array(
					'id' 		=> 'background-search',
					'type' 		=> 'color',
					'title' 	=> __('Search Bar background', 'mfn-opts'),
					'std' 		=> '#2991D6',
				),
				
				array(
					'id' 		=> 'background-subheader',
					'type' 		=> 'color',
					'title' 	=> __('Subheader background', 'mfn-opts'),
					'std' 		=> '#F7F7F7',
				),
					
				array(
					'id' 		=> 'color-subheader',
					'type' 		=> 'color',
					'title' 	=> __('Subheader Title color', 'mfn-opts'),
					'std' 		=> '#888888',
				),
				
			),
		);
		
		// Menu --------------------------------------------
		$sections['colors-menu'] = array(
			'title' => __('Menu & Action Bar', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
		
				array(
					'id' 		=> 'color-menu-a',
					'type' 		=> 'color',
					'title' 	=> __('Menu | Link color', 'mfn-opts'),
					'std' 		=> '#444444',
				),
					
				array(
					'id' 		=> 'color-menu-a-active',
					'type' 		=> 'color',
					'title' 	=> __('Menu | Active Link color', 'mfn-opts'),
					'desc' 		=> __('This is also Active Link Border', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'background-menu-a-active',
					'type' 		=> 'color',
					'title' 	=> __('Menu | Active Link background', 'mfn-opts'),
					'desc' 		=> __('For: Highlight & Plain Menu style', 'mfn-opts'),
					'std' 		=> '#F2F2F2',
				),
					
				array(
					'id' 		=> 'background-submenu',
					'type' 		=> 'color',
					'title' 	=> __('Submenu | background', 'mfn-opts'),
					'std' 		=> '#F2F2F2',
				),
					
				array(
					'id' 		=> 'color-submenu-a',
					'type' 		=> 'color',
					'title' 	=> __('Submenu | Link color', 'mfn-opts'),
					'std' 		=> '#5f5f5f',
				),
					
				array(
					'id' 		=> 'color-submenu-a-hover',
					'type' 		=> 'color',
					'title' 	=> __('Submenu | Hover Link color', 'mfn-opts'),
					'std' 		=> '#2e2e2e',
				),			
	
				array(
					'id' 		=> 'background-action-bar',
					'type' 		=> 'color',
					'title' 	=> __('Action Bar | background', 'mfn-opts'),
					'desc' 		=> __('For some Header Styles', 'mfn-opts'),
					'std' 		=> '#2C2C2C',
				),
	
				array(
					'id' 		=> 'background-overlay-menu',
					'type' 		=> 'color',
					'title' 	=> __('Overlay Menu | background', 'mfn-opts'),
					'desc' 		=> __('Header Overlay Menu only', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
	
				array(
					'id' 		=> 'background-overlay-menu-a',
					'type' 		=> 'color',
					'title' 	=> __('Overlay Menu | Link color', 'mfn-opts'),
					'desc' 		=> __('Header Overlay Menu only', 'mfn-opts'),
					'std' 		=> '#ffffff',
				),
	
				array(
					'id' 		=> 'border-menu-plain',
					'type' 		=> 'color',
					'title' 	=> __('Plain Menu | Border color', 'mfn-opts'),
					'desc' 		=> __('Header Plain only', 'mfn-opts'),
					'std' 		=> '#F2F2F2',
				),
				
			),
		);
		
		// Content --------------------------------------------
		$sections['content'] = array(
			'title' => __('Content', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
		
				array(
					'id' 		=> 'color-theme',
					'type' 		=> 'color',
					'title' 	=> __('Theme color', 'mfn-opts'), 
					'sub_desc' 	=> __('Color for highlighted buttons, icons and other small elements', 'mfn-opts'),
					'desc' 		=> __('You can use <strong>.themecolor</strong> and <strong>.themebg</strong> classes in your content', 'mfn-opts'),
					'std' 		=> '#2991d6'
				),
					
				array(
					'id' 		=> 'color-text',
					'type' 		=> 'color',
					'title' 	=> __('Text color', 'mfn-opts'), 
					'sub_desc' 	=> __('Content text color', 'mfn-opts'),
					'std' 		=> '#626262'
				),
					
				array(
					'id' 		=> 'color-a',
					'type' 		=> 'color',
					'title' 	=> __('Link color', 'mfn-opts'), 
					'std' 		=> '#2991d6'
				),
					
				array(
					'id' 		=> 'color-a-hover',
					'type' 		=> 'color',
					'title' 	=> __('Link Hover color', 'mfn-opts'), 
					'std' 		=> '#2275ac'
				),
				
				array(
					'id' 		=> 'color-fancy-link',
					'type' 		=> 'color',
					'title' 	=> __('Fancy Link | color', 'mfn-opts'),
					'desc' 		=> __('For some link styles only', 'mfn-opts'),
					'std' 		=> '#656B6F'
				),
				
				array(
					'id' 		=> 'background-fancy-link',
					'type' 		=> 'color',
					'title' 	=> __('Fancy Link | background', 'mfn-opts'),
					'desc' 		=> __('For some link styles only', 'mfn-opts'),
					'std' 		=> '#2195de'
				),
				
				array(
					'id' 		=> 'color-fancy-link-hover',
					'type' 		=> 'color',
					'title' 	=> __('Fancy Link | Hover color', 'mfn-opts'),
					'desc' 		=> __('For some link styles only', 'mfn-opts'),
					'std' 		=> '#2991d6'
				),
				
				array(
					'id' 		=> 'background-fancy-link-hover',
					'type' 		=> 'color',
					'title' 	=> __('Fancy Link | Hover background', 'mfn-opts'),
					'desc' 		=> __('For some link styles only', 'mfn-opts'),
					'std' 		=> '#2275ac'
				),
	
				array(
					'id' 		=> 'color-note',
					'type' 		=> 'color',
					'title' 	=> __('Note color', 'mfn-opts'), 
					'desc' 		=> __('eg. Blog meta, Filters, Widgets meta', 'mfn-opts'), 
					'std' 		=> '#a8a8a8'
				),
				
				array(
					'id' 		=> 'color-list',
					'type' 		=> 'color',
					'title' 	=> __('List color', 'mfn-opts'), 
					'desc' 		=> __('Ordered, Unordered & Bullets List', 'mfn-opts'), 
					'std' 		=> '#737E86'
				),
				
				array(
					'id' 		=> 'background-highlight',
					'type' 		=> 'color',
					'title' 	=> __('Dropcap & Highlight background', 'mfn-opts'), 
					'std' 		=> '#2991d6'
				),
				
				array(
					'id' 		=> 'background-highlight-section',
					'type' 		=> 'color',
					'title' 	=> __('Highlight Section background', 'mfn-opts'), 
					'std' 		=> '#2991d6'
				),
				
				array(
					'id' 		=> 'color-hr',
					'type' 		=> 'color',
					'title' 	=> __('Hr color', 'mfn-opts'), 
					'desc' 		=> __('Dots, ZigZag & Theme Color', 'mfn-opts'), 
					'std' 		=> '#2991d6'
				),
				
				array(
					'id' 		=> 'button-style',
					'type' 		=> 'select',
					'title' 	=> __('Button | style', 'mfn-opts'), 
					'options' 	=> array(
						''			=> 'Default',
						'stroke'	=> 'Stroke',
					)
				),
				
				array(
					'id' 		=> 'background-button',
					'type' 		=> 'color',
					'title' 	=> __('Button | background', 'mfn-opts'), 
					'std' 		=> '#f7f7f7'
				),
				
				array(
					'id' 		=> 'color-button',
					'type' 		=> 'color',
					'title' 	=> __('Button | color', 'mfn-opts'), 
					'std' 		=> '#747474'
				),
				
			),
		);
		
		// Footer --------------------------------------------
		$sections['colors-footer'] = array(
			'title' => __('Footer', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
					
				array(
					'id' 		=> 'color-footer-theme',
					'type' 		=> 'color',
					'title' 	=> __('Footer Theme color', 'mfn-opts'),
					'sub_desc' 	=> __('Color for icons and other small elements', 'mfn-opts'),
					'desc' 		=> __('You can use <strong>.themecolor</strong> and <strong>.themebg</strong> classes in your footer content', 'mfn-opts'),
					'std' 		=> '#2991d6'
				),
					
				array(
					'id' 		=> 'background-footer',
					'type' 		=> 'color',
					'title' 	=> __('Footer background', 'mfn-opts'),
					'std' 		=> '#545454',
				),
					
				array(
					'id' 		=> 'color-footer',
					'type' 		=> 'color',
					'title' 	=> __('Footer Text color', 'mfn-opts'),
					'std' 		=> '#cccccc',
				),
					
				array(
					'id' 		=> 'color-footer-a',
					'type' 		=> 'color',
					'title' 	=> __('Footer Link color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'color-footer-a-hover',
					'type' 		=> 'color',
					'title' 	=> __('Footer Hover Link color', 'mfn-opts'),
					'std' 		=> '#2275ac',
				),
					
				array(
					'id' 		=> 'color-footer-heading',
					'type' 		=> 'color',
					'title' 	=> __('Footer Heading color', 'mfn-opts'),
					'std' 		=> '#ffffff',
				),
				
				array(
					'id' 		=> 'color-footer-note',
					'type' 		=> 'color',
					'title' 	=> __('Footer Note color', 'mfn-opts'),
					'desc' 		=> __('eg. Widget meta', 'mfn-opts'),
					'std' 		=> '#a8a8a8',
				),
					
			),
		);
		
		// Sliding Top --------------------------------------------
		$sections['colors-sliding-top'] = array(
			'title' => __('Sliding Top', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
					
				array(
					'id' 		=> 'color-sliding-top-theme',
					'type' 		=> 'color',
					'title' 	=> __('Sliding Top Theme color', 'mfn-opts'),
					'sub_desc' 	=> __('Color for icons and other small elements', 'mfn-opts'),
					'desc' 		=> __('You can use <strong>.themecolor</strong> and <strong>.themebg</strong> classes in your Sliding Top content', 'mfn-opts'),
					'std' 		=> '#2991d6'
				),
					
				array(
					'id' 		=> 'background-sliding-top',
					'type' 		=> 'color',
					'title' 	=> __('Sliding Top background', 'mfn-opts'),
					'std' 		=> '#545454',
				),
					
				array(
					'id' 		=> 'color-sliding-top',
					'type' 		=> 'color',
					'title' 	=> __('Sliding Top Text color', 'mfn-opts'),
					'std' 		=> '#cccccc',
				),
					
				array(
					'id' 		=> 'color-sliding-top-a',
					'type' 		=> 'color',
					'title' 	=> __('Sliding Top Link color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'color-sliding-top-a-hover',
					'type' 		=> 'color',
					'title' 	=> __('Sliding Top Hover Link color', 'mfn-opts'),
					'std' 		=> '#2275ac',
				),
					
				array(
					'id' 		=> 'color-sliding-top-heading',
					'type' 		=> 'color',
					'title' 	=> __('Sliding Top Heading color', 'mfn-opts'),
					'std' 		=> '#ffffff',
				),
				
				array(
					'id' 		=> 'color-sliding-top-note',
					'type' 		=> 'color',
					'title' 	=> __('Sliding Top Note color', 'mfn-opts'),
					'desc' 		=> __('eg. Widget meta', 'mfn-opts'),
					'std' 		=> '#a8a8a8',
				),
					
			),
		);
		
		// Headings --------------------------------------------
		$sections['headings'] = array(
			'title' => __('Headings', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
		
				array(
					'id' 		=> 'color-h1',
					'type' 		=> 'color',
					'title' 	=> __('Heading H1 color', 'mfn-opts'), 
					'std' 		=> '#444444'
				),
		
				array(
					'id' 		=> 'color-h2',
					'type' 		=> 'color',
					'title' 	=> __('Heading H2 color', 'mfn-opts'), 
					'std' 		=> '#444444'
				),
		
				array(
					'id' 		=> 'color-h3',
					'type' 		=> 'color',
					'title' 	=> __('Heading H3 color', 'mfn-opts'), 
					'std' 		=> '#444444'
				),
		
				array(
					'id' 		=> 'color-h4',
					'type' 		=> 'color',
					'title' 	=> __('Heading H4 color', 'mfn-opts'), 
					'std' 		=> '#444444'
				),
		
				array(
					'id' 		=> 'color-h5',
					'type' 		=> 'color',
					'title' 	=> __('Heading H5 color', 'mfn-opts'), 
					'std' 		=> '#444444'
				),
		
				array(
					'id' 		=> 'color-h6',
					'type' 		=> 'color',
					'title' 	=> __('Heading H6 color', 'mfn-opts'), 
					'std' 		=> '#444444'
				),
					
			),
		);
		
		// Shortcodes --------------------------------------------
		$sections['colors-shortcodes'] = array(
			'title' => __('Shortcodes', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(
					
				array(
					'id' 		=> 'color-tab-title',
					'type' 		=> 'color',
					'title'		=> __('Accordion & Tabs Active Title color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'color-blockquote',
					'type' 		=> 'color',
					'title'		=> __('Blockquote color', 'mfn-opts'),
					'std' 		=> '#444444',
				),
					
				array(
					'id' 		=> 'color-contentlink',
					'type' 		=> 'color',
					'title'		=> __('Content Link Icon color', 'mfn-opts'),
					'desc'		=> __('This is also Content Link Hover Border', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'color-counter',
					'type' 		=> 'color',
					'title'		=> __('Counter Icon color', 'mfn-opts'),
					'desc'		=> __('This is also Chart Progress color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'background-getintouch',
					'type' 		=> 'color',
					'title'		=> __('Get in Touch background', 'mfn-opts'),
					'desc'		=> __('This is also Infobox background', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'color-iconbar',
					'type' 		=> 'color',
					'title'		=> __('Icon Bar Hover Icon color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'color-iconbox',
					'type' 		=> 'color',
					'title'		=> __('Icon Box Icon color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'background-imageframe-link',
					'type' 		=> 'color',
					'title'		=> __('Image Frame Link background', 'mfn-opts'),
					'desc'		=> __('This is also Image Frame Hover Link color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
				array(
					'id' 		=> 'color-imageframe-link',
					'type' 		=> 'color',
					'title'		=> __('Image Frame Link color', 'mfn-opts'),
					'desc'		=> __('This is also Image Frame Hover Link background', 'mfn-opts'),
					'std' 		=> '#ffffff',
				),
					
				array(
					'id' 		=> 'color-list-icon',
					'type' 		=> 'color',
					'title'		=> __('List & Feature List Icon color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
				
				array(
					'id' 		=> 'color-pricing-price',
					'type' 		=> 'color',
					'title'		=> __('Pricing Box Price color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
				
				array(
					'id' 		=> 'background-pricing-featured',
					'type' 		=> 'color',
					'title'		=> __('Pricing Box Featured background', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
				
				array(
					'id' 		=> 'background-progressbar',
					'type' 		=> 'color',
					'title'		=> __('Progress Bar background', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
				
				array(
					'id' 		=> 'color-quickfact-number',
					'type' 		=> 'color',
					'title'		=> __('Quick Fact Number color', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
				
				array(
					'id' 		=> 'background-slidingbox-title',
					'type' 		=> 'color',
					'title'		=> __('Sliding Box Title background', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
				
				array(
					'id' 		=> 'background-trailer-subtitle',
					'type' 		=> 'color',
					'title'		=> __('Trailer Box Subtitle background', 'mfn-opts'),
					'std' 		=> '#2991d6',
				),
					
			),
		);
	
		// Font Family --------------------------------------------
		$sections['font-family'] = array(
			'title' => __('Family', 'mfn-opts'),
			'fields' => array(
				
				array(
					'id' 		=> 'font-content',
					'type' 		=> 'font_select',
					'title' 	=> __('Content Font', 'mfn-opts'), 
					'sub_desc'	=> __('All theme texts except headings and menu', 'mfn-opts'), 
					'std' 		=> 'Roboto'
				),
				
				array(
					'id' 		=> 'font-menu',
					'type' 		=> 'font_select',
					'title' 	=> __('Main Menu Font', 'mfn-opts'), 
					'sub_desc' 	=> __('Header menu', 'mfn-opts'), 
					'std' 		=> 'Roboto'
				),
				
				array(
					'id' 		=> 'font-title',
					'type' 		=> 'font_select',
					'title' 	=> __('Page Title Font', 'mfn-opts'),
					'std' 		=> 'Patua One'
				),
				
				array(
					'id' 		=> 'font-headings',
					'type' 		=> 'font_select',
					'title' 	=> __('Big Headings Font', 'mfn-opts'), 
					'sub_desc' 	=> __('H1, H2, H3 & H4 headings', 'mfn-opts'), 
					'std' 		=> 'Patua One'
				),
					
				array(
					'id' 		=> 'font-headings-small',
					'type' 		=> 'font_select',
					'title' 	=> __('Small Headings Font', 'mfn-opts'), 
					'sub_desc' 	=> __('H5 & H6 headings', 'mfn-opts'), 
					'std' 		=> 'Roboto'
				),
					
				array(
					'id' 		=> 'font-blockquote',
					'type' 		=> 'font_select',
					'title' 	=> __('Blockquote Font', 'mfn-opts'), 
					'std' 		=> 'Patua One'
				),
					
				array(
					'id' 		=> 'font-weight',
					'type' 		=> 'checkbox',
					'title' 	=> __('Google Font Style & Weight', 'mfn-opts'),
					'sub_desc' 	=> __('Impact on page <b>load time</b>', 'mfn-opts'),
					'desc' 		=> __('Some of the fonts in the Google Font Directory support multiple styles. For a complete list of available font subsets please see <a href="http://www.google.com/webfonts" target="_blank">Google Web Fonts</a>.', 'mfn-opts'),
					'options' 	=> array(
						'100'		=> '100 Thin',
						'100italic'	=> '100 Thin Italic',
						'200'		=> '200 Extra-Light',
						'200italic'	=> '200 Extra-Light Italic',
						'300'		=> '300 Light',
						'300italic'	=> '300 Light Italic',
						'400'		=> '400 Regular',
						'400italic'	=> '400 Regular Italic',
						'500'		=> '500 Medium',
						'500italic'	=> '500 Medium Italic',
						'600'		=> '600 Semi-Bold',
						'600italic'	=> '600 Semi-Bold Italic',
						'700'		=> '700 Bold',
						'700italic'	=> '700 Bold Italic',
						'800'		=> '800 Extra-Bold',
						'800italic'	=> '800 Extra-Bold Italic',
						'900'		=> '900 Black',
						'900italic'	=> '900 Black Italic',
					),
					'class'		=> 'float-left',
				),	

				array(
					'id' 		=> 'font-subset',
					'type' 		=> 'text',
					'title' 	=> __('Google Font Subset', 'mfn-opts'),				
					'sub_desc' 	=> __('Specify which subsets should be downloaded. Multiple subsets should be separated with coma (,)', 'mfn-opts'),
					'desc' 		=> __('Some of the fonts in the Google Font Directory support multiple scripts (like Latin and Cyrillic for example). For a complete list of available font subsets please see <a href="http://www.google.com/webfonts" target="_blank">Google Web Fonts</a>.', 'mfn-opts'),
					'class' 	=> 'small-text'
				),
					
			),
		);
		
		// Content Font Size --------------------------------------------
		$sections['font-size'] = array(
			'title' => __('Size', 'mfn-opts'),
			'fields' => array(
	
				array(
					'id' 		=> 'font-size-content',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Content', 'mfn-opts'),
					'sub_desc' 	=> __('This font size will be used for all theme texts', 'mfn-opts'),
					'std' 		=> '13',
				),
					
				array(
					'id' 		=> 'font-size-menu',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Main menu', 'mfn-opts'),
					'sub_desc' 	=> __('This font size will be used for top level only', 'mfn-opts'),
					'std' 		=> '14',
				),
				
				array(
					'id' 		=> 'font-size-h1',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Heading H1', 'mfn-opts'),
					'sub_desc' 	=> __('Subpages header title', 'mfn-opts'),
					'std' 		=> '25',
				),
				
				array(
					'id' 		=> 'font-size-h2',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Heading H2', 'mfn-opts'),
					'std' 		=> '30',
				),
				
				array(
					'id' 		=> 'font-size-h3',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Heading H3', 'mfn-opts'),
					'std' 		=> '25',
				),
				
				array(
					'id' 		=> 'font-size-h4',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Heading H4', 'mfn-opts'),
					'std' 		=> '21',
				),
				
				array(
					'id' 		=> 'font-size-h5',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Heading H5', 'mfn-opts'),
					'std' 		=> '15',
				),
				
				array(
					'id' 		=> 'font-size-h6',
					'type' 		=> 'sliderbar',
					'title' 	=> __('Heading H6', 'mfn-opts'),
					'std' 		=> '13',
				),
		
			),
		);
		
		// Font Custom --------------------------------------------
		$sections['font-custom'] = array(
			'title' => __('Custom', 'mfn-opts'),
			'fields' => array(
					
				array(
					'id' 		=> 'font-custom',
					'type' 		=> 'text',
					'title' 	=> __('Font | Name', 'mfn-opts'),
					'sub_desc' 	=> __('Please use only letters or spaces, eg. Patua One', 'mfn-opts'),
					'desc' 		=> __('Name for Custom Font uploaded below. Font will show on fonts list after click the Save Changes button.' , 'mfn-opts'),
					'class' 	=> 'small-text',
				),

				array(
					'id' 		=> 'font-custom-woff',
					'type' 		=> 'upload',
					'title' 	=> __('Font | .woff', 'mfn-opts'),
					'class' 	=> '',
				),

				array(
					'id' 		=> 'font-custom-ttf',
					'type' 		=> 'upload',
					'title' 	=> __('Font | .ttf', 'mfn-opts'),
					'class' 	=> '',
				),

				array(
					'id' 		=> 'font-custom-svg',
					'type' 		=> 'upload',
					'title' 	=> __('Font | .svg', 'mfn-opts'),
					'class' 	=> '',
				),

				array(
					'id' 		=> 'font-custom-eot',
					'type' 		=> 'upload',
					'title' 	=> __('Font | .eot', 'mfn-opts'),
					'class' 	=> '',
				),

				array(
					'id' 		=> 'font-custom2',
					'type' 		=> 'text',
					'title' 	=> __('Font 2 | Name', 'mfn-opts'),
					'sub_desc' 	=> __('Please use only letters or spaces, eg. Patua One', 'mfn-opts'),
					'desc' 		=> __('Name for Custom Font 2 uploaded below. Font will show on fonts list after click the Save Changes button.' , 'mfn-opts'),
					'class' 	=> 'small-text',
				),

				array(
					'id' 		=> 'font-custom2-woff',
					'type' 		=> 'upload',
					'title' 	=> __('Font 2 | .woff', 'mfn-opts'),
					'class' 	=> '',
				),

				array(
					'id' 		=> 'font-custom2-ttf',
					'type' 		=> 'upload',
					'title' 	=> __('Font 2 | .ttf', 'mfn-opts'),
					'class' 	=> '',
				),

				array(
					'id' 		=> 'font-custom2-svg',
					'type' 		=> 'upload',
					'title' 	=> __('Font 2 | .svg', 'mfn-opts'),
					'class' 	=> '',
				),

				array(
					'id' 		=> 'font-custom2-eot',
					'type' 		=> 'upload',
					'title' 	=> __('Font 2 | .eot', 'mfn-opts'),
					'class' 	=> '',
				),
					
			),
		);
		
		
		// Translate / General --------------------------------------------
		$sections['translate-general'] = array(
			'title' => __('General', 'mfn-opts'),
			'fields' => array(
		
				array(
					'id' 		=> 'translate',
					'type' 		=> 'switch',
					'title' 	=> __('Enable Translate', 'mfn-opts'), 
					'desc' 		=> __('Turn it off if you want to use .mo .po files for more complex translation.', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '1'
				),
				
				array(
					'id' 		=> 'translate-search-placeholder',
					'type' 		=> 'text',
					'title' 	=> __('Search Placeholder', 'mfn-opts'),
					'desc' 		=> __('Search Form', 'mfn-opts'),
					'std' 		=> 'Enter your search',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-search-results',
					'type' 		=> 'text',
					'title' 	=> __('results found for:', 'mfn-opts'),
					'desc' 		=> __('Search Results', 'mfn-opts'),
					'std' 		=> 'results found for:',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-home',
					'type' 		=> 'text',
					'title' 	=> __('Home', 'mfn-opts'),
					'desc' 		=> __('Breadcrumbs', 'mfn-opts'),
					'std' 		=> 'Home',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-prev',
					'type' 		=> 'text',
					'title' 	=> __('Prev page', 'mfn-opts'),
					'desc' 		=> __('Pagination', 'mfn-opts'),
					'std' 		=> 'Prev page',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-next',
					'type' 		=> 'text',
					'title' 	=> __('Next page', 'mfn-opts'),
					'desc' 		=> __('Pagination', 'mfn-opts'),
					'std' 		=> 'Next page',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-load-more',
					'type' 		=> 'text',
					'title' 	=> __('Load more', 'mfn-opts'),
					'desc' 		=> __('Pagination', 'mfn-opts'),
					'std' 		=> 'Load more',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-wpml-no',
					'type' 		=> 'text',
					'title' 	=> __('No translations available for this page', 'mfn-opts'),
					'desc' 		=> __('WPML Languages Menu', 'mfn-opts'),
					'std' 		=> 'No translations available for this page',
				),
				
				array(
					'id' 		=> 'translate-days',
					'type' 		=> 'text',
					'title' 	=> __('Days', 'mfn-opts'),
					'desc' 		=> __('Countdown', 'mfn-opts'),
					'std' 		=> 'days',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-hours',
					'type' 		=> 'text',
					'title' 	=> __('Hours', 'mfn-opts'),
					'desc' 		=> __('Countdown', 'mfn-opts'),
					'std' 		=> 'hours',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-minutes',
					'type' 		=> 'text',
					'title' 	=> __('Minutes', 'mfn-opts'),
					'desc' 		=> __('Countdown', 'mfn-opts'),
					'std' 		=> 'minutes',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-seconds',
					'type' 		=> 'text',
					'title' 	=> __('Seconds', 'mfn-opts'),
					'desc' 		=> __('Countdown', 'mfn-opts'),
					'std' 		=> 'seconds',
					'class' 	=> 'small-text',
				),
	
			),
		);
		
		// Translate / Blog  --------------------------------------------
		$sections['translate-blog'] = array(
			'title' => __('Blog & Portfolio', 'mfn-opts'),
			'fields' => array(
	
				array(
					'id' 		=> 'translate-filter',
					'type' 		=> 'text',
					'title' 	=> __('Filter by', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio', 'mfn-opts'),
					'std' 		=> 'Filter by',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-tags',
					'type' 		=> 'text',
					'title' 	=> __('Tags', 'mfn-opts'),
					'desc' 		=> __('Blog', 'mfn-opts'),
					'std' 		=> 'Tags',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-authors',
					'type' 		=> 'text',
					'title' 	=> __('Authors', 'mfn-opts'),
					'desc' 		=> __('Blog', 'mfn-opts'),
					'std' 		=> 'Authors',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-all',
					'type' 		=> 'text',
					'title' 	=> __('Show all', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio', 'mfn-opts'),
					'std' 		=> 'Show all',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-item-all',
					'type' 		=> 'text',
					'title' 	=> __('All', 'mfn-opts'),
					'desc' 		=> __('Blog Item, Portfolio Item', 'mfn-opts'),
					'std' 		=> 'All',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-published',
					'type' 		=> 'text',
					'title' 	=> __('Published by', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio', 'mfn-opts'),
					'std' 		=> 'Published by',
					'class' 	=> 'small-text',
				),
	
				array(
					'id' 		=> 'translate-at',
					'type' 		=> 'text',
					'title' 	=> __('at', 'mfn-opts'),
					'sub_desc' 	=> __('Published by .. at', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio', 'mfn-opts'),
					'std' 		=> 'at',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-categories',
					'type' 		=> 'text',
					'title' 	=> __('Categories', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio', 'mfn-opts'),
					'std' 		=> 'Categories',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-tags',
					'type' 		=> 'text',
					'title' 	=> __('Tags', 'mfn-opts'),
					'desc' 		=> __('Blog', 'mfn-opts'),
					'std' 		=> 'Tags',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-readmore',
					'type' 		=> 'text',
					'title' 	=> __('Read more', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio', 'mfn-opts'),
					'std' 		=> 'Read more',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-like',
					'type' 		=> 'text',
					'title' 	=> __('Do you like it?', 'mfn-opts'),
					'desc' 		=> __('Blog', 'mfn-opts'),
					'std' 		=> 'Do you like it?',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-related',
					'type' 		=> 'text',
					'title' 	=> __('Related projects', 'mfn-opts'),
					'desc' 		=> __('Blog, Portfolio', 'mfn-opts'),
					'std' 		=> 'Related posts',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'translate-client',
					'type' 		=> 'text',
					'title' 	=> __('Client', 'mfn-opts'),
					'desc' 		=> __('Portfolio', 'mfn-opts'),
					'std' 		=> 'Client',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-date',
					'type' 		=> 'text',
					'title' 	=> __('Date', 'mfn-opts'),
					'desc' 		=> __('Portfolio', 'mfn-opts'),
					'std' 		=> 'Date',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-website',
					'type' 		=> 'text',
					'title' 	=> __('Website', 'mfn-opts'),
					'desc' 		=> __('Portfolio', 'mfn-opts'),
					'std' 		=> 'Website',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-view',
					'type' 		=> 'text',
					'title' 	=> __('View website', 'mfn-opts'),
					'desc' 		=> __('Portfolio', 'mfn-opts'),
					'std' 		=> 'View website',
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'translate-task',
					'type' 		=> 'text',
					'title' 	=> __('Task', 'mfn-opts'),
					'desc' 		=> __('Portfolio', 'mfn-opts'),
					'std' 		=> 'Task',
					'class' 	=> 'small-text',
				),
	
			),
		);
		
		// Translate Error 404 --------------------------------------------
		$sections['translate-404'] = array(
			'title' => __('Error 404', 'mfn-opts'),
			'fields' => array(
		
				array(
					'id' 		=> 'translate-404-title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mfn-opts'),
					'desc'		=> __('Ooops... Error 404', 'mfn-opts'),
					'std' 		=> 'Ooops... Error 404',
				),
				
				array(
					'id' 		=> 'translate-404-subtitle',
					'type' 		=> 'text',
					'title' 	=> __('Subtitle', 'mfn-opts'),
					'desc' 		=> __('We are sorry, but the page you are looking for does not exist.', 'mfn-opts'),
					'std' 		=> 'We are sorry, but the page you are looking for does not exist.',
				),
				
				array(
					'id' 		=> 'translate-404-text',
					'type' 		=> 'text',
					'title' 	=> __('Text', 'mfn-opts'),
					'desc' 		=> __('Please check entered address and try again or', 'mfn-opts'),
					'std' 		=> 'Please check entered address and try again or ',
				),
				
				array(
					'id' 		=> 'translate-404-btn',
					'type' 		=> 'text',
					'title' 	=> __('Button', 'mfn-opts'),
					'sub_desc' 	=> __('Go To Homepage button', 'mfn-opts'),
					'std' 		=> 'go to homepage',
					'class' 	=> 'small-text',
				),
		
			),
		);
		
		// Translate WPML --------------------------------------------
		$sections['translate-wpml'] = array(
			'title' => __('WPML Installer', 'mfn-opts'),
			'fields' => array(
		
				array(
					'id' 		=> 'translate-wpml-info',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('WPML is an optional premium plugin and it is NOT included into the theme', 'mfn-opts'),
				),		
					
				array(
					'id' 		=> 'translate-wpml-installer',
					'type' 		=> 'custom',
					'title' 	=> __('WPML Installer', 'mfn-opts'),
					'sub_desc'	=> __('WPML makes it easy to build multilingual sites and run them. It’s powerful enough for corporate sites, yet simple for blogs.', 'mfn-opts'),
					'action' 	=> 'wpml',
				),
		
			),
		);
		
		// Custom CSS & JS ========================================================================
		
		// CSS --------------------------------------------
		$sections['css'] = array(
			'title' => __('CSS', 'mfn-opts'),
			'fields' => array(
	
				array(
					'id' 		=> 'custom-css',
					'type' 		=> 'textarea',
					'title' 	=> __('Custom CSS', 'mfn-opts'),
					'sub_desc' 	=> __('Paste your custom CSS code here', 'mfn-opts'),
					'class' 	=> 'custom-css',
				),
						
			),
		);
		
		// JS --------------------------------------------
		$sections['js'] = array(
			'title' => __('JS', 'mfn-opts'),
			'fields' => array(

				array(
					'id' 		=> 'custom-js',
					'type' 		=> 'textarea',
					'title' 	=> __('Custom JS', 'mfn-opts'),
					'sub_desc' 	=> __('Paste your custom JS code here', 'mfn-opts'),
					'desc' 		=> __('To use jQuery code wrap it into <strong>jQuery(function($){ ... });</strong>', 'mfn-opts'),
				),
						
			),
		);
									
		global $MFN_Options;
		$MFN_Options = new MFN_Options( $menu, $sections );
	}
}
// add_action('init', 'mfn_opts_setup', 0);
mfn_opts_setup();


/**
 * This is used to return option value from the options array
 */
if( ! function_exists( 'mfn_opts_get' ) )
{
	function mfn_opts_get( $opt_name, $default = null ){
		global $MFN_Options;
		return $MFN_Options->get( $opt_name, $default );
	}
}


/**
 * This is used to echo option value from the options array
 */
if( ! function_exists( 'mfn_opts_show' ) )
{
	function mfn_opts_show( $opt_name, $default = null ){
		global $MFN_Options;
		$option = $MFN_Options->get( $opt_name, $default );
		if( ! is_array( $option ) ){
			echo $option;
		}	
	}
}


/**
 * Add new mimes for custom font upload
 */
if( ! function_exists( 'mfn_upload_mimes' ) )
{
	function mfn_upload_mimes( $existing_mimes=array() ){
		$existing_mimes['woff'] = 'font/woff';
		$existing_mimes['ttf'] 	= 'font/ttf';
		$existing_mimes['svg'] 	= 'font/svg';
		$existing_mimes['eot'] 	= 'font/eot';
		return $existing_mimes;
	}
}
add_filter('upload_mimes', 'mfn_upload_mimes');

?>
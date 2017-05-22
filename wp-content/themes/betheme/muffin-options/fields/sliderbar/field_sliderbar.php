<?php
class MFN_Options_sliderbar extends MFN_Options{	
	
	
	/**
	 * Field Constructor.
	*/
	function __construct($field = array(), $value ='', $parent){	
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;	
	}

	
	/**
	 * Field Render Function.
	*/
	function render(){
		
		$class	= isset( $this->field['class'] ) ? 'class="'. $this->field['class'] .'" ' : '';
		$param 	= isset( $this->field['param'] ) ? $this->field['param'] : '';
		
		$min 	= isset( $param['min'] ) ? $param['min'] : 1;
		$max 	= isset( $param['max'] ) ? $param['max'] : 70;
		
		echo '<div id="'.$this->field['id'].'_sliderbar" class="sliderbar '.$class.'" rel="'.$this->field['id'].'" data-min="'. $min .'" data-max="'. $max .'"></div>';
		
		echo '<input type="text" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.esc_attr($this->value).'" class="sliderbar_input '.$class.'" readonly="readonly"/>';	
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description sliderbar_desc'.$class.'">'.$this->field['desc'].'</span>':'';
	}
	
	
	/**
	 * Enqueue Function.
	*/
	function enqueue(){
		wp_enqueue_style('mfn-opts-jquery-ui-css');
		
		wp_enqueue_script(
			'jquery-slider', 
			MFN_OPTIONS_URI.'fields/sliderbar/jquery.ui.slider.js', 
			array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), 
			time(), 
			true
		);

		wp_enqueue_script(
			'mfn-opts-field-sliderbar-js', 
			MFN_OPTIONS_URI.'fields/sliderbar/field_sliderbar.js', 
			array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'),
			time(),
			true
		);
	}
}
?>
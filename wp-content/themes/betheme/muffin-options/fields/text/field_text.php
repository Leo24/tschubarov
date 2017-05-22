<?php
class MFN_Options_text extends MFN_Options{	
	
	/**
	 * Field Constructor.
	*/
	function __construct( $field = array(), $value ='', $parent = NULL ){
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;		
	}
	
	/**
	 * Field Render Function.
	*/
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? $this->field['class'] : 'regular-text';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		echo '<input type="text" name="'. $name .'" value="'.esc_attr($this->value).'" class="'.$class.'" />';
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description '.$class.'">'.$this->field['desc'].'</span>':'';
		
	}
	
}
?>
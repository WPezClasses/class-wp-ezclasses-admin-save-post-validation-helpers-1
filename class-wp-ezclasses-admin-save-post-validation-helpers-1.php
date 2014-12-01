<?php
/** 
 * The "default" set of validation methods that pairs with class-wp-ezclasses-admin-save-post-1
 *
 * ref: https://github.com/WPezClasses/class-wp-ezclasses-admin-save-post-validation-1
 *
 * PHP version 5.3
 *
 * LICENSE: TODO
 *
 * @package WPezClasses
 * @author Mark Simchock <mark.simchock@alchemyunited.com>
 * @since 0.5.1
 * @license TODO
 */
 
/**
 * == Change Log == 
 *
 * -- 0.5.0 - Tue 25 Nov 2014
 *
 * ---- Pop the champagne!
 */
 
/**
 * == TODO == 
 *
 *
 */

// No WP? Die! Now!!
if (!defined('ABSPATH')) {
	header( 'HTTP/1.0 403 Forbidden' );
    die();
}

if ( ! class_exists('Class_WP_ezClasses_Admin_Save_Post_Validation_Helpers_1') ) {
  class Class_WP_ezClasses_Admin_Save_Post_Validation_Helpers_1 extends Class_WP_ezClasses_Master_Singleton{
  
    private $_version;
    private $_url;
    private	$_path;
    private $_path_parent;
    private $_basename;
    private $_file;
  
    protected $_arr_init;
	protected $_str_lang;
	
	public function __construct() {
	  parent::__construct();
	}
		
	/**
	 *
	 */
	public function ez__construct($str_lang = 'en'){
	
	  $this->setup();
	  
	  $this->_str_lang = $str_lang;
	
	  // $arr_init_defaults = $this->init_defaults();  
	  // $this->_arr_init = WPezHelpers::ez_array_merge(array($arr_init_defaults, $arr_args));
	}
	
	/**
	 * 
	 */
	protected function setup(){
	
	  $this->_version = '0.5.0';
	  $this->_url = plugin_dir_url( __FILE__ );
	  $this->_path = plugin_dir_path( __FILE__ );
	  $this->_path_parent = dirname($this->_path);
	  $this->_basename = plugin_basename( __FILE__ );
	  $this->_file = __FILE__ ;
	}
	
	/**
	 *
	 */
	protected function init_defaults(){
	
	  $arr_defaults = array(
	  
	  	'active'			 					=> false,   // currently NA
		'active_true'							=> false,	// currently NA 
		'filters'								=> false, 	// currently NA
		'arr_arg_validation'					=> false, 	// currently NA
		);
	
	  return $arr_defaults;
	}
	
	/**
	 *
	 */
	public function required($str_name = '', $str_type = '', $arr_args = ''){
	  
	  $str_this_is = 'required';
	  $str_method = $str_this_is . '_' . trim(strtolower($str_type));
	  if ( ! method_exists($this, $str_method) ){
	    return false;
	  }
	  
	  // each 'type' has a specialize method
	  $bool_eval = $this->$str_method($str_name, $str_type, $arr_args);
	  
	  if ($bool_eval === true){ 
	  
		if ( isset($arr_args['msg']) ) {
		  return $arr_args['msg'];
		}
		
		$str_lang = $this->_str_lang;
	    if ( isset($arr_args['lang']) && is_string($arr_args['lang']) ) {
		  $str_lang = $arr_args['lang'];
		}
		
		return $this->required_message($str_lang);
	  }
	}
	
	/**
	 *
	 */
	protected function required_message($str_lang = 'en'){
	
	  if ( $str_lang == 'en' ){
	    return 'Is required.';
	  } else {
	    return 'Is required.';
	  }
	}
	
	/**
	 *
	 */
	protected function required_text($str_name = '', $str_type = '', $arr_args = ''){

	  if ( isset($_POST[$str_name]) ){
	    $str_post_name = trim($_POST[$str_name]);
	    if ( empty($str_post_name) ){
	      return true;
		}
	  }
	  return false;
	}
	
	/**
	 * NOTE: If there's no category WP will automatically set one. (For now) we can only catch there was not one 
	 * checked by the user.
	 */
	protected function required_category($str_name = '', $str_type = '', $arr_args = ''){
	
	  if ( isset($_POST['post_category']) && is_array($_POST['post_category']) && count($_POST['post_category']) == 1  ){
	    return true;
	  }
	  return false;
	}
	
	/**
	 *
	 */
	protected function required_featured_image($str_name = '', $str_type = '', $arr_args = ''){

	  if ( ! has_post_thumbnail() ){
	    return true;
	  }
	  return false;
	}
	
	/**
	 *
	 */
	public function length_min($str_name = '', $str_type = '', $arr_args = ''){
	
	  $str_this_is = 'length_min';
	  $str_method = $str_this_is . '_' . trim(strtolower($str_type));
	  if ( ! method_exists($this, $str_method) || ! isset($arr_args['arr_args']['strlen']) ){
	    return false;
	  }
	  
	  // each 'type' has a specialize method
	  $bool_eval = $this->$str_method($str_name, $str_type, $arr_args);
	
	  if ($bool_eval === true){ 
	    
		if ( isset($arr_args['msg']) ) {
		  return $arr_args['msg']  . $arr_args['arr_args']['strlen'];
		}
		
		$str_lang = $this->_str_lang;
	    if ( isset($arr_args['lang']) && is_string($arr_args['lang']) ) {
		  $str_lang = $arr_args['lang'];
		}
		
		return $this->length_min_message($str_lang) . $arr_args['arr_args']['strlen'];
	  }
	}
	
	protected function length_min_message($str_lang = 'en'){
	
	  if ( $str_lang == 'en' ){
	    return 'Total character count is less than the minimum of: ';
	  } else {
	    return 'Total character count is less than the minimum of: ';
	  }
	}
	
	/**
	 *
	 */
	protected function length_min_text($str_name = '', $str_type = '', $arr_args = ''){

	  if ( isset($_POST[$str_name]) && ( (strlen(trim($_POST[$str_name]))) < $arr_args['arr_args']['strlen'] ) ){
	    return true;
	  }
	  return false;
	
	}
	
	
	/**
	 *
	 */
	public function length_max($str_name = '', $str_type = '', $arr_args = ''){
	
	  $str_this_is = 'length_max';
	  $str_method = $str_this_is . '_' . trim(strtolower($str_type));
	  if ( ! method_exists($this, $str_method) || ! isset($arr_args['arr_args']['strlen']) ){
	    return false;
	  }
	  
	  // each 'type' has a specialize method
	  $bool_eval = $this->$str_method($str_name, $str_type, $arr_args);
	
	  if ($bool_eval === true){ 
	    
		if ( isset($arr_args['msg']) ) {
		  return $arr_args['msg']  . $arr_args['arr_args']['strlen'];
		}
		
		$str_lang = $this->_str_lang;
	    if ( isset($arr_args['lang']) && is_string($arr_args['lang']) ) {
		  $str_lang = $arr_args['lang'];
		}
		
		return $this->length_max_message($str_lang) . $arr_args['arr_args']['strlen'];
	  }
	}
	
	protected function length_max_message($str_lang = 'en'){
	
	  if ( $str_lang == 'en' ){
	    return 'Total character count is greater than the maximum of: ';
	  } else {
	    return 'Total character count is greater than the maximum of: ';
	  }
	}
	
	/**
	 *
	 */
	protected function length_max_text($str_name = '', $str_type = '', $arr_args = ''){

	  if ( isset($_POST[$str_name]) && ( strlen(trim($_POST[$str_name])) > $arr_args['arr_args']['strlen'] ) ){
	    return true;
	  }
	  return false;
	
	}
	
  }
} 
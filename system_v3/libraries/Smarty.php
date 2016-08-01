<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Smarty Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Smarty
 * @author		Kepler Gelotte
 * @link		http://www.coolphptools.com/codeigniter-smarty
 */
require_once(BASEPATH.'Smarty/libs/Smarty.class.php' );
class CI_Smarty extends Smarty {
  function __construct(){
    parent::__construct(); 
    $this->compile_dir = APPPATH . "views/templates_c";
    $this->template_dir = APPPATH . "views/templates";
    $this->left_delimiter =  "<{";
    $this->right_delimiter = "}>";
    $this->assign( 'APPPATH', APPPATH );
    $this->assign( 'BASEPATH', BASEPATH );
    // Assign CodeIgniter object by reference to CI
    if ( method_exists( $this, 'assignByRef') ){
      $ci =& get_instance();
      $this->assignByRef("ci", $ci);
    }
    log_message('debug', "Smarty Class Initialized");
  }

	/**
	 *  Parse a template using the Smarty engine
	 *
	 * This is a convenience method that combines assign() and
	 * display() into one step. 
	 *
	 * Values to assign are passed in an associative array of
	 * name => value pairs.
	 *
	 * If the output is to be returned as a string to the caller
	 * instead of being output, pass true as the third parameter.
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
  function view($template, $data = array(), $returnFetch = 0){
    if (is_array($data) && !empty($data)) {
      foreach ($data as $key => $val) {
        $this->assign($key, $val);
      }
    }
    if (!file_exists(APPPATH."views/templates/".$template)){
      $template = "error.tpl";
    }
    if (!$returnFetch){
      $CI =& get_instance();
      if (method_exists( $CI->output, 'set_output' )){
        $CI->output->set_output( $this->fetch($template) );
      } else {
        $CI->output->final_output = $this->fetch($template);
      }
      return;
    } else {
      return $this->fetch($template);
    }
  }
}
// END Smarty Class
?>

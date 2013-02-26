<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Layout Class
 *
 * Layout rendering engine extension for Code Igniter
 * Intended for easially managable html layouts with variable content and modules
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Layouts
 * @author		Harris Miller
 * @link		TODO: add github link
 */
class Layout
{
	var $_CI;

	const HTML_REGEX	= '/http:\/\//';
	const MIN_REGEX		= '/\.min\./';

	var $_title			= '';

	var $_html_classes	= array();
	var $_html_id		= '';
	var $_html_attrs	= array();

	var $_base_href		= '';
	var $_base_target	= '';

	var $_meta_tags		= array();

	var $_link_tags		= array();

	var $_css_files		= array();
	var $_js_files		= array();
	var $_js_inlines	= array();
	var $_noscript		= array();

	var $_layout		= '';
	var $_layout_folder	= '';
	var $_use_layout	= TRUE;
	var $_layout_data	= array();

	var $_modules		= array();
	var $_module_data	= array();

	
	public function __construct()
	{
		$this->_CI =& get_instance();

		// load url and html helpers
		$this->_CI->load->helper('url');
		$this->_CI->load->helper('html');
	}

	function render($main_content)
	{
		$out = '';

		$data = array(
				'output' => $main_content,
				'modules' => $this->_get_modules()
				);

		$layout_folder = $this->_CI->config->item('layout_folder');
		$layout = $this->_CI->config->item('layout');

		$out .= doctype();
		$out .= $this->_get_html_tag();
		$out .= $this->_get_head();
		$out .= $this->_CI->load->view($layout_folder . $layout, $data, TRUE);
		$out .= '</html>';

		return $out;
	}


	function _get_html_tag()
	{
		return '<html>';
	}

	function _get_head()
	{
		return '<head><title>Layout test</title></head>';
	}

	function _get_modules()
	{
		return array('aside' => '');
	}
	
}
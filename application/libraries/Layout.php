<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Layout Class
 *
 * Layout rendering engine extension for Code Igniter
 * Intended for easially managable html layouts with variable content and modules
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Harris Miller
 * @link		TODO: add github link
 */
class Layout
{
	private $_CI;

	private $_layout		= '';
	private $_layout_folder	= '';
	private $_layout_data	= array();

	private $_modules		= array();
	private $_module_data	= array();

	private $_title			= '';

	private $_html_classes	= array();
	private $_html_id		= '';
	private $_html_attrs	= array();

	private $_base_href		= '';
	private $_base_target	= '';

	private $_meta_tags		= array();

	private $_link_tags		= array();

	private $_css_files		= array();
	private $_css_folder	= '';

	private $_js_files		= array();
	private $_js_folder		= '';
	private $_js_inlines	= array();
	private $_noscript		= array();

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->_CI =& get_instance();

		// load library dependent helpers
		$this->_CI->load->helper('url');
		$this->_CI->load->helper('html');
	}

	// --------------------------------------------------------------------

	/**
	 * Render layout
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function render($content)
	{
		$out = '';

		// set layout data
		$data = array(
				'content' => $content,
				'modules' => $this->_render_modules()
				);

		// layout file and folder
		// use config if present
		$layout = $this->_item('layout') ? $this->_item('layout') : '';
		$layout_folder = $this->_item('layout_folder') ? $this->_item('layout_folder') : '';
		// override with local set if present
		$layout = !empty($this->_layout) ? $this->_layout : $layout;
		$layout_folder = !empty($this->_layout_folder) ? $this->_layout_folder : $layout_folder;

		// compose output string
		$out .= '<!DOCTYPE html>';
		$out .= $this->_render_html_tag();
		$out .= $this->_render_head();
		$out .= $this->_CI->load->view($layout_folder . $layout, $data, TRUE);
		$out .= '</html>';

		return $out;
	}

	// --------------------------------------------------------------------

	/**
	 * Set layout
	 *
	 * @access	public
	 * @param	string	the name of the view file to use for the layout (exclude file extension)
	 * @return	self
	 */
	public function set_layout($layout)
	{
		$this->_layout = $layout;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set layout folder
	 *
	 * @access	public
	 * @return	self
	 */
	public function set_layout_folder($folder)
	{
		$this->_layout_folder = $folder;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set layout
	 * pass in the name of the view file to use for the layout (exclude file extension)
	 *
	 * @access	public
	 * @param	mixed	can be either a single key or an array of key value pairs
	 * @param	string	the value of the single entered key from first param. if first param is an array, this param is ignored
	 * @return	self
	 */
	public function add_layout_data($data, $data_value)
	{
		if (!is_array($data))
		{
			$data = array($data => $data_value);
		}
		foreach ($data as $key => $value)
		{
			$this->_layout_data[$key] = $value;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Render modules
	 *
	 * @access	private
	 * @return	string
	 */
	private function _render_modules()
	{
		$modules = array();

		foreach($this->_modules as $module)
		{
			$data = isset($this->_module_data[$module]) ? $this->_module_data[$module] : null;
			$modules[$module] = $this->_CI->load->view($module, $data, TRUE);
		}

		return $modules;
	}

	// --------------------------------------------------------------------

	/**
	 * Add module
	 *
	 * @access	public
	 * @param	string	the name of the view file to use for the layout (exclude file extension)
	 * @param	array	data to be passed to view
	 * @return	self
	 */
	public function add_module($module, $data = null)
	{
		$this->_modules[] = $module;

		if (isset($data))
		{
			$this->_module_data[$module] = $data;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Render html tag
	 *
	 * @access	private
	 * @return	string
	 */
	private function _render_html_tag()
	{
		$html_classes = array_merge($this->_item('html_classes'), $this->_html_classes);
		$html_classes = array_unique($html_classes);
		$html_id = !empty($this->_html_id) ? $this->_html_id : $this->_item('html_id');
		$html_attrs = array_merge($this->_item('html_attrs'), $this->_html_attrs);
		$html_attrs = array_unique($html_classes);

		$html_tag = '<html ';

		if (!empty($html_classes))
		{
			$html_tag .= 'class="' . implode(' ', $html_classes) . '" ';
		}
		if (!empty($this->_html_id))
		{
			$html_tag .= 'id="' . $html_id . '" ';
		}
		if (!empty($this->_html_attrs))
		{
			foreach($this->_html_attrs as $key => $value)
			{
				$html_tag .= $key .  '="' . $value . '" ';
			}
		}

		return $html_tag .= '>';
	}

	// --------------------------------------------------------------------

	/**
	 * Add html tag class
	 *
	 * @access	public
	 * @param	mixed
	 * @return	self
	 */
	public function add_html_class($class)
	{
		if (!is_array($class))
		{
			$class = array($class);
		}
		foreach($class as $key => $value)
		{
			if (is_string($key))
			{
				$this->_html_classes[$key] = $value;
			}
			else
			{
				$this->_html_classes[] = $value;
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set html tag id attribute
	 *
	 * @access	public
	 * @param	string
	 * @return	self
	 */
	public function set_html_id($id)
	{
		$this->_html_id = $id;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Add html tag attributes
	 *
	 * @access	public
	 * @param	mixed
	 * @return	self
	 */
	function add_html_attrs($attrs)
	{
		if (is_array($attrs))
		{
			foreach($attrs as $key => $value)
			{
				if (is_string($key))
				{
					$this->_html_attrs[$key] = $value;
				}
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Render head tag
	 *
	 * @access	private
	 * @return	string
	 */
	private function _render_head()
	{
		$head = '<head>';
		$head .= '<title>' . $this->_title . '</title>';
		$head .= $this->_render_base_tag();
		//$head .= $this->_make_meta_tags();
		//$head .= $this->_make_link_tags();
		//$head .= $this->_make_css_tags();
		//$head .= $this->_make_js_tags();
		//$head .= $this->_make_noscript_tag();
		$head .= '</head>';

		return $head;
	}

	// --------------------------------------------------------------------

	/**
	 * Set base tag href attribute
	 *
	 * @access	public
	 * @param	string
	 * @return	self
	 */
	public function set_base_href($href)
	{
		$this->_base_href = $href;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set base tag target attribute
	 *
	 * @access	public
	 * @param	string
	 * @return	self
	 */
	public function set_base_target($target)
	{
		$this->_base_target = $target;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Render base tag
	 *
	 * NOTE: the href attribute defaults to Code Igniter's base_url() method
	 *
	 * @access	private
	 * @return	string
	 */
	private function _render_base_tag()
	{
		$href = !empty($this->_base_href) ? $this->_base_href : base_url();
		$target = !empty($this->_base_target) ? ' target="' . $this->_base_target : '';
		return '<base href="' . $href . '"' . $target . ' />';
	}






	// --------------------------------------------------------------------

	/**
	 * short-cut to $this->config->item()
	 */
	private function _item($item)
	{
		return $this->_CI->config->item($item);
	}
}
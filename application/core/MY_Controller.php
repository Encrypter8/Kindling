<?php

class MY_Controller extends CI_Controller
{
	// data to be sent through to the view
	public $data = array();

	// page title
	private $_title = '';

	// collection of meta data
	private $_meta = array();

	// file collections to be added to header
	private $_css_files = array();
	private $_js_files = array();

	// inline js code to that will be wrapped by document.ready jQuery
	private $_js_inlines = array();

	// view files, leave off .html
	private $_layout = '';

	// variable parts of the layout that are determined by the derived class
	private $_modules = array();
	private $_module_data = array();

	private $_using_layout = true;


	function __construct()
	{
		parent::__construct();
	}


	final function _output($output) {
		// create templating output
		$out = '';

		if($this->_using_layout)
		{
			$header_data = array(
				'title' => $this->_title,
				'meta_tags' => $this->_make_meta_tags(),
				'css_files' => $this->_make_css_tags(),
				'js_files' => $this->_make_js_tags(),
				'js_inlines' => $this->_make_js_inline(),
				'modules' => $this->_make_modules()
				);
			$data = array(
				'output' => $output,
				);

			// may move the inline HTML here, not sure yet
			$out .= '<!DOCTYPE html>';
			$out .= '<html lang="en" class=' . $this->_make_html_classes() . '>';
			$out .= $this->load->view('head', $header_data, TRUE);
			$out .= $this->load->view($this->config->item('layout_folder') . $this->_layout, $data, TRUE);
			$out .= '</html>';

			echo $out;
		}
		// else output as normal
		else
		{
			echo $output;
		}
	}


	// great to have the browser and browser version as classes on <html> for browser specific css and js
	private function _make_html_classes()
	{
		return $this->agent->browser() . ' ' . $this->agent->browser().$this->agent->version_major();
	}

	/**
	 * meta tag methods 
	*/

	private function _make_meta_tags()
	{
		// start with mime typ / char set, since we should always place this in the HTML
		$tags = '<meta content="text/html; charset=' . $this->config->item('charset') . '" http-equiv="Content-Type">';

		// add globals
		foreach($this->config->item('meta_tags') as $meta)
		{
			$tag = '<meta ';
			foreach ($meta as $context => $content)
			{
				$tag .= $context . '="' . $content . '" ';
			}
			$tag .= '/>';
			$tags .= $tag;
		}

		return $tags;
	}

	/**
	 * css file methods 
	*/

	protected function add_css($file)
	{
		array_push($_css_files, $file);
	}

	// TODO: change this function do both page only files and global files
	private function _make_css_tags()
	{
		// TODO: Possibly add css minifier
		$tags = '';

		// add globals
		foreach($this->config->item('css_files') as $file)
		{
			$tags .= $this->_single_css_tag($file);
		}

		// add locals
		foreach($this->_css_files as $file)
		{
			$tags .= $this->_single_css_tag($file);
		}

		return $tags;
	}

	private function _single_css_tag($file)
	{
		return '<link href="' . base_url($this->config->item('css_folder') . $file) . '" type="text/css" rel="stylesheet"></link>';;
	}

	/**
	 * js files methods 
	*/
	
	private function _make_js_tags()
	{
		$tags = '';

		// add global
		foreach($this->config->item('js_files') as $file)
		{
			$tags .= $this->_single_js_tag($file);
		}

		// add local
		foreach($this->_js_files as $file)
		{
			$tags .= $this->_single_js_tag($file);
		}

		return $tags;
	}

	private function _single_js_tag($file)
	{
		return '<script src="' . base_url($this->config->item('js_folder') . $file) . '" type="text/javascript"></script>';
	}

	/**
	 * Inline JS methods
	*/

	protected function add_inline_js($js_string)
	{
		array_push($_inlines_js, $js_string);
	}

	private function _make_js_inline()
	{
		return '<script type="text/javascript">$(function() { ' . implode('', $this->_js_inlines) . '});</script>';
	}

	/**
	 * Title methods
	*/
	protected function set_title($title)
	{
		$this->_title = $title;
	}

	protected function append_title($append)
	{
		$this->_title .= ' - ' . $append;
	}

	/**
	 * Module methods
	 */

	protected function add_module($module, $data = null)
	{
		array_push($this->_modules, $module);
		if (isset($data))
		{
			$this->_module_data[$module] = $data;
		}
	}

	protected function _make_modules()
	{
		$modules = array();

		foreach($this->_modules as $module)
		{
			$data = isset($this->_module_data[$module]) ? $this->_module_data[$module] : null;
			$modules[$module] = $this->load->view($module, $data, TRUE);
		}

		return $modules;
	}

	/**
	 * Layout utility methods
	 */

	protected function set_layout($layout)
	{
		$this->_layout = $layout;
	}

	protected function set_layout_on()
	{
		$this->_using_layout = TRUE;
	}

	protected function set_layout_off()
	{
		$this->_using_layout = FALSE;
	}
}
<?php

class MY_Controller extends CI_Controller
{
	const HTML_REGEX = '/http:\/\//';
	const MIN_REGEX = '/\.min\./';

	// page title
	private $_title = '';

	private $_html_classes = array();
	private $_html_id = '';
	private $_html_attrs = array();

	private $_base_href = '';
	private $_base_target = '';

	// collection of meta data
	private $_meta_tags = array();

	private $_link_tags = array();

	private $_favicon = '';

	// file collections to be added to header, file extensions needed
	private $_css_files = array();
	private $_js_files = array();

	// inline js code to that will be wrapped by document.ready jQuery
	private $_js_inlines = array();

	// only need one noscript tag for the head
	private $_noscript_tag = '';

	// view files, leave off .html
	private $_layout = '';
	private $_using_layout = true;
	private $_layout_data = array();

	// variable parts of the layout that are determined by the derived class
	private $_modules = array();
	private $_module_data = array();

	// minify on or off
	private $_minify = true;

	function __construct()
	{
		parent::__construct();

		if (isset($_GET['minify'])) {
			if ($_GET['minify'] == 'false')
			{
				$this->_minify = false;
				$this->session->set_userdata(array('minify' => 'false'));
			}
			else
			{
				$this->_minify = true;
				$this->session->unset_userdata('minify');
			}
		}
		else
		{
			// the session variable minify is only set for when css minification is set to off
			if ($this->session->userdata('minify') !== false)
			{
				$this->_minify = false;
			}
		}
	}

	final function _output($output) {
		// create templating output
		$out = '';

		if ($this->_using_layout)
		{
			$data = array(
				'output' => $output,
				'modules' => $this->_make_modules()
				);

			$data = array_merge($this->_layout_data, $data);

			// may move the inline HTML here, not sure yet
			$out .= '<!DOCTYPE html>';
			$out .= '<html lang="en" class="' . $this->_make_html_classes() . '">';
			$out .= $this->_make_head();
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

	private function _make_head()
	{
		$head = '<head>';
		$head .= '<title>' . $this->_title . '</title>';
		$head .= $this->_make_base_tag();
		$head .= $this->_make_meta_tags();
		$head .= $this->_make_link_tags();
		$head .= $this->_make_css_tags();
		$head .= $this->_make_js_tags();
		$head .= $this->_make_noscript_tag();
		$head .= '</head>';

		return $head;
	}

	// accepts string or array()
	protected function add_html_class($class)
	{
		// if string, transform into array
		if (!is_array($class))
		{
			$class = array($class);
		}

		array_push($this->_html_classes, $class);
	}

	// single string
	protected function set_html_id($id)
	{
		$this->_html_id = $id;
	}

	// accepts arrays
	protected function add_html_attrs($attrs)
	{
		if (!is_array($attrs))
		{
			// do nothing
			return;
		}

		array_push($this->_html_attrs, $attrs);
	}

	// great to have the browser and browser version as classes on <html> for browser specific css and js
	private function _make_html_classes()
	{
		// first remove any spaces from the browser name (list of browsers in config/user_agents.php)
		$browser = str_replace(' ', '', $this->agent->browser());
		return $browser . ' ' . $browser.$this->agent->version_major();
	}

	/**
	 * base tag methods 
	 */

	public function base_href($href)
	{
		$this->_base_href = $href;
	}

	public function base_target($target)
	{
		$this->_base_target = $target;
	}

	private function _make_base_tag()
	{
		$href = !empty($this->_base_href) ? $this->_base_href : base_url();
		$target = !empty($this->_base_target) ? ' target="' . $this->_base_target : '';
		return '<base href="' . $href . '"' . $target . ' />';
	}

	/**
	 * meta tag methods 
	 */

	public function add_meta_tag($meta_tag)
	{
		array_push($this->_meta_tags, $meta_tag);
	}

	// code igniter's helper function 'meta' is too limited
	// I may move this to a MY_html.php in the helper's folder and just override theirs
	private function _make_meta_tags()
	{
		// start with mime type / char set, since we should always place this in the HTML
		$tags = $this->_make_single_meta_tag(array('content' => 'text/html; charset=' . $this->config->item('charset'), 'http-equiv' => 'Content-Type'));

		// we also want to add X-UA-Compatible if browser is IE
		if ($this->agent->browser() == 'Internet Explorer')
		{
			$tags .= $this->_make_single_meta_tag(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=Edge'));
		}
		
		// add globals
		foreach($this->config->item('meta_tags') as $meta)
		{
			$tags .= $this->_make_single_meta_tag($meta);
		}

		// add locals
		foreach($this->_meta_tags as $meta)
		{
			$tags .= $this->_make_single_meta_tag($meta);
		}

		return $tags;
	}

	private function _make_single_meta_tag($meta)
	{
		$tag = '<meta ';
		foreach ($meta as $context => $content)
		{
			$tag .= $context . '="' . $content . '" ';
		}
		$tag .= '/>';
		return $tag;
	}

	/**
	 * link tag methods
	 */

	public function add_link_tag($link_tag)
	{
		array_push($this->_link_tags, $link_tag);
	}

	// same bullshit with the link_tag helper function
	// I may move this to a MY_html.php in the helper's folder and just override theirs
	private function _make_link_tags()
	{
		$tags = '';

		// first do favicon link, only if global or local has been set
		if (!!$this->config->item('favicon_link') || !empty($this->_favicon))
		{
			// use local over global
			$favicon = !empty($this->_favicon) ? $this->_favicon : $this->config->item('favicon_link');

			// check if file is local to server or http address
			if (preg_match(self::HTML_REGEX, $favicon) == 0)
			{
				$favicon = $this->config->item('images_folder') . $favicon;
			}
			
			$tags .= $this->_make_single_link_tag(array('rel' => 'shortcut icon', 'href' => $favicon));
		}

		// add globals
		foreach($this->config->item('link_tags') as $link)
		{
			$tags .= $this->_make_single_link_tag($link);
		}

		// add locals
		foreach($this->_link_tags as $link)
		{
			$tags .= $this->_make_single_link_tag($link);
		}

		return $tags;
	}

	private function _make_single_link_tag($link)
	{
		$tag = '<link ';
		foreach ($link as $context => $content)
		{
			$tag .= $context . '="' . $content . '" ';
		}
		$tag .= '/>';
		return $tag;
	}

	public function set_favicon($favicon)
	{
		$this->_favicon = $favicon;
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
		$tags = '';

		// minify all css files into one long string and encapsilate it in a style tag
		if ($this->_minify === true)
		{
			$this->load->library('cssmin');

			// add globals
			foreach($this->config->item('css_files') as $file)
			{
				$tags .= $this->_get_css_file_minified($file);
			}

			// add locals
			foreach($this->_css_files as $file)
			{
				$tags .= $this->_get_css_file_minified($file);
			}
		}
		// else, each css file gets its own tag
		else
		{
			// add globals
			foreach($this->config->item('css_files') as $file)
			{
				$tags .= $this->_make_single_css_tag($file);
			}

			// add locals
			foreach($this->_css_files as $file)
			{
				$tags .= $this->_make_single_css_tag($file);
			}
		}

		return $tags;
	}

	private function _get_css_file_minified($file)
	{
		// assume that if '.min.' is found in the file name that the file is already in a minified state
		// so if '.min.' is not found in the file name, minify it
		// also, we can't minify non-local files
		if (preg_match(self::MIN_REGEX, $file) == 0 && preg_match(self::HTML_REGEX, $file) == 0)
		{
			return '<style type="text/css">' . $this->cssmin->minify(file_get_contents($this->config->item('css_folder') . $file), false) . '</style>';
		}
		else
		{
			return $this->_make_single_css_tag($file);
		}
	}

	private function _make_single_css_tag($file)
	{
		// if 'http://' does not exist in $file, assume file is local and location in "cs_folder" set in config/content
		$file = preg_match(self::HTML_REGEX, $file) > 0 ? $file : $this->config->item('css_folder') . $file;
		return $this->_make_single_link_tag(array('href' => $file, 'type' => 'text/css', 'rel' => 'stylesheet'));
	}

	/**
	 * js files methods 
	 */
	
	private function _make_js_tags()
	{
		$tags = '';

		if ($this->_minify === true)
		{
			$this->load->library('jsmin');

			// add global
			foreach($this->config->item('js_files') as $file)
			{
				$tags .= $this->_get_js_file_minified($file);
			}

			// add local
			foreach($this->_js_files as $file)
			{
				$tags .= $this->_get_js_file_minified($file);
			}
		}
		else
		{
			// add global
			foreach($this->config->item('js_files') as $file)
			{
				$tags .= $this->_make_single_js_tag($file);
			}

			// add local
			foreach($this->_js_files as $file)
			{
				$tags .= $this->_make_single_js_tag($file);
			}
		}

		// add inlines if needed. there should only every be a few lines of code here, so no need to run it through the minifier
		$tags .= !empty($this->_js_inlines) ? '<script type="text/javascript">$(function() { ' . implode('', $this->_js_inlines) . '});</script>' : '';

		return $tags;
	}

	private function _get_js_file_minified($file)
	{
		// assume that if '.min.' is found in the file name that the file is already in a minified state
		// so if '.min.' is not found in the file name, minify it
		// also, we can't minify non-local files
		if (preg_match(self::MIN_REGEX, $file) == 0 && preg_match(self::HTML_REGEX, $file) == 0)
		{
			return '<script type="text/javascript">' . $this->jsmin->minify(file_get_contents($this->config->item('js_folder') . $file)) . '</script>';
		}
		else
		{
			return $this->_make_single_js_tag($file);
		}

		return $file;
	}

	private function _make_single_js_tag($file)
	{
		// if 'http://' does not exist in $file, assume file is local and location in "js_folder" set in config/content
		$file = preg_match(self::HTML_REGEX, $file) > 0 ? $file : $this->config->item('js_folder') . $file;
		return '<script src="' . $file . '" type="text/javascript"></script>';
	}

	/**
	 * Inline JS methods
	 */

	protected function add_inline_js($js_string)
	{
		array_push($this->_js_inlines, $js_string);
	}

	/**
	 * no script tag methods
	 */

	protected function noscript_tag($string)
	{
		$this->_noscript_tag = $string;
	}

	private function _make_noscript_tag()
	{
		if (!empty($this->_noscript_tag))
		{
			return '<noscript>' . $this->_noscript_tag . '</noscript>';
		}
		else
		{
			return '';
		}
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
	 * Layout methods
	 */

	protected function set_layout($layout)
	{
		$this->_layout = $layout;
	}

	protected function add_layout_data($key, $value)
	{
		$this->_layout_data[$key] = $value;
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
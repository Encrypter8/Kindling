<?php

class MY_Controller extends CI_Controller
{
	protected $data = Array();

	// find a perminate place for these variables
	private $css_files = array('public/css/base.css', 'public/css/layout.css', 'public/css/skeleton.css', 'public/css/styles.css');
	private $js_files = array('public/js/jquery-1.9.1.js', 'public/js/modernizr-2.6.2.js');

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Kindling';

		$this->data['html_classes']['browser'] = $this->agent->browser();
		$this->data['html_classes']['browser_version'] = $this->agent->browser().$this->agent->version_major();

		//$this->data['css_files'] = array('public/css/base.css', 'public/css/layout.css', 'public/css/skeleton.css');
		//$this->data['js_files'] = array('public/js/jquery-1.9.1.js', 'public/js/modernizr-2.6.2.js');

		// add global CSS and JS files
		// will probably change the location of this, not sure yet
		
		$this->data['css_files'] = Array();
		foreach($this->css_files as $files)
		{
			array_push($this->data['css_files'], '<link href="'.base_url($files).'" type="text/css" rel="stylesheet"></link>');
		}

		$this->data['js_files'] = Array();
		foreach($this->js_files as $files)
		{
			array_push($this->data['js_files'], '<script src="'.base_url($files).'" type="text/javascript"></script>');
		}
		
	}
}
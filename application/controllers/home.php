<?php

/**
* Home Controller
*/
class Home extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->set_title('Kindling');
		$this->set_layout('default');

		//$this->set_layout_off();
	}
	
	public function index()
	{
		$data['body_var'] = "This is a variable";
		$data['aside_var'] = "Aside Variable";

		$this->append_title('Home');
		$this->add_module('aside', $data);

		$this->add_layout_data('datetime', date('Y-m-d'));

		$this->add_inline_js('console.log("I am an inline js");');
		
		$this->load->view('body', $data);
		$this->load->view('body2');
	}

	public function css()
	{
		$this->set_layout_off();
		$this->load->library('cssmin');

		$file_name = 'styles.css';
		$file = $this->config->item('css_folder') . $file_name;

		$css = file_get_contents($file);

		$css = $this->cssmin->minify($css, false);

		echo $css;
	}

	public function js()
	{
		$this->set_layout_off();
		$this->load->library('jsmin');

		$file_name = 'jquery-1.9.1.js';
		$file = $this->config->item('js_folder') . $file_name;

		$js = file_get_contents($file);

		$js = $this->jsmin->minify($js);

		echo $js;
	}
}
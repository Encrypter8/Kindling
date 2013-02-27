<?php

/**
* test class
*/
class Test extends CI_Controller
{
	function index()
	{
		$data['body_var'] = "This is a variable";
		$module_data['aside_var'] = "Aside Variable";


		$this->load->library('layout');

		$this->layout->add_html_class('me')->set_html_id('site');

		$this->layout->add_module('aside', $module_data);
		

		echo $this->layout->render('body');
	}
}
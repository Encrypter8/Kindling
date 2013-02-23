<?php


/**
* 
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
		$data['test'] = "This is a variable";
		$data['test2'] = "Aside Variable";
		$this->append_title('Home');
		$this->add_module('aside', $data);
		$this->load->view('body', $data);
	}
}
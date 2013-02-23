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
		$data['body_var'] = "This is a variable";
		$data['aside_var'] = "Aside Variable";

		$this->append_title('Home');
		$this->add_module('aside', $data);

		$this->add_layout_data('datetime', date('F d, Y'));
		
		$this->load->view('body', $data);
		$this->load->view('body2');
	}
}
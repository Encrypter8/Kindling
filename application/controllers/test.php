<?php

/**
* test class
*/
class Test extends CI_Controller
{
	function index()
	{
		$this->load->library('layout');
		echo $this->layout->render('body');
	}
}
<?php

class MY_Controller extends CI_Controller
{
	protected $data = Array();

	public function __construct()
	{
		parent::__construct();

		$this->data['data'] = Array();

		$this->data['data']['title'] = 'Kindling';

		$this->data['data']['html_classes'] = Array();

		$this->data['data']['html_classes']['browser'] = $this->agent->browser();
		$this->data['data']['html_classes']['browser_version'] = $this->agent->browser().$this->agent->version_major();

		//var_dump($this->agent);


	}
}
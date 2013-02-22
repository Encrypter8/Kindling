<?php

class MY_Controller extends CI_Controller
{
	protected $data = Array();

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Kindling';

		$this->data['html_classes']['browser'] = $this->agent->browser();
		$this->data['html_classes']['browser_version'] = $this->agent->browser().$this->agent->version_major();
	}
}
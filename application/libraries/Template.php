<?php

/**
* Templating class
*/
class Template
{
	private $ci;

	function __construct()
	{
		$this->ci =& get_instance();
	}

	function load($tpl_view, $body_view = null, $data = null, $partial_views = array())
	{
		
	}
}
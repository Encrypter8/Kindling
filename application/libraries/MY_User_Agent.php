<?php

class MY_User_Agent extends CI_User_agent
{
	var $version_major = '';

	function __construct()
	{
		parent::__construct();

		$this->_set_version_major();
	}

	function _set_version_major()
	{
		if ($this->version != '')
		{
			$version_array = explode('.', $this->version());
			$this->version_major = $version_array[0];
		}
	}

	function version_major()
	{
		return $this->version_major;
	}
}
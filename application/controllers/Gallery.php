<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller 
{

	function __construct() {
		parent::__construct();
	}

	public function index() {
		echo "GALLERY";
	}

}
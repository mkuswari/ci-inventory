<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_login();
	}

	public function index()
	{
		$data = [
			"title" => "Dashboard"
		];

		$this->load->view("v_dashboard", $data);
	}
}

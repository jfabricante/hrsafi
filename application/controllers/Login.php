<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');

		$this->load->helper('form');
	}

	public function index()
	{
		$this->load->view('login_view');
	}

	public function authenticate()
	{
		$user = $this->user_model->validate();

		if (is_array($user))
		{
			$this->session->set_userdata($user);
			redirect(base_url('index.php/shuttle/list_'));
		}

		redirect($this->agent->referrer());
	}

	public function logout()
	{
		$this->session->sess_destroy();

		redirect(base_url());
	}

	protected function _showVars($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

}

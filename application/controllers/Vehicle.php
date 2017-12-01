<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Manila');

		$this->load->model('vehicle_model');
	}

	public function list_()
	{
		$data = array(
			'title'    => 'List of Private Vehicle Entry',
			'content'  => 'vehicle/list_view',
			'entities' => $this->vehicle_model->browse()
		);

		$this->load->view('include/template', $data);
	}

	public function form()
	{
		$data = array(
				'title'    => 'Private Car In/Out',
				'entities' => $this->vehicle_model->fetchPassenger()
			);

		$this->load->view('vehicle/form_view', $data);
	}

	public function ajaxFetchEmpNo()
	{
		echo json_encode($this->vehicle_model->fetchEmployeeNo($this->input->post()));
	}

	public function ajaxSaveItems()
	{
		$config = $this->input->post('data');

		// Format data
		foreach ($config as &$entity)
		{
			$entity['occurence_date'] = date('Y-m-d H:i:s', strtotime($entity['occurence_date']));
			$entity['date_filed']     = date('Y-m-d H:i:s');
			$entity['filed_by']       = $this->session->userdata('id');
		}

		$this->vehicle_model->storeBatch($config);
	}

}

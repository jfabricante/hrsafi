<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shuttle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Manila');

		$this->load->model('shuttle_model');
	}

	public function list_()
	{
		$data = array(
			'title'    => 'List of Late Shuttle',
			'content'  => 'shuttle/list_view',
			'entities' => $this->shuttle_model->browseLateItems()
		);

		$this->load->view('include/template', $data);
	}

	public function form()
	{
		$data = array(
				'title' => 'File Late Shuttle',
				'areas' => $this->shuttle_model->fetchShuttleArea()
			);

		$this->load->view('shuttle/form_view', $data);
	}

	public function view_item()
	{
		$config = array(
				'shuttle_code'   => $this->uri->segment(3),
				'occurence_date' => date('Y-m-d', strtotime($this->uri->segment(4)))
			);

		$entities = $this->shuttle_model->readLateItems($config);

		$data = array(
				'title'        => 'View Late Shuttle',
				'passengers'   => $this->shuttle_model->fetchPassenger(array('shuttle_code' => $config['shuttle_code'])),
				'entities'     => $entities,
				'employee_ids' => array_column($entities, 'employee_id'),
				'is_locked'    => array_filter(array_column($entities, 'is_locked'))
			);

		$this->load->view('shuttle/item_view', $data);
	}

	public function ajaxFetchPassenger()
	{
		$config = $this->input->post();

		$config['occurence_date'] = date('Y-m-d', strtotime($config['occurence_date']));

		$hasItem = count($this->shuttle_model->readLateItems($config));
		
		// Remove the element
		unset($config['occurence_date']);

		$passengers = $this->shuttle_model->fetchPassenger($config);

		$markup = '';

		$count = 1;

		foreach ($passengers as $passenger)
		{
			$markup .= '<tr>';
				$markup .= '<td>' . $count . '</td>';
				$markup .= '<td>' . $passenger['fullname'] . '</td>';
				$markup .= '<td>' . $passenger['employee_no'] . '</td>';

				if ($hasItem)
					$markup .= '<td><input type="checkbox" name="validate" value="' . $passenger['id'] . '" disabled class="validate" /></td>';
				else
					$markup .= '<td><input type="checkbox" name="validate" value="' . $passenger['id'] . '" class="validate" /></td>';

			$markup .= '</tr>';

			$count++;
		}

		echo $markup;
	}

	public function ajaxFileLateShuttle()
	{
		$config                   = $this->input->post();
		$config['occurence_date'] = date('Y-m-d H:i:s', strtotime($config['occurence_date']));
		$config['date_filed']     = date('Y-m-d H:i:s a');
		$config['filed_by']       = $this->session->userdata('id');

		echo $this->shuttle_model->storeItem($config);
	}

	public function ajaxLockItems()
	{
		$config = $this->input->post();

		$config['occurence_date'] = date('Y-m-d', strtotime($config['occurence_date']));

		$this->shuttle_model->lockItems($config);
	}

}

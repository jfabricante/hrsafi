<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	public function browse()
	{
		$fields = array(
				'a.id',
				'a.employee_id',
				'a.occurence_date',
				'a.filed_by',
				"CONCAT(b.first_name,' ', b.last_name) AS fullname",
				'c.employee_no'
			);

		$query = $this->db->select($fields)
				->from('private_vehicle_tab AS a')
				->join('personal_information_tab AS b', 'a.employee_id = b.employee_id', 'INNER')
				->join('employee_masterfile_tab AS c', 'a.employee_id = c.id', 'INNER')
				->order_by('fullname')
				->get();

		return $query->result_array();
	}

	public function fetchPassenger()
	{
		$fields = array(
				'c.id',
				"CONCAT(a.first_name,' ', a.last_name) AS fullname",
				'c.employee_no'
			);

		$query = $this->db->select($fields)
				->from('personal_information_tab AS a')
				->join('password_tab AS b', 'a.employee_id = b.employee_id', 'INNER')
				->join('employee_masterfile_tab AS c', 'c.id = b.employee_id', 'INNER')
				->where('c.status_id <= 4')
				->where('a.shuttle_code = 0003')
				->order_by('fullname')
				->get();

		return $query->result_array();
	}

	public function fetchEmployeeNo($params)
	{
		$query = $this->db->select('employee_no')
				->from('employee_masterfile_tab')
				->where('id', $params['employee_id'])
				->get();

		return $query->row_array();
	}

	public function storeBatch($params)
	{
		$this->db->insert_batch('private_vehicle_tab', $params);
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct() {
		parent::__construct();

		$this->load->database();
	}

	public function validate()
	{
		$fields = array(
				'a.id',
				'a.employee_no',
				"CONCAT(b.first_name,' ', b.last_name) AS fullname",
			);

		$clause = array(
				'a.employee_no' => $this->input->post('username'),
				'c.password'    => strtoupper($this->input->post('password'))
			);


		$query = $this->db->select($fields)
				->from('employee_masterfile_tab AS a')
				->join('personal_information_tab AS b', 'a.id = b.employee_id', 'INNER')
				->join('password_tab AS c', 'a.id = c.employee_id', 'INNER')
				->where($clause)
				->get();

		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}

		return 0;
	}
	
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shuttle_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	public function fetchShuttleArea()
	{
		$query = $this->db->get_where('shuttle_tab', 'active > 0');

		return $query->result();
	}

	public function fetchPassenger($params)
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
				->where($params)
				->order_by('fullname')
				->get();

		return $query->result_array();
	}

	public function storeItem($params)
	{
		// $query = $this->db->where($params)->get('late_shuttle_tab');
		$query = $this->db->where('employee_id', $params['employee_id'])
				->where('shuttle_code', $params['shuttle_code'])
				->like('occurence_date', $params['occurence_date'])
				->get('late_shuttle_tab');

		if (!$query->num_rows())
		{
			$this->db->insert('late_shuttle_tab', $params);
			return $this->db->last_query();
		}
		else
		{
			$this->db->where('employee_id', $params['employee_id'])
				->where('shuttle_code', $params['shuttle_code'])
				->like('occurence_date', $params['occurence_date'])
				->delete('late_shuttle_tab');
			return $this->db->last_query();
		}
	}

	public function browseLateItems()
	{
		$fields = array(
				'a.shuttle_code',
				'b.area',
				'a.occurence_date'
			);

		$query = $this->db->select($fields)
				->from('late_shuttle_tab AS a')
				->join('shuttle_tab AS b', 'a.shuttle_code = b.shuttle_code', 'INNER')
				->group_by('a.shuttle_code')
				->group_by('a.occurence_date')
				->get();

		return $query->result_array();
	}

	public function readLateItems($params)
	{
		$fields = array(
				'a.id',
				"CONCAT(c.first_name,' ', c.last_name) AS fullname",
				'a.employee_id',
				'a.occurence_date',
				'd.area',
				'a.shuttle_code',
				'a.is_locked'
			);

		$query = $this->db->select($fields)
				->from('late_shuttle_tab AS a')
				->join('employee_masterfile_tab AS b', 'b.id = a.employee_id', 'INNER')
				->join('personal_information_tab AS c', 'c.employee_id = b.id', 'INNER')
				->join('shuttle_tab AS d', 'a.shuttle_code = d.shuttle_code', 'INNER')
				->where('a.shuttle_code', $params['shuttle_code'])
				->like('occurence_date', $params['occurence_date'])
				->order_by('fullname')
				->get();

		return $query->result_array();
	}

	public function lockItems($params)
	{
		$entities = $this->readLateItems($params);

		foreach ($entities as $entity)
		{
			$config = array(
					'is_locked' => 1
				);

			$query = $this->db->where('id', $entity['id'])->update('late_shuttle_tab', $config);

		}	
	}
}
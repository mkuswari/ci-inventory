<?php 

class Report_model extends CI_Model {

	public function getAllSuppliers()
	{
		return $this->db->get("suppliers")->result_array();
	}

	public function getAllCustomers()
	{
		return $this->db->get("customers")->result_array();
	}

}

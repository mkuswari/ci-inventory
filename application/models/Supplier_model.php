<?php
class Supplier_model extends CI_Model
{

	public function getAllSuppliers()
	{
		return $this->db->get("suppliers")->result_array();
	}

	public function getSupplierById($id)
	{
		return $this->db->get_where("suppliers", ["id_supplier" => $id])->row_array();
	}

	public function insertNewSupplier($supplierData)
	{
		$this->db->insert("suppliers", $supplierData);
	}

	public function updateSelectedSupplier($supplierData, $id)
	{
		$this->db->set("supplier_code", $supplierData["supplier_code"]);
		$this->db->set("supplier_name", $supplierData["supplier_name"]);
		$this->db->set("supplier_email", $supplierData["supplier_email"]);
		$this->db->set("supplier_phone", $supplierData["supplier_phone"]);
		$this->db->set("supplier_address", $supplierData["supplier_address"]);
		$this->db->set("supplier_image", $supplierData["supplier_image"]);
		$this->db->where("id_supplier", $id);
		$this->db->update("suppliers", $supplierData);
	}

	public function deleteSelectedSupplier($id)
	{
		$this->db->where("id_supplier", $id);
		$this->db->delete("suppliers");
	}

	public function makeSupplierCode()
	{
		$this->db->select('RIGHT(items.item_code, 2) as item_code', FALSE);
		$this->db->order_by('item_code', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get("items");
		if ($query->num_rows() <> 0) {
			$data = $query->row();
			$itemCode = intval($data->item_code) + 1;
		} else {
			$itemCode = 1;
		}
		$date = date('dmY');
		$limit = str_pad($itemCode, 3, "0", STR_PAD_LEFT);
		$showCode = "SPL" . $date . $limit;
		return $showCode;
	}
}

<?php
class IncomingItem_model extends CI_Model
{

	public function getAllIncomingItems()
	{
		$this->db->select("*");
		$this->db->from("incoming_items");
		$this->db->join("items", "items.id_item = incoming_items.id_items");
		$this->db->join("suppliers", "suppliers.id_supplier = incoming_items.id_supplier");
		return $this->db->get()->result_array();
	}

	public function getAllIncomingItemById($id)
	{
		$this->db->select("*");
		$this->db->from("incoming_items");
		$this->db->join("items", "items.id_item = incoming_items.id_item");
		$this->db->join("suppliers", "suppliers.id_supplier = incoming_items.id_supplier");
		$this->db->where("id_incoming_items", $id);
		return $this->db->get()->row_array();
	}
	public function makeIncomingItemCode()
	{
		$this->db->select('RIGHT(incoming_items.incoming_item_code, 2) as incoming_item_code', FALSE);
		$this->db->order_by('incoming_item_code', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get("incoming_items");
		if ($query->num_rows() <> 0) {
			$data = $query->row();
			$itemCode = intval($data->item_code) + 1;
		} else {
			$itemCode = 1;
		}
		$date = date('dmY');
		$limit = str_pad($itemCode, 3, "0", STR_PAD_LEFT);
		$showCode = "TRX-M" . $date . $limit;
		return $showCode;
	}

	public function insertNewIncomingItem($incomingItemData)
	{
		$this->db->insert("incoming_items", $incomingItemData);
	}

	public function deleteSelectedIncomingItem($id)
	{
		$this->db->where("id_incoming_items", $id);
		$this->db->delete("incoming_items");
	}

}

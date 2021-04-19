<?php
class IncomingItem extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('IncomingItem_model');
		$this->load->model('Item_model');
		$this->load->model('Supplier_model');
	}

	public function index()
	{
		$data = [
			"title" => "Kelola Barang Masuk",
			"incoming_items" => $this->IncomingItem_model->getAllIncomingItems()
		];

		$this->load->view("incoming_items/v_index", $data);
	}

	public function create()
	{
		$data = [
			"title" => "Tambah Data Barang Masuk",
			"incoming_item_code" => $this->IncomingItem_model->makeIncomingItemCode(),
			"items" => $this->Item_model->getAllItems(),
			"suppliers" => $this->Supplier_model->getAllSuppliers()
		];

		$this->load->view("incoming_items/v_create", $data);
	}
}

<?php

class OutcomingItem extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('OutcomingItem_model');
		$this->load->model('Item_model');
		$this->load->model('Customer_model');
	}

	public function index()
	{
		$data = [
			"title" => "Kelola Barang Keluar",
			"outcoming_items" => $this->OutcomingItem_model->getAllOutcomingItems()
		];

		$this->load->view("outcoming_items/v_index", $data);
	}

	public function create()
	{
		$data = [
			"title" => "Tambah Data Barang Keluar",
			"outcoming_item_code" => $this->OutcomingItem_model->makeOutcomingItemCode(),
			"items" => $this->Item_model->getAllItems(),
			"customers" => $this->Customer_model->getAllCustomers()
		];

		if ($this->form_validation->run() == FALSE) {
			$this->load->view("outcoming_items/v_create", $data);
		} else {
			$outcomingItemData = [
				// 
			];
			$this->OutcomingItem_model->insertNewOutcomingItem($outcomingItemData);
			$this->session->set_flashdata('message', 'Ditambah');
			redirect('outcomingitem');
		}
	}
}
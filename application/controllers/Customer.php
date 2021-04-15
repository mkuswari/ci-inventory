<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_model');
	}

	public function index()
	{
		$data = [
			"title" => "Kelola Customer",
			"customers" => $this->Customer_model->getAllCustomers(),
		];

		$this->load->view("customers/v_index", $data);
	}

	public function create()
	{
		$data = [
			"title" => "Tambah Data Customer",
			"customer_code" => $this->Customer_model->makeCustomerCode()
		];

		$this->_validateForm();
		if ($this->form_validation->run() == FALSE) {
			$this->load->view("customers/v_create", $data);
		} else {

			$customerImage = $_FILES["customer_image"];
			if ($customerImage) {
				$config = [
					"allowed_types" => "jpg|jpeg|png|bmp|gif",
					"upload_path" => "./assets/uploads/customers/",
					"file_name" => $this->input->post("customer_code")
				];
				$this->load->library("upload", $config);
				if ($this->upload->do_upload("customer_image")) {
					$customerImage = $this->upload->data("file_name");
				} else {
					return "default.jpg";
				}
			}

			$customerData = [
				"customer_code" => $this->input->post("customer_code"),
				"customer_name" => $this->input->post("customer_name"),
				"customer_email" => $this->input->post("customer_email"),
				"customer_phone" => $this->input->post("customer_phone"),
				"customer_address" => $this->input->post("customer_address"),
				"customer_image" => $customerImage,
			];

			$this->Customer_model->insertNewCustomer($customerData);
			$this->session->set_flashdata('message', 'Ditambah');
			redirect('customer');
		}
	}

	public function update($id)
	{
		$data = [
			"title" => "Ubah Data Customer",
			"customer" => $this->Customer_model->getCustomerById($id)
		];

		$this->_validateForm();
		if ($this->form_validation->run() == FALSE) {
			$this->load->view("customers/v_update", $data);
		} else {

			$customerImage = $_FILES["customer_image"];
			if ($customerImage) {
				$config = [
					"allowed_types" => "jpg|jpeg|png|bmp|gif",
					"upload_path" => "./assets/uploads/customers/",
					"file_name" => $this->input->post("customer_code")
				];
				$this->load->library("upload", $config);
				if ($this->upload->do_upload("customer_image")) {
					$customer = $this->Customer_model->getCustomerById($id);
					$oldImage = $customer["customer_image"];
					if ($oldImage != "default.jpg") {
						unlink('./assets/uploads/customers/' . $oldImage);
					}
					$newImage = $this->upload->data("file_name");
					$customerImage = $newImage;
				} else {
					$customer = $this->Customer_model->getCustomerById($id);
					$customerImage = $customer["customer_image"];
				}
			}

			$customerData = [
				"customer_code" => $this->input->post("customer_code"),
				"customer_name" => $this->input->post("customer_name"),
				"customer_email" => $this->input->post("customer_email"),
				"customer_phone" => $this->input->post("customer_phone"),
				"customer_address" => $this->input->post("customer_address"),
				"customer_image" => $customerImage,
			];

			$this->Customer_model->updateSelectedCustomer($customerData, $id);
			$this->session->set_flashdata('message', 'Diubah');
			redirect('customer');
		}
	}

	public function delete($id)
	{
		$customer = $this->Customer_model->getCustomerById($id);
		if (file_exists('./assets/uploads/customers/' . $customer["customer_image"]) && $customer["customer_image"]) {
			unlink('./assets/uploads/customers/' . $customer["customer_image"]);
		}

		$this->Customer_model->deleteSelectedCustomer($id);
		$this->session->set_flashdata('message', 'Dihapus');
		redirect('customer');
	}

	private function _validateForm()
	{
		$this->form_validation->set_rules('customer_code', 'Kode Customer', 'required');
		$this->form_validation->set_rules('customer_name', 'Nama Customer', 'required');
		$this->form_validation->set_rules('customer_email', 'Email Customer', 'required');
		$this->form_validation->set_rules('customer_phone', 'No HP Customer', 'required');
		$this->form_validation->set_rules('customer_address', 'Alamat Customer', 'required');
	}
}

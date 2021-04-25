<?php
class Report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('dompdf_gen');
		$this->load->model('Report_model');
	}

	public function reportSuppliers()
	{
		$data["suppliers"] = $this->Report_model->getAllSuppliers();

		$this->load->view("reports/v_report_suppliers", $data);

		$paper_size = 'A4';
		$orientation = "portrait";
		$html = $this->output->get_output();
		$this->dompdf->set_paper($paper_size, $orientation);

		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("REKAP_DATA_SUPPLIER.pdf", array('Attachment' => 0));
	}

	public function reportCustomers()
	{
		$data["customers"] = $this->Report_model->getAllCustomers();

		$this->load->view("reports/v_report_customers", $data);

		$paper_size = 'A4';
		$orientation = "portrait";
		$html = $this->output->get_output();
		$this->dompdf->set_paper($paper_size, $orientation);

		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("REKAP_DATA_CUSTOMER.pdf", array('Attachment' => 0));
	}
}

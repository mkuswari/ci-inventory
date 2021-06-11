<?php
class Report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('dompdf_gen');
		$this->load->model('Report_model');

		must_login();
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

	public function reportTransactions()
	{
		$data = [
			"title" => "Laporan Transaksi",
			"outcoming_year_options" => $this->Report_model->yearOptionsForOutcomingTransaction(),
			"incoming_year_options" => $this->Report_model->yearOptionsForIncomingTransaction(),
		];

		$this->load->view("reports/v_report_transactions", $data);
	}

	public function filterTransactionsReport()
	{
		if (isset($_GET["reports"]) && !empty($_GET["reports"])) {
			$reports = $_GET["reports"];
			// jika jenis laporan yang dipilih 1
			if ($reports == '1') {
				if (isset($_GET["filter"]) && !empty($_GET["filter"])) {
					$filter = $_GET["filter"];
					// jika user memfilter berdasarkan tanggal
					if ($filter == '1') {
						$tgl = $_GET["tanggal"];


						$data = [
							"keterangan" => 'Data Transaksi Keluar Tanggal ' . date('d-m-y', strtotime($tgl)),
							"url_cetak" => 'transaksikeluar/cetak?filter=1&tanggal=' . $tgl,
							"transaksi_keluar" => 'transaksikeluar/cetak?filter=1&tanggal=' . $tgl
						];

						if ($data["transaksi_keluar"] == 0) {
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Data Tidak Ditemukan</div>');
							redirect("report/reporttransactions");
						}

						// cetak laporan
						ob_start();
						$this->load->view("reports/transactions/outcoming_report.php", $data);
						$html = ob_get_contents();
						ob_end_clean();

						require './assets/html2pdf/autoload.php';

						$pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
						$pdf->WriteHTML($html);
						$pdf->Output('LAPORAN_BARANG_KELUAR_HARIAN.pdf', 'D');

						// jika user memfilter berdasarkan bulan
					} else if ($filter == '2') {
						$bulan = $_GET["bulan"];
						$tahun = $_GET["tahun"];
						$namaBulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

						$data = [
							"keterangan" => 'Data Transaksi Keluar Bulan ' . $namaBulan[$bulan] . ' ' . $tahun,
							"url_cetak" => 'transaksikeluar/cetak?filter=2&bulan=' . $bulan . '&tahun=' . $tahun,
							"transaksi_keluar" => $this->Report_model->viewOutcomingTransactionByMonth($bulan, $tahun)
						];

						if ($data["transaksi_keluar"] == NULL) {
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Data Tidak Ditemukan</div>');
							redirect("report/reporttransactions");
						}

						// cetak laporan
						ob_start();
						$this->load->view("reports/transactions/outcoming_report.php", $data);
						$html = ob_get_contents();
						ob_end_clean();

						require './assets/html2pdf/autoload.php';

						$pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
						$pdf->WriteHTML($html);
						$pdf->Output('LAPORAN_BARANG_KELUAR_BULANAN.pdf', 'D');
					} else {
						$tahun = $_GET["tahun"];


						$data = [
							"keterangan" => 'Data Transaksi Keluar Tahun ' . $tahun,
							"url_cetak" => 'transaksikeluar/cetak?filter=3&tahun=' . $tahun,
							"transaksi_keluar" => $this->Report_model->viewOutcomingTransactionByYear($tahun)
						];

						if ($data["transaksi_keluar"] == NULL) {
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Data Tidak Ditemukan</div>');
							redirect("report/reporttransactions");
						}

						// cetak laporan
						ob_start();
						$this->load->view("reports/transactions/outcoming_report.php", $data);
						$html = ob_get_contents();
						ob_end_clean();

						require './assets/html2pdf/autoload.php';

						$pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
						$pdf->WriteHTML($html);
						$pdf->Output('LAPORAN_BARANG_KELUAR_TAHUNAN.pdf', 'D');
					}
				}
			} else {
				if (isset($_GET["filter"]) && !empty($_GET["filter"])) {
					$filter = $_GET["filter"];
					// jika user memfilter berdasarkan tanggal
					if ($filter == '1') {
						$tgl = $_GET["tanggal"];

						$data = [
							"keterangan" => 'Data Transaksi Masuk Tanggal ' . date('d-m-y', strtotime($tgl)),
							"url_cetak" => 'transaksimasuk/cetak?filter=1&tanggal=' . $tgl,
							"transaksi_masuk" => $this->Report_model->viewIncomingTransactionByDate($tgl)
						];

						if (!$data["transaksi_masuk"]) {
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Data Tidak Ditemukan</div>');
							redirect("report/reporttransactions");
						}

						// cetak laporan
						ob_start();
						$this->load->view("reports/transactions/incoming_report.php", $data);
						$html = ob_get_contents();
						ob_end_clean();

						require './assets/html2pdf/autoload.php';

						$pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
						$pdf->WriteHTML($html);
						$pdf->Output('LAPORAN_BARANG_MASUK_HARIAN.pdf', 'D');
						// jika user memfilter berdasarkan bulan
					} else if ($filter == '2') {
						$bulan = $_GET["bulan"];
						$tahun = $_GET["tahun"];
						$namaBulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

						$data = [
							"keterangan" => 'Data Transaksi Masuk Bulan ' . $namaBulan[$bulan] . ' ' . $tahun,
							"url_cetak" => 'transaksimasuk/cetak?filter=2&bulan=' . $bulan . '&tahun=' . $tahun,
							"transaksi_masuk" => $this->Report_model->viewIncomingTransactionByMonth($bulan, $tahun)
						];

						if (!$data["transaksi_masuk"]) {
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Data Tidak Ditemukan</div>');
							redirect("report/reporttransactions");
						}

						// cetak laporan
						ob_start();
						$this->load->view("reports/transactions/incoming_report.php", $data);
						$html = ob_get_contents();
						ob_end_clean();

						require './assets/html2pdf/autoload.php';

						$pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
						$pdf->WriteHTML($html);
						$pdf->Output('LAPORAN_BARANG_MASUK_BULANAN.pdf', 'D');
					} else {
						$tahun = $_GET["tahun"];

						$data = [
							"keterangan" => 'Data Transaksi Masuk Tahun ' . $tahun,
							"url_cetak" => 'transaksimasuk/cetak?filter=3&tahun=' . $tahun,
							"transaksi_masuk" => $this->Report_model->viewIncomingTransactionByYear($tahun)
						];

						if (!$data["transaksi_masuk"]) {
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Data Tidak Ditemukan</div>');
							redirect("report/reporttransactions");
						}

						// cetak laporan
						ob_start();
						$this->load->view("reports/transactions/incoming_report.php", $data);
						$html = ob_get_contents();
						ob_end_clean();

						require './assets/html2pdf/autoload.php';

						$pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
						$pdf->WriteHTML($html);
						$pdf->Output('LAPORAN_BARANG_MASUK_TAHUNAN.pdf', 'D');
					}
				}
			}
		}
	}
}

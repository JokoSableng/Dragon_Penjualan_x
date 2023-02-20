<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
	use \koolreport\export\Exportable;
}

class Utility_CekSJDO extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		$this->load->helper('file');
		if (!isset($this->session->userdata['username'])) {
			$this->session->set_flashdata(
				'pesan',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">
					Anda Belum Login
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>'
			);
			redirect('admin/auth');
		}
	}

	public function index_Utility_CekSJDO()
	{
		if (isset($_POST["print"])) {
		} else {
			$pilih = $this->input->post('option', TRUE);
			$wilayah = $this->input->post('wilayah', TRUE);
			$per = $this->session->userdata['periode'];

			if ($pilih == 1) {
				$data = array(
					'TGL' => set_value('TGL'),
				);
				$data['CekSJDO'] = $this->db->query("SELECT '' AS KODEC, '' AS NAMAC, a.TGL, a.NO_BUKTI, a.NO_DO, b.KD_BRG, b.QTYP, b.QTY, (b.QTYP - b.QTY) AS SELISIH FROM jual a, juald b 
																WHERE a.WILAYAH = '$wilayah' AND a.PER = '$per' AND a.POSTED = 0 AND a.NO_BUKTI = b.NO_BUKTI")->result();
			} elseif ($pilih == 2) {
				$data = array(
					'TGL' => set_value('TGL'),
				);
				$data['CekSJDO'] = $this->db->query("SELECT '' TGL, '' NO_BUKTI, '' NO_DO, KODEC, NAMAC, TOTAL_QTY AS QTY, TOTAL_QTYP AS QTYP, (TOTAL_QTYP - TOTAL_QTY) AS SELISIH FROM jual WHERE WILAYAH = '$wilayah' AND PER = '$per' AND POSTED = 0")->result();
			} else {
				$data = array(
					'TGL' => set_value('TGL'),
				);
				$data['CekSJDO'] = $this->db->query("SELECT ''")->result();
			}


			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/Utility_CekSJDO/Utility_CekSJDO', $data);
			$this->load->view('templates_admin/footer_report');
		}
	}
}

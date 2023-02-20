<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
	use \koolreport\export\Exportable;
}

class Utility_CrosscheckDOSJToko extends CI_Controller
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

	public function index_Utility_CrosscheckDOSJToko()
	{
		if ($this->input->post('print', true)) {
			$CI = &get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;
			$conn = mysqli_connect($servername, $username, $password, $database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Langganan_RincianPenjualanWilayah.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$filter_wilayah = " ";
			if ($this->input->post('WILAYAH_1', TRUE) != '') {
				$filter_wilayah = "AND jual.WILAYAH = '$wilayah_1' ";
			}
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$bulan = substr($tgl, 5, 2);
			$tahun = substr($tgl, 0, 4);
			$query = "SELECT URUT, TGL_CETAK, BULAN, TAHUN, KET, KODEC, NAMAC, NO_BUKTI, INVOICE, ROUND(COALESCE(TOTAL, 0)) AS TOTAL FROM
			( SELECT 1 AS URUT,
					DATE_FORMAT('$tgl','%d-%m-%Y') AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN' AS KET,
					jual.KODEC AS KODEC,
					jual.NAMAC AS NAMAC,
					jual.NO_BUKTI AS NO_BUKTI,
					jual.INVOICE AS INVOICE,
					SUM(jual.NETT) AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				$filter_wilayah
				AND jual.FLAG = 'JR'
				GROUP BY jual.NO_BUKTI
				UNION ALL
				SELECT 2 AS URUT,
					DATE_FORMAT('$tgl','%d-%m-%Y') AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'RETUR' AS KET,
					jual.KODEC AS KODEC,
					jual.NAMAC AS NAMAC,
					jual.NO_BUKTI AS NO_BUKTI,
					jual.INVOICE AS INVOICE,
					SUM(jual.NETT) AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				$filter_wilayah
				AND jual.FLAG = 'RJ'
				GROUP BY jual.NO_BUKTI
			) AS AAA ORDER BY KODEC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"URUT" => $row1["URUT"],
					"TGL_CETAK" => $row1["TGL_CETAK"],
					"KET" => $row1["KET"],
					"KODEC" => $row1["KODEC"],
					"NAMAC" => $row1["NAMAC"],
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"INVOICE" => $row1["INVOICE"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'TGL' => set_value('TGL'),
			'WILAYAH_1' => set_value('WILAYAH_1'),
		);
		$data['rincian_penjualan_wilayah'] = $this->Utility_model->tampil_data_index_Utility_CrosscheckDOSJToko()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/Utility_CrosscheckDOSJToko/Utility_CrosscheckDOSJToko', $data);
		$this->load->view('templates_admin/footer_report');
	}
}

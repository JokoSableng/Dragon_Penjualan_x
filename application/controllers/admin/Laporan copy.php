<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
	use \koolreport\export\Exportable;
}

class Laporan extends CI_Controller
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

	public function index_Penjualan_RekapPenjualan()
	{
		if (isset($_POST["print"])) {
		} else {
			$data = array(
				'TGL' => set_value('TGL'),
			);
			$data['penjualan_rekappenjualan'] = $this->laporan_model->tampil_data_penjualan_rekappenjualan()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Penjualan_RekapPenjualan', $data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Penjualan_RekapPenjualanWilayah()
	{
		if (isset($_POST["print"])) {
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Rekap_Penjualan_Wilayah.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$query = " SELECT KET, WILAYAH, DPP, PPN, TOTAL 
						FROM (
							SELECT 'PENJUALAN EXPORT' AS KET,
								jual.WILAYAH AS WILAYAH,
								SUM(jual.DPP) AS DPP,
								SUM(jual.PPN) AS PPN,
								SUM(jual.TOTAL) AS TOTAL
							FROM jual
							WHERE jual.PER = '$per'
							AND jual.EXPORT = 1
							GROUP BY jual.WILAYAH
							UNION ALL
							SELECT 'PENJUALAN MOBIL' AS KET,
								jual.WILAYAH AS WILAYAH,
								SUM(jual.DPP) AS DPP,
								SUM(jual.PPN) AS PPN,
								SUM(jual.TOTAL) AS TOTAL
							FROM jual
							WHERE jual.PER = '$per'
							AND jual.ASET = 1
							GROUP BY jual.WILAYAH
							UNION ALL
							SELECT 'PENJUALAN LAIN' AS KET,
								jual.WILAYAH AS WILAYAH,
								SUM(jual.DPP) AS DPP,
								SUM(jual.PPN) AS PPN,
								SUM(jual.TOTAL) AS TOTAL
							FROM jual
							WHERE jual.PER = '$per'
							AND jual.KDCI = 1
							GROUP BY jual.WILAYAH
							UNION ALL
							SELECT 'PENJUALAN UM' AS KET,
								jual.WILAYAH AS WILAYAH,
								SUM(jual.DPP) AS DPP,
								SUM(jual.PPN) AS PPN,
								SUM(jual.TOTAL) AS TOTAL
							FROM jual
							WHERE jual.PER = '$per'
							AND jual.KDCI = 'U'
							GROUP BY jual.WILAYAH
							UNION ALL
							SELECT 'PENJUALAN LOKAL' AS KET,
								jual.WILAYAH AS WILAYAH,
								SUM(jual.DPP) AS DPP,
								SUM(jual.PPN) AS PPN,
								SUM(jual.TOTAL) AS TOTAL
							FROM jual
							WHERE jual.PER = '$per'
							AND jual.LOKAL = 1
							GROUP BY jual.WILAYAH
							UNION ALL
							SELECT 'PENJUALAN PKP' AS KET,
								jual.WILAYAH AS WILAYAH,
								SUM(jual.DPP) AS DPP,
								SUM(jual.PPN) AS PPN,
								SUM(jual.TOTAL) AS TOTAL
							FROM jual
							WHERE jual.PER = '$per'
							AND jual.TAX = 'P'
							GROUP BY jual.WILAYAH
							UNION ALL
							SELECT 'PENJUALAN PMS' AS KET,
								jual.WILAYAH AS WILAYAH,
								SUM(jual.DPP) AS DPP,
								SUM(jual.PPN) AS PPN,
								SUM(jual.TOTAL) AS TOTAL
							FROM jual
							WHERE jual.PER = '$per'
							AND jual.PMS = 1
							GROUP BY jual.WILAYAH
						) AS AAA
						GROUP BY WILAYAH, KET";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'PER' => set_value('PER'),
			);
			$data['penjualan_rekappenjualanwilayah'] = $this->laporan_model->tampil_data_penjualan_rekappenjualanwilayah()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Penjualan_RekapPenjualanWilayah', $data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Penjualan_RekapPenjualanGolongan()
	{
		if (isset($_POST["print"])) {
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Rekap_Penjualan_Golongan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$query = " SELECT 
						CASE 
							WHEN juald.FLAG = 'JR' THEN 'A. PENJUALAN'
							WHEN juald.FLAG = 'RJ' THEN 'B. RETUR'
						END AS KET,
						CASE 
							WHEN juald.GOL = 1 THEN 'SEPATU INJECT'
							WHEN juald.GOL = 2 THEN 'SEPATU JOGGING/TENNES'
							WHEN juald.GOL = 3 THEN 'SEPATU KARET/FULL PLASTIK'
							WHEN juald.GOL = 4 THEN 'SANDAL JAPIT'
							WHEN juald.GOL = 5 THEN 'SANDAL EVA/GUNUNG/SPON/PHYLON'
							WHEN juald.GOL = 6 THEN 'BAHAN'
							WHEN juald.GOL = 7 THEN 'PVC SHEET'
							WHEN juald.GOL = 8 THEN 'JASA PRODUKSI'
							WHEN juald.GOL = 10 THEN 'PENDAPATAN SEWA'
							WHEN juald.GOL = 12 THEN 'APD'
						END AS GOL,
						SUM(jual.DPP) AS DPP,
						SUM(jual.PPN) AS PPN,
						SUM(jual.TOTAL) AS TOTAL
					FROM jual, juald
					WHERE jual.NO_BUKTI = juald.NO_BUKTI
					AND jual.PER='$per'
					GROUP BY juald.FLAG, juald.GOL";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'PER' => set_value('PER'),
			);
			$data['penjualan_rekappenjualangolongan'] = $this->laporan_model->tampil_data_penjualan_rekappenjualangolongan()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Penjualan_RekapPenjualanGolongan', $data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Penjualan_RincianPenjualanGolongan()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Rincian_Penjualan_Golongan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$query = " SELECT jual.INVOICE AS INVOICE,
						jual.TGL_FKTR AS TGL_FKTR,
						jual.KODEC AS KODEC,
						SUM(juald.QTY) AS QTY,
						SUM(juald.QTYP) AS QTYP,
						CASE 
							WHEN juald.GOL = 1 THEN SUM(jual.TOTAL)
						END AS INJECT,
						CASE 
							WHEN juald.GOL = 2 THEN SUM(jual.TOTAL)
						END AS JOGGING,
						CASE 
							WHEN juald.GOL = 3 THEN SUM(jual.TOTAL)
						END AS KARET,
						CASE 
							WHEN juald.GOL = 4 THEN SUM(jual.TOTAL)
						END AS JAPIT,
						CASE 
							WHEN juald.GOL = 5 THEN SUM(jual.TOTAL)
						END AS EVA,
						CASE 
							WHEN juald.GOL = 6 THEN SUM(jual.TOTAL)
						END AS BAHAN,
						CASE 
							WHEN juald.GOL = 7 THEN SUM(jual.TOTAL)
						END AS PVC,
						CASE 
							WHEN juald.GOL = 8 THEN SUM(jual.TOTAL)
						END AS JASA,
						CASE 
							WHEN juald.GOL = 10 THEN SUM(jual.TOTAL)
						END AS SEWA,
						CASE 
							WHEN juald.GOL = 12 THEN SUM(jual.TOTAL)
						END AS APD
					FROM jual, juald
					WHERE jual.NO_BUKTI = juald.NO_BUKTI
					AND jual.PER='$per'
					GROUP BY jual.INVOICE
					ORDER BY jual.INVOICE";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['penjualan_rincianpenjualangolongan'] = $this->laporan_model->tampil_data_penjualan_rincianpenjualangolongan()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Penjualan_RincianPenjualanGolongan', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Penjualan_RincianPenjualan()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Rincian_Penjualan_Langganan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$kodec_1 = $this->input->post('KODEC_1', TRUE);
			$query = "SELECT jual.TGL AS TGL,
						CONCAT(jual.KODEC,' - ',jual.NAMAC) AS PELANGGAN,
						jual.NO_BUKTI AS NO_BUKTI,
						jual.INVOICE AS INVOICE,
						jual.TGL_FKTR AS TGL_FKTR,
						CASE 
							WHEN jual.FLAG = 'JR' THEN 'A. PENJUALAN'
							WHEN jual.FLAG = 'RJ' THEN 'B. RETUR'
						END AS FLAG,
						SUM(jual.NETT) AS NETT
					FROM jual
					WHERE jual.KODEC = '$kodec_1'
					AND jual.PER='$per'
					GROUP BY jual.KODEC
					ORDER BY jual.TGL, jual.KODEC, jual.NO_BUKTI, jual.FLAG";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'KODEC_1' => set_value('KODEC_1'),
		);
		$data['penjualan_rincianpenjualanlangganan'] = $this->laporan_model->tampil_data_penjualan_rincianpenjualanlangganan()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Penjualan_RincianPenjualanLangganan', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Langganan_RincianPenjualanWilayah()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Rincian_Penjualan_Wilayah.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = "  SELECT jual.KODEC AS KODEC,
						jual.NAMAC AS NAMAC,
						jual.NO_BUKTI AS NO_BUKTI,
						jual.NO_SURAT AS NO_SURAT,
						jual.INVOICE AS INVOICE,
						CASE 
							WHEN jual.FLAG = 'JR' THEN 'A. PENJUALAN'
							WHEN jual.FLAG = 'RJ' THEN 'B. RETUR'
						END AS FLAG,
						jual.NETT AS NETT
					FROM jual
					WHERE jual.WILAYAH = '$wilayah_1'
					AND jual.PER='$per'
					ORDER BY jual.KODEC, jual.NO_BUKTI";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'WILAYAH_1' => set_value('WILAYAH_1'),
		);
		$data['penjualan_rincianpenjualanwilayah'] = $this->laporan_model->tampil_data_penjualan_rincianpenjualanwilayah()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Penjualan_RincianPenjualanWilayah', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Langganan_RincianPenjualanPMS()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Rincian_penjualan_PMS.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT jual.TGL AS TGL,
						jual.NO_BUKTI AS NO_BUKTI,
						'-' AS URAIAN,
						(jual.TOTAL+jual.TDISK) AS BRUTO,
						jual.TDISK AS TDISK,
						jual.NETT AS NETT
					FROM jual
					WHERE jual.WILAYAH = '$wilayah_1'
					AND jual.PER='$per'
					AND jual.PMS = 1
					ORDER BY jual.TGL, jual.NO_BUKTI";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'WILAYAH_1' => set_value('WILAYAH_1'),
		);
		$data['penjualan_registerpenjualanpms'] = $this->laporan_model->tampil_data_penjualan_registerpenjualanpms()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Penjualan_RegisterPenjualanPMS', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Penjualan_SuratJalan()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Surat_Jalan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'WILAYAH_1' => set_value('WILAYAH_1'),
		);
		$data['penjualan_suratjalan'] = $this->laporan_model->tampil_data_penjualan_suratjalan()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Penjualan_SuratJalan', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Pembayaran_PembayaranNotaToko()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Pembayaran_Nota_Toko.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['pembayaran_nota_toko'] = $this->laporan_model->tampil_data_pembayaran_nota_toko()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Pembayaran_Nota_Toko', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Pembayaran_PembayaranNotaWilayah()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Pembayaran_Nota_Wilayah.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['pembayaran_nota_wilayah'] = $this->laporan_model->tampil_data_pembayaran_nota_wilayah()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Pembayaran_Nota_wilayah', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Pembayaran_RekapPembayaranWilayah()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Pembayaran_Wilayah.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['rekap_pembayaran_wilayah'] = $this->laporan_model->tampil_data_rekap_pembayaran_wilayah()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/rekap_Pembayaran_wilayah', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_SisaNota()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Sisa_Nota.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['sisa_nota'] = $this->laporan_model->tampil_data_sisa_nota()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/sisa_nota', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_SisaNotaWilayah()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Sisa_Nota_Wilayah.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['sisanotawilayah'] = $this->laporan_model->tampil_data_sisa_nota_wilayah()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/sisa_nota_wilayah', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Piutang()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Piutang.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['piutang'] = $this->laporan_model->tampil_data_piutang()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/piutang', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_PiutangWilayah()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Piutang_Wilayah.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['piutangwilayah'] = $this->laporan_model->tampil_data_piutang_wilayah()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/piutang_wilayah', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_KartuPiutang()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Kartu_Piutang.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['kartupiutang'] = $this->laporan_model->tampil_data_kartu_piutang()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/kartu_piutang', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_OmzetPms()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['omzetpms'] = $this->laporan_model->tampil_data_omzet_pms()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Omzet_pms', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_OmzetJenis()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['omzetjenis'] = $this->laporan_model->tampil_data_omzet_jenis()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Omzet_jenis', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_SuratPesanan()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Surat_Pesanan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['suratpesanan'] = $this->laporan_model->tampil_data_surat_pesanan()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Laporan_Surat_Pesanan', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Do()
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
			$PHPJasperXML->load_xml_file("phpjasperxml/.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$query = " SELECT surats.NO_BUKTI AS NO_BUKTI,
						surats.WILAYAH AS WILAYAH,
						surats.JTEMPO AS JTEMPO,
						surats.TGL AS TGL,
						surats.NAMAC AS NAMAC,
						surats.ALAMAT AS ALAMAT,
						surats.KOTA AS KOTA,
						surats.NOPOL AS NOPOL,
						suratsd.REC AS REC,
						suratsd.KD_BRG AS KD_BRG,
						suratsd.QTY AS QTY,
						suratsd.QTYP AS QTYP
					FROM surats, suratsd
					WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
					AND surats.WILAYAH = '$wilayah_1'
					AND surats.PER='$per'
					AND surats.FLAG = 'GDG'
					AND surats.FLAG2 = 'SJ'
					AND surats.JUAL = 1
					ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['do'] = $this->laporan_model->tampil_data_do()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Laporan_Do', $data);
		$this->load->view('templates_admin/footer_report');
	}



	//////		AJAX MASTER		/////

	public function getData_master_cust_kodec_1()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT NO_ID as NO_ID, KODEC as KODEC_1
			FROM cust
			WHERE KODEC LIKE '%$search%'
			GROUP BY KODEC
			ORDER BY KODEC LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KODEC_1'],
				'text' => $row['KODEC_1']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_master_cust_kodec_2()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT NO_ID as NO_ID, KODEC as KODEC_2
			FROM cust
			WHERE KODEC LIKE '%$search%'
			GROUP BY KODEC
			ORDER BY KODEC LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KODEC_2'],
				'text' => $row['KODEC_2']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_master_cust_koderay_1()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT NO_ID as NO_ID, KODERAY as KODERAY_1
			FROM cust
			WHERE KODERAY LIKE '%$search%'
			GROUP BY KODERAY
			ORDER BY KODERAY LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KODERAY_1'],
				'text' => $row['KODERAY_1']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_master_cust_koderay_2()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT NO_ID as NO_ID, KODERAY as KODERAY_2
			FROM cust
			WHERE KODERAY LIKE '%$search%'
			GROUP BY KODERAY
			ORDER BY KODERAY LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KODERAY_2'],
				'text' => $row['KODERAY_2']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_master_wilayah_wilayah_1()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT NO_ID as NO_ID, WILAYAH as WILAYAH_1
			FROM wilayah
			WHERE WILAYAH LIKE '%$search%'
			GROUP BY WILAYAH
			ORDER BY WILAYAH LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['WILAYAH_1'],
				'text' => $row['WILAYAH_1']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	//////		BATAS AJAX MASTER		/////

	//////		AJAX KDMTS JL_CIHDR		/////

	public function getData_jl_cihdr_kdmts()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT '' as KDMTS_1,'' as ROW_ID UNION ALL SELECT kdmts, row_id
			FROM jl_cihdr
			WHERE kdmts LIKE '%$search%' 
			GROUP BY kdmts
			ORDER BY row_id LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KDMTS_1'],
				'text' => $row['KDMTS_1'],
				'kdmts' => $row['KDMTS_1'],
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	//////		BATAS KDMTS JL_CIHDR		/////

	//////		AJAX KDMTS JL_BAYAR		/////

	public function getData_jl_bayar_nobkk()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT '' as NOBKK_1,'' as ROW_ID UNION ALL SELECT nobkk, row_id
			FROM jl_bayar
			WHERE nobkk LIKE '%$search%' 
			GROUP BY nobkk
			ORDER BY row_id LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['NOBKK_1'],
				'text' => $row['NOBKK_1'],
				'nobkk' => $row['NOBKK_1'],
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_sisa_nota_kodec_1()
	{
		$wilayah = $this->session->userdata['wilayah'];
		$per = $this->session->userdata['periode'];
		$fase = $this->session->userdata['fase'];
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT KODEC AS KODEC_1
			FROM cust
			WHERE MUTASI = 1 AND (KODEC LIKE '%$search%')
			GROUP BY KODEC
			ORDER BY KODEC LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KODEC_1'],
				'text' => $row['KODEC_1'],
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	//////		BATAS NOBKK JL_BAYAR		/////


}

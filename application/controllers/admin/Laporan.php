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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Penjualan_RekapPenjualan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$bulan = substr($tgl, 5, 2);
			$tahun = substr($tgl, 0, 4);
			$query = "SELECT URUT, TGL_CETAK, BULAN, TAHUN, KET, ROUND(COALESCE(DPP, 0)) AS DPP, ROUND(COALESCE(PPN, 0)) AS PPN, ROUND(COALESCE(DPP+PPN, 0)) AS TOTAL FROM
			( SELECT 1 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN EXPORT' AS KET,
					SUM(jual.NETT) AS DPP,
					0 AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				AND jual.FLAG = 'JR'
				AND jual.EXPORT = 1
				-- GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 2 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN MOBIL' AS KET,
					SUM(jual.NETT) AS DPP,
					0 AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				AND jual.FLAG = 'JR'
				AND jual.ASET = 1
				-- GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 3 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN LOKAL PKP' AS KET,
					SUM(jual.NETT/1.1) AS DPP,
					SUM(jual.NETT-(jual.NETT/1.1)) AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				AND jual.FLAG = 'JR'
				AND jual.TAX = 'P'
				AND jual.EXPORT <> 1
				AND jual.ASET <> 1
				-- GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 4 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN LOKAL NON PKP' AS KET,
					SUM(jual.NETT/1.1) AS DPP,
					SUM(jual.NETT-(jual.NETT/1.1)) AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				AND jual.FLAG = 'JR'
				AND jual.TAX <> 'P'
				AND jual.EXPORT <> 1
				AND jual.ASET <> 1
				-- GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 5 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN RETUR' AS KET,
					SUM((jual.NETT/1.1)*-1) AS DPP,
					SUM((jual.NETT-(jual.NETT/1.1))*-1) AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_PMS) = '$bulan'
				AND YEAR(jual.TGL_PMS) = '$tahun'
				AND jual.FLAG = 'RJ'
				-- GROUP BY jual.WILAYAH
			) AS AAA WHERE DPP<>0 GROUP BY KET ORDER BY URUT ";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"TGL_CETAK" => $row1["TGL_CETAK"],
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
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
			$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
			$per = $setbulan . '/' . $settahun;
			$query = "SELECT '$tgl' TGL,'A.PENJUALA EXPORT' KET, WILAYAH, SUM(TOTAL) DPP, '0' PPN, SUM(TOTAL) TOTAL  FROM jual WHERE PER = '$per' AND FLAG = 'JR' AND EXPORT = '1' GROUP BY WILAYAH
						UNION ALL
						SELECT '$tgl' TGL,'B.PENJUALA PMS' KET, WILAYAH, SUM(NETT/1.1) DPP, SUM(NETT-(NETT/1.1)) PPN, SUM(NETT) TOTAL  FROM jual 
						WHERE PER = '$per' AND FLAG = 'JR' AND PMS = '1' AND EXPORT <> '1' AND ASET <> '1' AND NO_BUKTI NOT LIKE '%UM%' AND NO_BUKTI NOT LIKE '%IDST%' GROUP BY WILAYAH
						UNION ALL
						SELECT '$tgl' TGL,'C.PENJUALA LOKAL' KET, WILAYAH, SUM(NETT/1.1) DPP, SUM(NETT-(NETT/1.1)) PPN, SUM(NETT) TOTAL  FROM jual 
						WHERE PER = '$per' AND FLAG = 'JR'  AND EXPORT <> '1' AND ASET <> '1'  AND NO_BUKTI LIKE '%IDST%' GROUP BY WILAYAH
						UNION ALL
						SELECT '$tgl' TGL,'D.PENJUALAN UM' KET, WILAYAH, SUM(NETT/1.1) DPP, SUM(NETT-(NETT/1.1)) PPN, SUM(NETT) TOTAL  FROM jual 
						WHERE PER = '$per' AND FLAG = 'JR'  AND EXPORT <> '1' AND ASET <> '1'  AND NO_BUKTI LIKE '%UM%' GROUP BY WILAYAH
						UNION ALL
						SELECT '$tgl' TGL,'E.RETUR' KET, WILAYAH, (SUM(NETT/1.1)-(SUM(NETT/1.1)*2)) DPP, (SUM(NETT-(NETT/1.1))-(SUM(NETT-(NETT/1.1))*2)) PPN, (SUM(NETT)-(SUM(NETT)*2)) TOTAL  FROM jual 
						WHERE PER = '$per' AND FLAG = 'RJ'  GROUP BY WILAYAH";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KET" => $row1["KET"],
					"TGL" => $row1["TGL"],
					"WILAYAH" => $row1["WILAYAH"],
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Penjualan_RekapPenjualanGolongan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$bulan = substr($tgl, 5, 2);
			$tahun = substr($tgl, 0, 4);
			$query = "SELECT URUT, TGL_CETAK, BULAN, TAHUN, KET, GOL, ROUND(COALESCE(DPP, 0)) AS DPP, ROUND(COALESCE(PPN, 0)) AS PPN, ROUND(COALESCE(DPP+PPN, 0)) AS TOTAL FROM
			( SELECT 1 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'A. PENJUALAN' AS KET,
					CASE 
						WHEN goljual.GOL = '1' THEN 'SEPATU INJECT'
						WHEN goljual.GOL = '2' THEN 'SEPATU JOGGING/TENNES'
						WHEN goljual.GOL = '3' THEN 'SEPATU KARET/FULL PLASTIK'
						WHEN goljual.GOL = '4' THEN 'SANDAL JAPIT'
						WHEN goljual.GOL = '5' THEN 'SANDAL EVA/GUNUNG/SPON/PHYLON'
						WHEN goljual.GOL = '6' THEN 'BAHAN'
						WHEN goljual.GOL = '7' THEN 'PVC SHEET'
						WHEN goljual.GOL = '8' THEN 'JASA PRODUKSI'
						WHEN goljual.GOL = '10' THEN 'PENDAPATAN SEWA'
						WHEN goljual.GOL = '12' THEN 'APD'
						ELSE 'X'
					END AS GOL,
					SUM(goljual.TOTAL/1.1) AS DPP,
					SUM(goljual.TOTAL-(goljual.TOTAL/1.1)) AS PPN,
					0 AS TOTAL
				FROM goljual
				WHERE MONTH(goljual.TGL_FKTR) = '$bulan'
				AND YEAR(goljual.TGL_FKTR) = '$tahun'
				AND goljual.RETUR <> 'T'
				GROUP BY goljual.GOL
				UNION ALL
				SELECT 2 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'B. RETUR' AS KET,
					CASE 
						WHEN goljual.GOL = '1' THEN 'SEPATU INJECT'
						WHEN goljual.GOL = '2' THEN 'SEPATU JOGGING/TENNES'
						WHEN goljual.GOL = '3' THEN 'SEPATU KARET/FULL PLASTIK'
						WHEN goljual.GOL = '4' THEN 'SANDAL JAPIT'
						WHEN goljual.GOL = '5' THEN 'SANDAL EVA/GUNUNG/SPON/PHYLON'
						WHEN goljual.GOL = '6' THEN 'BAHAN'
						WHEN goljual.GOL = '7' THEN 'PVC SHEET'
						WHEN goljual.GOL = '8' THEN 'JASA PRODUKSI'
						WHEN goljual.GOL = '10' THEN 'PENDAPATAN SEWA'
						WHEN goljual.GOL = '12' THEN 'APD'
						ELSE 'X'
					END AS GOL,
					SUM(goljual.TOTAL/1.1) AS DPP,
					SUM(goljual.TOTAL-(goljual.TOTAL/1.1)) AS PPN,
					0 AS TOTAL
				FROM goljual
				WHERE MONTH(goljual.TGL_FKTR) = '$bulan'
				AND YEAR(goljual.TGL_FKTR) = '$tahun'
				AND goljual.RETUR = 'T'
				GROUP BY goljual.GOL
			) AS AAA WHERE DPP<>0 AND GOL<>'X' GROUP BY KET, GOL ORDER BY URUT, KET ";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"URUT" => $row1["URUT"],
					"TGL_CETAK" => $row1["TGL_CETAK"],
					"KET" => $row1["KET"],
					"GOL" => $row1["GOL"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["TOTAL"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'TGL' => set_value('TGL'),
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
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
			$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
			$per = $setbulan . '/' . $settahun;
			$query = "SELECT TGL_FKTR, INVOICE, KODEC, SUM(QTY) QTY, SUM(QTYP) QTYP, (if(GOL=1,SUM(TOTAL),0)) INJECT, (if(GOL=2,SUM(TOTAL),0)) JOGG_TENNES, 
						(if(GOL=3,SUM(TOTAL),0)) KARET_FPLASTIK, (if(GOL=4,SUM(TOTAL),0)) JAPIT, 
						(if(GOL=5,SUM(TOTAL),0)) EVA_SPON, (if(GOL=6,SUM(TOTAL),0)) APD_MASKER, (if(GOL=7,SUM(TOTAL),0)) PVC_SHEET, (if(GOL=8,SUM(TOTAL),0)) SOL_JPROD, 
						SUM(TOTAL/1.1) DPP, SUM(TOTAL-(TOTAL/1.1)) PPN, SUM(TOTAL) JUMLAH 
						FROM goljual WHERE MONTH(TGL_FKTR)='$setbulan' AND YEAR(TGL_FKTR) = '$settahun' GROUP BY INVOICE  ORDER BY INVOICE";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"TGFAK" => $row1["TGL_FKTR"],
					"INVOICE" => $row1["INVOICE"],
					"KDCUST" => $row1["KODEC"],
					"LUSIN" => $row1["QTY"],
					"PAIR" => $row1["QTYP"],
					"GOL1" => $row1["INJECT"],
					"GOL2" => $row1["JOGG_TENNES"],
					"GOL3" => $row1["KARET_FPLASTIK"],
					"GOL4" => $row1["JAPIT"],
					"GOL5" => $row1["EVA_SPON"],
					"GOL6" => $row1["APD_MASKER"],
					"GOL7" => $row1["PVC_SHEET"],
					"GOL8" => $row1["SOL_JPROD"],
					"DPP" => $row1["DPP"],
					"PPN" => $row1["PPN"],
					"TOTAL" => $row1["JUMLAH"],
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Rekap_Penjualan_Langganan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
			$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
			$per = $setbulan . '/' . $settahun;
			$query = "SELECT '$TGL' TGLX, a.NO_BUKTI, a.TGL TANGGAL, a.INVOICE INVOICE, a.TGL TGL_INVOICE, a.NETT, a.KODEC, a.NAMAC
						FROM jual a WHERE  a.PER = '$per' AND a.FLAG = 'JR' ORDER BY KODEC,NO_BUKTI";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"TGL" => $row1["TANGGAL"],
					"TGL_INVOICE" => $row1["TGL_INVOICE"],
					"INVOICE" => $row1["INVOICE"],
					"NETT" => $row1["NETT"],
					"KODEC" => $row1["KODEC"],
					"NAMAC" => $row1["NAMAC"],
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
		$data['langganan_rincianpenjualanwilayah'] = $this->laporan_model->tampil_data_langganan_rincianpenjualanwilayah()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Langganan_RincianPenjualanWilayah', $data);
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Langganan_RincianPenjualanPMS.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$perke = $this->input->post('PERKE', TRUE);
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$filter_wilayah = " ";
			if ($this->input->post('WILAYAH_1', TRUE) != '') {
				$filter_wilayah = "AND jual.WILAYAH = '$wilayah_1' ";
			}
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$bulan = substr($tgl, 5, 2);
			$tahun = substr($tgl, 0, 4);
			$query = " SELECT jual.WILAYAH AS WILAYAH,
				CASE 
					WHEN jual.WILAYAH = '66' THEN 'PMS INDOTIM'
					WHEN jual.WILAYAH = '77' THEN 'PMS JATIM B'
					WHEN jual.WILAYAH = '88' THEN 'PMS CAKRA'
					WHEN jual.WILAYAH = '90' THEN 'PMS ONLINE'
					WHEN jual.WILAYAH = '91' THEN 'PMS JATIM'
					WHEN jual.WILAYAH = '92' THEN 'PMS JATENG'
					WHEN jual.WILAYAH = '93' THEN 'PMS JAKARTA'
					WHEN jual.WILAYAH = '94' THEN 'PMS LAMPUNG'
					WHEN jual.WILAYAH = '95' THEN 'PMS PALEMBANG'
					WHEN jual.WILAYAH = '96' THEN 'PMS PEKANBARU'
					WHEN jual.WILAYAH = '97' THEN 'PMS PADANG'
					WHEN jual.WILAYAH = '98' THEN 'PMS MEDAN'
					WHEN jual.WILAYAH = '100' THEN 'PMS BANDUNG'
					ELSE '-'
				END AS HEADERWILAYAH,
				jual.NO_BUKTI AS NO_BUKTI,
				jual.PERKE AS PERKE,
				DATE_FORMAT('$tgl','%d-%m-%Y') AS TGL_CETAK,
				DATE_FORMAT(jual.TGL,'%d-%m-%Y') AS TGL,
				jual.TOTAL AS BRUTO,
				jual.TDISK AS TDISK,
				jual.NETT AS NETT
			FROM jual
			WHERE MONTH(jual.TGL) = '$bulan'
			AND YEAR(jual.TGL) = '$tahun'
			AND jual.TGL <= '$tgl'
			AND jual.PERKE = '$perke'
			$filter_wilayah
			AND jual.FLAG = 'JR'
			AND jual.PMS = 1
			ORDER BY jual.WILAYAH, jual.NO_BUKTI, jual.NO_BUKTI";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"WILAYAH" => $row1["WILAYAH"],
					"HEADERWILAYAH" => $row1["HEADERWILAYAH"],
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"PERKE" => $row1["PERKE"],
					"TGL_CETAK" => $row1["TGL_CETAK"],
					"TGL" => $row1["TGL"],
					"BRUTO" => $row1["BRUTO"],
					"TDISK" => $row1["TDISK"],
					"NETT" => $row1["NETT"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PERKE' => set_value('PERKE'),
			'TGL' => set_value('TGL'),
			'WILAYAH_1' => set_value('WILAYAH_1'),
		);
		$data['langganan_rincianpenjualanpms'] = $this->laporan_model->tampil_data_langganan_rincianpenjualanpms()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Langganan_RincianPenjualanPMS', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Penjualan_SuratJalan()
	{
		if ($this->input->post('print', true)) {
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
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
			$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
			$per = $setbulan . '/' . $settahun;
			$query = "SELECT $tgl AS CETAK,c.KODEC, c.NAMAC, a.NO_BUKTI, a.TGL, b.NO_SURAT,C.TGL_FKTR, c.SISA AS TOTAL, b.TOTAL BAYAR  
						FROM piu a, piud b, jual c
						WHERE a.NO_BUKTI = b.NO_BUKTI AND b.NO_SURAT = c.NO_BUKTI AND a.PER = '$per' 
						ORDER BY KODEC,NO_SURAT";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"TGL" => $row1["TGL"],
					"TGL_FKTR" => $row1["TGL_FKTR"],
					"INVOICE" => $row1["INVOICE"],
					"NO_SURAT" => $row1["NO_SURAT"],
					"KODEC" => $row1["KODEC"],
					"NAMAC" => $row1["NAMAC"],
					"TOTAL" => $row1["TOTAL"],
					"BAYAR" => $row1["BAYAR"],
					"CETAK" => date("d-m-Y", strtotime($row1["CETAK"])),
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
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
			$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
			$wilayah = $this->input->post('KDMTS', TRUE);
			$per = $setbulan . '/' . $settahun;
			$query = "SELECT c.KODEC, c.NAMAC, a.NO_BUKTI, a.TGL, b.NO_SURAT,C.TGL_FKTR, c.SISA AS TOTAL, b.TOTAL AS BAYAR  
						FROM piu a, piud b, jual c
						WHERE a.NO_BUKTI = b.NO_BUKTI AND b.NO_SURAT = c.NO_BUKTI AND a.PER = '$per' AND a.WILAYAH = '$wilayah'
						ORDER BY a.NO_BUKTI";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"TGL" => $row1["TGL"],
					"TGL_FKTR" => $row1["TGL_FKTR"],
					"INVOICE" => $row1["INVOICE"],
					"NO_SURAT" => $row1["NO_SURAT"],
					"KODEC" => $row1["KODEC"],
					"NAMAC" => $row1["NAMAC"],
					"TOTAL" => $row1["TOTAL"],
					"BAYAR" => $row1["BAYAR"],
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
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
			$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
			$wilayah = $this->input->post('KDMTS', TRUE);
			$per = $this->input->post('PER', TRUE);
			$query = "SELECT '$per' AS PER,WILAYAH KDMTS,KODEC,SUM(TOTAL) AS TOTAL 
						FROM piud
						WHERE PER = '$per' AND TANDA='' AND WILAYAH <> ''
						GROUP BY kdmts";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"TGL" => $row1["TGL"],
					"TGL_FKTR" => $row1["TGL_FKTR"],
					"INVOICE" => $row1["INVOICE"],
					"NO_SURAT" => $row1["NO_SURAT"],
					"KODEC" => $row1["KODEC"],
					"NAMAC" => $row1["NAMAC"],
					// "TOTAL" => $row1["TOTAL"],
					"TOTAL" => $row1["TOTAL"],
					"KDMTS" => $row1["KDMTS"],
					"PER" => $row1["PER"],
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_SisaNota.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$bulan = substr($tgl, 5, 2);
			$tahun = substr($tgl, 0, 4);
			$jenis = $this->input->post('JENIS', TRUE);
			$query = " SELECT jual.KODEC AS KODEC,
				jual.INVOICE AS INVOICE,
				DATE_FORMAT('$tgl','%d-%m-%Y') AS TGL,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.SISA AS SISA,
				jual.NO_BUKTI AS NO_BUKTI
			FROM jual
			WHERE MONTH(jual.TGL_FKTR) = '$bulan'
			AND YEAR(jual.TGL_FKTR) = '$tahun'
			AND jual.TGL_FKTR <= '$tgl'
			AND jual.FLAG = 'JR'
			ORDER BY jual.KODEC, jual.NO_BUKTI";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KODEC" => $row1["KODEC"],
					"INVOICE" => $row1["INVOICE"],
					"TGL" => $row1["TGL"],
					"TGL_FKTR" => $row1["TGL_FKTR"],
					"SISA" => $row1["SISA"],
					"NO_BUKTI" => $row1["NO_BUKTI"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'TGL' => set_value('TGL'),
			'JENIS' => set_value('JENIS'),
		);
		$data['sisanota'] = $this->laporan_model->tampil_data_sisanota()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/SisaNota', $data);
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_SisaNotaWilayah.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$bulan = substr($tgl, 5, 2);
			$tahun = substr($tgl, 0, 4);
			$jenis = $this->input->post('JENIS', TRUE);
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$filter_wilayah = " ";
			if ($this->input->post('WILAYAH_1', TRUE) != '') {
				$filter_wilayah = "AND jual.WILAYAH = '$wilayah_1' ";
			}
			$query = " SELECT jual.WILAYAH AS WILAYAH, 
				jual.KODEC AS KODEC,
				jual.INVOICE AS INVOICE,
				DATE_FORMAT('$tgl','%d-%m-%Y') AS TGL_CETAK,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.SISA AS SISA,
				jual.NO_BUKTI AS NO_BUKTI
			FROM jual
			WHERE MONTH(jual.TGL_FKTR) = '$bulan'
			AND YEAR(jual.TGL_FKTR) = '$tahun'
			AND jual.TGL_FKTR <= '$tgl'
			AND jual.FLAG = 'JR'
			AND jual.PMS = 1
			$filter_wilayah
			ORDER BY jual.KODEC, jual.TGL_FKTR, jual.NO_BUKTI";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"WILAYAH" => $row1["WILAYAH"],
					"KODEC" => $row1["KODEC"],
					"INVOICE" => $row1["INVOICE"],
					"TGL_CETAK" => $row1["TGL_CETAK"],
					"TGL_FKTR" => $row1["TGL_FKTR"],
					"SISA" => $row1["SISA"],
					"NO_BUKTI" => $row1["NO_BUKTI"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'TGL' => set_value('TGL'),
			'JENIS' => set_value('JENIS'),
			'WILAYAH_1' => set_value('WILAYAH_1'),
		);
		$data['sisanotawilayah'] = $this->laporan_model->tampil_data_sisanotawilayah()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/SisaNotaWilayah', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_Piutang()
	{
		if ($this->input->post('print', true)) {
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
			$plh = $this->input->post('PLH', TRUE);
			if ($plh == 1) {
				$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Omzet_PMS.jrxml");
			} else {
				$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Omzet_PMS_Semua.jrxml");
			}
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);

			$per = $this->session->userdata['periode'];
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$nama_wilayah = $this->input->post('NAMA_WIL', TRUE);

			if ($plh == 1) {
				$query = "SELECT '$wilayah_1' PMS, PER, PERKE, SUM(NETT) TOTAL,0 PERIODE_A ,0 PERIODE_B,0 LOKAL ,0 EXPORT FROM pms_surats WHERE PER = '$per' AND WILAYAH = '$wilayah_1' AND POSTED = '1' GROUP BY PERKE";
			} else {
				$query = "SELECT '$per' PER, z.*,(z.PERIODE_A + z.PERIODE_B + z.LOKAL + z.EXPORT) TOTAL FROM(
					SELECT a.WILAYAH PMS, COALESCE(b.PERIODE_A,0) PERIODE_A, COALESCE(c.PERIODE_B,0) PERIODE_B, COALESCE(d.LOKAL,0) LOKAL, COALESCE(e.EXPORT,0) EXPORT FROM wilayah a
					LEFT JOIN 
					(SELECT WILAYAH AS PMS, SUM(NETT) PERIODE_A FROM pms_surats WHERE PER = '$per'  AND PERKE = '1' GROUP BY WILAYAH) b
					ON a.WILAYAH = b.PMS
					LEFT JOIN 
					(SELECT WILAYAH AS PMS, SUM(NETT) PERIODE_B FROM pms_surats WHERE PER = '$per'  AND PERKE = '2' GROUP BY WILAYAH) c
					ON a.WILAYAH = c.PMS
					LEFT JOIN 
					(SELECT WILAYAH AS PMS, SUM(NETT) LOKAL FROM jual WHERE PER = '$per' AND NO_BUKTI LIKE '%IDST%' GROUP BY WILAYAH) d
					ON a.WILAYAH = d.PMS
					LEFT JOIN 
					(SELECT WILAYAH AS PMS, SUM(NETT) EXPORT FROM jual WHERE PER = '$per' AND EXPORT = '1' GROUP BY WILAYAH) e
					ON a.WILAYAH = e.PMS) z ORDER BY z.PMS ASC;";
			}

			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"PMS" => $row1["PMS"],
					"NAMA_WILAYAH" => $nama_wilayah,
					"PER" => $row1["PER"],
					"PERKE" => $row1["PERKE"],
					"TOTAL" => $row1["TOTAL"],
					"PERIODE_A" => $row1["PERIODE_A"],
					"PERIODE_B" => $row1["PERIODE_B"],
					"LOKAL" => $row1["LOKAL"],
					"EXPORT" => $row1["EXPORT"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'PER' => set_value('PER'),
			'WILAYAH_1' => set_value('WILAYAH_1'),
			'NAMA_WIL' => set_value('NAMA_WIL'),
			'PLH' => set_value('PLH'),
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
		}
		$data = array(
			'PER' => set_value('PER'),
		);
		$data['omzetjenis'] = $this->laporan_model->tampil_data_omzetjenis()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/OmzetJenis', $data);
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
			$lokal = $this->input->post('LOKAL', TRUE);
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$filter_wilayah = " ";
			if ($this->input->post('WILAYAH_1', TRUE) != '') {
				$filter_wilayah = "AND so.WILAYAH = '$wilayah_1' ";
			}
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$cetak = date("d-m-Y", strtotime($this->input->post('TGL', TRUE)));
			$bulan = substr($tgl, 5, 2);
			$tahun = substr($tgl, 0, 4);
			$query = " SELECT so.WILAYAH AS WILAYAH, 
							so.NO_BUKTI AS NO_BUKTI,
							'$cetak' AS CETAK,
							DATE_FORMAT(so.TGL,'%d-%m-%Y') AS TGL,
							sod.KODEC AS KODEC,
							sod.NAMAC AS NAMAC,
							sod.KD_BRG AS KD_BRG,
							sod.QTY AS QTY,
							sod.QTYP AS QTYP,
							wilayah.WILAYAH1
						FROM so, sod, wilayah
						WHERE so.NO_BUKTI = sod.NO_BUKTI 
						AND so.WILAYAH = wilayah.WILAYAH
						AND MONTH(so.TGL) = '$bulan'
						AND YEAR(so.TGL) = '$tahun'
						$filter_wilayah
						AND so.FLAG = 'PMS'
						AND so.FLAG2 = 'PJ'
						ORDER BY so.NO_BUKTI, so.NO_BUKTI, sod.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KDMTS" => $row1["WILAYAH"],
					"KODECUS" => $row1["KODEC"],
					"NAMAC" => $row1["NAMAC"],
					"ARTICLE" => $row1["KD_BRG"],
					"LUSIN" => $row1["QTY"],
					"PAIR" => $row1["QTYP"],
					"WILAYAH1" => $row1["WILAYAH1"],
					"CETAK" => $row1["CETAK"],
					"NO_SP" => $row1["NO_BUKTI"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'TGL' => set_value('TGL'),
			'WILAYAH_1' => set_value('WILAYAH_1'),
			'LOKAL' => set_value('LOKAL'),
		);
		$data['suratpesanan'] = $this->laporan_model->tampil_data_suratpesanan()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/laporan/Laporan_SuratPesanan', $data);
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
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_DO.jrxml");
			$PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
			$lokal = $this->input->post('LOKAL', TRUE);
			$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
			$filter_wilayah = " ";
			if ($this->input->post('WILAYAH_1', TRUE) != '') {
				$filter_wilayah = "AND so.WILAYAH = '$wilayah_1' ";
			}
			$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
			$bulan = substr($tgl, 5, 2);
			$tahun = substr($tgl, 0, 4);
			$query = " SELECT so.WILAYAH AS WILAYAH, 
							so.NO_BUKTI AS NO_BUKTI,
							DATE_FORMAT(so.TGL,'%d-%m-%Y') AS TGL,
							so.NO_DO AS NO_DO,
							DATE_FORMAT(so.TGL_DO,'%d-%m-%Y') AS TGL_DO,
							sod.KODEC AS KODEC,
							sod.NAMAC AS NAMAC,
							sod.KD_BRG AS KD_BRG,
							sod.QTY AS QTY,
							sod.QTYP AS QTYP,
							wilayah.WILAYAH1 AS WILAYAH1
						FROM so, sod, wilayah
						WHERE so.NO_BUKTI = sod.NO_BUKTI 
						AND so.WILAYAH = wilayah.WILAYAH
						AND MONTH(so.TGL_DO) = '$bulan'
						AND YEAR(so.TGL_DO) = '$tahun'
						$filter_wilayah
						AND so.FLAG = 'PMS'
						AND so.FLAG2 = 'PJ'
						ORDER BY so.NO_DO, so.NO_BUKTI, sod.REC";
			$result1 = mysqli_query($conn, $query);
			while ($row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KDMTS" => $row1["WILAYAH1"],
					"KODECUS" => $row1["KODEC"],
					"NAMAC" => $row1["NAMAC"],
					"ARTICLE" => $row1["KD_BRG"],
					"LUSIN" => $row1["QTY"],
					"PAIR" => $row1["QTYP"],
					"TGL_SP" => $row1["TGL"],
					"NODO" => $row1["NO_DO"],
					"NO_SP" => $row1["NO_BUKTI"],
				));
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		}
		$data = array(
			'TGL' => set_value('TGL'),
			'WILAYAH_1' => set_value('WILAYAH_1'),
			'LOKAL' => set_value('LOKAL'),
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
		$results = $this->db->query("SELECT NO_ID as NO_ID, WILAYAH as WILAYAH_1, WILAYAH1 as NAMA
			FROM wilayah
			WHERE WILAYAH LIKE '%$search%'
			GROUP BY WILAYAH
			ORDER BY WILAYAH LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['WILAYAH_1'],
				'text' => $row['WILAYAH_1'] . " - " . $row['NAMA'],
				'nama' => $row['NAMA'],
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_no_bukti_po_1()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT NO_ID as NO_ID, NO_BUKTI as NO_BUKTI_1
			FROM SO
			WHERE NO_BUKTI LIKE '%$search%'
			GROUP BY NO_BUKTI
			ORDER BY NO_BUKTI LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['NO_BUKTI_1'],
				'text' => $row['NO_BUKTI_1']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_no_bukti_po_2()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT NO_ID as NO_ID, NO_BUKTI as NO_BUKTI_2
			FROM SO
			WHERE NO_BUKTI LIKE '%$search%'
			GROUP BY NO_BUKTI
			ORDER BY NO_BUKTI LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['NO_BUKTI_2'],
				'text' => $row['NO_BUKTI_2']
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

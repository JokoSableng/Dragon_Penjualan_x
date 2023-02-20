<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
	use \koolreport\export\Exportable;
}

class Utility_PostinganSJ extends CI_Controller
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

	public function index_Utility_PostinganSJ()
	{
		if (isset($_POST["print"])) {
		} else {
			$pilih = $this->input->post('option', TRUE);
			$per = $this->session->userdata['periode'];

			if ($pilih == 1) {
				$this->db->query("TRUNCATE TABLE urut");
				$this->db->query("INSERT INTO URUT (NO_DO,TGL,WILAYAH) SELECT NO_DO,TGL,WILAYAH FROM jual WHERE PER = '$per' ORDER BY NO_DO ASC");

				$data = array(
					'TGL' => set_value('TGL'),
				);
				$data['CekNomorDOLoncat'] = $this->db->query("SELECT *,if((left(NO_DO,6)-NO_ID)=0,'SAMA','TDAK') AS TANDA FROM urut")->result();
			} elseif ($pilih == 2) {
				$this->db->query("TRUNCATE TABLE urut");
				$this->db->query("INSERT INTO URUT (NO_DO,TGL,WILAYAH) SELECT NO_DO,TGL,WILAYAH FROM jual WHERE PER = '$per' ORDER BY NO_DO ASC");

				$data = array(
					'TGL' => set_value('TGL'),
				);
				$data['CekNomorDOLoncat'] = $this->db->query("SELECT b.* FROM (SELECT *,'' AS TANDA,count(NO_DO) x FROM urut GROUP BY NO_DO ORDER BY NO_DO) b WHERE x > 1")->result();
			} else {
				$data = array(
					'TGL' => set_value('TGL'),
				);
				$data['CekNomorDOLoncat'] = $this->db->query("SELECT ''")->result();
			}


			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/Utility_PostinganSJ/Utility_PostinganSJ', $data);
			$this->load->view('templates_admin/footer_report');
		}
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
	use \koolreport\export\Exportable;
}

class Utility_CekArticleJLPMS extends CI_Controller
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

	public function index_Utility_CekArticleJLPMS()
	{
		$data = array(
			'TGL' => set_value('TGL'),
		);
		$data['utility_CekArticleJLPMS'] = $this->utility_model->tampil_data_utility_CekArticleJLPMS()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/Utility_CekArticleJLPMS/Utility_CekArticleJLPMS', $data);
		$this->load->view('templates_admin/footer_report');
	}
}

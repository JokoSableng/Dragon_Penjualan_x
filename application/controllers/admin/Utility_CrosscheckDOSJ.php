<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
	use \koolreport\export\Exportable;
}

class Utility_CrosscheckDOSJ extends CI_Controller
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

	public function index_Utility_CrosscheckDOSJ()
	{
		$data = array(
			'NOSP' => set_value('NOSP'),
			'KDBRG' => set_value('KDBRG'),
			'KODEC' => set_value('KODEC'),
		);
		$data['crosscheck_dosj_so'] = $this->utility_model->tampil_data_index_Utility_CrosscheckDOSJ_so()->result();
		$data['crosscheck_dosj_jual'] = $this->utility_model->tampil_data_index_Utility_CrosscheckDOSJ_jual()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/Utility_CrosscheckDOSJ/Utility_CrosscheckDOSJ', $data);
		$this->load->view('templates_admin/footer_report');
	}
	
	public function getArticle()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT KD_BRG, NA_BRG
			FROM brg
			WHERE KD_BRG LIKE '%$search%' or NA_BRG LIKE '%$search%'
			ORDER BY KD_BRG LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KD_BRG'],
				'text' => $row['KD_BRG'],
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}
	
	public function getKodec()
	{
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT KODEC, NAMAC
			FROM cust
			WHERE KODEC LIKE '%$search%' or NAMAC LIKE '%$search%'
			ORDER BY KODEC LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KODEC'],
				'text' => $row['KODEC'],
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}
}

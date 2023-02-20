<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\export\Exportable;
}

class Transaksi_CopyExcel extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
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

    public function index_Transaksi_CopyExcel()
    {
        if (isset($_POST["print"])) {
        } else {
            $data = array(
                'KODEC' => set_value('KODEC'),
                'TGL' => set_value('TGL'),
            );
            $data['transaksi_copyexcel'] = $this->laporan_model->tampil_data_transaksi_copyexcel()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Transaksi_CopyExcel', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }

    public function getData_cust()
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
			WHERE KODEC LIKE '%$search%' OR NAMAC LIKE '%$search%'
			GROUP BY KODEC
			ORDER BY NO_ID LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KODEC'],
                'text' => $row['KODEC']
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }
}

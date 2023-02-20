<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\export\Exportable;
}

class Faktur_PenjualanExcelHarian extends CI_Controller
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

    public function index_Faktur_PenjualanExcelHarian()
    {
        if (isset($_POST["print"])) {
        } else {
            $data = array(
                'TGL_1' => set_value('TGL_1'),
                'TGL_2' => set_value('TGL_2'),
            );
            $data['faktur_penjualanexcelharian'] = $this->laporan_model->tampil_data_faktur_penjualanexcelharian()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Faktur_PenjualanExcelHarian', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }
}

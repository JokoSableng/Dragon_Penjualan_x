<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\export\Exportable;
}

class Faktur_CekNota extends CI_Controller
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

    public function index_Faktur_CekNota()
    {
        if (isset($_POST["print"])) {
        } else {
            $data = array(
                'NO_SURAT' => set_value('NO_SURAT'),
                'KODEC' => set_value('KODEC'),
                'NAMAC' => set_value('NAMAC'),
                'INVOICE' => set_value('INVOICE'),
                'TGL_FKTR' => set_value('TGL_FKTR'),
                'NO_FKTR' => set_value('NO_FKTR'),
            );
            $data['faktur_ceknota'] = $this->laporan_model->tampil_data_faktur_ceknota()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Faktur_CekNota', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }
}

<?php

class Utility_ExcelBBMBG extends CI_Controller
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

    public function index_Utility_ExcelBBMBG()
    {
        if (isset($_POST["print"])) {
        } else {
            $data = array(
                'PER' => set_value('PER'),
            );
            $data['utility_excelbbmbg'] = $this->utility_model->tampil_data_utility_excelbbmbg()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Utility_ExcelBBMBG/Utility_ExcelBBMBG', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }

    public function update()
    {
    }
}

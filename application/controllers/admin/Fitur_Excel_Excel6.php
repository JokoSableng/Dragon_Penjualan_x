<?php

class Fitur_Excel_Excel6 extends CI_Controller
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

    public function index_Fitur_Excel_Excel6()
    {
        if (isset($_POST["print"])) {
        } else {
            $data = array(
                'TGL_1' => set_value('TGL_1'),
                'TGL_2' => set_value('TGL_2'),
            );
            $data['fitur_excel6_rekarticle'] = $this->fitur_model->tampil_data_fitur_excel_excel6_rekarticle()->result();
            $data['fitur_excel6_jlarticle'] = $this->fitur_model->tampil_data_fitur_excel_excel6_jlarticle()->result();
            $data['fitur_excel6_wiljlarticle'] = $this->fitur_model->tampil_data_fitur_excel_excel6_wiljlarticle()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Fitur_Excel_Excel6/Fitur_Excel_Excel6', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }

    public function update()
    {
    }
}

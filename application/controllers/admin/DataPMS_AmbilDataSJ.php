<?php

class DataPMS_AmbilDataSJ extends CI_Controller
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

    public function index_DataPMS_AmbilDataSJ()
    {
        $per = $this->session->userdata['periode'];
        $fase = $this->input->post('PERKE');
        $wilayah = $this->input->post('WILAYAH');
        $q1 = " SELECT PER AS PER,
                PERKE AS PERKE,
                TGL AS TGL,
                NO_BUKTI AS NO_BUKTI,
                NO_SO AS NO_SO,
                WILAYAH AS WILAYAH,
                KODEC AS KODEC
            FROM pms_surats
            WHERE PER = '$per'
            AND PERKE = '$fase'
            AND WILAYAH = '$wilayah'
            AND FLAG = 'PMS'
            AND FLAG2 = 'SJ'
            AND MUTASI = 0
            ORDER BY NO_BUKTI";
        $data['ambildatasj'] = $this->db->query($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/DataPMS_AmbilDataSJ/DataPMS_AmbilDataSJ', $data);
        $this->load->view('templates_admin/footer_report');
    }

    public function update()
    {
        redirect('admin/DataPMS_AmbilDataSJ/index_DataPMS_AmbilDataSJ');
    }
}

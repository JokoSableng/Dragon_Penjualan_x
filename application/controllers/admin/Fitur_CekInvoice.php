<?php

class Fitur_CekInvoice extends CI_Controller
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

    public function index_Fitur_CekInvoice()
    {
        if (isset($_POST["print"])) {
        } else {
            $data = array(
                'NO_BUKTI_1' => set_value('NO_BUKTI_1'),
                'KODEC_1' => set_value('KODEC_1'),
            );
            $data['fitur_cekinvoice'] = $this->fitur_model->tampil_data_fitur_cekinvoice()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Fitur_CekInvoice/Fitur_CekInvoice', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }

    public function update()
    {
    }

    public function getData_bukti()
    {
        $per = $this->session->userdata['periode'];
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_BUKTI AS NO_BUKTI
			FROM jual
			WHERE PER='$per' AND FLAG='JR' AND (NO_BUKTI LIKE '%$search%')
			ORDER BY NO_BUKTI LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_BUKTI'],
                'text' => $row['NO_BUKTI'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
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
        $results = $this->db->query("SELECT KODEC AS KODEC
			FROM cust
			WHERE KODEC LIKE '%$search%'
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

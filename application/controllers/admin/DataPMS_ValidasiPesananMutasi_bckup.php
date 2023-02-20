<?php

class DataPMS_ValidasiPesananMutasi extends CI_Controller
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

    public function index_DataPMS_ValidasiPesananMutasi()
    {
        if (isset($_POST["print"])) {
        } else {
            $data = array(
                'WILAYAH' => set_value('WILAYAH'),
                'NO_BUKTI_1' => set_value('NO_BUKTI_1'),
                'NO_BUKTI_2' => set_value('NO_BUKTI_2'),
            );
            $data['datapms_validasipesananmutasi'] = $this->datapms_model->tampil_data_datapms_validasipesananmutasi()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/DataPMS_ValidasiPesananMutasi/DataPMS_ValidasiPesananMutasi', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }

    public function update()
    {
    }

    public function getData_wilayah()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT WILAYAH AS WILAYAH
			FROM wilayah
			WHERE WILAYAH LIKE '%$search%'
			ORDER BY WILAYAH LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['WILAYAH'],
                'text' => $row['WILAYAH'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getData_nobukti_1()
    {
        $wilayah = $this->input->post('wilayah');
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_BUKTI AS NO_BUKTI_1
			FROM stockb
			WHERE WILAYAH = '$wilayah'
            AND stockb.POSTED = 0
            AND stockb.FLAG = 'PMS'
            AND stockb.FLAG2 = 'PJ'
            AND (NO_BUKTI LIKE '%$search%')
			GROUP BY NO_BUKTI
			ORDER BY NO_BUKTI LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_BUKTI_1'],
                'text' => $row['NO_BUKTI_1'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getData_nobukti_2()
    {
        $wilayah = $this->input->post('wilayah');
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_BUKTI AS NO_BUKTI_2
			FROM stockb
			WHERE WILAYAH = '$wilayah'
            AND stockb.POSTED = 0
            AND stockb.FLAG = 'PMS'
            AND stockb.FLAG2 = 'PJ'
            AND (NO_BUKTI LIKE '%$search%')
			GROUP BY NO_BUKTI
			ORDER BY NO_BUKTI LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_BUKTI_2'],
                'text' => $row['NO_BUKTI_2'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }
}

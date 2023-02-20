<?php

class Utility_CekBayar extends CI_Controller
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

    public function index_Utility_CekBayar()
    {
        if (isset($_POST["print"])) {
        } else {
            $data = array(
                'NO_SURAT_1' => set_value('NO_SURAT_1'),
            );
            $data['utility_cekbayar'] = $this->utility_model->tampil_data_utility_cekbayar()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Utility_CekBayar/Utility_CekBayar', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }

    public function update()
    {
    }

    function getjual()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        // $no_bukti = $this->input->post('NO_SURAT_1');
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;

        $results = $this->db->query("SELECT piud.NO_SURAT
        FROM piud
        WHERE piud.NO_SURAT LIKE '%$search%'
        ORDER BY piud.NO_SURAT LIMIT $xa,$perPage");

        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_SURAT'],
                'text' => $row['NO_SURAT'],
                'tampilan' => $row['NO_SURAT'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }    
}

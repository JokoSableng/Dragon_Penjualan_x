<?php


class Master_Article extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'brg') {
            $this->session->set_userdata('menu_penjualan', 'brg');
            $this->session->set_userdata('kode_menu', 'M0001');
            $this->session->set_userdata('keyword_brg', '');
            $this->session->set_userdata('order_brg', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'KD_BRG', 'NA_BRG', 'GOL', 'SATUAN');
    var $column_search = array('KD_BRG', 'NA_BRG', 'GOL', 'SATUAN');
    var $order = array('NO_ID' => 'asc');

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from('brg');
        $i = 0;
        foreach ($this->column_search as $item) {
            if (@$_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        $this->db->from('brg');
        return $this->db->count_all_results();
    }


    function get_ajax_brg()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $brg) {
            $no++;
            $row = array();
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $brg->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Master_Article/update/' . $brg->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $brg->KD_BRG;
            $row[] = $brg->NA_BRG;
            $row[] = $brg->GOL;
            $row[] = $brg->SATUAN;
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function index_Master_Article()
    {
        $data['brg'] = $this->master_model->tampil_data('brg', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Article/Master_Article', $data);
        $this->load->view('templates_admin/footer');
    }

    public function getOrder()
    {
        $data['orderBy'] = $this->input->get('order');
        $this->session->set_userdata('order_brg', $data['orderBy']);
    }

    public function _rules()
    {
    }

    public function input()
    {
    }

    public function input_aksi()
    {
    }

    public function lihat($NO_ID)
    {
    }

    public function lihat_aksi()
    {
    }

    public function update($NO_ID)
    {
        $where = array('NO_ID' => $NO_ID);
        $ambildata = $this->master_model->edit_data($where, 'brg');
        $r = $ambildata->row_array();
        $data = [
            'NO_ID' => $r['NO_ID'],
            'KD_BRG' => $r['KD_BRG'],
            'NA_BRG' => $r['NA_BRG'],
            'GOL' => $r['GOL'],
            'SATUAN' => $r['SATUAN'],
            'WARNA' => $r['WARNA'],
            'JENIS' => $r['JENIS'],
            'HARGA' => $r['HARGA'],
            'HARGAP' => $r['HARGAP'],
        ];
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Article/Master_Article_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $NO_ID = $this->input->post('NO_ID');
        $data = array(
            'KD_BRG' => $this->input->post('KD_BRG', TRUE),
            'NA_BRG' => $this->input->post('NA_BRG', TRUE),
            'GOL' => $this->input->post('GOL', TRUE),
            'SATUAN' => $this->input->post('SATUAN', TRUE),
            'WARNA' => $this->input->post('WARNA', TRUE),
            'JENIS' => $this->input->post('JENIS', TRUE),
            'HARGA' => str_replace(',', '', $this->input->post('HARGA', TRUE)),
            'HARGAP' => str_replace(',', '', $this->input->post('HARGAP', TRUE)),
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'NO_ID' => $NO_ID
        );
        $this->master_model->update_data($where, $data, 'brg');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Updated.
                <button ACNO="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Article/index_Master_Article');
    }

    public function delete($NO_ID)
    {
    }

    function delete_multiple()
    {
    }
}

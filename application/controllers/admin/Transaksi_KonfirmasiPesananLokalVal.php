<?php


class Transaksi_KonfirmasiPesananLokalVal extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'proforma') {
            $this->session->set_userdata('menu_penjualan', 'proforma');
            $this->session->set_userdata('kode_menu', 'T0001');
            $this->session->set_userdata('keyword_proforma', '');
            $this->session->set_userdata('order_proforma', 'NO_ID');
        }
    }
    var $column_order = array(null, null, 'NO_BUKTI', 'MAXKRE', 'PIUTANG', 'WIP');
    var $column_search = array('NO_BUKTI', 'MAXKRE', 'PIUTANG', 'WIP');
    var $order = array('NO_ID' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PI',
            'EXPORT' => '0'
        );
        $this->db->select('*');
        $this->db->from('proforma');
        $this->db->where($where);
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
        if (isset($_POST['order'])) { // here order processing
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
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PI',
            'EXPORT' => '0'
        );
        $this->db->select('*');
        $this->db->from('proforma');
        $this->db->where($where);
        return $this->db->count_all_results();
    }


    function get_ajax_proforma()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $proforma) {
            $no++;
            $row = array();
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $proforma->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_KonfirmasiPesananLokalVal/update/' . $proforma->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $proforma->NO_BUKTI;
            $row[] = $proforma->MAXKRE;
            $row[] = $proforma->PIUTANG;
            $row[] = $proforma->WIP;
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    public function index_Transaksi_KonfirmasiPesananLokalVal()
    {
        $data['proforma'] = $this->master_model->tampil_data('proforma', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_KonfirmasiPesananLokalVal/Transaksi_KonfirmasiPesananLokalVal', $data);
        $this->load->view('templates_admin/footer');
    }

    public function getOrder()
    {
        $data['orderBy'] = $this->input->get('order');
        $this->session->set_userdata('order_proforma', $data['orderBy']);
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
        $ambildata = $this->master_model->edit_data($where, 'proforma');
        $r = $ambildata->row_array();
        $data = [
            'NO_ID' => $r['NO_ID'],
            'NO_BUKTI' => $r['NO_BUKTI'],
            'MAXKRE' => $r['MAXKRE'],
            'PIUTANG' => $r['PIUTANG'],
            'WIP' => $r['WIP'],
            'STOK' => $r['STOK'],
            'PO_LAMA' => $r['PO_LAMA'],
            'SELISIH' => $r['SELISIH'],
        ];
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_KonfirmasiPesananLokalVal/Transaksi_KonfirmasiPesananLokalVal_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $NO_ID = $this->input->post('NO_ID');
        $data = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            'MAXKRE' => str_replace(',', '', $this->input->post('MAXKRE', TRUE)),
            'PIUTANG' => str_replace(',', '', $this->input->post('PIUTANG', TRUE)),
            'WIP' => str_replace(',', '', $this->input->post('WIP', TRUE)),
            'STOK' => str_replace(',', '', $this->input->post('STOK', TRUE)),
            'PO_LAMA' => $this->input->post('PO_LAMA', TRUE),
            'SELISIH' => str_replace(',', '', $this->input->post('SELISIH', TRUE)),
        );
        $where = array(
            'NO_ID' => $NO_ID
        );
        $this->master_model->update_data($where, $data, 'proforma');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Updated.
                <button ACNO="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_KonfirmasiPesananLokalVal/index_Transaksi_KonfirmasiPesananLokalVal');
    }

    public function delete($NO_ID)
    {
    }

    function delete_multiple()
    {
    }

    function print()
    {
        $CI = &get_instance();
        $CI->load->database();
        $servername = $CI->db->hostname;
        $username = $CI->db->username;
        $password = $CI->db->password;
        $database = $CI->db->database;
        $conn = mysqli_connect($servername, $username, $password, $database);
        error_reporting(E_ALL);
        ob_start();
        include('phpjasperxml/class/tcpdf/tcpdf.php');
        include('phpjasperxml/class/PHPJasperXML.inc.php');
        include('phpjasperxml/setting.php');
        $PHPJasperXML = new \PHPJasperXML();
        $PHPJasperXML->load_xml_file("phpjasperxml/account.jrxml");
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $query = "SELECT account.NO_ID,
                account.acno,
                account.nama,
                account.nama_kel,
                account.nm_grup
                FROM account 
                ORDER BY account.acno ";
        $result1 = mysqli_query($conn, $query);
        //$jumlah1 = $result1->fields["jumlah1"];
        //$PHPJasperXML->arrayParameter=array("JUDUL"=>(string) $copy1, "jumlah1"=>(double) $jumlah1 );
        $x = 1;
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NO_ID" => $x,
                "ACNO" => $row1["acno"],
                "nama" => $row1["nama"],
                "nama_kel" => $row1["nama_kel"],
                "nm_grup" => $row1["nm_grup"]
            ));
            $x++;
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}

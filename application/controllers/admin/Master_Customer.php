<?php


class Master_Customer extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'cust') {
            $this->session->set_userdata('menu_penjualan', 'cust');
            $this->session->set_userdata('kode_menu', 'M0001');
            $this->session->set_userdata('keyword_cust', '');
            $this->session->set_userdata('order_cust', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'KODEC', 'NAMAC', 'KOTA', 'WILAYAH');
    var $column_search = array('KODEC', 'NAMAC', 'KOTA', 'WILAYAH');
    var $order = array('NO_ID' => 'asc');

    private function _get_datatables_query()
    {
        $this->db->select('NO_ID, KODEC, NAMAC, KOTA, WILAYAH');
        $this->db->from('cust');
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
        $this->db->from('cust');
        return $this->db->count_all_results();
    }


    function get_ajax_cust()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $cust) {
            $no++;
            $row = array();
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $cust->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Master_Customer/update/' . $cust->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Master_Customer/delete/' . $cust->NO_ID) . '"  onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $cust->KODEC;
            $row[] = $cust->NAMAC;
            $row[] = $cust->KOTA;
            $row[] = $cust->WILAYAH;
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

    public function index_Master_Customer()
    {
        $data['cust'] = $this->master_model->tampil_data('cust', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Customer/Master_Customer', $data);
        $this->load->view('templates_admin/footer');
    }

    public function getOrder()
    {
        $data['orderBy'] = $this->input->get('order');
        $this->session->set_userdata('order_cust', $data['orderBy']);
    }

    public function _rules()
    {
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Customer/Master_Customer_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $data = array(
            'KODEC' => $this->input->post('KODEC', TRUE),
            'LOKAL' => $this->input->post('LOKAL', TRUE) ?? 0,
            'EXPORT' => $this->input->post('EXPORT', TRUE) ?? 0,
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
            'TAX' => $this->input->post('TAX', TRUE),
            'NPWP' => $this->input->post('NPWP', TRUE),
            'NIK' => $this->input->post('NIK', TRUE),
            'ALAMAT' => $this->input->post('ALAMAT', TRUE),
            'KOTA' => $this->input->post('KOTA', TRUE),
            'PROVINSI' => $this->input->post('PROVINSI', TRUE),
            'ALAMAT2' => $this->input->post('ALAMAT2', TRUE),
            'KOTA2' => $this->input->post('KOTA2', TRUE),
            'TELPON1' => $this->input->post('TELPON1', TRUE),
            'FAX' => $this->input->post('FAX', TRUE),
            'KONTAK' => $this->input->post('KONTAK', TRUE),
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date('Y-m-d H:i:s'),
        );
        $this->master_model->input_data('cust', $data);
        $datad = array(
            'KODEC' => $this->input->post('KODEC', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'YER' => substr($this->session->userdata['periode'], -4),
        );
        $this->master_model->input_data('custd', $datad);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button ACNO="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Customer/index_Master_Customer');
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
        $ambildata = $this->master_model->edit_data($where, 'cust');
        $r = $ambildata->row_array();
        $data = [
            'NO_ID' => $r['NO_ID'],
            'KODEC' => $r['KODEC'],
            'LOKAL' => $r['LOKAL'],
            'EXPORT' => $r['EXPORT'],
            'WILAYAH' => $r['WILAYAH'],
            'NAMAC' => $r['NAMAC'],
            'TAX' => $r['TAX'],
            'NPWP' => $r['NPWP'],
            'NIK' => $r['NIK'],
            'ALAMAT' => $r['ALAMAT'],
            'KOTA' => $r['KOTA'],
            'PROVINSI' => $r['PROVINSI'],
            'ALAMAT2' => $r['ALAMAT2'],
            'KOTA2' => $r['KOTA2'],
            'TELPON1' => $r['TELPON1'],
            'FAX' => $r['FAX'],
            'KONTAK' => $r['KONTAK'],
        ];
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Customer/Master_Customer_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $NO_ID = $this->input->post('NO_ID');
        $data = array(
            'KODEC' => $this->input->post('KODEC', TRUE),
            'LOKAL' => str_replace(',', '', $this->input->post('LOKAL', TRUE)) ?? 0,
            'EXPORT' => str_replace(',', '', $this->input->post('EXPORT', TRUE)) ?? 0,
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
            'TAX' => $this->input->post('TAX', TRUE),
            'NPWP' => $this->input->post('NPWP', TRUE),
            'NIK' => $this->input->post('NIK', TRUE),
            'ALAMAT' => $this->input->post('ALAMAT', TRUE),
            'KOTA' => $this->input->post('KOTA', TRUE),
            'PROVINSI' => $this->input->post('PROVINSI', TRUE),
            'ALAMAT2' => $this->input->post('ALAMAT2', TRUE),
            'KOTA2' => $this->input->post('KOTA2', TRUE),
            'TELPON1' => $this->input->post('TELPON1', TRUE),
            'FAX' => $this->input->post('FAX', TRUE),
            'KONTAK' => $this->input->post('KONTAK', TRUE),
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date('Y-m-d H:i:s')
        );
        $where = array(
            'NO_ID' => $NO_ID
        );
        $this->master_model->update_data($where, $data, 'cust');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Updated.
                <button ACNO="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Customer/index_Master_Customer');
    }

    public function delete($NO_ID)
    {
        $where = array('NO_ID' => $NO_ID);
        $this->master_model->hapus_data($where, 'cust');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Customer/index_Master_Customer');
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

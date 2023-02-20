<?php


class Master_Perkiraan extends CI_Controller
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
        if ($this->session->userdata['menu'] != 'account') {
            $this->session->set_userdata('menu', 'account');
            $this->session->set_userdata('kode_menu', 'M0002');
            $this->session->set_userdata('keyword_account', '');
            $this->session->set_userdata('order_account', 'NO_ID');
        }
    }
    // start datatables
    var $column_order = array(null, null, null, 'ACNO', 'NAMA'); //set column field database for datatable orderable
    var $column_search = array('ACNO', 'NAMA'); //set column field database for datatable searchable
    var $order = array('NO_ID' => 'asc'); // default order 

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from('account');
        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
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
        $this->db->from('account');
        return $this->db->count_all_results();
    }


    function get_ajax_account()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $account) {
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $account->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Master_Perkiraan/lihat/' . $account->NO_ID) . '"> <i class="fa fa-eye"></i> Lihat</a>
                            <a class="dropdown-item" href="' . site_url('admin/Master_Perkiraan/update/' . $account->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Master_Perkiraan/delete/' . $account->NO_ID) . '"  onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $account->ACNO;
            $row[] = $account->NAMA;
            // $row[] = $account->size;
            // $row[] = $account->satuan;
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

    public function index_Master_Perkiraan()
    {
        $data['account'] = $this->master_model->tampil_data('account', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Perkiraan/Master_Perkiraan', $data);
        $this->load->view('templates_admin/footer');
    }

    public function getOrder()
    {
        $data['orderBy'] = $this->input->get('order');
        $this->session->set_userdata('order_account', $data['orderBy']);
    }

    public function _rules()
    {
        $this->form_validation->set_rules('PERKIRAAN', 'PERKIRAAN', 'required', ['required' => 'Uraian is required']);
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Perkiraan/Master_Perkiraan_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $data = array(
            'ACNO' => $this->input->post('ACNO', TRUE),
            'NAMA' => $this->input->post('NAMA', TRUE),
            // 'KIK' => $this->input->post('KIK',TRUE),
            // 'emboss' => $this->input->post('EMBOSS',TRUE),
            // 'tebal' => str_replace(',','',$this->input->post('TEBAL',TRUE)),
            // 'lebar' => str_replace(',','',$this->input->post('LEBAR',TRUE)),
            // 'roll' => str_replace(',','',$this->input->post('ROLL',TRUE)),
            // 'kd_warna' => $this->input->post('KD_WARNA',TRUE),
            // 'warna' => $this->input->post('WARNA',TRUE),
            // 'size' => $this->input->post('SIZE',TRUE),
            // 'golong' => $this->input->post('GOLONG',TRUE),
            // 'satuan' => $this->input->post('SATUAN',TRUE),
            // 'uraian' => $this->input->post('URAIAN',TRUE),
            // 'uraian1' => $this->input->post('URAIAN1',TRUE),
            // 'hrgbaru' => str_replace(',','',$this->input->post('HRGBARU',TRUE)),
            // 'hrgpsb' => str_replace(',','',$this->input->post('HRGPSB',TRUE)),
            // 'usrnm' => $this->session->userdata['username'],
            // 'e_tgl' => date('Y-m-d H:i:s'),
        );
        $this->master_model->input_data('account', $data);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button ACNO="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Perkiraan/index_Master_Perkiraan');
    }

    public function lihat($no_id)
    {
        $where = array('NO_ID' => $no_id);
        $ambildata = $this->master_model->edit_data($where, 'account');
        $r = $ambildata->row_array();
        $data = [
            'NO_ID' => $r['NO_ID'],
            'ACNO' => $r['ACNO'],
            'NAMA' => $r['NAMA'],
            // 'KIK' => $r['KIK'],
            // 'EMBOSS' => $r['emboss'],
            // 'TEBAL' => $r['tebal'],
            // 'LEBAR' => $r['lebar'],
            // 'ROLL' => $r['roll'],
            // 'KD_WARNA' => $r['kd_warna'],
            // 'WARNA' => $r['warna'],
            // 'SIZE' => $r['size'],
            // 'GOLONG' => $r['golong'],
            // 'SATUAN' => $r['satuan'],
            // 'URAIAN' => $r['uraian'],
            // 'URAIAN1' => $r['uraian1'],
            // 'HRGBARU' => $r['hrgbaru'],
            // 'HRGPSB' => $r['hrgpsb'],
        ];
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Perkiraan/Master_Perkiraan_lihat', $data);
        $this->load->view('templates_admin/footer');
    }

    public function lihat_aksi()
    {
        redirect('admin/Master_Perkiraan/index_Master_Perkiraan');
    }

    public function update($no_id)
    {
        $where = array('NO_ID' => $no_id);
        $ambildata = $this->master_model->edit_data($where, 'account');
        $r = $ambildata->row_array();
        $data = [
            'NO_ID' => $r['NO_ID'],
            'ACNO' => $r['ACNO'],
            'NAMA' => $r['NAMA'],
            // 'KIK' => $r['KIK'],
            // 'EMBOSS' => $r['emboss'],
            // 'TEBAL' => $r['tebal'],
            // 'LEBAR' => $r['lebar'],
            // 'ROLL' => $r['roll'],
            // 'KD_WARNA' => $r['kd_warna'],
            // 'WARNA' => $r['warna'],
            // 'SIZE' => $r['size'],
            // 'GOLONG' => $r['golong'],
            // 'SATUAN' => $r['satuan'],
            // 'URAIAN' => $r['uraian'],
            // 'URAIAN1' => $r['uraian1'],
            // 'HRGBARU' => $r['hrgbaru'],
            // 'HRGPSB' => $r['hrgpsb'],
        ];
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Perkiraan/Master_Perkiraan_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $NO_ID = $this->input->post('NO_ID');
        $data = array(
            'ACNO' => $this->input->post('ACNO', TRUE),
            'NAMA' => $this->input->post('NAMA', TRUE),
            // 'KIK' => $this->input->post('KIK',TRUE),
            // 'emboss' => $this->input->post('EMBOSS',TRUE),
            // 'tebal' => str_replace(',','',$this->input->post('TEBAL',TRUE)),
            // 'lebar' => str_replace(',','',$this->input->post('LEBAR',TRUE)),
            // 'roll' => str_replace(',','',$this->input->post('ROLL',TRUE)),
            // 'kd_warna' => $this->input->post('KD_WARNA',TRUE),
            // 'warna' => $this->input->post('WARNA',TRUE),
            // 'size' => $this->input->post('SIZE',TRUE),
            // 'golong' => $this->input->post('GOLONG',TRUE),
            // 'satuan' => $this->input->post('SATUAN',TRUE),
            // 'uraian' => $this->input->post('URAIAN',TRUE),
            // 'uraian1' => $this->input->post('URAIAN1',TRUE),
            // 'hrgbaru' => str_replace(',','',$this->input->post('HRGBARU',TRUE)),
            // 'hrgpsb' => str_replace(',','',$this->input->post('HRGPSB',TRUE)),
            // 'usrnm' => $this->session->userdata['username'],
            // 'e_tgl' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'NO_ID' => $NO_ID
        );
        $this->master_model->update_data($where, $data, 'account');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Updated.
                <button ACNO="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Perkiraan/index_Master_Perkiraan');
    }

    public function delete($NO_ID)
    {
        $where = array('NO_ID' => $NO_ID);
        $this->master_model->hapus_data($where, 'account');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button ACNO="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/artikel/index_perkiraan');
    }

    function delete_multiple()
    {
        $this->master_model->remove_checked('account');
        redirect('admin/artikel/index_perkiraan');
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
        $query = "SELECT account.no_id,
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
                "no_id" => $x,
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

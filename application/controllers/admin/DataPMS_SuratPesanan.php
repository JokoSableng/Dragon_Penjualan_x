<?php

class DataPMS_SuratPesanan extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'so') {
            $this->session->set_userdata('menu_penjualan', 'so');
            $this->session->set_userdata('kode_menu', 'D0001');
            $this->session->set_userdata('keyword_so', '');
            $this->session->set_userdata('order_so', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL', 'WILAYAH', 'DIVAL_JL', 'USRNMVAL_JL');
    var $column_search = array('NO_BUKTI', 'TGL', 'WILAYAH', 'DIVAL_JL', 'USRNMVAL_JL');
    var $order = array('DIVAL_JL' => 'desc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        // $fase = $this->session->userdata['fase'];
        $where = array(
            'PER' => $periode,
            // 'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
        );
        $this->db->select('*');
        $this->db->from('so');
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
        $periode = $this->session->userdata['periode'];
        // $fase = $this->session->userdata['fase'];
        $where = array(
            'PER' => $periode,
            // 'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
        );
        $this->db->from('so');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_so()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $so) {
            $JASPER = "window.open('JASPER/" . $so->NO_ID . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $so->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/DataPMS_SuratPesanan/update/' . $so->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $so->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($so->TGL));
            $row[] = $so->WILAYAH;
            $row[] = ($so->DIVAL_JL == 1) ? "SUDAH VALIDASI" : "BELUM VALIDASI";
            $row[] = $so->USRNMVAL_JL;
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

    public function index_DataPMS_SuratPesanan()
    {
        $periode = $this->session->userdata['periode'];
        // $fase = $this->session->userdata['fase'];
        $this->session->set_userdata('judul', 'Validasi Surat Pesanan');
        $where = array(
            'PER' => $periode,
            // 'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
        );
        $data['so'] = $this->transaksi_model->tampil_data($where, 'so', 'DIVAL_JL')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/DataPMS_SuratPesanan/DataPMS_SuratPesanan', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
    }

    public function input_aksi()
    {
    }

    public function update($id)
    {
        $q1 = "SELECT so.NO_ID as ID,
                so.NO_BUKTI AS NO_BUKTI,
                so.TGL AS TGL,
                so.NO_DO AS NO_DO,
                so.TGL_DO AS TGL_DO,
                so.WILAYAH AS WILAYAH,
                so.TOTAL_QTY AS TOTAL_QTY,
                so.TOTAL_QTYP AS TOTAL_QTYP,
                so.WILAYAH AS WILAYAH,
                so.KET AS KET,
                so.DIVAL_JL AS DIVAL_JL,
                so.USRNMVAL_JL AS USRNMVAL_JL,
                so.TGSMPVAL_JL AS TGSMPVAL_JL,

                sod.NO_ID AS NO_ID,
                sod.REC AS REC,
                sod.KD_BRG AS KD_BRG,
                sod.WARNA AS WARNA,
                sod.SIZE AS SIZE,
                sod.GOL AS GOL,
                sod.HARGA AS HARGA,
                sod.HARGAP AS HARGAP,
                sod.SISA AS QTY,
                sod.SISAP AS QTYP,
                sod.KODEC AS KODEC,
                sod.NAMAC AS NAMAC,
                sod.KOTA AS KOTA,
                sod.KODERAY AS KODERAY,
                sod.MAXKRE AS MAXKRE,
                sod.PIU AS PIU,
                sod.EXP_PIU AS EXP_PIU
            FROM so,sod 
            WHERE so.NO_ID=$id 
            AND so.NO_ID=sod.ID 
            ORDER BY sod.REC";
        $data['suratpesanan'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/DataPMS_SuratPesanan/DataPMS_SuratPesanan_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
    }

    public function verifikasi_suratpesanan($NO_ID)
    {
        $datah = array(
            'DIVAL_JL' => '1',
            'USRNMVAL_JL' => $this->session->userdata['username'],
            'TGSMPVAL_JL' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'NO_ID' => "$NO_ID"
        );
        $this->transaksi_model->update_data($where, $datah, 'so');
        $datahd = array(
            'DIVAL_JL' => '1',
            'USRNMVAL_JL' => $this->session->userdata['username'],
            'TGSMPVAL_JL' => date('Y-m-d H:i:s'),
        );
        $whered = array(
            'ID' => "$NO_ID"
        );
        $this->transaksi_model->update_data($whered, $datahd, 'sod');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Data succesfully Updated.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
				</button> 
			</div>'
        );
        redirect('admin/DataPMS_SuratPesanan/index_DataPMS_SuratPesanan');
    }

    public function delete($id)
    {
    }

    function delete_multiple()
    {
    }


    function JASPER($id)
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
        include_once('phpjasperxml/class/tcpdf/tcpdf.php');
        include_once("phpjasperxml/class/PHPJasperXML.inc.php");
        include_once("phpjasperxml/setting.php");
        $PHPJasperXML = new \PHPJasperXML();
        $PHPJasperXML->load_xml_file("phpjasperxml/DataPMS_SuratPesanan.jrxml");
        $no_id = $id;
        $query = "SELECT so.NO_ID as ID,
                so.NO_BUKTI AS NO_BUKTI,
                so.TGL AS TGL,
                so.WILAYAH AS WILAYAH,
                so.TOTAL_QTY AS TOTAL_QTY,
                so.TOTAL_QTYP AS TOTAL_QTYP,

                sod.NO_ID AS NO_ID,
                sod.REC AS REC,
                CONCAT(sod.KODEC,' - ',sod.NAMAC) AS CUSTOMER,
                CONCAT(sod.KD_BRG,' - ',sod.WARNA) AS BARANG,
                sod.QTY AS QTY,
                sod.QTYP AS QTYP
            FROM so,sod 
            WHERE so.NO_ID = $id 
            AND so.NO_ID = sod.ID 
            ORDER BY sod.REC";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NO_BUKTI" => $row1["NO_BUKTI"],
                "TGL" => $row1["TGL"],
                "WILAYAH" => $row1["WILAYAH"],
                "TOTAL_QTY" => $row1["TOTAL_QTY"],
                "TOTAL_QTYP" => $row1["TOTAL_QTYP"],
                "REC" => $row1["REC"],
                "CUSTOMER" => $row1["CUSTOMER"],
                "BARANG" => $row1["BARANG"],
                "QTY" => $row1["QTY"],
                "QTYP" => $row1["QTYP"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}

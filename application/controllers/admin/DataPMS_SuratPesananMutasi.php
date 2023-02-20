<?php

class DataPMS_SuratPesananMutasi extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'stockb') {
            $this->session->set_userdata('menu_penjualan', 'stockb');
            $this->session->set_userdata('kode_menu', 'D0002');
            $this->session->set_userdata('keyword_stockb', '');
            $this->session->set_userdata('order_stockb', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL', 'WILAYAH', 'DIVAL_JL', 'USRNMVAL_JL');
    var $column_search = array('NO_BUKTI', 'TGL', 'WILAYAH', 'DIVAL_JL', 'USRNMVAL_JL');
    var $order = array('DIVAL_JL' => 'desc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
        );
        $this->db->select('*');
        $this->db->from('stockb');
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
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
        );
        $this->db->from('stockb');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_stockb()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $stockb) {
            $JASPER = "window.open('JASPER/" . $stockb->NO_ID . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $stockb->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/DataPMS_SuratPesananMutasi/update/' . $stockb->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $stockb->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($stockb->TGL));
            $row[] = $stockb->WILAYAH;
            $row[] = ($stockb->DIVAL_JL == 1) ? "SUDAH VALIDASI" : "BELUM VALIDASI";
            $row[] = $stockb->USRNMVAL_JL;
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

    public function index_DataPMS_SuratPesananMutasi()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Validasi Surat Pesanan Mutasi');
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
        );
        $data['stockb'] = $this->transaksi_model->tampil_data($where, 'stockb', 'DIVAL_JL')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/DataPMS_SuratPesananMutasi/DataPMS_SuratPesananMutasi', $data);
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
        $q1 = "SELECT stockb.NO_ID as ID,
                stockb.NO_BUKTI AS NO_BUKTI,
                stockb.TGL AS TGL,
                stockb.NO_DO AS NO_DO,
                stockb.TGL_DO AS TGL_DO,
                stockb.WILAYAH AS WILAYAH,
                stockb.TOTAL_QTY AS TOTAL_QTY,
                stockb.TOTAL_QTYP AS TOTAL_QTYP,
                stockb.WILAYAH AS WILAYAH,
                stockb.KET AS KET,
                stockb.DIVAL_JL AS DIVAL_JL,
                stockb.USRNMVAL_JL AS USRNMVAL_JL,
                stockb.TGSMPVAL_JL AS TGSMPVAL_JL,

                stockbd.NO_ID AS NO_ID,
                stockbd.REC AS REC,
                stockbd.KD_BRG AS KD_BRG,
                stockbd.WARNA AS WARNA,
                stockbd.SIZE AS SIZE,
                stockbd.GOL AS GOL,
                stockbd.SISA AS QTY,
                stockbd.SISAP AS QTYP,
                stockbd.KODEC AS KODEC,
                stockbd.NAMAC AS NAMAC
            FROM stockb,stockbd 
            WHERE stockb.NO_ID=$id 
            AND stockb.NO_ID=stockbd.ID 
            ORDER BY stockbd.REC";
        $data['suratpesananmutasi'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/DataPMS_SuratPesananMutasi/DataPMS_SuratPesananMutasi_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
    }

    public function verifikasi_suratpesananmutasi($NO_ID)
    {
        $datah = array(
            'DIVAL_JL' => '1',
            'USRNMVAL_JL' => $this->session->userdata['username'],
            'TGSMPVAL_JL' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'NO_ID' => "$NO_ID"
        );
        $this->transaksi_model->update_data($where, $datah, 'stockb');
        $datahd = array(
            'DIVAL_JL' => '1',
            'USRNMVAL_JL' => $this->session->userdata['username'],
            'TGSMPVAL_JL' => date('Y-m-d H:i:s'),
        );
        $whered = array(
            'ID' => "$NO_ID"
        );
        $this->transaksi_model->update_data($whered, $datahd, 'stockbd');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Data succesfully Updated.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
				</button> 
			</div>'
        );
        redirect('admin/DataPMS_SuratPesananMutasi/index_DataPMS_SuratPesananMutasi');
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
        $PHPJasperXML->load_xml_file("phpjasperxml/DataPMS_SuratPesananMutasi.jrxml");
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

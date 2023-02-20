<?php

class Transaksi_SuratPesananMutasi extends CI_Controller
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
            $this->session->set_userdata('kode_menu', 'T0001');
            $this->session->set_userdata('keyword_stockb', '');
            $this->session->set_userdata('order_stockb', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL', 'NO_DO', 'TGL_DO', 'WILAYAH');
    var $column_search = array('NO_BUKTI', 'TGL', 'NO_DO', 'TGL_DO', 'WILAYAH');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            // 'DIVAL_JL' => 1,
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
            // 'DIVAL_JL' => 1,
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
                        <a style="background-color: #1cc88a" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_SuratPesananMutasi/update/' . $stockb->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $stockb->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($stockb->TGL));
            $row[] = $stockb->NO_DO;
            $row[] = date('d-m-Y', strtotime($stockb->TGL_DO));
            $row[] = $stockb->WILAYAH;
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

    public function index_Transaksi_SuratPesananMutasi()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Surat Pesanan Mutasi');
        $where = array(
            'PER' => $periode,
            // 'DIVAL_JL' => 1,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
        );
        $data['so'] = $this->transaksi_model->tampil_data($where, 'stockb', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_SuratPesananMutasi/Transaksi_SuratPesananMutasi', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
    }

    public function input_aksi()
    {
    }

    public function mintanodo()
    {
        $kdmts = $this->session->userdata['kdmts'];
        $user = $this->session->userdata['username'];
        $respone = '';
        $ceknodo = $this->db->query("SELECT NO_DO 
                -- FROM so
                FROM minta_nodo
                WHERE REQ_DO=1 AND WILAYAH='$kdmts'")->num_rows();
        if (!($ceknodo)) {
            $cekminta = $this->db->query("SELECT NO_DO 
                    FROM minta_nodo 
                    WHERE REQ_DO=0 AND WILAYAH='$kdmts'")->num_rows();
            if (!($cekminta)) {
                $this->db->query("INSERT INTO 
                        minta_nodo (REQ_DO, PER, NO_SO, WILAYAH, USRNM, NO_DO, TGL_DO) 
                    VALUES (0,'','','$kdmts','$user','','') ");
                $respone = "KOSONG";
            } else {
                $respone = "MINTA";
            }
        } else {
            $respone = "ADA";
        }
        $results = $this->db->query("SELECT NO_DO, TGL_DO, REQ_DO 
            -- FROM so 
            FROM minta_nodo
            WHERE REQ_DO=1 AND WILAYAH='$kdmts'");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'nodo' => ($respone == "ADA") ? $row['NO_DO'] : "X",
                'tgldo' => ($respone == "ADA") ? $row['TGL_DO'] : "X",
                'reqdo' => ($respone == "ADA") ? $row['REQ_DO'] : "X",
                'respone' => $respone,
            );
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
    }

    public function lihat($id)
    {
    }

    public function lihat_aksi()
    {
    }

    public function update($id)
    {
        $q1 = "SELECT stockb.NO_ID as ID,
                stockb.NO_BUKTI AS NO_BUKTI,
                stockb.TGL AS TGL,
                stockb.NO_DO AS NO_DO,
                stockb.TGL_DO AS TGL_DO,
                stockb.TOTAL_QTY AS TOTAL_QTY,
                stockb.TOTAL_QTYP AS TOTAL_QTYP,

                stockbd.NO_ID AS NO_ID,
                stockbd.REC AS REC,
                stockbd.KD_BRG AS KD_BRG,
                stockbd.WARNA AS WARNA,
                stockbd.SIZE AS SIZE,
                stockbd.GOL AS GOL,
                stockbd.HARGA AS HARGA,
                stockbd.HARGAP AS HARGAP,
                stockbd.SISA AS QTY,
                stockbd.SISAP AS QTYP,
                stockbd.KODEC AS KODEC,
                stockbd.NAMAC AS NAMAC,
                stockbd.KOTA AS KOTA,
                stockbd.KODERAY AS KODERAY,
                stockbd.MAXKRE AS MAXKRE,
                stockbd.PIU AS PIU,
                stockbd.EXP_PIU AS EXP_PIU
            FROM stockb,stockbd 
            WHERE stockb.NO_ID=$id 
            AND stockb.NO_ID=stockbd.ID 
            ORDER BY stockbd.REC";
        $data['suratpesananmutasi'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_SuratPesananMutasi/Transaksi_SuratPesananMutasi_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            // 'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NO_DO' => $this->input->post('NO_DO', TRUE),
            'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
            // 'TOTAL_QTY' => str_replace(',', '', $this->input->post('TOTAL_QTY', TRUE)),
            // 'TOTAL_QTYP' => str_replace(',', '', $this->input->post('TOTAL_QTYP', TRUE)),
            // 'WILAYAH' => $this->session->userdata['kdmts'],
            // 'PER' => $this->session->userdata['periode'],
            // 'PERKE' => $this->session->userdata['fase'],
            // 'USRNM' => $this->session->userdata['username'],
            // 'TG_SMP' => date("Y-m-d h:i a"),
            // 'FLAG' => 'PMS',
            // 'FLAG2' => 'PJ'
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'stockb');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT stockb.NO_ID as ID,
                stockb.NO_BUKTI AS NO_BUKTI,
                stockb.TGL AS TGL,
                stockb.NO_DO AS NO_DO,
                stockb.TGL_DO AS TGL_DO,
                stockb.TOTAL_QTY AS TOTAL_QTY,
                stockb.TOTAL_QTYP AS TOTAL_QTYP,

                stockbd.NO_ID AS NO_ID,
                stockbd.REC AS REC,
                stockbd.KD_BRG AS KD_BRG,
                stockbd.WARNA AS WARNA,
                stockbd.SIZE AS SIZE,
                stockbd.GOL AS GOL,
                stockbd.HARGA AS HARGA,
                stockbd.HARGAP AS HARGAP,
                stockbd.SISA AS QTY,
                stockbd.SISAP AS QTYP,
                stockbd.KODEC AS KODEC,
                stockbd.NAMAC AS NAMAC,
                stockbd.KOTA AS KOTA,
                stockbd.KODERAY AS KODERAY,
                stockbd.MAXKRE AS MAXKRE,
                stockbd.PIU AS PIU,
                stockbd.EXP_PIU AS EXP_PIU
            FROM stockb,stockbd 
            WHERE stockb.NO_ID=$id 
            AND stockb.NO_ID=stockbd.ID 
            ORDER BY stockbd.REC";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        // $REC = $this->input->post('REC');
        // $KD_BRG = $this->input->post('KD_BRG');
        // $WARNA = $this->input->post('WARNA');
        // $SIZE = $this->input->post('SIZE');
        // $GOL = $this->input->post('GOL');
        // $HARGA = str_replace(',', '', $this->input->post('HARGA', TRUE));
        // $HARGAP = str_replace(',', '', $this->input->post('HARGAP', TRUE));
        // $QTY = str_replace(',', '', $this->input->post('QTY', TRUE));
        // $QTYP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        // $SISA = str_replace(',', '', $this->input->post('QTY', TRUE));
        // $SISAP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        // $KODEC = $this->input->post('KODEC');
        // $NAMAC = $this->input->post('NAMAC');
        // $KOTA = $this->input->post('KOTA');
        // $KODERAY = $this->input->post('KODERAY');
        // $MAXKRE = str_replace(',', '', $this->input->post('MAXKRE', TRUE));
        // $PIU = str_replace(',', '', $this->input->post('PIU', TRUE));
        // $EXP_PIU = date("Y-m-d", strtotime($this->input->post('EXP_PIU', TRUE)));
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'NO_BUKTI' => $this->input->post('NO_BUKTI'),
                    // 'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'NO_DO' => $this->input->post('NO_DO', TRUE),
                    'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
                    // 'REC' => $REC[$URUT],
                    // 'KD_BRG' => $KD_BRG[$URUT],
                    // 'WARNA' => $WARNA[$URUT],
                    // 'SIZE' => $SIZE[$URUT],
                    // 'GOL' => $GOL[$URUT],
                    // 'HARGA' => str_replace(',', '', $HARGA[$URUT]),
                    // 'HARGAP' => str_replace(',', '', $HARGAP[$URUT]),
                    // 'QTY' => str_replace(',', '', $QTY[$URUT]),
                    // 'QTYP' => str_replace(',', '', $QTYP[$URUT]),
                    // 'SISA' => str_replace(',', '', $SISA[$URUT]),
                    // 'SISAP' => str_replace(',', '', $SISAP[$URUT]),
                    // 'KODEC' => $KODEC[$URUT],
                    // 'NAMAC' => $NAMAC[$URUT],
                    // 'KOTA' => $KOTA[$URUT],
                    // 'KODERAY' => $KODERAY[$URUT],
                    // 'MAXKRE' => str_replace(',', '', $MAXKRE[$URUT]),
                    // 'PIU' => str_replace(',', '', $PIU[$URUT]),
                    // 'EXP_PIU' => date("Y-m-d", strtotime($EXP_PIU[$URUT])),
                    // 'WILAYAH' => $this->session->userdata['kdmts'],
                    // 'PER' => $this->session->userdata['periode'],
                    // 'PERKE' => $this->session->userdata['fase'],
                    // 'USRNM' => $this->session->userdata['username'],
                    // 'TG_SMP' => date("Y-m-d h:i a"),
                    // 'FLAG' => 'PMS',
                    // 'FLAG2' => 'PJ'
                );
                $where = array(
                    'NO_ID' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'stockbd');
            } else {
                $where = array(
                    'NO_ID' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'stockbd');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'ID' => $this->input->post('ID', TRUE),
                    'NO_BUKTI' => $this->input->post('NO_BUKTI'),
                    // 'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'NO_DO' => $this->input->post('NO_DO'),
                    'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
                    // 'REC' => $REC[$i],
                    // 'KD_BRG' => $KD_BRG[$i],
                    // 'WARNA' => $WARNA[$i],
                    // 'SIZE' => $SIZE[$i],
                    // 'GOL' => $GOL[$i],
                    // 'HARGA' => str_replace(',', '', $HARGA[$i]),
                    // 'HARGAP' => str_replace(',', '', $HARGAP[$i]),
                    // 'QTY' => str_replace(',', '', $QTY[$i]),
                    // 'QTYP' => str_replace(',', '', $QTYP[$i]),
                    // 'SISA' => str_replace(',', '', $SISA[$i]),
                    // 'SISAP' => str_replace(',', '', $SISAP[$i]),
                    // 'KODEC' => $KODEC[$i],
                    // 'NAMAC' => $NAMAC[$i],
                    // 'KOTA' => $KOTA[$i],
                    // 'KODERAY' => $KODERAY[$i],
                    // 'MAXKRE' => str_replace(',', '', $MAXKRE[$i]),
                    // 'PIU' => str_replace(',', '', $PIU[$i]),
                    // 'EXP_PIU' => date("Y-m-d", strtotime($EXP_PIU[$i])),
                    // 'WILAYAH' => $this->session->userdata['kdmts'],
                    // 'PER' => $this->session->userdata['periode'],
                    // 'PERKE' => $this->session->userdata['fase'],
                    // 'USRNM' => $this->session->userdata['username'],
                    // 'TG_SMP' => date("Y-m-d h:i a"),
                    // 'FLAG' => 'PMS',
                    // 'FLAG2' => 'PJ'
                );
                $this->transaksi_model->input_datad('stockbd', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_SuratPesananMutasi/index_Transaksi_SuratPesananMutasi');
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'stockb');
        $where = array('ID' => $id);
        $this->transaksi_model->hapus_data($where, 'stockbd');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_SuratPesananMutasi/index_Transaksi_SuratPesananMutasi');
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_SuratPesananMutasi.jrxml");
        $no_id = $id;
        $query = "SELECT stockb.NO_ID as ID,
                stockb.NO_BUKTI AS NO_BUKTI,
                stockb.TGL AS TGL,
                stockb.WILAYAH AS WILAYAH,
                stockb.TOTAL_QTY AS TOTAL_QTY,
                stockb.TOTAL_QTYP AS TOTAL_QTYP,

                stockbd.NO_ID AS NO_ID,
                stockbd.REC AS REC,
                CONCAT(stockbd.KODEC,' - ',stockbd.NAMAC) AS CUSTOMER,
                CONCAT(stockbd.KD_BRG,' - ',stockbd.WARNA) AS BARANG,
                stockbd.QTY AS QTY,
                stockbd.QTYP AS QTYP
            FROM stockb,stockbd 
            WHERE stockb.NO_ID = $id 
            AND stockb.NO_ID = stockbd.ID 
            ORDER BY stockbd.REC";
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

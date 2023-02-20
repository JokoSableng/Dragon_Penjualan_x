<?php

class Transaksi_Pemesanan_PemesananMutasi extends CI_Controller
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
            $this->session->set_userdata('kode_menu', 'ST0002');
            $this->session->set_userdata('keyword_so', '');
            $this->session->set_userdata('order_so', 'NO_ID');
        }
    }

    var $column_order = array(null, null, null, 'NO_BUKTI', 'TGL', 'NO_DO', 'TGL_DO');
    var $column_search = array('NO_BUKTI', 'TGL', 'NO_DO', 'TGL_DO');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $per = $this->session->userdata['periode'];
        $where = array(
            'PER' => $per,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJM',
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
        $per = $this->session->userdata['periode'];
        $where = array(
            'PER' => $per,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJM',
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
            $JASPER = "window.open('JASPER/" . $so->NO_BUKTI . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $so->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Pemesanan_PemesananMutasi/update/' . $so->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_BUKTI" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $so->NO_BUKTI;
            $row[] = $so->TGL;
            $row[] = $so->NO_DO;
            $row[] = $so->TGL_DO;
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

    public function index_Transaksi_Pemesanan_PemesananMutasi()
    {
        $per = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Pemesanan Mutasi');
        $where = array(
            'PER' => $per,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJM',
        );
        $data['so'] = $this->transaksi_model->tampil_data($where, 'so', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Pemesanan_PemesananMutasi/Transaksi_Pemesanan_PemesananMutasi', $data);
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
                so.NOTES AS NOTES,
                so.TOTAL_QTY AS TOTAL_QTY,
                so.TOTAL_QTYP AS TOTAL_QTYP,

                sod.NO_ID AS NO_ID,
                sod.REC AS REC,
                sod.KD_BRG AS KD_BRG,
                sod.WARNA AS WARNA,
                sod.GOL AS GOL,
                sod.SISA AS QTY,
                sod.QTYP AS QTYP,
                sod.KODEC AS KODEC,
                sod.NAMAC AS NAMAC
            FROM so, sod 
            WHERE so.NO_ID=$id 
            AND so.NO_ID = sod.ID 
            ORDER BY sod.REC";
        $data['pemesanan_pemesananmutasi'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Pemesanan_PemesananMutasi/Transaksi_Pemesanan_PemesananMutasi_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NO_DO' => $this->input->post('NO_DO', TRUE),
            'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'NOTES' => $this->input->post('NOTES', TRUE),
            'TOTAL_QTY' => str_replace(',', '', $this->input->post('TOTAL_QTY', TRUE)),
            'TOTAL_QTYP' => str_replace(',', '', $this->input->post('TOTAL_QTYP', TRUE)),
            'FLAG' => 'PMS',
            'FLAG2' => 'PJM',
            // 'PER' =>  $this->session->userdata['periode'],
            // 'USRNM' => $this->session->userdata['username'],
            // 'TG_SMP' => date("Y-m-d h:i a")
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'so');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT so.NO_ID as ID,
                so.NO_BUKTI AS NO_BUKTI,
                so.TGL AS TGL,
                so.NO_DO AS NO_DO,
                so.TGL_DO AS TGL_DO,
                so.WILAYAH AS WILAYAH,
                so.NOTES AS NOTES,
                so.TOTAL_QTY AS TOTAL_QTY,
                so.TOTAL_QTYP AS TOTAL_QTYP,

                sod.NO_ID AS NO_ID,
                sod.REC AS REC,
                sod.KD_BRG AS KD_BRG,
                sod.WARNA AS WARNA,
                sod.GOL AS GOL,
                sod.SISA AS QTY,
                sod.SISAP AS QTYP,
                sod.QTY AS QTY,
                sod.QTYP AS QTYP,
                sod.KODEC AS KODEC,
                sod.NAMAC AS NAMAC
            FROM so, sod 
            WHERE so.NO_ID=$id 
            AND so.NO_ID = sod.ID 
            ORDER BY sod.REC";
        $data = $this->transaksi_model->edit_data($q1)->result();
        // var_dump($data);
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $WARNA = $this->input->post('WARNA');
        $GOL = $this->input->post('GOL');
        $QTY = str_replace(',', '', $this->input->post('QTY', TRUE));
        $QTYP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        $SISA = str_replace(',', '', $this->input->post('QTY', TRUE));
        $SISAP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        $KODEC = $this->input->post('KODEC');
        $NAMAC = $this->input->post('NAMAC');
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'NO_BUKTI' => $this->input->post('NO_BUKTI'),
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'NO_DO' => $this->input->post('NO_DO', TRUE),
                    'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
                    'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                    'REC' => $REC[$URUT],
                    'KD_BRG' => $KD_BRG[$URUT],
                    'WARNA' => $WARNA[$URUT],
                    'GOL' => $GOL[$URUT],
                    'QTY' => str_replace(',', '', $QTY[$URUT]),
                    'QTYP' => str_replace(',', '', $QTYP[$URUT]),
                    'SISA' => str_replace(',', '', $SISA[$URUT]),
                    'SISAP' => str_replace(',', '', $SISAP[$URUT]),
                    'KODEC' => $KODEC[$URUT],
                    'NAMAC' => $NAMAC[$URUT],
                    'FLAG' => 'PMS',
                    'FLAG2' => 'PJM',
                    // 'PER' => $this->session->userdata['periode'],
                    // 'USRNM' => $this->session->userdata['username'],
                    // 'TG_SMP' => date("Y-m-d h:i a")
                );
                $where = array(
                    'NO_ID' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'sod');
            } else {
                $where = array(
                    'NO_ID' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'sod');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'ID' => $this->input->post('ID', TRUE),
                    'NO_BUKTI' => $this->input->post('NO_BUKTI'),
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'NO_DO' => $this->input->post('NO_DO', TRUE),
                    'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
                    'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                    'REC' => $REC[$i],
                    'KD_BRG' => $KD_BRG[$i],
                    'WARNA' => $WARNA[$i],
                    'GOL' => $GOL[$i],
                    'QTY' => str_replace(',', '', $QTY[$i]),
                    'QTYP' => str_replace(',', '', $QTYP[$i]),
                    'SISA' => str_replace(',', '', $SISA[$i]),
                    'SISAP' => str_replace(',', '', $SISAP[$i]),
                    'KODEC' => $KODEC[$i],
                    'NAMAC' => $NAMAC[$i],
                    'FLAG' => 'PMS',
                    'FLAG2' => 'PJM',
                    // 'PER' => $this->session->userdata['periode'],
                    // 'USRNM' => $this->session->userdata['username'],
                    // 'TG_SMP' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('sod', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Bukti Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Pemesanan_PemesananMutasi/index_Transaksi_Pemesanan_PemesananMutasi');
    }

    public function delete($id)
    {
    }

    function delete_multiple()
    {
    }

    public function upload_no_do($NO_ID)
    {
        $datah = array(
            'NO_DO' => $this->input->post('NO_DO', TRUE),
            'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
        );
        $where = array(
            'NO_ID' => "$NO_ID"
        );
        $this->transaksi_model->update_data($where, $datah, 'so');
        $datahd = array(
            'NO_DO' => $this->input->post('NO_DO', TRUE),
            'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
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
        redirect('admin/Transaksi_Pemesanan_PemesananMutasi/index_Transaksi_Pemesanan_PemesananMutasi');
    }

    public function getDataAjax_wilayah()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_ID, WILAYAH, WILAYAH1 AS NOTES
            FROM wilayah
            WHERE WILAYAH LIKE '%$search%' OR WILAYAH1 LIKE '%$search%'
            ORDER BY WILAYAH LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['WILAYAH'],
                'text' => $row['WILAYAH'],
                'WILAYAH' => $row['WILAYAH'] . " - " . $row['NOTES'],
                'NOTES' => $row['NOTES'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getDataAjax_brg()
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
        $results = $this->db->query("SELECT NO_ID, KD_BRG, WARNA, GOL
            FROM brg
            WHERE KD_BRG LIKE '%$search%' OR WARNA LIKE '%$search%' OR GOL LIKE '%$search%'
            ORDER BY KD_BRG LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KD_BRG'],
                'text' => $row['KD_BRG'],
                'KD_BRG' => $row['KD_BRG'] . " - " . $row['WARNA'] . " - " . $row['GOL'],
                'WARNA' => $row['WARNA'],
                'GOL' => $row['GOL'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getDataAjax_cust()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_ID, KODEC, NAMAC, KOTA
            FROM cust
            WHERE KODEC LIKE '%$search%' OR NAMAC LIKE '%$search%' OR ALAMAT LIKE '%$search%' OR KOTA LIKE '%$search%'
            ORDER BY KODEC LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KODEC'],
                'text' => $row['KODEC'],
                'KODEC' => $row['KODEC'] . " - " . $row['NAMAC'] . " - " . $row['KOTA'],
                'NAMAC' => $row['NAMAC'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    function JASPER($no_b)
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Pemesanan_PemesananMutasi.jrxml");
        $no_bukti = $no_b;
        $query = " SELECT po.nosj, 
                po.tglci, 
                po.nopol, 
                po.pkp, 
                po.kodecus, 
                po.koderay, 
                po.nama, 
                po.kota,
                po.keter,
                po.bmpkp,
                po.no_sp,
                po.nodo,
                po.maxkre,
                po.spiu,
                po.stand,
                po.bulat,
                po.tlusin,
                po.tpair,
                po.tjumlah,
                po.jenis,
                po.kontan,
                po.tdisk,
                po.bs,
                po.perubahan_hrg,
                po.total as nett,

                pod.rec,
                pod.article,
                pod.warna,
                pod.size,
                pod.golong,
                pod.lusin,
                pod.pair,
                pod.harga,
                pod.disc1,
                pod.disc2,
                pod.disc3,
                pod.disc4,
                pod.discrp,
                pod.disc,
                pod.jumlah
            FROM po, pod 
            WHERE po.nosj=pod.nosj 
            AND po.nosj='" . $no_bukti . "' 
            ORDER BY pod.no_id";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "nosj" => $row1["nosj"],
                "tglci" => $row1["tglci"],
                "tlusin" => $row1["tlusin"],
                "tpair" => $row1["tpair"],
                "tjumlah" => $row1["tjumlah"],
                "jenis" => $row1["jenis"],
                "total" => $row1["total"],
                "tdisk" => $row1["tdisk"],
                "pkp" => $row1["pkp"],
                "nopol" => $row1["nopol"],
                "kodecus" => $row1["kodecus"],
                "koderay" => $row1["koderay"],
                "nama" => $row1["nama"],
                "kota" => $row1["kota"],
                "keter" => $row1["keter"],
                "bmpkp" => $row1["bmpkp"],
                "no_sp" => $row1["no_sp"],
                "nodo" => $row1["nodo"],
                "maxkre" => $row1["maxkre"],
                "spiu" => $row1["spiu"],
                "stand" => $row1["stand"],
                "bulat" => $row1["bulat"],
                "kontan" => $row1["kontan"],
                "nett" => $row1["nett"],
                "bs" => $row1["bs"],
                "perubahan_hrg" => $row1["perubahan_hrg"],

                "rec" => $row1["rec"],
                "article" => $row1["article"],
                "warna" => $row1["warna"],
                "size" => $row1["size"],
                "golong" => $row1["golong"],
                "lusin" => $row1["lusin"],
                "pair" => $row1["pair"],
                "harga" => $row1["harga"],
                "jumlah" => $row1["jumlah"],
                "disc1" => $row1["disc1"],
                "disc2" => $row1["disc2"],
                "disc3" => $row1["disc3"],
                "disc4" => $row1["disc4"],
                "discrp" => $row1["discrp"],
                "disc" => $row1["disc"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}

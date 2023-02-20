<?php

class Transaksi_Stok_Opname extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
            $this->session->set_flashdata('pesan', 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Anda Belum Login
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('admin/auth');
        }
        if ($this->session->userdata['menu_pemasaran'] != 'stockb') {
			$this->session->set_userdata('menu_pemasaran', 'stockb');
			$this->session->set_userdata('kode_menu', 'T0009');
			$this->session->set_userdata('keyword_stockb', '');
			$this->session->set_userdata('order_stockb', 'NO_ID');
        }
    }

    var $column_order = array(null, null, null, 'NO_BUKTI', 'TGL', 'USRNM', 'WILAYAH');
    var $column_search = array('NO_BUKTI', 'TGL', 'USRNM', 'WILAYAH');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query() {
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'FLAG' => 'PMS',
            'FLAG2' => 'LN'
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

    function get_datatables() {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all() {
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'FLAG' => 'PMS',
            'FLAG2' => 'LN'
        );
        $this->db->from('stockb');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_stockb() {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $stockb) {
            $JASPER = "window.open('JASPER/" . $stockb->NO_ID . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $stockb->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Stok_Opname/update/' . $stockb->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Stok_Opname/delete/' . $stockb->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $stockb->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($stockb->TGL));
            $row[] = $stockb->USRNM;
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

    public function index_Transaksi_Stok_Opname() {
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Surat Koreksi Stok');
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'FLAG' => 'PMS',
            'FLAG2' => 'LN'
        );
        $data['stockb'] = $this->transaksi_model->tampil_data($where,'stockb','NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Stok_Opname/Transaksi_Stok_Opname', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input() {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Stok_Opname/Transaksi_Stok_Opname_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi() {
		$per = $this->session->userdata['periode'];
		$kdmts = $this->session->userdata['kdmts'];
        $nomer = $this->db->query("SELECT MAX(NO_BUKTI) as NO_BUKTI FROM stockb WHERE PER='$per' AND WILAYAH='$kdmts' AND FLAG2='LN' ")->result();
        $nom = array_column($nomer,'NO_BUKTI');
        $value11 = substr($nom[0],-4);
        $value22 = STRVAL($value11) + 1;
        $urut= str_pad($value22,4,"0",STR_PAD_LEFT);
        $bukti='LN'.substr($this->session->userdata['periode'],-2).substr($this->session->userdata['periode'],0,2).'-'.$urut;
        $datah = array(
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL',TRUE))),
            'WILAYAH' => $this->session->userdata['kdmts'],
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'PMS',
            'FLAG2' => 'LN'
        );
        $this->transaksi_model->input_datah('stockb',$datah);
        $ID= $this->db ->query("SELECT MAX(NO_ID) AS NO_ID FROM stockb WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $NA_BRG = $this->input->post('NA_BRG');
        $WARNA = $this->input->post('WARNA');
        $SIZE = $this->input->post('SIZE');
        $GOL = $this->input->post('GOL');       
        $QTY = str_replace(',','',$this->input->post('QTY',TRUE));
        $QTYP = str_replace(',','',$this->input->post('QTYP',TRUE));
        $KOREKSI = str_replace(',','',$this->input->post('KOREKSI',TRUE));
        $KOREKSIP = str_replace(',','',$this->input->post('KOREKSIP',TRUE));
        $i = 0;
        foreach($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'NO_BUKTI' => $bukti,
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL',TRUE))),
                'REC' => $REC[$i],
                'KD_BRG' => $KD_BRG[$i],
                'NA_BRG' => $NA_BRG[$i],
                'WARNA' => $WARNA[$i],
                'SIZE' => $SIZE[$i],
                'GOL' => $GOL[$i],
                'QTY' => str_replace(',','',$QTY[$i]),
                'QTYP' => str_replace(',','',$QTYP[$i]),
                'KOREKSI' => str_replace(',','',$KOREKSI[$i]),
                'KOREKSIP' => str_replace(',','',$KOREKSIP[$i]),
                'WILAYAH' => $this->session->userdata['kdmts'],
                'PER' => $this->session->userdata['periode'],
                'PERKE' => $this->session->userdata['fase'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i a"),
                'FLAG' => 'PMS',
                'FLAG2' => 'LN'
            );
            $this->transaksi_model->input_datad('stockbd',$datad);
            $i++;
        }
        $this->session->set_flashdata('pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Stok_Opname/index_Transaksi_Stok_Opname'); 
    }

    public function update($id) {
        $q1="SELECT stockb.NO_ID as ID,
                stockb.no_bukti AS NOSJ,
                stockb.tgl AS TGLCI,
                stockb.nopol AS NOPOL,
                stockb.pkp AS PKP,
                stockb.kota AS KOTA,
                stockb.stand AS STAND,
                stockb.bulat AS BULAT,
                stockb.total_qty AS TLUSIN,
                stockb.total_qtyp AS TPAIR,
                stockb.tjumlah AS TJUMLAH,
                stockb.jenis AS JENIS,
                stockb.kontan AS KONTAN,
                stockb.bs AS BS,
                stockb.total AS NETT,

                stockbd.NO_ID AS NO_ID,
                stockbd.rec AS REC,
                stockbd.kd_brg AS KD_BRG,
                stockbd.warna AS WARNA,
                stockbd.size AS SIZE,
                stockbd.gol AS GOLONG,
                stockbd.qty AS LUSIN,
                stockbd.qtyp AS PAIR,
                stockbd.harga AS HARGA,
                stockbd.jumlah AS JUMLAH
            FROM stockb,stockbd 
            WHERE stockb.NO_ID=$id 
            AND stockb.NO_ID=stockbd.id 
            ORDER BY stockbd.rec";
        $data['stok_opname']= $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Stok_Opname/Transaksi_Stok_Opname_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi() {
        $datah = array(
            'no_bukti' => $this->input->post('NOSJ',TRUE),
            'tgl' => date("Y-m-d", strtotime($this->input->post('TGLCI',TRUE))),
            'nopol' => $this->input->post('NOPOL',TRUE), 
            'pkp' => $this->input->post('PKP',TRUE),
            'kota' => $this->input->post('KOTA',TRUE),
            'stand' => str_replace(',','',$this->input->post('STAND',TRUE)),
            'bulat' => str_replace(',','',$this->input->post('BULAT',TRUE)),
            'total_qty' => str_replace(',','',$this->input->post('TLUSIN',TRUE)),
            'total_qtyp' => str_replace(',','',$this->input->post('TPAIR',TRUE)),
            'tjumlah' => str_replace(',','',$this->input->post('TJUMLAH',TRUE)),
            'jenis' => str_replace(',','',$this->input->post('JENIS',TRUE)),
            'kontan' => str_replace(',','',$this->input->post('KONTAN',TRUE)),
            'bs' => str_replace(',','',$this->input->post('STAND',TRUE)),
            'total' => str_replace(',','',$this->input->post('NETT',TRUE)),
            'wilayah' => $this->session->userdata['kdmts'],
            'per' => $this->session->userdata['periode'],
            'perke' => $this->session->userdata['fase'],
            'usrnm' => $this->session->userdata['username'],
            'tg_smp' => date("Y-m-d h:i a")
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'stockb');
        $id = $this->input->post('ID', TRUE);
        $q1="SELECT stockb.NO_ID as ID,
                stockb.no_bukti AS NOSJ,
                stockb.tgl AS TGLCI,
                stockb.nopol AS NOPOL,
                stockb.pkp AS PKP,
                stockb.kota AS KOTA,
                stockb.stand AS STAND,
                stockb.bulat AS BULAT,
                stockb.total_qty AS TLUSIN,
                stockb.total_qtyp AS TPAIR,
                stockb.tjumlah AS TJUMLAH,
                stockb.jenis AS JENIS,
                stockb.kontan AS KONTAN,
                stockb.bs AS BS,
                stockb.total AS NETT,

                stockbd.NO_ID AS NO_ID,
                stockbd.rec AS REC,
                stockbd.kd_brg AS KD_BRG,
                stockbd.warna AS WARNA,
                stockbd.size AS SIZE,
                stockbd.gol AS GOLONG,
                stockbd.qty AS LUSIN,
                stockbd.qtyp AS PAIR,
                stockbd.harga AS HARGA,
                stockbd.jumlah AS JUMLAH
            FROM stockb,stockbd 
            WHERE stockb.NO_ID=$id 
            AND stockb.NO_ID=stockbd.id 
            ORDER BY stockbd.rec";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $WARNA = $this->input->post('WARNA');
        $SIZE = $this->input->post('SIZE');
        $GOLONG = $this->input->post('GOLONG');       
        $LUSIN = $this->input->post('LUSIN');    
        $PAIR = $this->input->post('PAIR');         
        $HARGA = $this->input->post('HARGA'); 
        $DISC1 = $this->input->post('DISC1');    
        $DISC2 = $this->input->post('DISC2');    
        $DISC3 = $this->input->post('DISC3');    
        $DISC4 = $this->input->post('DISC4');    
        $DISCRP = $this->input->post('DISCRP');    
        $DISC = $this->input->post('DISC');  
        $JUMLAH = $this->input->post('JUMLAH');
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'rec' => $REC[$URUT],
                    'no_bukti' => $this->input->post('NOSJ'),
                    'tgl' => date("Y-m-d", strtotime($this->input->post('TGLCI',TRUE))),
                    'rec' => $REC[$URUT],
                    'kd_brg' => $KD_BRG[$URUT],
                    'warna' => $WARNA[$URUT],
                    'size' => $SIZE[$URUT],
                    'gol' => $GOLONG[$URUT],
                    'qty' => str_replace(',','',$LUSIN[$URUT]),
                    'qtyp' => str_replace(',','',$PAIR[$URUT]),
                    'harga' => str_replace(',','',$HARGA[$URUT]),
                    'jumlah' => str_replace(',','',$JUMLAH[$URUT]),
                    'wilayah' => $this->session->userdata['kdmts'],
                    'per' => $this->session->userdata['periode'],
                    'perke' => $this->session->userdata['fase'],
                    'usrnm' => $this->session->userdata['username'],
                    'tg_smp' => date("Y-m-d h:i a")
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
                    'id' => $this->input->post('ID', TRUE),
                    'rec' => $REC[$i],
                    'nosj' => $this->input->post('NOSJ'),
                    'tglci' => date("Y-m-d", strtotime($this->input->post('TGLCI',TRUE))),
                    'rec' => $REC[$i],
                    'kd_brg' => $KD_BRG[$i],
                    'warna' => $WARNA[$i],
                    'size' => $WARNA[$i],
                    'golong' => $GOLONG[$i],
                    'lusin' => str_replace(',','',$LUSIN[$i]),
                    'pair' => str_replace(',','',$PAIR[$i]),
                    'harga' => str_replace(',','',$HARGA[$i]),
                    'disc1' => str_replace(',','',$DISC1[$i]),
                    'disc2' => str_replace(',','',$DISC2[$i]),
                    'disc3' => str_replace(',','',$DISC3[$i]),
                    'disc4' => str_replace(',','',$DISC4[$i]),
                    'discrp' => str_replace(',','',$DISCRP[$i]),
                    'disc' => str_replace(',','',$DISC[$i]),
                    'jumlah' => str_replace(',','',$JUMLAH[$i]),
                    'kdmts' => $this->session->userdata['kdmts'],
                    'per' => $this->session->userdata['periode'],
                    'perke' => $this->session->userdata['fase'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('stockbd', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Bukti ' . $this->input->post('NO_MANUAL') . $this->input->post('NO_BUKTI') . ' Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Stok_Opname/index_Transaksi_Stok_Opname');
    }

    public function delete($id) {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'stockb');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'stockbd');
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Stok_Opname/index_Transaksi_Stok_Opname');
    }

    function delete_multiple() {
        $this->transaksi_model->remove_checked_transaksi_surat_jalan('stockb', 'stockbd');
        redirect('admin/Transaksi_Stok_Opname/index_Transaksi_Stok_Opname');
    }

    public function getDataAjax_Brg() {
        $kdmts = $this->session->userdata['kdmts'];
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_ID, KD_BRG, NA_BRG, WARNA, SIZE, GOL, WILAYAH, HARGA, HARGAP
            FROM brg
            WHERE WILAYAH = '$kdmts' AND (KD_BRG LIKE '%$search%' OR NA_BRG LIKE '%$search%' OR WARNA LIKE '%$search%' OR SIZE LIKE '%$search%' OR GOL LIKE '%$search%' OR WILAYAH LIKE '%$search%')
            ORDER BY KD_BRG LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KD_BRG'],
                'text' => $row['KD_BRG'],
                'KD_BRG' => $row['KD_BRG'] . " - " . $row['WARNA'] . " - " . $row['NA_BRG'] . " - " . $row['SIZE'] . " - " . $row['GOL'] . " - " . $row['WILAYAH'],
                'NA_BRG' => $row['NA_BRG'],
                'WARNA' => $row['WARNA'],
                'SIZE' => $row['SIZE'],
                'GOL' => $row['GOL'],
                'KOREKSI' => $row['HARGA'],
                'KOREKSIP' => $row['HARGAP'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    function JASPER($id) {
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Stok_Opname.jrxml");
        $NO_ID = $id;
        $query ="SELECT stockb.NO_ID as ID,
                stockb.nosj AS NOSJ,
                stockb.tglci AS TGLCI,
                stockb.nopol AS NOPOL,
                stockb.pkp AS PKP,
                stockb.kodecus AS KODECUS,
                stockb.koderay AS KODERAY,
                stockb.nama AS NAMA,
                stockb.kota AS KOTA,
                stockb.keter AS KETER,
                stockb.bmpkp AS BMPKP,
                stockb.no_sp AS NO_SP,
                stockb.nodo AS NODO,
                stockb.maxkre AS MAXKRE,
                stockb.piu AS PIU,
                stockb.stand AS STAND,
                stockb.bulat AS BULAT,
                stockb.tlusin AS TLUSIN,
                stockb.tpair AS TPAIR,
                stockb.tjumlah AS TJUMLAH,
                stockb.jenis AS JENIS,
                stockb.kontan AS KONTAN,
                stockb.tdisk AS TDISC,
                stockb.bs AS BS,
                stockb.perubahan_hrg AS PERUBAHAN_HRG,
                stockb.total AS NETT,

                stockbd.NO_ID AS NO_ID,
                stockbd.rec AS REC,
                CONCAT(stockbd.kd_brg,' - ',stockbd.warna) AS KD_BRG,
                stockbd.size AS SIZE,
                stockbd.golong AS GOLONG,
                stockbd.lusin AS LUSIN,
                stockbd.pair AS PAIR,
                stockbd.harga AS HARGA,
                stockbd.hrgpsb AS HRGPSB,
                stockbd.disc1 AS DISC1,
                stockbd.disc2 AS DISC2,
                stockbd.disc3 AS DISC3,
                stockbd.disc4 AS DISC4,
                stockbd.discrp AS DISCRP,
                stockbd.disc AS DISC,
                stockbd.jumlah AS JUMLAH
            FROM stockb,stockbd 
            WHERE stockb.NO_ID=$id 
            AND stockb.NO_ID=stockbd.id 
            ORDER BY stockbd.rec";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "REC" => $row1["REC"],
                "TGLCI" => $row1["TGLCI"],
                "NOSJ" => $row1["NOSJ"],
                "NAMA" => $row1["NAMA"],
                "KOTA" => $row1["KOTA"],
                "LUSIN" => $row1["LUSIN"],
                "PAIR" => $row1["PAIR"],
                "KD_BRG" => $row1["KD_BRG"],
                "HARGA" => $row1["HARGA"],
                "HRGPSB" => $row1["HRGPSB"],
                "JUMLAH" => $row1["JUMLAH"],
                "TJUMLAH" => $row1["TJUMLAH"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }

}
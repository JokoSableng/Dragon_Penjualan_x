<?php

class Transaksi_Retur_Pengiriman extends CI_Controller {

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
        if ($this->session->userdata['menu_pemasaran'] != 'surats') {
			$this->session->set_userdata('menu_pemasaran', 'surats');
			$this->session->set_userdata('kode_menu', 'T0008');
			$this->session->set_userdata('keyword_surats', '');
			$this->session->set_userdata('order_surats', 'NO_ID');
        }
    }

    var $column_order = array(null, null, null, 'NO_BUKTI', 'TGL', 'KODEC', 'NAMAC', 'WILAYAH');
    var $column_search = array('NO_BUKTI', 'TGL', 'KODEC', 'NAMAC', 'WILAYAH');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query() {
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $fase = $this->session->userdata['fase'];
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'JS'
        );
        $this->db->select('*');
        $this->db->from('surats');
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
        $fase = $this->session->userdata['fase'];
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'JS'
        );
        $this->db->from('surats');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_surats() {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $surats) {
            $JASPER = "window.open('JASPER/" . $surats->NO_ID . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $surats->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Retur_Pengiriman/update/' . $surats->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Retur_Pengiriman/delete/' . $surats->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $surats->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($surats->TGL));
            $row[] = $surats->KODEC;
            $row[] = $surats->NAMAC;
            $row[] = $surats->WILAYAH;
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

    public function index_Transaksi_Retur_Pengiriman() {
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $fase = $this->session->userdata['fase'];
        $this->session->set_userdata('judul', 'Transaksi Retur Pengiriman');
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'JS'
        );
        $data['surats'] = $this->transaksi_model->tampil_data($where,'surats','NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Retur_Pengiriman/Transaksi_Retur_Pengiriman', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input() {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Retur_Pengiriman/Transaksi_Retur_Pengiriman_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi() {
		$per = $this->session->userdata['periode'];
		$kdmts = $this->session->userdata['kdmts'];
        $nomer = $this->db->query("SELECT MAX(NO_BUKTI) as NO_BUKTI FROM surats WHERE PER='$per' AND WILAYAH='$kdmts' AND FLAG2='JS' ")->result();   
        $nom = array_column($nomer,'NO_BUKTI');
        $value11 = substr($nom[0],-4);
        $value22 = STRVAL($value11) + 1;
        $urut= str_pad($value22,4,"0",STR_PAD_LEFT);
        $bukti='JS'.substr($this->session->userdata['periode'],-2).substr($this->session->userdata['periode'],0,2).'-'.$urut;
        $datah = array(
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL',TRUE))),
            'KODEC' => $this->input->post('KODEC',TRUE),
            'KODERAY' => $this->input->post('KODERAY',TRUE),
            'NAMAC' => $this->input->post('NAMAC',TRUE),
            'TOTAL_QTY' => str_replace(',','',$this->input->post('TOTAL_QTY',TRUE)),
            'TOTAL_QTYP' => str_replace(',','',$this->input->post('TOTAL_QTYP',TRUE)),
            'TTOTAL' => str_replace(',','',$this->input->post('TTOTAL',TRUE)),
            'TDISC' => str_replace(',','',$this->input->post('TDISC',TRUE)),
            'NETT' => str_replace(',','',$this->input->post('NETT',TRUE)),
            'SISA' => str_replace(',','',$this->input->post('SISA',TRUE)),
            'WILAYAH' => $this->session->userdata['kdmts'],
            'PER' => $this->session->userdata['periode'],
            'PERKE' => $this->session->userdata['fase'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'PMS',
            'FLAG2' => 'JS'
        );
        $this->transaksi_model->input_datah('surats',$datah);
        $ID= $this->db ->query("SELECT MAX(NO_ID) AS NO_ID FROM surats WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $WARNA = $this->input->post('WARNA');
        $SIZE = $this->input->post('SIZE');
        $GOL = $this->input->post('GOL');       
        $QTY = str_replace(',','',$this->input->post('QTY',TRUE));
        $QTYP = str_replace(',','',$this->input->post('QTYP',TRUE));
        $HARGA = str_replace(',','',$this->input->post('HARGA',TRUE));
        $TOTAL = str_replace(',','',$this->input->post('TOTAL',TRUE));
        $i = 0;
        foreach($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'NO_BUKTI' => $bukti,
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL',TRUE))),
                // 'KODEC' => $this->input->post('KODEC',TRUE),
                // 'NAMAC' => $this->input->post('NAMAC',TRUE),
                // 'KODERAY' => $this->input->post('KODERAY',TRUE),
                // 'TOTAL_QTY' => str_replace(',','',$this->input->post('TOTAL_QTY',TRUE)),
                // 'TOTAL_QTYP' => str_replace(',','',$this->input->post('TOTAL_QTYP',TRUE)),
                // 'TTOTAL' => str_replace(',','',$this->input->post('TTOTAL',TRUE)),
                // 'TDISC' => str_replace(',','',$this->input->post('TDISC',TRUE)),
                // 'NETT' => str_replace(',','',$this->input->post('NETT',TRUE)),
                // 'SISA' => str_replace(',','',$this->input->post('SISA',TRUE)),
                'REC' => $REC[$i],
                'KD_BRG' => $KD_BRG[$i],
                'WARNA' => $WARNA[$i],
                'SIZE' => $SIZE[$i],
                'GOL' => $GOL[$i],
                'QTY' => str_replace(',','',$QTY[$i]),
                'QTYP' => str_replace(',','',$QTYP[$i]),
                'HARGA' => str_replace(',','',$HARGA[$i]),
                'TOTAL' => str_replace(',','',$TOTAL[$i]),
                'WILAYAH' => $this->session->userdata['kdmts'],
                'PER' => $this->session->userdata['periode'],
                'PERKE' => $this->session->userdata['fase'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i a"),
                'FLAG' => 'PMS',
                'FLAG2' => 'JS'
            );
            $this->transaksi_model->input_datad('suratsd',$datad);
            $i++;
        }
        $this->session->set_flashdata('pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Retur_Pengiriman/index_Transaksi_Retur_Pengiriman'); 
    }

    public function update($id) {
        $q1="SELECT surats.NO_ID as ID,
                surats.no_bukti AS NO_BUKTI,
                surats.tgl AS TGL,
                surats.kodec AS KODEC,
                surats.koderay AS KODERAY,
                surats.namac AS NAMAC,
                surats.total_qty AS TOTAL_QTY,
                surats.total_qtyp AS TOTAL_QTYP,
                surats.ttotal AS TTOTAL,
                surats.tdisc AS TDISC,
                surats.nett AS NETT,
                surats.sisa AS SISA,

                suratsd.NO_ID AS NO_ID,
                suratsd.rec AS REC,
                suratsd.kd_brg AS KD_BRG,
                suratsd.warna AS WARNA,
                suratsd.size AS SIZE,
                suratsd.gol AS GOL,
                suratsd.qty AS QTY,
                suratsd.qtyp AS QTYP,
                suratsd.harga AS HARGA,
                suratsd.total AS TOTAL
            FROM surats,suratsd 
            WHERE surats.NO_ID=$id 
            AND surats.NO_ID=suratsd.id 
            ORDER BY suratsd.rec";
        $data['retur_pengiriman']= $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Retur_Pengiriman/Transaksi_Retur_Pengiriman_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi() {
        $datah = array(
            'no_bukti' => $this->input->post('NO_BUKTI',TRUE),
            'tgl' => date("Y-m-d", strtotime($this->input->post('TGL',TRUE))),
            'kodec' => $this->input->post('KODEC',TRUE),
            'koderay' => $this->input->post('KODERAY',TRUE),
            'namac' => $this->input->post('NAMAC',TRUE),
            'total_qty' => str_replace(',','',$this->input->post('TOTAL_QTY',TRUE)),
            'total_qtyp' => str_replace(',','',$this->input->post('TOTAL_QTYP',TRUE)),
            'ttotal' => str_replace(',','',$this->input->post('TTOTAL',TRUE)),
            'tdisc' => str_replace(',','',$this->input->post('TDISC',TRUE)),
            'nett' => str_replace(',','',$this->input->post('NETT',TRUE)),
            'sisa' => str_replace(',','',$this->input->post('SISA',TRUE)),
            'wilayah' => $this->session->userdata['kdmts'],
            'per' => $this->session->userdata['periode'],
            'perke' => $this->session->userdata['fase'],
            'usrnm' => $this->session->userdata['username'],
            'tg_smp' => date("Y-m-d h:i a")
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'surats');
        $id = $this->input->post('ID', TRUE);
        $q1="SELECT surats.NO_ID as ID,
                surats.no_bukti AS NO_BUKTI,
                surats.tgl AS TGL,
                surats.kodec AS KODEC,
                surats.koderay AS KODERAY,
                surats.namac AS NAMAC,
                surats.total_qty AS TOTAL_QTY,
                surats.total_qtyp AS TOTAL_QTYP,
                surats.ttotal AS TTOTAL,
                surats.tdisc AS TDISC,
                surats.nett AS NETT,
                surats.sisa AS SISA,

                suratsd.NO_ID AS NO_ID,
                suratsd.rec AS REC,
                suratsd.kd_brg AS KD_BRG,
                suratsd.warna AS WARNA,
                suratsd.size AS SIZE,
                suratsd.gol AS GOL,
                suratsd.qty AS QTY,
                suratsd.qtyp AS QTYP,
                suratsd.harga AS HARGA,
                suratsd.total AS TOTAL
            FROM surats,suratsd 
            WHERE surats.NO_ID=$id 
            AND surats.NO_ID=suratsd.id 
            ORDER BY suratsd.rec";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $WARNA = $this->input->post('WARNA');
        $SIZE = $this->input->post('SIZE');
        $GOL = $this->input->post('GOL');       
        $QTY = str_replace(',','',$this->input->post('QTY',TRUE));
        $QTYP = str_replace(',','',$this->input->post('QTYP',TRUE));
        $HARGA = str_replace(',','',$this->input->post('HARGA',TRUE));
        $TOTAL = str_replace(',','',$this->input->post('TOTAL',TRUE));
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'REC' => $REC[$URUT],
                    'KD_BRG' => $KD_BRG[$URUT],
                    'WARNA' => $WARNA[$URUT],
                    'SIZE' => $SIZE[$URUT],
                    'GOL' => $GOL[$URUT],
                    'QTY' => str_replace(',','',$QTY[$URUT]),
                    'QTYP' => str_replace(',','',$QTYP[$URUT]),
                    'HARGA' => str_replace(',','',$HARGA[$URUT]),
                    'TOTAL' => str_replace(',','',$TOTAL[$URUT]),
                    'WILAYAH' => $this->session->userdata['kdmts'],
                    'PER' => $this->session->userdata['periode'],
                    'PERKE' => $this->session->userdata['fase'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a")
                );
                $where = array(
                    'NO_ID' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'suratsd');
            } else {
                $where = array(
                    'NO_ID' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'suratsd');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'ID' => $this->input->post('ID', TRUE),
                    'REC' => $REC[$i],
                    'KD_BRG' => $KD_BRG[$i],
                    'WARNA' => $WARNA[$i],
                    'SIZE' => $WARNA[$i],
                    'GOL' => $GOL[$i],
                    'QTY' => str_replace(',','',$QTY[$i]),
                    'QTYP' => str_replace(',','',$QTYP[$i]),
                    'HARGA' => str_replace(',','',$HARGA[$i]),
                    'TOTAL' => str_replace(',','',$TOTAL[$i]),
                    'WILAYAH' => $this->session->userdata['kdmts'],
                    'PER' => $this->session->userdata['periode'],
                    'PERKE' => $this->session->userdata['fase'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('suratsd', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Bukti ' . $this->input->post('NO_MANUAL') . $this->input->post('NO_BUKTI') . ' Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Retur_Pengiriman/index_Transaksi_Retur_Pengiriman');
    }

    public function delete($id) {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'surats');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'suratsd');
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Retur_Pengiriman/index_Transaksi_Retur_Pengiriman');
    }

    function delete_multiple() {
        $this->transaksi_model->remove_checked_transaksi_surat_jalan('surats', 'suratsd');
        redirect('admin/Transaksi_Retur_Pengiriman/index_Transaksi_Retur_Pengiriman');
    }

    function filter_no_so() {
        $no_so = $this->input->get('no_so');
        $q1 = "SELECT KD_BRG, WARNA, SIZE, GOL, (QTY*-1) AS QTY, (QTYP*-1) AS QTYP 
                FROM sod 
                WHERE NO_BUKTI='$no_so' 
                ORDER BY REC ";
        $q2 = $this->db->query($q1);
        if($q2->num_rows() > 0){
            foreach($q2->result() as $row){
                $hasil[] = $row;
            }
        };
        echo json_encode($hasil);
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
        $results = $this->db->query("SELECT NO_ID, KD_BRG, NA_BRG, WARNA, SIZE, GOL, WILAYAH
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Retur_Pengiriman.jrxml");
        $NO_ID = $id;
        $query ="SELECT surats.NO_ID as ID,
                surats.nosj AS NOSJ,
                surats.tglci AS TGLCI,
                surats.nopol AS NOPOL,
                surats.pkp AS PKP,
                surats.kodecus AS KODECUS,
                surats.koderay AS KODERAY,
                surats.nama AS NAMA,
                surats.kota AS KOTA,
                surats.keter AS KETER,
                surats.bmpkp AS BMPKP,
                surats.no_sp AS NO_SP,
                surats.nodo AS NODO,
                surats.maxkre AS MAXKRE,
                surats.piu AS PIU,
                surats.stand AS STAND,
                surats.bulat AS BULAT,
                surats.tlusin AS TLUSIN,
                surats.tpair AS TPAIR,
                surats.tjumlah AS TJUMLAH,
                surats.jenis AS JENIS,
                surats.kontan AS KONTAN,
                surats.tdisk AS TDISC,
                surats.bs AS BS,
                surats.perubahan_hrg AS PERUBAHAN_HRG,
                surats.total AS NETT,

                suratsd.NO_ID AS NO_ID,
                suratsd.rec AS REC,
                CONCAT(suratsd.article,' - ',suratsd.warna) AS ARTICLE,
                suratsd.size AS SIZE,
                suratsd.golong AS GOLONG,
                suratsd.lusin AS LUSIN,
                suratsd.pair AS PAIR,
                suratsd.harga AS HARGA,
                suratsd.hrgpsb AS HRGPSB,
                suratsd.disc1 AS DISC1,
                suratsd.disc2 AS DISC2,
                suratsd.disc3 AS DISC3,
                suratsd.disc4 AS DISC4,
                suratsd.discrp AS DISCRP,
                suratsd.disc AS DISC,
                suratsd.jumlah AS JUMLAH
            FROM surats,suratsd 
            WHERE surats.NO_ID=$id 
            AND surats.NO_ID=suratsd.id 
            ORDER BY suratsd.rec";
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
                "ARTICLE" => $row1["ARTICLE"],
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
<?php

class Transaksi_Surat_Jalan extends CI_Controller
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
        if ($this->session->userdata['menu_pemasaran'] != 'surats') {
            $this->session->set_userdata('menu_pemasaran', 'surats');
            $this->session->set_userdata('kode_menu', 'T0005');
            $this->session->set_userdata('keyword_surats', '');
            $this->session->set_userdata('order_surats', 'NO_ID');
        }
    }

    var $column_order = array(null, null, null, 'NO_BUKTI', 'TGL', 'KODEC', 'NAMAC', 'WILAYAH');
    var $column_search = array('NO_BUKTI', 'TGL', 'KODEC', 'NAMAC', 'WILAYAH');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $fase = $this->session->userdata['fase'];
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'SJ'
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
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $fase = $this->session->userdata['fase'];
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'SJ'
        );
        $this->db->from('surats');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_surats()
    {
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
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Surat_Jalan/update/' . $surats->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Surat_Jalan/delete/' . $surats->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
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

    public function index_Transaksi_Surat_Jalan()
    {
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $fase = $this->session->userdata['fase'];
        $this->session->set_userdata('judul', 'Transaksi Surat Jalan Pengiriman');
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'SJ'
        );
        $data['surats'] = $this->transaksi_model->tampil_data($where, 'surats', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Surat_Jalan/Transaksi_Surat_Jalan', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Surat_Jalan/Transaksi_Surat_Jalan_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $per = $this->session->userdata['periode'];
        $kdmts = $this->session->userdata['kdmts'];
        $nomer = $this->db->query("SELECT MAX(NO_BUKTI) as NO_BUKTI FROM surats WHERE per='$per' AND wilayah='$kdmts' AND FLAG2='SJ' ")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $value11 = substr($nom[0], -4);
        $value22 = STRVAL($value11) + 1;
        $urut = str_pad($value22, 4, "0", STR_PAD_LEFT);
        $bukti = 'SJ' . substr($this->session->userdata['periode'], -2) . substr($this->session->userdata['periode'], 0, 2) . '-' . $urut;
        $datah = array(
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NOPOL' => $this->input->post('NOPOL', TRUE),
            'PKP' => $this->input->post('PKP', TRUE),
            'KODEC' => $this->input->post('KODEC', TRUE),
            'KOTA' => $this->input->post('KOTA', TRUE),
            'KODERAY' => $this->input->post('KODERAY', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
            'BMPKP' => $this->input->post('BMPKP', TRUE),
            'NO_SO' => $this->input->post('NO_SO', TRUE),
            'TGL_SO' => date("Y-m-d", strtotime($this->input->post('TGL_SO', TRUE))),
            'NO_DO' => $this->input->post('NO_DO', TRUE),
            'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
            'MAXKRE' => str_replace(',', '', $this->input->post('MAXKRE', TRUE)),
            'PIU' => str_replace(',', '', $this->input->post('PIU', TRUE)),
            'EXP_PIU' => date("Y-m-d", strtotime($this->input->post('EXP_PIU', TRUE))),
            'STAND' => str_replace(',', '', $this->input->post('STAND', TRUE)),
            'BULAT' => str_replace(',', '', $this->input->post('BULAT', TRUE)),
            'TOTAL_QTY' => str_replace(',', '', $this->input->post('TOTAL_QTY', TRUE)),
            'TOTAL_QTYP' => str_replace(',', '', $this->input->post('TOTAL_QTYP', TRUE)),
            'TOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'JENIS' => str_replace(',', '', $this->input->post('JENIS', TRUE)),
            'KONTAN' => str_replace(',', '', $this->input->post('KONTAN', TRUE)),
            'TDISC' => str_replace(',', '', $this->input->post('TDISC', TRUE)),
            'BS' => str_replace(',', '', $this->input->post('BS', TRUE)),
            'PRB_HRG' => str_replace(',', '', $this->input->post('PRB_HRG', TRUE)),
            'NETT' => str_replace(',', '', $this->input->post('NETT', TRUE)),
            'WILAYAH' => $this->session->userdata['kdmts'],
            'PER' => $this->session->userdata['periode'],
            'PERKE' => $this->session->userdata['fase'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'PMS',
            'FLAG2' => 'SJ'
        );
        $this->transaksi_model->input_datah('surats', $datah);
        $ID = $this->db->query("SELECT MAX(NO_ID) AS NO_ID FROM surats WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $WARNA = $this->input->post('WARNA');
        $SIZE = $this->input->post('SIZE');
        $GOL = $this->input->post('GOL');
        $QTY = str_replace(',', '', $this->input->post('QTY', TRUE));
        $QTYP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        $KIRIM = str_replace(',', '', $this->input->post('QTY', TRUE));
        $KIRIMP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        $HARGA = str_replace(',', '', $this->input->post('HARGA', TRUE));
        $HARGAP = str_replace(',', '', $this->input->post('HARGAP', TRUE));
        $DISC1 = str_replace(',', '', $this->input->post('DISC1', TRUE));
        $DISC2 = str_replace(',', '', $this->input->post('DISC2', TRUE));
        $DISC3 = str_replace(',', '', $this->input->post('DISC3', TRUE));
        $DISC4 = str_replace(',', '', $this->input->post('DISC4', TRUE));
        $DISC = str_replace(',', '', $this->input->post('DISC', TRUE));
        $TOTAL = str_replace(',', '', $this->input->post('TOTAL', TRUE));
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'NO_BUKTI' => $bukti,
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                'NO_DO' => $this->input->post('NO_DO', TRUE),
                'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
                'NO_SO' => $this->input->post('NO_SO', TRUE),
                'TGL_SO' => date("Y-m-d", strtotime($this->input->post('TGL_SO', TRUE))),
                'KODEC' => $this->input->post('KODEC', TRUE),
                'NAMAC' => $this->input->post('NAMAC', TRUE),
                'KODERAY' => $this->input->post('KODERAY', TRUE),
                'REC' => $REC[$i],
                'KD_BRG' => $KD_BRG[$i],
                'WARNA' => $WARNA[$i],
                'SIZE' => $SIZE[$i],
                'GOL' => $GOL[$i],
                'QTY' => str_replace(',', '', $QTY[$i]),
                'QTYP' => str_replace(',', '', $QTYP[$i]),
                'KIRIM' => str_replace(',', '', $KIRIM[$i]),
                'KIRIMP' => str_replace(',', '', $KIRIMP[$i]),
                'HARGA' => str_replace(',', '', $HARGA[$i]),
                'HARGAP' => str_replace(',', '', $HARGAP[$i]),
                'DISC1' => str_replace(',', '', $DISC1[$i]),
                'DISC2' => str_replace(',', '', $DISC2[$i]),
                'DISC3' => str_replace(',', '', $DISC3[$i]),
                'DISC4' => str_replace(',', '', $DISC4[$i]),
                'DISC' => str_replace(',', '', $DISC[$i]),
                'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                'WILAYAH' => $this->session->userdata['kdmts'],
                'PER' => $this->session->userdata['periode'],
                'PERKE' => $this->session->userdata['fase'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i a"),
                'FLAG' => 'PMS',
                'FLAG2' => 'SJ'
            );
            $this->transaksi_model->input_datad('suratsd', $datad);
            $i++;
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Surat_Jalan/index_Transaksi_Surat_Jalan');
    }

    public function update($id)
    {
        $q1 = "SELECT surats.NO_ID as ID,
                surats.no_bukti AS NO_BUKTI,
                surats.tgl AS TGL,
                surats.nopol AS NOPOL,
                surats.pkp AS PKP,
                surats.no_sp AS NO_SP,
                surats.kodec AS KODEC,
                surats.koderay AS KODERAY,
                surats.namac AS NAMAC,
                surats.kota AS KOTA,
                surats.keter AS KETER,
                surats.bmpkp AS BMPKP,
                surats.no_do AS NO_DO,
                surats.tgl_do AS TGL_DO,
                surats.tgl_so AS TGL_SO,
                surats.maxkre AS MAXKRE,
                surats.piu AS PIU,
                surats.stand AS STAND,
                surats.bulat AS BULAT,
                surats.total_qty AS TQTY,
                surats.total_qtyp AS TQTYP,
                surats.ttotal AS TJUMLAH,
                surats.jenis AS JENIS,
                surats.kontan AS KONTAN,
                surats.tdisc AS TDISC,
                surats.bs AS BS,
                surats.prb_hrg AS PERUBAHAN_HRG,
                surats.total AS NETT,
                surats.exp_piu AS EXP_PIU,

                suratsd.NO_ID AS NO_ID,
                suratsd.rec AS REC,
                suratsd.kd_brg AS ARTICLE,
                suratsd.warna AS WARNA,
                suratsd.size AS SIZE,
                suratsd.gol AS GOLONG,
                suratsd.qty AS LUSIN,
                suratsd.qtyp AS PAIR,
                suratsd.harga AS HARGA,
                suratsd.discrp AS DISCRP,
                suratsd.disc AS DISC,
                suratsd.total AS JUMLAH
            FROM surats,suratsd 
            WHERE surats.NO_ID=$id 
            AND surats.NO_ID=suratsd.id 
            ORDER BY suratsd.rec";
        $data['surat_jalan'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Surat_Jalan/Transaksi_Surat_Jalan_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'nosj' => $this->input->post('NOSJ', TRUE),
            'tglci' => date("Y-m-d", strtotime($this->input->post('TGLCI', TRUE))),
            'nopol' => $this->input->post('NOPOL', TRUE),
            'pkp' => $this->input->post('PKP', TRUE),
            'kodecus' => $this->input->post('KODECUS', TRUE),
            'koderay' => $this->input->post('KODERAY', TRUE),
            'nama' => $this->input->post('NAMA', TRUE),
            'kota' => $this->input->post('KOTA', TRUE),
            'keter' => $this->input->post('KETER', TRUE),
            'bmpkp' => $this->input->post('BMPKP', TRUE),
            'no_sp' => $this->input->post('NO_SP', TRUE),
            'nodo' => $this->input->post('NODO', TRUE),
            'maxkre' => str_replace(',', '', $this->input->post('MAXKRE', TRUE)),
            'piu' => str_replace(',', '', $this->input->post('PIU', TRUE)),
            'stand' => str_replace(',', '', $this->input->post('STAND', TRUE)),
            'bulat' => str_replace(',', '', $this->input->post('BULAT', TRUE)),
            'tlusin' => str_replace(',', '', $this->input->post('TLUSIN', TRUE)),
            'tpair' => str_replace(',', '', $this->input->post('TPAIR', TRUE)),
            'tjumlah' => str_replace(',', '', $this->input->post('TJUMLAH', TRUE)),
            'jenis' => str_replace(',', '', $this->input->post('JENIS', TRUE)),
            'kontan' => str_replace(',', '', $this->input->post('KONTAN', TRUE)),
            'tdisk' => str_replace(',', '', $this->input->post('TDISC', TRUE)),
            'bs' => str_replace(',', '', $this->input->post('STAND', TRUE)),
            'perubahan_hrg' => str_replace(',', '', $this->input->post('PERUBAHAN_HRG', TRUE)),
            'total' => str_replace(',', '', $this->input->post('NETT', TRUE)),
            'wilayah' => $this->session->userdata['kdmts'],
            'per' => $this->session->userdata['periode'],
            'perke' => $this->session->userdata['fase'],
            'e_pc' => $this->session->userdata['username'],
            'e_tgl' => date("Y-m-d h:i a")
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'surats');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT surats.NO_ID as ID,
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
                suratsd.article AS ARTICLE,
                suratsd.warna AS WARNA,
                suratsd.size AS SIZE,
                suratsd.golong AS GOLONG,
                suratsd.lusin AS LUSIN,
                suratsd.pair AS PAIR,
                suratsd.harga AS HARGA,
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
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $ARTICLE = $this->input->post('ARTICLE');
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
                    'nosj' => $this->input->post('NOSJ'),
                    'tglci' => date("Y-m-d", strtotime($this->input->post('TGLCI', TRUE))),
                    'rec' => $REC[$URUT],
                    'article' => $ARTICLE[$URUT],
                    'warna' => $WARNA[$URUT],
                    'size' => $SIZE[$URUT],
                    'golong' => $GOLONG[$URUT],
                    'lusin' => str_replace(',', '', $LUSIN[$URUT]),
                    'pair' => str_replace(',', '', $PAIR[$URUT]),
                    'harga' => str_replace(',', '', $HARGA[$URUT]),
                    'disc1' => str_replace(',', '', $DISC1[$URUT]),
                    'disc2' => str_replace(',', '', $DISC2[$URUT]),
                    'disc3' => str_replace(',', '', $DISC3[$URUT]),
                    'disc4' => str_replace(',', '', $DISC4[$URUT]),
                    'discrp' => str_replace(',', '', $DISCRP[$URUT]),
                    'disc' => str_replace(',', '', $DISC[$URUT]),
                    'harga' => str_replace(',', '', $HARGA[$URUT]),
                    'jumlah' => str_replace(',', '', $JUMLAH[$URUT]),
                    'kdmts' => $this->session->userdata['kdmts'],
                    'per' => $this->session->userdata['periode'],
                    'perke' => $this->session->userdata['fase'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
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
                    'id' => $this->input->post('ID', TRUE),
                    'rec' => $REC[$i],
                    'nosj' => $this->input->post('NOSJ'),
                    'tglci' => date("Y-m-d", strtotime($this->input->post('TGLCI', TRUE))),
                    'rec' => $REC[$i],
                    'article' => $ARTICLE[$i],
                    'warna' => $WARNA[$i],
                    'size' => $WARNA[$i],
                    'golong' => $GOLONG[$i],
                    'lusin' => str_replace(',', '', $LUSIN[$i]),
                    'pair' => str_replace(',', '', $PAIR[$i]),
                    'harga' => str_replace(',', '', $HARGA[$i]),
                    'disc1' => str_replace(',', '', $DISC1[$i]),
                    'disc2' => str_replace(',', '', $DISC2[$i]),
                    'disc3' => str_replace(',', '', $DISC3[$i]),
                    'disc4' => str_replace(',', '', $DISC4[$i]),
                    'discrp' => str_replace(',', '', $DISCRP[$i]),
                    'disc' => str_replace(',', '', $DISC[$i]),
                    'jumlah' => str_replace(',', '', $JUMLAH[$i]),
                    'kdmts' => $this->session->userdata['kdmts'],
                    'per' => $this->session->userdata['periode'],
                    'perke' => $this->session->userdata['fase'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('suratsd', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Bukti ' . $this->input->post('NO_MANUAL') . $this->input->post('NO_BUKTI') . ' Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Surat_Jalan/index_Transaksi_Surat_Jalan');
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'surats');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'suratsd');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Surat_Jalan/index_Transaksi_Surat_Jalan');
    }

    function delete_multiple()
    {
        $this->transaksi_model->remove_checked_transaksi_surat_jalan('surats', 'suratsd');
        redirect('admin/Transaksi_Surat_Jalan/index_Transaksi_Surat_Jalan');
    }

    function filter_no_so()
    {
        $no_so = $this->input->get('no_so');
        $q1 = "SELECT KD_BRG, WARNA, SIZE, GOL, QTY, QTYP, HARGA, HARGAP 
                FROM sod 
                WHERE NO_BUKTI='$no_so' 
                ORDER BY REC ";
        $q2 = $this->db->query($q1);
        if ($q2->num_rows() > 0) {
            foreach ($q2->result() as $row) {
                $hasil[] = $row;
            }
        };
        echo json_encode($hasil);
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_SuratJalan.jrxml");
        $NO_ID = $id;
        $query = "SELECT surats.NO_ID as ID,
            surats.NO_BUKTI AS NO_BUKTI,
            surats.TGL AS TGL,
            surats.NO_DO AS NO_DO,
            surats.NAMAC AS NAMAC,
            surats.ALAMAT AS ALAMAT,
            surats.KOTA AS KOTA,
            surats.NETT AS NETT,

            suratsd.NO_ID AS NO_ID,
            suratsd.REC AS REC,
            suratsd.QTY AS QTY,
            suratsd.QTYP AS QTYP,
            suratsd.KIRIM AS KIRIM,
            suratsd.KIRIMP AS KIRIMP,
            CONCAT(suratsd.KD_BRG+' - '+suratsd.WARNA) AS BARANG,
            suratsd.TOTAL AS TOTAL
        FROM surats, suratsd 
        WHERE surats.NO_ID=$id
        AND surats.NO_ID = suratsd.ID 
        ORDER BY suratsd.REC";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NO_BUKTI" => $row1["NO_BUKTI"],
                "TGL" => $row1["TGL"],
                "NO_DO" => $row1["NO_DO"],
                "NAMAC" => $row1["NAMAC"],
                "ALAMAT" => $row1["ALAMAT"],
                "KOTA" => $row1["KOTA"],
                "NETT" => $row1["NETT"],
                "REC" => $row1["REC"],
                "QTY" => $row1["QTY"],
                "QTYP" => $row1["QTYP"],
                "KIRIM" => $row1["KIRIM"],
                "KIRIMP" => $row1["KIRIMP"],
                "KD_BRG" => $row1["KD_BRG"],
                "BARANG" => $row1["BARANG"],
                "TOTAL" => $row1["TOTAL"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}

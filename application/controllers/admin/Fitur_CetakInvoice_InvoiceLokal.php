<?php

class Fitur_CetakInvoice_InvoiceLokal extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'jual') {
            $this->session->set_userdata('menu_penjualan', 'jual');
            $this->session->set_userdata('kode_menu', 'ST0005');
            $this->session->set_userdata('keyword_jual', '');
            $this->session->set_userdata('order_jual', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL', 'NO_ORDER', 'KODEC');
    var $column_search = array('NO_BUKTI', 'TGL', 'NO_ORDER', 'KODEC');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'JR',
            'LOKAL' => '1'
        );
        $this->db->select('*');
        $this->db->from('jual');
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
            'FLAG' => 'JR',
            'LOKAL' => '1'
        );
        $this->db->from('jual');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_jual()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $jual) {
            $no++;
            $row = array();
            $JASPER = "window.open('JASPER/" . $jual->NO_ID . "','', 'width=1000','height=900');";
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $jual->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Fitur_CetakInvoice_InvoiceLokal/update/' . $jual->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Fitur_CetakInvoice_InvoiceLokal/delete/' . $jual->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $jual->NO_BUKTI;
            $row[] = $jual->TGL;
            $row[] = $jual->NO_SO;
            $row[] = $jual->KODEC;
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

    public function index_Fitur_CetakInvoice_InvoiceLokal()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Penjualan Lokal');
        $where = array(
            'PER' => $periode,
            'FLAG' => 'JR',
            'LOKAL' => '1'
        );
        $data['jual'] = $this->transaksi_model->tampil_data($where, 'jual', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Fitur_CetakInvoice_InvoiceLokal/Fitur_CetakInvoice_InvoiceLokal', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
    }

    public function input_aksi()
    {
    }

    public function lihat($id)
    {
    }

    public function lihat_aksi()
    {
    }

    public function update($id)
    {
        $q1 = "SELECT jual.NO_ID as ID,
                jual.NO_BUKTI AS NO_BUKTI,
                jual.TGL AS TGL,
                jual.NO_SURAT AS NO_SURAT,
                jual.TGL_SJ AS TGL_SJ,
                jual.TGL_PMS AS TGL_PMS,
                jual.NO_FKTR AS NO_FKTR,
                jual.KD_FKTR AS KD_FKTR,
                jual.TGL_FKTR AS TGL_FKTR,
                jual.INVOICE AS INVOICE,
                jual.NO_SO AS NO_SO,
                jual.KODEC AS KODEC,
                (SELECT TAX from cust WHERE KODEC=jual.KODEC limit 1) AS TAX,
                (SELECT NPWP from cust WHERE KODEC=jual.KODEC limit 1) AS NPWP,
                jual.WILAYAH AS WILAYAH,
                jual.NAMAC AS NAMAC,
                jual.NOTES AS NOTES,
                jual.HRG_BR AS HRG_BR,
                jual.TOTAL_QTY AS TOTAL_QTY,
                jual.TOTAL_QTYP AS TOTAL_QTYP,
                jual.TOTAL AS TTOTAL,
                jual.STAND AS STAND,
                jual.BULAT AS BULAT,
                jual.DPP AS DPP,
                jual.JENIS AS JENIS,
                jual.KONTAN AS KONTAN,
                jual.TDISK AS TDISK,
                jual.POT AS POT,
                jual.BS AS BS,
                jual.PRB_HRG AS PRB_HRG,
                jual.SISA AS SISA,
                jual.PPN AS PPN,
                jual.BB AS BB,
                jual.OB AS OB,
                jual.DPP1 AS DPP1,
                jual.NETT AS NETT,
                jual.LAIN AS LAIN,

                juald.NO_ID AS NO_ID,
                juald.REC AS REC,
                juald.KD_BRG AS KD_BRG,
                juald.NA_BRG AS NA_BRG,
                juald.SATUAN AS SATUAN,
                juald.QTY AS QTY,
                juald.QTYP AS QTYP,
                juald.HARGA AS HARGA,
                juald.HARGAP AS HARGAP,
                juald.HARGADPP AS HARGADPP,
                juald.DISC1 AS DISC1,
                juald.DISC2 AS DISC2,
                juald.DISC3 AS DISC3,
                juald.DISC4 AS DISC4,
                juald.DISCRP AS DISCRP,
                juald.DISC AS DISC,
                juald.TOTAL AS TOTAL,
                juald.TOTALDPP AS TOTALDPP
            FROM jual,juald 
            WHERE jual.NO_ID=$id 
            AND jual.NO_ID=juald.ID 
            ORDER BY juald.REC";
        $data['cetakinvoicelokal'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Fitur_CetakInvoice_InvoiceLokal/Fitur_CetakInvoice_InvoiceLokal_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        /*
        $datah = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            // 'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            // 'NO_SURAT' => $this->input->post('NO_SURAT', TRUE),
            // 'TGL_SJ' => date("Y-m-d", strtotime($this->input->post('TGL_SJ', TRUE))),
            'TGL_PMS' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NO_FKTR' => $this->input->post('NO_FKTR', TRUE),
            // 'KD_FKTR' => $this->input->post('KD_FKTR', TRUE),
            'TGL_FKTR' => date("Y-m-d", strtotime($this->input->post('TGL_FKTR', TRUE))),
            'INVOICE' => $this->input->post('INVOICE', TRUE),
            'NO_SO' => $this->input->post('NO_SO', TRUE),
            'KODEC' => $this->input->post('KODEC', TRUE),
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
            'NOTES' => $this->input->post('NOTES', TRUE),
            // 'HRG_BR' => $this->input->post('HRG_BR', TRUE),
            'TOTAL_QTY' => str_replace(',', '', $this->input->post('TOTAL_QTY', TRUE)),
            // 'TOTAL_QTYP' => str_replace(',', '', $this->input->post('TOTAL_QTYP', TRUE)),
            'TOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            // 'STAND' => str_replace(',', '', $this->input->post('STAND', TRUE)),
            // 'BULAT' => str_replace(',', '', $this->input->post('BULAT', TRUE)),
            'DPP' => str_replace(',', '', $this->input->post('DPP', TRUE)),
            // 'JENIS' => str_replace(',', '', $this->input->post('JENIS', TRUE)),
            // 'KONTAN' => str_replace(',', '', $this->input->post('KONTAN', TRUE)),
            'TDISK' => str_replace(',', '', $this->input->post('TDISK', TRUE)),
            // 'POT' => str_replace(',', '', $this->input->post('POT', TRUE)),
            // 'BS' => str_replace(',', '', $this->input->post('BS', TRUE)),
            // 'PRB_HRG' => str_replace(',', '', $this->input->post('PRB_HRG', TRUE)),
            // 'SISA' => str_replace(',', '', $this->input->post('SISA', TRUE)),
            'PPN' => str_replace(',', '', $this->input->post('PPN', TRUE)),
            // 'BB' => str_replace(',', '', $this->input->post('BB', TRUE)),
            // 'OB' => str_replace(',', '', $this->input->post('OB', TRUE)),
            // 'DPP1' => str_replace(',', '', $this->input->post('DPP1', TRUE)),
            'NETT' => str_replace(',', '', $this->input->post('NETT', TRUE)),
            'LAIN' => str_replace(',', '', $this->input->post('LAIN', TRUE)),
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i:s"),
            'LOKAL' => '1',
            'FLAG' => 'JR'
        );
        */
        $datah = array(
            'NOTES' => $this->input->post('NOTES', TRUE),
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'jual');
        /*
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT jual.NO_ID as ID, 
                juald.REC AS REC, 
                juald.NO_ID AS NO_ID
            FROM jual, juald 
            WHERE jual.NO_ID=$id 
            AND jual.NO_ID=juald.ID 
            ORDER BY juald.REC";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $NA_BRG = $this->input->post('NA_BRG');
        $QTY = str_replace(',', '', $this->input->post('QTY', TRUE));
        // $QTYP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        $HARGA = str_replace(',', '', $this->input->post('HARGA', TRUE));
        // $HARGAP = str_replace(',', '', $this->input->post('HARGAP', TRUE));
        // $DISC1 = str_replace(',', '', $this->input->post('DISC1', TRUE));
        // $DISC2 = str_replace(',', '', $this->input->post('DISC2', TRUE));
        // $DISC3 = str_replace(',', '', $this->input->post('DISC3', TRUE));
        // $DISC4 = str_replace(',', '', $this->input->post('DISC4', TRUE));
        $DISCRP = str_replace(',', '', $this->input->post('DISCRP', TRUE));
        // $DISC = str_replace(',', '', $this->input->post('DISC', TRUE));
        $TOTAL = str_replace(',', '', $this->input->post('TOTAL', TRUE));
        $KET1 = $this->input->post('KET1');
        $KET2 = $this->input->post('KET2');
        $DPP = str_replace(',', '', $this->input->post('TOTALDPP', TRUE));
        $PPN = str_replace(',', '', $this->input->post('TOTALPPN', TRUE));
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'NO_BUKTI' => $this->input->post('NO_BUKTI'),
                    'FLAG' => 'JR',
                    'LOKAL' => '1',
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'NO_SURAT' => $this->input->post('NO_SURAT', TRUE),
                    'TGL_SJ' => date("Y-m-d", strtotime($this->input->post('TGL_SJ', TRUE))),
                    'NO_SO' => $this->input->post('NO_SO', TRUE),
                    'KODEC' => $this->input->post('KODEC', TRUE),
                    'NAMAC' => $this->input->post('NAMAC', TRUE),
                    'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                    'REC' => $REC[$URUT],
                    'KD_BRG' => $KD_BRG[$URUT],
                    'NA_BRG' => $NA_BRG[$URUT],
                    'QTY' => str_replace(',', '', $QTY[$URUT]),
                    // 'QTYP' => str_replace(',', '', $QTYP[$URUT]),
                    'HARGA' => str_replace(',', '', $HARGA[$URUT]),
                    // 'HARGAP' => str_replace(',', '', $HARGAP[$URUT]),
                    // 'DISC1' => str_replace(',', '', $DISC1[$URUT]),
                    // 'DISC2' => str_replace(',', '', $DISC2[$URUT]),
                    // 'DISC3' => str_replace(',', '', $DISC3[$URUT]),
                    // 'DISC4' => str_replace(',', '', $DISC4[$URUT]),
                    'DISCRP' => str_replace(',', '', $DISCRP[$URUT]),
                    // 'DISC' => str_replace(',', '', $DISC[$URUT]),
                    'TOTAL' => str_replace(',', '', $TOTAL[$URUT]),
                    'TOTALDPP' => str_replace(',', '', $DPP[$URUT]),
                    'KET1' => $KET1[$URUT],
                    'KET2' => $KET2[$URUT],
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i:s")
                );
                $where = array(
                    'NO_ID' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'juald');
            } else {
                $where = array(
                    'NO_ID' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'juald');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'ID' => $this->input->post('ID', TRUE),
                    'NO_BUKTI' => $this->input->post('NO_BUKTI'),
                    'FLAG' => 'JR',
                    'LOKAL' => '1',
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'NO_SURAT' => $this->input->post('NO_SURAT', TRUE),
                    'TGL_SJ' => date("Y-m-d", strtotime($this->input->post('TGL_SJ', TRUE))),
                    'NO_SO' => $this->input->post('NO_SO', TRUE),
                    'KODEC' => $this->input->post('KODEC', TRUE),
                    'NAMAC' => $this->input->post('NAMAC', TRUE),
                    'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                    'REC' => $REC[$i],
                    'KD_BRG' => $KD_BRG[$i],
                    'NA_BRG' => $NA_BRG[$i],
                    'QTY' => str_replace(',', '', $QTY[$i]),
                    // 'QTYP' => str_replace(',', '', $QTYP[$i]),
                    'HARGA' => str_replace(',', '', $HARGA[$i]),
                    // 'HARGAP' => str_replace(',', '', $HARGAP[$i]),
                    // 'DISC1' => str_replace(',', '', $DISC1[$i]),
                    // 'DISC2' => str_replace(',', '', $DISC2[$i]),
                    // 'DISC3' => str_replace(',', '', $DISC3[$i]),
                    // 'DISC4' => str_replace(',', '', $DISC4[$i]),
                    'DISCRP' => str_replace(',', '', $DISCRP[$i]),
                    // 'DISC' => str_replace(',', '', $DISC[$i]),
                    'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                    'TOTALDPP' => str_replace(',', '', $DPP[$i]),
                    'KET1' => $KET1[$i],
                    'KET2' => $KET2[$i],
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i:s")
                );
                $this->transaksi_model->input_datad('juald', $datad);
            }
            $i++;
        }
        */
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data '.$this->input->post('NO_BUKTI').' Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Fitur_CetakInvoice_InvoiceLokal/index_Fitur_CetakInvoice_InvoiceLokal');
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'jual');
        $where = array('ID' => $id);
        $this->transaksi_model->hapus_data($where, 'juald');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Fitur_CetakInvoice_InvoiceLokal/index_Fitur_CetakInvoice_InvoiceLokal');
    }

    function delete_multiple()
    {
    }

    function filter_no_surat()
    {
        $no_surat = $this->input->get('no_surat');
        $q1 = "SELECT KD_BRG AS KD_BRG, 
                NA_BRG AS NA_BRG,
                QTY AS QTY,
                QTYP AS QTYP,
                HARGA AS HARGA,
                HARGAP AS HARGAP,
                TOTAL AS TOTAL
            FROM suratsd 
            WHERE NO_BUKTI='$no_surat' 
            ORDER BY REC";
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Fitur_CetakInvoice_InvoiceLokal.jrxml");
        $NO_ID = $id;
        $query = "SELECT jual.NO_ID as NO_ID,
                jual.NO_BUKTI AS NO_BUKTI,
                jual.TGL AS TGLCI,
                jual.jtempo AS JTEMPO,
                jual.tgl_fktr AS TGFAK,
                jual.no_cet AS NOCET,
                jual.no_fktr AS NOFAKTR,
                jual.KD_FKTR AS KODEFAK,
                jual.invoice AS INVOICE,
                jual.NO_ORDER AS NODO,
                jual.KODEC AS KODECUS,
                jual.namac AS NAMA,
                '' AS KDMTS,
                jual.TOTAL_QTY AS TLUSIN,
                '' AS KETER,
                jual.TOTAL_QTYP AS TPAIR,
                jual.stand AS STAND,
                jual.bulat AS BULAT,
                jual.total AS TOTAL,
                jual.dpp AS DPP,
                jual.disc3 AS JENIS,
                jual.disc2 AS KONTAN,
                jual.dpptdisk AS DPPTDISK,
                jual.disc7 AS DISC7,
                jual.disc6 AS DISC6,
                jual.disc5 AS DISC5,
                jual.disc4 AS OB,
                jual.tdisk AS TDISK,
                jual.sisa AS SISA,
                jual.ppn AS PPN,
                jual.dpp1 AS DPP1,
                jual.TOTAL AS TJUMLAH,
                jual.NOPOL AS NOPOL,

                juald.ID AS ID,
                juald.rec AS REC,
                juald.KD_BRG AS ARTICLE,
                juald.NA_BRG AS URAIAN,
                juald.QTY AS LUSIN,
                juald.QTYP AS PAIR,
                juald.harga AS HARGA,
                juald.hargapdpp AS HARGAPDPP,
                juald.disc1 AS DISC1,
                juald.disc2 AS DISC2,
                juald.disc3 AS DISC3,
                juald.disc4 AS DISC4,
                juald.discrp AS DISCRP,
                juald.disc AS DISC,
                juald.TOTAL AS JUMLAH,
                juald.ket1 AS KET1,
                juald.ket2 AS KET2,
                juald.SATUAN AS SATUAN,
                juald.WARNA AS WARNA,
                juald.TOTALDPP AS TOTALDPP,
                juald.TGL_PMS AS CETAK,

                cust.ALAMAT AS ALAMAT,
                cust.KOTA AS KOTA
        FROM jual,juald,cust
        WHERE jual.NO_BUKTI = juald.NO_BUKTI 
		AND jual.KODEC = cust.KODEC
        AND jual.NO_ID = '" . $NO_ID . "' 
        ORDER BY juald.NO_ID";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "KDMTS" => $row1["KDMTS"],
                "TGFAK" => $row1["TGFAK"],
                "JTEMPO" => $row1["JTEMPO"],
                "NAMA" => $row1["NAMA"],
                "NOCET" => $row1["NOCET"],
                "LUSIN" => $row1["LUSIN"],
                "PAIR" => $row1["PAIR"],
                "KET1" => $row1["KET1"],
                "ARTICLE" => $row1["ARTICLE"],
                "HARGA" => $row1["HARGAPDPP"],
                "KOTA" => $row1["KOTA"],
                "SJ" => $row1["NO_BUKTI"],
                "INVOICE" => $row1["INVOICE"],
                "TGLCI" => date("d-m-Y", strtotime($row1["CETAK"])),
                "POTONGAN" => $row1["TDISK"],
                "JUMLAH" => $row1["TOTALDPP"],
                "ALAMAT" => $row1["ALAMAT"],
                "SATUAN" => $row1["SATUAN"],
                "PPN" => $row1["PPN"],
                "DPP1" => $row1["DPP1"],
                "URAIAN" => $row1["URAIAN"],
                "WARNA" => $row1["WARNA"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}
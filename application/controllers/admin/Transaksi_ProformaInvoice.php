<?php

class Transaksi_ProformaInvoice extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'proforma') {
            $this->session->set_userdata('menu_penjualan', 'proforma');
            $this->session->set_userdata('kode_menu', 'ST0006');
            $this->session->set_userdata('keyword_proforma', '');
            $this->session->set_userdata('order_proforma', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL_SO', 'NO_SO', 'KODEC');
    var $column_search = array('NO_BUKTI', 'TGL_SO', 'NO_SO', 'KODEC');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PI',
            'EXPORT' => '0'
        );
        $this->db->select('*');
        $this->db->from('proforma');
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
            'FLAG' => 'PI',
            'EXPORT' => '0'
        );
        $this->db->from('proforma');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_proforma()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $proforma) {
            $no++;
            $row = array();
            $JASPER = "window.open('JASPER/" . $proforma->NO_ID . "','', 'width=1000','height=900');";
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $proforma->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_ProformaInvoice/update/' . $proforma->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_ProformaInvoice/delete/' . $proforma->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $proforma->NO_BUKTI;
            $row[] = $proforma->TGL_SO;
            $row[] = $proforma->NO_SO;
            $row[] = $proforma->KODEC;
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

    public function index_Transaksi_ProformaInvoice()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Proforma Invoice');
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PI',
            'EXPORT' => '0'
        );
        $data['proforma'] = $this->transaksi_model->tampil_data($where, 'proforma', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_ProformaInvoice/Transaksi_ProformaInvoice', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_ProformaInvoice/Transaksi_ProformaInvoice_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $per = $this->session->userdata['periode'];
        $nomer = $this->db->query("SELECT MAX(NO_BUKTI) as NO_BUKTI FROM proforma WHERE PER='$per' AND FLAG='PI'")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $value11 = substr($nom[0], -4);
        $value22 = STRVAL($value11) + 1;
        $urut = str_pad($value22, 4, "0", STR_PAD_LEFT);
        $bukti = 'PI' . '-' . substr($this->session->userdata['periode'], -2) . substr($this->session->userdata['periode'], 0, 2) . '-' . $urut;
        $datah = array(
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NO_SO' => $this->input->post('NO_SO', TRUE),
            'TGL_SO' => date("Y-m-d", strtotime($this->input->post('TGL_SO', TRUE))),
            'KODEC' => $this->input->post('KODEC', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
            'ALAMAT' => $this->input->post('ALAMAT', TRUE),
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'MAXKRE' => str_replace(',', '', $this->input->post('MAXKRE', TRUE)),
            'KOTA' => $this->input->post('KOTA', TRUE),
            'TOTAL_QTYP' => str_replace(',', '', $this->input->post('TOTAL_QTYP', TRUE)),
            'TOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'KURS' => str_replace(',', '', $this->input->post('KURS', TRUE)),
            'NETT' => str_replace(',', '', $this->input->post('NETT', TRUE)),
            'FRANCO' => $this->input->post('FRANCO', TRUE),
            'PAYMENT' => $this->input->post('PAYMENT', TRUE),
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i:s"),
            'EXPORT' => '0',
            'FLAG' => 'PI'
        );
        // var_dump($datah, 'TEST');
        $this->transaksi_model->input_datah('proforma', $datah);
        $ID = $this->db->query("SELECT MAX(NO_ID) AS NO_ID FROM proforma WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $SIZE = $this->input->post('SIZE');
        $WARNA = $this->input->post('WARNA');
        $TGL_SJ = date("Y-m-d", strtotime($this->input->post('TGL_SJ', TRUE)));
        $QTYP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        $SATUAN = $this->input->post('SATUAN');
        $HARGAP = str_replace(',', '', $this->input->post('HARGAP', TRUE));
        $TOTAL = str_replace(',', '', $this->input->post('TOTAL', TRUE));
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'NO_BUKTI' => $bukti,
                'FLAG' => 'PI',
                'EXPORT' => '0',
                'NO_SO' => $this->input->post('NO_SO', TRUE),
                'TGL_SO' => date("Y-m-d", strtotime($this->input->post('TGL_SO', TRUE))),
                'KODEC' => $this->input->post('KODEC', TRUE),
                'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                'REC' => $REC[$i],
                'KD_BRG' => $KD_BRG[$i],
                'SIZE' => $SIZE[$i],
                'WARNA' => $WARNA[$i],
                'TGL_SJ' => date("Y-m-d", strtotime($TGL_SJ[$i])),
                'QTYP' => str_replace(',', '', $QTYP[$i]),
                'SATUAN' => $SATUAN[$i],
                'HARGAP' => str_replace(',', '', $HARGAP[$i]),
                'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                'PER' => $this->session->userdata['periode'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i:s")
            );
            $this->transaksi_model->input_datad('proformad', $datad);
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
        redirect('admin/Transaksi_ProformaInvoice/index_Transaksi_ProformaInvoice');
    }

    public function lihat($id)
    {
    }

    public function lihat_aksi()
    {
    }

    public function update($id)
    {
        $q1 = "SELECT proforma.NO_ID as ID,
                proforma.NO_BUKTI AS NO_BUKTI,
                proforma.TGL AS TGL,
                proforma.NO_SO AS NO_SO,
                proforma.TGL_SO AS TGL_SO,
                proforma.KODEC AS KODEC,
                proforma.NAMAC AS NAMAC,
                proforma.ALAMAT AS ALAMAT,
                proforma.WILAYAH AS WILAYAH,
                proforma.MAXKRE AS MAXKRE,
                proforma.KOTA AS KOTA,
                proforma.TOTAL_QTYP AS TOTAL_QTYP,
                proforma.TOTAL AS TTOTAL,
                proforma.KURS AS KURS,
                proforma.NETT AS NETT,
                proforma.FRANCO AS FRANCO,
                proforma.PAYMENT AS PAYMENT,

                proformad.NO_ID AS NO_ID,
                proformad.REC AS REC,
                proformad.KD_BRG AS KD_BRG,
                proformad.SIZE AS SIZE,
                proformad.WARNA AS WARNA,
                proformad.TGL_SJ AS TGL_SJ,
                proformad.QTYP AS QTYP,
                proformad.SATUAN AS SATUAN,
                proformad.HARGAP AS HARGAP,
                proformad.TOTAL AS TOTAL
            FROM proforma, proformad 
            WHERE proforma.NO_ID=$id 
            AND proforma.NO_ID=proformad.ID 
            ORDER BY proformad.REC";
        $data['proformainvoice'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_ProformaInvoice/Transaksi_ProformaInvoice_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NO_SO' => $this->input->post('NO_SO', TRUE),
            'TGL_SO' => date("Y-m-d", strtotime($this->input->post('TGL_SO', TRUE))),
            'KODEC' => $this->input->post('KODEC', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
            'ALAMAT' => $this->input->post('ALAMAT', TRUE),
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'MAXKRE' => str_replace(',', '', $this->input->post('MAXKRE', TRUE)),
            'KOTA' => $this->input->post('KOTA', TRUE),
            'TOTAL_QTYP' => str_replace(',', '', $this->input->post('TOTAL_QTYP', TRUE)),
            'TOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'KURS' => str_replace(',', '', $this->input->post('KURS', TRUE)),
            'NETT' => str_replace(',', '', $this->input->post('NETT', TRUE)),
            'FRANCO' => $this->input->post('FRANCO', TRUE),
            'PAYMENT' => $this->input->post('PAYMENT', TRUE),
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i:s"),
            'EXPORT' => '0',
            'FLAG' => 'PI'
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'proforma');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT proforma.NO_ID as ID,
                proforma.NO_BUKTI AS NO_BUKTI,
                proforma.TGL AS TGL,
                proforma.NO_SO AS NO_SO,
                proforma.TGL_SO AS TGL_SO,
                proforma.KODEC AS KODEC,
                proforma.NAMAC AS NAMAC,
                proforma.ALAMAT AS ALAMAT,
                proforma.WILAYAH AS WILAYAH,
                proforma.MAXKRE AS MAXKRE,
                proforma.KOTA AS KOTA,
                proforma.TOTAL_QTYP AS TOTAL_QTYP,
                proforma.TOTAL AS TTOTAL,
                proforma.KURS AS KURS,
                proforma.NETT AS NETT,
                proforma.FRANCO AS FRANCO,
                proforma.PAYMENT AS PAYMENT,

                proformad.NO_ID AS NO_ID,
                proformad.REC AS REC,
                proformad.KD_BRG AS KD_BRG,
                proformad.SIZE AS SIZE,
                proformad.WARNA AS WARNA,
                proformad.TGL_SJ AS TGL_SJ,
                proformad.QTYP AS QTYP,
                proformad.SATUAN AS SATUAN,
                proformad.HARGAP AS HARGAP,
                proformad.TOTAL AS TOTAL
            FROM proforma, proformad 
            WHERE proforma.NO_ID=$id 
            AND proforma.NO_ID=proformad.ID 
            ORDER BY proformad.REC";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $SIZE = $this->input->post('SIZE');
        $WARNA = $this->input->post('WARNA');
        $TGL_SJ = date("Y-m-d", strtotime($this->input->post('TGL_SJ', TRUE)));
        $QTYP = str_replace(',', '', $this->input->post('QTYP', TRUE));
        $SATUAN = $this->input->post('SATUAN');
        $HARGAP = str_replace(',', '', $this->input->post('HARGAP', TRUE));
        $TOTAL = str_replace(',', '', $this->input->post('TOTAL', TRUE));
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'NO_BUKTI' => $this->input->post('NO_BUKTI'),
                    'FLAG' => 'PI',
                    'EXPORT' => '0',
                    'NO_SO' => $this->input->post('NO_SO', TRUE),
                    'TGL_SO' => date("Y-m-d", strtotime($this->input->post('TGL_SO', TRUE))),
                    'KODEC' => $this->input->post('KODEC', TRUE),
                    'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                    'REC' => $REC[$URUT],
                    'KD_BRG' => $KD_BRG[$URUT],
                    'SIZE' => $SIZE[$URUT],
                    'WARNA' => $WARNA[$URUT],
                    'TGL_SJ' => date("Y-m-d", strtotime($TGL_SJ[$URUT])),
                    'QTYP' => str_replace(',', '', $QTYP[$URUT]),
                    'SATUAN' => $SATUAN[$URUT],
                    'HARGAP' => str_replace(',', '', $HARGAP[$URUT]),
                    'TOTAL' => str_replace(',', '', $TOTAL[$URUT]),
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i:s")
                );
                $where = array(
                    'NO_ID' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'proformad');
            } else {
                $where = array(
                    'NO_ID' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'proformad');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'ID' => $this->input->post('ID', TRUE),
                    'NO_BUKTI' => $this->input->post('NO_BUKTI'),
                    'FLAG' => 'PI',
                    'EXPORT' => '0',
                    'NO_SO' => $this->input->post('NO_SO', TRUE),
                    'TGL_SO' => date("Y-m-d", strtotime($this->input->post('TGL_SO', TRUE))),
                    'KODEC' => $this->input->post('KODEC', TRUE),
                    'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                    'REC' => $REC[$i],
                    'KD_BRG' => $KD_BRG[$i],
                    'SIZE' => $SIZE[$i],
                    'WARNA' => $WARNA[$i],
                    'TGL_SJ' => date("Y-m-d", strtotime($TGL_SJ[$i])),
                    'QTYP' => str_replace(',', '', $QTYP[$i]),
                    'SATUAN' => $SATUAN[$i],
                    'HARGAP' => str_replace(',', '', $HARGAP[$i]),
                    'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i:s")
                );
                $this->transaksi_model->input_datad('proformad', $datad);
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
        redirect('admin/Transaksi_ProformaInvoice/index_Transaksi_ProformaInvoice');
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'proforma');
        $where = array('ID' => $id);
        $this->transaksi_model->hapus_data($where, 'proformad');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_ProformaInvoice/index_Transaksi_ProformaInvoice');
    }

    function delete_multiple()
    {
        $this->transaksi_model->remove_checked('proforma', 'proformad');
        redirect('admin/Transaksi_ProformaInvoice/index_Transaksi_ProformaInvoice');
    }

    function filter_no_so()
    {
        $no_so = $this->input->get('no_so');
        $q1 = "SELECT KD_BRG AS KD_BRG, 
                QTYP AS QTYP,
                SIZE AS SIZE,
                WARNA AS WARNA,
                SATUAN AS SATUAN,
                HARGAP AS HARGAP,
                TOTAL AS TOTAL
            FROM sod 
            WHERE NO_BUKTI='$no_so' 
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_ProformaInvoice.jrxml");
        $NO_ID = $id;
        $query = "SELECT proforma.NO_ID as ID,
                proforma.NO_BUKTI AS NOSJ,
                proforma.TGL AS TGLCI,
                proforma.jtempo AS JTEMPO,
                proforma.tgfak AS TGFAK,
                proforma.nocet AS NOCET,
                proforma.nofaktr AS NOFAKTR,
                proforma.kodefak AS KODEFAK,
                proforma.invoice AS INVOICE,
                proforma.NO_ORDER AS NODO,
                proforma.kodecus AS KODECUS,
                proforma.nama AS NAMA,
                proforma.kdmts AS KDMTS,
                proforma.keter AS KETER,
                proforma.tlusin AS TLUSIN,
                proforma.tpair AS TPAIR,
                proforma.stand AS STAND,
                proforma.bulat AS BULAT,
                proforma.total AS TOTAL,
                proforma.dpp AS DPP,
                proforma.disc3 AS JENIS,
                proforma.disc2 AS KONTAN,
                proforma.dpptdisk AS DPPTDISK,
                proforma.disc7 AS DISC7,
                proforma.disc6 AS DISC6,
                proforma.disc5 AS DISC5,
                proforma.disc4 AS OB,
                proforma.tdisk AS TDISK,
                proforma.sisa AS SISA,
                proforma.ppn AS PPN,
                proforma.dpp1 AS DPP1,
                proforma.jumlah AS TJUMLAH,

                proformad.NO_ID AS NO_ID,
                proformad.rec AS REC,
                proformad.article AS ARTICLE,
                proformad.uraian AS URAIAN,
                proformad.lusin AS LUSIN,
                proformad.pair AS PAIR,
                proformad.harga AS HARGA,
                proformad.disc1 AS DISC1,
                proformad.disc2 AS DISC2,
                proformad.disc3 AS DISC3,
                proformad.disc4 AS DISC4,
                proformad.discrp AS DISCRP,
                proformad.disc AS DISC,
                proformad.jumlah AS JUMLAH,
                proformad.ket1 AS KET1,
                proformad.ket2 AS KET2
        FROM proforma,proformad  
        WHERE proforma.NO_ID = proformad.NO_ID 
        AND proforma.NO_ID = '" . $NO_ID . "' 
        ORDER BY proformad.NO_ID";
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
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}

<?php

class Transaksi_PembayaranBBM extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'piu') {
            $this->session->set_userdata('menu_penjualan', 'piu');
            $this->session->set_userdata('kode_menu', 'T0012');
            $this->session->set_userdata('keyword_bankjual', '');
            $this->session->set_userdata('order_bankjual', 'NO_BUKTI');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL', 'NOTES', 'TOTAL');
    var $column_search = array('NO_BUKTI', 'TGL', 'NOTES', 'TOTAL');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'FLAG' => 'BBM',
            'PER' => $periode
        );
        $this->db->select('*');
        $this->db->from('piu');
        $this->db->order_by('NO_BUKTI');
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
            'FLAG' => 'BBM',
            'PER' => $periode
        );
        $this->db->from('piu');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_piu()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $piu) {
            $no++;
            $row = array();
            $JASPER = "window.open('JASPER/" . $piu->NO_ID . "','', 'width=1000','height=900');";
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $piu->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_PembayaranBBM/update/' . $piu->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_PembayaranBBM/delete/' . $piu->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $piu->NO_BUKTI;
            $row[] = $piu->TGL;
            $row[] = $piu->NOTES;
            $row[] = $piu->TOTAL;
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

    public function index_Transaksi_PembayaranBBM()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Pembayaran BBM');
        $where = array(
            'FLAG' => 'BBM',
            'PER' => $periode
        );

		$cek_field_no_rbank = $this->db->query("SELECT COUNT(*) as ADA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'piu' AND COLUMN_NAME = 'NO_JLPIU'")->result();
		if ($cek_field_no_rbank[0]->ADA==0)
		{
			$this->db->query("ALTER TABLE `piu`
			ADD COLUMN `NO_JLPIU`  varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''");
		}

        $data['piu'] = $this->transaksi_model->tampil_data($where, 'piu', 'NO_BUKTI')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PembayaranBBM/Transaksi_PembayaranBBM', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PembayaranBBM/Transaksi_PembayaranBBM_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        // BBM - 1506 / 01 / 2022
        $per = $this->session->userdata['periode'];
        $nomer = $this->db->query("SELECT MAX(NO_BUKTI) as NO_BUKTI FROM piu WHERE PER='$per' AND FLAG='BBM'")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $value11 = substr($nom[0], 4, 8);
        $value22 = STRVAL($value11) + 1;
        $urut = str_pad($value22, 4, "0", STR_PAD_LEFT);
        $bukti = 'BBM' . '-' . $urut . '/' . substr($this->session->userdata['periode'], 0, 2) . '/' . substr($this->session->userdata['periode'], -4);
        $datah = array(
            'FLAG' => 'BBM',
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'KD_SETOR' => $this->input->post('KD_SETOR', TRUE),
            'NOTES' => $this->input->post('NOTES', TRUE),
            'TOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'NO_CHBG' => $this->input->post('NO_CHBG', TRUE),
            'BANK' => $this->input->post('BANK', TRUE),
            'JTEMPO' => date("Y-m-d", strtotime($this->input->post('JTEMPO', TRUE))),
            'TGL_CAIR' => date("Y-m-d", strtotime($this->input->post('TGL_CAIR', TRUE))),
            'GIRO' => str_replace(',', '', $this->input->post('GIRO', TRUE)),
            'TUNAI' => str_replace(',', '', $this->input->post('TUNAI', TRUE)),
            'KU' => str_replace(',', '', $this->input->post('KU', TRUE)),
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a")
        );
        $this->transaksi_model->input_datah('piu', $datah);
        // var_dump($datah);
        $ID = $this->db->query("SELECT MAX(NO_ID) AS NO_ID FROM piu WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $NO_SURAT = $this->input->post('NO_SURAT');
        $INVOICE = $this->input->post('INVOICE');
        $KODEC = $this->input->post('KODEC');
        $NAMAC = $this->input->post('NAMAC');
        $TGL_FKTR = $this->input->post('TGL_FKTR');
        $TGL_SURAT = $this->input->post('TGL_SURAT');
        $TOTAL = $this->input->post('TOTAL');
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'FLAG' => 'BBM',
                'NO_BUKTI' => $bukti,
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                'REC' => $REC[$i],
                'NO_SURAT' => $NO_SURAT[$i],
                'INVOICE' => $INVOICE[$i],
                'KODEC' => $KODEC[$i],
                'NAMAC' => $NAMAC[$i],
                'TGL_FKTR' => date("Y-m-d", strtotime($TGL_FKTR[$i])),
                'TGL_SURAT' => date("Y-m-d", strtotime($TGL_SURAT[$i])),
                'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                'PER' => $this->session->userdata['periode'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('piud', $datad);
            $i++;
        }
        // var_dump($datad);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_PembayaranBBM/index_Transaksi_PembayaranBBM');
    }

    public function lihat($id)
    {
    }

    public function lihat_aksi()
    {
    }

    public function update($id)
    {
        $q1 = "SELECT piu.NO_ID AS ID,
                piu.NO_BUKTI AS NO_BUKTI,
                piu.TGL AS TGL,
                piu.KD_SETOR AS KD_SETOR,
                piu.NOTES AS NOTES,
                piu.TOTAL AS TTOTAL,
                piu.NO_CHBG AS NO_CHBG,
                piu.BANK AS BANK,
                piu.JTEMPO AS JTEMPO,
                piu.TGL_CAIR AS TGL_CAIR,
                piu.GIRO AS GIRO,
                piu.TUNAI AS TUNAI,
                piu.KU AS KU,
                piu.NO_RBANK,
                coalesce((SELECT JUMLAH from rbank WHERE NO_BUKTI=piu.NO_RBANK limit 1), 0) as JUM_RBANK,
                coalesce((SELECT NO_ID from rbank WHERE NO_BUKTI=piu.NO_RBANK limit 1), 0) as NO_ID_RBANK,
                piu.NO_JLPIU,

                piud.NO_ID AS NO_ID,
                piud.REC AS REC,
                piud.NO_SURAT AS NO_SURAT,
                piud.INVOICE AS INVOICE,
                piud.KODEC AS KODEC,
                piud.NAMAC AS NAMAC,
                piud.TGL_FKTR AS TGL_FKTR,
                piud.TGL_SURAT AS TGL_SURAT,
                piud.TOTAL AS TOTAL
            FROM piu,piud
            WHERE piu.NO_ID=$id 
            AND piu.NO_BUKTI=piud.NO_BUKTI
            ORDER BY piud.REC";
        $data['pembayaranbbm'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PembayaranBBM/Transaksi_PembayaranBBM_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            'FLAG' => 'BBM',
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'KD_SETOR' => $this->input->post('KD_SETOR', TRUE),
            'NOTES' => $this->input->post('NOTES', TRUE),
            'TOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'NO_CHBG' => $this->input->post('NO_CHBG', TRUE),
            'BANK' => $this->input->post('BANK', TRUE),
            'JTEMPO' => date("Y-m-d", strtotime($this->input->post('JTEMPO', TRUE))),
            'TGL_CAIR' => date("Y-m-d", strtotime($this->input->post('TGL_CAIR', TRUE))),
            'GIRO' => str_replace(',', '', $this->input->post('GIRO', TRUE)),
            'TUNAI' => str_replace(',', '', $this->input->post('TUNAI', TRUE)),
            'KU' => str_replace(',', '', $this->input->post('KU', TRUE)),
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'NO_JLPIU' => $this->input->post('NO_JLPIU', TRUE),
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'piu');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT piu.NO_ID AS ID,
                piu.NO_BUKTI AS NO_BUKTI,
                piu.TGL AS TGL,
                piu.KD_SETOR AS KD_SETOR,
                piu.NOTES AS NOTES,
                piu.TOTAL AS TTOTAL,
                piu.NO_CHBG AS NO_CHBG,
                piu.BANK AS BANK,
                piu.JTEMPO AS JTEMPO,
                piu.TGL_CAIR AS TGL_CAIR,
                piu.GIRO AS GIRO,
                piu.TUNAI AS TUNAI,
                piu.KU AS KU,

                piud.NO_ID AS NO_ID,
                piud.REC AS REC,
                piud.NO_SURAT AS NO_SURAT,
                piud.INVOICE AS INVOICE,
                piud.KODEC AS KODEC,
                piud.NAMAC AS NAMAC,
                piud.TGL_FKTR AS TGL_FKTR,
                piud.TGL_SURAT AS TGL_SURAT,
                piud.TOTAL AS TOTAL
            FROM piu,piud
            WHERE piu.NO_ID=$id 
            AND piu.NO_BUKTI=piud.NO_BUKTI 
            ORDER BY piud.REC";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $NO_SURAT = $this->input->post('NO_SURAT');
        $INVOICE = $this->input->post('INVOICE');
        $KODEC = $this->input->post('KODEC');
        $NAMAC = $this->input->post('NAMAC');
        $TGL_FKTR = $this->input->post('TGL_FKTR');
        $TGL_SURAT = $this->input->post('TGL_SURAT');
        $TOTAL = $this->input->post('TOTAL');
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'FLAG' => 'BBM',
                    'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'REC' => $REC[$URUT],
                    'NO_SURAT' => $NO_SURAT[$URUT],
                    'INVOICE' => $INVOICE[$URUT],
                    'KODEC' => $KODEC[$URUT],
                    'NAMAC' => $NAMAC[$URUT],
                    'TGL_FKTR' => date("Y-m-d", strtotime($TGL_FKTR[$URUT])),
                    'TGL_SURAT' => date("Y-m-d", strtotime($TGL_SURAT[$URUT])),
                    'TOTAL' => str_replace(',', '', $TOTAL[$URUT]),
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a")
                );
                $where = array(
                    'NO_ID' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'piud');
            } else {
                $where = array(
                    'NO_ID' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'piud');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'FLAG' => 'BBM',
                    'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'REC' => $REC[$i],
                    'NO_SURAT' => $NO_SURAT[$i],
                    'INVOICE' => $INVOICE[$i],
                    'KODEC' => $KODEC[$i],
                    'NAMAC' => $NAMAC[$i],
                    'TGL_FKTR' => date("Y-m-d", strtotime($TGL_FKTR[$i])),
                    'TGL_SURAT' => date("Y-m-d", strtotime($TGL_SURAT[$i])),
                    'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('piud', $datad);
            }
            $i++;
        }
        if ($this->input->post('NO_JLPIU')!="")
        {
            $this->db->query("UPDATE jl_piu SET NO_PIU='".$this->input->post('NO_BUKTI')."' WHERE NO_BUKTI='".$this->input->post('NO_JLPIU')."'");
            $this->db->query("UPDATE rbank SET POSTED_KSR=1, POSTED_USR_KSR='".$this->session->userdata['username']."', POSTED_SMP_KSR=NOW() WHERE NO_PIU='".$this->input->post('NO_BUKTI')."'");
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Data Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_PembayaranBBM/index_Transaksi_PembayaranBBM');
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'piu');
        $where = array('ID' => $id);
        $this->transaksi_model->hapus_data($where, 'piud');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_PembayaranBBM/index_Transaksi_PembayaranBBM');
    }

    function delete_multiple()
    {
    }

    public function getDataAjax_no_surat()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_ID, 
                NO_BUKTI AS NO_SURAT,
                INVOICE AS INVOICE,
                KODEC AS KODEC,
                NAMAC AS NAMAC,
                DATE_FORMAT(TGL_FKTR, '%d-%m-%Y') AS TGL_FKTR,
                DATE_FORMAT(TGL_SJ, '%d-%m-%Y') AS TGL_SURAT,
                NETT AS TOTAL
            FROM jual
            WHERE FLAG='JR' AND (NO_BUKTI LIKE '%$search%' OR INVOICE LIKE '%$search%' OR KODEC LIKE '%$search%')
            ORDER BY NO_BUKTI LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_SURAT'],
                'text' => $row['NO_SURAT'],
                'NO_SURAT' => $row['NO_SURAT'] . " - " . $row['INVOICE'] . " - " . $row['KODEC'] . " - " . $row['TOTAL'],
                'INVOICE' => $row['INVOICE'],
                'KODEC' => $row['KODEC'],
                'NAMAC' => $row['NAMAC'],
                'TGL_FKTR' => $row['TGL_FKTR'],
                'TGL_SURAT' => $row['TGL_SURAT'],
                'TOTAL' => $row['TOTAL'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_PembayaranBBM.jrxml");
        $NO_ID = $id;
        $query = "SELECT piu.NO_ID AS ID,
                piu.NO_BUKTI AS NO_BUKTI,
                piu.TGL AS TGL,
                piu.kdmts AS KDMTS,
                piu.kd_setor AS KD_SETOR,
                piu.kodecus AS KODECUS,
                piu.nama AS NAMA,
                piu.acc AS ACC,
                piu.uraian AS URAIAN,
                piu.total AS TOTAL,
                piu.no_chgb AS NO_CHBG,
                piu.bank AS BANK,
                piu.tgljt AS TGLJT,
                piu.tgl_cair AS TGL_CAIR,
                piu.giro AS GIRO,
                piu.tunai AS TUNAI,
                piu.ku AS KU,

                piud.NO_ID AS NO_ID,
                piud.rec AS REC,
                piud.nosj AS NO_SURAT,
                piud.invoice AS INVOICE,
                piud.kodecus AS KODEC,
                piud.tgfak AS TGL_FKTR,
                piud.tglci AS TGL_SURAT,
                piud.tbayar AS TOTAL
            FROM piu,piud
            WHERE piu.NO_ID = piud.id 
            AND piu.NO_ID = '" . $NO_ID . "' 
            ORDER BY piud.NO_ID";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NAMA" => $row1["NAMA"],
                "KODECUS" => $row1["KODECUS"],
                "NO_BUKTI" => $row1["NO_BUKTI"],
                "NO_SURAT" => $row1["NO_SURAT"],
                "INVOICE" => $row1["INVOICE"],
                "TOTAL" => $row1["TOTAL"],
                "TGL" => $row1["TGL"],

            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }

    public function getDataAjaxRemote()
    {
    }
    
    function getjlpiu()
    {
        $no_jlpiu = $this->input->get('NO_JLPIU');
        $q1 = "SELECT '' as NO_BUKTI, '' as NO_SURAT, '' as INVOICE, '' as KODEC, '' as NAMAC, '' AS TGL_FKTR, '' AS TGL_SURAT, 0 as TOTAL ";
        if ($no_jlpiu!='') 
        {
            $q1 = "SELECT a.NO_BUKTI, b.NO_SURAT, b.INVOICE, b.KODEC, (SELECT NAMAC from cust WHERE KODEC=b.KODEC limit 1) as NAMAC, DATE_FORMAT(b.TGL_FKTR, '%d-%m-%Y') AS TGL_FKTR, DATE_FORMAT(b.TGL_SURAT, '%d-%m-%Y') AS TGL_SURAT, b.TOTAL 
            from jl_piu a, jl_piud b 
            WHERE a.NO_BUKTI=b.NO_BUKTI and a.NO_BUKTI='$no_jlpiu'";
        }
        $q2 = $this->db->query($q1);
        if ($q2->num_rows() > 0) {
            foreach ($q2->result() as $row) {
                $hasil[] = $row;
            }
        };
        echo json_encode($hasil);
    }
    
    public function updateRbank($id)
    {
        $sess_data['prog'] = 'PJL';
        $sess_data['grup'] = 0;
        $this->session->set_userdata($sess_data);

        $q1 = "SELECT bank.NO_ID as ID,
                bank.NO_BUKTI AS NO_BUKTI,
                -- LEFT(bank.NO_BUKTI,3) AS BUKTI, 
				CASE bank.KD
					WHEN '' THEN LEFT(bank.NO_BUKTI,4)
                    ELSE LEFT(bank.NO_BUKTI,5)
				END AS BUKTI,
                RIGHT(bank.NO_BUKTI,4) AS NOMER,
                bank.TGL AS TGL,
                bank.BACNO AS BACNO,
                bank.BNAMA AS BNAMA,
                bank.BNK AS BNK,
                bank.KD AS KD,
                bank.KET AS KET,
                bank.JUMLAH AS TJUMLAH,
                bank.JUMLAH AS TJUMLAH_TAMPUNGAN,
                bank.USRNM_KSR AS USRNM_KSR,
                bank.USRNM_ACC AS USRNM_ACC,
                bank.POSTED_KSR AS POSTED_KSR,
                bank.POSTED_ACC AS POSTED_ACC,

                bankd.NO_ID AS NO_ID,
                bankd.REC AS REC,
                bankd.ACNO AS ACNO,
                bankd.NAMA AS NAMA,
                bankd.URAIAN AS URAIAN,
                bankd.TGL_CAIR AS TGL_CAIR,
                bankd.BG AS BG,
                bankd.CAIR AS CAIR,
                bankd.JTEMPO AS JTEMPO,
                bankd.JUMLAH AS JUMLAH            
            FROM rbank bank, rbankd bankd
            WHERE bank.NO_ID=$id
            AND bank.NO_ID=bankd.ID
            ORDER BY bankd.REC";
        $data['bank_masuk'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PembayaranBBM/Transaksi_Bank_Rencana_BankMasuk_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function updateRbank_aksi()
    {
        $USRNM_ACC = '';
        $TG_SMP_ACC = '';
        $USRNM_KSR = '';
        $TG_SMP_KSR = '';
        if ($this->session->userdata['prog'] == 'KASIR') {
            $USRNM_KSR = $this->session->userdata['username'];
            $TG_SMP_KSR = date("Y-m-d H:i:s");
        } else if ($this->session->userdata['prog'] == 'ACCOUNTING') {
            $USRNM_ACC = $this->session->userdata['username'];
            $TG_SMP_ACC = date("Y-m-d H:i:s");
        }
        $per = $this->session->userdata['periode'];
        $tahun = substr($this->session->userdata['periode'], -2);
        $bulan = substr($this->session->userdata['periode'], 0, 2);
        $bukti = $this->input->post('BUKTI', TRUE);
        $nomer = $this->input->post('NOMER', TRUE);
        $jenis = $bukti . '-' . $tahun . $bulan;
        $nomer = $this->input->post('NOMER', TRUE);
        $nobukti = $jenis . $nomer;
        $no_id = $this->input->post('ID', TRUE);
        $ceknobukti = $this->db->query("SELECT count(NO_BUKTI) AS NO_BUKTI FROM rbank WHERE NO_BUKTI='$nobukti' AND PER='$per' AND NO_ID != '$no_id'")->result();
        foreach ($ceknobukti as $no_bukti) {
        }
        if ($no_bukti->NO_BUKTI == 0) {
            $xx = $this->db->query("SELECT NO_BUKTI AS BUKTIX FROM rbank WHERE NO_ID='$no_id'")->result();
            $buktix = $xx[0]->BUKTIX;
            $this->db->query("CALL bankdel('" . $buktix . "')");
            $datah = array(
                // 'NO_BUKTI' => $nobukti,
                // 'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                // 'BACNO' => $this->input->post('BACNO', TRUE),
                // 'BNAMA' => $this->input->post('BNAMA', TRUE),
                // 'BNK' => $this->input->post('BNK', TRUE),
                // 'KD' => $this->input->post('KD', TRUE),
                // 'KET' => $this->input->post('KET', TRUE),
                'JUMLAH' => str_replace(',', '', $this->input->post('TJUMLAH', TRUE)),
                // 'FLAG' => 'B',
                // 'TYPE' => 'RBBM',
                // 'PER' =>  $this->session->userdata['periode'],
                // 'USRNM_ACC' => $USRNM_ACC,
                // 'TG_SMP_ACC' => $TG_SMP_ACC,
                // 'USRNM_KSR' => $USRNM_KSR,
                // 'TG_SMP_KSR' => $TG_SMP_KSR
            );
            $where = array(
                'NO_ID' => $this->input->post('ID', TRUE)
            );
            $this->transaksi_model->update_data($where, $datah, 'rbank');
            $id = $this->input->post('ID', TRUE);
            $q1 = "SELECT rbankd.NO_ID AS NO_ID FROM rbank, rbankd 
            WHERE rbank.NO_ID=$id AND rbank.NO_ID=rbankd.ID ORDER BY rbankd.REC";
            $data = $this->transaksi_model->edit_data($q1)->result();
            $NO_ID = $this->input->post('NO_ID');
            $REC = $this->input->post('REC');
            $ACNO = $this->input->post('ACNO');
            $NAMA = $this->input->post('NAMA');
            $URAIAN = $this->input->post('URAIAN');
            $JUMLAH = str_replace(',', '', $this->input->post('JUMLAH', TRUE));
            $DEBET = str_replace(',', '', $this->input->post('JUMLAH', TRUE));
            $TGL_CAIR = $this->input->post('TGL_CAIR');
            $BG = $this->input->post('BG');
            $CAIR = $this->input->post('CAIR');
            $JTEMPO = $this->input->post('JTEMPO');
            $jum = count($data);
            $ID = array_column($data, 'NO_ID');
            $jumy = count($NO_ID);
            $i = 0;
            while ($i < $jum) {
                if (in_array($ID[$i], $NO_ID)) {
                    $URUT = array_search($ID[$i], $NO_ID);
                    $datad = array(
                        'NO_BUKTI' => $nobukti,
                        'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                        'BACNO' => $this->input->post('BACNO', TRUE),
                        'BNAMA' => $this->input->post('BNAMA', TRUE),
                        'REC' => $REC[$URUT],
                        'ACNO' => $ACNO[$URUT],
                        'NAMA' => $NAMA[$URUT],
                        'URAIAN' => $URAIAN[$URUT],
                        'JUMLAH' => str_replace(',', '', $JUMLAH[$URUT]),
                        'DEBET' => str_replace(',', '', $DEBET[$URUT]),
                        'TGL_CAIR' => date("Y-m-d", strtotime($TGL_CAIR[$URUT])),
                        'BG' => $BG[$URUT],
                        'CAIR' => isset($CAIR[$URUT]) ? $CAIR[$URUT] : 0,
                        'JTEMPO' => date("Y-m-d", strtotime($JTEMPO[$URUT])),
                        'FLAG' => 'B',
                        'TYPE' => 'RBBM',
                        'PER' => $this->session->userdata['periode'],
                        'USRNM_ACC' => $USRNM_ACC,
                        'TG_SMP_ACC' => $TG_SMP_ACC,
                        'USRNM_KSR' => $USRNM_KSR,
                        'TG_SMP_KSR' => $TG_SMP_KSR
                    );
                    $where = array(
                        'NO_ID' => $NO_ID[$URUT]
                    );
                    $this->transaksi_model->update_data($where, $datad, 'rbankd');
                } else {
                    $where = array(
                        'NO_ID' => $ID[$i]
                    );
                    $this->transaksi_model->hapus_data($where, 'rbankd');
                }
                $i++;
            }
            $i = 0;
            while ($i < $jumy) {
                if ($NO_ID[$i] == "0") {
                    $datad = array(
                        'ID' => $this->input->post('ID', TRUE),
                        'NO_BUKTI' => $nobukti,
                        'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                        'BACNO' => $this->input->post('BACNO', TRUE),
                        'BNAMA' => $this->input->post('BNAMA', TRUE),
                        'REC' => $REC[$i],
                        'ACNO' => $ACNO[$i],
                        'NAMA' => $NAMA[$i],
                        'URAIAN' => $URAIAN[$i],
                        'JUMLAH' => str_replace(',', '', $JUMLAH[$i]),
                        'DEBET' => str_replace(',', '', $DEBET[$i]),
                        'TGL_CAIR' => date("Y-m-d", strtotime($TGL_CAIR[$i])),
                        'BG' => $BG[$i],
                        'CAIR' => isset($CAIR[$i]) ? $CAIR[$i] : 0,
                        'JTEMPO' => date("Y-m-d", strtotime($JTEMPO[$i])),
                        'FLAG' => 'B',
                        'TYPE' => 'RBBM',
                        'PER' => $this->session->userdata['periode'],
                        'USRNM_ACC' => $USRNM_ACC,
                        'TG_SMP_ACC' => $TG_SMP_ACC,
                        'USRNM_KSR' => $USRNM_KSR,
                        'TG_SMP_KSR' => $TG_SMP_KSR
                    );
                    $this->transaksi_model->input_datad('rbankd', $datad);
                }
                
                // $this->buat_BG_Bank($nobukti,'BBM');
                $i++;
            }
            $xx = $this->db->query("SELECT NO_BUKTI AS BUKTIX FROM rbank WHERE NO_BUKTI='$nobukti'")->result();
            $no_bukti = $xx[0]->BUKTIX;
            // $this->db->query("CALL bankins('" . $no_bukti . "')");
            $usrnmx = $this->session->userdata['username'];
            // $this->db->query("CALL kasir_rbank_cair('" . $no_bukti . "','" . $usrnmx . "')");
			// mysqli_next_result($this->db->conn_id);
            // $this->bukti_Minus($no_bukti);
            // $this->buat_piu($no_bukti,'RBBM');

            $this->session->set_flashdata(
                'pesannobuktidobel',
                '<div class="alert alert-success alert-dismissible fade show" role="alert"> Berhasil Di Update No Bukti - ' . $no_bukti . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
            );
            $this->finish_update_rbank($nobukti);
        } else {
            $this->session->set_flashdata(
                'pesannobuktidobel',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                    Data No Bukti Sudah Ada
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div>'
            );
            $this->finish_update_rbank($nobukti);
        }
    }

    public function finish_update_rbank($no_bukti)
    {
        echo "<b>Berhasil ubah data Rencana Bank Masuk ".$no_bukti." . Otomatis tertutup dalam 4 detik..</b>";
        echo '<script> window.setTimeout("window.close()", 4000); </script>';
    }
    
    public function getDataAjax_account()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT ACNO, NAMA, BNK
            FROM account
            WHERE BNK<>1 AND BNK<>2 AND(ACNO LIKE '%$search%' OR NAMA LIKE '%$search%' OR BNK LIKE '%$search%')
            ORDER BY ACNO LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['ACNO'],
                'text' => $row['ACNO'],
                'ACNO' => $row['ACNO'] . " - " . $row['NAMA'] . " - " . $row['BNK'],
                'NAMA' => $row['NAMA'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }
    
    public function getDataAjax_no_fktr()
    {
        $kodes = $this->input->post('kodes');
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_BUKTI AS NO_FKTR, TOTAL AS JUMLAH
            FROM piu
            WHERE FLAG = 'HT' 
            AND NO_KASIR <>''
            AND KODEC = '$kodes' 
            AND (NO_BUKTI LIKE '%$search%')
            ORDER BY NO_BUKTI LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_FKTR'],
                'text' => $row['NO_FKTR'],
                'NO_FKTR' => $row['NO_FKTR'],
                'JUMLAH' => $row['JUMLAH'],
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
        $results = $this->db->query("SELECT KODEC, NAMAC
            FROM cust
            WHERE KODEC LIKE '%$search%' OR NAMAC LIKE '%$search%'
            ORDER BY KODEC LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KODEC'],
                'text' => $row['KODEC'],
                'KODEC' => $row['KODEC'] . " - " . $row['NAMAC'],
                'NAMAC' => $row['NAMAC'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }
    
    function cekBG()
    {
        $NO_BG = $this->input->get('NO_BG');
        $q1 = "SELECT NO_BG
            FROM bg WHERE NO_BG='$NO_BG'";
        $q2 = $this->db->query($q1);
        if ($q2->num_rows() > 0) {
            foreach ($q2->result() as $row) {
                $hasil[] = $row;
            }
        };
        echo json_encode($hasil);
    }
}

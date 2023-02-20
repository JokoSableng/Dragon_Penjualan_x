<?php

class Transaksi_PembayaranBKM extends CI_Controller
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
            $this->session->set_userdata('kode_menu', 'T0011');
            $this->session->set_userdata('keyword_piu', '');
            $this->session->set_userdata('order_piu', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL', 'NOTES', 'TOTAL');
    var $column_search = array('NO_BUKTI', 'TGL', 'NOTES', 'TOTAL');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'FLAG' => 'BKM',
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
            'FLAG' => 'BKM',
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
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_PembayaranBKM/update/' . $piu->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_PembayaranBKM/delete/' . $piu->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
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

    public function index_Transaksi_PembayaranBKM()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Pembayaran BKM');
        $where = array(
            'FLAG' => 'BKM',
            'PER' => $periode
        );
        $data['piu'] = $this->transaksi_model->tampil_data($where, 'piu', 'NO_BUKTI')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PembayaranBKM/Transaksi_PembayaranBKM', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PembayaranBKM/Transaksi_PembayaranBKM_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        // BKM - 1506 / 01 / 2022
        $per = $this->session->userdata['periode'];
        $nomer = $this->db->query("SELECT MAX(NO_BUKTI) as NO_BUKTI FROM piu WHERE PER='$per' AND FLAG='BKM'")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $value11 = substr($nom[0], 4, 8);
        $value22 = STRVAL($value11) + 1;
        $urut = str_pad($value22, 4, "0", STR_PAD_LEFT);
        $bukti = 'BKM' . '-' . $urut . '/' . substr($this->session->userdata['periode'], 0, 2) . '/' . substr($this->session->userdata['periode'], -4);
        $datah = array(
            'FLAG' => 'BKM',
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'KD_SETOR' => $this->input->post('KD_SETOR', TRUE),
            // 'KODEC' => $this->input->post('KODEC', TRUE),
            // 'NAMAC' => $this->input->post('NAMAC', TRUE),
            'ACC' => $this->input->post('ACC', TRUE),
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
                'FLAG' => 'BKM',
                'NO_BUKTI' => $bukti,
                'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                // 'KODEC' => $this->input->post('KODEC', TRUE),
                // 'NAMAC' => $this->input->post('NAMAC', TRUE),
                'KODEC' => $KODEC[$i],
                'NAMAC' => $NAMAC[$i],
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                'REC' => $REC[$i],
                'NO_SURAT' => $NO_SURAT[$i],
                'INVOICE' => $INVOICE[$i],
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
        redirect('admin/Transaksi_PembayaranBKM/index_Transaksi_PembayaranBKM');
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
                piu.WILAYAH AS WILAYAH,
                piu.KD_SETOR AS KD_SETOR,
                -- piu.KODEC AS KODEC,
                -- piu.NAMAC AS NAMAC,
                piu.ACC AS ACC,
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
        $data['pembayaranbkm'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PembayaranBKM/Transaksi_PembayaranBKM_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            'FLAG' => 'BKM',
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'KD_SETOR' => $this->input->post('KD_SETOR', TRUE),
            // 'KODEC' => $this->input->post('KODEC', TRUE),
            // 'NAMAC' => $this->input->post('NAMAC', TRUE),
            'ACC' => $this->input->post('ACC', TRUE),
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
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'piu');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT piu.NO_ID AS ID,
                piu.NO_BUKTI AS NO_BUKTI,
                piu.TGL AS TGL,
                piu.WILAYAH AS WILAYAH,
                piu.KD_SETOR AS KD_SETOR,
                -- piu.KODEC AS KODEC,
                -- piu.NAMAC AS NAMAC,
                piu.ACC AS ACC,
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
            AND piu.NO_ID=piud.id 
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
                    'FLAG' => 'BKM',
                    'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
                    'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                    // 'KODEC' => $this->input->post('KODEC', TRUE),
                    // 'NAMAC' => $this->input->post('NAMAC', TRUE),
                    'KODEC' => $KODEC[$URUT],
                    'NAMAC' => $NAMAC[$URUT],
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'REC' => $REC[$URUT],
                    'NO_SURAT' => $NO_SURAT[$URUT],
                    'INVOICE' => $INVOICE[$URUT],
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
                    'FLAG' => 'BKM',
                    'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
                    'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                    // 'KODEC' => $this->input->post('KODEC', TRUE),
                    // 'NAMAC' => $this->input->post('NAMAC', TRUE),
                    'KODEC' => $KODEC[$i],
                    'KODEC' => $KODEC[$i],
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'REC' => $REC[$i],
                    'NO_SURAT' => $NO_SURAT[$i],
                    'INVOICE' => $INVOICE[$i],
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
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Data Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_PembayaranBKM/index_Transaksi_PembayaranBKM');
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
        redirect('admin/Transaksi_PembayaranBKM/index_Transaksi_PembayaranBKM');
    }

    function delete_multiple()
    {
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
        $results = $this->db->query("SELECT NO_ID, WILAYAH
            FROM wilayah
            WHERE WILAYAH LIKE '%$search%'
            ORDER BY WILAYAH LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['WILAYAH'],
                'text' => $row['WILAYAH'],
                'WILAYAH' => $row['WILAYAH'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getDataAjax_cust()
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
        $results = $this->db->query("SELECT NO_ID, KODEC, NAMAC
            FROM cust
            WHERE WILAYAH = '$wilayah' AND (KODEC LIKE '%$search%' OR NAMAC LIKE '%$search%')
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

    public function getDataAjax_no_surat()
    {
        $kodec = $this->input->post('kodec');
        $filterkodec="";
        if($kodec)
        {
            $filterkodec=" and KODEC = '$kodec' ";
        }
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
            WHERE FLAG='JR' $filterkodec AND (NO_BUKTI LIKE '%$search%' OR INVOICE LIKE '%$search%')
            ORDER BY NO_BUKTI LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_SURAT'],
                'text' => $row['NO_SURAT'],
                'NO_SURAT' => $row['NO_SURAT'] . " - " . $row['INVOICE'] . " - " . $row['TGL_FKTR'] . " - " . $row['TOTAL'],
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Pembayaran_BKM.jrxml");
        $this->load->helper("terbilang");
        $NO_ID = $id;
        $query = "SELECT piu.NO_ID AS ID,
                piu.NO_BUKTI AS NO_BUKTI,
                piu.TGL AS TGL,
                '' AS KDMTS,
                piu.kd_setor AS KD_SETOR,
                piu.KODEC AS KODECUS,
                piu.NAMAC AS NAMA,
                piu.acc AS ACC,
                '' AS URAIAN,
                '' AS NO_CHBG,
                piu.bank AS BANK,
                '' AS TGLJT,
                piu.tgl_cair AS TGL_CAIR,
                piu.giro AS GIRO,
                piu.tunai AS TUNAI,
                piu.ku AS KU,
                piu.total AS TTOTAL,

                piud.NO_ID AS NO_ID,
                piud.total AS TOTALX,
                piud.rec AS REC,
                '' AS NO_SURAT,
                piud.invoice AS INVOICE,
                '' AS KODEC,
                '' AS TGL_FKTR,
                '' AS TGL_SURAT,
                '' AS TOTAL
            FROM piu,piud
            WHERE piu.NO_ID = piud.id 
            AND piu.NO_ID = $NO_ID 
            ORDER BY piud.NO_ID";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NAMA" => $row1["NAMA"],
                "KODECUS" => $row1["KODECUS"],
                "NOBKK" => $row1["NO_BUKTI"],
                "NO_SURAT" => $row1["NO_SURAT"],
                "INVOICE" => $row1["INVOICE"],
                "TBAYAR" => $row1["TOTALX"],
                "TTBAYAR" => $row1["TTOTAL"],
                "TGL_TRAN" => date("d-m-Y", strtotime($row1["TGL"])),
                "ACC" => $row1["ACC"],
                "TERBILANG" => number_to_words($row1["TTOTAL"]),
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }

    public function getDataAjaxRemote()
    {
    }
}

<?php

class Transaksi_CekBKM_PMSB extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'jl_piu') {
            $this->session->set_userdata('menu_penjualan', 'jl_piu');
            $this->session->set_userdata('kode_menu', 'T0011');
            $this->session->set_userdata('keyword_jl_piu', '');
            $this->session->set_userdata('order_jl_piu', 'NO_ID');
        }
    }

    var $column_order = array(null, 'NO_BUKTI', 'TGL', 'KODEC', 'NOTES', 'WILAYAH');
    var $column_search = array('NO_BUKTI', 'TGL', 'KODEC', 'NOTES', 'WILAYAH');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'FLAG' => 'BKM',
            'PER' => $periode
        );
        $this->db->select('NO_ID, NO_BUKTI, TGL, KODEC, NOTES, WILAYAH');
        $this->db->from('jl_piu');
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
        $this->db->from('jl_piu');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_jl_piu()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $jl_piu) {
            $no++;
            $row = array();
            $JASPER = "window.open('JASPER/" . $jl_piu->NO_ID . "','', 'width=1000','height=900');";
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $jl_piu->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_CekBKM_PMSB/update/' . $jl_piu->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_CekBKM_PMSB/delete/' . $jl_piu->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $jl_piu->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($jl_piu->TGL, TRUE));
            $row[] = $jl_piu->KODEC;
            $row[] = $jl_piu->NOTES;
            $row[] = $jl_piu->WILAYAH;
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

    public function index_Transaksi_CekBKM_PMSB()
    {
        $where = array();
        $data['wilayah'] = $this->transaksi_model->tampil_data($where, 'wilayah', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_CekBKM_PMSB/Transaksi_CekBKM_PMSB', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_CekBKM_PMSB/Transaksi_CekBKM_PMSB_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        // BKM - 1506 / 01 / 2022
        $bukti = $this->input->post('NO_BUKTI', TRUE);
        $datah = array(
            'FLAG' => 'BKM',
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'WILAYAH' => $this->input->post('WILAYAH', TRUE),
            'KD_SETOR' => $this->input->post('KD_SETOR', TRUE),
            'KODEC' => $this->input->post('KODEC', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
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
        $this->transaksi_model->input_datah('jl_piu', $datah);
        // var_dump($datah);
        $ID = $this->db->query("SELECT MAX(NO_ID) AS NO_ID FROM jl_piu WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $NO_SURAT = $this->input->post('NO_SURAT');
        $INVOICE = $this->input->post('INVOICE');
        $TGL_FKTR = $this->input->post('TGL_FKTR');
        $TGL_SURAT = $this->input->post('TGL_SURAT');
        $TOTAL = $this->input->post('TOTAL');
        $TANDA = $this->input->post('TANDA');
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'FLAG' => 'BKM',
                'NO_BUKTI' => $bukti,
                'WILAYAH' => $this->input->post('WILAYAH', TRUE),
                'KODEC' => $this->input->post('KODEC', TRUE),
                'NAMAC' => $this->input->post('NAMAC', TRUE),
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                'REC' => $REC[$i],
                'NO_SURAT' => $NO_SURAT[$i],
                'INVOICE' => $INVOICE[$i],
                'TGL_FKTR' => date("Y-m-d", strtotime($TGL_FKTR[$i])),
                'TGL_SURAT' => date("Y-m-d", strtotime($TGL_SURAT[$i])),
                'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                'TANDA' => $TANDA[$i],
                'PER' => $this->session->userdata['periode'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('jl_piud', $datad);
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
        redirect('admin/Transaksi_CekBKM_PMSB/index_Transaksi_CekBKM_PMSB');
    }

    public function lihat($id)
    {
    }

    public function lihat_aksi()
    {
    }

    public function update($id)
    {
        $q1 = "SELECT jl_piu.NO_ID AS ID,
                jl_piu.NO_BUKTI AS NO_BUKTI,
                jl_piu.TGL AS TGL,
                jl_piu.WILAYAH AS WILAYAH,
                jl_piu.KD_SETOR AS KD_SETOR,
                jl_piu.KODEC AS KODEC,
                jl_piu.NAMAC AS NAMAC,
                jl_piu.ACC AS ACC,
                jl_piu.NOTES AS NOTES,
                jl_piu.TOTAL AS TTOTAL,
                jl_piu.NO_CHBG AS NO_CHBG,
                jl_piu.BANK AS BANK,
                jl_piu.JTEMPO AS JTEMPO,
                jl_piu.TGL_CAIR AS TGL_CAIR,
                jl_piu.GIRO AS GIRO,
                jl_piu.TUNAI AS TUNAI,
                jl_piu.KU AS KU,

                jl_piud.NO_ID AS NO_ID,
                jl_piud.REC AS REC,
                jl_piud.NO_SURAT AS NO_SURAT,
                jl_piud.INVOICE AS INVOICE,
                jl_piud.TGL_FKTR AS TGL_FKTR,
                jl_piud.TGL_SURAT AS TGL_SURAT,
                jl_piud.TOTAL AS TOTAL,
                jl_piud.TANDA AS TANDA,
                '*' AS TANDAX
            FROM jl_piu,jl_piud
            WHERE jl_piu.NO_ID=$id 
            AND jl_piu.NO_ID=jl_piud.id 
            ORDER BY jl_piud.REC";
        $data['cekbkm_pmsb'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_CekBKM_PMSB/Transaksi_CekBKM_PMSB_update', $data);
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
            'KODEC' => $this->input->post('KODEC', TRUE),
            'NAMAC' => $this->input->post('NAMAC', TRUE),
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
        $this->transaksi_model->update_data($where, $datah, 'jl_piu');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT jl_piu.NO_ID AS ID,
                jl_piu.NO_BUKTI AS NO_BUKTI,
                jl_piu.TGL AS TGL,
                jl_piu.WILAYAH AS WILAYAH,
                jl_piu.KD_SETOR AS KD_SETOR,
                jl_piu.KODEC AS KODEC,
                jl_piu.NAMAC AS NAMAC,
                jl_piu.ACC AS ACC,
                jl_piu.NOTES AS NOTES,
                jl_piu.TOTAL AS TTOTAL,
                jl_piu.NO_CHBG AS NO_CHBG,
                jl_piu.BANK AS BANK,
                jl_piu.JTEMPO AS JTEMPO,
                jl_piu.TGL_CAIR AS TGL_CAIR,
                jl_piu.GIRO AS GIRO,
                jl_piu.TUNAI AS TUNAI,
                jl_piu.KU AS KU,

                jl_piud.NO_ID AS NO_ID,
                jl_piud.REC AS REC,
                jl_piud.NO_SURAT AS NO_SURAT,
                jl_piud.INVOICE AS INVOICE,
                jl_piud.TGL_FKTR AS TGL_FKTR,
                jl_piud.TGL_SURAT AS TGL_SURAT,
                jl_piud.TOTAL AS TOTAL,
                jl_piud.TANDA AS TANDA
            FROM jl_piu,jl_piud
            WHERE jl_piu.NO_ID=$id 
            AND jl_piu.NO_ID=jl_piud.id 
            ORDER BY jl_piud.REC";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $NO_SURAT = $this->input->post('NO_SURAT');
        $INVOICE = $this->input->post('INVOICE');
        $TGL_FKTR = $this->input->post('TGL_FKTR');
        $TGL_SURAT = $this->input->post('TGL_SURAT');
        $TOTAL = $this->input->post('TOTAL');
        $TANDA = $this->input->post('TANDA');
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
                    'KODEC' => $this->input->post('KODEC', TRUE),
                    'NAMAC' => $this->input->post('NAMAC', TRUE),
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'REC' => $REC[$URUT],
                    'NO_SURAT' => $NO_SURAT[$URUT],
                    'INVOICE' => $INVOICE[$URUT],
                    'TGL_FKTR' => date("Y-m-d", strtotime($TGL_FKTR[$URUT])),
                    'TGL_SURAT' => date("Y-m-d", strtotime($TGL_SURAT[$URUT])),
                    'TOTAL' => str_replace(',', '', $TOTAL[$URUT]),
                    'TANDA' => $TANDA[$URUT],
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a")
                );
                $where = array(
                    'NO_ID' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'jl_piud');
            } else {
                $where = array(
                    'NO_ID' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'jl_piud');
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
                    'KODEC' => $this->input->post('KODEC', TRUE),
                    'NAMAC' => $this->input->post('NAMAC', TRUE),
                    'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'REC' => $REC[$i],
                    'NO_SURAT' => $NO_SURAT[$i],
                    'INVOICE' => $INVOICE[$i],
                    'TGL_FKTR' => date("Y-m-d", strtotime($TGL_FKTR[$i])),
                    'TGL_SURAT' => date("Y-m-d", strtotime($TGL_SURAT[$i])),
                    'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                    'TANDA' => str_replace(',', '', $TANDA[$i]),
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('jl_piud', $datad);
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
        redirect('admin/Transaksi_CekBKM_PMSB/index_Transaksi_CekBKM_PMSB');
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'jl_piu');
        $where = array('ID' => $id);
        $this->transaksi_model->hapus_data($where, 'jl_piud');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_CekBKM_PMSB/index_Transaksi_CekBKM_PMSB');
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
                DATE_FORMAT(TGL_FKTR, '%d-%m-%Y') AS TGL_FKTR,
                DATE_FORMAT(TGL_SJ, '%d-%m-%Y') AS TGL_SURAT,
                NETT AS TOTAL
            FROM jual
            WHERE KODEC = '$kodec' AND FLAG='JR' AND (NO_BUKTI LIKE '%$search%' OR INVOICE LIKE '%$search%')
            ORDER BY NO_BUKTI LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_SURAT'],
                'text' => $row['NO_SURAT'],
                'NO_SURAT' => $row['NO_SURAT'] . " - " . $row['INVOICE'] . " - " . $row['TGL_FKTR'] . " - " . $row['TOTAL'],
                'INVOICE' => $row['INVOICE'],
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
        $query = "SELECT jl_piu.NO_ID AS ID,
                jl_piu.NO_BUKTI AS NO_BUKTI,
                jl_piu.TGL AS TGL,
                '' AS KDMTS,
                jl_piu.kd_setor AS KD_SETOR,
                jl_piu.KODEC AS KODECUS,
                jl_piu.NAMAC AS NAMA,
                jl_piu.acc AS ACC,
                '' AS URAIAN,
                '' AS NO_CHBG,
                jl_piu.bank AS BANK,
                '' AS TGLJT,
                jl_piu.tgl_cair AS TGL_CAIR,
                jl_piu.giro AS GIRO,
                jl_piu.tunai AS TUNAI,
                jl_piu.ku AS KU,
                jl_piu.total AS TTOTAL,

                jl_piud.NO_ID AS NO_ID,
                jl_piud.total AS TOTALX,
                jl_piud.rec AS REC,
                '' AS NO_SURAT,
                jl_piud.invoice AS INVOICE,
                '' AS KODEC,
                '' AS TGL_FKTR,
                '' AS TGL_SURAT,
                '' AS TOTAL
            FROM jl_piu,jl_piud
            WHERE jl_piu.NO_ID = jl_piud.id 
            AND jl_piu.NO_ID = $NO_ID 
            ORDER BY jl_piud.NO_ID";
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

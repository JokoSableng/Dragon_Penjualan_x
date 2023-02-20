<?php

class Transaksi_Bkk_Kasir extends CI_Controller
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
        if ($this->session->userdata['menu_pemasaran'] != 'kas') {
            $this->session->set_userdata('menu_pemasaran', 'kas');
            $this->session->set_userdata('kode_menu', 'T0010');
            $this->session->set_userdata('keyword_kas', '');
            $this->session->set_userdata('order_kas', 'NO_ID');
        }
    }

    var $column_order = array(null, null, null, 'NO_BUKTI', 'TGL', 'NOTES', 'FLAG2');
    var $column_search = array('NO_BUKTI', 'TGL', 'NOTES', 'FLAG2');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PMS',
            'FLAG2' => 'BKK'
        );
        $this->db->select('*');
        $this->db->from('kas');
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
            'FLAG' => 'PMS',
            'FLAG2' => 'BKK'
        );
        $this->db->from('kas');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_kas()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $kas) {
            $JASPER = "window.open('JASPER/" . $kas->NO_ID . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $kas->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Bkk_Kasir/lihat/' . $kas->NO_ID) . '"> <i class="fa fa-eye"></i> Lihat</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Bkk_Kasir/update/' . $kas->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Bkk_Kasir/delete/' . $kas->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $kas->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($kas->TGL));
            $row[] = $kas->NOTES;
            $row[] = $kas->FLAG2;
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

    public function index_Transaksi_Bkk_Kasir()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Bkk Kasir');
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PMS',
            'FLAG2' => 'BKK'
        );
        $data['kas'] = $this->transaksi_model->tampil_data($where, 'kas', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Bkk_Kasir/Transaksi_Bkk_Kasir', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Bkk_Kasir/Transaksi_Bkk_Kasir_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $per = $this->session->userdata['periode'];
        $kdmts = $this->session->userdata['kdmts'];
        if (substr($this->session->userdata['periode'], 0, 2) == 1) {
            $ROMAWI = 'I';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 2) {
            $ROMAWI = 'II';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 3) {
            $ROMAWI = 'III';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 4) {
            $ROMAWI = 'IV';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 5) {
            $ROMAWI = 'V';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 6) {
            $ROMAWI = 'VI';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 7) {
            $ROMAWI = 'VII';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 8) {
            $ROMAWI = 'VIII';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 9) {
            $ROMAWI = 'IX';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 10) {
            $ROMAWI = 'X';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 11) {
            $ROMAWI = 'XI';
        }
        if (substr($this->session->userdata['periode'], 0, 2) == 12) {
            $ROMAWI = 'XII';
        }
        $nomer = $this->db->query("SELECT left(MAX(NO_BUKTI),4) as NO_BUKTI FROM ajuan WHERE PER='$per' AND WILAYAH='$kdmts' ")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $urut = str_pad($nom[0] + 1, 4, "0", STR_PAD_LEFT);
        $bukti = $urut . '/' . 'BKK' . '/' . $kdmts . '/' . $ROMAWI . '/' . substr($this->session->userdata['periode'], -2);
        $datah = array(
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NOTES' => $this->input->post('NOTES'),
            'TTOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'WILAYAH' => $this->session->userdata['kdmts'],
            'PERKE' => $this->session->userdata['fase'],
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'PMS',
            'FLAG2' => 'BKK',
        );
        $this->transaksi_model->input_datah('kas', $datah);
        $ID = $this->db->query("SELECT MAX(NO_ID) AS NO_ID FROM kas WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $NO_BUKTI = $this->input->post('NO_PERK');
        $URAIAN = $this->input->post('URAIAN');
        $TOTAL = $this->input->post('TOTAL');
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'NO_BUKTI' => $bukti,
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                'NOTES' => $this->input->post('NOTES', TRUE),
                'REC' => $REC[$i],
                'NO_BUKTI' => $NO_BUKTI[$i],
                'URAIAN' => $URAIAN[$i],
                'TOTAL' => $TOTAL[$i],
                'WILAYAH' => $this->session->userdata['kdmts'],
                'PERKE' => $this->session->userdata['fase'],
                'PER' => $this->session->userdata['periode'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i a"),
                'FLAG' => 'PMS',
                'FLAG2' => 'BKK',
            );
            $this->transaksi_model->input_datad('kasd', $datad);
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
        redirect('admin/Transaksi_Bkk_Kasir/index_Transaksi_Bkk_Kasir');
    }

    public function lihat($id)
    {
        $q1 = "SELECT kas.NO_ID as ID,
                kas.NO_BUKTI AS NO_BUKTI,
                kas.TGL AS TGL,
                kas.NOTES AS NOTES,
                kas.TTOTAL AS TTOTAL,

                kasd.NO_ID AS NO_ID,
                kasd.REC AS REC,
                kasd.ACNO AS ACNO,
                kasd.NAMA AS NAMA,
                kasd.TOTAL AS TOTAL
            FROM kas,kasd 
            WHERE kas.NO_ID=$id 
            AND kas.NO_ID=kasd.ID
            ORDER BY kasd.REC";
        $data['bkk_kasir'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Bkk_Kasir/Transaksi_Bkk_Kasir_lihat', $data);
        $this->load->view('templates_admin/footer');
    }

    public function lihat_aksi()
    {
        redirect('admin/Transaksi_Bkk_Kasir/index_Transaksi_Bkk_Kasir');
    }

    public function update($id)
    {
    }

    public function update_aksi()
    {
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'kas');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'kasd');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Bkk_Kasir/index_Transaksi_Bkk_Kasir');
    }

    function delete_multiple()
    {
        $this->transaksi_model->remove_checked_transaksi_bkk_kasir('kas', 'kasd');
        redirect('admin/Transaksi_Bkk_Kasir/index_Transaksi_Bkk_Kasir');
    }

    public function getDataAjax_Perkira()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_ID, NO_PERK, NA_PERK
            FROM perkira
            WHERE NO_PERK LIKE '%$search%' OR NA_PERK LIKE '%$search%'
            ORDER BY NO_PERK LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['NO_PERK'],
                'text' => $row['NO_PERK'],
                'NO_PERK' => $row['NO_PERK'] . " - " . $row['NA_PERK'],
                'NA_PERK' => $row['NA_PERK'],
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Bkk_Kasir.jrxml");
        $NO_ID = $id;
        $query = "SELECT kas.NO_ID as ID,
                kas.nobukti AS NOBUKTI,
                kas.tglbukti AS TGLBUKTI,
                kas.uraian AS URAIAN,
                kas.total AS TOTAL,

                kasd.NO_ID AS NO_ID,
                kasd.rec AS REC,
                kasd.noperk AS NOPERK,
                kasd.urai1 AS URAI1,
                kasd.ktunai AS KTUNAI
            FROM kas,kasd 
            WHERE kas.NO_ID=$id 
            AND kas.NO_ID=kasd.id 
            ORDER BY kasd.rec";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "URAIAN" => $row1["URAIAN"],
                "NOPERK" => $row1["NOPERK"],
                "URAI1" => $row1["URAI1"],
                "KTUNAI" => $row1["KTUNAI"],
                "REC" => $row1["REC"],
                "NOBUKTI" => $row1["NOBUKTI"],
                "TOTAL" => $row1["TOTAL"],
                "TGLBUKTI" => $row1["TGLBUKTI"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}

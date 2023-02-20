<?php

class Transaksi_PesananOrderSheet extends CI_Controller
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
            $this->session->set_userdata('kode_menu', 'T0018');
            $this->session->set_userdata('keyword_so', '');
            $this->session->set_userdata('order_so', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL', 'NO_DO', 'TGL_DO', 'WILAYAH');
    var $column_search = array('NO_BUKTI', 'TGL', 'NO_DO', 'TGL_DO', 'WILAYAH');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ',
            'SHEET' => '1',
            'WILAYAH' => '01'
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
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ',
            'SHEET' => '1',
            'WILAYAH' => '01'
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
            $JASPER = "window.open('JASPER/" . $so->NO_ID . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $so->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_PesananOrderSheet/update/' . $so->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $so->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($so->TGL));
            $row[] = $so->NO_DO;
            $row[] = date('d-m-Y', strtotime($so->TGL_DO));
            $row[] = $so->WILAYAH;
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

    public function index_Transaksi_PesananOrderSheet()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Surat Pesanan Order Sheet');
        $where = array(
            'PER' => $periode,
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ',
            'SHEET' => '1',
            'WILAYAH' => '01',
        );
        $data['so'] = $this->transaksi_model->tampil_data($where, 'so', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PesananOrderSheet/Transaksi_PesananOrderSheet', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PesananOrderSheet/Transaksi_PesananOrderSheet_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $per = $this->session->userdata['periode'];
        $wilayah = '01';
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
        $flag2 = 'PJ';
        $nomer = $this->db->query("SELECT left(MAX(NO_BUKTI),4) as NO_BUKTI FROM so WHERE PER='$per' AND WILAYAH='$wilayah' AND FLAG2='$flag2'  ")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $urut = str_pad($nom[0] + 1, 4, "0", STR_PAD_LEFT);
        $bukti = $urut . '/' . 'SP' . '/' . $wilayah . '/' . $ROMAWI . '/' . substr($this->session->userdata['periode'], -2);
        $datah = array(
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NO_DO' => $this->input->post('NO_DO', TRUE),
            'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
            'TOTAL_QTY' => str_replace(',', '', $this->input->post('TOTAL_QTY', TRUE)),
            'TOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'SHEET' => '1',
            'WILAYAH' => '01',
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
        );
        $this->transaksi_model->input_datah('so', $datah);
        $ID = $this->db->query("SELECT MAX(NO_ID) AS NO_ID FROM so WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $NA_BRG = $this->input->post('NA_BRG');
        $WARNA = $this->input->post('WARNA');
        $SIZE = $this->input->post('SIZE');
        $NO_KIK = $this->input->post('NO_KIK');
        $QTY = str_replace(',', '', $this->input->post('QTY', TRUE));
        $HARGA = str_replace(',', '', $this->input->post('HARGA', TRUE));
        $TOTAL = str_replace(',', '', $this->input->post('TOTAL', TRUE));
        $KODEC = $this->input->post('KODEC');
        $NAMAC = $this->input->post('NAMAC');
        $KOTA = $this->input->post('KOTA');
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'NO_BUKTI' => $bukti,
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                'NO_DO' => $this->input->post('NO_DO', TRUE),
                'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
                'REC' => $REC[$i],
                'KD_BRG' => $KD_BRG[$i],
                'NA_BRG' => $NA_BRG[$i],
                'WARNA' => $WARNA[$i],
                'SIZE' => $SIZE[$i],
                'NO_KIK' => $NO_KIK[$i],
                'QTY' => str_replace(',', '', $QTY[$i]),
                'HARGA' => str_replace(',', '', $HARGA[$i]),
                'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                'KODEC' => $KODEC[$i],
                'NAMAC' => $NAMAC[$i],
                'KOTA' => $KOTA[$i],
                'WILAYAH' => '01',
                'SHEET' => '1',
                'PER' => $this->session->userdata['periode'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i a"),
                'FLAG' => 'PMS',
                'FLAG2' => 'PJ'
            );
            $this->transaksi_model->input_datad('sod', $datad);
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
        redirect('admin/Transaksi_PesananOrderSheet/index_Transaksi_PesananOrderSheet');
    }

    public function lihat($id)
    {
    }

    public function lihat_aksi()
    {
    }

    public function update($id)
    {
        $q1 = "SELECT so.NO_ID as ID,
                so.NO_BUKTI AS NO_BUKTI,
                so.TGL AS TGL,
                so.NO_DO AS NO_DO,
                so.TGL_DO AS TGL_DO,
                so.TOTAL_QTY AS TOTAL_QTY,
                so.TOTAL AS TTOTAL,

                sod.NO_ID AS NO_ID,
                sod.REC AS REC,
                sod.KD_BRG AS KD_BRG,
                sod.NA_BRG AS NA_BRG,
                sod.WARNA AS WARNA,
                sod.SIZE AS SIZE,
                sod.NO_KIK AS NO_KIK,
                sod.QTY AS QTY,
                sod.HARGA AS HARGA,
                sod.TOTAL AS TOTAL,
                sod.KODEC AS KODEC,
                sod.NAMAC AS NAMAC,
                sod.KOTA AS KOTA
            FROM so,sod 
            WHERE so.NO_ID=$id 
            AND so.NO_ID=sod.ID 
            ORDER BY sod.REC";
        $data['pesananordersheet'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PesananOrderSheet/Transaksi_PesananOrderSheet_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'NO_DO' => $this->input->post('NO_DO', TRUE),
            'TGL_DO' => date("Y-m-d", strtotime($this->input->post('TGL_DO', TRUE))),
            'TOTAL_QTY' => str_replace(',', '', $this->input->post('TOTAL_QTY', TRUE)),
            'TOTAL' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'WILAYAH' => '01',
            'SHEET' => '1',
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'PMS',
            'FLAG2' => 'PJ'
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
                so.TOTAL_QTY AS TOTAL_QTY,
                so.TOTAL AS TTOTAL,

                sod.NO_ID AS NO_ID,
                sod.REC AS REC,
                sod.KD_BRG AS KD_BRG,
                sod.NA_BRG AS NA_BRG,
                sod.WARNA AS WARNA,
                sod.SIZE AS SIZE,
                sod.NO_KIK AS NO_KIK,
                sod.QTY AS QTY,
                sod.HARGA AS HARGA,
                sod.TOTAL AS TOTAL,
                sod.KODEC AS KODEC,
                sod.NAMAC AS NAMAC,
                sod.KOTA AS KOTA
            FROM so,sod 
            WHERE so.NO_ID=$id 
            AND so.NO_ID=sod.ID 
            ORDER BY sod.REC";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_BRG = $this->input->post('KD_BRG');
        $NA_BRG = $this->input->post('NA_BRG');
        $WARNA = $this->input->post('WARNA');
        $SIZE = $this->input->post('SIZE');
        $NO_KIK = $this->input->post('NO_KIK');
        $QTY = str_replace(',', '', $this->input->post('QTY', TRUE));
        $HARGA = str_replace(',', '', $this->input->post('HARGA', TRUE));
        $TOTAL = str_replace(',', '', $this->input->post('TOTAL', TRUE));
        $KODEC = $this->input->post('KODEC');
        $NAMAC = $this->input->post('NAMAC');
        $KOTA = $this->input->post('KOTA');
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
                    'REC' => $REC[$URUT],
                    'KD_BRG' => $KD_BRG[$URUT],
                    'NA_BRG' => $NA_BRG[$URUT],
                    'WARNA' => $WARNA[$URUT],
                    'SIZE' => $SIZE[$URUT],
                    'NO_KIK' => $NO_KIK[$URUT],
                    'QTY' => str_replace(',', '', $QTY[$URUT]),
                    'HARGA' => str_replace(',', '', $HARGA[$URUT]),
                    'TOTAL' => str_replace(',', '', $TOTAL[$URUT]),
                    'KODEC' => $KODEC[$URUT],
                    'NAMAC' => $NAMAC[$URUT],
                    'KOTA' => $KOTA[$URUT],
                    'WILAYAH' => '01',
                    'SHEET' => '1',
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a"),
                    'FLAG' => 'PMS',
                    'FLAG2' => 'PJ'
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
                    'REC' => $REC[$i],
                    'KD_BRG' => $KD_BRG[$i],
                    'NA_BRG' => $NA_BRG[$i],
                    'WARNA' => $WARNA[$i],
                    'SIZE' => $SIZE[$i],
                    'NO_KIK' => $NO_KIK[$i],
                    'QTY' => str_replace(',', '', $QTY[$i]),
                    'HARGA' => str_replace(',', '', $HARGA[$i]),
                    'TOTAL' => str_replace(',', '', $TOTAL[$i]),
                    'KODEC' => $KODEC[$i],
                    'NAMAC' => $NAMAC[$i],
                    'KOTA' => $KOTA[$i],
                    'WILAYAH' => '01',
                    'SHEET' => '1',
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a"),
                    'FLAG' => 'PMS',
                    'FLAG2' => 'PJ'
                );
                $this->transaksi_model->input_datad('sod', $datad);
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
        redirect('admin/Transaksi_PesananOrderSheet/index_Transaksi_PesananOrderSheet');
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'so');
        $where = array('ID' => $id);
        $this->transaksi_model->hapus_data($where, 'sod');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_PesananOrderSheet/index_Transaksi_PesananOrderSheet');
    }

    function delete_multiple()
    {
    }

    public function getDataAjax_Brg()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_ID, KD_BRG, NA_BRG, WARNA, SIZE
            FROM brg
            WHERE KD_BRG LIKE '%$search%' OR NA_BRG LIKE '%$search%' OR WARNA LIKE '%$search%' OR SIZE LIKE '%$search%'
            ORDER BY KD_BRG LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KD_BRG'],
                'text' => $row['KD_BRG'],
                'KD_BRG' => $row['KD_BRG'] . " - " . $row['NA_BRG'] . " - " . $row['WARNA'] . " - " . $row['SIZE'],
                'NA_BRG' => $row['NA_BRG'],
                'WARNA' => $row['WARNA'],
                'SIZE' => $row['SIZE'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getDataAjax_Cust()
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
            WHERE KODEC LIKE '%$search%' OR NAMAC LIKE '%$search%' OR KOTA LIKE '%$search%'
            ORDER BY KODEC LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KODEC'],
                'text' => $row['KODEC'],
                'KODEC' => $row['KODEC'] . " - " . $row['NAMAC'] . " - " . $row['KOTA'],
                'NAMAC' => $row['NAMAC'],
                'KOTA' => $row['KOTA'],
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_PesananOrderSheet.jrxml");
        $no_id = $id;
        $query = "SELECT so.NO_ID as ID,
                so.NO_BUKTI AS NO_BUKTI,
                so.TGL AS TGL,
                so.WILAYAH AS WILAYAH,
                so.TOTAL_QTY AS TOTAL_QTY,
                so.TOTAL_QTYP AS TOTAL_QTYP,

                sod.NO_ID AS NO_ID,
                sod.REC AS REC,
                CONCAT(sod.KODEC,' - ',sod.NAMAC) AS CUSTOMER,
                CONCAT(sod.KD_BRG,' - ',sod.WARNA) AS BARANG,
                sod.QTY AS QTY,
                sod.QTYP AS QTYP
            FROM so,sod 
            WHERE so.NO_ID = $id 
            AND so.NO_ID = sod.ID 
            ORDER BY sod.REC";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NO_BUKTI" => $row1["NO_BUKTI"],
                "TGL" => $row1["TGL"],
                "WILAYAH" => $row1["WILAYAH"],
                "TOTAL_QTY" => $row1["TOTAL_QTY"],
                "TOTAL_QTYP" => $row1["TOTAL_QTYP"],
                "REC" => $row1["REC"],
                "CUSTOMER" => $row1["CUSTOMER"],
                "BARANG" => $row1["BARANG"],
                "QTY" => $row1["QTY"],
                "QTYP" => $row1["QTYP"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}

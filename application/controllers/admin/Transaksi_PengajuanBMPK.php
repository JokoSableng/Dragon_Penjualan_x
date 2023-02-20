<?php

class Transaksi_PengajuanBMPK extends CI_Controller
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
        if ($this->session->userdata['menu_penjualan'] != 'ajuan') {
            $this->session->set_userdata('menu_penjualan', 'ajuan');
            $this->session->set_userdata('kode_menu', 'T0011');
            $this->session->set_userdata('keyword_ajuan', '');
            $this->session->set_userdata('order_ajuan', 'NO_ID');
        }
    }

    var $column_order = array(null, null, 'NO_BUKTI', 'TGL', 'PER');
    var $column_search = array('NO_BUKTI', 'TGL', 'PER');
    var $order = array('NO_BUKTI' => 'asc');

    private function _get_datatables_query()
    {
        $periode = $this->session->userdata['periode'];
        $where = array(
            'PER' => $periode,
            'FLAG' => 'JL'
        );
        $this->db->select('*');
        $this->db->from('ajuan');
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
            'FLAG' => 'JL'
        );
        $this->db->from('ajuan');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_ajuan()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $ajuan) {
            $JASPER = "window.open('JASPER/" . $ajuan->NO_ID . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            // $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $ajuan->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #1cc88a;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_PengajuanBMPK/update/' . $ajuan->NO_ID) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a name="NO_ID" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_PengajuanBMPK/delete/' . $ajuan->NO_ID) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $ajuan->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($ajuan->TGL));
            $row[] = $ajuan->PER;
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

    public function index_Transaksi_PengajuanBMPK()
    {
        $periode = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Pengajuan BMPK');
        $where = array(
            'PER' => $periode,
            'FLAG' => 'JL'
        );
        $data['ajuan'] = $this->transaksi_model->tampil_data($where, 'ajuan', 'NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PengajuanBMPK/Transaksi_PengajuanBMPK', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PengajuanBMPK/Transaksi_PengajuanBMPK_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $per = $this->session->userdata['periode'];
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
        $nomer = $this->db->query("SELECT left(MAX(NO_BUKTI),4) as NO_BUKTI FROM ajuan WHERE PER='$per' ")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $urut = str_pad($nom[0] + 1, 4, "0", STR_PAD_LEFT);
        $bukti = $urut . '/' . 'FP' . '/' . $ROMAWI . '/' . substr($this->session->userdata['periode'], -2);
        $datah = array(
            'NO_BUKTI' => $bukti,
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'JL'
        );
        $this->transaksi_model->input_datah('ajuan', $datah);
        $ID = $this->db->query("SELECT MAX(NO_ID) AS NO_ID FROM ajuan WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
        $REC = $this->input->post('REC');
        $KODEC = $this->input->post('KODEC');
        $NAMAC = $this->input->post('NAMAC');
        $WILAYAH = $this->input->post('WILAYAH');
        $BMPKL = $this->input->post('BMPKL');
        $BMPKB = $this->input->post('BMPKB');
        $MET_BYR = $this->input->post('MET_BYR');
        $PERIODE2 = $this->input->post('PERIODE2');
        $NOTES = $this->input->post('NOTES');
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'ID' => $ID[0]->NO_ID,
                'NO_BUKTI' => $bukti,
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                'REC' => $REC[$i],
                'KODEC' => $KODEC[$i],
                'NAMAC' => $NAMAC[$i],
                'WILAYAH' => $WILAYAH[$i],
                'BMPKL' => $BMPKL[$i],
                'BMPKB' => $BMPKB[$i],
                'MET_BYR' => $MET_BYR[$i],
                'PERIODE2' => $PERIODE2[$i],
                'NOTES' => $NOTES[$i],
                'PER' => $this->session->userdata['periode'],
                'USRNM' => $this->session->userdata['username'],
                'TG_SMP' => date("Y-m-d h:i a"),
                'FLAG' => 'JL'
            );
            $this->transaksi_model->input_datad('ajuand', $datad);
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
        redirect('admin/Transaksi_PengajuanBMPK/index_Transaksi_PengajuanBMPK');
    }

    public function lihat($id)
    {
    }

    public function lihat_aksi()
    {
    }

    public function update($id)
    {
        $q1 = "SELECT ajuan.NO_ID as ID,
                ajuan.NO_BUKTI AS NO_BUKTI,
                ajuan.tgl AS TGL,

                ajuand.NO_ID AS NO_ID,
                ajuand.REC AS REC,
                ajuand.KODEC AS KODEC,
                ajuand.NAMAC AS NAMAC,
                ajuand.BMPKL AS BMPKL,
                ajuand.BMPKL AS BMPKB,
                ajuand.MET_BYR AS MET_BYR,
                ajuand.PERIODE2 AS PERIODE2,
                ajuand.NOTES AS NOTES
            FROM ajuan, ajuand 
            WHERE ajuan.NO_ID=$id 
            AND ajuan.NO_ID=ajuand.ID 
            ORDER BY ajuand.REC";
        $data['pengajuanbmpk'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PengajuanBMPK/Transaksi_PengajuanBMPK_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'NO_BUKTI' => $this->input->post('NO_BUKTI', TRUE),
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            'PER' => $this->session->userdata['periode'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'JL'
        );
        $where = array(
            'NO_ID' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'ajuan');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT ajuan.NO_ID as ID,
                ajuan.NO_BUKTI AS NO_BUKTI,
                ajuan.tgl AS TGL,

                ajuand.NO_ID AS NO_ID,
                ajuand.REC AS REC,
                ajuand.KODEC AS KODEC,
                ajuand.NAMAC AS NAMAC,
                ajuand.BMPKL AS BMPKL,
                ajuand.BMPKL AS BMPKB,
                ajuand.MET_BYR AS MET_BYR,
                ajuand.PERIODE2 AS PERIODE2,
                ajuand.NOTES AS NOTES
            FROM ajuan, ajuand 
            WHERE ajuan.NO_ID=$id 
            AND ajuan.NO_ID=ajuand.ID 
            ORDER BY ajuand.REC";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KODEC = $this->input->post('KODEC');
        $NAMAC = $this->input->post('NAMAC');
        $WILAYAH = $this->input->post('WILAYAH');
        $BMPKL = $this->input->post('BMPKL');
        $BMPKB = $this->input->post('BMPKB');
        $MET_BYR = $this->input->post('MET_BYR');
        $PERIODE2 = $this->input->post('PERIODE2');
        $NOTES = $this->input->post('NOTES');
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
                    'REC' => $REC[$URUT],
                    'KODEC' => $KODEC[$URUT],
                    'NAMAC' => $NAMAC[$URUT],
                    'WILAYAH' => $WILAYAH[$URUT],
                    'BMPKL' => $BMPKL[$URUT],
                    'BMPKB' => $BMPKB[$URUT],
                    'MET_BYR' => $MET_BYR[$URUT],
                    'PERIODE2' => $PERIODE2[$URUT],
                    'NOTES' => $NOTES[$URUT],
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a"),
                    'FLAG' => 'JL'
                );
                $where = array(
                    'NO_ID' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'ajuand');
            } else {
                $where = array(
                    'NO_ID' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'ajuand');
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
                    'REC' => $REC[$i],
                    'KODEC' => $KODEC[$i],
                    'NAMAC' => $NAMAC[$i],
                    'WILAYAH' => $WILAYAH[$i],
                    'BMPKL' => $BMPKL[$i],
                    'BMPKB' => $BMPKB[$i],
                    'MET_BYR' => $MET_BYR[$i],
                    'PERIODE2' => $PERIODE2[$i],
                    'NOTES' => $NOTES[$i],
                    'PER' => $this->session->userdata['periode'],
                    'USRNM' => $this->session->userdata['username'],
                    'TG_SMP' => date("Y-m-d h:i a"),
                    'FLAG' => 'JL'
                );
                $this->transaksi_model->input_datad('ajuand', $datad);
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
        redirect('admin/Transaksi_PengajuanBMPK/index_Transaksi_PengajuanBMPK');
    }

    public function delete($id)
    {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'ajuan');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'ajuand');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_PengajuanBMPK/index_Transaksi_PengajuanBMPK');
    }

    function delete_multiple()
    {
    }

    public function getDataAjax_kodec()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT NO_ID, KODEC, NAMAC, WILAYAH, BMPKL
            FROM cust
            WHERE KODEC LIKE '%$search%' OR NAMAC LIKE '%$search%' OR WILAYAH LIKE '%$search%' OR BMPKL LIKE '%$search%'
            ORDER BY KODEC LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KODEC'],
                'text' => $row['KODEC'],
                'KODEC' => $row['KODEC'] . " - " . $row['NAMAC'] . " - " . $row['WILAYAH'] . " - " . $row['BMPKL'],
                'WILAYAH' => $row['WILAYAH'],
                'NAMAC' => $row['NAMAC'],
                'BMPKL' => $row['BMPKL'],
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_PengajuanBMPK.jrxml");
        $NO_ID = $id;
        $query = "SELECT ajuan.NO_ID as ID,
                ajuan.NO_BUKTI AS NOBUKTI,
                ajuan.tgl AS TGL,

                ajuand.NO_ID AS NO_ID,
                ajuand.rec AS REC,
                ajuand.kodecus AS KODECUS,
                ajuand.nama AS NAMA,
                ajuand.bmpkl AS BMPKL,
                ajuand.bmpkb AS BMPKB,
                ajuand.met_byr AS MET_BYR,
                ajuand.periode2 AS PERIODE2,
                ajuand.alasan AS ALASAN
            FROM ajuan,ajuand 
            WHERE ajuan.NO_ID=$id 
            AND ajuan.NO_ID=ajuand.id 
            ORDER BY ajuand.rec";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NAMA" => $row1["NAMA"],
                "BMPKL" => $row1["BMPKL"],
                "BMPKB" => $row1["BMPKB"],
                "MET_BYR" => $row1["MET_BYR"],
                "PERIODE2" => $row1["PERIODE2"],
                "ALASAN" => $row1["ALASAN"],
                "TGL" => $row1["TGL"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}

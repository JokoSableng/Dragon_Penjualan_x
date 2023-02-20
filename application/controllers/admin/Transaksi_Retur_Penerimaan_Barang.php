<?php

class Transaksi_Retur_Penerimaan_Barang extends CI_Controller {

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
        if ($this->session->userdata['menu_pemasaran'] != 'beli') {
			$this->session->set_userdata('menu_pemasaran', 'beli');
			$this->session->set_userdata('kode_menu', 'T0005');
			$this->session->set_userdata('keyword_beli', '');
			$this->session->set_userdata('order_beli', 'NO_ID');
        }
    }

    var $column_order = array(null, null, null, 'NO_BUKTI', 'TGL', 'NO_SJ', 'TGL_SJ', 'WILAYAH');
    var $column_search = array('NO_BUKTI', 'TGL', 'NO_SJ', 'TGL_SJ', 'WILAYAH');
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
            'FLAG2' => 'LB'
        );
        $this->db->select('*');
        $this->db->from('beli');
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
            'FLAG2' => 'LB'
        );
        $this->db->from('beli');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_beli() {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $beli) {
            $JASPER = "window.open('JASPER/" . $beli->NO_ID . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $beli->NO_ID . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Retur_Penerimaan_Barang/lihat/' . $beli->NO_ID) . '"> <i class="fa fa-eye"></i> Lihat</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $beli->NO_BUKTI;
            $row[] = date('d-m-Y', strtotime($beli->TGL));
            $row[] = $beli->NO_SJ;
            $row[] = date('d-m-Y', strtotime($beli->TGL_SJ));
            $row[] = $beli->WILAYAH;
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

    public function index_Transaksi_Retur_Penerimaan_Barang() {
        $kdmts = $this->session->userdata['kdmts'];
        $per = $this->session->userdata['periode'];
        $fase = $this->session->userdata['fase'];
        $this->session->set_userdata('judul', 'Transaksi Penerimaan Barang');
        $where = array(
            'WILAYAH' => $kdmts,
            'PER' => $per,
            'PERKE' => $fase,
            'FLAG' => 'PMS',
            'FLAG2' => 'LB'
        );
        $data['beli'] = $this->transaksi_model->tampil_data($where,'beli','NO_ID')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Retur_Penerimaan_Barang/Transaksi_Retur_Penerimaan_Barang', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input() {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Retur_Penerimaan_Barang/Transaksi_Retur_Penerimaan_Barang_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi() {
        $per = $this->session->userdata['periode'];
		$kdmts = $this->session->userdata['kdmts'];
        $nomer = $this->db->query("SELECT MAX(NO_BUKTI) as NO_BUKTI FROM beli WHERE PER='$per' AND WILAYAH='$kdmts' AND FLAG2='LB' ")->result();
        $nom = array_column($nomer,'NO_BUKTI');
        $value11 = substr($nom[0],-4);
        $value22 = STRVAL($value11) + 1;
        $urut= str_pad($value22,4,"0",STR_PAD_LEFT);
        $bukti='LB'.substr($this->session->userdata['periode'],-2).substr($this->session->userdata['periode'],0,2).'-'.$urut;
        $datah = array(
            'NO_BUKTI' => $bukti,
            'NO_SJ' => $this->input->post('NO_SJ', TRUE),
            'TGL' => date("Y-m-d", strtotime($this->input->post('TGL',TRUE))),
            'TOTAL_QTY' => str_replace(',','',$this->input->post('TOTAL_QTY',TRUE)),
            'TOTAL_QTYP' => str_replace(',','',$this->input->post('TOTAL_QTYP',TRUE)),
            'TTOTAL' => str_replace(',','',$this->input->post('TTOTAL',TRUE)),
            'DISK' => str_replace(',','',$this->input->post('DISK',TRUE)),
            'NETT' => str_replace(',','',$this->input->post('NETT',TRUE)), 
            'WILAYAH' => $this->session->userdata['kdmts'],
            'PER' => $this->session->userdata['periode'],
            'PERKE' => $this->session->userdata['fase'],
            'USRNM' => $this->session->userdata['username'],
            'TG_SMP' => date("Y-m-d h:i a"),
            'FLAG' => 'PMS',
            'FLAG2' => 'LB'
        );
        $this->transaksi_model->input_datah('beli',$datah);
        $ID= $this->db ->query("SELECT MAX(NO_ID) AS NO_ID FROM beli WHERE NO_BUKTI = '$bukti' GROUP BY NO_BUKTI")->result();
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
                'NO_SJ' => $this->input->post('NO_SJ', TRUE),
                'TGL' => date("Y-m-d", strtotime($this->input->post('TGL',TRUE))),
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
                'FLAG2' => 'LB'
            );
            $this->transaksi_model->input_datad('belid',$datad);
            $i++;
        }
        $this->session->set_flashdata('pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Retur_Penerimaan_Barang/index_Transaksi_Retur_Penerimaan_Barang'); 
    }

    public function lihat($id) {
        $q1="SELECT beli.NO_ID as ID,
                beli.NO_BUKTI AS NO_BUKTI,
                beli.TGL AS TGL,
                beli.NO_SJ AS NO_SJ,
                beli.TGL_SJ AS TGL_SJ,
                beli.TOTAL_QTY AS TOTAL_QTY,
                beli.TOTAL_QTYP AS TOTAL_QTYP,
                beli.TTOTAL AS TTOTAL,
                beli.TDISK AS TDISK,
                beli.NETT AS NETT,

                belid.NO_ID AS NO_ID,
                belid.REC AS REC,
                belid.KD_BRG AS KD_BRG,
                belid.NA_BRG AS NA_BRG,
                belid.WARNA AS WARNA,
                belid.SIZE AS SIZE,
                belid.GOL AS GOL,
                belid.QTY AS QTY,
                belid.QTYP AS QTYP,
                belid.HARGA AS HARGA,
                belid.TOTAL AS TOTAL,
                belid.TERIMA AS TERIMA
            FROM beli,belid 
            WHERE beli.NO_ID=$id
            AND beli.NO_ID=belid.ID 
            ORDER BY belid.REC";
        $data['beli']= $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Retur_Penerimaan_Barang/Transaksi_Retur_Penerimaan_Barang_lihat', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi() {}

    public function delete($id) {
        $where = array('NO_ID' => $id);
        $this->transaksi_model->hapus_data($where, 'beli');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'belid');
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Retur_Penerimaan_Barang/index_Transaksi_Retur_Penerimaan_Barang');
    }

    function delete_multiple() {
        $this->transaksi_model->remove_checked_transaksi_surat_jalan('beli', 'belid');
        redirect('admin/Transaksi_Retur_Penerimaan_Barang/index_Transaksi_Retur_Penerimaan_Barang');
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
        $results = $this->db->query("SELECT NO_ID, KD_BRG, WARNA, SIZE, GOL, WILAYAH
            FROM brg
            WHERE WILAYAH = '$kdmts' AND (KD_BRG LIKE '%$search%' OR WARNA LIKE '%$search%' OR SIZE LIKE '%$search%' OR GOL LIKE '%$search%' OR WILAYAH LIKE '%$search%')
            ORDER BY KD_BRG LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['KD_BRG'],
                'text' => $row['KD_BRG'],
                'KD_BRG' => $row['KD_BRG'] . " - " . $row['WARNA'] . " - " . $row['SIZE'] . " - " . $row['GOL'] . " - " . $row['WILAYAH'],
                'WARNA' => $row['WARNA'],
                'SIZE' => $row['SIZE'],
                'GOL' => $row['GOL'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    function JASPER($id) {}

}
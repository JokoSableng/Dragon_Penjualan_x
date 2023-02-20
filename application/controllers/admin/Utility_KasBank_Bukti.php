<?php

class Utility_KasBank_Bukti extends CI_Controller
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
    }

    public function index_KasBank_Bukti($tipe)
    {
        $this->db->query("UPDATE `menu_penjualan` SET `URL_MENU`='admin/Utility_KasBank_Bukti/index_KasBank_Bukti/2' WHERE KODE_MENU='U0008'");
        $this->db->query("UPDATE `menu_penjualan` SET `URL_MENU`='admin/Utility_KasBank_Bukti/index_KasBank_Bukti/4' WHERE KODE_MENU='U0009'");
        /*
        INSERT INTO `menu_penjualan` (`KODE_MENU`, `NAMA_MENU`, `LEVEL`, `PARENT_MENU`, `URL_MENU`, `AKSES_MENU`) 
        VALUES ('U0024', 'Rev BKM Ke BKM', '1', 'N0006', 'admin/Utility_KasBank_Bukti/index_KasBank_Bukti/1', 'SUPER_ADMIN');

        INSERT INTO `menu_penjualan` (`KODE_MENU`, `NAMA_MENU`, `LEVEL`, `PARENT_MENU`, `URL_MENU`, `AKSES_MENU`) 
        VALUES ('U0025', 'Rev BBM Ke BBM', '1', 'N0006', 'admin/Utility_KasBank_Bukti/index_KasBank_Bukti/3', 'SUPER_ADMIN');
        
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('1', 'SUPER_ADMIN', 'U0024', 'Rev BKM Ke BKM', '1', '1', '1', '1');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('601', 'JL1', 'U0024', 'Rev BKM Ke BKM', '0', '0', '0', '0');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('602', 'JL2', 'U0024', 'Rev BKM Ke BKM', '0', '0', '0', '0');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('603', 'JL3', 'U0024', 'Rev BKM Ke BKM', '1', '1', '1', '1');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('604', 'JL4', 'U0024', 'Rev BKM Ke BKM', '0', '0', '0', '0');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('607', 'JL7', 'U0024', 'Rev BKM Ke BKM', '0', '0', '0', '0');
        
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('1', 'SUPER_ADMIN', 'U0025', 'Rev BBM Ke BBM', '1', '1', '1', '1');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('601', 'JL1', 'U0025', 'Rev BBM Ke BBM', '0', '0', '0', '0');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('602', 'JL2', 'U0025', 'Rev BBM Ke BBM', '0', '0', '0', '0');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('603', 'JL3', 'U0025', 'Rev BBM Ke BBM', '1', '1', '1', '1');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('604', 'JL4', 'U0025', 'Rev BBM Ke BBM', '0', '0', '0', '0');
        INSERT INTO `user_typed_penjualan` (`id`, `user_level`, `kode_menu`, `nama_menu`, `baru`, `edit`, `hapus`, `lihat`) 
        VALUES ('607', 'JL7', 'U0025', 'Rev BBM Ke BBM', '0', '0', '0', '0');
        */

        $judul="";
        if($tipe==1) $judul="Rev BKM ke BKM";
        if($tipe==2) $judul="Rev BKM ke BBM";
        if($tipe==3) $judul="Rev BBM ke BBM";
        if($tipe==4) $judul="Rev BBM ke BKM";

        if (isset($_POST["nobukti"])) 
        {
            $userx = $this->session->userdata['username'];
            $buktilama = $_POST['nobukti'];
            $buktibaru = $_POST['nobukti_baru'];
            $tgl = date("Y-m-d", strtotime($this->input->post('TGL')));

            $update = $this->db->query("CALL utility_kasbank('UPDATE', '$tipe', '$buktilama', '$buktibaru', '$tgl', '$userx')")->result();
            $hasil = array_column($update, 'HASIL');

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert"> 
                    '.$hasil[0].' selesai diproses..
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div>'
            );
            redirect('admin//Utility_KasBank_Bukti/index_KasBank_Bukti/'.$tipe);
        } 
        else 
        {
            $data = array(
                'JUDUL' => $judul,
                'JENIS' => $tipe,
            );

            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Utility_KasBank/Utility_KasBank_Bukti', $data);
            $this->load->view('templates_admin/footer_report');
        }
    }

    public function filter($bukti, $search, $limit, $start, $order_field, $order_ascdesc){
        $this->db->select('a.NO_BUKTI, date_format(b.TGL_FKTR,"%d-%m-%Y") as TGL_FKTR, b.NO_SURAT, b.KODEC, b.TOTAL')
            ->from('piu as a')
            ->join('piud as b', 'a.NO_BUKTI = b.NO_BUKTI', 'LEFT')
            ->where("a.NO_BUKTI = '$bukti' 
        and (a.NO_BUKTI like '%$search%' or b.NO_SURAT like '%$search%' or b.TOTAL like '%$search%')")
            ->order_by($order_field, $order_ascdesc)
            ->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    public function count_filter($bukti, $search){
        $this->db->select('a.NO_BUKTI, date_format(b.TGL_FKTR,"%d-%m-%Y") as TGL_FKTR, b.NO_SURAT, b.KODEC, b.TOTAL')
            ->from('piu as a')
            ->join('piud as b', 'a.NO_BUKTI = b.NO_BUKTI', 'LEFT')
            ->where("a.NO_BUKTI = '$bukti' 
        and (a.NO_BUKTI like '%$search%' or b.NO_SURAT like '%$search%' or b.TOTAL like '%$search%')");
        return $this->db->get()->num_rows();
    }
    
    public function getDetailBukti() 
    {
        $search = $_POST['search']['value'];
        $limit = $_POST['length'];
        $start = $_POST['start'];
        $order_index = $_POST['order'][0]['column'];
        $order_field = $_POST['columns'][$order_index]['data'];
        $order_ascdesc = $_POST['order'][0]['dir'];
        
        $bukti = $_POST['nobukti'];
        $sql_total = $this->count_filter($bukti, $search);
        $sql_data = $this->filter($bukti, $search, $limit, $start, $order_field, $order_ascdesc);
        $sql_filter = $this->count_filter($bukti, $search);

        $callback = array(
            'draw'=>$_POST['draw'],
            'recordsTotal'=>$sql_total,
            'recordsFiltered'=>$sql_filter,
            'data'=>$sql_data
        );
        
        $this->output->set_content_type('application/json')->set_output(json_encode($callback));
    }
    
    public function cekBuktiBaru()
    {
        $bukti = $_POST['NO_BUKTI'];
		$cek = $this->db->query("CALL utility_kasbank('CEK', '', '$bukti', '', '', '')")->result();
        $this->output->set_content_type('application/json')->set_output(json_encode($cek));
	}
}

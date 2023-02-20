<?php

class Transaksi_PostingPiutang extends CI_Controller
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

    public function index_Transaksi_PostingPiutang()
    {
        $per = $this->session->userdata['periode'];
        $q1 = " SELECT piu.NO_ID AS NO_ID,
                piu.NO_BUKTI AS NO_BUKTI,
                piu.TGL AS TGL,
                piud.KODEC AS KODEC,
                piud.NAMAC AS NAMAC,
                piu.TOTAL AS TOTAL,
                piu.FLAG AS FLAG,
                CASE 
					WHEN piu.POSTED = 1 THEN 'SUDAH DIPOSTED'
					WHEN piu.POSTED = 0 THEN 'BELUM DIPOSTED'
				END AS POSTED
            FROM piu, piud
            WHERE piu.NO_BUKTI=piud.NO_BUKTI
            AND piu.PER='$per'
            AND piu.POSTED=0
            GROUP BY piu.NO_BUKTI
            ORDER BY piu.NO_BUKTI";
        $data['piu'] = $this->db->query($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_PostingPiutang', $data);
        $this->load->view('templates_admin/footer_report');
    }

    public function update()
    {
        $usrnm = $this->session->userdata['username'];
        $ceked = $this->input->post('check');
        for ($i = 0; $i < count($ceked); $i++) {
            $q1 = "UPDATE piu, piud 
                SET piu.POSTED = 1,
                piud.POSTED = 1,
                piu.USRNM_POSTED = '$usrnm',
                piud.USRNM_POSTED = '$usrnm',
                piud.USRNM_POSTED = date('Y-m-d h:i:s'),
                piud.USRNM_POSTED = date('Y-m-d h:i:s')
                WHERE piu.NO_ID='$ceked[$i]' 
                AND piu.NO_BUKTI=piud.NO_BUKTI";
            $this->db->query($q1);
        }
        redirect('admin/Transaksi_PostingPiutang/index_Transaksi_PostingPiutang');
    }
}

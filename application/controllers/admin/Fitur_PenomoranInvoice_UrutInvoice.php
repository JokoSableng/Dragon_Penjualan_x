<?php

class Fitur_PenomoranInvoice_UrutInvoice extends CI_Controller
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

    public function index_Fitur_PenomoranInvoice_UrutInvoice()
    {
        $per = $this->session->userdata['periode'];
        if(isset($_POST["PER"])) $per = $this->input->post('PER', TRUE);

            if (isset($_POST["proses"])) {
                $prosesInv = $this->db->query("SELECT count(NO_BUKTI) as NO_BUKTI FROM jual WHERE jual.FLAG='JR' AND jual.INVOICE='' AND jual.PER='$per'")->result();
                $this->db->query("CALL jl_urut_invoice('$per')");
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    '.$prosesInv[0]->NO_BUKTI.' SJ telah diproses.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
                );
            }

        $invAkhir = $this->db->query("SELECT MAX(SUBSTRING_INDEX(INVOICE,'/',1)) as AKHIR_INV, MAX(INVOICE) as INVOICE FROM jual WHERE jual.FLAG='JR' AND jual.INVOICE<>'' AND jual.PER='$per'")->result();
        $data = array(
            'PER' => set_value('PER'),
            'no_inv' => $invAkhir[0]->AKHIR_INV,
            'noinv' => $invAkhir[0]->INVOICE,
        );
        $data['fitur_penomoraninvoice_urutinvoice'] = $this->fitur_model->tampil_data_fitur_penomoraninvoice_urutinvoice()->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Fitur_PenomoranInvoice_UrutInvoice/Fitur_PenomoranInvoice_UrutInvoice', $data);
        $this->load->view('templates_admin/footer_report');
    }

}

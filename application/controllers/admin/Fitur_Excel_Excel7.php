<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Fitur_Excel_Excel7 extends CI_Controller
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

    public function index_Fitur_Excel_Excel7()
    {
        if (isset($_POST["ambil"])) {
            $this->importExcel();
        }
        $data = array(
            'TGL_1' => set_value('TGL_1'),
            'TGL_2' => set_value('TGL_2'),
        );
        $data['fitur_excel7'] = $this->fitur_model->tampil_data_fitur_excel_excel7()->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Fitur_Excel_Excel7/Fitur_Excel_Excel7', $data);
        $this->load->view('templates_admin/footer_report');
    }

    public function update()
    {
    }

    public function importExcel()
    {
        $namaTabel = 'fitur_excel7';
        // composer require phpoffice/phpspreadsheet
        $this->db->query(" CREATE TABLE IF NOT EXISTS $namaTabel (
            `NO_SJ` varchar(30) NOT NULL DEFAULT '',
            `TGLCI` date NULL DEFAULT '2001-01-01',
            `FIX` varchar(1) NOT NULL DEFAULT '',
            `USRNM` varchar(50) NOT NULL DEFAULT '',
            `TG_SMP` datetime NULL DEFAULT '2001-01-01'
          ) 
        ");

        $hasil = '';
        $file = $_FILES['fileimpor']['tmp_name'];
        $ekstensi  = explode('.', $_FILES['fileimpor']['name']);
        if (!empty($file)) {
            if (strtolower(end($ekstensi)) === 'xlsx' && $_FILES["fileimpor"]["size"] > 0) {
                $path_xlsx = $file;
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($path_xlsx);
                $d = $spreadsheet->getSheet(0)->toArray();
                $jumRecord = 0;
                $this->db->query("TRUNCATE table $namaTabel");
                unset($d[0]);
                foreach ($d as $t) {
                    $data = array(
                        'NO_SJ' => $t[0],
                        'TGLCI' => date("Y-m-d", strtotime($t[1])),
                        'FIX' => $t[2] ?? '',
                        'USRNM' => $this->session->userdata['username'],
                        'TG_SMP' => date("Y-m-d h:i:s"),
                    );
                    $this->master_model->input_data($namaTabel, $data);
                    $jumRecord++;
                }
                $this->db->query("UPDATE jual a, $namaTabel b SET a.FIX=b.FIX WHERE a.NO_BUKTI=b.NO_SJ");
                $hasil = "Berhasil proses ".$jumRecord." baris data (".$_FILES['fileimpor']['name'].")";
            }
            else {
                $hasil = "File Excel tidak cocok!";
            }
            
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert"> '.$hasil.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> </div>');
        }
    }
}

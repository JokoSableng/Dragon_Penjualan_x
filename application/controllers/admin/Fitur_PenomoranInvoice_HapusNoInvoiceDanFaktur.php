<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur extends CI_Controller
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

    public function index_Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur()
    {
        $this->db->query("UPDATE `menu_penjualan` SET `URL_MENU`='admin/Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur/index_Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur' WHERE (`NO_ID`='323')");
        $this->db->query("UPDATE `menu_penjualan` SET `URL_MENU`='admin/Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur/index_Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur' WHERE (`NO_ID`='324')");
        if (isset($_POST["ambiledit"])) {
            $this->importExcelEdit();
        }
        if (isset($_POST["ambilhapus"])) {
            $this->importExcelHapus();
        }
            $data = array(
                'TGL' => set_value('TGL'),
            );
            $data['fitur_penomoraninvoice_hapusnoinvoicedanfaktur'] = $this->fitur_model->tampil_data_fitur_penomoraninvoice_hapusnoinvoicedanfaktur()->result();
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/navbar');
            $this->load->view('admin/Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur/Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur', $data);
            $this->load->view('templates_admin/footer_report');
    }

    public function update()
    {
    }

    public function importExcelEdit()
    {
        $namaTabel = 'fitur_editInvoice';
        // composer require phpoffice/phpspreadsheet
        $this->db->query(" CREATE TABLE IF NOT EXISTS $namaTabel (
            `NOSJ` varchar(30) NOT NULL DEFAULT '',
            `TGLCI` date NULL DEFAULT '2001-01-01',
            `TGFAK` date NULL DEFAULT '2001-01-01',
            `JTEMPO` date NULL DEFAULT '2001-01-01',
            `INVOICE` varchar(30) NOT NULL DEFAULT '',
            `KODEFAK` varchar(50) NOT NULL DEFAULT '',
            `NOFAKTR` varchar(30) NOT NULL DEFAULT '',
            `NOCET` varchar(30) NOT NULL DEFAULT '',
            `KDMTS` varchar(25) NOT NULL DEFAULT '',
            `USRNM` varchar(50) NOT NULL DEFAULT '',
            `TG_SMP` datetime NULL DEFAULT '2001-01-01'
          ) 
        ");

        $hasil = '';
        $file = $_FILES['fileimporedit']['tmp_name'];
        $ekstensi  = explode('.', $_FILES['fileimporedit']['name']);
        if (!empty($file)) {
            if (strtolower(end($ekstensi)) === 'xlsx' && $_FILES["fileimporedit"]["size"] > 0) {
                $path_xlsx = $file;
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($path_xlsx);
                $d = $spreadsheet->getSheet(0)->toArray();
                $jumRecord = 0;
                $this->db->query("TRUNCATE table $namaTabel");
                unset($d[0]);
                foreach ($d as $t) {
                    $data = array(
                        'NOSJ' => $t[0],
                        'TGLCI' => date("Y-m-d", strtotime($t[1])),
                        'TGFAK' => date("Y-m-d", strtotime($t[2])),
                        'JTEMPO' => date("Y-m-d", strtotime($t[3])),
                        'INVOICE' => $t[4] ?? '',
                        'KODEFAK' => $t[5] ?? '',
                        'NOFAKTR' => $t[6] ?? '',
                        'NOCET' => $t[7] ?? '',
                        'KDMTS' => $t[8] ?? '',
                        'USRNM' => $this->session->userdata['username'],
                        'TG_SMP' => date("Y-m-d h:i:s"),
                    );
                    $this->master_model->input_data($namaTabel, $data);
                    $jumRecord++;
                }
                $this->db->query("UPDATE jual a, $namaTabel b SET a.INVOICE=b.INVOICE, a.TGL_FKTR=b.TGFAK, a.NO_FKTR=b.NOFAKTR WHERE a.NO_BUKTI=b.NOSJ and a.INVOICE<>b.INVOICE");
                $hasil = "Berhasil proses ".$jumRecord." baris data (".$_FILES['fileimporedit']['name'].").";
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

    public function importExcelHapus()
    {
        $namaTabel = 'fitur_hapusInvoice';
        // composer require phpoffice/phpspreadsheet
        $this->db->query(" CREATE TABLE IF NOT EXISTS $namaTabel (
            `NOSJ` varchar(30) NOT NULL DEFAULT '',
            `TGFAK` date NULL DEFAULT '2001-01-01',
            `JTEMPO` date NULL DEFAULT '2001-01-01',
            `INVOICE` varchar(30) NOT NULL DEFAULT '',
            `KODEFAK` varchar(50) NOT NULL DEFAULT '',
            `NOFAKTR` varchar(30) NOT NULL DEFAULT '',
            `NOCET` varchar(30) NOT NULL DEFAULT '',
            `KDMTS` varchar(25) NOT NULL DEFAULT '',
            `USRNM` varchar(50) NOT NULL DEFAULT '',
            `TG_SMP` datetime NULL DEFAULT '2001-01-01'
          ) 
        ");

        $hasil = '';
        $file = $_FILES['fileimporhapus']['tmp_name'];
        $ekstensi  = explode('.', $_FILES['fileimporhapus']['name']);
        if (!empty($file)) {
            if (strtolower(end($ekstensi)) === 'xlsx' && $_FILES["fileimporhapus"]["size"] > 0) {
                $path_xlsx = $file;
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($path_xlsx);
                $d = $spreadsheet->getSheet(0)->toArray();
                $jumRecord = 0;
                $this->db->query("TRUNCATE table $namaTabel");
                unset($d[0]);
                foreach ($d as $t) {
                    $data = array(
                        'NOSJ' => $t[0],
                        'TGFAK' => date("Y-m-d", strtotime($t[2])),
                        'JTEMPO' => date("Y-m-d", strtotime($t[3])),
                        'INVOICE' => $t[4] ?? '',
                        'KODEFAK' => $t[5] ?? '',
                        'NOFAKTR' => $t[6] ?? '',
                        'NOCET' => $t[7] ?? '',
                        'KDMTS' => $t[8] ?? '',
                        'USRNM' => $this->session->userdata['username'],
                        'TG_SMP' => date("Y-m-d h:i:s"),
                    );
                    $this->master_model->input_data($namaTabel, $data);
                    $jumRecord++;
                }
                $recordUpdate = $this->db->query("SELECT count(NOSJ) as NOSJ from $namaTabel WHERE INVOICE=''")->result();
                $this->db->query("UPDATE jual SET INVOICE='', TGL_FKTR='2001-01-01', NO_FKTR='' WHERE NO_BUKTI in (SELECT NOSJ from $namaTabel WHERE INVOICE='')");
                $hasil = "Berhasil proses ".$jumRecord." baris data (".$_FILES['fileimporhapus']['name']."). Terhapus ".$recordUpdate[0]->NOSJ." baris.";
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

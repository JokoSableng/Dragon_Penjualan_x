<?php

class DataPMS_ValidasiPesanan extends CI_Controller
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
		if (!isset($this->session->userdata['cari'])) {
			$this->session->set_userdata('cari', '');
		}
    }

	var $column_order = array(null, 'NO_BUKTI', 'NO_DO', 'WILAYAH', 'TGL_DO');
	var $column_search = array('NO_BUKTI', 'WILAYAH');
	var $order = array('NO_BUKTI' => 'asc');

	private function _get_datatables_query()
	{
		$periode = $this->session->userdata['filter_per'];
		$where = array(
			'PER' => $periode,
            'NO_DO' => "",
            'FLAG' => "PMS"
		);
		$this->db->select('*');
		$this->db->from('so');
		$this->db->where($where);
		$i = 0;
		foreach ($this->column_search as $item) { // loop column 
			if (@$_POST['search']['value']) { // if datatable send POST for search
				if ($i === 0) { // first loop
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) { // here order processing
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
		$periode = $this->session->userdata['filter_per'];
		$where = array(
			'PER' => $periode,
            'NO_DO' => "",
            'FLAG' => "PMS"
		);
		$this->db->from('so');
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	// end datatables

	function get_ajaxBkt()
	{
		$list = $this->get_datatables();
		$data = array();
		$no = @$_POST['start'];
		foreach ($list as $BKTX) {
			$no++;
			$row = array();
			$row[] = $no . ".";
			$row[] = $BKTX->NO_BUKTI;
			$row[] = '<input onclick="select()" value="' . $BKTX->NO_DO . '" type="text" class="form-control NO_DO" >';
			$row[] = $BKTX->WILAYAH;
			$row[] = date("d-m-Y", strtotime($BKTX->TGL_DO));
			$data[] = $row;
		}
		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->count_all(),
			"recordsFiltered" => $this->count_filtered(),
			"data" => $data,
		);
		// output to json format
		echo json_encode($output);
	}

    public function index_DataPMS_ValidasiPesanan()
    {
        $per = $this->session->userdata['periode'];
        if(isset($_POST["PER"])) {
            $per = $this->input->post('PER', TRUE);
        }
        $this->session->set_userdata('filter_per', $per);
        
        $data = array(
            'PER' => set_value('PER'),
        );
        // $data['datapms_validasipesanan'] = $this->datapms_model->tampil_data_datapms_validasipesanan()->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/DataPMS_ValidasiPesanan/DataPMS_ValidasiPesanan');
        $this->load->view('templates_admin/footer_report');
    }

	public function carix()
	{
		$cari = $this->input->post('cari');
		$this->session->set_userdata('cari', $cari);
	}

	public function edit()
	{
		$nosp = $this->input->post('NO_BUKTI');
		$nodo = $this->input->post('NO_DO');

		$q1 = "UPDATE so SET NO_DO='$nodo',TGL_DO=now() WHERE NO_BUKTI='$nosp' ";
		$this->db->query($q1);
		$hasil = "Data Berhasil Disimpan . . .";
		$hasil = $nosp . "_" . $nodo;

		echo json_encode($hasil);
	}
}

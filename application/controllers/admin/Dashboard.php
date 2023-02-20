<?php

class Dashboard extends CI_Controller
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

	public function index()
	{
		$data = $this->user_model->ambil_data($this->session->userdata['username']);
		$data = array(
			'username' => $data->USERNAME,
			'level' => $data->AKSES,
			'dr' => $data->DR,
			'periode' => $this->session->userdata['periode'],
		);
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('templates_admin/footer');
	}

	public function ganti_periode()
	{
		$month = $this->input->post('bulan');
		$year = $this->input->post('tahun');
		$periode = $month . '/' . $year;
		$this->session->set_userdata('periode', $periode);
		$data = $this->user_model->ambil_data($this->session->userdata['username']);
		$data = array(
			'username' => $data->username,
			'level'   => $data->level,
			'periode' => $this->session->userdata['periode'],
		);
		redirect('admin/dashboard');
	}

	// fungsi untuk ganti font
	public function ganti_font($id)
	{
		$font = $this->input->post('font');
		$size = $this->input->post('size');
		$data = [
			'FONT' => $font,
			'SIZE' => $size
		];
		$this->font_model->update($id, $data);
		redirect('admin/dashboard');
	}

	public function notif_so()
	{
		$q1 = "SELECT NO_BUKTI
            FROM so WHERE NO_DO=''
			GROUP BY NO_BUKTI
            ORDER BY NO_BUKTI";
		$q2 = $this->db->query($q1);
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				$hasil[] = $row;
			}
		};
		echo json_encode($hasil);
	}
}

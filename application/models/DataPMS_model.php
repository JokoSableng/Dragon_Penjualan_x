<?php

class DataPMS_model extends CI_Model
{

	/// VALIDASI PESANAN
	public function tampil_data_datapms_validasipesanan()
	{
		$per = $this->session->userdata['periode'];
		$no_bukti_1 = $this->input->post('NO_BUKTI_1');
		$q1 = " SELECT so.NO_BUKTI AS NO_BUKTI,
				so.TGL AS TGL,
				so.PER AS PER,
				so.NO_DO AS NO_DO,
				so.TGL_DO AS TGL_DO,
				so.WILAYAH AS WILAYAH,
				sod.KD_BRG AS KD_BRG,
				sod.WARNA AS WARNA,
				sod.GOL AS GOL,
				sod.QTY AS QTY,
				sod.QTYP AS QTYP,
				CONCAT(sod.KODEC,' - ',sod.NAMAC) AS CUSTOMERS
			FROM so, sod
			WHERE so.NO_BUKTI = sod.NO_BUKTI
			AND so.NO_BUKTI = '$no_bukti_1'
			AND so.POSTED = 0
			ORDER BY so.NO_BUKTI, sod.REC";
		return $this->db->query($q1);
	}
	/// BATAS VALIDASI PESANAN

	/// VALIDASI PESANAN MUTASI
	public function tampil_data_datapms_validasipesananmutasi()
	{
		// $per = $this->session->userdata['periode'];
		$no_bukti_1 = $this->input->post('NO_BUKTI_1');
		$no_bukti_2 = $this->input->post('NO_BUKTI_2');
		$q1 = " SELECT stockb.NO_BUKTI AS NO_BUKTI,
				stockb.TGL AS TGL,
				stockb.PER AS PER,
				stockb.NO_DO AS NO_DO,
				stockb.TGL_DO AS TGL_DO,
				stockb.WILAYAH AS WILAYAH,
				stockbd.KD_BRG AS KD_BRG,
				stockbd.WARNA AS WARNA,
				stockbd.GOL AS GOL,
				stockbd.QTY AS QTY,
				stockbd.QTYP AS QTYP,
				CONCAT(stockbd.KODEC,' - ',stockbd.NAMAC) AS CUSTOMERS
			FROM stockb, stockbd
			WHERE stockb.NO_BUKTI = stockbd.NO_BUKTI
			AND stockb.NO_BUKTI BETWEEN '$no_bukti_1' AND '$no_bukti_2'
			AND stockb.POSTED = 0
			ORDER BY stockb.NO_BUKTI, stockbd.REC";
		return $this->db->query($q1);
	}
	/// BATAS VALIDASI PESANAN MUTASI


}

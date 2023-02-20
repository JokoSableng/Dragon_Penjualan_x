<?php

class Fitur_model extends CI_Model
{

	/// CEK INVOICE
	public function tampil_data_fitur_cekinvoice()
	{
		$no_bukti_1 = $this->input->post('NO_BUKTI_1');
		$filter_bukti = " AND jual.NO_BUKTI='' ";
		if ($no_bukti_1 != '') {
			$filter_bukti = "AND jual.NO_BUKTI = '$no_bukti_1'";
		}
		$kodec_1 = $this->input->post('KODEC_1');
		$filter_kodec = " ";
		if ($this->input->post('KODEC', TRUE) != '') {
			$filter_kodec = "AND jual.KODEC = '$kodec_1'";
		}
		$per = $this->session->userdata['periode'];
		$q1 = " SELECT jual.PER AS PER,
				jual.NO_BUKTI AS NO_BUKTI,
				jual.KODEC AS KODEC,
				jual.NAMAC AS NAMAC,
				jual.INVOICE AS INVOICE,
				DATE_FORMAT(jual.TGL_FKTR,'%d/%m/%Y') AS TGL_FKTR,
				jual.NO_FKTR AS NO_FKTR,
				jual.NETT AS NETT
			FROM jual
			WHERE jual.FLAG='JR'
			AND jual.PER='$per'
			$filter_bukti
			$filter_kodec
			ORDER BY jual.NO_BUKTI, jual.KODEC";
		return $this->db->query($q1);
	}
	/// BATAS CEK INVOICE

	/// URUT INVOICE
	public function tampil_data_fitur_penomoraninvoice_urutinvoice()
	{
		$per = $this->input->post('PER', TRUE);
		$q1 = " SELECT jual.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(jual.TGL,'%d-%m-%Y') as TGL, 
				jual.INVOICE AS INVOICE,
				jual.TGL_FKTR AS TGL_FKTR,
				jual.JTEMPO AS JTEMPO,
				jual.INVOICE AS INVOICE,
				jual.NO_FKTR AS NO_FKTR
			FROM jual
			WHERE jual.FLAG='JR'
			AND jual.INVOICE=''
			AND jual.PER='$per'
			ORDER BY jual.NO_BUKTI, jual.TGL";
		return $this->db->query($q1);
	}
	/// BATAS URUT INVOICE

	/// HAPUS NO INVOICE DAN FAKTUR
	public function tampil_data_fitur_penomoraninvoice_hapusnoinvoicedanfaktur()
	{
		// $per = $this->session->userdata['periode'];
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$q1 = " SELECT jual.NO_BUKTI, 
			DATE_FORMAT(jual.TGL,'%d-%m-%Y') as TGL, 
			DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') as TGL_FKTR, 
			DATE_FORMAT(jual.JTEMPO,'%d-%m-%Y') as JTEMPO, 
			jual.INVOICE, 
			jual.KD_FKTR, 
			jual.NO_FKTR, 
			jual.NO_CET, 
			jual.WILAYAH
			FROM jual
			WHERE jual.FLAG='JR'
			AND jual.TGL='$tgl'
			ORDER BY jual.TGL_FKTR, jual.WILAYAH, jual.NO_BUKTI";
		return $this->db->query($q1);
	}
	/// BATAS HAPUS NO INVOICE DAN FAKTUR

	/// EXCEL 1
	public function tampil_data_fitur_excel_excel1()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = " SELECT jual.PER AS PER,
				jual.WILAYAH AS WILAYAH,
				jual.NO_BUKTI AS NO_BUKTI,
				jual.NO_DO AS NO_DO,
				jual.INVOICE AS INVOICE,
				jual.NO_FKTR AS NO_FKTR,
				jual.KD_FKTR AS KD_FKTR,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.KODEC AS KODEC,
				jual.NAMAC AS NAMAC,
				jual.ALAMAT AS ALAMAT,
				jual.KOTA AS KOTA,
				coalesce((SELECT NPWP from cust WHERE KODEC=jual.KODEC limit 1), '') AS NPWP,
				jual.TOTAL AS TOTAL,
				jual.TAX AS TAX
			FROM jual
			WHERE jual.FLAG='JR'
			AND MONTH(jual.TGL_FKTR) = '$bulan'
			AND YEAR(jual.TGL_FKTR) = '$tahun'
			ORDER BY jual.WILAYAH, jual.NO_BUKTI";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL 1

	/// EXCEL 2
	public function tampil_data_fitur_excel_excel2()
	{
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = " SELECT jual.PER AS PER,
				jual.WILAYAH AS WILAYAH,
				jual.NO_BUKTI AS NO_BUKTI,
				jual.NO_DO AS NO_DO,
				jual.INVOICE AS INVOICE,
				jual.NO_FKTR AS NO_FKTR,
				jual.KD_FKTR AS KD_FKTR,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.KODEC AS KODEC,
				jual.NAMAC AS NAMAC,
				jual.ALAMAT AS ALAMAT,
				jual.KOTA AS KOTA,
				coalesce((SELECT NPWP from cust WHERE KODEC=jual.KODEC limit 1), '') AS NPWP,
				jual.TOTAL AS TOTAL,
				jual.TAX AS TAX
			FROM jual
			WHERE jual.FLAG='JR'
			AND jual.TGL between '$tgl1' and '$tgl2'
			AND jual.INVOICE<>''
			AND jual.NO_FKTR<>''
			ORDER BY jual.WILAYAH, jual.NO_BUKTI";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL 2

	/// EXCEL 3
	public function tampil_data_fitur_excel_excel3()
	{
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = " SELECT jual.PER AS PER,
				jual.WILAYAH AS WILAYAH,
				jual.NO_BUKTI AS NO_BUKTI,
				jual.NO_DO AS NO_DO,
				jual.INVOICE AS INVOICE,
				jual.NO_FKTR AS NO_FKTR,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.KODEC AS KODEC,
				jual.NAMAC AS NAMAC,
				jual.TOTAL AS TOTAL,
				jual.TAX AS TAX,
				juald.KD_BRG as ARTICLE,
				sum(juald.QTY) as LUSIN,
				sum(juald.QTYP) as PAIR
			FROM jual, juald
			WHERE jual.NO_BUKTI=juald.NO_BUKTI 
			and jual.FLAG='JR'
			AND jual.TGL between '$tgl1' and '$tgl2'
			GROUP BY jual.WILAYAH, juald.KD_BRG
			ORDER BY jual.WILAYAH, jual.NO_BUKTI";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL 3

	/// EXCEL 4
	public function tampil_data_fitur_excel_excel4()
	{
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = " SELECT jual.WILAYAH AS WILAYAH,
				-- jual.NO_BUKTI AS NO_BUKTI,
				-- jual.NO_DO AS NO_DO,
				-- jual.INVOICE AS INVOICE,
				-- jual.NO_FKTR AS NO_FKTR,
				-- DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				-- jual.KODEC AS KODEC,
				-- jual.NAMAC AS NAMAC,
				sum(jual.TOTAL) AS TOTAL
			FROM jual
			WHERE jual.FLAG='JR'
			AND jual.TGL between '$tgl1' and '$tgl2'
			AND jual.INVOICE=''
			GROUP BY jual.WILAYAH
			ORDER BY jual.WILAYAH";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL 4

	/// EXCEL 5
	public function tampil_data_fitur_excel_excel5()
	{
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = " SELECT jual.PER AS PER,
				jual.WILAYAH AS WILAYAH,
				jual.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(jual.TGL,'%d-%m-%Y') AS TGL,
				jual.NO_DO AS NO_DO,
				jual.INVOICE AS INVOICE,
				jual.NO_FKTR AS NO_FKTR,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.KODEC AS KODEC,
				jual.KODERAY AS KODERAY,
				jual.NAMAC AS NAMAC,
				jual.ALAMAT AS ALAMAT,
				jual.KOTA AS KOTA,
				jual.TOTAL AS TOTAL,
				jual.TAX AS TAX,
				(SELECT NO_BUKTI from pms_piud WHERE NO_SURAT=jual.NO_BUKTI limit 1) as NO_BKK,
				(SELECT DATE_FORMAT(TGL,'%d-%m-%Y') from pms_piu WHERE NO_BUKTI=(SELECT NO_BUKTI from pms_piud WHERE NO_SURAT=jual.NO_BUKTI limit 1)) as TGL_BAYAR,
				(SELECT if(GIRO<>0,DATE_FORMAT(JTEMPO,'%d-%m-%Y'),'') from pms_piu WHERE NO_BUKTI=(SELECT NO_BUKTI from pms_piud WHERE NO_SURAT=jual.NO_BUKTI limit 1)) as JTEMPO_GIR,
				(SELECT if(GIRO=0,DATE_FORMAT(JTEMPO,'%d-%m-%Y'),'') from pms_piu WHERE NO_BUKTI=(SELECT NO_BUKTI from pms_piud WHERE NO_SURAT=jual.NO_BUKTI limit 1)) as JTEMPO_TUN
			FROM jual
			WHERE jual.FLAG='JR'
			AND jual.TGL between '$tgl1' and '$tgl2'
			AND jual.INVOICE=''
			ORDER BY jual.WILAYAH, jual.NO_BUKTI";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL 5

	/// EXCEL 6
	public function tampil_data_fitur_excel_excel6_rekarticle()
	{
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = " SELECT b.KD_BRG, sum(b.QTY) as LUSIN, sum(b.QTYP) as PAIR, sum(b.TOTAL) as TOTAL
			FROM jual a, juald b 
			WHERE a.NO_BUKTI=b.NO_BUKTI 
			AND a.FLAG='JR'
			AND a.WILAYAH BETWEEN '91' AND '98' 
			AND a.TGL BETWEEN '$tgl1' AND '$tgl2'
			GROUP BY b.KD_BRG
			ORDER BY b.KD_BRG";
		return $this->db->query($q1);
	}
	public function tampil_data_fitur_excel_excel6_jlarticle()
	{
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = " SELECT b.NO_BUKTI, b.KD_BRG, sum(b.QTY) as LUSIN, sum(b.QTYP) as PAIR, sum(b.TOTAL) as TOTAL
			FROM jual a, juald b 
			WHERE a.NO_BUKTI=b.NO_BUKTI 
			AND a.FLAG='JR'
			AND a.WILAYAH BETWEEN '91' and '98' 
			AND a.TGL BETWEEN '$tgl1' and '$tgl2'
			GROUP BY b.NO_BUKTI,b.KD_BRG
			ORDER BY b.NO_BUKTI,b.KD_BRG";
		return $this->db->query($q1);
	}
	public function tampil_data_fitur_excel_excel6_wiljlarticle()
	{
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = " SELECT KD_BRG, 
			sum(if(WILAYAH='91',QTY,0)) as PMS91, sum(if(WILAYAH='92',QTY,0)) as PMS92, sum(if(WILAYAH='93',QTY,0)) as PMS93,
			sum(if(WILAYAH='94',QTY,0)) as PMS94, sum(if(WILAYAH='95',QTY,0)) as PMS95, sum(if(WILAYAH='96',QTY,0)) as PMS96,
			sum(if(WILAYAH='97',QTY,0))as PMS97, sum(if(WILAYAH='98',QTY,0)) as PMS98, sum(TOTAL) as TOTAL from juald 
			WHERE NO_BUKTI in (SELECT NO_BUKTI from jual WHERE FLAG='JR' AND WILAYAH BETWEEN '91' AND '98' AND TGL BETWEEN '$tgl1' AND '$tgl2')
			GROUP BY KD_BRG
			ORDER BY KD_BRG";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL 6

	/// EXCEL 7
	public function tampil_data_fitur_excel_excel7()
	{
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = " SELECT jual.NO_BUKTI AS NO_BUKTI, DATE_FORMAT(jual.TGL,'%d-%m-%Y') as TGL, jual.FIX 
			FROM jual
			WHERE jual.FLAG='JR'
			AND jual.TGL BETWEEN '$tgl1' AND '$tgl2' 
			AND jual.INVOICE<>'' 
			ORDER BY jual.NO_BUKTI";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL 7

}

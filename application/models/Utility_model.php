<?php

class Utility_model extends CI_Model
{

	/// TRANSAKSI EVA EXCEL GIRO CAIR
	public function tampil_data_utility_excelgirocair()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = " SELECT piu.PER AS PER,
				piu.WILAYAH AS WILAYAH,
				piu.KODEC AS KODEC,
				piu.NAMAC AS NAMAC,
				piu.KOTA AS KOTA,
				piu.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(piu.JTEMPO,'%d-%m-%Y') AS JTEMPO,
				piu.NO_CHBG AS NO_CHBG,
				piu.GIRO AS GIRO,
				DATE_FORMAT(piu.TGL_CAIR,'%d-%m-%Y') AS TGL_CAIR,
				piu.BANK AS BANK
			FROM piu
			WHERE MONTH(piu.JTEMPO) = '$bulan'
			AND YEAR(piu.JTEMPO) = '$tahun'
			AND (TGL_CAIR='2001-01-01' or TGL_CAIR='0000-00-00')
			AND piu.NO_CHBG<>''
			ORDER BY piu.WILAYAH, piu.TGL_CAIR";
		return $this->db->query($q1);
	}
	/// BATAS TRANSAKSI EVA EXCEL GIRO CAIR

	/// TRANSAKSI EVA EXCEL GIRO CAIR
	public function tampil_data_utility_excelgirojtempo()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = " SELECT piu.PER AS PER,
				piu.WILAYAH AS WILAYAH,
				piu.KODEC AS KODEC,
				piu.NAMAC AS NAMAC,
				piu.KOTA AS KOTA,
				piu.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(piu.JTEMPO,'%d-%m-%Y') AS JTEMPO,
				piu.NO_CHBG AS NO_CHBG,
				piu.GIRO AS GIRO,
				DATE_FORMAT(piu.TGL_CAIR,'%d-%m-%Y') AS TGL_CAIR,
				piu.BANK AS BANK
			FROM piu
			WHERE MONTH(piu.JTEMPO) = '$bulan'
			AND YEAR(piu.JTEMPO) = '$tahun'
			AND piu.NO_CHBG<>''
			ORDER BY piu.WILAYAH, piu.JTEMPO";
		return $this->db->query($q1);
	}
	/// BATAS TRANSAKSI EVA EXCEL GIRO CAIR

	/// EXCEL INVOICE
	public function tampil_data_utility_excelinv()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = " SELECT jual.PER AS PER,
				jual.WILAYAH AS WILAYAH,
				jual.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.INVOICE AS INVOICE,
				jual.TOTAL AS TOTAL
			FROM jual
			WHERE jual.FLAG='JR'
			AND MONTH(jual.TGL_FKTR) = '$bulan'
			AND YEAR(jual.TGL_FKTR) = '$tahun'
			ORDER BY jual.WILAYAH, jual.NO_BUKTI";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL INVOICE

	public function tampil_data_index_Utility_CrosscheckDOSJToko()
	{
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$filter_wilayah = " ";
		if ($this->input->post('WILAYAH_1', TRUE) != '') {
			$filter_wilayah = "AND jual.WILAYAH = '$wilayah_1' ";
		}
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = "SELECT URUT, TGL_CETAK, BULAN, TAHUN, KET, KODEC, NAMAC, NO_BUKTI, INVOICE, ROUND(COALESCE(TOTAL, 0)) AS TOTAL FROM
			( SELECT 1 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN' AS KET,
					jual.KODEC AS KODEC,
					jual.NAMAC AS NAMAC,
					jual.NO_BUKTI AS NO_BUKTI,
					jual.INVOICE AS INVOICE,
					SUM(jual.NETT) AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				$filter_wilayah
				AND jual.FLAG = 'JR'
				GROUP BY jual.NO_BUKTI
				UNION ALL
				SELECT 2 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'RETUR' AS KET,
					jual.KODEC AS KODEC,
					jual.NAMAC AS NAMAC,
					jual.NO_BUKTI AS NO_BUKTI,
					jual.INVOICE AS INVOICE,
					SUM(jual.NETT) AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				$filter_wilayah
				AND jual.FLAG = 'RJ'
				GROUP BY jual.NO_BUKTI
			) AS AAA ORDER BY KODEC";
		return $this->db->query($q1);
	}

	public function tampil_data_index_Utility_CrosscheckDOSJ_so()
	{
		$nosp = $this->input->post('NOSP', TRUE);
		$kdbrg = $this->input->post('KDBRG', TRUE);
		$kodec = $this->input->post('KODEC', TRUE);

		$filter_nosp = " ";
		if ($nosp != '') {
			$filter_nosp = " AND a.NO_BUKTI = '$nosp' ";
		}
		$filter_kdbrg = " ";
		if ($kdbrg != '') {
			$filter_kdbrg = " AND b.KD_BRG = '$kdbrg' ";
		}
		$filter_kodec = " ";
		if ($kodec != '') {
			$filter_kodec = " AND b.KODEC = '$kodec' ";
		}

		if ($nosp=='' && $kdbrg=='' && $kodec=='') {
			$filter_nosp = " AND a.NO_BUKTI ='' ";
			$filter_kdbrg = " AND b.KD_BRG = '' ";
			$filter_kodec = " AND b.KODEC = '' ";
		}
		// $tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		// $bulan = substr($tgl, 5, 2);
		// $tahun = substr($tgl, 0, 4);
		$per = $this->session->userdata['periode'];
		$bulan = substr($per, 0, 2);
		$tahun = substr($per, -4);
		$q1 = "SELECT a.NO_BUKTI as NO_SP, a.NO_DO, b.KD_BRG, b.QTY, b.QTYP, b.KODEC, b.NAMAC
		from so a,sod b 
		WHERE a.NO_BUKTI=b.NO_BUKTI and a.PER='$per' and a.FLAG='PMS' 
		$filter_nosp $filter_kdbrg $filter_kodec
		;";
		return $this->db->query($q1);
	}
	public function tampil_data_index_Utility_CrosscheckDOSJ_jual()
	{
		$nosp = $this->input->post('NOSP', TRUE);
		$kdbrg = $this->input->post('KDBRG', TRUE);
		$kodec = $this->input->post('KODEC', TRUE);

		$filter_nosp = " ";
		if ($nosp != '') {
			$filter_nosp = " AND a.NO_DO in (SELECT NO_DO from so WHERE NO_BUKTI='$nosp') ";
		}
		$filter_kdbrg = " ";
		if ($kdbrg != '') {
			$filter_kdbrg = " AND b.KD_BRG = '$kdbrg' ";
		}
		$filter_kodec = " ";
		if ($kodec != '') {
			$filter_kodec = " AND b.KODEC = '$kodec' ";
		}

		if ($nosp=='' && $kdbrg=='' && $kodec=='') {
			$filter_nosp = " AND a.NO_DO in (SELECT NO_DO from so WHERE NO_BUKTI='') ";
			$filter_kdbrg = " AND b.KD_BRG = '' ";
			$filter_kodec = " AND b.KODEC = '' ";
		}
		// $tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		// $bulan = substr($tgl, 5, 2);
		// $tahun = substr($tgl, 0, 4);
		$per = $this->session->userdata['periode'];
		$bulan = substr($per, 0, 2);
		$tahun = substr($per, -4);
		$q1 = "SELECT (SELECT NO_BUKTI from so WHERE NO_DO=a.NO_DO and NO_DO<>'' limit 1) as NO_SP, a.NO_DO, b.KD_BRG, b.QTY, b.QTYP, a.NO_BUKTI as NO_SJ, b.KODEC, b.NAMAC
		from jual a,juald b 
		WHERE a.NO_BUKTI=b.NO_BUKTI and a.PER='$per' and a.FLAG='JR' 
		$filter_nosp $filter_kdbrg $filter_kodec
		;";
		return $this->db->query($q1);
	}
	/// NO INV
	public function tampil_data_utility_noinv()
	{
		$perke = $this->input->post('PERKE_1');
		// $perke = '06/2022';
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		// $tgl = '2022-06-02';
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = " SELECT jual.PER AS PER,
				jual.WILAYAH AS WILAYAH,
				jual.PERKE AS PERKE,
				jual.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.INVOICE AS INVOICE,
				jual.TOTAL AS TOTAL
			FROM jual
			WHERE jual.FLAG='JR'
			AND jual.PERKE = '$perke'
			AND MONTH(jual.TGL_FKTR) = '$bulan'
			AND YEAR(jual.TGL_FKTR) = '$tahun'
			ORDER BY jual.WILAYAH, jual.NO_BUKTI";
		return $this->db->query($q1);
		
	}
	/// BATAS NO INV

	/// EXCEL BBM BG
	public function tampil_data_utility_excelbbmbg()
	{
		$per = $this->session->userdata['periode'];
		$ver = substr($per, 0, 2);
		$thn = substr($per, -4);
		// $q1 = " SELECT jualbankd.PER AS PER,
		// 		jualbankd.NO_BUKTI AS NO_BUKTI,
		// 		'' AS NO_KASIR,
		// 		jualbankd.URAIAN AS URAIAN,
		// 		jualbankd.TOTAL AS TOTAL
		// 	FROM jualbankd
		// 	WHERE jualbankd.PER = '$per'
		// 	ORDER BY jualbankd.NO_BUKTI";
		$q1 = " SELECT jualbank.PER AS PER, jualbank.NO_BUKTI AS NO_BUKTI, '' AS NO_KASIR, 
				jualbank.KET AS URAIAN, jualbank.JUMLAH AS TOTAL
				FROM jualbank 
				WHERE /*jualbank.PER = '$per'*/
				DATE_FORMAT(jualbank.TGL,'%m')='$ver' and DATE_FORMAT(jualbank.TGL,'%Y')='$thn'
				ORDER BY jualbank.NO_BUKTI";
		return $this->db->query($q1);
	}
	/// BATAS EXCEL BBM BG

	/// CEK BAYAR
	public function tampil_data_utility_cekbayar()
	{
		$no_bukti = $this->input->post('NO_SURAT_1');
		$q1 = " SELECT piud.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(piud.TGL,'%d-%m-%Y') AS TGL,
				piud.NO_SURAT AS NO_SURAT,
				piud.KODEC AS KODEC,
				piud.SISA AS SISA
			FROM piud
			WHERE piud.NO_SURAT = '$no_bukti'
			ORDER BY piud.REC";
		return $this->db->query($q1);
	}
	/// BATAS CEK BAYAR

	public function tampil_data_utility_copypergolongan()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$q1 = " SELECT aa.NO_BUKTI as NOSP, aa.NO_DO, bb.NO_BUKTI as NOSJ, bb.TGL, aa.KODEC, aa.KD_BRG, 
		coalesce(aa.QTY,0) as QTYSP, aa.HARGA, coalesce(bb.QTY,0) as QTYSJ, bb.HARGA, bb.TOTAL from
		(SELECT a.NO_BUKTI, a.KODEC, a.NO_DO, a.KD_BRG, sum(a.QTY) as QTY, a.HARGA from sod a 
		WHERE a.NO_DO in (SELECT NO_DO from jual WHERE TGL='$tgl')
		GROUP BY a.NO_DO,a.KD_BRG
		) as aa 
		LEFT JOIN
		(SELECT b.NO_BUKTI, b.KODEC, b.NO_DO, b.TGL, c.KD_BRG, sum(c.QTY) as QTY, c.HARGA, sum(c.TOTAL) as TOTAL from jual b, juald c 
		WHERE b.NO_BUKTI=c.NO_BUKTI and b.FLAG='JR' and b.TGL='$tgl'
		GROUP BY b.NO_BUKTI,b.NO_DO,c.KD_BRG
		) as bb
		on aa.NO_DO=bb.NO_DO and aa.KD_BRG=bb.KD_BRG
		WHERE aa.QTY<>bb.QTY
		ORDER BY aa.NO_DO,aa.KD_BRG;";
		return $this->db->query($q1);
	}

	public function tampil_data_utility_CekSJDO()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$q1 = " SELECT aa.NO_BUKTI as NOSP, aa.NO_DO, bb.NO_BUKTI as NOSJ, bb.TGL, aa.KODEC, aa.KD_BRG, 
		coalesce(aa.QTY,0) as QTYSP, aa.HARGA, coalesce(bb.QTY,0) as QTYSJ, bb.HARGA, bb.TOTAL from
		(SELECT a.NO_BUKTI, a.KODEC, a.NO_DO, a.KD_BRG, sum(a.QTY) as QTY, a.HARGA from sod a 
		WHERE a.NO_DO in (SELECT NO_DO from jual WHERE TGL='$tgl')
		GROUP BY a.NO_DO,a.KD_BRG
		) as aa 
		LEFT JOIN
		(SELECT b.NO_BUKTI, b.KODEC, b.NO_DO, b.TGL, c.KD_BRG, sum(c.QTY) as QTY, c.HARGA, sum(c.TOTAL) as TOTAL from jual b, juald c 
		WHERE b.NO_BUKTI=c.NO_BUKTI and b.FLAG='JR' and b.TGL='$tgl'
		GROUP BY b.NO_BUKTI,b.NO_DO,c.KD_BRG
		) as bb
		on aa.NO_DO=bb.NO_DO and aa.KD_BRG=bb.KD_BRG
		WHERE aa.QTY<>bb.QTY
		ORDER BY aa.NO_DO,aa.KD_BRG;";
		return $this->db->query($q1);
	}

	public function tampil_data_utility_CekArticleJLPMS()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$q1 = " SELECT NOSP, NO_DO, NOSJ, TGL, KD_BRG, sum(DISCRP) as DISCRP, WARNA from (
			SELECT aa.NO_BUKTI as NOSP, aa.NO_DO, bb.NO_BUKTI as NOSJ, bb.TGL, aa.KODEC, aa.KD_BRG, 
			coalesce(aa.QTY,0) as QTYSP, aa.HARGA as HARGASP, coalesce(bb.QTY,0) as QTYSJ, bb.HARGA as HARGASJ, bb.TOTAL, aa.WARNA, bb.DISCRP from
			(SELECT a.NO_BUKTI, a.KODEC, a.NO_DO, a.KD_BRG, sum(a.QTY) as QTY, a.HARGA, a.WARNA from sod a 
			WHERE a.NO_DO in (SELECT NO_DO from jual WHERE TGL='$tgl')
			GROUP BY a.NO_DO,a.KD_BRG
			) as aa 
			LEFT JOIN
			(SELECT b.NO_BUKTI, b.KODEC, b.NO_DO, b.TGL, c.KD_BRG, sum(c.QTY) as QTY, c.HARGA, sum(c.TOTAL) as TOTAL, c.DISCRP from jual b, juald c 
			WHERE b.NO_BUKTI=c.NO_BUKTI and b.FLAG='JR' and b.TGL='$tgl'
			GROUP BY b.NO_BUKTI,b.NO_DO,c.KD_BRG
			) as bb
			on aa.NO_DO=bb.NO_DO and aa.KD_BRG=bb.KD_BRG
			WHERE aa.QTY<>bb.QTY
		) as jlpms
		GROUP BY KD_BRG
		ORDER BY KD_BRG;";
		return $this->db->query($q1);
	}

	public function tampil_data_utility_CekNoSJJLPMS()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$q1 = " SELECT aa.NO_BUKTI as NOSP, aa.NO_DO, bb.NO_BUKTI as NOSJ, bb.TGL, aa.KODEC, aa.KD_BRG, 
		coalesce(aa.QTY,0) as QTYSP, aa.HARGA, coalesce(bb.QTY,0) as QTYSJ, bb.HARGA, bb.TOTAL from
		(SELECT a.NO_BUKTI, a.KODEC, a.NO_DO, a.KD_BRG, sum(a.QTY) as QTY, a.HARGA from sod a 
		WHERE a.NO_DO in (SELECT NO_DO from jual WHERE TGL='$tgl')
		GROUP BY a.NO_DO,a.KD_BRG
		) as aa 
		LEFT JOIN
		(SELECT b.NO_BUKTI, b.KODEC, b.NO_DO, b.TGL, c.KD_BRG, sum(c.QTY) as QTY, c.HARGA, sum(c.TOTAL) as TOTAL from jual b, juald c 
		WHERE b.NO_BUKTI=c.NO_BUKTI and b.FLAG='JR' and b.TGL='$tgl'
		GROUP BY b.NO_BUKTI,b.NO_DO,c.KD_BRG
		) as bb
		on aa.NO_DO=bb.NO_DO and aa.KD_BRG=bb.KD_BRG
		WHERE aa.QTY<>bb.QTY
		ORDER BY aa.NO_DO,aa.KD_BRG;";
		return $this->db->query($q1);
	}

}

<?php

class Laporan_model extends CI_Model
{

	/// LAPORAN

	public function tampil_data_penjualan_rekappenjualan()
	{
		// SELE 'PENJUALAN EXPORT' AS KET,SUM(total) AS TOTAL,sum(total) as dpp FROM cihdr WHERE MONTH(cihdr.tgfak)=MONTH(dDateto) and YEAR(cihdr.tgfak)=YEAR(dDateto) AND EXPORT=1 GROUP BY kdmts INTO CURSOR DETAIL READWRITE
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 6, 2);
		$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
		$per = $setbulan . '/' . $settahun;
		$q1 = " SELECT TGL_CETAK, KET, DPP, PPN, NETT FROM
			(
				SELECT '$tgl' AS TGL_CETAK,
					'PENJUALAN EXPORT' AS KET,
					SUM(jual.DPP) AS DPP,
					SUM(jual.PPN) AS PPN,
					SUM(jual.NETT) AS NETT
				FROM jual
				WHERE jual.PER= '$per'
				-- WHERE MONTH(jual.TGL)='$setbulan'
				-- AND YEAR(jual.TGL)='$settahun'
				AND jual.FLAG='JR'
				AND jual.EXPORT=1
			)";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rekappenjualanwilayah()
	{
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT KET, WILAYAH, DPP, PPN, TOTAL 
			FROM (
				SELECT 'PENJUALAN EXPORT' AS KET,
					jual.WILAYAH AS WILAYAH,
					SUM(jual.DPP) AS DPP,
					SUM(jual.PPN) AS PPN,
					SUM(jual.TOTAL) AS TOTAL
				FROM jual
				WHERE jual.PER = '$per'
				AND jual.EXPORT = 1
				GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 'PENJUALAN MOBIL' AS KET,
					jual.WILAYAH AS WILAYAH,
					SUM(jual.DPP) AS DPP,
					SUM(jual.PPN) AS PPN,
					SUM(jual.TOTAL) AS TOTAL
				FROM jual
				WHERE jual.PER = '$per'
				AND jual.ASET = 1
				GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 'PENJUALAN LAIN' AS KET,
					jual.WILAYAH AS WILAYAH,
					SUM(jual.DPP) AS DPP,
					SUM(jual.PPN) AS PPN,
					SUM(jual.TOTAL) AS TOTAL
				FROM jual
				WHERE jual.PER = '$per'
				AND jual.KDCI = 1
				GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 'PENJUALAN UM' AS KET,
					jual.WILAYAH AS WILAYAH,
					SUM(jual.DPP) AS DPP,
					SUM(jual.PPN) AS PPN,
					SUM(jual.TOTAL) AS TOTAL
				FROM jual
				WHERE jual.PER = '$per'
				AND jual.KDCI = 'U'
				GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 'PENJUALAN LOKAL' AS KET,
					jual.WILAYAH AS WILAYAH,
					SUM(jual.DPP) AS DPP,
					SUM(jual.PPN) AS PPN,
					SUM(jual.TOTAL) AS TOTAL
				FROM jual
				WHERE jual.PER = '$per'
				AND jual.LOKAL = 1
				GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 'PENJUALAN PKP' AS KET,
					jual.WILAYAH AS WILAYAH,
					SUM(jual.DPP) AS DPP,
					SUM(jual.PPN) AS PPN,
					SUM(jual.TOTAL) AS TOTAL
				FROM jual
				WHERE jual.PER = '$per'
				AND jual.TAX = 'P'
				GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 'PENJUALAN PMS' AS KET,
					jual.WILAYAH AS WILAYAH,
					SUM(jual.DPP) AS DPP,
					SUM(jual.PPN) AS PPN,
					SUM(jual.TOTAL) AS TOTAL
				FROM jual
				WHERE jual.PER = '$per'
				AND jual.PMS = 1
				GROUP BY jual.WILAYAH
			) AS AAA
			GROUP BY WILAYAH, KET";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rekappenjualangolongan()
	{
		$per = $this->session->userdata['periode'];
		$q1 = " SELECT 
				CASE 
					WHEN juald.FLAG = 'JR' THEN 'A. PENJUALAN'
					WHEN juald.FLAG = 'RJ' THEN 'B. RETUR'
				END AS KET,
				CASE 
					WHEN juald.GOL = 1 THEN 'SEPATU INJECT'
					WHEN juald.GOL = 2 THEN 'SEPATU JOGGING/TENNES'
					WHEN juald.GOL = 3 THEN 'SEPATU KARET/FULL PLASTIK'
					WHEN juald.GOL = 4 THEN 'SANDAL JAPIT'
					WHEN juald.GOL = 5 THEN 'SANDAL EVA/GUNUNG/SPON/PHYLON'
					WHEN juald.GOL = 6 THEN 'BAHAN'
					WHEN juald.GOL = 7 THEN 'PVC SHEET'
					WHEN juald.GOL = 8 THEN 'JASA PRODUKSI'
					WHEN juald.GOL = 10 THEN 'PENDAPATAN SEWA'
					WHEN juald.GOL = 12 THEN 'APD'
				END AS GOL,
				SUM(jual.DPP) AS DPP,
				SUM(jual.PPN) AS PPN,
				SUM(jual.TOTAL) AS TOTAL
			FROM jual, juald
			WHERE jual.NO_BUKTI = juald.NO_BUKTI
			AND jual.PER='$per'
			GROUP BY juald.FLAG, juald.GOL";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rincianpenjualangolongan()
	{
		$per = $this->session->userdata['periode'];
		$q1 = " SELECT jual.INVOICE AS INVOICE,
				jual.TGL_FKTR AS TGL_FKTR,
				jual.KODEC AS KODEC,
				SUM(juald.QTY) AS QTY,
				SUM(juald.QTYP) AS QTYP,
				CASE 
					WHEN juald.GOL = 1 THEN SUM(jual.TOTAL)
				END AS INJECT,
				CASE 
					WHEN juald.GOL = 2 THEN SUM(jual.TOTAL)
				END AS JOGGING,
				CASE 
					WHEN juald.GOL = 3 THEN SUM(jual.TOTAL)
				END AS KARET,
				CASE 
					WHEN juald.GOL = 4 THEN SUM(jual.TOTAL)
				END AS JAPIT,
				CASE 
					WHEN juald.GOL = 5 THEN SUM(jual.TOTAL)
				END AS EVA,
				CASE 
					WHEN juald.GOL = 6 THEN SUM(jual.TOTAL)
				END AS BAHAN,
				CASE 
					WHEN juald.GOL = 7 THEN SUM(jual.TOTAL)
				END AS PVC,
				CASE 
					WHEN juald.GOL = 8 THEN SUM(jual.TOTAL)
				END AS JASA,
				CASE 
					WHEN juald.GOL = 10 THEN SUM(jual.TOTAL)
				END AS SEWA,
				CASE 
					WHEN juald.GOL = 12 THEN SUM(jual.TOTAL)
				END AS APD
			FROM jual, juald
			WHERE jual.NO_BUKTI = juald.NO_BUKTI
			AND jual.PER='$per'
			GROUP BY jual.INVOICE
			ORDER BY jual.INVOICE";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rincianpenjualanlangganan()
	{
		$per = $this->session->userdata['periode'];
		$kodec_1 = $this->input->post('KODEC_1', TRUE);
		$q1 = " SELECT jual.TGL AS TGL,
				CONCAT(jual.KODEC,' - ',jual.NAMAC) AS PELANGGAN,
				jual.NO_BUKTI AS NO_BUKTI,
				jual.INVOICE AS INVOICE,
				jual.TGL_FKTR AS TGL_FKTR,
				CASE 
					WHEN jual.FLAG = 'JR' THEN 'A. PENJUALAN'
					WHEN jual.FLAG = 'RJ' THEN 'B. RETUR'
				END AS FLAG,
				SUM(jual.NETT) AS NETT
			FROM jual
			WHERE jual.KODEC = '$kodec_1'
			AND jual.PER='$per'
			GROUP BY jual.KODEC
			ORDER BY jual.TGL, jual.KODEC, jual.NO_BUKTI, jual.FLAG";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rincianpenjualanwilayah()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT jual.KODEC AS KODEC,
				jual.NAMAC AS NAMAC,
				jual.NO_BUKTI AS NO_BUKTI,
				jual.NO_SURAT AS NO_SURAT,
				jual.INVOICE AS INVOICE,
				CASE 
					WHEN jual.FLAG = 'JR' THEN 'A. PENJUALAN'
					WHEN jual.FLAG = 'RJ' THEN 'B. RETUR'
				END AS FLAG,
				jual.NETT AS NETT
			FROM jual
			WHERE jual.WILAYAH = '$wilayah_1'
			AND jual.PER='$per'
			ORDER BY jual.KODEC, jual.NO_BUKTI";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_registerpenjualanpms()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT jual.TGL AS TGL,
				jual.NO_BUKTI AS NO_BUKTI,
				'-' AS URAIAN,
				(jual.TOTAL+jual.TDISK) AS BRUTO,
				jual.TDISK AS TDISK,
				jual.NETT AS NETT
			FROM jual
			WHERE jual.WILAYAH = '$wilayah_1'
			AND jual.PER='$per'
			AND jual.PMS = 1
			ORDER BY jual.TGL, jual.NO_BUKTI";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_suratjalan()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_pembayaran_nota_toko()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_pembayaran_nota_wilayah()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_rekap_pembayaran_wilayah()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_sisa_nota()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_sisa_nota_wilayah()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_piutang()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_piutang_wilayah()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_kartu_piutang()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_Omzet_Pms()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_Omzet_Jenis()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_Surat_pesanan()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_Do()
	{
		$per = $this->session->userdata['periode'];
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT surats.NO_BUKTI AS NO_BUKTI,
				surats.PER AS PER,
				surats.WILAYAH AS WILAYAH,
				surats.JTEMPO AS JTEMPO,
				surats.TGL AS TGL,
				surats.NAMAC AS NAMAC,
				surats.ALAMAT AS ALAMAT,
				surats.KOTA AS KOTA,
				surats.NOPOL AS NOPOL,
				suratsd.REC AS REC,
				suratsd.KD_BRG AS KD_BRG,
				suratsd.QTY AS QTY,
				suratsd.QTYP AS QTYP
			FROM surats, suratsd
			WHERE surats.NO_BUKTI = suratsd.NO_BUKTI
			AND surats.WILAYAH = '$wilayah_1'
			AND surats.PER='$per'
			AND surats.FLAG = 'GDG'
			AND surats.FLAG2 = 'SJ'
			AND surats.JUAL = 1
			ORDER BY surats.TGL, surats.NO_BUKTI, suratsd.REC";
		return $this->db->query($q1);
	}

	/// BATAS LAPORAN

	///	TRANSAKSI EXCEL

	public function tampil_data_transaksi_copyexcel()
	{
		$kodec = $this->input->post('KODEC');
		$filter_kodec = " ";
		if ($this->input->post('KODEC', TRUE) != '') {
			$filter_kodec = "AND jual.KODEC = '$kodec'";
		}
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$q1 = "SELECT jual.NO_BUKTI AS NO_BUKTI, 
                jual.KODEC AS KODEC, 
                jual.NAMAC AS NAMAC, 
                jual.NO_SO AS NO_SO, 
                jual.TGL AS TGL,
                juald.KD_BRG AS KD_BRG,
                juald.QTY AS QTY,
                juald.HARGA AS HARGA
            FROM jual, juald
            WHERE jual.NO_BUKTI=juald.NO_BUKTI 
            AND jual.FLAG='JR'
            $filter_kodec
            AND jual.TGL <= '$tgl'
            ORDER BY jual.TGL";
		return $this->db->query($q1);
	}

	public function tampil_data_transaksi_copyjualperperiode()
	{
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT jual.WILAYAH AS WILAYAH, 
                jual.KODEC AS KODEC, 
                jual.NAMAC AS NAMAC, 
                jual.NO_SO AS NO_SO, 
                jual.NO_BUKTI AS NO_BUKTI,
                jual.TGL AS TGL,
                juald.KD_BRG AS KD_BRG,
                juald.QTY AS QTY,
                juald.QTYP AS QTYP,
                juald.HARGA AS HARGA,
                juald.HARGAP AS HARGAP
            FROM jual, juald
            WHERE jual.NO_BUKTI=juald.NO_BUKTI 
            AND jual.FLAG = 'JR'
            AND jual.PER = '$per'
            ORDER BY jual.NO_BUKTI";
		return $this->db->query($q1);
	}

	public function tampil_data_transaksi_copyexcelpi()
	{
		$kodec = $this->input->post('KODEC');
		$filter_kodec = " ";
		if ($this->input->post('KODEC', TRUE) != '') {
			$filter_kodec = "AND jual.KODEC = '$kodec'";
		}
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$q1 = "SELECT jual.NO_BUKTI AS NO_BUKTI, 
                jual.KODEC AS KODEC, 
                jual.NAMAC AS NAMAC, 
                jual.NO_SO AS NO_SO, 
                jual.TGL AS TGL,
                juald.KD_BRG AS KD_BRG,
                juald.QTY AS QTY,
                juald.HARGA AS HARGA
            FROM jual, juald
            WHERE jual.NO_BUKTI=juald.NO_BUKTI 
            AND jual.FLAG='JR'
            $filter_kodec
            AND jual.TGL <= '$tgl'
            ORDER BY jual.TGL";
		return $this->db->query($q1);
	}

	///	BATAS TRANSAKSI EXCEL

	///	FAKTUR EXCEL

	public function tampil_data_faktur_penjualanexcelharian()
	{
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl_2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = "SELECT jual.WILAYAH AS WILAYAH, 
                SUM(jual.TOTAL) AS TOTAL 
            FROM jual
            WHERE jual.FLAG= 'JR'
			AND jual.EXPORt = 1
			AND jual.TGL BETWEEN '$tgl_1' AND '$tgl_2'
			GROUP BY jual.WILAYAH
            ORDER BY jual.WILAYAH";
		return $this->db->query($q1);
	}

	public function tampil_data_faktur_penjualanexcel()
	{
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl_2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = "SELECT jual.WILAYAH AS WILAYAH,
				jual.TGL AS TGL,
				jual.TGL_SJ AS TGL_SJ,
                SUM(jual.TOTAL) AS TOTAL 
            FROM jual
            WHERE jual.FLAG= 'JR'
			AND jual.TGL_SJ BETWEEN '$tgl_1' AND '$tgl_2'
			GROUP BY jual.WILAYAH, jual.TGL_SJ
            ORDER BY jual.TGL_SJ";
		return $this->db->query($q1);
	}

	public function tampil_data_faktur_copyexcel()
	{
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT jual.NO_FKTR AS NO_FKTR,
                jual.TGL_FKTR AS TGL_FKTR,
				jual.NO_SURAT AS NO_SURAT,
                jual.KODEC AS KODEC, 
                jual.NAMAC AS NAMAC, 
                jual.INVOICE AS INVOICE,
                jual.TOTAL AS TOTAL
            FROM jual
            WHERE jual.FLAG = 'JR'
            AND jual.PER = '$per'
            ORDER BY jual.NO_FKTR";
		return $this->db->query($q1);
	}

	public function tampil_data_faktur_copynodokeexcel()
	{
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT jual.NO_SURAT AS NO_SURAT,
                jual.NO_SO AS NO_SO,
				jual.TGL AS TGL,
                jual.NO_DO AS NO_DO
            FROM jual
            WHERE jual.FLAG = 'JR'
            AND jual.PER = '$per'
			AND jual.NO_DO <> ''
			GROUP BY jual.NO_DO
            ORDER BY jual.NO_DO";
		return $this->db->query($q1);
	}

	public function tampil_data_faktur_ceknota()
	{
		$no_surat = $this->input->post('NO_SURAT');
		$filter_no_surat = " ";
		if ($this->input->post('NO_SURAT', TRUE) != '') {
			$filter_no_surat = "AND jual.NO_SURAT = '$no_surat'";
		}
		$kodec = $this->input->post('KODEC');
		$filter_kodec = " ";
		if ($this->input->post('KODEC', TRUE) != '') {
			$filter_kodec = "AND jual.KODEC = '$kodec'";
		}
		$namac = $this->input->post('NAMAC');
		$filter_namac = " ";
		if ($this->input->post('NAMAC', TRUE) != '') {
			$filter_namac = "AND jual.NAMAC = '$namac'";
		}
		$invoice = $this->input->post('INVOICE');
		$filter_invoice = " ";
		if ($this->input->post('INVOICE', TRUE) != '') {
			$filter_invoice = "AND jual.INVOICE = '$invoice'";
		}
		$q1 = "SELECT piu.NO_BUKTI AS NO_BUKTI,
                jual.KODEC AS KODEC,
				jual.NAMAC AS NAMAC,
                jual.INVOICE AS INVOICE,
                jual.TGL_FKTR AS TGL_FKTR,
                jual.NO_FKTR AS NO_FKTR,
                jual.TOTAL AS TOTAL
            FROM jual
            WHERE jual.FLAG = 'JR'
			$filter_no_surat
			$filter_kodec
			$filter_namac
			$filter_invoice
			ORDER BY jual.NO_DO";
		return $this->db->query($q1);
	}
	///	BATAS FAKTUR EXCEL

}

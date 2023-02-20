<?php

class Laporan_model extends CI_Model
{

	/// LAPORAN
	public function tampil_data_penjualan_rekappenjualan()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = "SELECT URUT, TGL_CETAK, BULAN, TAHUN, KET, ROUND(COALESCE(DPP, 0)) AS DPP, ROUND(COALESCE(PPN, 0)) AS PPN, ROUND(COALESCE(DPP+PPN, 0)) AS TOTAL FROM
			( SELECT 1 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN EXPORT' AS KET,
					SUM(jual.NETT) AS DPP,
					0 AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				AND jual.FLAG = 'JR'
				AND jual.EXPORT = 1
				-- GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 2 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN MOBIL' AS KET,
					SUM(jual.NETT) AS DPP,
					0 AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				AND jual.FLAG = 'JR'
				AND jual.ASET = 1
				-- GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 3 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN LOKAL PKP' AS KET,
					SUM(jual.NETT/1.1) AS DPP,
					SUM(jual.NETT-(jual.NETT/1.1)) AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				AND jual.FLAG = 'JR'
				AND jual.TAX = 'P'
				AND jual.EXPORT <> 1
				AND jual.ASET <> 1
				-- GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 4 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN LOKAL NON PKP' AS KET,
					SUM(jual.NETT/1.1) AS DPP,
					SUM(jual.NETT-(jual.NETT/1.1)) AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_FKTR) = '$bulan'
				AND YEAR(jual.TGL_FKTR) = '$tahun'
				AND jual.FLAG = 'JR'
				AND jual.TAX <> 'P'
				AND jual.EXPORT <> 1
				AND jual.ASET <> 1
				-- GROUP BY jual.WILAYAH
				UNION ALL
				SELECT 5 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'PENJUALAN RETUR' AS KET,
					SUM((jual.NETT/1.1)*-1) AS DPP,
					SUM((jual.NETT-(jual.NETT/1.1))*-1) AS PPN,
					0 AS TOTAL
				FROM jual
				WHERE MONTH(jual.TGL_PMS) = '$bulan'
				AND YEAR(jual.TGL_PMS) = '$tahun'
				AND jual.FLAG = 'RJ'
				-- GROUP BY jual.WILAYAH
			) AS AAA WHERE DPP<>0 GROUP BY KET ORDER BY URUT ";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rekappenjualanwilayah()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
		$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
		$per = $setbulan . '/' . $settahun;
		$q1 = "SELECT 'A.PENJUALA EXPORT' KET, WILAYAH, SUM(TOTAL) DPP, '0' PPN, SUM(TOTAL) TOTAL  FROM jual WHERE PER = '$per' AND FLAG = 'JR' AND EXPORT = '1' GROUP BY WILAYAH
				UNION ALL
				SELECT 'B.PENJUALA PMS' KET, WILAYAH, SUM(NETT/1.1) DPP, SUM(NETT-(NETT/1.1)) PPN, SUM(NETT) TOTAL  FROM jual 
				WHERE PER = '$per' AND FLAG = 'JR' AND PMS = '1' AND EXPORT <> '1' AND ASET <> '1' AND NO_BUKTI NOT LIKE '%UM%' AND NO_BUKTI NOT LIKE '%IDST%' GROUP BY WILAYAH
				UNION ALL
				SELECT 'C.PENJUALA LOKAL' KET, WILAYAH, SUM(NETT/1.1) DPP, SUM(NETT-(NETT/1.1)) PPN, SUM(NETT) TOTAL  FROM jual 
				WHERE PER = '$per' AND FLAG = 'JR'  AND EXPORT <> '1' AND ASET <> '1'  AND NO_BUKTI LIKE '%IDST%' GROUP BY WILAYAH
				UNION ALL
				SELECT 'D.PENJUALAN UM' KET, WILAYAH, SUM(NETT/1.1) DPP, SUM(NETT-(NETT/1.1)) PPN, SUM(NETT) TOTAL  FROM jual 
				WHERE PER = '$per' AND FLAG = 'JR'  AND EXPORT <> '1' AND ASET <> '1'  AND NO_BUKTI LIKE '%UM%' GROUP BY WILAYAH
				UNION ALL
				SELECT 'E.RETUR' KET, WILAYAH, (SUM(NETT/1.1)-(SUM(NETT/1.1)*2)) DPP, (SUM(NETT-(NETT/1.1))-(SUM(NETT-(NETT/1.1))*2)) PPN, (SUM(NETT)-(SUM(NETT)*2)) TOTAL  FROM jual 
				WHERE PER = '$per' AND FLAG = 'RJ'  GROUP BY WILAYAH";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rekappenjualangolongan()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = "SELECT URUT, TGL_CETAK, BULAN, TAHUN, KET, GOL, ROUND(COALESCE(DPP, 0)) AS DPP, ROUND(COALESCE(PPN, 0)) AS PPN, ROUND(COALESCE(DPP+PPN, 0)) AS TOTAL FROM
			( SELECT 1 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'A. PENJUALAN' AS KET,
					CASE 
						WHEN goljual.GOL = '1' THEN 'SEPATU INJECT'
						WHEN goljual.GOL = '2' THEN 'SEPATU JOGGING/TENNES'
						WHEN goljual.GOL = '3' THEN 'SEPATU KARET/FULL PLASTIK'
						WHEN goljual.GOL = '4' THEN 'SANDAL JAPIT'
						WHEN goljual.GOL = '5' THEN 'SANDAL EVA/GUNUNG/SPON/PHYLON'
						WHEN goljual.GOL = '6' THEN 'BAHAN'
						WHEN goljual.GOL = '7' THEN 'PVC SHEET'
						WHEN goljual.GOL = '8' THEN 'JASA PRODUKSI'
						WHEN goljual.GOL = '10' THEN 'PENDAPATAN SEWA'
						WHEN goljual.GOL = '12' THEN 'APD'
						ELSE 'X'
					END AS GOL,
					SUM(goljual.TOTAL/1.1) AS DPP,
					SUM(goljual.TOTAL-(goljual.TOTAL/1.1)) AS PPN,
					0 AS TOTAL
				FROM goljual
				WHERE MONTH(goljual.TGL_FKTR) = '$bulan'
				AND YEAR(goljual.TGL_FKTR) = '$tahun'
				AND goljual.RETUR <> 'T'
				GROUP BY goljual.GOL
				UNION ALL
				SELECT 2 AS URUT,
					'$tgl' AS TGL_CETAK,
					'$bulan' AS BULAN,
					'$tahun' AS TAHUN,
					'B. RETUR' AS KET,
					CASE 
						WHEN goljual.GOL = '1' THEN 'SEPATU INJECT'
						WHEN goljual.GOL = '2' THEN 'SEPATU JOGGING/TENNES'
						WHEN goljual.GOL = '3' THEN 'SEPATU KARET/FULL PLASTIK'
						WHEN goljual.GOL = '4' THEN 'SANDAL JAPIT'
						WHEN goljual.GOL = '5' THEN 'SANDAL EVA/GUNUNG/SPON/PHYLON'
						WHEN goljual.GOL = '6' THEN 'BAHAN'
						WHEN goljual.GOL = '7' THEN 'PVC SHEET'
						WHEN goljual.GOL = '8' THEN 'JASA PRODUKSI'
						WHEN goljual.GOL = '10' THEN 'PENDAPATAN SEWA'
						WHEN goljual.GOL = '12' THEN 'APD'
						ELSE 'X'
					END AS GOL,
					SUM(goljual.TOTAL/1.1) AS DPP,
					SUM(goljual.TOTAL-(goljual.TOTAL/1.1)) AS PPN,
					0 AS TOTAL
				FROM goljual
				WHERE MONTH(goljual.TGL_FKTR) = '$bulan'
				AND YEAR(goljual.TGL_FKTR) = '$tahun'
				AND goljual.RETUR = 'T'
				GROUP BY goljual.GOL
			) AS AAA WHERE DPP<>0 AND GOL<>'X' GROUP BY KET, GOL ORDER BY URUT, KET ";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rincianpenjualangolongan()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
		$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
		$per = $setbulan . '/' . $settahun;
		// $q1 = " SELECT jual.INVOICE AS INVOICE,
		// 		jual.TGL_FKTR AS TGL_FKTR,
		// 		jual.KODEC AS KODEC,
		// 		SUM(juald.QTY) AS QTY,
		// 		SUM(juald.QTYP) AS QTYP,
		// 		CASE 
		// 			WHEN juald.GOL = 1 THEN SUM(jual.TOTAL)
		// 		END AS INJECT,
		// 		CASE 
		// 			WHEN juald.GOL = 2 THEN SUM(jual.TOTAL)
		// 		END AS JOGGING,
		// 		CASE 
		// 			WHEN juald.GOL = 3 THEN SUM(jual.TOTAL)
		// 		END AS KARET,
		// 		CASE 
		// 			WHEN juald.GOL = 4 THEN SUM(jual.TOTAL)
		// 		END AS JAPIT,
		// 		CASE 
		// 			WHEN juald.GOL = 5 THEN SUM(jual.TOTAL)
		// 		END AS EVA,
		// 		CASE 
		// 			WHEN juald.GOL = 6 THEN SUM(jual.TOTAL)
		// 		END AS BAHAN,
		// 		CASE 
		// 			WHEN juald.GOL = 7 THEN SUM(jual.TOTAL)
		// 		END AS PVC,
		// 		CASE 
		// 			WHEN juald.GOL = 8 THEN SUM(jual.TOTAL)
		// 		END AS JASA,
		// 		CASE 
		// 			WHEN juald.GOL = 10 THEN SUM(jual.TOTAL)
		// 		END AS SEWA,
		// 		CASE 
		// 			WHEN juald.GOL = 12 THEN SUM(jual.TOTAL)
		// 		END AS APD
		// 	FROM jual, juald
		// 	WHERE jual.NO_BUKTI = juald.NO_BUKTI
		// 	AND jual.PER='$per'
		// 	GROUP BY jual.INVOICE
		// 	ORDER BY jual.INVOICE";
		$q1 = "SELECT TGL_FKTR, INVOICE, KODEC, SUM(QTY) QTY, SUM(QTYP) QTYP, (if(GOL=1,SUM(TOTAL),0)) INJECT, (if(GOL=2,SUM(TOTAL),0)) JOGG_TENNES, 
				(if(GOL=3,SUM(TOTAL),0)) KARET_FPLASTIK, (if(GOL=4,SUM(TOTAL),0)) JAPIT, 
				(if(GOL=5,SUM(TOTAL),0)) EVA_SPON, (if(GOL=6,SUM(TOTAL),0)) APD_MASKER, (if(GOL=7,SUM(TOTAL),0)) PVC_SHEET, (if(GOL=8,SUM(TOTAL),0)) SOL_JPROD, 
				SUM(TOTAL/1.1) DPP, SUM(TOTAL-(TOTAL/1.1)) PPN, SUM(TOTAL) JUMLAH 
				FROM goljual WHERE MONTH(TGL_FKTR)='$setbulan' AND YEAR(TGL_FKTR) = '$settahun' GROUP BY INVOICE  ORDER BY INVOICE";
		return $this->db->query($q1);
	}

	public function tampil_data_penjualan_rincianpenjualanlangganan()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
		$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
		$per = $setbulan . '/' . $settahun;
		$q1 = " SELECT a.NO_BUKTI, a.TGL TANGGAL, a.INVOICE INVOICE, a.TGL TGL_INVOICE, a.NETT, a.KODEC, a.NAMAC
				FROM jual a WHERE  a.PER = '$per' AND a.FLAG = 'JR' ORDER BY KODEC";
		return $this->db->query($q1);
	}

	public function tampil_data_langganan_rincianpenjualanwilayah()
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

	public function tampil_data_langganan_rincianpenjualanpms()
	{
		$perke = $this->input->post('PERKE', TRUE);
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$filter_wilayah = " ";
		if ($this->input->post('WILAYAH_1', TRUE) != '') {
			$filter_wilayah = "AND jual.WILAYAH = '$wilayah_1' ";
		}
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = " SELECT jual.WILAYAH AS WILAYAH, 
				jual.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(jual.TGL,'%d-%m-%Y') AS TGL,
				jual.TOTAL AS BRUTO,
				jual.TDISK AS TDISK,
				jual.NETT AS NETT
			FROM jual
			WHERE MONTH(jual.TGL) = '$bulan'
			AND YEAR(jual.TGL) = '$tahun'
			AND jual.TGL <= '$tgl'
			AND jual.PERKE = '$perke'
			$filter_wilayah
			AND jual.FLAG = 'JR'
			AND jual.PMS = 1
			ORDER BY jual.WILAYAH, jual.NO_BUKTI, jual.NO_BUKTI";
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
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
		$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
		$per = $setbulan . '/' . $settahun;
		$q1 = "SELECT c.KODEC, c.NAMAC, a.NO_BUKTI, a.TGL, b.NO_SURAT,C.TGL_FKTR, c.SISA AS TOTAL, b.TOTAL BAYAR  
				FROM piu a, piud b, jual c
				WHERE a.NO_BUKTI = b.NO_BUKTI AND b.NO_SURAT = c.NO_BUKTI AND a.PER = '$per' 
				ORDER BY KODEC,NO_SURAT";
		return $this->db->query($q1);
	}

	public function tampil_data_pembayaran_nota_wilayah()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$setbulan = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 5, 2);
		$settahun = substr(date("Y-m-d", strtotime($this->input->post('TGL', TRUE))), 0, 4);
		$wilayah = $this->input->post('KDMTS', TRUE);
		$per = $setbulan . '/' . $settahun;
		$q1 = " SELECT c.KODEC, c.NAMAC, a.NO_BUKTI, a.TGL, b.NO_SURAT,C.TGL_FKTR, c.SISA AS TOTAL, b.TOTAL AS BAYAR  
						FROM piu a, piud b, jual c
						WHERE a.NO_BUKTI = b.NO_BUKTI AND b.NO_SURAT = c.NO_BUKTI AND a.PER = '$per' AND a.WILAYAH = '$wilayah'
						ORDER BY a.NO_BUKTI";
		return $this->db->query($q1);
	}

	public function tampil_data_rekap_pembayaran_wilayah()
	{
		$per = $this->input->post('PER', TRUE);
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$q1 = " SELECT WILAYAH KDMTS,KODEC,SUM(TOTAL) AS BAYAR
				FROM piud
				WHERE PER = '$per' AND TANDA='' AND WILAYAH <> ''
				GROUP BY kdmts";
		return $this->db->query($q1);
	}

	public function tampil_data_sisanota()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$jenis = $this->input->post('JENIS', TRUE);
		$q1 = " SELECT jual.KODEC AS KODEC,
				jual.INVOICE AS INVOICE,
				jual.TGL_FKTR AS TGL_FKTR,
				jual.SISA AS SISA,
				jual.NO_BUKTI AS NO_BUKTI
			FROM jual
			WHERE MONTH(jual.TGL_FKTR) = '$bulan'
			AND YEAR(jual.TGL_FKTR) = '$tahun'
			AND jual.TGL_FKTR <= '$tgl'
			AND jual.FLAG = 'JR'
			ORDER BY jual.KODEC, jual.NO_BUKTI";
		return $this->db->query($q1);
	}

	public function tampil_data_sisanotawilayah()
	{
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$jenis = $this->input->post('JENIS', TRUE);
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$filter_wilayah = " ";
		if ($this->input->post('WILAYAH_1', TRUE) != '') {
			$filter_wilayah = "AND jual.WILAYAH = '$wilayah_1' ";
		}
		$q1 = " SELECT jual.WILAYAH AS WILAYAH, 
				jual.KODEC AS KODEC,
				jual.INVOICE AS INVOICE,
				DATE_FORMAT('$tgl','%d-%m-%Y') AS TGL_CETAK,
				DATE_FORMAT(jual.TGL_FKTR,'%d-%m-%Y') AS TGL_FKTR,
				jual.SISA AS SISA,
				jual.NO_BUKTI AS NO_BUKTI
			FROM jual
			WHERE MONTH(jual.TGL_FKTR) = '$bulan'
			AND YEAR(jual.TGL_FKTR) = '$tahun'
			AND jual.TGL_FKTR <= '$tgl'
			AND jual.FLAG = 'JR'
			AND jual.PMS = 1
			$filter_wilayah
			ORDER BY jual.KODEC, jual.TGL_FKTR, jual.NO_BUKTI";
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
		$plh = $this->input->post('PLH', TRUE);

		if ($plh == 1) {
			$q1 = "SELECT '$wilayah_1' PMS, PER, PERKE, SUM(NETT) TOTAL,0 PERIODE_A ,0 PERIODE_B,0 LOKAL ,0 EXPORT FROM pms_surats WHERE PER = '$per' AND WILAYAH = '$wilayah_1' AND POSTED = '1' GROUP BY PERKE";
		} else {
			$q1 = "SELECT '$per' PER, z.*,(z.PERIODE_A + z.PERIODE_B + z.LOKAL + z.EXPORT) TOTAL FROM(
					SELECT a.WILAYAH PMS, COALESCE(b.PERIODE_A,0) PERIODE_A, COALESCE(c.PERIODE_B,0) PERIODE_B, COALESCE(d.LOKAL,0) LOKAL, COALESCE(e.EXPORT,0) EXPORT FROM wilayah a
					LEFT JOIN 
					(SELECT WILAYAH AS PMS, SUM(NETT) PERIODE_A FROM pms_surats WHERE PER = '$per'  AND PERKE = '1' GROUP BY WILAYAH) b
					ON a.WILAYAH = b.PMS
					LEFT JOIN 
					(SELECT WILAYAH AS PMS, SUM(NETT) PERIODE_B FROM pms_surats WHERE PER = '$per'  AND PERKE = '2' GROUP BY WILAYAH) c
					ON a.WILAYAH = c.PMS
					LEFT JOIN 
					(SELECT WILAYAH AS PMS, SUM(NETT) LOKAL FROM jual WHERE PER = '$per' AND NO_BUKTI LIKE '%IDST%' GROUP BY WILAYAH) d
					ON a.WILAYAH = d.PMS
					LEFT JOIN 
					(SELECT WILAYAH AS PMS, SUM(NETT) EXPORT FROM jual WHERE PER = '$per' AND EXPORT = '1' GROUP BY WILAYAH) e
					ON a.WILAYAH = e.PMS) z ORDER BY z.PMS ASC;";
		}
		return $this->db->query($q1);
	}

	public function tampil_data_omzetjenis()
	{
		#A, C, E, G, I
		$per = $this->session->userdata['periode'];
		$q1 = " SELECT pms_surats.PER AS PERIODE, 
				pms_surats.WILAYAH AS WILAYAH,
				0 AS QTY_SPT,
				0 AS QTYP_SPT,
				0 AS TOTAL_SPT,
				0 AS QTY_SDL,
				0 AS QTYP_SDL,
				0 AS TOTAL_SDL,
				CASE 
					WHEN pms_suratsd.GOL='C' THEN SUM(pms_suratsd.QTY)
				ELSE 0
				END AS QTY_PCU,
				CASE 
					WHEN pms_suratsd.GOL='C' THEN SUM(pms_suratsd.QTYP)
				ELSE 0
				END AS QTYP_PCU,
				CASE 
					-- WHEN pms_suratsd.GOL='C' THEN SUM(pms_suratsd.TOTAL/1.1)
					WHEN pms_suratsd.GOL='C' THEN SUM(pms_suratsd.TOTAL)
				ELSE 0
				END AS TOTAL_PCU
			FROM pms_surats, pms_suratsd
			WHERE pms_surats.NO_BUKTI = pms_suratsd.NO_BUKTI 
			AND pms_surats.PER = '$per'
			AND pms_surats.FLAG = 'PMS'
			AND pms_surats.FLAG2 = 'SJ'
			AND pms_surats.MUTASI = 0
			GROUP BY pms_surats.WILAYAH
			ORDER BY pms_surats.WILAYAH, pms_suratsd.GOL";
		return $this->db->query($q1);
	}

	public function tampil_data_suratpesanan()
	{
		$lokal = $this->input->post('LOKAL', TRUE);
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$filter_wilayah = " ";
		if ($this->input->post('WILAYAH_1', TRUE) != '') {
			$filter_wilayah = "AND so.WILAYAH = '$wilayah_1' ";
		}
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = " SELECT so.WILAYAH AS WILAYAH, 
				so.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(so.TGL,'%d-%m-%Y') AS TGL,
				sod.KODEC AS KODEC,
				sod.NAMAC AS NAMAC,
				sod.KD_BRG AS KD_BRG,
				sod.QTY AS QTY,
				sod.QTYP AS QTYP
			FROM so, sod
			WHERE so.NO_BUKTI = sod.NO_BUKTI 
			AND MONTH(so.TGL) = '$bulan'
			AND YEAR(so.TGL) = '$tahun'
			$filter_wilayah
			AND so.FLAG = 'PMS'
			AND so.FLAG2 = 'PJ'
			ORDER BY so.NO_BUKTI, so.NO_BUKTI, sod.REC";
		return $this->db->query($q1);
	}

	public function tampil_data_do()
	{
		$lokal = $this->input->post('LOKAL', TRUE);
		$wilayah_1 = $this->input->post('WILAYAH_1', TRUE);
		$filter_wilayah = " ";
		if ($this->input->post('WILAYAH_1', TRUE) != '') {
			$filter_wilayah = "AND so.WILAYAH = '$wilayah_1' ";
		}
		$tgl = date("Y-m-d", strtotime($this->input->post('TGL', TRUE)));
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		$q1 = " SELECT so.WILAYAH AS WILAYAH, 
				so.NO_BUKTI AS NO_BUKTI,
				DATE_FORMAT(so.TGL,'%d-%m-%Y') AS TGL,
				so.NO_DO AS NO_DO,
				DATE_FORMAT(so.TGL_DO,'%d-%m-%Y') AS TGL_DO,
				sod.KODEC AS KODEC,
				sod.NAMAC AS NAMAC,
				sod.KD_BRG AS KD_BRG,
				sod.QTY AS QTY,
				sod.QTYP AS QTYP
			FROM so, sod
			WHERE so.NO_BUKTI = sod.NO_BUKTI 
			AND MONTH(so.TGL_DO) = '$bulan'
			AND YEAR(so.TGL_DO) = '$tahun'
			$filter_wilayah
			AND so.FLAG = 'PMS'
			AND so.FLAG2 = 'PJ'
			ORDER BY so.NO_DO, so.NO_BUKTI, sod.REC";
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

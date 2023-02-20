<?php
foreach ($surat_jalan as $rowh) {
};
?>

<style>
	#myInput {
		background-image: url('<?php echo base_url() ?>assets/img/search-icon-blue.png');
		background-position: 10px 12px;
		background-repeat: no-repeat;
		width: 100%;
		font-size: 14px;
		padding: 12px 20px 12px 40px;
		border: 1px solid #ddd;
		margin-bottom: 12px;
	}

	#myTable {
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #ddd;
		font-size: 14px;
	}

	#myTable th,
	#myTable td {
		text-align: left;
		padding: 5px;
	}

	#myTable tr {
		border-bottom: 1px solid #ddd;
	}

	#myTable tr.header,
	#myTable tr:hover {
		background-color: #f1f1f1;
	}

	input[type=text]:focus {
		width: 100%;
	}

	table {
		table-layout: fixed;
	}

	table th {
		color: black;
		text-align: center;
	}

	table td {
		overflow: hidden;
	}

	.label {
		color: black;
		font-weight: bold;
	}

	.rightJustified {
		text-align: right;
	}

	.total {
		font-size: 14px;
		font-weight: bold;
		color: blue;
	}

	.bodycontainer {
		/* width: 1000px; */
		max-height: 500px;
		margin: 0;
		overflow-y: auto;
	}

	#datatable td {
		padding: 2px !important;
		vertical-align: middle;
	}

	.table-scrollable {
		margin: 0;
		padding: 0;
	}

	.modal-bodys {
		max-height: 250px;
		overflow-y: auto;
	}

	.select2-dropdown {
		width: 500px !important;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksisuratjalan" name="transaksisuratjalan" action="<?php echo base_url('admin/Transaksi_Surat_Jalan/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="col-md-2">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value="<?php echo $rowh->NO_BUKTI ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tanggal </label>
						</div>
						<div class="col-md-2">
							<input type="text" class="date form-control TGL" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL, TRUE)); ?>" onclick="select()">
						</div>
						<div class="col-md-1">
							<label class="label">No Kendaraan </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NOPOL" id="NOPOL" name="NOPOL" type="text" value="<?php echo $rowh->NOPOL ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Pkp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input PKP" id="PKP" name="PKP" type="text" value="<?php echo $rowh->PKP ?>">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2 input-group">
							<input name="NAMAC" id="NAMAC" maxlength="30" type="text" class="form-control NAMAC text_input" onkeypress="return tabE(this,event)" value="<?php echo $rowh->NAMAC ?>" placeholder="Nama Customer" readonly>
							<span class="input-group-btn">
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_no_so" data-toggle="modal" href="#lupno_so"><i class="fa fa-search"></i></a>
							</span>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input KODERAY" id="KODERAY" name="KODERAY" type="text" value="<?php echo $rowh->KODERAY ?>" placeholder="Koderayon" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KODEC" id="KODEC" name="KODEC" type="text" value="<?php echo $rowh->KODEC ?>" placeholder="Kode Customer" readonly>
						</div>
						<div class="col-md-1">
							<label class="label"> </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KOTA" id="KOTA" name="KOTA" type="text" value="<?php echo $rowh->KOTA ?>" placeholder="Kota" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_SP" id="NO_SP" name="NO_SP" type="text" value="<?php echo $rowh->NO_SP ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">No Do </label>
						</div>
						<div class="col-md-2 input-group">
							<input class="form-control text_input NO_DO" id="NO_DO" name="NO_DO" type="text" value="<?php echo $rowh->NO_DO ?>" readonly>
							<input class="form-control text_input TGL_DO" id="TGL_DO" name="TGL_DO" type="hidden" value="<?php echo $rowh->TGL_DO ?>" readonly>
							<input class="form-control text_input TGL_SO" id="TGL_SO" name="TGL_SO" type="hidden" value="<?php echo $rowh->TGL_SO ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Max Kredit </label>
						</div>
						<div class="col-md-2">
							<input class="form-control MAXKRE rightJustified text-primary font-weight-bold" id="MAXKRE" name="MAXKRE" type="text" value="<?php echo $rowh->MAXKRE ?>" onclick="select()" onkeyup="hitung()" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Piutang </label>
						</div>
						<div class="col-md-2">
							<input class="form-control PIU rightJustified text-primary font-weight-bold" id="PIU" name="PIU" type="text" value="<?php echo $rowh->PIU ?>" onclick="select()" onkeyup="hitung()" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Sisa BMPKP </label>
						</div>
						<div class="col-md-2">
							<input class="form-control BMPKP rightJustified text-primary font-weight-bold" id="BMPKP" name="BMPKP" type="text" value="<?php echo $rowh->BMPKP ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Exp Piutang </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input EXP_PIU" id="EXP_PIU" name="EXP_PIU" type="text" value="<?php echo $rowh->EXP_PIU ?>" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive scrollable">
					<table id="datatable" class="table table-hoverx table-stripedx table-borderedx table-condensed table-scrollable">
						<thead>
							<tr>
								<th width="50px">No</th>
								<th width="150px">Barang</th>
								<th width="120px">Warna</th>
								<th width="100px">Size</th>
								<th width="100px">Golongan</th>
								<th width="120px">Lusin</th>
								<th width="120px">Pair</th>
								<th width="120px">Harga</th>
								<th width="100px">Disc 1</th>
								<th width="100px">Disc 0</th>
								<th width="100px">Disc 3</th>
								<th width="100px">Disc 4</th>
								<th width="100px">Disc Rp</th>
								<th width="100px">T Disc</th>
								<th width="120px">Jumlah</th>
								<th width="1px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($surat_jalan as $row) :
							?>
								<tr>
									<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
									<td><input name="KD_BRG[]" id="KD_BRG<?php echo $no; ?>" value="<?= $row->KD_BRG ?>" type="text" class="form-control KD_BRG" readonly></td>
									<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA" readonly></td>
									<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE" readonly></td>
									<td><input name="GOL[]" id="GOL<?php echo $no; ?>" value="<?= $row->GOL ?>" type="text" class="form-control GOL" maxlength="1" readonly></td>
									<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" id="QTY<?php echo $no; ?>" value="<?php echo number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary"></td>
									<td><input name="QTYP[]" onclick="select()" onkeyup="hitung()" id="QTYP<?php echo $no; ?>" value="<?php echo number_format($row->QTYP, 2, '.', ','); ?>" type="text" class="form-control QTYP rightJustified text-primary"></td>
									<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary"></td>
									<td><input name="DISC1[]" onclick="select()" onkeyup="hitung()" id="DISC1<?php echo $no; ?>" value="<?php echo number_format($row->DISC1, 2, '.', ','); ?>" type="text" class="form-control DISC1 rightJustified text-danger"></td>
									<td><input name="DISC2[]" onclick="select()" onkeyup="hitung()" id="DISC2<?php echo $no; ?>" value="<?php echo number_format($row->DISC2, 2, '.', ','); ?>" type="text" class="form-control DISC2 rightJustified text-danger"></td>
									<td><input name="DISC3[]" onclick="select()" onkeyup="hitung()" id="DISC3<?php echo $no; ?>" value="<?php echo number_format($row->DISC3, 2, '.', ','); ?>" type="text" class="form-control DISC3 rightJustified text-danger"></td>
									<td><input name="DISC4[]" onclick="select()" onkeyup="hitung()" id="DISC4<?php echo $no; ?>" value="<?php echo number_format($row->DISC4, 2, '.', ','); ?>" type="text" class="form-control DISC4 rightJustified text-danger"></td>
									<td><input name="DISCRP[]" onclick="select()" onkeyup="hitung()" id="DISCRP<?php echo $no; ?>" value="<?php echo number_format($row->DISCRP, 2, '.', ','); ?>" type="text" class="form-control DISCRP rightJustified text-danger"></td>
									<td><input name="DISC[]" onclick="select()" onkeyup="hitung()" id="DISC<?php echo $no; ?>" value="<?php echo number_format($row->DISC, 2, '.', ','); ?>" type="text" class="form-control DISC rightJustified text-danger" readonly></td>
									<td><input name="TOTAL[]" onkeyup="hitung()" id="TOTAL<?php echo $no; ?>" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
									<td><input name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden">
									<td>
								</tr>
								<?php $no++; ?>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TQTY rightJustified text-primary font-weight-bold" id="TQTY" name="TQTY" value="<?php echo number_format($row->TQTY, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TQTYP rightJustified text-primary font-weight-bold" id="TQTYP" name="TQTYP" value="<?php echo number_format($row->TQTYP, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<br><br>
		<!--tab-->
		<!-- <div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div> -->
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Stand </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control STAND rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->STAND, 2, '.', ','); ?>" id="STAND" name="STAND" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Pembulatan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BULAT rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->BULAT, 2, '.', ','); ?>" id="BULAT" name="BULAT" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Sub Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TTOTAL rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->TTOTAL, 2, '.', ','); ?>" id="TTOTAL" name="TTOTAL" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Jenis </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control JENIS rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->JENIS, 2, '.', ','); ?>" id="JENIS" name="JENIS" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Kontan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control KONTAN rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->KONTAN, 2, '.', ','); ?>" id="KONTAN" name="KONTAN" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Disc Rp </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TDISC rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($row->TDISC, 2, '.', ','); ?>" id="TDISC" name="TDISC" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Bs </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BS rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->BS, 2, '.', ','); ?>" id="BS" name="BS" readonly>
				</div>
				<div class="col-md-2" style="text-align: right;">
					<label class="label">Perubahan Harga </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control PRB_HRG rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->PRB_HRG, 2, '.', ','); ?>" id="PRB_HRG" name="PRB_HRG" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Nett </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control NETT rightJustified text-success font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->NETT, 2, '.', ','); ?>" id="NETT" name="NETT" readonly>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group cxx">
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
						<a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
					</div>
					<h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- myModal No Sp-->
<div id="mymodal_no_sp" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data Penerimaan Barang</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_no_so'>
					<thead>
						<th>No Bukti</th>
						<th>Tanggal</th>
						<th>No DO</th>
						<th>Total Lusin</th>
						<th>Kode Customer</th>
						<th>Nama Customer</th>
						<th>Kode Rayon</th>
						<th>Kota</th>
						<th>PKP</th>
						<th>Max Kredit</th>
						<th>Piutang</th>
						<th>Exp Piutang</th>
					</thead>
					<tbody>
						<?php
						// $per = $this->session->userdata['periode'];
						$kdmts = $this->session->userdata['kdmts'];
						$sql = "SELECT so.NO_BUKTI AS NO_SP, 
								so.TGL AS TGL_SO, 
								so.NO_DO AS NO_DO, 
								so.TGL_DO AS TGL_DO,
								so.TOTAL_QTY AS TOTAL_QTY,
								so.TOTAL_QTYP AS TOTAL_QTYP,
								sod.KODEC AS KODEC,
								sod.NAMAC AS NAMAC,
								sod.PKP AS PKP,
								sod.KOTA AS KOTA,
								sod.MAXKRE AS MAXKRE,
								sod.KODERAY AS KODERAY,
								sod.PIU AS PIU,
								sod.EXP_PIU AS EXP_PIU
							FROM so, sod
							WHERE so.NO_BUKTI=sod.NO_BUKTI
							AND so.WILAYAH = '$kdmts'
							AND so.REQ_DO = 2
							GROUP BY so.NO_BUKTI
							ORDER BY so.NO_BUKTI";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='NSSVAL'><a href="#" class="select_no_so"><?php echo $b->NO_SP; ?></td>
								<td class='TSSVAL text_input'><?php echo $b->TGL_SO; ?></a></td>
								<td class='NDSVAL text_input'><?php echo $b->NO_DO; ?></td>
								<td class='TQSVAL text_input'><?php echo $b->TOTAL_QTY; ?></td>
								<td class='KDSVAL text_input'><?php echo $b->KODEC; ?></td>
								<td class='NMSVAL text_input'><?php echo $b->NAMAC; ?></td>
								<td class='KRSVAL text_input'><?php echo $b->KODERAY; ?></td>
								<td class='KTSVAL text_input'><?php echo $b->KOTA; ?></td>
								<td class='PKSVAL text_input'><?php echo $b->PKP; ?></td>
								<td class='MKSVAL text_input'><?php echo $b->MAXKRE; ?></td>
								<td class='PISVAL text_input'><?php echo $b->PIU; ?></td>
								<td class='EPSVAL text_input'><?php echo $b->EXP_PIU; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#modal_no_sp').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {
			$('input[type=search]').val('').keyup(); // this line and next one clear the search dialog
		});
		$('#modal_nodo').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {
			$('input[type=search]').val('').keyup(); // this line and next one clear the search dialog
		});
	});
</script>

<script>
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			// gawe cek validasi/ centang2
			var forms = document.getElementsByClassName('needs-validation');
			// 
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
					} else {
						$(this).submit(function() {
							return false;
						});
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();
	var target;
	var idrow = <?php echo $no ?>;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#MAXKRE").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#SPIU").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TQTY").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TQTYP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#STAND").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#BULAT").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#JENIS").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#KONTAN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#BS").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#PRB_HRG").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TTOTAL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TDISC").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#NETT").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#QTYP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARGA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC2" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC3" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC4" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISCRP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TOTAL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		//MyModal No Sp
		$('#mymodal_no_sp').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_no_sp', function() {
			var val = $(this).parents("tr").find(".NSJVAL").text();
			target.parents("div").find(".NO_SP").val(val);
			$('#mymodal_no_sp').modal('toggle');
		});
		//MyModal No Do
		$('#mymodal_nodo').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_nodo', function() {
			var val = $(this).parents("tr").find(".TSJVAL").text();
			target.parents("div").find(".TGL_SP").val(val);
			var val = $(this).parents("tr").find(".NDJVAL").text();
			target.parents("div").find(".NODO").val(val);
			var val = $(this).parents("tr").find(".TDJVAL").text();
			target.parents("div").find(".TGLDO").val(val);
			var val = $(this).parents("tr").find(".TLJVAL").text();
			target.parents("div").find(".TQTY").val(val);
			var val = $(this).parents("tr").find(".TPJVAL").text();
			target.parents("div").find(".TQTYP").val(val);
			$('#mymodal_nodo').modal('toggle');
			var nodo = $(this).parents("tr").find(".NDJVAL").text();
			$.ajax({
				type: 'get',
				url: '<?php echo base_url('index.php/admin/Transaksi_Surat_Jalan/filter_nodo'); ?>',
				data: {
					nodo: nodo
				},
				dataType: 'json',
				success: function(response) {
					// alert(response);
					var html = '';
					var i;
					for (i = 0; i < response.length; i++) {
						html += '<tr>' +
							'<td><input name="REC[]" id=REC' + i + ' type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly value=' + (i + 1) + ' ></td>' +
							'<td><input name="KD_BRG[]" id=KD_BRG' + i + ' type="text" class="form-control KD_BRG" value="' + response[i].KD_BRG + '" readonly></td>' +
							'<td><input name="WARNA[]" id=WARNA' + i + ' type="text" class="form-control WARNA" value="' + response[i].WARNA + '" readonly></td>' +
							'<td><input name="SIZE[]" id=SIZE' + i + ' type="text" class="form-control SIZE" value="' + response[i].SIZE + '" readonly></td>' +
							'<td><input name="GOL[]" id=GOL' + i + ' type="text" class="form-control GOL" value="' + response[i].GOL + '" readonly></td>' +
							'<td><input name="QTY[]" id=QTY' + i + ' type="text" class="form-control QTY rightJustified text-primary" value="' + numberWithCommas(response[i].QTY) + '" readonly></td>' +
							'<td><input name="QTYP[]" id=QTYP' + i + ' type="text" class="form-control QTYP rightJustified text-primary" value="' + numberWithCommas(response[i].QTYP) + '" readonly></td>' +
							'<td><input name="HARGA[]" id=HARGA' + i + ' type="text" class="form-control HARGA rightJustified text-primary" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC1[]" id=DISC1' + i + ' type="text" class="form-control DISC1 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC2[]" id=DISC2' + i + ' type="text" class="form-control DISC2 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC3[]" id=DISC3' + i + ' type="text" class="form-control DISC3 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC4[]" id=DISC4' + i + ' type="text" class="form-control DISC4 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISCRP[]" id=DISCRP' + i + ' type="text" class="form-control DISCRP rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC[]" id=DISC' + i + ' type="text" class="form-control DISC rightJustified text-danger" value="0" readonly ></td>' +
							'<td><input name="TOTAL[]" id=TOTAL' + i + ' type="text" class="form-control TOTAL rightJustified text-primary" value="0" readonly></td>' +
							'</tr>';
					}
					idrow = i;
					$('#show-data').html(html);
					jumlahdata = 100;
					for (i = 0; i <= jumlahdata; i++) {
						$("#QTY" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#QTYP" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#HARGA" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#DISC1" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#DISC2" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#DISC3" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#DISC4" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#DISCRP" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#DISC" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#TOTAL" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
					}
				}
			});
		});
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
	});

	function nomor() {
		var i = 1;
		$(".REC").each(function() {
			$(this).val(i++);
		});
		hitung();
	}

	function hitung() {
		var TQTY = 0;
		var TQTYP = 0;
		var TTOTAL = 0;
		var TDISC = 0;
		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var lusin = parseFloat($('#QTY' + i).val().replace(/,/g, ''));
			var pair = parseFloat($('#QTYP' + i).val().replace(/,/g, ''));
			var harga = parseFloat($('#HARGA' + i).val().replace(/,/g, ''));
			var disc1 = parseFloat($('#DISC1' + i).val().replace(/,/g, ''));
			var disc2 = parseFloat($('#DISC2' + i).val().replace(/,/g, ''));
			var disc3 = parseFloat($('#DISC3' + i).val().replace(/,/g, ''));
			var disc4 = parseFloat($('#DISC4' + i).val().replace(/,/g, ''));
			var discrp = parseFloat($('#DISCRP' + i).val().replace(/,/g, ''));

			var disc = disc1 + disc2 + disc3 + disc4 + discrp;
			if (isNaN(disc)) disc = 0;
			$('#DISC' + i).val(numberWithCommas(disc));
			$('#DISC' + i).autoNumeric('update');

			var jumlah = (lusin + pair) * harga - disc;
			if (isNaN(jumlah)) jumlah = 0;
			$('#TOTAL' + i).val(numberWithCommas(jumlah));
			$('#TOTAL' + i).autoNumeric('update');
		};
		$(".QTY").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TQTY += val;
		});
		$(".QTYP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TQTYP += val;
		});
		$(".DISC").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TDISC += val;
		});
		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TTOTAL += val;
		});

		var NETT = TTOTAL;

		if (isNaN(TQTY)) TQTY = 0;
		if (isNaN(TQTYP)) TQTYP = 0;
		if (isNaN(TDISC)) TDISC = 0;
		if (isNaN(TTOTAL)) TTOTAL = 0;
		if (isNaN(NETT)) NETT = 0;

		$('#TQTY').val(numberWithCommas(TQTY));
		$('#TQTYP').val(numberWithCommas(TQTYP));
		$('#TDISC').val(numberWithCommas(TDISC));
		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$('#NETT').val(numberWithCommas(NETT));

		$("#TQTY").autoNumeric('update');
		$('#TQTYP').autoNumeric('update');
		$('#TDISC').autoNumeric('update');
		$('#TTOTAL').autoNumeric('update');
		$('#NETT').autoNumeric('update');
	}

	function tambah() {}

	function hapus() {}
</script>

<script>
	$(document).ready(function() {
		select_kodecus();
	});

	function select_kodecus() {
		$('.js-example-responsive-kodecus').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_Surat_Jalan/getDataAjax_Customer') ?>",
				dataType: "json",
				type: "post",
				delay: 10,
				data: function(params) {
					return {
						search: params.term,
						page: params.page
					}
				},
				processResults: function(data, params) {
					params.page = params.page || 1;
					return {
						results: data.items,
						pagination: {
							more: data.total_count
						}
					};
				},
				cache: true
			},
			placeholder: 'Pilih Customer',
			minimumInputLength: 0,
			templateResult: format_kodecus,
			templateSelection: formatSelection_kodecus
		});
	}

	function format_kodecus(repo_kodecus) {
		if (repo_kodecus.loading) {
			return repo_kodecus.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_kodecus.kodecus);
		return $container;
	}
	var nama = '';
	var kota = '';
	var koderay = '';

	function formatSelection_kodecus(repo_kodecus) {
		nama = repo_kodecus.nama;
		kota = repo_kodecus.kota;
		koderay = repo_kodecus.koderay;
		return repo_kodecus.text;
	}

	function kodecus(x) {
		var q = x.substring(7, 9);
		$('#NAMA' + q).val(nama);
		$('#KOTA' + q).val(kota);
		$('#KODERAY' + q).val(koderay);
	}
</script>
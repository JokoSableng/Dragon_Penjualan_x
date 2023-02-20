<?php
foreach ($penjualanpms as $rowh) {
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

	.text_input {
		font-size: small;
		color: black;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="penjualanpms" name="penjualanpms" action="<?php echo base_url('admin/Transaksi_PenjualanPMS/update_aksi'); ?>" class="form-horizontal" method="post">
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="input-group col-md-2">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value="<?php echo $rowh->NO_BUKTI ?>" readonly>
						</div>
						<div class="col-md-2 input-group">
							<input class="form-control text_input NO_CET" id="NO_CET" name="NO_CET" type="text" value="<?php echo $rowh->NO_CET ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">No Order </label>
						</div>
						<div class="col-md-2 input-group">
							<input class="form-control text_input" id="" name="" type="text" value="" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl SJ </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input TGL" id="TGL" name="TGL" type="text" value="<?php echo date('d-m-Y', strtotime($rowh->TGL, TRUE)); ?>" readonly>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
							<label class="form-check-label" for="flexCheckDefault">
								Bonus
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Faktur </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_FKTR" id="NO_FKTR" name="NO_FKTR" type="text" value="<?php echo $rowh->NO_FKTR ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Kode Fak </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KD_FKTR" id="KD_FKTR" name="KD_FKTR" type="text" value="<?php echo $rowh->KD_FKTR ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Harga Baru </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input HRG_BR" id="HRG_BR" name="HRG_BR" type="text" value="<?php echo $rowh->HRG_BR ?>">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Invoice </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input INVOICE" id="INVOICE" name="INVOICE" type="text" value="<?php echo $rowh->INVOICE ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Tgl Fak </label>
						</div>
						<div class="col-md-2">
							<input type="text" class="date form-control text_input" id="TGL_FKTR" name="TGL_FKTR" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_FKTR, TRUE)); ?>" onclick="select()">
						</div>
						<div class="col-md-1">
							<label class="label">No DO </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_SO" id="NO_SO" name="NO_SO" type="text" value="<?php echo $rowh->NO_SO ?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KODEC" id="KODEC" name="KODEC" type="text" value="<?php echo $rowh->KODEC ?>" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NAMAC" id="NAMAC" name="NAMAC" type="text" value="<?php echo $rowh->NAMAC ?>" readonly>
						</div>
						<div class="col-md-0">
							<label class="label">PKP </label>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input PKP" id="PKP" name="PKP" type="text" value="">
						</div>
						<div class="col-md-5">
							<input class="form-control text_input ALAMAT" id="ALAMAT" name="ALAMAT" type="text" value="<?php echo $rowh->ALAMAT ?>">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Kode Area </label>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input WILAYAH" id="WILAYAH" name="WILAYAH" type="text" value="<?php echo $rowh->WILAYAH ?>" readonly>
						</div>
						<div class="col-md-3">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value="<?php echo $rowh->NOTES ?>">
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<input class="form-control text_input KOTA" id="KOTA" name="KOTA" type="text" value="<?php echo $rowh->KOTA ?>">
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
								<th width="150px">Article</th>
								<th width="150px">Uraian</th>
								<th width="75px">Lusin</th>
								<th width="75px">Pair</th>
								<th width="100px">Harga</th>
								<th width="100px">Harga Pair</th>
								<th width="75px">Disc1</th>
								<th width="75px">Disc2</th>
								<th width="75px">Disc3</th>
								<th width="75px">Disc4</th>
								<th width="75px">Disc Rp</th>
								<th width="75px">T Disc</th>
								<th width="150px">Jumlah</th>
								<th width="1px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($penjualanpms as $row) :
							?>
								<tr>
									<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
									<td><input name="KD_BRG[]" id="KD_BRG<?php echo $no; ?>" value="<?= $row->KD_BRG ?>" type="text" class="form-control KD_BRG text_input" readonly></td>
									<td><input name="NA_BRG[]" id="NA_BRG<?php echo $no; ?>" value="<?= $row->NA_BRG ?>" type="text" class="form-control NA_BRG text_input" readonly></td>
									<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" id="QTY<?php echo $no; ?>" value="<?php echo number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary" readonly></td>
									<td><input name="QTYP[]" onclick="select()" onkeyup="hitung()" id="QTYP<?php echo $no; ?>" value="<?php echo number_format($row->QTYP, 2, '.', ','); ?>" type="text" class="form-control QTYP rightJustified text-primary"></td>
									<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary" readonly></td>
									<td><input name="HARGAP[]" onclick="select()" onkeyup="hitung()" id="HARGAP<?php echo $no; ?>" value="<?php echo number_format($row->HARGAP, 2, '.', ','); ?>" type="text" class="form-control HARGAP rightJustified text-primary"></td>
									<td><input name="DISC1[]" onclick="select()" onkeyup="hitung()" id="DISC1<?php echo $no; ?>" value="<?php echo number_format($row->DISC1, 2, '.', ','); ?>" type="text" class="form-control DISC1 rightJustified text-danger" readonly></td>
									<td><input name="DISC2[]" onclick="select()" onkeyup="hitung()" id="DISC2<?php echo $no; ?>" value="<?php echo number_format($row->DISC2, 2, '.', ','); ?>" type="text" class="form-control DISC2 rightJustified text-danger" readonly></td>
									<td><input name="DISC3[]" onclick="select()" onkeyup="hitung()" id="DISC3<?php echo $no; ?>" value="<?php echo number_format($row->DISC3, 2, '.', ','); ?>" type="text" class="form-control DISC3 rightJustified text-danger" readonly></td>
									<td><input name="DISC4[]" onclick="select()" onkeyup="hitung()" id="DISC4<?php echo $no; ?>" value="<?php echo number_format($row->DISC4, 2, '.', ','); ?>" type="text" class="form-control DISC4 rightJustified text-danger" readonly></td>
									<td><input name="DISCRP[]" onclick="select()" onkeyup="hitung()" id="DISCRP<?php echo $no; ?>" value="<?php echo number_format($row->DISCRP, 2, '.', ','); ?>" type="text" class="form-control DISCRP rightJustified text-danger" readonly></td>
									<td><input name="DISC[]" onclick="select()" onkeyup="hitung()" id="DISC<?php echo $no; ?>" value="<?php echo number_format($row->DISC, 2, '.', ','); ?>" type="text" class="form-control DISC rightJustified text-danger" readonly></td>
									<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" id="TOTAL<?php echo $no; ?>" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
									<td>
										<input name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden">
										<button style="visibility: hidden;" type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
											<i class="fa fa-fw fa-trash"></i>
										</button>
									</td>
								</tr>
								<?php $no++; ?>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TOTAL_QTY rightJustified text-primary font-weight-bold" id="TOTAL_QTY" name="TOTAL_QTY" value="<?php echo number_format($rowh->TOTAL_QTY, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TOTAL_QTYP rightJustified text-primary font-weight-bold" id="TOTAL_QTYP" name="TOTAL_QTYP" value="<?php echo number_format($rowh->TOTAL_QTYP, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TTOTAL rightJustified text-primary font-weight-bold" id="TTOTAL" name="TTOTAL" value="<?php echo number_format($rowh->TTOTAL, 2, '.', ','); ?>" readonly></td>
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
					<input class="form-control STAND rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->STAND, 2, '.', ','); ?>" id="STAND" name="STAND" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Pembulatan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BULAT rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->BULAT, 2, '.', ','); ?>" id="BULAT" name="BULAT" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Sub Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TTOTAL rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->TTOTAL, 2, '.', ','); ?>" id="TTOTAL" name="TTOTAL" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Jum </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DPP rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->DPP, 2, '.', ','); ?>" id="DPP" name="DPP" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Jenis </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DISC3_HEADER rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->DISC3_HEADER, 2, '.', ','); ?>" id="DISC3_HEADER" name="DISC3_HEADER" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Kontan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DISC2_HEADER rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->DISC2_HEADER, 2, '.', ','); ?>" id="DISC2_HEADER" name="DISC2_HEADER" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Disc RP </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TDISK rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($rowh->TDISK, 2, '.', ','); ?>" id="TDISK" name="TDISK" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Pot </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DPPTDISK rightJustified text-primary font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($rowh->DPPTDISK, 2, '.', ','); ?>" id="DPPTDISK" name="DPPTDISK" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Bb </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BB rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->BB, 2, '.', ','); ?>" id="BB" name="BB" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Ob </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control OB rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->OB, 2, '.', ','); ?>" id="OB" name="OB" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Netto </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control NETT rightJustified text-success font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->NETT, 2, '.', ','); ?>" id="NETT" name="NETT" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Dpp </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DPP1 rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->DPP1, 2, '.', ','); ?>" id="DPP1" name="DPP1" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Bs </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DISC7_HEADER rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->DISC7_HEADER, 2, '.', ','); ?>" id="DISC7_HEADER" name="DISC7_HEADER" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Perubahan Harga </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DISC6_HEADER rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->DISC6_HEADER, 2, '.', ','); ?>" id="DISC6_HEADER" name="DISC6_HEADER" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">PPN </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control PPN rightJustified text-danger font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->PPN, 2, '.', ','); ?>" id="PPN" name="PPN" readonly>
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


<!-- myModal No SJ-->
<div id="mymodal_no_surat" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data SJ</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_no_surat'>
					<thead>
						<th>No SJ</th>
						<th>Tgl SJ</th>
						<th>No SO</th>
						<th>Kodec</th>
						<th>Namac</th>
						<th>Wilayah</th>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT NO_BUKTI AS NO_SURAT, 
								TGL AS TGL_SJ, 
								NO_SO AS NO_SO, 
								KODEC AS KODEC,
								NAMAC AS NAMAC,
								WILAYAH AS WILAYAH
							FROM surats
							WHERE JUAL = 0
							AND WILAYAH = 94
							ORDER BY NO_BUKTI DESC";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='NSSVAL'><a href="#" class="select_no_surat"><?php echo $b->NO_SURAT; ?></a></td>
								<td class='TSSVAL text_input'><?php echo $b->TGL_SJ; ?></td>
								<td class='NOSVAL text_input'><?php echo $b->NO_SO; ?></td>
								<td class='KOSVAL text_input'><?php echo $b->KODEC; ?></td>
								<td class='NASVAL text_input'><?php echo $b->NAMAC; ?></td>
								<td class='WLSVAL text_input'><?php echo $b->WILAYAH; ?></td>
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
		$('#modal_no_surat').DataTable({
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
		$("#TOTAL_QTY").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TOTAL_QTYP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TTOTAL").autoNumeric('init', {
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
		$("#DPP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DISC3_HEADER").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DISC2_HEADER").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TDISK").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DPPTDISK").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DISC7_HEADER").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DISC6_HEADER").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#PPN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#BB").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#OB").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#NETT").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DPP1").autoNumeric('init', {
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
			$("#HARGAP" + i.toString()).autoNumeric('init', {
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
		//MyModal SJ
		$('#mymodal_no_sj').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_no_sj', function() {
			var val = $(this).parents("tr").find(".NSSVAL").text();
			target.parents("div").find(".NO_CET").val(val);
			var val = $(this).parents("tr").find(".TSSVAL").text();
			target.parents("div").find(".TGL").val(val);
			var val = $(this).parents("tr").find(".NOSVAL").text();
			target.parents("div").find(".NO_SO").val(val);
			var val = $(this).parents("tr").find(".KOSVAL").text();
			target.parents("div").find(".KODEC").val(val);
			var val = $(this).parents("tr").find(".NASVAL").text();
			target.parents("div").find(".NAMAC").val(val);
			var val = $(this).parents("tr").find(".WLSVAL").text();
			target.parents("div").find(".WILAYAH").val(val);
			$('#mymodal_no_sj').modal('toggle');
		});
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
		$('input[type="checkbox"]').on('change', function() {
			this.value ^= 1;
			console.log(this.value)
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
		var TOTAL_QTY = 0;
		var TOTAL_QTYP = 0;
		var TTOTAL = 0;
		var STAND = parseFloat($('#STAND').val().replace(/,/g, ''));
		var BULAT = parseFloat($('#BULAT').val().replace(/,/g, ''));
		var DPP = parseFloat($('#DPP').val().replace(/,/g, ''));
		var DISC3_HEADER = parseFloat($('#DISC3_HEADER').val().replace(/,/g, ''));
		var DISC2_HEADER = parseFloat($('#DISC2_HEADER').val().replace(/,/g, ''));
		var TDISK = parseFloat($('#TDISK').val().replace(/,/g, ''));
		var DPPTDISK = parseFloat($('#DPPTDISK').val().replace(/,/g, ''));
		var DISC7_HEADER = parseFloat($('#DISC7_HEADER').val().replace(/,/g, ''));
		var DISC6_HEADER = parseFloat($('#DISC6_HEADER').val().replace(/,/g, ''));
		var PPN = parseFloat($('#PPN').val().replace(/,/g, ''));
		var BB = parseFloat($('#BB').val().replace(/,/g, ''));
		var OB = parseFloat($('#OB').val().replace(/,/g, ''));
		var NETT = parseFloat($('#NETT').val().replace(/,/g, ''));
		var DPP1 = parseFloat($('#DPP1').val().replace(/,/g, ''));

		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var qty = parseFloat($('#QTY' + i).val().replace(/,/g, ''));
			var qtyp = parseFloat($('#QTYP' + i).val().replace(/,/g, ''));
			var harga = parseFloat($('#HARGA' + i).val().replace(/,/g, ''));
			var hargap = parseFloat($('#HARGAP' + i).val().replace(/,/g, ''));

			// var qtyp = qty * 12;
			// if (isNaN(qtyp)) qtyp = 0;
			// $('#QTYP' + i).val(numberWithCommas(qtyp));
			// $('#QTYP' + i).autoNumeric('update');

			// var hargap = harga * 12;
			// if (isNaN(hargap)) hargap = 0;
			// $('#HARGAP' + i).val(numberWithCommas(hargap));
			// $('#HARGAP' + i).autoNumeric('update');

			var total = (qty * harga) + (qtyp * hargap);
			if (isNaN(total)) total = 0;
			$('#TOTAL' + i).val(numberWithCommas(total));
			$('#TOTAL' + i).autoNumeric('update');
		};

		$(".QTY").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TOTAL_QTY += val;
		});
		$(".QTYP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TOTAL_QTYP += val;
		});
		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TTOTAL += val;
		});

		NETT = TTOTAL - PPN;

		if (isNaN(TOTAL_QTY)) TOTAL_QTY = 0;
		if (isNaN(TOTAL_QTYP)) TOTAL_QTYP = 0;
		if (isNaN(TTOTAL)) TTOTAL = 0;
		if (isNaN(STAND)) STAND = 0;
		if (isNaN(BULAT)) BULAT = 0;
		if (isNaN(DPP)) DPP = 0;
		if (isNaN(DISC3_HEADER)) DISC3_HEADER = 0;
		if (isNaN(DISC2_HEADER)) DISC2_HEADER = 0;
		if (isNaN(TDISK)) TDISK = 0;
		if (isNaN(DPPTDISK)) DPPTDISK = 0;
		if (isNaN(DISC7_HEADER)) DISC7_HEADER = 0;
		if (isNaN(DISC6_HEADER)) DISC6_HEADER = 0;
		if (isNaN(PPN)) PPN = 0;
		if (isNaN(BB)) BB = 0;
		if (isNaN(OB)) OB = 0;
		if (isNaN(NETT)) NETT = 0;
		if (isNaN(DPP1)) DPP1 = 0;

		$('#TOTAL_QTY').val(numberWithCommas(TOTAL_QTY));
		$('#TOTAL_QTYP').val(numberWithCommas(TOTAL_QTYP));
		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$('#STAND').val(numberWithCommas(STAND));
		$('#BULAT').val(numberWithCommas(BULAT));
		$('#DPP').val(numberWithCommas(DPP));
		$('#DISC3_HEADER').val(numberWithCommas(DISC3_HEADER));
		$('#DISC2_HEADER').val(numberWithCommas(DISC2_HEADER));
		$('#TDISK').val(numberWithCommas(TDISK));
		$('#DPPTDISK').val(numberWithCommas(DPPTDISK));
		$('#DISC7_HEADER').val(numberWithCommas(DISC7_HEADER));
		$('#DISC6_HEADER').val(numberWithCommas(DISC6_HEADER));
		$('#PPN').val(numberWithCommas(PPN));
		$('#BB').val(numberWithCommas(BB));
		$('#OB').val(numberWithCommas(OB));
		$('#NETT').val(numberWithCommas(NETT));
		$('#DPP1').val(numberWithCommas(DPP1));

		$("#TOTAL_QTY").autoNumeric('update');
		$("#TOTAL_QTYP").autoNumeric('update');
		$("#TTOTAL").autoNumeric('update');
		$("#STAND").autoNumeric('update');
		$("#BULAT").autoNumeric('update');
		$("#DPP").autoNumeric('update');
		$("#DISC3_HEADER").autoNumeric('update');
		$("#DISC2_HEADER").autoNumeric('update');
		$("#TDISK").autoNumeric('update');
		$("#DPPTDISK").autoNumeric('update');
		$("#DISC7_HEADER").autoNumeric('update');
		$("#DISC6_HEADER").autoNumeric('update');
		$("#PPN").autoNumeric('update');
		$("#BB").autoNumeric('update');
		$("#OB").autoNumeric('update');
		$("#NETT").autoNumeric('update');
		$("#DPP1").autoNumeric('update');
	}

	function tambah() {}

	function hapus() {}
</script>
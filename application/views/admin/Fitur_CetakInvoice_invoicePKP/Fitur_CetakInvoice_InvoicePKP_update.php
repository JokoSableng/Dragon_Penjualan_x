<?php
foreach ($cetakinvoicepkp as $rowh) {
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
	<form id="cetakinvoicepkp" name="cetakinvoicepkp" action="<?php echo base_url('admin/Fitur_CetakInvoice_InvoicePKP/update_aksi'); ?>" class="form-horizontal" method="post">
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sj </label>
						</div>
						<div class="input-group col-md-2">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value="<?php echo $rowh->NO_BUKTI ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl </label>
						</div>
						<div class="input-group col-md-2">
							<input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_PMS, TRUE)); ?>" onclick="select()">
						</div>
						<!-- <div class="col-md-1">
							<label class="label">No Sj </label>
						</div>
						<div class="col-md-2 input-group">
							<input class="form-control text_input NO_SURAT" id="NO_SURAT" name="NO_SURAT" type="text" value="<?php //echo $rowh->NO_SURAT ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl SJ </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input TGL_SJ" id="TGL_SJ" name="TGL_SJ" type="text" value="<?php //echo $rowh->TGL_SJ ?>" readonly>
						</div> -->
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
							<label class="label">No Order </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_SO" id="NO_SO" name="NO_SO" type="text" value="<?php echo $rowh->NO_SO ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Invoice </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input INVOICE" id="INVOICE" name="INVOICE" type="text" value="<?php echo $rowh->INVOICE ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Tgl Faktur </label>
						</div>
						<div class="col-md-2">
							<input type="text" class="date form-control text_input" id="TGL_FKTR" name="TGL_FKTR" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_FKTR, TRUE)); ?>" onclick="select()">
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
						<div class="col-md-3">
							<input class="form-control text_input NAMAC" id="NAMAC" name="NAMAC" type="text" value="<?php echo $rowh->NAMAC ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">NPWP </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NPWP" id="NPWP" name="NPWP" type="text" value="<?php echo $rowh->NPWP ?>" readonly>
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
								<th width="150px">Uraian</th>
								<th width="125px">Qty</th>
								<th width="90px">Satuan</th>
								<th width="125px">Harga</th>
								<th width="150px">Jumlah</th>
								<th width="100px">Diskon</th>
								<th width="100px">DPP</th>
								<th width="100px">PPN</th>
								<th width="1px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($cetakinvoicepkp as $row) :
							?>
								<tr>
									<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
									<td><input name="KD_BRG[]" id="KD_BRG<?php echo $no; ?>" value="<?= $row->KD_BRG ?>" type="text" class="form-control KD_BRG text_input" readonly hidden> <input name="NA_BRG[]" id="NA_BRG<?php echo $no; ?>" value="<?= $row->NA_BRG ?>" type="text" class="form-control NA_BRG text_input" readonly></td>
									<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" id="QTY<?php echo $no; ?>" value="<?php echo ($row->QTY)==0 ? number_format($row->QTYP, 2, '.', ',') : number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary" readonly></td>
									<td><input name="SATUAN[]" id="SATUAN<?php echo $no; ?>" value="<?= $row->SATUAN ?>" type="text" class="form-control SATUAN text_input" readonly></td>
									<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo ($row->QTY)==0 ? number_format($row->HARGAP, 2, '.', ',') : number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary" readonly></td>
									<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" id="TOTAL<?php echo $no; ?>" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
									<td><input name="DISCRP[]" onclick="select()" onkeyup="hitung()" id="DISCRP<?php echo $no; ?>" value="<?php echo number_format($row->DISC1+$row->DISC2+$row->DISC3+$row->DISC4+$row->DISCRP, 2, '.', ','); ?>" type="text" class="form-control DISCRP rightJustified text-danger" readonly></td>
									<td><input name="TOTALDPP[]" onclick="select()" onkeyup="hitung()" id="TOTALDPP<?php echo $no; ?>" value="<?php echo number_format($row->TOTALDPP, 2, '.', ','); ?>" type="text" class="form-control TOTALDPP rightJustified text-primary" readonly></td>
									<td><input name="TOTALPPN[]" onclick="select()" onkeyup="hitung()" id="TOTALPPN<?php echo $no; ?>" value="<?php //echo number_format($row->TOTALPPN, 2, '.', ','); ?>" type="text" class="form-control TOTALPPN rightJustified text-danger" readonly></td>
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
				<div class="col-md-9">
				</div>
				<div class="col-md-1">
					<label class="label">Sub Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TOTAL_QTY rightJustified text-primary font-weight-bold" id="TOTAL_QTY" name="TOTAL_QTY" value="<?php echo number_format($rowh->TOTAL_QTY, 2, '.', ','); ?>" readonly hidden>
					<input class="form-control TTOTAL rightJustified text-success font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->TTOTAL, 2, '.', ','); ?>" id="TTOTAL" name="TTOTAL" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Keterangan </label>
				</div>
				<div class="col-md-7">
					<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value="<?php echo $rowh->NOTES ?>">
				</div>
				<div class="col-md-1">
				</div>
				<div class="col-md-1">
					<label class="label">Disc Rp </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TDISK rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($rowh->TDISK, 2, '.', ','); ?>" id="TDISK" name="TDISK" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-9">
				</div>
				<div class="col-md-1">
					<label class="label">Uang Muka </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control LAIN rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->LAIN, 2, '.', ','); ?>" id="LAIN" name="LAIN" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-9">
				</div>
				<div class="col-md-1">
					<label class="label">DPP </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DPP rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->DPP, 2, '.', ','); ?>" id="DPP" name="DPP" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-9">
				</div>
				<div class="col-md-1">
					<label class="label">PPN </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control PPN rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->PPN, 2, '.', ','); ?>" id="PPN" name="PPN" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-9">
				</div>
				<div class="col-md-1">
					<label class="label">DPP + PPN</label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control NETT rightJustified text-success font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->NETT, 2, '.', ','); ?>" id="NETT" name="NETT" readonly>
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
<div id="mymodal_no_sj" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data SJ</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_no_sj'>
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
							ORDER BY NO_BUKTI DESC";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='NSSVAL'><a href="#" class="select_no_sj"><?php echo $b->NO_SURAT; ?></a></td>
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
		$('#modal_no_sj').DataTable({
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
		$("#TTOTAL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DPP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TDISK").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#PPN").autoNumeric('init', {
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
			$("#HARGA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TOTAL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISCRP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TOTALDPP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TOTALPPN" + i.toString()).autoNumeric('init', {
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
			target.parents("div").find(".NO_SURAT").val(val);
			var val = $(this).parents("tr").find(".TSSVAL").text();
			target.parents("div").find(".TGL_SJ").val(val);
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
		});

		hitung();
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
		var TTOTAL = 0;
		var TDPP = 0;
		var TDISK = 0;
		var TPPN = 0;
		var NETT = 0;
		
		let TGL = new Date("<?= date('Y,m,d', strtotime($rowh->TGL))?>");
		let TGL11 = new Date("2022,4,1");
		var pajak = TGL>=TGL11 ? 0.11 : 0.1;

		$(".QTY").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TOTAL_QTY += val;
		});
		$(".TOTAL").each(function() {
			let z = $(this).closest('tr');
			var QTY = parseFloat(z.find('.QTY').val().replace(/,/g, ''));
			var HARGA = parseFloat(z.find('.HARGA').val().replace(/,/g, ''));
			var DISC = parseFloat(z.find('.DISCRP').val().replace(/,/g, ''));
			var TAX = '<?=$rowh->TAX ?>'=='P' ? pajak : 0;
			var TOTDPP = parseFloat(z.find('.TOTALDPP').val().replace(/,/g, ''));

			var TOTAL =  QTY * HARGA;
			if (isNaN(TOTAL)) TOTAL = 0;
            // var TOTALDPP  = (TOTAL-DISCRP) / TAX;
            // var TOTALPPN  = (TOTAL-DISCRP)-parseFloat(TOTALDPP.toFixed().replace(/,/g, ''));
            var DISCRP  = DISC/100*TOTAL;
            var TOTALDPP  = (TOTAL-DISCRP);
            // var TOTALPPN  = (TOTAL-DISCRP) * TAX;
            var TOTALPPN  = (TOTAL-TOTDPP);
			if (isNaN(TOTALPPN)) TOTALPPN = 0;
			
			$(this).val(TOTAL);
		    $(this).autoNumeric('update');
			// z.find('.TOTALDPP').val(TOTALDPP);
		    // z.find('.TOTALDPP').autoNumeric('update');
			z.find('.TOTALPPN').val(TOTALPPN.toFixed());
		    z.find('.TOTALPPN').autoNumeric('update');

			TTOTAL += TOTAL;
			TDPP += parseFloat(TOTALDPP.toFixed().replace(/,/g, ''));
			TPPN += parseFloat(TOTALPPN.toFixed().replace(/,/g, ''));
			TDISK += DISCRP;
		});

		NETT = TDPP + TPPN;

		if (isNaN(TOTAL_QTY)) TOTAL_QTY = 0;
		if (isNaN(TTOTAL)) TTOTAL = 0;
		if (isNaN(TDPP)) TDPP = 0;
		if (isNaN(TDISK)) TDISK = 0;
		if (isNaN(TPPN)) TPPN = 0;
		if (isNaN(NETT)) NETT = 0;

		// $('#TOTAL_QTY').val(numberWithCommas(TOTAL_QTY));
		// $('#TTOTAL').val(numberWithCommas(TTOTAL));
		// $('#DPP').val(numberWithCommas(TDPP));
		// $('#TDISK').val(numberWithCommas(TDISK));
		// $('#PPN').val(numberWithCommas(TPPN));
		// $('#NETT').val(numberWithCommas(NETT));

		// $("#TOTAL_QTY").autoNumeric('update');
		// $("#TTOTAL").autoNumeric('update');
		// $("#DPP").autoNumeric('update');
		// $("#TDISK").autoNumeric('update');
		// $("#PPN").autoNumeric('update');
		// $("#NETT").autoNumeric('update');
	}

	function tambah() {}

	function hapus() {}
</script>
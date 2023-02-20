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
		<i class="fas fa-university"></i> Input <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="proformainvoiceexpor" name="proformainvoiceexpor" action="<?php echo base_url('admin/Transaksi_ProformaInvoiceExpor/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="input-group col-md-2">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value='' readonly>
						</div>
						<div class="col-md-1">
							<label class="label">No SO </label>
						</div>
						<div class="col-md-2 input-group">
							<input name="NO_SO" id="NO_SO" type="text" class="form-control NO_SO text_input" onkeypress="return tabE(this,event)" readonly>
							<span class="input-group-btn">
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_no_so" data-toggle="modal" href="#lupsj"><i class="fa fa-search"></i></a>
							</span>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl SO </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input TGL_SO" id="TGL_SO" name="TGL_SO" type="text" value='' readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KODEC" id="KODEC" name="KODEC" type="text" value='' readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NAMAC" id="NAMAC" name="NAMAC" type="text" value='' readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input ALAMAT" id="ALAMAT" name="ALAMAT" type="text" value='' readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Kode Area </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input WILAYAH" id="WILAYAH" name="WILAYAH" type="text" value='' readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input MAXKRE" id="MAXKRE" name="MAXKRE" type="text" value='' readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KOTA" id="KOTA" name="KOTA" type="text" value='' readonly>
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
								<th width="200px">Article</th>
								<th width="125px">Size</th>
								<th width="125px">Color</th>
								<th width="150px">Delivery Date</th>
								<th width="125px">Qty</th>
								<th width="125px">Unit</th>
								<th width="100px">Unit Price</th>
								<th width="150px">Tot Amount</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody id="show-data">
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_BRG[]" id="KD_BRG0" type="text" class="form-control KD_BRG text_input" readonly></td>
								<td><input name="SIZE[]" id="SIZE0" type="text" class="form-control SIZE text_input" readonly></td>
								<td><input name="WARNA[]" id="WARNA0" type="text" class="form-control WARNA text_input" readonly></td>
								<td>
									<input type="text" class="date form-control TGL_SJ text_input" id="TGL_SJ0" name="TGL_SJ[]" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																											echo $_POST["TGL_SJ"];
																																										} else echo date('d-m-Y'); ?>">
								</td>
								<td><input name="QTYP[]" onclick="select()" onkeyup="hitung()" value="0" id="QTYP0" type="text" class="form-control QTYP rightJustified text-primary"></td>
								<td><input name="SATUAN[]" id="SATUAN0" type="text" class="form-control SATUAN text_input" readonly></td>
								<td><input name="HARGAP[]" onclick="select()" onkeyup="hitung()" value="0" id="HARGAP0" type="text" class="form-control HARGAP rightJustified text-primary"></td>
								<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value="0" id="TOTAL0" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
								<td>
									<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
										<i class="fa fa-fw fa-trash"></i>
									</button>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TOTAL_QTYP rightJustified text-primary font-weight-bold" id="TOTAL_QTYP" name="TOTAL_QTYP" value="0" readonly></td>
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
					<label class="label">Condition </label>
				</div>
				<div class="col-md-8"></div>
				<div class="col-md-1">
					<label class="label">Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TTOTAL rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="TTOTAL" name="TTOTAL" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Franco </label>
				</div>
				<div class="col-md-2">
					<input class="form-control text_input FRANCO" id="FRANCO" name="FRANCO" type="text" value=''>
				</div>
				<div class="col-md-6"></div>
				<div class="col-md-1">
					<label class="label">Kurs </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control KURS rightJustified text-primary font-weight-bold" value="0" id="KURS" name="KURS">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Payment </label>
				</div>
				<div class="col-md-2">
					<input class="form-control text_input PAYMENT" id="PAYMENT" name="PAYMENT" type="text" value=''>
				</div>
				<div class="col-md-6"></div>
				<div class="col-md-1">
					<label class="label">Nett </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control NETT rightJustified text-success font-weight-bold" onchange="hitung()" value="0" id="NETT" name="NETT" readonly>
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

<!-- myModal No SO-->
<div id="mymodal_no_so" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data SO</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_no_so'>
					<thead>
						<th>No SO</th>
						<th>Tgl SO</th>
						<th>Kodec</th>
						<th>Namac</th>
						<th>Wilayah</th>
						<th>Alamat</th>
						<th>MaxKre</th>
						<th>Kota</th>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT so.NO_BUKTI AS NO_SO, 
								so.TGL AS TGL_SO, 
								so.KODEC AS KODEC,
								so.NAMAC AS NAMAC,
								so.WILAYAH AS WILAYAH,
								cust.ALAMAT AS ALAMAT,
								cust.MAXKRE AS MAXKRE,
								cust.KOTA AS KOTA
							FROM so, cust
							WHERE so.KODEC=cust.KODEC
							ORDER BY NO_BUKTI DESC";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='NSSVAL'><a href="#" class="select_no_so"><?php echo $b->NO_SO; ?></a></td>
								<td class='TSSVAL text_input'><?php echo $b->TGL_SO; ?></td>
								<td class='KOSVAL text_input'><?php echo $b->KODEC; ?></td>
								<td class='NASVAL text_input'><?php echo $b->NAMAC; ?></td>
								<td class='WLSVAL text_input'><?php echo $b->WILAYAH; ?></td>
								<td class='ALSVAL text_input'><?php echo $b->ALAMAT; ?></td>
								<td class='MKSVAL text_input'><?php echo $b->MAXKRE; ?></td>
								<td class='KTSVAL text_input'><?php echo $b->KOTA; ?></td>
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
		$('#modal_no_so').DataTable({
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
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#TOTAL_QTYP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TTOTAL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#KURS").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#NETT").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTYP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARGAP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TOTAL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		//MyModal SO
		$('#mymodal_no_so').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_no_so', function() {
			var val = $(this).parents("tr").find(".NSSVAL").text();
			target.parents("div").find(".NO_SO").val(val);
			var val = $(this).parents("tr").find(".TSSVAL").text();
			target.parents("div").find(".TGL_SO").val(val);
			var val = $(this).parents("tr").find(".KOSVAL").text();
			target.parents("div").find(".KODEC").val(val);
			var val = $(this).parents("tr").find(".NASVAL").text();
			target.parents("div").find(".NAMAC").val(val);
			var val = $(this).parents("tr").find(".WLSVAL").text();
			target.parents("div").find(".WILAYAH").val(val);
			var val = $(this).parents("tr").find(".ALSVAL").text();
			target.parents("div").find(".ALAMAT").val(val);
			var val = $(this).parents("tr").find(".MKSVAL").text();
			target.parents("div").find(".MAXKRE").val(val);
			var val = $(this).parents("tr").find(".KTSVAL").text();
			target.parents("div").find(".KOTA").val(val);
			$('#mymodal_no_so').modal('toggle');
			var no_so = $(this).parents("tr").find(".NSSVAL").text();
			$.ajax({
				type: 'get',
				url: '<?php echo base_url('index.php/admin/Transaksi_ProformaInvoiceExpor/filter_no_so'); ?>',
				data: {
					no_so: no_so
				},

				dataType: 'json',
				success: function(response) {
					// alert(response);
					var html = '';
					var i;
					for (i = 0; i < response.length; i++) {
						html += '<tr>' +
							'<td><input name="REC[]" id=REC' + i + ' type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly value=' + (i + 1) + ' ></td>' +
							'<td><input name="KD_BRG[]" value="' + response[i].KD_BRG + '" id=KD_BRG' + i + ' type="text" class="form-control KD_BRG text_input" readonly></td>' +
							'<td><input name="SIZE[]" value="' + response[i].SIZE + '" id=SIZE' + i + ' type="text" class="form-control SIZE text_input" readonly></td>' +
							'<td><input name="WARNA[]" value="' + response[i].WARNA + '" id=WARNA' + i + ' type="text" class="form-control WARNA text_input" readonly></td>' +
							'<td><input name="TGL_SJ[]" value="<?php if (isset($_POST["tampilkan"])) {
																	echo $_POST["TGL_SJ"];
																} else echo date('d-m-Y'); ?>" id=TGL_SJ' + i + ' type="text" class="date form-control TGL_SJ text_input" data-date-format="dd-mm-yyyy"></td>' +
							'<td><input name="QTYP[]" value="' + numberWithCommas(response[i].QTYP) + '" id=QTYP' + i + ' type="text" class="form-control QTYP rightJustified text-primary" readonly></td>' +
							'<td><input name="SATUAN[]" value="' + response[i].SATUAN + '" id=SATUAN' + i + ' type="text" class="form-control SATUAN text_input" readonly></td>' +
							'<td><input name="HARGAP[]" value="' + numberWithCommas(response[i].HARGAP) + '" id=HARGAP' + i + ' type="text" class="form-control HARGAP rightJustified text-primary" readonly></td>' +
							'<td><input name="TOTAL[]" value="' + numberWithCommas(response[i].TOTAL) + '" id=TOTAL' + i + ' type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>' +
							'</tr>';
					}
					idrow = i;
					$('#show-data').html(html);
					jumlahdata = 100;
					for (i = 0; i <= jumlahdata; i++) {
						$("#QTYP" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#HARGAP" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#TOTAL" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
					}
					$('input[type="checkbox"]').on('change', function() {
						this.value ^= 1;
						console.log(this.value)
					});
				}
			});
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
		var TOTAL_QTYP = 0;
		var TTOTAL = 0;
		var KURS = parseFloat($('#KURS').val().replace(/,/g, ''));
		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var qtyp = parseFloat($('#QTYP' + i).val().replace(/,/g, ''));
			var hargap = parseFloat($('#HARGAP' + i).val().replace(/,/g, ''));
			var total = parseFloat($('#TOTAL' + i).val().replace(/,/g, ''));
			// 	var harga = parseFloat($('#HARGA'+i).val().replace(/,/g, ''));
			// 	var hargap = parseFloat($('#HARGAP'+i).val().replace(/,/g, ''));

			// 	var qtyp = qty*12;
			// 	if(isNaN(qtyp)) qtyp = 0;
			// 	$('#QTYP'+i).val(numberWithCommas(qtyp));
			// 	$('#QTYP'+i).autoNumeric('update');

			// 	var hargap = harga*12;
			// 	if(isNaN(hargap)) hargap = 0;
			// 	$('#HARGAP'+i).val(numberWithCommas(hargap));
			// 	$('#HARGAP'+i).autoNumeric('update');

			// 	var total = qty*harga;
			// 	if(isNaN(total)) total = 0;
			// 	$('#TOTAL'+i).val(numberWithCommas(total));
			// 	$('#TOTAL'+i).autoNumeric('update');
		};

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

		NETT = TTOTAL * KURS;

		if (isNaN(TOTAL_QTYP)) TOTAL_QTYP = 0;
		if (isNaN(TTOTAL)) TTOTAL = 0;
		if (isNaN(NETT)) NETT = 0;

		$('#TOTAL_QTYP').val(numberWithCommas(TOTAL_QTYP));
		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$('#NETT').val(numberWithCommas(NETT));

		$("#TOTAL_QTYP").autoNumeric('update');
		$("#TTOTAL").autoNumeric('update');
		$("#NETT").autoNumeric('update');
	}

	function tambah() {}

	function hapus() {}
</script>
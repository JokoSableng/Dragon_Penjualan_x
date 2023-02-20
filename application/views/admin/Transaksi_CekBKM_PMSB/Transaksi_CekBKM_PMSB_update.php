<?php
foreach ($cekbkm_pmsb as $rowh) {
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
		<i class="fas fa-university"></i> Update Cek BKM PMS B
	</div>
	<form id="cekbkm_pmsb" name="cekbkm_pmsb" action="<?php echo base_url('admin/Transaksi_CekBKM_PMSB/update_aksi'); ?>" class="form-horizontal" method="post">
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
						<div class="col-md-1">
							<label class="label">Tanggal </label>
						</div>
						<div class="input-group col-md-2">
							<input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL, TRUE)); ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Kode Area </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input WILAYAH" id="WILAYAH" name="WILAYAH" type="text" value="<?php echo $rowh->WILAYAH ?>" readonly>
							<!-- <select class="js-example-responsive-wilayah form-control WILAYAH text_input" name="WILAYAH" id="WILAYAH" onchange="wilayah(this.id)">
								<option value="<?php echo $rowh->WILAYAH; ?>" selected id="WILAYAH"><?php echo $rowh->WILAYAH; ?></option>
							</select> -->
						</div>
						<div class="col-md-1">
							<label class="label">Setor </label>
						</div>
						<div class="col-md-1 ">
							<select class="form-control KD_SETOR text_input" id="KD_SETOR" value="<?php echo $rowh->KD_SETOR ?>" style="width: 100%;" name="KD_SETOR">
								<?php if ($rowh->KD_SETOR == "RI") {
									echo "<option value='RI' selected>RI</option>";
									echo "<option value='CA'>CA</option>";
									echo "<option value='DN'>DN</option>";
								}
								if ($rowh->KD_SETOR == "CA") {
									echo "<option value='RI'>RI</option>";
									echo "<option value='CA' selected>CA</option>";
									echo "<option value='DN'>DN</option>";
								} else {
									echo "<option value='RI'>RI</option>";
									echo "<option value='CA'>CA</option>";
									echo "<option value='DN' selected>DN</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Kode Customer </label>
						</div>
						<div class="col-md-2">
							<select class="js-example-responsive-kodec form-control KODEC text_input" name="KODEC" id="KODEC" onchange="kodec(this.id)">
								<option value="<?php echo $rowh->KODEC; ?>" selected id="KODEC"><?php echo $rowh->KODEC; ?></option>
							</select>
						</div>
						<div class="col-md-3">
							<input class="form-control text_input NAMAC" id="NAMAC" name="NAMAC" type="text" value="<?php echo $rowh->NAMAC ?>" readonly>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-primary btn-sm" onclick="updateTanda()">Centang</button>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Perk </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input ACC" id="ACC" name="ACC" type="text" value="<?php echo $rowh->ACC ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Notes </label>
						</div>
						<div class="col-md-5">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value="<?php echo $rowh->NOTES ?>">
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
								<th width="200px">No Sj</th>
								<th width="200px">Invoice</th>
								<th width="200px">Tg Fak</th>
								<th width="200px">Tgl Sj</th>
								<th width="150px">Bayar</th>
								<th width="150px">Cek</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($cekbkm_pmsb as $row) :
							?>
								<tr>
									<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
									<td>
										<div class="input-group">
											<select class="js-example-responsive-no_surat form-control NO_SURAT text_input" name="NO_SURAT[]" id="NO_SURAT<?php echo $no; ?>" onchange="no_surat(this.id)">
												<option value="<?php echo $row->NO_SURAT; ?>" selected id="NO_SURAT<?php echo $no; ?>"><?php echo $row->NO_SURAT; ?></option>
											</select>
										</div>
									</td>
									<td><input name="INVOICE[]" id="INVOICE<?php echo $no; ?>" value="<?= $row->INVOICE ?>" type="text" class="form-control INVOICE text_input" readonly></td>
									<td><input name="TGL_FKTR[]" id="TGL_FKTR<?php echo $no; ?>" type="text" class="date form-control text_input" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($row->TGL_FKTR, TRUE)); ?>" onclick="select()"></td>
									<td><input name="TGL_SURAT[]" id="TGL_SURAT<?php echo $no; ?>" type="text" class="date form-control text_input" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($row->TGL_SURAT, TRUE)); ?>" onclick="select()"></td>
									<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" id="TOTAL<?php echo $no; ?>" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" type="text" class="form-control TOTAL rightJustified text-primary"></td>
									<td>
										<input name="TANDA[]" maxlength="1" id="TANDA<?php echo $no; ?>" value="<?= $row->TANDA ?>" type="text" class="form-control TANDA text_input">
										<input name="TANDAX[]" maxlength="1" id="TANDAX<?php echo $no; ?>" value="<?= $row->TANDAX ?>" type="hidden" class="form-control TANDAX text_input">
									</td>
									<td>
										<input name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden">
										<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
											<i class="fa fa-fw fa-trash-alt"></i>
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
							<td></td>
							<td></td>
							<td><input class="form-control TTOTAL rightJustified text-primary font-weight-bold" id="TTOTAL" name="TTOTAL" value="<?php echo number_format($rowh->TTOTAL, 2, '.', ','); ?>" readonly></td>
							<td></td>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<br>
		<!--tab-->
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div>
		<hr>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-3">
					<h3 class="label">Metode Pembayaran </h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive scrollable">
					<table id="datatable" class="table table-hoverx table-stripedx table-borderedx table-condensed table-scrollable">
						<thead>
							<tr>
								<th width="200px">No Giro</th>
								<th width="200px">Bank</th>
								<th width="200px">J Tempo</th>
								<th width="100px">Tgl Cair</th>
								<th width="150px">Giro</th>
								<th width="150px">Tunai</th>
								<th width="150px">Ku</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input name="NO_CHBG" id="NO_CHBG" value="<?php echo $rowh->NO_CHBG ?>" type="text" class="form-control NO_CHBG text_input"></td>
								<td><input name="BANK" id="BANK" value="<?php echo $rowh->BANK ?>" type="text" class="form-control BANK text_input"></td>
								<td><input type="text" class="date form-control text_input" id="JTEMPO" name="JTEMPO" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->JTEMPO, TRUE)); ?>"></td>
								<td><input type="text" class="date form-control text_input" id="TGL_CAIR" name="TGL_CAIR" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_CAIR, TRUE)); ?>"></td>
								<td><input name="GIRO" onclick="select()" onkeyup="hitung()" value="<?php echo number_format($rowh->GIRO, 2, '.', ','); ?>" id="GIRO" type="text" class="form-control GIRO rightJustified text-primary"></td>
								<td><input name="TUNAI" onclick="select()" onkeyup="hitung()" value="<?php echo number_format($rowh->TUNAI, 2, '.', ','); ?>" id="TUNAI" type="text" class="form-control TUNAI rightJustified text-primary"></td>
								<td><input name="KU" onclick="select()" onkeyup="hitung()" value="<?php echo number_format($rowh->KU, 2, '.', ','); ?>" id="KU" type="text" class="form-control KU rightJustified text-primary"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br><br>
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

<script>
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			var forms = document.getElementsByClassName('needs-validation');
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
		$("#TTOTAL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#GIRO").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TUNAI").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#KU").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#TOTAL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
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
		var TTOTAL = 0;

		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var total = parseFloat($('#TOTAL' + i).val().replace(/,/g, ''));

		};
		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TTOTAL += val;
		});

		if (isNaN(TTOTAL)) TTOTAL = 0;

		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$("#TTOTAL").autoNumeric('update');
	}

	function updateTanda() {
		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			$('#TANDA' + i).val($('#TANDAX' + i).val() ?? $('#TANDA' + i).val());
		}
		alert("Update Status Selesai..");
	}

	function tambah() {

		var x = document.getElementById('datatable').insertRow(idrow + 1);
		var td1 = x.insertCell(0);
		var td2 = x.insertCell(1);
		var td3 = x.insertCell(2);
		var td4 = x.insertCell(3);
		var td5 = x.insertCell(4);
		var td6 = x.insertCell(5);
		var td7 = x.insertCell(6);
		var td8 = x.insertCell(7);

		var no_surat0 = "<div class='input-group'><select class='js-example-responsive-no_surat form-control NO_SURAT' name='NO_SURAT[]' value='' id=NO_SURAT" + idrow + " onchange='no_surat(this.id)' onfocusout='hitung()' required></select></div>";
		var no_surat = no_surat0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = no_surat;
		td3.innerHTML = "<input name='INVOICE[]' id=INVOICE" + idrow + " type='text' class='form-control INVOICE text_input' readonly>";
		td4.innerHTML = "<input name='TGL_FKTR[]' ocnlick='select()' id=TGL_FKTR" + idrow + " type='text' class='date form-control TGL_FKTR text_input' data-date-format='dd-mm-yyyy' value='<?php if (isset($_POST["tampilkan"])) {
																																																	echo $_POST["TGL_FKTR"];
																																																} else echo date('d-m-Y'); ?>'>";
		td5.innerHTML = "<input name='TGL_SURAT[]' ocnlick='select()' id=TGL_SURAT" + idrow + " type='text' class='date form-control TGL_SURAT text_input' data-date-format='dd-mm-yyyy' value='<?php if (isset($_POST["tampilkan"])) {
																																																	echo $_POST["TGL_SURAT"];
																																																} else echo date('d-m-Y'); ?>'>";
		td6.innerHTML = "<input name='TOTAL[]' onclick='select()' onkeyup='hitung()' value='0' id=TOTAL" + idrow + " type='text' class='form-control TOTAL rightJustified text-primary' readonly>";
		td7.innerHTML = "<input name='TANDA[]' id=TANDA" + idrow + " type='text' class='form-control TANDA text_input' maxlength='1'>";
		td8.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#TOTAL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		select_no_surat();
		idrow++;
		nomor();
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
	}

	function hapus() {
		if (idrow > 1) {
			var x = document.getElementById('datatable').deleteRow(idrow);
			idrow--;
			nomor();
		}
	}
</script>

<script>
	$(document).ready(function() {
		$(window).keydown(function(event) {
			if ((event.keyCode == 13)) {
				event.preventDefault();
				return false;
			}
		});
		select_wilayah();
		select_kodec();
		select_no_surat();
	});

	function select_wilayah() {
		$('.js-example-responsive-wilayah').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_CekBKM_PMSB/getDataAjax_wilayah') ?>",
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
			placeholder: 'Pilih Wilayah',
			minimumInputLength: 0,
			templateResult: format_wilayah,
			templateSelection: formatSelection_wilayah
		});
	}

	function format_wilayah(repo_wilayah) {
		if (repo_wilayah.loading) {
			return repo_wilayah.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix text_input'>" +
			"<div class='select2-result-repository__title text_input'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_wilayah.WILAYAH);
		return $container;
	}

	function formatSelection_wilayah(repo_wilayah) {
		return repo_wilayah.text;
	}

	function wilayah(x) {
		var q = x.substring(7, 9);
		console.log('Wilayah :' + q);
	}

	function select_kodec() {
		var wilayah = $('#WILAYAH').val();
		$('.js-example-responsive-kodec').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_CekBKM_PMSB/getDataAjax_cust') ?>",
				dataType: "json",
				type: "post",
				delay: 10,
				data: function(params) {
					return {
						search: params.term,
						page: params.page,
						wilayah: $('#WILAYAH').val(),
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
			templateResult: format_kodec,
			templateSelection: formatSelection_kodec
		});
	}

	function format_kodec(repo_kodec) {
		if (repo_kodec.loading) {
			return repo_kodec.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix text_input'>" +
			"<div class='select2-result-repository__title text_input'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_kodec.KODEC);
		return $container;
	}
	var namac = '';

	function formatSelection_kodec(repo_kodec) {
		namac = repo_kodec.NAMAC;
		return repo_kodec.text;
	}

	function kodec(xx) {
		var qq = xx.substring(6, 8);
		$('#NAMAC' + qq).val(namac);
		console.log('Namac :' + qq);
	}

	function select_no_surat() {
		var kodec = $('#KODEC').val();
		$('.js-example-responsive-no_surat').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_CekBKM_PMSB/getDataAjax_no_surat') ?>",
				dataType: "json",
				type: "post",
				delay: 10,
				data: function(params) {
					return {
						search: params.term,
						page: params.page,
						kodec: $('#KODEC').val(),
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
			placeholder: 'Pilih No SJ',
			minimumInputLength: 0,
			templateResult: format_no_surat,
			templateSelection: formatSelection_no_surat
		});
	}

	function format_no_surat(repo_no_surat) {
		if (repo_no_surat.loading) {
			return repo_no_surat.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix text_input'>" +
			"<div class='select2-result-repository__title text_input'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_no_surat.NO_SURAT);
		return $container;
	}
	var invoice = '';
	var tgl_fktr = '';
	var tgl_surat = '';
	var total = '';

	function formatSelection_no_surat(repo_no_surat) {
		invoice = repo_no_surat.INVOICE;
		tgl_fktr = repo_no_surat.TGL_FKTR;
		tgl_surat = repo_no_surat.TGL_SURAT;
		total = repo_no_surat.TOTAL;
		return repo_no_surat.text;
	}

	function no_surat(xxx) {
		var qqq = xxx.substring(8, 12);
		$('#INVOICE' + qqq).val(invoice);
		$('#TGL_FKTR' + qqq).val(tgl_fktr);
		$('#TGL_SURAT' + qqq).val(tgl_surat);
		$('#TOTAL' + qqq).val(total);
		console.log('No Surat :' + qqq);
	}
</script>
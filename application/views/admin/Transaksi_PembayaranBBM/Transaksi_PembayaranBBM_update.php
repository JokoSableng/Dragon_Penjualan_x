<?php
foreach ($pembayaranbbm as $rowh) {};
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
	<form id="pembayaranbbm" name="pembayaranbbm" action="<?php echo base_url('admin/Transaksi_PembayaranBBM/update_aksi'); ?>" class="form-horizontal" method="post">
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
							<label class="label">Notes </label>
						</div>
						<div class="col-md-3">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value="<?php echo $rowh->NOTES ?>">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bank</label>
						</div>
						<div class="col-md-2 input-group">
							<input class="form-control text_input NO_RBANK" id="NO_RBANK" name="NO_RBANK" type="text" value="<?php echo $rowh->NO_RBANK ?>" readonly>
							<span class="input-group-btn">
								<a class="btn btn-light" onfocusout="hitung()" href="#" onclick="window.open('<?= base_url('admin/Transaksi_PembayaranBBM/updateRbank/'.$rowh->NO_ID_RBANK) ?>', '', 'width=1200','height=1000');"><i class="fa fa-edit"></i></a>
							</span>
						</div>
						<div class="col-md-1">
							<label class="label">Nilai Bank</label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input JUM_RBANK rightJustified" id="JUM_RBANK" name="JUM_RBANK" type="text" value="<?php echo $rowh->JUM_RBANK ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">No JL Piu</label>
						</div>
						<div class="col-md-2 input-group">
							<input class="form-control text_input NO_JLPIU" id="NO_JLPIU" name="NO_JLPIU" type="text" value="<?php echo $rowh->NO_JLPIU ?>">
							<span class="input-group-btn">
								<a class="btn btn-warning" href="#" onclick="getJlpiu()"><i class="fa fa-search"></i></a>
							</span>
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
								<th width="150px">Invoice</th>
								<th width="150px">Kodec</th>
								<th width="150px">Namac</th>
								<th width="150px">Tg Fak</th>
								<th width="150px">Tgl Sj</th>
								<th width="150px">T Bayar</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody id="detail">
							<?php
							$no = 0;
							foreach ($pembayaranbbm as $row) :
							?>
								<tr>
									<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
									<!-- <td>
										<div class="input-group">
											<select class="js-example-responsive-no_surat form-control NO_SURAT text_input" name="NO_SURAT[]" id="NO_SURAT<?php echo $no; ?>" onchange="no_surat(this.id)">
												<option value="<?php echo $row->NO_SURAT; ?>" selected id="NO_SURAT<?php echo $no; ?>"><?php echo $row->NO_SURAT; ?></option>
											</select>
										</div>
									</td> -->
									<td><input name="NO_SURAT[]" id="NO_SURAT<?php echo $no; ?>" value="<?= $row->NO_SURAT ?>" type="text" class="form-control NO_SURAT text_input" readonly></td>
									<td><input name="INVOICE[]" id="INVOICE<?php echo $no; ?>" value="<?= $row->INVOICE ?>" type="text" class="form-control INVOICE text_input" readonly></td>
									<td><input name="KODEC[]" id="KODEC<?php echo $no; ?>" value="<?= $row->KODEC ?>" type="text" class="form-control KODEC text_input" readonly></td>
									<td><input name="NAMAC[]" id="NAMAC<?php echo $no; ?>" value="<?= $row->NAMAC ?>" type="text" class="form-control NAMAC text_input" readonly></td>
									<td><input name="TGL_FKTR[]" id="TGL_FKTR<?php echo $no; ?>" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_FKTR)); ?>" type="text" class="form-control TGL_FKTR text_input" readonly></td>
									<td><input name="TGL_SURAT[]" id="TGL_SURAT<?php echo $no; ?>" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_SURAT)); ?>" type="text" class="form-control TGL_SURAT text_input" readonly></td>
									<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" id="TOTAL<?php echo $no; ?>" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
									<td>
										<input name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden">
										<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
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
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success" hidden><i class="fas fa-plus fa-sm md-3"></i> </button>
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
								<td>
									<input type="text" class="date form-control text_input" id="JTEMPO" name="JTEMPO" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->JTEMPO, TRUE)); ?>">
								</td>
								<td>
									<input type="text" class="date form-control text_input" id="TGL_CAIR" name="TGL_CAIR" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_CAIR, TRUE)); ?>">
								</td>
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
						<button type="submit" class="btn btn-success" onclick="return simpan()"><i class="fa fa-save"></i> Save</button>
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
		$("#JUM_RBANK").autoNumeric('init', {
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
		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TTOTAL += val;
		});

		if (isNaN(TTOTAL)) TTOTAL = 0;

		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$("#TTOTAL").autoNumeric('update');
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
		var td9 = x.insertCell(8);

		var no_surat0 = "<div class='input-group'><select class='js-example-responsive-no_surat form-control NO_SURAT' name='NO_SURAT[]' value='' id=NO_SURAT" + idrow + " onchange='no_surat(this.id)' onfocusout='hitung()' required></select></div>";
		var no_surat = no_surat0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		// td2.innerHTML = no_surat;
		td2.innerHTML = "<input name='NO_SURAT[]' id=NO_SURAT" + idrow + " type='text' class='form-control NO_SURAT text_input' readonly>";
		td3.innerHTML = "<input name='INVOICE[]' id=INVOICE" + idrow + " type='text' class='form-control INVOICE text_input' readonly>";
		td4.innerHTML = "<input name='KODEC[]' id=KODEC" + idrow + " type='text' class='form-control KODEC text_input' readonly>";
		td5.innerHTML = "<input name='NAMAC[]' id=NAMAC" + idrow + " type='text' class='form-control NAMAC text_input' readonly>";
		td6.innerHTML = "<input name='TGL_FKTR[]' id=TGL_FKTR" + idrow + " type='text' class='form-control TGL_FKTR text_input' readonly>";
		td7.innerHTML = "<input name='TGL_SURAT[]' id=TGL_SURAT" + idrow + " type='text' class='form-control TGL_SURAT text_input' readonly>";
		td8.innerHTML = "<input name='TOTAL[]' onclick='select()' onkeyup='hitung()' value='0' id=TOTAL" + idrow + " type='text' class='form-control TOTAL rightJustified text-primary' readonly>";
		td9.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
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
		select_no_surat();
	});

	function select_no_surat() {
		$('.js-example-responsive-no_surat').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_PembayaranBBM/getDataAjax_no_surat') ?>",
				dataType: "json",
				type: "post",
				delay: 10,
				data: function(params) {
					return {
						search: params.term,
						page: params.page,
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
	var kodec = '';
	var namac = '';
	var tgl_fktr = '';
	var tgl_surat = '';
	var total = '';

	function formatSelection_no_surat(repo_no_surat) {
		invoice = repo_no_surat.INVOICE;
		kodec = repo_no_surat.KODEC;
		namac = repo_no_surat.NAMAC;
		tgl_fktr = repo_no_surat.TGL_FKTR;
		tgl_surat = repo_no_surat.TGL_SURAT;
		total = repo_no_surat.TOTAL;
		return repo_no_surat.text;
	}

	function no_surat(xxx) {
		var qqq = xxx.substring(8, 12);
		$('#INVOICE' + qqq).val(invoice);
		$('#KODEC' + qqq).val(kodec);
		$('#NAMAC' + qqq).val(namac);
		$('#TGL_FKTR' + qqq).val(tgl_fktr);
		$('#TGL_SURAT' + qqq).val(tgl_surat);
		$('#TOTAL' + qqq).val(total);
		console.log('No Surat :' + qqq);
	}

	function getJlpiu()
	{
		// var no_jlpiu = '<?= $rowh->NO_BUKTI ?>';
		var no_jlpiu = $('#NO_JLPIU').val();
		$.ajax({
			async : false,
			type: 'get',
			url: '<?php echo base_url('index.php/admin/Transaksi_PembayaranBBM/getjlpiu'); ?>',
			data: {
				NO_JLPIU: no_jlpiu
			},
			dataType: 'json',
			success: function(response) {
				var html = '';
				var i;
				for (i = 0; i < response.length; i++) {
					html += `<tr>
						<td><input name="REC[]" id="REC` + i + `" type="text" value="` + (i + 1) + `" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
						<td><input name="NO_SURAT[]" id="NO_SURAT` + i + `" type="text" value="` + response[i].NO_SURAT + `" class="form-control NO_SURAT text_input" readonly></td>
						<td><input name="INVOICE[]" id="INVOICE` + i + `" type="text" class="form-control INVOICE text_input" value="` + response[i].INVOICE + `" readonly></td>
						<td><input name="KODEC[]" id="KODEC` + i + `" type="text" class="form-control KODEC text_input" value="` + response[i].KODEC + `" readonly></td>
						<td><input name="NAMAC[]" id="NAMAC` + i + `" type="text" class="form-control NAMAC text_input" value="` + response[i].NAMAC + `" readonly></td>
						<td><input name="TGL_FKTR[]" id="TGL_FKTR` + i + `" type="text" class="form-control TGL_FKTR text_input" value="` + response[i].TGL_FKTR + `" readonly></td>
						<td><input name="TGL_SURAT[]" id="TGL_SURAT` + i + `" type="text" class="form-control TGL_SURAT text_input" value="` + response[i].TGL_SURAT + `" readonly></td>
						<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value="` + response[i].TOTAL + `" id="TOTAL` + i + `" type="text" class="form-control TOTAL rightJustified text-primary" readonly><input type="hidden" name="NO_ID[]" id"NO_ID` + i + `" value='0'  ></td>
						<td>
							<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
								<i class="fa fa-fw fa-trash"></i>
							</button>
						</td>
					</tr>`
				}
				idrow = i;
				$('#detail').html(html);
				hitung();
				$(".TOTAL").each(function() {
					$(this).autoNumeric('init', {
						aSign: '<?php echo ''; ?>',
						vMin: '-999999999.99'
					});
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				idrow = 0;
				var html = `<tr>
					<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
					<td><input name="NO_SURAT[]" id="NO_SURAT0" type="text" class="form-control NO_SURAT text_input" readonly></td>
					<td><input name="INVOICE[]" id="INVOICE0" type="text" class="form-control INVOICE text_input" readonly></td>
					<td><input name="KODEC[]" id="KODEC0" type="text" class="form-control KODEC text_input" readonly></td>
					<td><input name="NAMAC[]" id="NAMAC0" type="text" class="form-control NAMAC text_input" readonly></td>
					<td><input name="TGL_FKTR[]" id="TGL_FKTR0" type="text" class="form-control TGL_FKTR text_input" readonly></td>
					<td><input name="TGL_SURAT[]" id="TGL_SURAT0" type="text" class="form-control TGL_SURAT text_input" readonly></td>
					<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value=0 id="TOTAL0" type="text" class="form-control TOTAL rightJustified text-primary" readonly><input type="hidden" name="NO_ID[]" id"NO_ID0" value='0'  ></td>
					<td>
						<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
							<i class="fa fa-fw fa-trash"></i>
						</button>
					</td>
				</tr>`
				$('#detail').html(html);
				hitung();
				console.log('Error ajax getjlpiu');
			}
		});
	}

	function cekTotalBankJlpiu()
	{
		var jum_rbank = <?=$rowh->JUM_RBANK ?>;
		var totdetail = parseFloat($('#TTOTAL').val().replace(/,/g, ''));
		if (jum_rbank!=0 && jum_rbank!=totdetail)
		{
			$('#JUM_RBANK').css({"color":"white", "background-color": "red"});
			$('#TTOTAL').css({"background-color": "red"});
            setTimeout(function() {
				$('#JUM_RBANK').css({"color":"black", "background-color": "#eaecf4"});
				$('#TTOTAL').css({"background-color": "#eaecf4"});
            }, 3000)
			alert("Total bank dan penjualan tidak sama!");
			return 1;
		}
		return 0;
	}
	
	function simpan()
	{
		getJlpiu();
		hitung();
		if (cekTotalBankJlpiu()==1) return false;
		return true;
	}
</script>
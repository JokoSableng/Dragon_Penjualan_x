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
	<form id="pengajuanbmpk" name="pengajuanbmpk" action="<?php echo base_url('admin/Transaksi_PengajuanBMPK/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
							<label class="label">Tanggal </label>
						</div>
						<div class="input-group col-md-2">
							<input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																					echo $_POST["TGL"];
																																				} else echo date('d-m-Y'); ?>" onclick="select()">
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
								<th width="100px">Kode Lang</th>
								<th width="150px">Nama Lang</th>
								<th width="100px">Wilayah</th>
								<th width="150px">BMPK Lama</th>
								<th width="150px">BMPK Baru</th>
								<th width="150px">Metode Bayar</th>
								<th width="150px">Periode</th>
								<th width="150px">Alasan</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td>
									<div class='input-group'>
										<select value="" class="js-example-responsive-kodec form-control KODEC0" name="KODEC[]" id="KODEC0" onchange="kodec(this.id)" onfocusout="hitung()" required></select>
									</div>
								</td>
								<td><input name="NAMAC[]" id="NAMAC0" type="text" class="form-control NAMAC text_input" readonly></td>
								<td><input name="WILAYAH[]" id="WILAYAH0" type="text" class="form-control WILAYAH text_input" readonly></td>
								<td><input name="BMPKL[]" id="BMPKL0" type="text" class="form-control BMPKL text_input" readonly></td>
								<td><input name="BMPKB[]" id="BMPKB0" type="text" class="form-control BMPKB text_input"></td>
								<td><input name="MET_BYR[]" id="MET_BYR0" type="text" class="form-control MET_BYR text_input"></td>
								<td><input name="PERIODE2[]" id="PERIODE20" type="text" class="form-control PERIODE2 text_input"></td>
								<td><input name="NOTES[]" id="NOTES0" type="text" class="form-control NOTES text_input"></td>
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
							<td></td>
							<td></td>
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
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {}
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

	function hitung() {}

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
		var td10 = x.insertCell(9);

		var kodec0 = "<div class='input-group'><select class='js-example-responsive-kodec form-control KODEC' name='KODEC[]' value='' id=KODEC" + idrow + " onchange='kodec(this.id)' onfocusout='hitung()' required></select></div>";
		var kodec = kodec0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control text_input' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = kodec;
		td3.innerHTML = "<input name='NAMAC[]' id=NAMAC" + idrow + " type='text' class='form-control NAMAC text_input' readonly>";
		td4.innerHTML = "<input name='WILAYAH[]' id=WILAYAH" + idrow + " type='text' class='form-control WILAYAH text_input' readonly>";
		td5.innerHTML = "<input name='BMPKL[]' id=BMPKL" + idrow + " type='text' class='form-control BMPKL text_input' readonly>";
		td6.innerHTML = "<input name='BMPKB[]' id=BMPKB" + idrow + " type='text' class='form-control BMPKB text_input'>";
		td7.innerHTML = "<input name='MET_BYR[]' id=MET_BYR" + idrow + " type='text' class='form-control MET_BYR text_input'>";
		td8.innerHTML = "<input name='PERIODE2[]' id=PERIODE2" + idrow + " type='text' class='form-control PERIODE2 text_input'>";
		td9.innerHTML = "<input name='NOTES[]' id=NOTES" + idrow + " type='text' class='form-control NOTES text_input'>";
		td10.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {}
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		select_kodec();
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
		select_kodec();
	});

	function select_kodec() {
		$('.js-example-responsive-kodec').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_PengajuanBMPK/getDataAjax_kodec') ?>",
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
			placeholder: 'Pilih Kodecu',
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
	var wilayah = '';
	var bmpkl = '';

	function formatSelection_kodec(repo_kodec) {
		namac = repo_kodec.NAMAC;
		wilayah = repo_kodec.WILAYAH;
		bmpkl = repo_kodec.BMPKL;
		return repo_kodec.text;
	}

	function kodec(xxx) {
		var qqq = xxx.substring(5, 9);
		$('#NAMAC' + qqq).val(namac);
		$('#WILAYAH' + qqq).val(wilayah);
		$('#BMPKL' + qqq).val(bmpkl);
		console.log('Kodec :' + qqq);
	}
</script>
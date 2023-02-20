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
		width: 400px !important;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Input <?php echo $this->session->userdata['judul']; ?>
	</div>
	<!-- <?= $this->session->userdata['kdmts']; ?> -->
	<form id="stokopname" name="stokopname" action="<?php echo base_url('admin/Transaksi_Stok_Opname/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="input-group col-md-3">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value='' readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl </label>
						</div>
						<div class="col-md-3">
							<input type="text" class="date form-control" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
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
								<th width="150px">Kode Barang</th>
								<th width="150px">Nama Barang</th>
								<th width="120px">Warna</th>
								<th width="100px">Size</th>
								<th width="100px">Golongan</th>
								<th width="120px">Lusin</th>
								<th width="120px">Pair</th>
								<th width="120px">Harga Lusin</th>
								<th width="120px">Harga Pair</th>
								<th width="120px">Total</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td>
									<div class="input-group">
										<select class="js-example-responsive-kd_brg form-control KD_BRG0" name="KD_BRG[]" id="KD_BRG0" onchange="kd_brg(this.id)" onfocusout="hitung()" required></select>
									</div>
								</td>
								<td><input name="NA_BRG[]" id="NA_BRG0" type="text" class="form-control NA_BRG" readonly></td>
								<td><input name="WARNA[]" id="WARNA0" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE0" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOL[]" id="GOL0" type="text" class="form-control GOL" maxlength="1" readonly></td>
								<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" value="0" id="QTY0" type="text" class="form-control QTY rightJustified text-primary"></td>
								<td><input name="QTYP[]" onclick="select()" onkeyup="hitung()" value="0" id="QTYP0" type="text" class="form-control QTYP rightJustified text-primary"></td>
								<td><input name="KOREKSI[]" onclick="select()" onkeyup="hitung()" value="0" id="KOREKSI0" type="text" class="form-control KOREKSI rightJustified text-primary" readonly></td>
								<td><input name="KOREKSIP[]" onclick="select()" onkeyup="hitung()" value="0" id="KOREKSIP0" type="text" class="form-control KOREKSIP rightJustified text-primary" readonly></td>
								<td><input name="TOTAL[]" onkeyup="hitung()" value="0" id="TOTAL0" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
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
							<td></td>
							<td></td>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<br><br>
		<!--tab-->
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-4">
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<!-- <button type="submit" hidden class="btn btn-success simpan"><i class="fa fa-save"></i> Save</button> -->
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

<script type="text/javascript">
	$(document).ready(function() {
		$('#modal_no_do').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" +
				"<'row'<'col-md-6'f><'col-md-6'l>>" +
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {
			$('input[type=search]').val('').keyup();
		});
	});
</script>

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
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#QTYP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#KOREKSI" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#KOREKSIP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
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
		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var lusin = parseFloat($('#QTY' + i).val().replace(/,/g, ''));
			var pair = parseFloat($('#QTYP' + i).val().replace(/,/g, ''));
			var koreksi = parseFloat($('#KOREKSI' + i).val().replace(/,/g, ''));
			var koreksip = parseFloat($('#KOREKSIP' + i).val().replace(/,/g, ''));

			var jumlah = (lusin * koreksi) + (pair * koreksip);

			if (isNaN(jumlah)) jumlah = 0;
			$('#TOTAL' + i).val(numberWithCommas(jumlah));
			$('#TOTAL' + i).autoNumeric('update');
		};
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
		var td10 = x.insertCell(9);
		var td11 = x.insertCell(10);
		var td12 = x.insertCell(11);

		var kd_brg0 = "<div class='input-group'><select class='js-example-responsive-kd_brg form-control KD_BRG' name='KD_BRG[]' id=KD_BRG" + idrow + " onchange='kd_brg(this.id)' onfocusout='hitung()' required></select></div>";
		var kd_brg = kd_brg0;


		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = kd_brg;
		td3.innerHTML = "<input name='NA_BRG[]' id=NA_BRG" + idrow + " type='text' class='form-control NA_BRG' readonly>";
		td4.innerHTML = "<input name='WARNA[]' id=WARNA" + idrow + " type='text' class='form-control WARNA' readonly>";
		td5.innerHTML = "<input name='SIZE[]' id=SIZE" + idrow + " type='text' class='form-control SIZE' readonly>";
		td6.innerHTML = "<input name='GOL[]' onclick='select()' id=GOL" + idrow + " type='text' class='form-control GOL' maxlength='1' readonly>";
		td7.innerHTML = "<input name='QTY[]' onclick='select()' onchange='hitung()' value='0' id=QTY" + idrow + " type='text' class='form-control QTY rightJustified text-primary'>";
		td8.innerHTML = "<input name='QTYP[]' onclick='select()' onchange='hitung()' value='0' id=QTYP" + idrow + " type='text' class='form-control QTYP rightJustified text-primary'>";
		td9.innerHTML = "<input name='KOREKSI[]' onclick='select()' onchange='hitung()' value='0' id=KOREKSI" + idrow + " type='text' class='form-control KOREKSI rightJustified text-primary' readonly>";
		td10.innerHTML = "<input name='KOREKSIP[]' onclick='select()' onchange='hitung()' value='0' id=KOREKSIP" + idrow + " type='text' class='form-control KOREKSIP rightJustified text-primary' readonly>";
		td11.innerHTML = "<input name='TOTAL[]' onkeyup='select()' value='0' id=TOTAL" + idrow + " type='text' class='form-control TOTAL rightJustified text-primary' readonly>";
		td12.innerHTML = "<input type='hidden' value='0' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
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
			$("#KOREKSI" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#KOREKSIP" + i.toString()).autoNumeric('init', {
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
		}

		idrow++;
		nomor();
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
		select_kd_brg();
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
		select_kd_brg();
		select_kodec();
	});

	function select_kd_brg() {
		$('.js-example-responsive-kd_brg').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_Stok_Opname/getDataAjax_Brg') ?>",
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
			placeholder: 'Pilih Barang',
			minimumInputLength: 0,
			templateResult: format_kd_brg,
			templateSelection: formatSelection_kd_brg
		});
	}

	function format_kd_brg(repo_kd_brg) {
		if (repo_kd_brg.loading) {
			return repo_kd_brg.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_kd_brg.KD_BRG);
		return $container;
	}
	var na_brg = '';
	var warna = '';
	var size = '';
	var gol = '';
	var koreksi = '';
	var koreksip = '';

	function formatSelection_kd_brg(repo_kd_brg) {
		na_brg = repo_kd_brg.NA_BRG;
		warna = repo_kd_brg.WARNA;
		size = repo_kd_brg.SIZE;
		gol = repo_kd_brg.GOL;
		koreksi = repo_kd_brg.KOREKSI;
		koreksip = repo_kd_brg.KOREKSIP;
		return repo_kd_brg.text;
	}

	function kd_brg(x) {
		var q = x.substring(6, 10);
		$('#NA_BRG' + q).val(na_brg);
		$('#WARNA' + q).val(warna);
		$('#SIZE' + q).val(size);
		$('#GOL' + q).val(gol);
		$('#KOREKSI' + q).val(koreksi);
		$('#KOREKSIP' + q).val(koreksip);
		console.log('gol ' + gol);
	}
</script>
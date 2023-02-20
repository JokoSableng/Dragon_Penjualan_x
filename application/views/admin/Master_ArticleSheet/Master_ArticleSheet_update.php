<style>
	#myInput {
		background-image: url('<?php echo base_url() ?>assets/img/search-icon-blue.png');
		background-position: 10px 12px;
		background-repeat: no-repeat;
		width: 100%;
		padding: 10px 20px 10px 40px;
		border: 1px solid #ddd;
		margin-bottom: 10px;
	}

	.pd-1 {
		padding: 1px;
	}

	#myTable {
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #ddd;
	}

	#myTable th,
	#myTable td {
		text-align: left;
	}

	#myTable tr {
		border-bottom: 1px solid #ddd;
	}

	#myTable tr.header,
	#myTable tr:hover {
		background-color: #1cc88a;
	}

	input[type=text]:focus {
		width: 100%;
	}

	table {
		table-layout: fixed;
	}

	table th,
	table td {
		overflow: hidden;
	}

	.table>thead>tr>th {
		background-color: #1cc88a;
		top: 0;
		position: sticky !important;
		z-index: 999;
		text-align: center;
		color: black;
		font-weight: bold;
	}

	.rightJustified {
		text-align: right;
	}

	.total {
		font-weight: bold;
		color: blue;
	}

	.bodycontainer {
		width: 1280px;
		max-height: 300PX;
		margin: 0;
		overflow-y: auto;
	}

	.table-scrollable {
		margin: 0;
		padding: 0;
	}

	.modal-bodys {
		max-height: 250px;
		overflow-y: auto;
	}

	.label {
		font-weight: bold;
		color: black;
	}

	.label_header {
		font-weight: bold;
		color: black;
		text-align: center;
	}

	.text_input {
		color: black;
	}

	.number_input {
		color: black;
		text-align: right;
	}

	.number_total {
		font-weight: bold;
		color: black;
		text-align: right;
	}

	.btn_back {
		color: black;
	}

	.btn_back:hover {
		transition: 0.4s;
		color: white;
	}

	.btn_cancel {
		color: black;
	}

	.btn_cancel:hover {
		transition: 0.4s;
		color: white;
	}

	.btn_save {
		background-color: #1cc88a;
		color: black;
	}

	.btn_save:hover {
		transition: 0.4s;
		color: white;
	}

	/* Style tab */
	.tab {
		overflow: hidden;
		border: 1px solid #ccc;
		background-color: #1cc88a;
	}

	.tab button {
		background-color: inherit;
		float: left;
		border: none;
		outline: none;
		cursor: pointer;
		padding: 14px 16px;
		transition: 0.4s;
	}

	.tab button:hover {
		background-color: #1cc88a;
		transition: 0.4s;
	}

	.tab button.active {
		background-color: #1cc88a;
		color: white;
	}

	.tabcontent {
		display: none;
		padding: 6px 12px;
	}

	.alert-container {
		background-color: #1cc88a;
		color: black;
		font-weight: bolder;
	}

	.label {
		color: black;
		font-weight: bold;
	}

	.text_input {
		font-size: small;
		color: black;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update Master Artikel Sheet
	</div>
	<br>
	<form id="articlesheet" name="articlesheet" action="<?php echo base_url('admin/Master_ArticleSheet/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Artikel</label>
				</div>
				<div class="col-md-3">
					<input type="hidden" id="NO_ID" name="NO_ID" class="form-control text_input NO_ID" value="<?= $NO_ID ?>" readonly>
					<input type="text" id="KD_BRG" name="KD_BRG" class="form-control text_input KD_BRG" value="<?= $KD_BRG ?>" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Type</label>
				</div>
				<div class="col-md-3 ">
					<input type="text" id="JENIS" name="JENIS" class="form-control text_input JENIS" value="<?= $JENIS ?>">
				</div>
				<div class="col-md-1">
					<label class="label">KIK/MFG</label>
				</div>
				<div class="col-md-3 ">
					<input type="text" id="KIK" name="KIK" class="form-control text_input KIK" value="<?= $KIK ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Emboss</label>
				</div>
				<div class="col-md-3">
					<input type="text" id="EMBOSS" name="EMBOSS" class="form-control text_input EMBOSS" value="<?= $EMBOSS ?>">
				</div>
				<div class="col-md-1">
					<label class="label">Tebal</label>
				</div>
				<div class="col-md-3 ">
					<input name="TEBAL" id="TEBAL" type="text" class="form-control num TEBAL text_input" value="<?php echo number_format($TEBAL, 2, '.', ','); ?>">
				</div>
				<div class="col-md-1">
					<label class="label">Lebar</label>
				</div>
				<div class="col-md-3 ">
					<input name="LEBAR" id="LEBAR" type="text" class="form-control num LEBAR text_input" value="<?php echo number_format($LEBAR, 2, '.', ','); ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Roll</label>
				</div>
				<div class="col-md-3">
					<input name="ROLL" id="ROLL" type="text" class="form-control num ROLL text_input" value="<?php echo number_format($ROLL, 2, '.', ','); ?>">
				</div>
				<div class="col-md-1">
					<label class="label">Kode Warna</label>
				</div>
				<div class="col-md-3 ">
					<input type="text" id="KD_WARNA" name="KD_WARNA" class="form-control text_input KD_WARNA" value="<?= $KD_WARNA ?>">
				</div>
				<div class="col-md-1">
					<label class="label">Warna</label>
				</div>
				<div class="col-md-3 ">
					<input type="text" id="WARNA" name="WARNA" class="form-control text_input WARNA" value="<?= $WARNA ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Size</label>
				</div>
				<div class="col-md-3">
					<input type="text" id="SIZE" name="SIZE" class="form-control text_input SIZE" value="<?= $SIZE ?>">
				</div>
				<div class="col-md-1">
					<label class="label">Golong</label>
				</div>
				<div class="col-md-3 ">
					<input type="text" id="GOL" name="GOL" class="form-control text_input GOL" value="<?= $GOL ?>">
				</div>
				<div class="col-md-1">
					<label class="label">Satuan</label>
				</div>
				<div class="col-md-3 ">
					<input type="text" id="SATUAN" name="SATUAN" class="form-control text_input SATUAN" value="<?= $SATUAN ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Uraian</label>
				</div>
				<div class="col-md-3">
					<input type="text" id="NA_BRG" name="NA_BRG" class="form-control text_input NA_BRG" value="<?= $NA_BRG ?>">
				</div>
				<div class="col-md-1">
					<label class="label">Uraian 1</label>
				</div>
				<div class="col-md-3 ">
					<input type="text" id="KET" name="KET" class="form-control text_input KET" value="<?= $KET ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Harga Lusin</label>
				</div>
				<div class="col-md-3">
					<input name="HARGA" id="HARGA" type="text" class="form-control num HARGA text_input" value="<?php echo number_format($HARGA, 2, '.', ','); ?>">
				</div>
				<div class="col-md-1">
					<label class="label">Harga Pair</label>
				</div>
				<div class="col-md-3 ">
					<input name="HARGAP" id="HARGAP" type="text" class="form-control num HARGAP text_input" value="<?php echo number_format($HARGAP, 2, '.', ','); ?>">
				</div>
			</div>
		</div>
		<br>
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

<script>
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('needs-validation');
			// Loop over them and prevent submission
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

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function fnum() {
		$(".num").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$('.num').autoNumeric('update');
	};

	$(document).ready(function() {
		fnum();
		$('body').on('keyup', 'input.num', function() {
			if (event.which != 190) {
				if (event.which >= 37 && event.which <= 40) return;
			}
			this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			hitung();
		});
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		});
	});

	function hitung() {}
</script>
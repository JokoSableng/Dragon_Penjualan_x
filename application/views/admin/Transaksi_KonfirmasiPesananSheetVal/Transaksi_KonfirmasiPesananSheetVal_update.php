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
		<i class="fas fa-university"></i> Update Transaksi Konfirmasi Pesanan Sheet Val
	</div>
	<br>
	<form id="konfirmasipesanansheetval" name="konfirmasipesanansheetval" action="<?php echo base_url('admin/Transaksi_KonfirmasiPesananSheetVal/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">No PI</label>
				</div>
				<div class="col-md-3">
					<input type="hidden" id="NO_ID" name="NO_ID" class="form-control text_input NO_ID" value="<?= $NO_ID ?>" readonly>
					<input type="text" id="NO_BUKTI" name="NO_BUKTI" class="form-control text_input NO_BUKTI" value="<?= $NO_BUKTI ?>" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Plafon</label>
				</div>
				<div class="col-md-3">
					<input name="MAXKRE" id="MAXKRE" type="text" class="form-control num MAXKRE text_input" value="<?php echo number_format($MAXKRE, 2, '.', ','); ?>" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Piutang</label>
				</div>
				<div class="col-md-3">
					<input name="PIUTANG" id="PIUTANG" type="text" class="form-control num PIUTANG text_input" value="<?php echo number_format($PIUTANG, 2, '.', ','); ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">WIP</label>
				</div>
				<div class="col-md-3">
					<input name="WIP" id="WIP" type="text" class="form-control num WIP text_input" value="<?php echo number_format($WIP, 2, '.', ','); ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Stok</label>
				</div>
				<div class="col-md-3">
					<input name="STOK" id="STOK" type="text" class="form-control num STOK text_input" value="<?php echo number_format($STOK, 2, '.', ','); ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Po Lama</label>
				</div>
				<div class="col-md-3">
					<input type="text" id="PO_LAMA" name="PO_LAMA" class="form-control text_input PO_LAMA" value="<?= $PO_LAMA ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Selisih</label>
				</div>
				<div class="col-md-3">
					<input name="SELISIH" id="SELISIH" type="text" class="form-control num SELISIH text_input" value="<?php echo number_format($SELISIH, 2, '.', ','); ?>" readonly>
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
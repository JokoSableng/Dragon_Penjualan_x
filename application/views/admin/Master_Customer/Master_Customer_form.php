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
		background-color: #f1f1f1;
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
		background-color: #0063b2;
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
		background-color: #1b8526;
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
		background-color: #f1f1f1;
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
		background-color: #9ae6ae;
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

	.checkbox_container {
		width: 25px;
		height: 25px;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Input Master Customer
	</div>
	<form id="mastercustomer" name="mastercustomer" action="<?php echo base_url('admin/Master_Customer/input_aksi'); ?>" class="form-horizontal" method="post">
		<br><br>
		<div class="form-body">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Kode</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="KODEC" name="KODEC" class="form-control text_input KODEC" value="" required>
					</div>
					<div class="col-md-1">
						<label class="label">Lokal</label>
					</div>
					<div class="col-md-1">
						<input name="LOKAL" id="LOKAL" type="checkbox" value="0" class="checkbox_container" unchecked>
					</div>
					<div class="col-md-1">
						<label class="label">Export</label>
					</div>
					<div class="col-md-1">
						<input name="EXPORT" id="EXPORT" type="checkbox" value="0" class="checkbox_container" unchecked>
					</div>
					<div class="col-md-1"></div>
					<div class="col-md-1">
						<label class="label">Wilayah</label>
					</div>
					<div class="col-md-2">
						<input type="text" id="WILAYAH" name="WILAYAH" class="form-control text_input WILAYAH" value="">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Nama</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="NAMAC" name="NAMAC" class="form-control text_input NAMAC" value="">
					</div>
					<div class="col-md-1">
						<label class="label">Tax</label>
					</div>
					<div class="col-md-1 ">
						<input type="text" id="TAX" name="TAX" class="form-control text_input TAX" value="">
					</div>
					<div class="col-md-1">
						<label class="label">Npwp</label>
					</div>
					<div class="col-md-2 ">
						<input type="text" id="NPWP" name="NPWP" class="form-control text_input NPWP" value="">
					</div>
					<div class="col-md-1">
						<label class="label">Nik</label>
					</div>
					<div class="col-md-2 ">
						<input type="text" id="NIK" name="NIK" class="form-control text_input NIK" value="">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Alamat</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="ALAMAT" name="ALAMAT" class="form-control text_input ALAMAT" value="">
					</div>
					<div class="col-md-1">
						<label class="label">Kota</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="KOTA" name="KOTA" class="form-control text_input KOTA" value="">
					</div>
					<div class="col-md-1">
						<label class="label">Provinsi</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="PROVINSI" name="PROVINSI" class="form-control text_input PROVINSI" value="">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Alamat Kirim</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="ALAMAT2" name="ALAMAT2" class="form-control text_input ALAMAT2" value="">
					</div>
					<div class="col-md-1">
						<label class="label">Kota Kirim</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="KOTA2" name="KOTA2" class="form-control text_input KOTA2" value="">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Telp</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="TELPON1" name="TELPON1" class="form-control text_input TELPON1" value="">
					</div>
					<div class="col-md-1">
						<label class="label">Faximile</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="FAX" name="FAX" class="form-control text_input FAX" value="">
					</div>
					<div class="col-md-1">
						<label class="label">Contact P</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="KONTAK" name="KONTAK" class="form-control text_input KONTAK" value="">
					</div>
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


<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],
			order: true,
		});
	});
</script>

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

	function chekbox() {
		$(".LOKAL").each(function() {
			if ($(this).is(":checked") == true) {
				$(this).attr('value', '1');
			} else {
				$(this).prop('checked', true);
				$(this).attr('value', '0');
			}
		});
		$(".EXPOR").each(function() {
			if ($(this).is(":checked") == true) {
				$(this).attr('value', '1');
			} else {
				$(this).prop('checked', true);
				$(this).attr('value', '0');
			}
		});
	}

	$(document).ready(function() {
		fnum();
		$('body').on('keyup', 'input.num', function() {
			if (event.which != 190) {
				if (event.which >= 37 && event.which <= 40) return;
			}
			this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			hitung();
		});
	});
	$('input[type="checkbox"]').on('change', function() {
		this.value ^= 1;
		console.log(this.value)
	});
	$(".date").datepicker({
		'dateFormat': 'dd-mm-yy',
	});

	function hitung() {}
</script>
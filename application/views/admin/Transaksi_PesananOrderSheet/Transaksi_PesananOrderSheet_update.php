<?php
foreach ($pesananordersheet as $rowh) {
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
	<form id="pesananordersheet" name="pesananordersheet" action="<?php echo base_url('admin/Transaksi_PesananOrderSheet/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No SP </label>
						</div>
						<div class="input-group col-md-2">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value="<?php echo $rowh->NO_BUKTI ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl SP</label>
						</div>
						<div class="input-group col-md-2">
							<input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL, TRUE)); ?>" onclick="select()">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No DO </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_DO" id="NO_DO" name="NO_DO" type="text" value="<?php echo $rowh->NO_DO ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Tgl DO </label>
						</div>
						<div class="col-md-2">
							<input type="text" class="date form-control text_input" id="TGL_DO" name="TGL_DO" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_DO, TRUE)); ?>" onclick="select()">
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
								<th width="100px">Barang</th>
								<th width="100px">Uraian</th>
								<th width="100px">Warna</th>
								<th width="100px">Size</th>
								<th width="100px">No KIK</th>
								<th width="100px">Jml</th>
								<th width="100px">Harga</th>
								<th width="100px">Total</th>
								<th width="100px">Customer</th>
								<th width="100px">Nama</th>
								<th width="100px">Kota</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($pesananordersheet as $row) :
							?>
								<tr>
									<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
									<td>
										<div class="input-group">
											<select class="js-example-responsive-kd_brg form-control KD_BRG text_input" name="KD_BRG[]" id="KD_BRG<?php echo $no; ?>" onchange="kd_brg(this.id)">
												<option value="<?php echo $row->KD_BRG; ?>" selected id="KD_BRG<?php echo $no; ?>"><?php echo $row->KD_BRG; ?></option>
											</select>
										</div>
									</td>
									<td><input name="NA_BRG[]" id="NA_BRG<?php echo $no; ?>" value="<?= $row->NA_BRG ?>" type="text" class="form-control NA_BRG text_input" readonly></td>
									<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA text_input" readonly></td>
									<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE text_input" readonly></td>
									<td><input name="NO_KIK[]" id="NO_KIK<?php echo $no; ?>" value="<?= $row->NO_KIK ?>" type="text" class="form-control NO_KIK text_input"></td>
									<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" id="QTY<?php echo $no; ?>" value="<?php echo number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary"></td>
									<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary"></td>
									<td><input name="TOTAL[]" id="TOTAL<?php echo $no; ?>" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
									<td>
										<div class="input-group">
											<select class="js-example-responsive-kodec form-control KODEC text_input" name="KODEC[]" id="KODEC<?php echo $no; ?>" onchange="kodec(this.id)">
												<option value="<?php echo $row->KODEC; ?>" selected id="KODEC<?php echo $no; ?>"><?php echo $row->KODEC; ?></option>
											</select>
										</div>
									</td>
									<td><input name="NAMAC[]" id="NAMAC<?php echo $no; ?>" value="<?= $row->NAMAC ?>" type="text" class="form-control NAMAC text_input" readonly></td>
									<td><input name="KOTA[]" id="KOTA<?php echo $no; ?>" value="<?= $row->KOTA ?>" type="text" class="form-control KOTA text_input" readonly></td>
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
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TOTAL_QTY rightJustified text-primary font-weight-bold" id="TOTAL_QTY" name="TOTAL_QTY" value="<?php echo number_format($rowh->TOTAL_QTY, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td><input class="form-control TTOTAL rightJustified text-primary font-weight-bold" id="TTOTAL" name="TTOTAL" value="<?php echo number_format($rowh->TTOTAL, 2, '.', ','); ?>" readonly></td>
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
		$("#TTOTAL").autoNumeric('init', {
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
		}
		//MyModal SJ
		$('#mymodal_no_surat').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_no_surat', function() {
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
			$('#mymodal_no_surat').modal('toggle');
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
		var TTOTAL = 0;

		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var qty = parseFloat($('#QTY' + i).val().replace(/,/g, ''));
			var harga = parseFloat($('#HARGA' + i).val().replace(/,/g, ''));

			var total = qty * harga;
			if (isNaN(total)) total = 0;
			$('#TOTAL' + i).val(numberWithCommas(total));
			$('#TOTAL' + i).autoNumeric('update');
		};

		$(".QTY").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TOTAL_QTY += val;
		});
		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TTOTAL += val;
		});

		if (isNaN(TOTAL_QTY)) TOTAL_QTY = 0;
		if (isNaN(TTOTAL)) TTOTAL = 0;

		$('#TOTAL_QTY').val(numberWithCommas(TOTAL_QTY));
		$('#TTOTAL').val(numberWithCommas(TTOTAL));

		$("#TOTAL_QTY").autoNumeric('update');
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
		var td10 = x.insertCell(9);
		var td11 = x.insertCell(10);
		var td12 = x.insertCell(11);
		var td13 = x.insertCell(12);

		var kd_brg0 = "<div class='input-group'><select class='js-example-responsive-kd_brg form-control KD_BRG text_input' name='KD_BRG[]' id=KD_BRG" + idrow + " onchange='kd_brg(this.id)' onfocusout='hitung()' required></select></div>";
		var kd_brg = kd_brg0;

		var kodec0 = "<div class='input-group'><select class='js-example-responsive-kodec form-control KODEC text_input' name='KODEC[]' id=KODEC" + idrow + " onchange='kodec(this.id)' onfocusout='hitung()' required></select></div>";
		var kodec = kodec0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control text_input' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = kd_brg;
		td3.innerHTML = "<input name='NA_BRG[]' id=NA_BRG" + idrow + " type='text' class='form-control NA_BRG text_input' readonly>";
		td4.innerHTML = "<input name='WARNA[]' id=WARNA" + idrow + " type='text' class='form-control WARNA text_input' readonly>";
		td5.innerHTML = "<input name='SIZE[]' id=SIZE" + idrow + " type='text' class='form-control SIZE text_input' readonly>";
		td6.innerHTML = "<input name='NO_KIK[]' id=NO_KIK" + idrow + " type='text' class='form-control NO_KIK text_input'>";
		td7.innerHTML = "<input name='HARGA[]' onclick='select()' value='0' id=HARGA" + idrow + " type='text' class='form-control HARGA rightJustified text-primary'>";
		td8.innerHTML = "<input name='QTY[]' onclick='select()' onchange='hitung()' value='0' id=QTY" + idrow + " type='text' class='form-control QTY rightJustified text-primary'>";
		td9.innerHTML = "<input name='TOTAL[]' onclick='select()' onchange='hitung()' value='0' id=TOTAL" + idrow + " type='text' class='form-control TOTAL rightJustified text-primary' readonly>";
		td10.innerHTML = kodec;
		td11.innerHTML = "<input name='NAMAC[]' id=NAMAC" + idrow + " type='text' class='form-control NAMAC text_input' readonly>";
		td12.innerHTML = "<input name='KOTA[]' id=KOTA" + idrow + " type='text' class='form-control KOTA text_input' readonly>";
		td13.innerHTML = "<input type='hidden' value='0' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#HARGA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#QTY" + i.toString()).autoNumeric('init', {
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
		select_kodec();
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
				url: "<?= base_url('admin/Transaksi_PesananOrderSheet/getDataAjax_Brg') ?>",
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
			"<div class='select2-result-repository clearfix text_input'>" +
			"<div class='select2-result-repository__title text_input'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_kd_brg.KD_BRG);
		return $container;
	}
	var na_brg = '';
	var warna = '';
	var size = '';

	function formatSelection_kd_brg(repo_kd_brg) {
		na_brg = repo_kd_brg.NA_BRG;
		warna = repo_kd_brg.WARNA;
		size = repo_kd_brg.SIZE;
		return repo_kd_brg.text;
	}

	function kd_brg(x) {
		var q = x.substring(6, 10);
		$('#NA_BRG' + q).val(na_brg);
		$('#WARNA' + q).val(warna);
		$('#SIZE' + q).val(size);
		console.log('Na Brg ' + na_brg);
	}

	function select_kodec() {
		$('.js-example-responsive-kodec').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_PesananOrderSheet/getDataAjax_Cust') ?>",
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
	var kota = '';

	function formatSelection_kodec(repo_kodec) {
		namac = repo_kodec.NAMAC;
		kota = repo_kodec.KOTA;
		return repo_kodec.text;
	}

	function kodec(xx) {
		var qq = xx.substring(5, 12);
		$('#NAMAC' + qq).val(namac);
		$('#KOTA' + qq).val(kota);
		console.log(namac);
	}
</script>
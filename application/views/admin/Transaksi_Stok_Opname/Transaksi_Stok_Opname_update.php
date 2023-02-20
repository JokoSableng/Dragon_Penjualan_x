<?php
	foreach ($stok_opname as $rowh) {};
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
	#myTable td { text-align: left; padding: 5px; }
	#myTable tr { border-bottom: 1px solid #ddd; }
	#myTable tr.header,
	#myTable tr:hover { background-color: #f1f1f1; }
	input[type=text]:focus { width: 100%; }
	table {	table-layout: fixed; }
	table th {color: black; text-align: center;}
	table td { overflow: hidden; }
	.label {color: black; font-weight: bold;}
	.rightJustified { text-align: right; }
	.total { font-size: 14px; font-weight: bold; color: blue; }
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
	.table-scrollable {	margin: 0; padding: 0; }
	.modal-bodys { max-height: 250px; overflow-y: auto; }
	.select2-dropdown {	width: 500px !important; }
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksi_stok_opname" name="transaksi_stok_opname" action="<?php echo base_url('admin/Transaksi_Stok_Opname/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Opname </label>
						</div>
						<div class="input-group col-md-3">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NOSJ" id="NOSJ" name="NOSJ" type="text" value="<?php echo $rowh->NOSJ ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl </label>
						</div>
						<div class="col-md-3">
							<input 
								type="text" 
								class="date form-control TGLCI" 
								id="TGLCI" 
								name="TGLCI" 
								data-date-format="dd-mm-yyyy" 
								value="<?php echo date('d-m-Y', strtotime($rowh->TGLCI, TRUE)); ?>"
								onclick="select()" 
							>
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
								<th width="150px">Article</th>
								<th width="120px">Warna</th>
								<th width="100px">Size</th>
								<th width="100px">Golongan</th>
								<th width="120px">Lusin</th>
								<th width="120px">Pair</th>
								<th width="120px">Harga</th>
								<th width="120px">Jumlah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
                        <?php
							$no = 0;
							foreach ($stok_opname as $row) : 
						?>
							<tr>
                                <td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td>
									<div class="input-group">
										<select class="js-example-responsive-kd_brg form-control KD_BRG" name="KD_BRG[]" id="KD_BRG<?php echo $no; ?>" onchange="kd_brg(this.id)" required>
											<option value="<?php echo $row->KD_BRG; ?>" selected id="KD_BRG<?php echo $no; ?>"><?php echo $row->KD_BRG; ?></option>
										</select>
									</div>
								</td>
								<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOLONG[]" id="GOLONG<?php echo $no; ?>" value="<?= $row->GOLONG ?>" type="text" class="form-control GOLONG" maxlength="1" readonly></td>
								<td><input name="LUSIN[]" onclick="select()" onkeyup="hitung()" id="LUSIN<?php echo $no; ?>" value="<?php echo number_format($row->LUSIN, 2, '.', ','); ?>" type="text" class="form-control LUSIN rightJustified text-primary"></td>
								<td><input name="PAIR[]" onclick="select()" onkeyup="hitung()" id="PAIR<?php echo $no; ?>" value="<?php echo number_format($row->PAIR, 2, '.', ','); ?>" type="text" class="form-control PAIR rightJustified text-primary"></td>
								<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary"></td>
								<td><input name="JUMLAH[]" onkeyup="hitung()" id="JUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->JUMLAH, 2, '.', ','); ?>" type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>
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
							<td><input class="form-control TLUSIN rightJustified text-primary font-weight-bold" id="TLUSIN" name="TLUSIN" value="<?php echo number_format($row->TLUSIN, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TPAIR rightJustified text-primary font-weight-bold" id="TPAIR" name="TPAIR" value="<?php echo number_format($row->TPAIR, 2, '.', ','); ?>" readonly></td>
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
				<div class="col-md-4">
					<button type="button"  onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
				<div class="col-md-3"></div>
				<div class="col-md-1">
					<label class="label">Sub Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TJUMLAH rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->TJUMLAH, 2, '.', ','); ?>" id="TJUMLAH" name="TJUMLAH" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-7"></div>
				<div class="col-md-1">
					<label class="label">Disc </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DISC rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($row->DISC, 2, '.', ','); ?>" id="DISC" name="DISC">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
			<div class="col-md-7"></div>
			<div class="col-md-1">
				<label class="label">Nett </label>
			</div>
			<div class="col-md-2 ">
				<input class="form-control NETT rightJustified text-success font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->NETT, 2, '.', ','); ?>" id="NETT" name="NETT" readonly>
			</div>
		</div> -->
		<div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group cxx">
						<button type="submit"  class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
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
		$("#TLUSIN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TPAIR").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJUMLAH").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DISC").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#NETT").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#LUSIN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#PAIR" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARGA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {
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
		var TLUSIN = 0;
		var TPAIR = 0;
		var TJUMLAH = 0;
		var DISC = parseFloat($('#DISC').val().replace(/,/g, ''));

		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var lusin = parseFloat($('#LUSIN'+i).val().replace(/,/g, ''));
			var pair = parseFloat($('#PAIR'+i).val().replace(/,/g, ''));
			var harga = parseFloat($('#HARGA'+i).val().replace(/,/g, ''));

			var jumlah = ( lusin + pair) * harga;
			if(isNaN(jumlah)) jumlah = 0;
			$('#JUMLAH'+i).val(numberWithCommas(jumlah));
			$('#JUMLAH'+i).autoNumeric('update');
		};
		$(".LUSIN").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TLUSIN+=val;
		});
		$(".PAIR").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TPAIR+=val;
		});
		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TJUMLAH+=val;
		});

		var NETT = TJUMLAH - DISC;

		if(isNaN(TLUSIN)) TLUSIN = 0;
		if(isNaN(TPAIR)) TPAIR = 0;
		if(isNaN(TJUMLAH)) TJUMLAH = 0;
		if(isNaN(NETT)) NETT = 0;

		$('#TLUSIN').val(numberWithCommas(TLUSIN));
		$('#TPAIR').val(numberWithCommas(TPAIR));
		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));
		$('#NETT').val(numberWithCommas(NETT));

		$("#TLUSIN").autoNumeric('update');
		$('#TPAIR').autoNumeric('update');
		$('#TJUMLAH').autoNumeric('update');
		$('#NETT').autoNumeric('update');
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

		var akun0 = "<div class='input-group'><select class='js-example-responsive form-control KD_BRG' name='KD_BRG[]' id=KD_BRG" + idrow + " onchange='kd_brg(this.id)' onfocusout='hitung()' required></select></div>";
		var akun = akun0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = akun;
		td3.innerHTML = "<input name='WARNA[]' id=WARNA0" + idrow + " type='text' class='form-control WARNA' readonly>";
		td4.innerHTML = "<input name='SIZE[]' id=SIZE0" + idrow + " type='text' class='form-control SIZE' readonly>";
		td5.innerHTML = "<input name='GOLONG[]' id=GOLONG0" + idrow + " type='text' class='form-control GOLONG' maxlength='1' readonly>";
		td6.innerHTML = "<input name='LUSIN[]' onclick='select()' onkeyup='hitung()' value='0' id=LUSIN" + idrow + " type='text' class='form-control LUSIN rightJustified text-primary'>";
		td7.innerHTML = "<input name='PAIR[]' onclick='select()' onkeyup='hitung()' value='0' id=PAIR" + idrow + " type='text' class='form-control PAIR rightJustified text-primary'>";
		td8.innerHTML = "<input name='HARGA[]' onclick='select()' onkeyup='hitung()' value='0' id=HARGA" + idrow + " type='text' class='form-control HARGA rightJustified text-primary'>";
		td9.innerHTML = "<input name='JUMLAH[]' onkeyup='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary' readonly>";
		td10.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#LUSIN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#PAIR" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARGA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {
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
		select2x();
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
			placeholder: 'Pilih Article',
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

	function formatSelection_kd_brg(repo_kd_brg) {
		na_brg = repo_kd_brg.NA_BRG;
		warna = repo_kd_brg.WARNA;
		size = repo_kd_brg.SIZE;
		gol = repo_kd_brg.GOL;
		return repo_kd_brg.text;
	}

	function kd_brg(x) {
		var q = x.substring(6, 10);
		$('#NA_BRG' + q).val(na_brg);
		$('#WARNA' + q).val(warna);
		$('#SIZE' + q).val(size);
		$('#GOL' + q).val(gol);
		console.log('gol '+gol);
	}

	function select_kodec() {
		$('.js-example-responsive-kodec').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_Stok_Opname/getDataAjax_Cust') ?>",
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
			placeholder: 'Pilih Kodecus',
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
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
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
		var qq = xx.substring(5, 9);
		$('#NAMAC' + qq).val(namac);
		$('#KOTA' + qq).val(kota);
		console.log(qq+namac);
	}

</script>
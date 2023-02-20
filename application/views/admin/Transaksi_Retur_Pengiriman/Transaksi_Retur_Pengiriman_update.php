<?php
	foreach ($retur_pengiriman as $rowh) {};
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
	<form id="transaksi_retur_pengiriman" name="transaksi_retur_pengiriman" action="<?php echo base_url('admin/Transaksi_Retur_Pengiriman/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="col-md-2">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value="<?php echo $rowh->NO_BUKTI ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl </label>
						</div>
						<div class="col-md-2">
							<input 
								type="text" 
								class="date form-control TGL" 
								id="TGL" 
								name="TGL" 
								data-date-format="dd-mm-yyyy" 
								value="<?php echo date('d-m-Y', strtotime($rowh->TGL, TRUE)); ?>"
								onclick="select()" 
							>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2 input-group">
							<input name="KODEC" id="KODEC" value="<?php echo $rowh->KODEC ?>" maxlength="30" type="text" class="form-control text_input KODEC" onkeypress="return tabE(this,event)" readonly>
							<span class="input-group-btn">
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_customer" data-toggle="modal" href="#lupno_so" ><i class="fa fa-search"></i></a>
							</span>
						</div>
						<div class="col-md-1">
							<label class="label">Nama </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NAMAC" id="NAMAC" name="NAMAC" type="text" value="<?php echo $rowh->NAMAC ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Kode Rayon </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KODERAY" id="KODERAY" name="KODERAY" type="text" value="<?php echo $rowh->KODERAY ?>" readonly>
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
								<th width="150px">Barang</th>
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
							foreach ($retur_pengiriman as $row) : 
						?>
							<tr>
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td>
									<div class="input-group">
										<select class="js-example-responsive-kd_brg form-control KD_BRG" name="KD_BRG[]" id="KD_BRG<?php echo $no; ?>" onchange="article(this.id)" required>
											<option value="<?php echo $row->KD_BRG; ?>" selected id="KD_BRG<?php echo $no; ?>"><?php echo $row->KD_BRG; ?></option>
										</select>
									</div>
								</td>
								<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOL[]" id="GOL<?php echo $no; ?>" value="<?= $row->GOL ?>" type="text" class="form-control GOL" maxlength="1" readonly></td>
								<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" id="QTY<?php echo $no; ?>" value="<?php echo number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary"></td>
								<td><input name="QTYP[]" onclick="select()" onkeyup="hitung()" id="QTYP<?php echo $no; ?>" value="<?php echo number_format($row->QTYP, 2, '.', ','); ?>" type="text" class="form-control QTYP rightJustified text-primary"></td>
								<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary"></td>
								<td><input name="TOTAL[]" onkeyup="hitung()" id="TOTAL<?php echo $no; ?>" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
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
							<td><input class="form-control TOTAL_QTY rightJustified text-primary font-weight-bold" id="TOTAL_QTY" name="TOTAL_QTY" value="<?php echo number_format($row->TOTAL_QTY, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TOTAL_QTYP rightJustified text-primary font-weight-bold" id="TOTAL_QTYP" name="TOTAL_QTYP" value="<?php echo number_format($row->TOTAL_QTYP, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td></td>
						</tfoot>
					</table>
				</div>
            </div>
		</div>
		<br><br>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-4">
					<button type="button"  onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
				<div class="col-md-3"></div>
				<div class="col-md-1">
					<label class="label">Sub Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TTOTAL rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->TTOTAL, 2, '.', ','); ?>" id="TTOTAL" name="TTOTAL" readonly>
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
					<input class="form-control TDISC rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($row->TDISC, 2, '.', ','); ?>" id="TDISC" name="TDISC">
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
		</div>
		<div class="col-md-12">
			<div class="form-group row">
			<div class="col-md-7"></div>
			<div class="col-md-1">
				<label class="label">Sisa </label>
			</div>
			<div class="col-md-2 ">
				<input class="form-control SISA rightJustified text-success font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->SISA, 2, '.', ','); ?>" id="SISA" name="SISA" readonly>
			</div>
		</div>
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
		$("#TOTAL_QTY").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TOTAL_QTYP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TTOTAL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TDISC").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#NETT").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#SISA").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
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
			$("#HARGA" + i.toString()).autoNumeric('init', {
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
		var TOTAL_QTY = 0;
		var TOTAL_QTYP = 0;
		var TTOTAL = 0;
		var TDISC = parseFloat($('#TDISC').val().replace(/,/g, ''));
		var SISA = 0;

		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var lusin = parseFloat($('#QTY'+i).val().replace(/,/g, ''));
			var pair = parseFloat($('#QTYP'+i).val().replace(/,/g, ''));
			var harga = parseFloat($('#HARGA'+i).val().replace(/,/g, ''));

			var jumlah = ( lusin + pair) * harga;
			if(isNaN(jumlah)) jumlah = 0;
			$('#TOTAL'+i).val(numberWithCommas(jumlah));
			$('#TOTAL'+i).autoNumeric('update');
		};
		$(".QTY").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TOTAL_QTY+=val;
		});
		$(".QTYP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TOTAL_QTYP+=val;
		});
		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TTOTAL+=val;
		});

		var NETT = TTOTAL - TDISC;

		if(isNaN(TOTAL_QTY)) TOTAL_QTY = 0;
		if(isNaN(TOTAL_QTYP)) TOTAL_QTYP = 0;
		if(isNaN(TTOTAL)) TTOTAL = 0;
		if(isNaN(NETT)) NETT = 0;
		if(isNaN(SISA)) SISA = 0;

		$('#TOTAL_QTY').val(numberWithCommas(TOTAL_QTY));
		$('#TOTAL_QTYP').val(numberWithCommas(TOTAL_QTYP));
		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$('#NETT').val(numberWithCommas(NETT));
		$('#SISA').val(numberWithCommas(SISA));

		$("#TOTAL_QTY").autoNumeric('update');
		$('#TOTAL_QTYP').autoNumeric('update');
		$('#TTOTAL').autoNumeric('update');
		$('#NETT').autoNumeric('update');
		$("#SISA").autoNumeric('update');

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

		var akun0 = "<div class='input-group'><select class='js-example-responsive-article form-control ARTICLE0' name='KD_BRG[]' id=ARTICLE0" + idrow + " onchange='article(this.id)' onfocusout='hitung()' required></select></div>";
		var akun = akun0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = akun;
		td3.innerHTML = "<input name='WARNA[]' id=WARNA0" + idrow + " type='text' class='form-control WARNA' readonly>";
		td4.innerHTML = "<input name='SIZE[]' id=SIZE0" + idrow + " type='text' class='form-control SIZE' readonly>";
		td5.innerHTML = "<input name='GOL[]' id=GOLONG0" + idrow + " type='text' class='form-control GOL' maxlength='1' readonly>";
		td6.innerHTML = "<input name='QTY[]' onclick='select()' onkeyup='hitung()' value='0' id=QTY" + idrow + " type='text' class='form-control QTY rightJustified text-primary'>";
		td7.innerHTML = "<input name='QTYP[]' onclick='select()' onkeyup='hitung()' value='0' id=QTYP" + idrow + " type='text' class='form-control QTYP rightJustified text-primary'>";
		td8.innerHTML = "<input name='HARGA[]' onclick='select()' onkeyup='hitung()' value='0' id=HARGA" + idrow + " type='text' class='form-control HARGA rightJustified text-primary'>";
		td9.innerHTML = "<input name='TOTAL[]' onkeyup='hitung()' value='0' id=TOTAL" + idrow + " type='text' class='form-control TOTAL rightJustified text-primary' readonly>";
		td10.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
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
		select_article();
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
		select_article();
		select_kodecus();
	});

	function select_article() {
		$('.js-example-responsive-article').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_Retur_Pengiriman/getDataAjax_Article') ?>",
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
			templateResult: format_article,
			templateSelection: formatSelection_article
		});
	}

	function format_article(repo_article) {
		if (repo_article.loading) {
			return repo_article.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_article.article);
		return $container;
	}
	var warna = '';
	var size = '';
	var golong = '';

	function formatSelection_article(repo_article) {
		warna = repo_article.warna;
		size = repo_article.size;
		golong = repo_article.golong;
		return repo_article.text;
	}

	function article(x) {
		var q = x.substring(7, 9);
		$('#WARNA' + q).val(warna);
		$('#SIZE' + q).val(size);
		$('#GOL' + q).val(golong);
	}

	function select_kodecus() {
		$('.js-example-responsive-kodecus').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_Retur_Pengiriman/getDataAjax_Customer') ?>",
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
			templateResult: format_kodecus,
			templateSelection: formatSelection_kodecus
		});
	}

	function format_kodecus(repo_kodecus) {
		if (repo_kodecus.loading) {
			return repo_kodecus.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_kodecus.kodecus);
		return $container;
	}
	var nama = '';
	var kota = '';
	var koderay = '';

	function formatSelection_kodecus(repo_kodecus) {
		nama = repo_kodecus.nama;
		kota = repo_kodecus.kota;
		koderay = repo_kodecus.koderay;
		return repo_kodecus.text;
	}

	function kodecus(x) {
		var q = x.substring(7, 9);
		$('#NAMA' + q).val(nama);
		$('#KOTA' + q).val(kota);
		$('#KODERAY' + q).val(koderay);
	}

</script>
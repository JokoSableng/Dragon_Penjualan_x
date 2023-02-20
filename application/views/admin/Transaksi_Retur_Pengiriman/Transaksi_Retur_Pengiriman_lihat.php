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
		<i class="fas fa-university"></i> Lihat <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksi_retur_pengiriman" name="transaksi_retur_pengiriman" action="<?php echo base_url('admin/Transaksi_Retur_Pengiriman/lihat_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sj </label>
						</div>
						<div class="input-group col-md-3">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NOSJ" id="NOSJ" name="NOSJ" type="text" value="<?php echo $rowh->NOSJ ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl Sj </label>
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
                                readonly
							>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="input-group col-md-3">
							<input class="form-control text_input KODECUS" id="KODECUS" name="KODECUS" type="text" value="<?php echo $rowh->KODECUS ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Koderay </label>
						</div>
						<div class="input-group col-md-3">
							<input class="form-control text_input KODERAY" id="KODERAY" name="KODERAY" type="text" value="<?php echo $rowh->KODERAY ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Nama </label>
						</div>
						<div class="input-group col-md-3">
							<input class="form-control text_input NAMA" id="NAMA" name="NAMA" type="text" value="<?php echo $rowh->NAMA ?>" readonly>
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
							foreach ($retur_pengiriman as $row) : 
						?>
							<tr>

								</td>
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" readonly></td>
								<td><input name="ARTICLE[]" id="ARTICLE<?php echo $no; ?>" value="<?= $row->ARTICLE ?>" type="text" class="form-control ARTICLE" readonly></td>
								<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOLONG[]" id="GOLONG<?php echo $no; ?>" value="<?= $row->GOLONG ?>" type="text" class="form-control GOLONG" maxlength="1" readonly></td>
								<td><input name="LUSIN[]" onclick="select()" onkeyup="hitung()" id="LUSIN<?php echo $no; ?>" value="<?php echo number_format($row->LUSIN, 2, '.', ','); ?>" type="text" class="form-control LUSIN rightJustified text-primary"readonly></td>
								<td><input name="PAIR[]" onclick="select()" onkeyup="hitung()" id="PAIR<?php echo $no; ?>" value="<?php echo number_format($row->PAIR, 2, '.', ','); ?>" type="text" class="form-control PAIR rightJustified text-primary"readonly></td>
								<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary"readonly></td>
								<td><input name="JUMLAH[]" onkeyup="hitung()" id="JUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->JUMLAH, 2, '.', ','); ?>" type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>
								<td>
									<input name="ROW_ID[]" id="ROW_ID<?php echo $no; ?>" value="<?= $row->ROW_ID ?>" class="form-control" type="hidden">
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
		<div class="col-md-12">
			<div class="form-group row">
			<div class="col-md-7"></div>
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
					<input class="form-control TDISC rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($row->TDISC, 2, '.', ','); ?>" id="TDISC" name="TDISC"readonly>
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
                        <button type="submit" class="btn btn-danger"><i class="fa fa-backward"></i> Back</button>
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

	function hitung() {}

	function tambah() {}

	function hapus() {}
</script>

<script>
	$(document).ready(function() {
		select2x();
	});

	function select2x() {
		$('.js-example-responsive').select2({
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
			templateResult: format,
			templateSelection: formatSelection
		});
	}

	function format(repo) {
		if (repo.loading) {
			return repo.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo.coba);
		return $container;
	}
	var warna = '';
	var size = '';
	var golong = '';

	function formatSelection(repo) {
		warna = repo.warna;
		size = repo.size;
		golong = repo.golong;
		return repo.text;
	}

	function coba(x) {
		var q = x.substring(7, 9);
		$('#WARNA' + q).val(warna);
		$('#SIZE' + q).val(size);
		$('#GOLONG' + q).val(golong);
	}

</script>
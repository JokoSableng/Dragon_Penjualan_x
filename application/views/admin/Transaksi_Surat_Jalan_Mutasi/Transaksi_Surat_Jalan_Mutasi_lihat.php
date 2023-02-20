<?php
	foreach ($surat_jalan_mutasi as $rowh) {};
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
	<form id="Transaksi_Surat_Jalan_Mutasi" name="Transaksi_Surat_Jalan_Mutasi" action="<?php echo base_url('admin/Transaksi_Surat_Jalan_Mutasi/lihat_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sj </label>
						</div>
						<div class="col-md-2">
							<input class="form-control" name="ID" value="<?php echo $rowh->ID ?>" type="hidden">
							<input class="form-control text_input NOSJ" id="NOSJ" name="NOSJ" value="<?php echo $rowh->NOSJ ?>" type="text" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl Sj </label>
						</div>
						<div class="col-md-2">
							<input 
								type="text" 
								class="form-control" 
								id="TGLCIM" 
								name="TGLCIM" 
								data-date-format="dd-mm-yyyy" 
								value="<?php echo date('d-m-Y', strtotime($rowh->TGLCIM, TRUE)); ?>"
								onclick="select()" 
								readonly
							>
						</div>
						<div class="col-md-1">
							<label class="label">Pkp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input PKP" id="PKP" name="PKP" value="<?php echo $rowh->PKP ?>" type="text" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">No Do </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NODOM" id="NODOM" name="NODOM" value="<?php echo $rowh->NODOM ?>" type="text" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KODECUS" id="KODECUS" name="KODECUS" value="<?php echo $rowh->KODECUS ?>" type="text" readonly>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input KODERAY" id="KODERAY" name="KODERAY" value="<?php echo $rowh->KODERAY ?>" type="text" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NAMA" id="NAMA" name="NAMA" value="<?php echo $rowh->NAMA ?>" type="text" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KOTA" id="KOTA" name="KOTA" value="<?php echo $rowh->KOTA ?>" type="text" readonly>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<label class="label">No Sp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_SPM" id="NO_SPM" name="NO_SPM" value="<?php echo $rowh->NO_SPM ?>" type="text" readonly>
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
								<th width="100px">Disc 1</th>
								<th width="100px">Disc 0</th>
								<th width="100px">Disc 3</th>
								<th width="100px">Disc 4</th>
								<th width="100px">Disc Rp</th>
								<th width="100px">T Disc</th>
								<th width="120px">Jumlah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							foreach ($surat_jalan_mutasi as $row) : 
						?>
							<tr>
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?php echo $row->REC; ?>" class="form-control REC" type="text" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="ARTICLE[]" id="ARTICLE<?php echo $no; ?>" value="<?php echo $row->ARTICLE; ?>" type="text" class="form-control ARTICLE" readonly></td>
								<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?php echo $row->WARNA; ?>" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?php echo $row->SIZE; ?>" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOLONG[]" onclick="select()" id="GOLONG<?php echo $no; ?>" value="<?php echo $row->GOLONG; ?>" type="text" class="form-control GOLONG" maxlength="1" readonly></td>
								<td><input name="LUSIN[]" onclick="select()" onchange="hitung()" id="LUSIN<?php echo $no; ?>" value="<?php echo number_format($row->LUSIN, 2, '.', ','); ?>" type="text" class="form-control LUSIN rightJustified text-primary" readonly></td>
								<td><input name="PAIR[]" onclick="select()" onchange="hitung()" id="PAIR<?php echo $no; ?>" value="<?php echo number_format($row->PAIR, 2, '.', ','); ?>" type="text" class="form-control PAIR rightJustified text-primary" readonly></td>
								<td><input name="HARGA[]" onclick="select()" onchange="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary" readonly></td>
								<td><input name="DISC1[]" onclick="select()" onchange="hitung()" id="DISC1<?php echo $no; ?>" value="<?php echo number_format($row->DISC1, 2, '.', ','); ?>" type="text" class="form-control DISC1 rightJustified text-danger" readonly></td>
								<td><input name="DISC2[]" onclick="select()" onchange="hitung()" id="DISC2<?php echo $no; ?>" value="<?php echo number_format($row->DISC2, 2, '.', ','); ?>" type="text" class="form-control DISC2 rightJustified text-danger" readonly></td>
								<td><input name="DISC3[]" onclick="select()" onchange="hitung()" id="DISC3<?php echo $no; ?>" value="<?php echo number_format($row->DISC3, 2, '.', ','); ?>" type="text" class="form-control DISC3 rightJustified text-danger" readonly></td>
								<td><input name="DISC4[]" onclick="select()" onchange="hitung()" id="DISC4<?php echo $no; ?>" value="<?php echo number_format($row->DISC4, 2, '.', ','); ?>" type="text" class="form-control DISC4 rightJustified text-danger" readonly></td>
								<td><input name="DISCRP[]" onclick="select()" onchange="hitung()" id="DISCRP<?php echo $no; ?>" value="<?php echo number_format($row->DISCRP, 2, '.', ','); ?>" type="text" class="form-control DISCRP rightJustified text-danger" readonly></td>
								<td><input name="DISC[]" onclick="select()" onchange="hitung()" id="DISC<?php echo $no; ?>" value="<?php echo number_format($row->DISC, 2, '.', ','); ?>" type="text" class="form-control DISC rightJustified text-danger" readonly></td>
								<td><input name="JUMLAH[]" onchange="hitung()" id="JUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->JUMLAH, 2, '.', ','); ?>" type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>
								<td>
									<input style="visibility: hidden;" name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden">
									<button style="visibility: hidden;" type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
										<i style="visibility: hidden;" class="fa fa-fw fa-trash"></i>
									</button>
								</td>
							</tr>
						</tbody>
						<?php $no++; ?>
						<?php endforeach; ?>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TLUSIN rightJustified text-primary font-weight-bold" id="TLUSIN" name="TLUSIN" value="<?php echo number_format($rowh->DISC, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TPAIR rightJustified text-primary font-weight-bold" id="TPAIR" name="TPAIR" value="<?php echo number_format($rowh->DISC, 2, '.', ','); ?>" readonly></td>
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
		<!-- <div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div> -->
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Stand </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control STAND rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->STAND, 2, '.', ','); ?>" id="STAND" name="STAND" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Pembulatan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BULAT rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->BULAT, 2, '.', ','); ?>" id="BULAT" name="BULAT" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Sub Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TJUMLAH rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->TJUMLAH, 2, '.', ','); ?>" id="TJUMLAH" name="TJUMLAH" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Jenis </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control JENIS rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->JENIS, 2, '.', ','); ?>" id="JENIS" name="JENIS" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Kontan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control KONTAN rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->KONTAN, 2, '.', ','); ?>" id="KONTAN" name="KONTAN" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Disc Rp </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TDISC rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($rowh->TDISC, 2, '.', ','); ?>" id="TDISC" name="TDISC" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
			<div class="col-md-1">
					<label class="label">Bs </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BS rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->BS, 2, '.', ','); ?>" id="BS" name="BS" readonly>
				</div>
				<div class="col-md-2" style="text-align: right;">
					<label class="label">Perubahan Harga </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control PERUBAHAN_HRG rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->PERUBAHAN_HRG, 2, '.', ','); ?>" id="PERUBAHAN_HRG" name="PERUBAHAN_HRG" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Nett </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control NETT rightJustified text-success font-weight-bold" onchange="hitung()" value="<?php echo number_format($rowh->NETT, 2, '.', ','); ?>" id="NETT" name="NETT" readonly>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group cxx">
						<button type="submit"  class="btn btn-danger"><i class="fa fa-backward"></i> Back</button>
					</div>
					<h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	(function() {})();

	var target;
	var idrow = <?php echo $no ?>;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#MAXKRE").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#SPIU").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TLUSIN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TPAIR").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#STAND").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#BULAT").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#JENIS").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#KONTAN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#BS").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#PERUBAHAN_HRG").autoNumeric('init', {
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
			$("#DISC1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC2" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC3" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC4" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISCRP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#DISC" + i.toString()).autoNumeric('init', {
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

	function select2x() {}

	function format(repo) {}
	var xx = '';
	var size = '';

	function formatSelection(repo) {}

	function coba(x) {}

</script>
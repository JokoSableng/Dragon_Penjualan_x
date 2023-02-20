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
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksi_surat_jalan_mutasi" name="transaksi_surat_jalan_mutasi" action="<?php echo base_url('admin/Transaksi_Surat_Jalan_Mutasi/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sj </label>
						</div>
						<div class="col-md-2">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NOSJ" id="NOSJ" name="NOSJ" type="text" value="<?php echo $rowh->NOSJ ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl Sj </label>
						</div>
						<div class="col-md-2">
							<input 
								type="text" 
								class="date form-control" 
								id="TGLCIM" 
								name="TGLCIM" 
								data-date-format="dd-mm-yyyy" 
								value="<?php echo date('d-m-Y', strtotime($rowh->TGLCIM, TRUE)); ?>"
								onclick="select()" 
							>
						</div>
						<div class="col-md-1">
							<label class="label">Pkp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input PKP" id="PKP" name="PKP" type="text" value="<?php echo $rowh->PKP ?>" required>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2">
							<select class="js-example-responsive-kodecus form-control KODECUS" name="KODECUS" id="KODECUS" onchange="kodecus(this.id)" required>
								<option value="<?php echo $rowh->KODECUS; ?>" selected id="KODECUS"><?php echo $rowh->KODECUS; ?></option>
							</select>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input KODERAY" id="KODERAY" name="KODERAY" type="text" value="<?php echo $rowh->KODERAY ?>" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NAMA" id="NAMA" name="NAMA" type="text" value="<?php echo $rowh->NAMA ?>" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KOTA" id="KOTA" name="KOTA" type="text" value="<?php echo $rowh->KOTA ?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_SPM" id="NO_SPM" name="NO_SPM" type="text" value="<?php echo $rowh->NO_SPM ?>">
						</div>
						<div class="col-md-1">
							<label class="label">No Do </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NODOM" id="NODOM" name="NODOM" type="text" value="<?php echo $rowh->NODOM ?>">
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
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td>
									<div class="input-group">
										<select class="js-example-responsive-article form-control ARTICLE" name="ARTICLE[]" id="ARTICLE<?php echo $no; ?>" onchange="article(this.id)" required>
											<option value="<?php echo $row->ARTICLE; ?>" selected id="ARTICLE<?php echo $no; ?>"><?php echo $row->ARTICLE; ?></option>
										</select>
									</div>
								</td>
								<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOLONG[]" id="GOLONG<?php echo $no; ?>" value="<?= $row->GOLONG ?>" type="text" class="form-control GOLONG" maxlength="1" readonly></td>
								<td><input name="LUSIN[]" onclick="select()" onkeyup="hitung()" id="LUSIN<?php echo $no; ?>" value="<?php echo number_format($row->LUSIN, 2, '.', ','); ?>" type="text" class="form-control LUSIN rightJustified text-primary"></td>
								<td><input name="PAIR[]" onclick="select()" onkeyup="hitung()" id="PAIR<?php echo $no; ?>" value="<?php echo number_format($row->PAIR, 2, '.', ','); ?>" type="text" class="form-control PAIR rightJustified text-primary"></td>
								<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary"></td>
								<td><input name="DISC1[]" onclick="select()" onkeyup="hitung()" id="DISC1<?php echo $no; ?>" value="<?php echo number_format($row->DISC1, 2, '.', ','); ?>" type="text" class="form-control DISC1 rightJustified text-danger"></td>
								<td><input name="DISC2[]" onclick="select()" onkeyup="hitung()" id="DISC2<?php echo $no; ?>" value="<?php echo number_format($row->DISC2, 2, '.', ','); ?>" type="text" class="form-control DISC2 rightJustified text-danger"></td>
								<td><input name="DISC3[]" onclick="select()" onkeyup="hitung()" id="DISC3<?php echo $no; ?>" value="<?php echo number_format($row->DISC3, 2, '.', ','); ?>" type="text" class="form-control DISC3 rightJustified text-danger"></td>
								<td><input name="DISC4[]" onclick="select()" onkeyup="hitung()" id="DISC4<?php echo $no; ?>" value="<?php echo number_format($row->DISC4, 2, '.', ','); ?>" type="text" class="form-control DISC4 rightJustified text-danger"></td>
								<td><input name="DISCRP[]" onclick="select()" onkeyup="hitung()" id="DISCRP<?php echo $no; ?>" value="<?php echo number_format($row->DISCRP, 2, '.', ','); ?>" type="text" class="form-control DISCRP rightJustified text-danger"></td>
								<td><input name="DISC[]" onclick="select()" onkeyup="hitung()" id="DISC<?php echo $no; ?>" value="<?php echo number_format($row->DISC, 2, '.', ','); ?>" type="text" class="form-control DISC rightJustified text-danger" readonly></td>
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
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Stand </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control STAND rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->TLUSIN, 2, '.', ','); ?>" id="STAND" name="STAND" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Pembulatan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BULAT rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->TLUSIN, 2, '.', ','); ?>" id="BULAT" name="BULAT" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Sub Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TJUMLAH rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->TLUSIN, 2, '.', ','); ?>" id="TJUMLAH" name="TJUMLAH" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Jenis </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control JENIS rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->JENIS, 2, '.', ','); ?>" id="JENIS" name="JENIS" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Kontan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control KONTAN rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->KONTAN, 2, '.', ','); ?>" id="KONTAN" name="KONTAN" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Disc Rp </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TDISC rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="<?php echo number_format($row->TDISC, 2, '.', ','); ?>" id="TDISC" name="TDISC" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
			<div class="col-md-1">
					<label class="label">Bs </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BS rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->BS, 2, '.', ','); ?>" id="BS" name="BS" readonly>
				</div>
				<div class="col-md-2" style="text-align: right;">
					<label class="label">Perubahan Harga </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control PERUBAHAN_HRG rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->PERUBAHAN_HRG, 2, '.', ','); ?>" id="PERUBAHAN_HRG" name="PERUBAHAN_HRG" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Nett </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control NETT rightJustified text-success font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->NETT, 2, '.', ','); ?>" id="NETT" name="NETT" readonly>
				</div>
			</div>
		</div>
		<br>
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

	function hitung() {
		var TLUSIN = 0;
		var TPAIR = 0;
		var TJUMLAH = 0;
		var TDISC = 0;
		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var lusin = parseFloat($('#LUSIN'+i).val().replace(/,/g, ''));
			var pair = parseFloat($('#PAIR'+i).val().replace(/,/g, ''));
			var harga = parseFloat($('#HARGA'+i).val().replace(/,/g, ''));
			var disc1 = parseFloat($('#DISC1'+i).val().replace(/,/g, ''));
			var disc2 = parseFloat($('#DISC2'+i).val().replace(/,/g, ''));
			var disc3 = parseFloat($('#DISC3'+i).val().replace(/,/g, ''));
			var disc4 = parseFloat($('#DISC4'+i).val().replace(/,/g, ''));
			var discrp = parseFloat($('#DISCRP'+i).val().replace(/,/g, ''));

			var disc = disc1+disc2+disc3+disc4+discrp;
			if(isNaN(disc)) disc = 0;
			$('#DISC'+i).val(numberWithCommas(disc));
			$('#DISC'+i).autoNumeric('update');

			var jumlah = ( lusin + pair) * harga - disc;
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
		$(".DISC").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TDISC+=val;
		});
		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TJUMLAH+=val;
		});

		var NETT = TJUMLAH;

		if(isNaN(TLUSIN)) TLUSIN = 0;
		if(isNaN(TPAIR)) TPAIR = 0;
		if(isNaN(TDISC)) TDISC = 0;
		if(isNaN(TJUMLAH)) TJUMLAH = 0;
		if(isNaN(NETT)) NETT = 0;

		$('#TLUSIN').val(numberWithCommas(TLUSIN));
		$('#TPAIR').val(numberWithCommas(TPAIR));
		$('#TDISC').val(numberWithCommas(TDISC));
		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));
		$('#NETT').val(numberWithCommas(NETT));

		$("#TLUSIN").autoNumeric('update');
		$('#TPAIR').autoNumeric('update');
		$('#TDISC').autoNumeric('update');
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
		var td11 = x.insertCell(10);
		var td12 = x.insertCell(11);
		var td13 = x.insertCell(12);
		var td14 = x.insertCell(13);
		var td15 = x.insertCell(14);
		var td16 = x.insertCell(15);

		var akun0 = "<div class='input-group'><select class='js-example-responsive-article form-control ARTICLE0' name='ARTICLE[]' id=ARTICLE0" + idrow + " onchange='article(this.id)' onfocusout='hitung()' required></select></div>";
		var akun = akun0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = akun;
		td3.innerHTML = "<input name='WARNA[]' id=WARNA0" + idrow + " type='text' class='form-control WARNA' readonly>";
		td4.innerHTML = "<input name='SIZE[]' id=SIZE0" + idrow + " type='text' class='form-control SIZE' readonly>";
		td5.innerHTML = "<input name='GOLONG[]' id=GOLONG0" + idrow + " type='text' class='form-control GOLONG' maxlength='1' readonly>";
		td6.innerHTML = "<input name='LUSIN[]' onclick='select()' onkeyup='hitung()' value='0' id=LUSIN" + idrow + " type='text' class='form-control LUSIN rightJustified text-primary'>";
		td7.innerHTML = "<input name='PAIR[]' onclick='select()' onkeyup='hitung()' value='0' id=PAIR" + idrow + " type='text' class='form-control PAIR rightJustified text-primary'>";
		td8.innerHTML = "<input name='HARGA[]' onclick='select()' onkeyup='hitung()' value='0' id=HARGA" + idrow + " type='text' class='form-control HARGA rightJustified text-primary'>";
		td9.innerHTML = "<input name='DISC1[]' onclick='select()' onkeyup='hitung()' value='0' id=DISC1" + idrow + " type='text' class='form-control DISC1 rightJustified text-danger'>";
		td10.innerHTML = "<input name='DISC2[]' onclick='select()' onkeyup='hitung()' value='0' id=DISC2" + idrow + " type='text' class='form-control DISC2 rightJustified text-danger'>";
		td11.innerHTML = "<input name='DISC3[]' onclick='select()' onkeyup='hitung()' value='0' id=DISC3" + idrow + " type='text' class='form-control DISC3 rightJustified text-danger'>";
		td12.innerHTML = "<input name='DISC4[]' onclick='select()' onkeyup='hitung()' value='0' id=DISC4" + idrow + " type='text' class='form-control DISC4 rightJustified text-danger'>";
		td13.innerHTML = "<input name='DISCRP[]' onclick='select()' onkeyup='hitung()' value='0' id=DISCRP" + idrow + " type='text' class='form-control DISCRP rightJustified text-danger'>";
		td14.innerHTML = "<input name='DISC[]' onclick='select()' onkeyup='hitung()' value='0' id=DISC" + idrow + " type='text' class='form-control DISC rightJustified text-danger' readonly>";
		td15.innerHTML = "<input name='JUMLAH[]' onkeyup='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary' readonly>";
		td16.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
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
				url: "<?= base_url('admin/Transaksi_Surat_Jalan_Mutasi/getDataAjax_Article') ?>",
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
		$('#GOLONG' + q).val(golong);
	}

	function select_kodecus() {
		$('.js-example-responsive-kodecus').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_Surat_Jalan_Mutasi/getDataAjax_Customer') ?>",
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
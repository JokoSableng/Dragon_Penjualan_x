<?php
	foreach ($surat_jalan as $rowh) {};
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
	<form id="transaksi_surat_jalan" name="transaksi_surat_jalan" action="<?php echo base_url('admin/Transaksi_Surat_Jalan/lihat_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
								id="TGLCI" 
								name="TGLCI" 
								data-date-format="dd-mm-yyyy" 
								value="<?php echo date('d-m-Y', strtotime($rowh->TGLCI, TRUE)); ?>"
								onclick="select()" 
                                readonly
							>
						</div>
						<div class="col-md-1">
							<label class="label">Nopol </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NOPOL" id="NOPOL" name="NOPOL" type="text" value="<?php echo $rowh->NOPOL ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Pkp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input PKP" id="PKP" name="PKP" type="text" value="<?php echo $rowh->PKP ?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KODECUS" id="KODECUS" name="KODECUS" type="text" value="<?php echo $rowh->KODECUS ?>"readonly>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input KODERAY" id="KODERAY" name="KODERAY" type="text" value="<?php echo $rowh->KODERAY ?>"readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NAMA" id="NAMA" name="NAMA" type="text" value="<?php echo $rowh->NAMA ?>"readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KOTA" id="KOTA" name="KOTA" type="text" value="<?php echo $rowh->KOTA ?>"readonly>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input KETER" id="KETER" name="KETER" type="text" value="<?php echo $rowh->KETER ?>"readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Bmkpk </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input BMPKP" id="BMPKP" name="BMPKP" type="text" value="<?php echo $rowh->BMPKP ?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_SP" id="NO_SP" name="NO_SP" type="text" value="<?php echo $rowh->NO_SP ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">No Do </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NODO" id="NODO" name="NODO" type="text" value="<?php echo $rowh->NODO ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Max Kredit </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input MAXKRE" id="MAXKRE" name="MAXKRE" type="text" value="<?php echo $rowh->MAXKRE ?>"readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Piu + Giro </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input PIU" id="PIU" name="PIU" type="text" value="<?php echo $rowh->PIU ?>" maxlength="1"readonly>
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
								<th width="1px"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							foreach ($surat_jalan as $row) : 
						?>
							<tr>
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="ARTICLE[]" id="ARTICLE<?php echo $no; ?>" value="<?= $row->ARTICLE ?>" type="text" class="form-control ARTICLE" readonly></td>
								<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOLONG[]" id="GOLONG<?php echo $no; ?>" value="<?= $row->GOLONG ?>" type="text" class="form-control GOLONG" maxlength="1" readonly></td>
								<td><input name="LUSIN[]" onclick="select()" onkeyup="hitung()" id="LUSIN<?php echo $no; ?>" value="<?php echo number_format($row->LUSIN, 2, '.', ','); ?>" type="text" class="form-control LUSIN rightJustified text-primary"readonly></td>
								<td><input name="PAIR[]" onclick="select()" onkeyup="hitung()" id="PAIR<?php echo $no; ?>" value="<?php echo number_format($row->PAIR, 2, '.', ','); ?>" type="text" class="form-control PAIR rightJustified text-primary"readonly></td>
								<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary"readonly></td>
								<td><input name="DISC1[]" onclick="select()" onkeyup="hitung()" id="DISC1<?php echo $no; ?>" value="<?php echo number_format($row->DISC1, 2, '.', ','); ?>" type="text" class="form-control DISC1 rightJustified text-danger"readonly></td>
								<td><input name="DISC2[]" onclick="select()" onkeyup="hitung()" id="DISC2<?php echo $no; ?>" value="<?php echo number_format($row->DISC2, 2, '.', ','); ?>" type="text" class="form-control DISC2 rightJustified text-danger"readonly></td>
								<td><input name="DISC3[]" onclick="select()" onkeyup="hitung()" id="DISC3<?php echo $no; ?>" value="<?php echo number_format($row->DISC3, 2, '.', ','); ?>" type="text" class="form-control DISC3 rightJustified text-danger"readonly></td>
								<td><input name="DISC4[]" onclick="select()" onkeyup="hitung()" id="DISC4<?php echo $no; ?>" value="<?php echo number_format($row->DISC4, 2, '.', ','); ?>" type="text" class="form-control DISC4 rightJustified text-danger"readonly></td>
								<td><input name="DISCRP[]" onclick="select()" onkeyup="hitung()" id="DISCRP<?php echo $no; ?>" value="<?php echo number_format($row->DISCRP, 2, '.', ','); ?>" type="text" class="form-control DISCRP rightJustified text-danger"readonly></td>
								<td><input name="DISC[]" onclick="select()" onkeyup="hitung()" id="DISC<?php echo $no; ?>" value="<?php echo number_format($row->DISC, 2, '.', ','); ?>" type="text" class="form-control DISC rightJustified text-danger" readonly></td>
								<td><input name="JUMLAH[]" onkeyup="hitung()" id="JUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->JUMLAH, 2, '.', ','); ?>" type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>
								<td><input name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden"><td>
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
					<input class="form-control STAND rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->STAND, 2, '.', ','); ?>" id="STAND" name="STAND" readonly>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Pembulatan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BULAT rightJustified text-primary font-weight-bold" onchange="hitung()" value="<?php echo number_format($row->BULAT, 2, '.', ','); ?>" id="BULAT" name="BULAT" readonly>
				</div>
				<div class="col-md-1"></div>
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
                         <button type="submit" class="btn btn-danger"><i class="fa fa-backward"></i> Back</button>
					</div>
					<h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- myModal No Sp-->
<div id="mymodal_no_sp" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data Penerimaan Barang</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_no_sp'>
					<thead>	
						<th>No Sp</th>
						<th>Tgl Sp</th>
						<th>No Do</th>
						<th>Tgl Do</th>
						<th>T Lusin</th>
						<th>T Pair</th>
					</thead>
					<tbody>
					<?php
						$sql = "SELECT jl_sphdr.no_sp AS NO_SP, 
								jl_sphdr.tgl_sp AS TGL_SP, 
								jl_sphdr.nodo AS NODO, 
								jl_sphdr.tgldo AS TGLDO,
								jl_sphdr.tlusin AS TLUSIN,
								jl_sphdr.tpair AS TPAIR FROM jl_sphdr ORDER BY no_sp";
						$a = $this->db->query($sql)->result();
						foreach($a as $b ) { 
					?>
						<tr>
							<td class='NSJVAL'><a href="#" class="select_no_sp"><?php echo $b->NO_SP;?></a></td>
							<td class='TSJVAL text_input'><?php echo $b->TGL_SP;?></td>
							<td class='NDJVAL text_input'><?php echo $b->NODO;?></td>
							<td class='TDJVAL text_input'><?php echo $b->TGLDO;?></td>
							<td class='TLJVAL text_input'><?php echo $b->TLUSIN;?></td>
							<td class='TPJVAL text_input'><?php echo $b->TPAIR;?></td>
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

<!-- myModal No Do-->
<div id="mymodal_nodo" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data Penerimaan Barang</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_nodo'>
					<thead>	
						<th>No Do</th>
						<th>No Sp</th>
						<th>Tgl Sp</th>
						<th>Tgl Do</th>
						<th>T Lusin</th>
						<th>T Pair</th>
					</thead>
					<tbody>
					<?php
						$sql = "SELECT jl_sphdr.no_sp AS NO_SP, 
								jl_sphdr.tgl_sp AS TGL_SP, 
								jl_sphdr.nodo AS NODO, 
								jl_sphdr.tgldo AS TGLDO,
								jl_sphdr.tlusin AS TLUSIN,
								jl_sphdr.tpair AS TPAIR FROM jl_sphdr ORDER BY nodo";
						$a = $this->db->query($sql)->result();
						foreach($a as $b ) { 
					?>
						<tr>
							<td class='NDJVAL'><a href="#" class="select_nodo"><?php echo $b->NODO;?></td>
							<td class='NSJVAL text_input'><?php echo $b->NO_SP;?></a></td>
							<td class='TSJVAL text_input'><?php echo $b->TGL_SP;?></td>
							<td class='TDJVAL text_input'><?php echo $b->TGLDO;?></td>
							<td class='TLJVAL text_input'><?php echo $b->TLUSIN;?></td>
							<td class='TPJVAL text_input'><?php echo $b->TPAIR;?></td>
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
		$('#modal_no_sp').DataTable({
			dom: 
				"<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {			 
			$('input[type=search]').val('').keyup();  // this line and next one clear the search dialog
		});
		$('#modal_nodo').DataTable({
			dom: 
				"<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {			 
			$('input[type=search]').val('').keyup();  // this line and next one clear the search dialog
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
		//MyModal No Sp
			$('#mymodal_no_sp').on('show.bs.modal', function (e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_no_sp', function() {
			var val = $(this).parents("tr").find(".NSJVAL").text();
			target.parents("div").find(".NO_SP").val(val);
			$('#mymodal_no_sp').modal('toggle');
		});
		//MyModal No Do
			$('#mymodal_nodo').on('show.bs.modal', function (e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_nodo', function() {
			var val = $(this).parents("tr").find(".TSJVAL").text();
			target.parents("div").find(".TGL_SP").val(val);
			var val = $(this).parents("tr").find(".NDJVAL").text();
			target.parents("div").find(".NODO").val(val);
			var val = $(this).parents("tr").find(".TDJVAL").text();
			target.parents("div").find(".TGLDO").val(val);	
			var val = $(this).parents("tr").find(".TLJVAL").text();
			target.parents("div").find(".TLUSIN").val(val);	
			var val = $(this).parents("tr").find(".TPJVAL").text();
			target.parents("div").find(".TPAIR").val(val);	
			$('#mymodal_nodo').modal('toggle');
			var nodo = $(this).parents("tr").find(".NDJVAL").text();
			$.ajax({
				type:'get',
				url : '<?php echo base_url('index.php/admin/Transaksi_Surat_Jalan/filter_nodo'); ?>',
				data:{ nodo : nodo},
				dataType: 'json',
				success:function(response) {
				// alert(response);
					var html = '';
                    var i;
                    for(i=0; i<response.length; i++){
                        html += '<tr>'+
									'<td><input name="REC[]" id=REC'+i+' type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly value='+(i+1)+' ></td>'+
									'<td><input name="ARTICLE[]" id=ARTICLE'+i+' type="text" class="form-control ARTICLE" value="'+response[i].ARTICLE+'" readonly></td>'+
									'<td><input name="WARNA[]" id=WARNA'+i+' type="text" class="form-control WARNA" value="'+response[i].WARNA+'" readonly></td>'+
									'<td><input name="SIZE[]" id=SIZE'+i+' type="text" class="form-control SIZE" value="'+response[i].SIZE+'" readonly></td>'+
									'<td><input name="GOLONG[]" id=GOLONG'+i+' type="text" class="form-control GOLONG" value="'+response[i].GOLONG+'" readonly></td>'+
									'<td><input name="LUSIN[]" id=LUSIN'+i+' type="text" class="form-control LUSIN rightJustified text-primary" value="'+numberWithCommas(response[i].LUSIN)+'" readonly></td>'+
									'<td><input name="PAIR[]" id=PAIR'+i+' type="text" class="form-control PAIR rightJustified text-primary" value="'+numberWithCommas(response[i].PAIR)+'" readonly></td>'+
									'<td><input name="HARGA[]" id=HARGA'+i+' type="text" class="form-control HARGA rightJustified text-primary" value="0" onclick="select()" onkeyup="hitung()" ></td>'+
									'<td><input name="DISC1[]" id=DISC1'+i+' type="text" class="form-control DISC1 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>'+
									'<td><input name="DISC2[]" id=DISC2'+i+' type="text" class="form-control DISC2 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>'+
									'<td><input name="DISC3[]" id=DISC3'+i+' type="text" class="form-control DISC3 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>'+
									'<td><input name="DISC4[]" id=DISC4'+i+' type="text" class="form-control DISC4 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>'+
									'<td><input name="DISCRP[]" id=DISCRP'+i+' type="text" class="form-control DISCRP rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>'+
									'<td><input name="DISC[]" id=DISC'+i+' type="text" class="form-control DISC rightJustified text-danger" value="0" readonly ></td>'+
									'<td><input name="JUMLAH[]" id=JUMLAH'+i+' type="text" class="form-control JUMLAH rightJustified text-primary" value="0" readonly></td>'+
                                '</tr>';
                    }
					idrow=i;
					$('#show-data').html(html);
					jumlahdata = 100 ;
					for(i=0; i<=jumlahdata; i++){
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
				}
        	});
		});
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
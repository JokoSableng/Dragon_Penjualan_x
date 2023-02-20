<?php
foreach ($suratpesanan as $rowh) {
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
		width: 400px !important;
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
	<!-- <?= $this->session->userdata['kdmts']; ?> -->
	<form id="suratpesanan" name="suratpesanan" action="<?php echo base_url('admin/Transaksi_SuratPesanan/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sp </label>
						</div>
						<div class="input-group col-md-3">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value="<?php echo $rowh->NO_BUKTI ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl Sp </label>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL, TRUE)); ?>" onclick="select()" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Do </label>
						</div>
						<div class="col-md-3 input-group">
							<input <?php if ($rowh->NO_DO != '') echo 'readonly'; ?> class="form-control text_input NO_DO" id="NO_DO" name="NO_DO" type="text" value="<?php echo $rowh->NO_DO ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Tgl Do </label>
						</div>
						<div class="col-md-3">
							<input <?php if ($rowh->NO_DO != '') echo 'class="form-control TGL_DO text_input" readonly'; ?> type="text" class="date form-control text_input" id="TGL_DO" name="TGL_DO" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL_DO, TRUE)); ?>" onclick="select()">
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-2">
							<?php
							if ($rowh->NO_DO == '')
								echo '<a 
										type="button" 
										class="btn btn-warning btn-center"
										onclick="btIsiNoDo()" 
									>
										<span style="color: black; font-weight: bold;"><i class="fa fa-upload"></i> Upload No DO</span>
									</a>';
							else echo '<a 
									type="button" 
									class="btn btn-success btn-center" 
								>
									<span style="color: black; font-weight: bold;"><i class="fa fa-check"></i> No DO Sudah Diupload</span>
								</a>';
							?>
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
								<th width="200px">Barang</th>
								<th width="90px">Warna</th>
								<th width="100px">Size</th>
								<th width="75px">Gol</th>
								<th width="100px">Harga Lusin</th>
								<th width="100px">Harga Pair</th>
								<th width="75px">Lusin</th>
								<th width="75px">Pair</th>
								<th width="150px">Customer</th>
								<th width="150px">Nama</th>
								<th width="100px">Kota</th>
								<th width="10px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($suratpesanan as $row) :
							?>
								<tr>
									<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
									<td><input name="KD_BRG[]" id="KD_BRG<?php echo $no; ?>" value="<?= $row->KD_BRG ?>" type="text" class="form-control KD_BRG text_input" readonly></td>
									<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA text_input" readonly></td>
									<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE text_input" readonly></td>
									<td><input name="GOL[]" id="GOL<?php echo $no; ?>" value="<?= $row->GOL ?>" type="text" class="form-control GOL text_input" maxlength="1" readonly></td>
									<td><input name="HARGA[]" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary" readonly></td>
									<td><input name="HARGAP[]" id="HARGAP<?php echo $no; ?>" value="<?php echo number_format($row->HARGAP, 2, '.', ','); ?>" type="text" class="form-control HARGAP rightJustified text-primary" readonly></td>
									<td><input name="QTY[]" onclick="select()" onchange="hitung()" id="QTY<?php echo $no; ?>" value="<?php echo number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary" readonly></td>
									<td><input name="QTYP[]" onclick="select()" onchange="hitung()" id="QTYP<?php echo $no; ?>" value="<?php echo number_format($row->QTYP, 2, '.', ','); ?>" type="text" class="form-control QTYP rightJustified text-primary" readonly></td>
									<td><input name="KODEC[]" id="KODEC<?php echo $no; ?>" value="<?= $row->KODEC ?>" type="text" class="form-control KODEC text_input" readonly></td>
									<td><input name="NAMAC[]" id="NAMAC<?php echo $no; ?>" value="<?= $row->NAMAC ?>" type="text" class="form-control NAMAC text_input" readonly></td>
									<td><input name="KOTA[]" id="KOTA<?php echo $no; ?>" value="<?= $row->KOTA ?>" type="text" class="form-control KOTA text_input" readonly></td>
									<td><input name="KODERAY[]" id="KODERAY<?php echo $no; ?>" value="<?= $row->KODERAY ?>" type="hidden" class="form-control KODERAY text_input" readonly></td>
									<td><input name="MAXKRE[]" id="MAXKRE<?php echo $no; ?>" value="<?php echo number_format($row->MAXKRE, 2, '.', ','); ?>" type="hidden" class="form-control MAXKRE text_input" readonly></td>
									<td><input name="PIU[]" id="PIU<?php echo $no; ?>" value="<?php echo number_format($row->PIU, 2, '.', ','); ?>" type="hidden" class="form-control PIU text_input" readonly></td>
									<td>
										<input name="EXP_PIU[]" id="EXP_PIU<?php echo $no; ?>" type="hidden" class="date form-control" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($row->EXP_PIU, TRUE)); ?>" onclick="select()">
									</td>
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
							<td></td>
							<td><input class="form-control TOTAL_QTY rightJustified text-primary font-weight-bold" id="TOTAL_QTY" name="TOTAL_QTY" value="<?php echo number_format($rowh->TOTAL_QTY, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TOTAL_QTYP rightJustified text-primary font-weight-bold" id="TOTAL_QTYP" name="TOTAL_QTYP" value="<?php echo number_format($rowh->TOTAL_QTYP, 2, '.', ','); ?>" readonly></td>
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
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div> -->
		<!-- <div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group cxx">
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
						<a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
					</div>
					<h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
				</div>
			</div>
		</div> -->
	</form>
</div>

<!-- myModal No DO-->
<div id="mymodal_no_do" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data No DO</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_no_do'>
					<thead>
						<th>No DO</th>
						<th>Tgl DO</th>
						<th>Wilayah</th>
						<th>Periode</th>
						<th>Status Req</th>
					</thead>
					<tbody>
						<?php
						$kdmts = $this->session->userdata['kdmts'];
						$sql = "SELECT minta_nodo.NO_DO AS NO_DO, 
							DATE_FORMAT(minta_nodo.TGL_DO,'%d-%m-%Y') AS TGL_DO,
							minta_nodo.WILAYAH AS WILAYAH, 
							minta_nodo.PER AS PER,
							CASE minta_nodo.REQ_DO
								WHEN '0' THEN 'MASIH DIAJUKAN'
								WHEN '1' THEN 'BISA DIGUNAKAN UNTUK SP'
							END AS REQ_DO
							FROM minta_nodo
							WHERE minta_nodo.WILAYAH='$kdmts' ";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='NDJVAL text_input'><?php echo $b->NO_DO; ?></td>
								<td class='TDJVAL text_input'><?php echo $b->TGL_DO; ?></td>
								<td class='KDJVAL text_input'><?php echo $b->WILAYAH; ?></td>
								<td class='PEJVAL text_input'><?php echo $b->PER; ?></td>
								<td class='RDJVAL text_input label'><?php echo $b->REQ_DO; ?></td>
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
		$('#modal_no_do').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" +
				"<'row'<'col-md-6'f><'col-md-6'l>>" +
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {
			$('input[type=search]').val('').keyup();
		});
	});
</script>

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
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#STOKAK" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#STOK" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARGA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARGAP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#QTY" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#QTYP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		//MyModal No DO
		$('#mymodal_no_do').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_no_do', function() {
			var val = $(this).parents("tr").find(".NDJVAL").text();
			target.parents("div").find(".NO_DO").val(val);
			var val = $(this).parents("tr").find(".TDJVAL").text();
			target.parents("div").find(".TGL_DO").val(val);
			$('#mymodal_no_do').modal('toggle');
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

	function fill_no_do() {
		var nod0 = $("#NO_DO").val();
		$.ajax({
			url: "<?= base_url('admin/Transaksi_SuratPesanan/mintanodo') ?>",
			data: {
				'nodo': nod0,
			},
			success: function(data) {
				// if(data!="KOSONG")
				if (data.length > 0) {
					$.each(data, function(i, item) {
						// if(data[i].respone=="KOSONG"){
						// 	console.log("Jika kosong");
						// } else {
						// 	$("#NODO").val(data[i].nodo);
						// 	$("#TGL_DO").val(data[i].tgldo);
						// 	alert("No DO akan dipakai");
						// }
						$("#NO_DO").val(data[i].nodo);
						$("#TGL_DO").val(data[i].tgldo);
					});
				} else {
					alert("No Do sedang diajukan dan masih diproses!");
				}
			}
		});
	}

	function btIsiNoDo() {
		if (confirm("Yakin isi No DO ? \n Setelah No Do diisi, maka form ini hanya bisa lihat data")) {
			document.getElementById("suratpesanan").submit();
			// window.location.replace("<?php echo base_url('admin/Transaksi_SuratPesanan/update_aksi/' . $rowh->ID) ?>");
		}
	}

	function hitung() {}

	function tambah() {}

	function hapus() {}
</script>
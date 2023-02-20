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
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Input <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksisuratjalan" name="transaksisuratjalan" action="<?php echo base_url('admin/Transaksi_Surat_Jalan/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value='' readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tanggal </label>
						</div>
						<div class="col-md-2">
							<input type="text" class="date form-control" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																		echo $_POST["TGL"];
																																	} else echo date('d-m-Y'); ?>" onclick="select()">
						</div>
						<div class="col-md-1">
							<label class="label">No Kendaraan </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NOPOL" id="NOPOL" name="NOPOL" type="text" value=''>
						</div>
						<div class="col-md-1">
							<label class="label">Pkp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input PKP" id="PKP" name="PKP" type="text" value='' readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2 input-group">
							<input name="NAMAC" id="NAMAC" maxlength="30" type="text" class="form-control NAMAC text_input" onkeypress="return tabE(this,event)" placeholder="Nama Customer" readonly>
							<span class="input-group-btn">
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_no_so" data-toggle="modal" href="#lupno_so"><i class="fa fa-search"></i></a>
							</span>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input KODERAY" id="KODERAY" name="KODERAY" type="text" value='' placeholder="Koderayon" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KODEC" id="KODEC" name="KODEC" type="text" value='' placeholder="Kode Customer" readonly>
						</div>
						<div class="col-md-1">
							<label class="label"> </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KOTA" id="KOTA" name="KOTA" type="text" value='' placeholder="Kota" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Sp </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_SO" id="NO_SO" name="NO_SO" type="text" value='' readonly>
						</div>
						<div class="col-md-1">
							<label class="label">No Do </label>
						</div>
						<div class="col-md-2 input-group">
							<input class="form-control text_input NO_DO" id="NO_DO" name="NO_DO" type="text" value='' readonly>
							<input class="form-control text_input TGL_DO" id="TGL_DO" name="TGL_DO" type="hidden" value='' readonly>
							<input class="form-control text_input TGL_SO" id="TGL_SO" name="TGL_SO" type="hidden" value='' readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Max Kredit </label>
						</div>
						<div class="col-md-2">
							<input class="form-control MAXKRE rightJustified text-primary font-weight-bold" id="MAXKRE" name="MAXKRE" type="text" value='0' onclick="select()" onkeyup="hitung()" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Piutang </label>
						</div>
						<div class="col-md-2">
							<input class="form-control PIU rightJustified text-primary font-weight-bold" id="PIU" name="PIU" type="text" value='0' onclick="select()" onkeyup="hitung()" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Sisa BMPKP </label>
						</div>
						<div class="col-md-2">
							<input class="form-control BMPKP rightJustified text-primary font-weight-bold" id="BMPKP" name="BMPKP" type="text" value='0' onkeyup="hitung()" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Exp Piutang </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input EXP_PIU" id="EXP_PIU" name="EXP_PIU" type="text" value='' readonly>
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
								<th width="150px">Kode Barang</th>
								<th width="120px">Warna</th>
								<th width="100px">Size</th>
								<th width="100px">Golongan</th>
								<th width="120px">Lusin</th>
								<th width="120px">Pair</th>
								<th width="120px">Harga Lusin</th>
								<th width="120px">Harga Pair</th>
								<th width="100px">Disc 1</th>
								<th width="100px">Disc 2</th>
								<th width="100px">Disc 3</th>
								<th width="100px">Disc 4</th>
								<th width="100px">T Disc</th>
								<th width="120px">Jumlah</th>
								<th width="1px"></th>
							</tr>
						</thead>
						<tbody id="show-data">
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_BRG[]" id="KD_BRG0" type="text" class="form-control KD_BRG" readonly></td>
								<td><input name="WARNA[]" id="WARNA0" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE0" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOL[]" id="GOL0" type="text" class="form-control GOL" maxlength="1" readonly></td>
								<td><input name="QTY[]" value="0" id="QTY0" type="text" class="form-control QTY rightJustified text-primary" readonly></td>
								<td><input name="QTYP[]" value="0" id="QTYP0" type="text" class="form-control QTYP rightJustified text-primary" readonly></td>
								<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" value="0" id="HARGA0" type="text" class="form-control HARGA rightJustified text-primary" readonly></td>
								<td><input name="HARGAP[]" onclick="select()" onkeyup="hitung()" value="0" id="HARGAP0" type="text" class="form-control HARGAP rightJustified text-primary" readonly></td>
								<td><input name="DISC1[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC10" type="text" class="form-control DISC1 rightJustified text-danger"></td>
								<td><input name="DISC2[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC20" type="text" class="form-control DISC2 rightJustified text-danger"></td>
								<td><input name="DISC3[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC30" type="text" class="form-control DISC3 rightJustified text-danger"></td>
								<td><input name="DISC4[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC40" type="text" class="form-control DISC4 rightJustified text-danger"></td>
								<td><input name="DISC[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC0" type="text" class="form-control DISC rightJustified text-danger" readonly></td>
								<td><input name="TOTAL[]" value="0" id="TOTAL0" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
							</tr>
						</tbody>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TQTY rightJustified text-primary font-weight-bold" id="TQTY" name="TQTY" value="0" readonly></td>
							<td><input class="form-control TQTYP rightJustified text-primary font-weight-bold" id="TQTYP" name="TQTYP" value="0" readonly></td>
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
					<label class="label">Stand </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control STAND rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="STAND" name="STAND">
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Pembulatan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BULAT rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="BULAT" name="BULAT">
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Sub Total </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TTOTAL rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="TTOTAL" name="TTOTAL" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Jenis </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control JENIS rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="JENIS" name="JENIS">
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Kontan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control KONTAN rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="KONTAN" name="KONTAN">
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Disc Rp </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TDISC rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="0" id="TDISC" name="TDISC" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">BS </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BS rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="BS" name="BS">
				</div>
				<div class="col-md-2" style="text-align: right;">
					<label class="label">Perubahan Harga </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control PRB_HRG rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="PRB_HRG" name="PRB_HRG">
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-1">
					<label class="label">Nett </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control NETT rightJustified text-success font-weight-bold" onchange="hitung()" value="0" id="NETT" name="NETT" readonly>
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

<!-- myModal No SO-->
<div id="mymodal_no_so" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data Pemesanan</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_no_so'>
					<thead>
						<th>No Bukti</th>
						<th>Tanggal</th>
						<th>No DO</th>
						<th>Kode Customer</th>
						<th>Nama Customer</th>
						<th>Kode Rayon</th>
						<th>Kota</th>
						<th>PKP</th>
						<th>Max Kredit</th>
						<th>Piutang</th>
						<th>Exp Piutang</th>
					</thead>
					<tbody>
						<?php
						$per = $this->session->userdata['periode'];
						$kdmts = $this->session->userdata['kdmts'];
						$sql = "SELECT so.NO_BUKTI AS NO_SO, 
								so.TGL AS TGL_SO, 
								so.NO_DO AS NO_DO, 
								so.TGL_DO AS TGL_DO,
								so.TOTAL_QTY AS TOTAL_QTY,
								so.TOTAL_QTYP AS TOTAL_QTYP,
								sod.KODEC AS KODEC,
								sod.NAMAC AS NAMAC,
								sod.PKP AS PKP,
								sod.KOTA AS KOTA,
								sod.MAXKRE AS MAXKRE,
								sod.KODERAY AS KODERAY,
								sod.PIU AS PIU,
								sod.EXP_PIU AS EXP_PIU
							FROM so, sod
							WHERE so.NO_BUKTI=sod.NO_BUKTI
							AND so.WILAYAH = '$kdmts'
							AND so.PER = '$per'
							AND so.REQ_DO = 0
							GROUP BY so.NO_BUKTI
							ORDER BY so.NO_BUKTI";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='NSSVAL'><a href="#" class="select_no_so"><?php echo $b->NO_SO; ?></td>
								<td class='TSSVAL text_input'><?php echo $b->TGL_SO; ?></a></td>
								<td class='NDSVAL text_input'><?php echo $b->NO_DO; ?></td>
								<td class='KDSVAL text_input'><?php echo $b->KODEC; ?></td>
								<td class='NMSVAL text_input'><?php echo $b->NAMAC; ?></td>
								<td class='KRSVAL text_input'><?php echo $b->KODERAY; ?></td>
								<td class='KTSVAL text_input'><?php echo $b->KOTA; ?></td>
								<td class='PKSVAL text_input'><?php echo $b->PKP; ?></td>
								<td class='MKSVAL text_input'><?php echo $b->MAXKRE; ?></td>
								<td class='PISVAL text_input'><?php echo $b->PIU; ?></td>
								<td class='EPSVAL text_input'><?php echo $b->EXP_PIU; ?></td>
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

<!-- MyModal Exp Piutang -->
<div id="mymodal_exp_piu" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Sisa BMPKP melebihi batas!</h4>
			</div>
			<div class="modal-body">
				<div class="form-group" align="left">
					<label class="label">Masukkan Key Date :</label>
					<input onchange="keypiu()" type="text" class="form-control KEYDATE" id="KEYDATE" placeholder="keydate.." name="KEYDATE" autocomplete="off" required>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#modal_no_so').DataTable({
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

<script type="text/javascript">
	$(document).ready(function() {
		$('#modal_exp_piu').DataTable({});
		$('.modal-footer').on('click', '#close', function() {});
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
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#BMPKP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#MAXKRE").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#PIU").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TQTY").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TQTYP").autoNumeric('init', {
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
		$("#PRB_HRG").autoNumeric('init', {
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
			$("#HARGAP" + i.toString()).autoNumeric('init', {
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
			$("#TOTAL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		//MyModal No SO
		$('#mymodal_no_so').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		//MyModal Exp Piut
		$('#mymodal_exp_piu').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
			setTimeout(function() {
				$('#KEYDATE').focus().select();
			}, 300)
		});

		$('body').on('click', '.select_no_so', function() {
			var val = $(this).parents("tr").find(".NSSVAL").text();
			target.parents("div").find(".NO_SO").val(val);
			var val = $(this).parents("tr").find(".TSSVAL").text();
			target.parents("div").find(".TGL_SO").val(val);
			var val = $(this).parents("tr").find(".NDSVAL").text();
			target.parents("div").find(".NO_DO").val(val);
			var val = $(this).parents("tr").find(".TDSVAL").text();
			target.parents("div").find(".TGL_DO").val(val);
			var val = $(this).parents("tr").find(".TQSVAL").text();
			target.parents("div").find(".TOTAL_QTY").val(val);
			var val = $(this).parents("tr").find(".TPSVAL").text();
			target.parents("div").find(".TOTAL_QTYP").val(val);
			var val = $(this).parents("tr").find(".KDSVAL").text();
			target.parents("div").find(".KODEC").val(val);
			var val = $(this).parents("tr").find(".NMSVAL").text();
			target.parents("div").find(".NAMAC").val(val);
			var val = $(this).parents("tr").find(".KRSVAL").text();
			target.parents("div").find(".KODERAY").val(val);
			var val = $(this).parents("tr").find(".KTSVAL").text();
			target.parents("div").find(".KOTA").val(val);
			var val = $(this).parents("tr").find(".PKSVAL").text();
			target.parents("div").find(".PKP").val(val);
			var val = $(this).parents("tr").find(".MKSVAL").text();
			target.parents("div").find(".MAXKRE").val(val);
			var val = $(this).parents("tr").find(".PISVAL").text();
			target.parents("div").find(".PIU").val(val);
			var val = $(this).parents("tr").find(".EPSVAL").text();
			target.parents("div").find(".EXP_PIU").val(val);
			$('#mymodal_no_so').modal('toggle');
			var no_so = $(this).parents("tr").find(".NSSVAL").text();
			$.ajax({
				type: 'get',
				url: '<?php echo base_url('index.php/admin/Transaksi_Surat_Jalan/filter_no_so'); ?>',
				data: {
					no_so: no_so
				},
				dataType: 'json',
				success: function(response) {
					// alert(response);
					var html = '';
					var i;
					for (i = 0; i < response.length; i++) {
						html += '<tr>' +
							'<td><input name="REC[]" id=REC' + i + ' type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly value=' + (i + 1) + ' ></td>' +
							'<td><input name="KD_BRG[]" id=KD_BRG' + i + ' type="text" class="form-control KD_BRG" value="' + response[i].KD_BRG + '" readonly></td>' +
							'<td><input name="WARNA[]" id=WARNA' + i + ' type="text" class="form-control WARNA" value="' + response[i].WARNA + '" readonly></td>' +
							'<td><input name="SIZE[]" id=SIZE' + i + ' type="text" class="form-control SIZE" value="' + response[i].SIZE + '" readonly></td>' +
							'<td><input name="GOL[]" id=GOL' + i + ' type="text" class="form-control GOL" value="' + response[i].GOL + '" readonly></td>' +
							'<td><input name="QTY[]" id=QTY' + i + ' type="text" class="form-control QTY rightJustified text-primary" value="' + numberWithCommas(response[i].QTY) + '" readonly></td>' +
							'<td><input name="QTYP[]" id=QTYP' + i + ' type="text" class="form-control QTYP rightJustified text-primary" value="' + numberWithCommas(response[i].QTYP) + '" readonly></td>' +
							'<td><input name="HARGA[]" id=HARGA' + i + ' type="text" class="form-control HARGA rightJustified text-primary" value="' + numberWithCommas(response[i].HARGA) + '" readonly></td>' +
							'<td><input name="HARGAP[]" id=HARGAP' + i + ' type="text" class="form-control HARGAP rightJustified text-primary" value="' + numberWithCommas(response[i].HARGAP) + '" readonly></td>' +
							'<td><input name="DISC1[]" id=DISC1' + i + ' type="text" class="form-control DISC1 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC2[]" id=DISC2' + i + ' type="text" class="form-control DISC2 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC3[]" id=DISC3' + i + ' type="text" class="form-control DISC3 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC4[]" id=DISC4' + i + ' type="text" class="form-control DISC4 rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" ></td>' +
							'<td><input name="DISC[]" id=DISC' + i + ' type="text" class="form-control DISC rightJustified text-danger" value="0" onclick="select()" onkeyup="hitung()" readonly ></td>' +
							'<td><input name="TOTAL[]" id=TOTAL' + i + ' type="text" class="form-control TOTAL rightJustified text-primary" value="0" readonly></td>' +
							'</tr>';
					}
					idrow = i;
					$('#show-data').html(html);
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
						$("#HARGAP" + i.toString()).autoNumeric('init', {
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
						$("#TOTAL" + i.toString()).autoNumeric('init', {
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

	function keypiu() {
		var EXP_PIU = $('#EXP_PIU').val();
		var KEYDATE = $('#KEYDATE').val();
		console.log('Keydate :' + KEYDATE);
		console.log('Exp Piu :' + EXP_PIU);
		if (KEYDATE == EXP_PIU) {
			alert('OK')
			$('#mymodal_exp_piu').modal('hide');
		} else {
			alert('Keydate  Tidak Sama')
		}
	}

	function hitung() {
		var STAND = parseFloat($('#STAND').val().replace(/,/g, ''));
		var BULAT = parseFloat($('#BULAT').val().replace(/,/g, ''));
		var JENIS = parseFloat($('#JENIS').val().replace(/,/g, ''));
		var KONTAN = parseFloat($('#KONTAN').val().replace(/,/g, ''));
		var BS = parseFloat($('#BS').val().replace(/,/g, ''));
		var PRB_HRG = parseFloat($('#PRB_HRG').val().replace(/,/g, ''));
		var TQTY = 0;
		var TQTYP = 0;
		var TTOTAL = 0;
		var TDISC = 0;
		var MAXKRE = parseFloat($('#MAXKRE').val().replace(/,/g, ''));
		var PIU = parseFloat($('#PIU').val().replace(/,/g, ''));
		var EXP_PIU = $('#EXP_PIU').val();
		var KEYDATE = parseFloat($('#KEYDATE').val().replace(/,/g, ''));

		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var lusin = parseFloat($('#QTY' + i).val().replace(/,/g, ''));
			var pair = parseFloat($('#QTYP' + i).val().replace(/,/g, ''));
			var harga = parseFloat($('#HARGA' + i).val().replace(/,/g, ''));
			var hargap = parseFloat($('#HARGAP' + i).val().replace(/,/g, ''));
			var disc1 = parseFloat($('#DISC1' + i).val().replace(/,/g, ''));
			var disc2 = parseFloat($('#DISC2' + i).val().replace(/,/g, ''));
			var disc3 = parseFloat($('#DISC3' + i).val().replace(/,/g, ''));
			var disc4 = parseFloat($('#DISC4' + i).val().replace(/,/g, ''));

			var disc = disc1 + disc2 + disc3 + disc4;
			if (isNaN(disc)) disc = 0;
			$('#DISC' + i).val(numberWithCommas(disc));
			$('#DISC' + i).autoNumeric('update');

			var total = (lusin * harga) + (pair * hargap);
			if (isNaN(total)) total = 0;
			$('#TOTAL' + i).val(numberWithCommas(total));
			$('#TOTAL' + i).autoNumeric('update');
		};
		$(".QTY").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TQTY += val;
		});
		$(".QTYP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TQTYP += val;
		});
		$(".DISC").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TDISC += val;
		});
		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TTOTAL += val;
		});
		$(".BMPKP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			BMPKP += val;
		});

		var BMPKP = MAXKRE - PIU;
		if (BMPKP < 0) {
			$('#mymodal_exp_piu').modal('show');
		}

		var TTDISC = STAND + BULAT + JENIS + KONTAN + BS + PRB_HRG;
		var NETT = TTOTAL - TDISC;

		if (isNaN(STAND)) STAND = 0;
		if (isNaN(BULAT)) BULAT = 0;
		if (isNaN(JENIS)) JENIS = 0;
		if (isNaN(KONTAN)) KONTAN = 0;
		if (isNaN(BS)) BS = 0;
		if (isNaN(PRB_HRG)) PRB_HRG = 0;
		if (isNaN(TQTY)) TQTY = 0;
		if (isNaN(TQTYP)) TQTYP = 0;
		if (isNaN(TTDISC)) TTDISC = 0;
		if (isNaN(TTOTAL)) TTOTAL = 0;
		if (isNaN(MAXKRE)) MAXKRE = 0;
		if (isNaN(NETT)) NETT = 0;

		$('#STAND').val(numberWithCommas(STAND));
		$('#BULAT').val(numberWithCommas(BULAT));
		$('#JENIS').val(numberWithCommas(JENIS));
		$('#KONTAN').val(numberWithCommas(KONTAN));
		$('#BS').val(numberWithCommas(BS));
		$('#PRB_HRG').val(numberWithCommas(PRB_HRG));
		$('#TQTY').val(numberWithCommas(TQTY));
		$('#TQTYP').val(numberWithCommas(TQTYP));
		$('#TDISC').val(numberWithCommas(TTDISC));
		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$('#BMPKP').val(numberWithCommas(BMPKP));
		$('#MAXKRE').val(numberWithCommas(MAXKRE));
		$('#NETT').val(numberWithCommas(NETT));

		$('#STAND').autoNumeric('update');
		$('#BULAT').autoNumeric('update');
		$('#JENIS').autoNumeric('update');
		$('#KONTAN').autoNumeric('update');
		$('#BS').autoNumeric('update');
		$('#PRB_HRG').autoNumeric('update');
		$("#TQTY").autoNumeric('update');
		$('#TQTYP').autoNumeric('update');
		$('#TDISC').autoNumeric('update');
		$('#TTOTAL').autoNumeric('update');
		$('#BMPKP').autoNumeric('update');
		$('#MAXKRE').autoNumeric('update');
		$('#NETT').autoNumeric('update');
	}

	function tambah() {}

	function hapus() {}
</script>
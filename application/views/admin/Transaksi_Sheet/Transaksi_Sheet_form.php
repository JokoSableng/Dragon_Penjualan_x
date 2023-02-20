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
		<i class="fas fa-university"></i> Input <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="sheet" name="sheet" action="<?php echo base_url('admin/Transaksi_PenjualanSheet/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="input-group col-md-2">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value='' readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl </label>
						</div>
						<div class="input-group col-md-2">
							<input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																					echo $_POST["TGL"];
																																				} else echo date('d-m-Y'); ?>" onclick="select()">
						</div>
						<div class="col-md-1">
							<label class="label">No Sj </label>
						</div>
						<div class="col-md-2 input-group">
							<input name="NO_SURAT" id="NO_SURAT" type="text" class="form-control NO_SURAT text_input" onkeypress="return tabE(this,event)" readonly>
							<span class="input-group-btn">
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_no_surat" data-toggle="modal" href="#lupsj"><i class="fa fa-search"></i></a>
							</span>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl SJ </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input TGL_SJ" id="TGL_SJ" name="TGL_SJ" type="text" value='' readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Faktur </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_FKTR" id="NO_FKTR" name="NO_FKTR" type="text" value=''>
						</div>
						<div class="col-md-1">
							<label class="label">Kode Fak </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KD_FKTR" id="KD_FKTR" name="KD_FKTR" type="text" value=''>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl Fak </label>
						</div>
						<div class="col-md-2">
							<input type="text" class="date form-control text_input" id="TGL_FKTR" name="TGL_FKTR" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																							echo $_POST["TGL_FKTR"];
																																						} else echo date('d-m-Y'); ?>" onclick="select()">
						</div>
						<div class="col-md-1">
							<label class="label">Invoice </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input INVOICE" id="INVOICE" name="INVOICE" type="text" value=''>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No SO </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_SO" id="NO_SO" name="NO_SO" type="text" value='' readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Customer </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KODEC" id="KODEC" name="KODEC" type="text" value='' readonly>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input WILAYAH" id="WILAYAH" name="WILAYAH" type="text" value='' readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NAMAC" id="NAMAC" name="NAMAC" type="text" value='' readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Keterangan </label>
						</div>
						<div class="col-md-5">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value=''>
						</div>
						<div class="col-md-1">
							<label class="label">Harga Baru </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input HRG_BR" id="" name="HRG_BR" type="text" value=''>
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
								<th width="150px">Kd Bahan</th>
								<th width="150px">Na Bahan</th>
								<th width="125px">Warna</th>
								<th width="125px">Gol</th>
								<th width="125px">Satuan</th>
								<th width="125px">Meter</th>
								<th width="100px">Harga</th>
								<th width="100px">Disc 1</th>
								<th width="150px">Disc 2</th>
								<th width="150px">Disc 3</th>
								<th width="150px">Disc 4</th>
								<th width="150px">Disc Rp</th>
								<th width="100px">Disc</th>
								<th width="100px">Jumlah</th>
								<th width="100px">Ket 1</th>
								<th width="1px"></th>
							</tr>
						</thead>
						<tbody id="show-data">
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_BHN[]" id="KD_BHN0" type="text" class="form-control KD_BHN text_input" readonly></td>
								<td><input name="NA_BHN[]" id="NA_BHN0" type="text" class="form-control NA_BHN text_input" readonly></td>
								<td><input name="WARNA[]" id="WARNA0" type="text" class="form-control WARNA text_input" readonly></td>
								<td><input name="GOL[]" id="GOL0" type="text" class="form-control GOL text_input" readonly></td>
								<td><input name="SATUAN[]" id="SATUAN0" type="text" class="form-control SATUAN text_input" readonly></td>
								<td><input name="METER[]" id="METER0" type="text" class="form-control METER text_input" readonly></td>
								<td><input name="HARGA[]" onclick="select()" onkeyup="hitung()" value="0" id="HARGA0" type="text" class="form-control HARGA rightJustified text-primary" readonly></td>
								<td><input name="DISC1[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC10" type="text" class="form-control DISC1 rightJustified text-danger"></td>
								<td><input name="DISC2[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC20" type="text" class="form-control DISC2 rightJustified text-danger"></td>
								<td><input name="DISC3[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC30" type="text" class="form-control DISC3 rightJustified text-danger"></td>
								<td><input name="DISC4[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC40" type="text" class="form-control DISC4 rightJustified text-danger"></td>
								<td><input name="DISCRP[]" onclick="select()" onkeyup="hitung()" value="0" id="DISCRP0" type="text" class="form-control DISCRP rightJustified text-danger"></td>
								<td><input name="DISC[]" onclick="select()" onkeyup="hitung()" value="0" id="DISC0" type="text" class="form-control DISC rightJustified text-danger"></td>
								<td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value="0" id="TOTAL0" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
								<td><input name="KET1[]" id="KET10" type="text" class="form-control KET1 text_input"></td>
								<!-- <td>
									<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
										<i class="fa fa-fw fa-trash"></i>
									</button>
								</td> -->
							</tr>
						</tbody>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TTOTAL rightJustified text-primary font-weight-bold" id="TTOTAL" name="TTOTAL" value="0" readonly></td>
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
					<input class="form-control STAND rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="STAND" name="STAND" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Pembulatan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BULAT rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="BULAT" name="BULAT" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Rate </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control RATE rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="RATE" name="RATE" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Dpp </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DPP rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="DPP" name="DPP" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Jenis </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control JENIS rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="JENIS" name="JENIS" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Kontan </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control KONTAN rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="KONTAN" name="KONTAN" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">T Disc </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control TDISK rightJustified text-danger font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="0" id="TDISK" name="TDISK" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Pot </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control POT rightJustified text-primary font-weight-bold" onfocusout="hitung()" onchange="hitung()" value="0" id="POT" name="POT" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Bs </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BS rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="BS" name="BS" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Perubahan Harga </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control PRB_HRG rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="PRB_HRG" name="PRB_HRG" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Sisa </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control SISA rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="SISA" name="SISA" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">PPN </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control PPN rightJustified text-danger font-weight-bold" onchange="hitung()" value="0" id="PPN" name="PPN" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<label class="label">Bb </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control BB rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="BB" name="BB" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Ob </label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control OB rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="OB" name="OB" readonly>
				</div>
				<div class="col-md-1">
					<label class="label">Dpp 1</label>
				</div>
				<div class="col-md-2 ">
					<input class="form-control DPP1 rightJustified text-primary font-weight-bold" onchange="hitung()" value="0" id="DPP1" name="DPP1" readonly>
				</div>
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
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#TTOTAL").autoNumeric('init', {
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
		$("#DPP").autoNumeric('init', {
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
		$("#TDISK").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#POT").autoNumeric('init', {
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
		$("#SISA").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#PPN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#BB").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#OB").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#DPP1").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#NETT").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#RATE").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
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
			var no_surat = $(this).parents("tr").find(".NSSVAL").text();
			$.ajax({
				type: 'get',
				url: '<?php echo base_url('index.php/admin/Transaksi_PenjualanSheet/filter_no_surat'); ?>',
				data: {
					no_surat: no_surat
				},
				dataType: 'json',
				success: function(response) {
					// alert(response);
					var html = '';
					var i;
					for (i = 0; i < response.length; i++) {
						html += '<tr>' +
							'<td><input name="REC[]" id=REC' + i + ' type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly value=' + (i + 1) + ' ></td>' +
							'<td><input name="KD_BHN[]" value="' + response[i].KD_BHN + '" id=KD_BHN' + i + ' type="text" class="form-control KD_BHN text_input" readonly></td>' +
							'<td><input name="NA_BHN[]" value="' + response[i].NA_BHN + '" id=NA_BHN' + i + ' type="text" class="form-control NA_BHN text_input" readonly></td>' +
							'<td><input name="WARNA[]" value="' + response[i].WARNA + '" id=WARNA' + i + ' type="text" class="form-control WARNA text_input" readonly></td>' +
							'<td><input name="GOL[]" value="' + response[i].GOL + '" id=GOL' + i + ' type="text" class="form-control GOL text_input" readonly></td>' +
							'<td><input name="SATUAN[]" value="' + response[i].SATUAN + '" id=SATUAN' + i + ' type="text" class="form-control SATUAN text_input" readonly></td>' +
							'<td><input name="METER[]" value="' + response[i].METER + '" id=METER' + i + ' type="text" class="form-control METER text_input" readonly></td>' +
							'<td><input name="HARGA[]" value="' + numberWithCommas(response[i].HARGA) + '" id=HARGA' + i + ' type="text" class="form-control HARGA rightJustified text-primary" readonly></td>' +
							'<td><input name="DISC1[]" value="0" id=DISC1' + i + ' type="text" class="form-control DISC1 rightJustified text-danger" readonly></td>' +
							'<td><input name="DISC2[]" value="0" id=DISC2' + i + ' type="text" class="form-control DISC2 rightJustified text-danger" readonly></td>' +
							'<td><input name="DISC3[]" value="0" id=DISC3' + i + ' type="text" class="form-control DISC3 rightJustified text-danger" readonly></td>' +
							'<td><input name="DISC4[]" value="0" id=DISC4' + i + ' type="text" class="form-control DISC4 rightJustified text-danger" readonly></td>' +
							'<td><input name="DISCRP[]" value="0" id=DISCRP' + i + ' type="text" class="form-control DISCRP rightJustified text-danger" readonly></td>' +
							'<td><input name="DISC[]" value="0" id=DISC' + i + ' type="text" class="form-control DISC rightJustified text-danger" readonly></td>' +
							'<td><input name="TOTAL[]" value="' + numberWithCommas(response[i].TOTAL) + '" id=TOTAL' + i + ' type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>' +
							'<td><input name="KET1[]" value="" id=KET1' + i + ' type="text" class="form-control KET1 text_input"></td>' +
							'</tr>';
					}
					idrow = i;
					$('#show-data').html(html);
					jumlahdata = 100;
					for (i = 0; i <= jumlahdata; i++) {
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
						$("#TOTAL" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
					}
					$('input[type="checkbox"]').on('change', function() {
						this.value ^= 1;
						console.log(this.value)
					});
				}
			});
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
		var TTOTAL = 0;
		var STAND = 0;
		var BULAT = 0;
		var DPP = 0;
		var JENIS = 0;
		var KONTAN = 0;
		var TDISK = 0;
		var POT = 0;
		var BS = 0;
		var PRB_HRG = 0;
		var SISA = 0;
		var PPN = 0;
		var BB = 0;
		var OB = 0;
		var DPP1 = 0;
		var NETT = 0;

		// var total_row = idrow;
		// for (i=0;i<total_row;i++) {
		// 	var qty = parseFloat($('#QTY'+i).val().replace(/,/g, ''));
		// 	var qtyp = parseFloat($('#QTYP'+i).val().replace(/,/g, ''));
		// 	var harga = parseFloat($('#HARGA'+i).val().replace(/,/g, ''));
		// 	var hargap = parseFloat($('#HARGAP'+i).val().replace(/,/g, ''));

		// 	var qtyp = qty*12;
		// 	if(isNaN(qtyp)) qtyp = 0;
		// 	$('#QTYP'+i).val(numberWithCommas(qtyp));
		// 	$('#QTYP'+i).autoNumeric('update');

		// 	var hargap = harga*12;
		// 	if(isNaN(hargap)) hargap = 0;
		// 	$('#HARGAP'+i).val(numberWithCommas(hargap));
		// 	$('#HARGAP'+i).autoNumeric('update');

		// 	var total = qty*harga;
		// 	if(isNaN(total)) total = 0;
		// 	$('#TOTAL'+i).val(numberWithCommas(total));
		// 	$('#TOTAL'+i).autoNumeric('update');
		// };

		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TTOTAL += val;
		});

		NETT = TTOTAL - PPN;

		if (isNaN(TTOTAL)) TTOTAL = 0;
		if (isNaN(STAND)) STAND = 0;
		if (isNaN(BULAT)) BULAT = 0;
		if (isNaN(DPP)) DPP = 0;
		if (isNaN(JENIS)) JENIS = 0;
		if (isNaN(KONTAN)) KONTAN = 0;
		if (isNaN(TDISK)) TDISK = 0;
		if (isNaN(POT)) POT = 0;
		if (isNaN(BS)) BS = 0;
		if (isNaN(PRB_HRG)) PRB_HRG = 0;
		if (isNaN(SISA)) SISA = 0;
		if (isNaN(PPN)) PPN = 0;
		if (isNaN(BB)) BB = 0;
		if (isNaN(OB)) OB = 0;
		if (isNaN(DPP1)) DPP1 = 0;
		if (isNaN(NETT)) NETT = 0;
		if (isNaN(RATE)) RATE = 0;

		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$('#STAND').val(numberWithCommas(STAND));
		$('#BULAT').val(numberWithCommas(BULAT));
		$('#DPP').val(numberWithCommas(DPP));
		$('#JENIS').val(numberWithCommas(JENIS));
		$('#KONTAN').val(numberWithCommas(KONTAN));
		$('#TDISK').val(numberWithCommas(TDISK));
		$('#POT').val(numberWithCommas(POT));
		$('#BS').val(numberWithCommas(BS));
		$('#PRB_HRG').val(numberWithCommas(PRB_HRG));
		$('#SISA').val(numberWithCommas(SISA));
		$('#PPN').val(numberWithCommas(PPN));
		$('#BB').val(numberWithCommas(BB));
		$('#OB').val(numberWithCommas(OB));
		$('#DPP1').val(numberWithCommas(DPP1));
		$('#NETT').val(numberWithCommas(NETT));
		$('#RATE').val(numberWithCommas(RATE));

		$("#TTOTAL").autoNumeric('update');
		$("#STAND").autoNumeric('update');
		$("#BULAT").autoNumeric('update');
		$("#DPP").autoNumeric('update');
		$("#JENIS").autoNumeric('update');
		$("#KONTAN").autoNumeric('update');
		$("#TDISK").autoNumeric('update');
		$("#POT").autoNumeric('update');
		$("#BS").autoNumeric('update');
		$("#PRB_HRG").autoNumeric('update');
		$("#SISA").autoNumeric('update');
		$("#PPN").autoNumeric('update');
		$("#BB").autoNumeric('update');
		$("#OB").autoNumeric('update');
		$("#DPP1").autoNumeric('update');
		$("#NETT").autoNumeric('update');
		$("#RATE").autoNumeric('update');
	}

	function tambah() {}

	function hapus() {}
</script>
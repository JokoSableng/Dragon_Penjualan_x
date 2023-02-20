<?php
	foreach ($bkk_kasir as $rowh) {};
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
	<form id="transaksi_bkk_kasir" name="transaksi_bkk_kasir" action="<?php echo base_url('admin/Transaksi_Bkk_Kasir/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="input-group col-md-3">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NOBUKTI" id="NOBUKTI" name="NOBUKTI" type="text" value="<?php echo $rowh->NOBUKTI ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl </label>
						</div>
						<div class="col-md-3">
							<input 
								type="text" 
								class="date form-control TGLBUKTI" 
								id="TGLBUKTI" 
								name="TGLBUKTI" 
								data-date-format="dd-mm-yyyy" 
								value="<?php echo date('d-m-Y', strtotime($rowh->TGLBUKTI, TRUE)); ?>"
								onclick="select()" 
							>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Ket </label>
						</div>
						<div class="input-group col-md-3">
							<input class="form-control text_input URAIAN" id="URAIAN" name="URAIAN" type="text"  value="<?php echo $rowh->URAIAN ?>">
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
								<th width="250px">No Perk</th>
								<th width="360px">Uraian</th>
								<th width="320px">Jumlah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
                        <?php
							$no = 0;
							foreach ($bkk_kasir as $row) : 
						?>
							<tr>
                                <td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="NOPERK[]" id="NOPERK<?php echo $no; ?>" value="<?= $row->NOPERK ?>" type="text" class="form-control NOPERK"></td>
								<td><input name="URAI1[]" id="URAI1<?php echo $no; ?>" value="<?= $row->URAI1 ?>" type="text" class="form-control URAI1"></td>
								<td><input name="KTUNAI[]" onkeyup="hitung()" id="KTUNAI<?php echo $no; ?>" value="<?php echo number_format($row->KTUNAI, 2, '.', ','); ?>" type="text" class="form-control KTUNAI rightJustified text-primary"></td>
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
							<td><input class="form-control TOTAL rightJustified text-primary font-weight-bold" id="TOTAL" name="TOTAL" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" readonly></td>
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
		$("#TOTAL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#KTUNAI" + i.toString()).autoNumeric('init', {
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
		var TOTAL = 0;

		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var ktunai = parseFloat($('#KTUNAI'+i).val().replace(/,/g, ''));
		};
		$(".KTUNAI").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TOTAL+=val;
		});

		if(isNaN(TOTAL)) TOTAL = 0;

		$('#TOTAL').val(numberWithCommas(TOTAL));

		$("#TOTAL").autoNumeric('update');
	}

	function tambah() {

		var x = document.getElementById('datatable').insertRow(idrow + 1);
		var td1 = x.insertCell(0);
		var td2 = x.insertCell(1);
		var td3 = x.insertCell(2);
		var td4 = x.insertCell(3);
		var td5 = x.insertCell(4);

		var akun0 = "<div class='input-group'><select class='js-example-responsive form-control ARTICLE0' name='ARTICLE[]' id=ARTICLE0" + idrow + " onchange='coba(this.id)' onfocusout='hitung()' required></select></div>";
		var akun = akun0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = "<input name='NOPERK[]' id=NOPERK0" + idrow + " type='text' class='form-control NOPERK'>";
		td3.innerHTML = "<input name='URAI1[]' id=URAI10" + idrow + " type='text' class='form-control URAI1'>";
		td4.innerHTML = "<input name='KTUNAI[]' onkeyup='hitung()' value='0' id=KTUNAI" + idrow + " type='text' class='form-control KTUNAI rightJustified text-primary'>";
		td5.innerHTML = "<input type='hidden' value='0' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#KTUNAI" + i.toString()).autoNumeric('init', {
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
		select2x();
	});

	function select2x() {
		$('.js-example-responsive').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_Bkk_Kasir/getDataAjax_Article') ?>",
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
	var xx = '';
	var size = '';

	function formatSelection(repo) {
		xx = repo.warna;
		size = repo.size;
		return repo.text;
	}

	function coba(x) {
		var q = x.substring(7, 9);
		$('#WARNA' + q).val(xx);
		$('#SIZE' + q).val(size);
	}

</script>
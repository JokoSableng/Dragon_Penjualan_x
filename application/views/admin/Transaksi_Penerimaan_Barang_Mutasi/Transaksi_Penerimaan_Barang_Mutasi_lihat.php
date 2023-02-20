<?php
	foreach ($stockb as $rowh) {};
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
	.checkbox_container {width: 25px; height: 25px;}
	td input[type="checkbox"] {
		float: left;
		margin: 0 auto;
		width: 100%;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Lihat <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksipenerimaanbarangmutasi" name="transaksipenerimaanbarangmutasi" action="<?php echo base_url('admin/Transaksi_Penerimaan_Barang_Mutasi/lihat_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="input-group col-md-2">
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
								readonly
							>
						</div>
						<div class="col-md-1">
							<label class="label">No SJ </label>
						</div>
						<div class="input-group col-md-2">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NO_SJ" id="NO_SJ" name="NO_SJ" type="text" value="<?php echo $rowh->NO_SJ ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Tgl SJ</label>
						</div>
						<div class="col-md-2">
							<input 
								type="text" 
								class="date form-control TGL_SJ"
								id="TGL_SJ" 
								name="TGL_SJ" 
								data-date-format="dd-mm-yyyy" 
								value="<?php echo date('d-m-Y', strtotime($rowh->TGL_SJ, TRUE)); ?>"
								readonly
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
								<th width="175px">Article</th>
								<th width="125px">Warna</th>
								<th width="100px">Size</th>
								<th width="100px">Gol</th>
								<th width="150px">Lusin</th>
								<th width="150px">Pair</th>
								<th width="150px">Harga</th>
								<th width="200px">Jumlah</th>
								<th width="50px">Cek</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
                        <?php
							$no = 0;
							foreach ($stockb as $row) : 
						?>
							<tr>
                                <td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_BRG[]" id="KD_BRG<?php echo $no; ?>" value="<?= $row->KD_BRG ?>" type="text" class="form-control KD_BRG" readonly></td>
								<td><input name="WARNA[]" id="WARNA<?php echo $no; ?>" value="<?= $row->WARNA ?>" type="text" class="form-control WARNA" readonly></td>
								<td><input name="SIZE[]" id="SIZE<?php echo $no; ?>" value="<?= $row->SIZE ?>" type="text" class="form-control SIZE" readonly></td>
								<td><input name="GOL[]" id="GOL<?php echo $no; ?>" value="<?= $row->GOL ?>" type="text" class="form-control GOL" readonly></td>
								<td><input name="QTY[]" id="QTY<?php echo $no; ?>" value="<?php echo number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary" readonly></td>
								<td><input name="QTYP[]" id="QTYP<?php echo $no; ?>" value="<?php echo number_format($row->QTYP, 2, '.', ','); ?>" type="text" class="form-control QTYP rightJustified text-primary" readonly></td>
								<td><input name="HARGA[]" id="HARGA<?php echo $no; ?>" value="<?php echo number_format($row->HARGA, 2, '.', ','); ?>" type="text" class="form-control HARGA rightJustified text-primary" readonly></td>
								<td><input name="TOTAL[]" id="TOTAL<?php echo $no; ?>" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
								<td>
									<input <?php if ($row->TERIMA == "1") echo 'checked onclick="return false;"'; ?> name="TERIMA[]" id="TERIMA<?php echo $no; ?>" type="checkbox" value="<?= $row->TERIMA ?>" class="checkbox_container">
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
							<!-- <td><input class="form-control TOTAL rightJustified text-primary font-weight-bold" id="TOTAL" name="TOTAL" value="<?php echo number_format($row->TOTAL, 2, '.', ','); ?>" readonly></td> -->
						</tfoot>
					</table>
				</div>
            </div>
		</div>
		<br><br>
		<!-- <div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-4">
					<button type="button"  onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div> -->
		<!-- <div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group cxx">
						<button type="submit"  class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
							<a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
					</div>
					<h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
				</div>
			</div>
		</div> -->
	</form>
</div>
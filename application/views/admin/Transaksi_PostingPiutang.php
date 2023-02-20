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

	.checkbox_container {
		width: 25px;
		height: 25px;
	}

	td input[type="checkbox"] {
		float: left;
		margin: 0 auto;
		width: 100%;
	}
</style>

<br>
<section>
	<div class="container-fluid">
		<div class="alert alert-success" role="alert">
			<i class="fas fa-university"></i> Posting Piutang
		</div>
		<?php echo $this->session->flashdata('pesan') ?>
		<form name="posting_piutang" action="<?php echo base_url('admin/Transaksi_PostingPiutang/update'); ?>" class="form-horizontal" method="post">
			<table id="example" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>Tanggal</th>
						<th>Kode Cust</th>
						<th>Nama Cust</th>
						<th>Total Bayar</th>
						<th>Flag</th>
						<th>Status</th>
						<th width="20px"><input type="checkbox" id="selectall" /></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					foreach ($piu as $piup) :
					?>
						<tr>
							<td style="font-weight: bold; text-decoration: underline; color: blue;"><?php echo $piup->NO_BUKTI ?><input type="hidden" name="no_piu[]" value="<?php echo $piup->NO_BUKTI ?>"></td>
							<td class="text_input"><?php if ($piup->TGL == "2001-01-01") echo '';
													else echo date('d-m-Y', strtotime($piup->TGL, TRUE)) ?></td>
							<td class="text_input"><?php echo $piup->KODEC ?></td>
							<td class="text_input"><?php echo $piup->NAMAC ?></td>
							<td class="text_input"><?php echo $piup->TOTAL ?></td>
							<td class="text_input"><?php echo $piup->FLAG ?></td>
							<td class="text_input"><?php echo $piup->POSTED ?></td>
							<td><input type='checkbox' class='singlechkbox' name='check[]' id='check<?php echo $no; ?>' value="<?php echo $piup->NO_ID ?>"></td>
						</tr>
					<?php
						$no++;
					endforeach;
					?>
				</tbody>
			</table>
		</form>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],
			order: true,
		});
		$('#exampleb').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-2'l><'col-md-6'><'col-md-4'f>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],
			order: true,
		});
		$('.buttons-pdf, .buttons-excel, .buttons-print').addClass('btn btn-primary mb-3');
		$("div.test_btn").append(' <input type="submit" class="btn btn-primary mb-3" id="update" name="update" value="Update"> ');
		// $("div.test_btn").append(' <input type="submit" class="btn btn-danger mb-3" id="pembatalan" name="pembatalan" value="Pembatalan"> ');
	});
</script>


<script>
	$(document).ready(function() {
		$('body').on('keyup', 'input.numinput', function() {
			if (event.which != 190) {
				if (event.which >= 37 && event.which <= 40) return;
			}
			this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			hitung();
		});
		$('#myModalPP').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_pp', function() {
			var val = $(this).parents("tr").find(".NBPVAL").text();
			target.parents("div").find(".NO_BUKTI").val(val);
			$('#myModalPP').modal('toggle');
		});
	});
</script>
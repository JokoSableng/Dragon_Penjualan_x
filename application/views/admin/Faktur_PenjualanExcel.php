<style>
	.alert-container {
		background-color: #1cc88a;
		color: black;
		font-weight: bolder;
	}

	.label-title {
		color: black;
		font-weight: bold;
	}

	.label {
		color: black;
		font-weight: bold;
	}

	.detail {
		color: black;
		text-align: center;
	}

	.footerCss {
		color: black;
		font-weight: bold;
	}

	.text_input {
		font-size: small;
		color: black;
	}
</style>

<section>
	<div class="container-fluid">
		<br>
		<div class="alert alert-success alert-container" role="alert">
			<i class="fas fa-university"></i> Faktur Penjualan Excel
		</div>
		<?php echo $this->session->flashdata('pesan') ?>
		<form id="faktur_penjualanexcel" method="post" action="<?php echo base_url('admin/Faktur_PenjualanExcelHarian/index_Faktur_PenjualanExcelHarian') ?>">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Tanggal </label>
					</div>
					<div class="col-md-2">
						<input type="text" class="date form-control text_input" id="TGL_1" name="TGL_1" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																					echo $_POST["TGL_1"];
																																				} else echo date('d-m-Y'); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">s/d </label>
					</div>
					<div class="col-md-2">
						<input type="text" class="date form-control text_input" id="TGL_2" name="TGL_2" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																					echo $_POST["TGL_2"];
																																				} else echo date('d-m-Y'); ?>">
					</div>
					<div class="col-sm-1"></div>
					<div class=" col-sm-1 nopadding">
						<button class="btn btn-md btn-secondary" id="tampilkan" name="tampilkan"> Tampilkan </button>
					</div>
					<div class="dropdown col-sm-1 nopadding">
						<button class="btn btn-outline secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-download"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<button type="button" class="dropdown-item" id="btnExportCopy">
								<i class="fa fa-clone"></i> Copy
							</button>
							<button type="button" class="dropdown-item" id="btnExportExcel">
								<i class="fa fa-file-excel-o"></i> Excel
							</button>
							<button type="button" class="dropdown-item" id="btnExportCsv">
								<i class="fas fa-file-csv"></i> Csv
							</button>
							<button type="button" class="dropdown-item" id="btnExportPdf">
								<i class="fa fa-file-pdf-o"></i> Pdf
							</button>
							<!-- <button class="dropdown-item" id="print" name="print" value="print">
								<i class="fa fa-print"></i> Print
							</button> -->
						</div>
					</div>
				</div>
			</div>
			<hr class="m-t-10">
			<!-- PASTE DIBAWAH INI -->
			<!-- DISINI BATAS AWAL KOOLREPORT-->
			<?php

			use \koolreport\datagrid\DataTables;
			?>
			<div class="report-content">
				<?php
				DataTables::create(array(
					"dataStore" => $faktur_penjualanexcel,
					"name" => "example",
					"fixedHeader" => true,
					"showFooter" => true,
					"showFooter" => "bottom",
					"columns" => array(
						"TGL_SJ" => array(
							"label" => "Tgl SJ"
						),
						"TGL" => array(
							"label" => "Tgl"
						),
						"WILAYAH" => array(
							"label" => "Wilayah"
						),
						"TOTAL" => array(
							"label" => "Total",
							"type" => "number",
							"decimals" => 2,
							"decimalPoint" => ".",
							"thousandSeparator" => ",",
							"footer" => "sum",
						)
					),
					"cssClass" => array(
						"table" => "table table-hover table-striped table-bordered compact",
						"th" => "label-title",
						"td" => "detail",
						"tf" => "footerCss"
					),
					"options" => array(
						// "columnDefs"=>array(
						//     array(
						//         "width"=> 5, "targets"=>2
						//     ),
						// ),
						"paging" => true,
						"searching" => true,
						"colReorder" => true,
						"fixedHeader" => true,
						"select" => true,
						"showFooter" => true,
						"showFooter" => "bottom",
						"dom" => 'lfrtip', // B e dilangi
						// "dom" => '<"row"<col-md-6"B><"col-md-6"f>> <"row"<"col-md-12"t>><"row"<"col-md-12">>',
						"buttons" => array(
							array(
								"extend" => 'collection',
								"text" => 'Export',
								"buttons" => [
									'copy',
									'excel',
									'csv',
									'pdf'
									// 'print'
								],
							),
						),
					)
				));
				?>
			</div>
			<!-- DISINI BATAS AKHIR KOOLREPORT-->
		</form>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$(window).keydown(function(event) {
			if ((event.keyCode == 13)) {
				event.preventDefault();
				return false;
			}
		});
		$("#btnExportCopy").on("click", function() {
			var table = $('#example').DataTable();
			table.button('.buttons-copy').trigger();
		});
		$("#btnExportExcel").on("click", function() {
			var table = $('#example').DataTable();
			table.button('.buttons-excel').trigger();
		});
		$("#btnExportPdf").on("click", function() {
			var table = $('#example').DataTable();
			table.button('.buttons-pdf').trigger();
		});
		$("#btnExportCsv").on("click", function() {
			var table = $('#example').DataTable();
			table.button('.buttons-csv').trigger();
		});
		// $("#btnExportPrint").on("click", function() {
		// 	var table = $('#example').DataTable();
		// 	table.button('.buttons-print').trigger();
		// });
		$('.date').mask('00-00-0000');
	});
</script>
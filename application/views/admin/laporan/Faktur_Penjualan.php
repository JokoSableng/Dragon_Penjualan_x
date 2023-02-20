<style>
    .judulnya {
        color: black;
        background-color: #d2f4e8;
    }
</style>

<section>
    <div class="container-fluid">
        <div class="alert alert-success" role="alert">
            <i class="fas fa-money"></i> Faktur Penjualan
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="suratjalan" method="post" action="<?php echo base_url('admin/laporan/index_Faktur_Penjualan') ?>">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-4 nopadding">
                        <button class="btn btn-md btn-secondary" id="tampilkan" name="tampilkan"> Tampilkan </button>
                    </div>
                </div>
                <div class="dropdown col-md-2 nopadding">
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
                        <button class="dropdown-item" id="print" name="print" value="print">
                            <i class="fa fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>
            <hr class="m-t-10">
            <!-- PASTE DIBAWAH INI -->
            <!-- DISINI BATAS AWAL KOOLREPORT-->
            <?php
                use \koolreport\widgets\koolphp\Table;
                use \koolreport\widgets\google\BarChart;
                use \koolreport\datagrid\DataTables;
                use \koolreport\processes\Sort;
            ?>
            <div class="report-content">
                <?php
                DataTables::create(array(
                    "dataStore" => $faktur_penjualan,
                    "name" => "example",
                    "showFooter"=>true,
                    "showFooter"=>"bottom",
                    "columns" => array(
                        "KA" => array(
                            "label" => "Ka",
                        ),
                        "JLN" => array(
                            "label" => "Jln",
                        ),
                        "KOTA" => array(
                            "label" => "Kota",
                        ),
                        "INVOICE" => array(
                            "label" => "Invoice",
                        ),
                        "NOSJ" => array(
                            "label" => "Nosj",
                        ),
                        "TGL" => array(
                            "label" => "Tgl",
                        ),
                        "NOCANV" => array(
                            "label" => "Nocanv",
                        ),
                        "NAMA" => array(
                            "label" => "Nama",
                        ),
                        "ALMT" => array(
                            "label" => "Almt",
                        ),
                        "REC" => array(
                            "label" => "Rec",
                        ),
                        "URAIAN" => array(
                            "label" => "Uraian",
                        ),
                        "QTY" => array(
                            "label" => "Qty",
                        ),
                        "SATUAN" => array(
                            "label" => "Satuan",
                        ),
                        "HARGA" => array(
                            "label" => "Harga",
                        ),
                        "JUMLAH" => array(
                            "label" => "Jumlah",
                        )
                    ),
                    "cssClass" => array(
                        "table" => "table table-hover table-bordered",
                        "th" => "judulnya",
                        "td" => function ($row, $colName) {
                            if ($colName == "total") {
                                return "text-right";
                            }
                        }
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
                                    'pdf',
                                    'print'
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
<!-- DISINI BATAS AWAL SCRIPT KOOLREPORT-->
<script type="text/javascript">
    $(document).ready(function() {
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy'
        })
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
        $("#btnExportPrint").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-print').trigger();
        });
        $('.date').mask('00-00-0000');
    });
</script>

<script>

    $(document).ready(function() {});

</script>
<style>
    .label-title {
        color: black;
        font-weight: bold;
    }
    .detail {
        color: black;
        text-align: center;
    }
</style>

<section>
    <div class="container-fluid">
        <div class="alert alert-success" role="alert">
<!-- Ganti 1, sesuai judul -->
            <i class="fas fa-university"></i> Laporan Pengiriman Per Customer Article
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
<!-- Ganti 2, sesuai ganti 1 di CONTROLLER - LAPORAN -->
        <form id="frmrbiaya" method="post" action="<?php echo base_url('admin/laporan/index_Pengiriman_Per_Customer_Article') ?>">
<!-- Ganti 3, sesuai ganti 1 di CONTROLLER - LAPORAN -->
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label-title">Tanggal </label>
                    </div>
					<div class="col-md-3 nopadding">
                        <input type="text" class="date form-control text_input" id="TGLCI_1" name="TGLCI_1" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) { echo $_POST["TGLCI_1"]; } else echo date('d-m-Y'); ?>">
                    </div>
					<div class="col-md-1">
						<label class="label-title">s / d</label>
					</div>
                    <div class="col-md-3 nopadding">
                        <input type="text" class="date form-control text_input" id="TGLCI_2" name="TGLCI_2" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) { echo $_POST["TGLCI_2"]; } else echo date('d-m-Y'); ?>">
                    </div>
                </div>
            </div>
<!-- Batas ganti 3 -->
<!-- Ganti 4, sesuai ganti 1 di CONTROLLER - LAPORAN -->
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label-title">Kode Customer </label>
                    </div>
                    <div class="col-md-3">
<!-- Ganti 4.1 -->
                        <select class="js-example-responsive form-control KODECUS_1" name="KODECUS_1" id="KODECUS_1" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["KODECUS_1"] == $KODECUS_1) {
                                echo '<option value="' . $KODECUS_1 . '" selected >' . $KODECUS_1 . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="label-title">s/d </label>
                    </div>
                    <div class="col-md-3">
<!-- Ganti 4.2 -->
                        <select class="js-example-responsive form-control KODECUS_2" name="KODECUS_2" id="KODECUS_2" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["KODECUS_2"] == $KODECUS_2) {
                                echo '<option value="' . $KODECUS_2 . '" selected >' . $KODECUS_2 . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
<!-- Batas ganti 4 -->
            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-sm-2 nopadding">
                        <button class="btn btn-md btn-secondary" id="tampilkan" name="tampilkan"> Tampilkan </button>
                    </div>
                    <div class="dropdown col-sm-2 nopadding">
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
            </div>
            <hr class="m-t-10">
            <!-- PASTE DIBAWAH INI -->
            <!-- DISINI BATAS AWAL KOOLREPORT-->
            <?php
                use \koolreport\widgets\koolphp\Table;
                use \koolreport\widgets\google\BarChart;
                use \koolreport\datagrid\DataTables;
            ?>
            <div class="report-content">
                <?php
                DataTables::create(array(
// Ganti 5, sesuai ganti 3 CONTROLLER - LAPORAN
                    "dataStore" => $pengiriman_per_customer_article,
                    "name" => "example",
                    "showFooter"=>"bottom",
                    "columns" => array(
// Ganti 6, sesuai ganti 2 MODEL - LAPORAN MODEL sebelah kanan
                        "PER" => array(
                            "label" => "Periode",
                        ),
                        "KDMTS" => array(
                            "label" => "Kdmts",
                        ),
                        "NOSJ" => array(
                            "label" => "No Sj",
                        ),
                        "TGLCI" => array(
                            "label" => "Tanggal",
                            "formatValue" => function ($value) {
                                return date_format(date_create($value), "d-m-Y");
                            }
                        ),
                        "CUSTOMER" => array(
                            "label" => "Customer",
                        ),
                        "BRUTO" => array(
                            "label" => "Bruto",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
                            "footer"=>"sum",
                        ),
                        "TDISK" => array(
                            "label" => "Potong",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
                            "footer"=>"sum",
                        ),
                        "TOTAL" => array(
                            "label" => "Netto",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
                            "footer"=>"sum",
                        )
                    ),
                    "cssClass" => array(
                        "table" => "table table-hover table-bordered",
                        "th" => "label-title",
                        "td" => "detail",
                            function ($row, $colName) {
                                if ($colName == "DEBET") {
                                    return "text-right";
                                }
                                if ($colName == "KREDIT") {
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
                        "showFooter"=>true,
                        "showFooter"=>"bottom",
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
        </section>
<script type="text/javascript">
    $(document).ready(function() {
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
    });
</script>

<script>

    $(document).ready(function() {
// Ganti 7
        select_kodecus();
// Ganti 8
        select_kodecus_2();
        $(".date").datepicker({
            'dateFormat':'dd-mm-yy',
        })
    });

// Ganti 9, sesuai ganti 7
    function select_kodecus() {
// Ganti 10, sesuai ganti 4.1
        $('#KODECUS_1').select2({
            ajax: {
// Ganti 11, sesuai ganti 5 CONTROLLER - LAPORAN
                url: "<?= base_url('admin/laporan/getData_kodecus_rc_custom_1') ?>",
                dataType: "json",
                type: "post",
                delay: 250,
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
            placeholder: 'Masukan Kode Customer...',
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

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatSelection(repo) {
        return repo.text;
    }

// Ganti 12, sesuai ganti 8
    function select_kodecus_2() {
// Ganti 13, sesuai ganti 4.2
        $('#KODECUS_2').select2({
            ajax: {
// Ganti 14, sesuai ganti 8 CONTROLLER - LAPORAN
                url: "<?= base_url('admin/laporan/getData_kodecus_rc_custom_2') ?>",
                dataType: "json",
                type: "post",
                delay: 250,
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
            placeholder: 'Masukan Kode Customer ...',
            minimumInputLength: 0,
// Ganti 15
            templateResult: format2,
// Ganti 16
            templateSelection: formatSelection2
        });
    }

// Ganti 17, sesuai dengan gantii 15
    function format2(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

// Ganti 18, sesuai dengan ganti 16
    function formatSelection2(repo) {
        return repo.text;
    }

</script>
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
            <i class="fas fa-university"></i> Laporan Omzet PMS
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <!-- Ganti 2, sesuai ganti 1 di CONTROLLER - LAPORAN -->
        <form id="omzetpms" method="post" action="<?php echo base_url('admin/laporan/index_OmzetPms') ?>">
            <!-- Ganti 3, sesuai ganti 1 di CONTROLLER - LAPORAN -->
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label">Print
                        </label>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control text_input PLH" name="PLH" id="PLH">
                            <option <?php if (isset($_POST["tampilkan"]) &&  $_POST["PLH"] == 1) {echo 'selected ' . '' ;} ?> value='1' >Per PMS</option>
                            <option <?php if (isset($_POST["tampilkan"]) &&  $_POST["PLH"] == 2) {echo 'selected ' . '' ;} ?> value='2'>SEMUA</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label-title">Wilayah </label>
                    </div>
                    <div class="col-md-2">
                        <select class="js-example-responsive form-control WILAYAH_1" name="WILAYAH_1" id="WILAYAH_1" onchange="no_wilayah(this.id)" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["WILAYAH_1"] == $WILAYAH_1) {
                                echo '<option value="' . $WILAYAH_1 . '" selected >' . $WILAYAH_1 . " - " . $NAMA_WIL . '</option>';
                            } ?>
                        </select>
                        <input name="NAMA_WIL" id="NAMA_WIL" type="text" hidden <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["NAMA_WIL"] == $NAMA_WIL) {
                                echo 'value="' . $NAMA_WIL . '"';
                            } ?>>
                    </div>
                </div>
            </div>
            <!-- Batas ganti 3 -->
            <!-- Ganti 4, sesuai ganti 1 di CONTROLLER - LAPORAN -->
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
                    "dataStore" => $omzetpms,
                    "name" => "example",
                    "showFooter" => "bottom",
                    "columns" => array(
                        // Ganti 6, sesuai ganti 2 MODEL - LAPORAN MODEL sebelah kanan
                        "PMS" => array(
                            "label" => "Wilayah",
                        ),
                        "PERIODE_A" => array(
                            "label" => "Per A",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "PERIODE_B" => array(
                            "label" => "Per B",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "LOKAL" => array(
                            "label" => "Lokal",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "EXPORT" => array(
                            "label" => "Export",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "TOTAL" => array(
                            "label" => "Total",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        // Batas ganti 6
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
        select_koderay_1();
        select_koderay_2();
        select_wilayah_1();
    });

    function select_koderay_1() {
        $('#KODERAY_1').select2({
            ajax: {
                url: "<?= base_url('admin/laporan/getData_master_cust_koderay_1') ?>",
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
            placeholder: 'Masukan Koderay ...',
            minimumInputLength: 0,
            templateResult: format,
            templateSelection: formatSelection
        });
    }

    function select_koderay_2() {
        $('#KODERAY_2').select2({
            ajax: {
                url: "<?= base_url('admin/laporan/getData_master_cust_koderay_2') ?>",
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
            placeholder: 'Masukan Koderay ...',
            minimumInputLength: 0,
            templateResult: format,
            templateSelection: formatSelection
        });
    }

    function select_wilayah_1() {
        $('#WILAYAH_1').select2({
            ajax: {
                url: "<?= base_url('admin/laporan/getData_master_wilayah_wilayah_1') ?>",
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
            placeholder: 'Semua Wilayah ...',
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
	var namawil = '';

    function formatSelection(repo) {
        namawil = repo.nama;
        return repo.text;
    }
    
	function no_wilayah(xxx) {
        $('#NAMA_WIL').val(namawil);
        if(!namawil) $('#NAMA_WIL').val("<?= $NAMA_WIL?>");
	}
</script>
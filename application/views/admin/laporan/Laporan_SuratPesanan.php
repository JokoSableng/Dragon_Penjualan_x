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
            <i class="fas fa-university"></i> Laporan Surat Pesanan
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="suratpesanan" method="post" action="<?php echo base_url('admin/laporan/index_SuratPesanan') ?>">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label">Tanggal </label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
                                                                                                                                                echo $_POST["TGL"];
                                                                                                                                            } else echo date('d-m-Y'); ?>">
                    </div>
                    <div class="col-md-1">
                        <label class="label">Lokal
                        </label>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control text_input LOKAL" name="LOKAL" id="LOKAL">
                            <?php if (isset($_POST["tampilkan"]) && $_POST["LOKAL"] == '1') {
                                echo "<option value='1' selected>Lokal</option>";
                                echo "<option value='2'>Non Lokal</option>";
                            } else {
                                echo "<option value='1'>Lokal</option>";
                                echo "<option value='2' selected>Non Lokal</option>";
                            }
                            ?>
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
                        <select class="js-example-responsive form-control WILAYAH_1" name="WILAYAH_1" id="WILAYAH_1" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["WILAYAH_1"] == $WILAYAH_1) {
                                echo '<option value="' . $WILAYAH_1 . '" selected >' . $WILAYAH_1 . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-sm-7"></div>
                    <div class="col-sm-1 nopadding">
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

            use \koolreport\datagrid\DataTables;
            ?>
            <div class="report-content">
                <?php
                DataTables::create(array(
                    "dataStore" => $suratpesanan,
                    "name" => "example",
                    "fixedHeader" => true,
                    "showFooter" => true,
                    "showFooter" => "bottom",
                    "columns" => array(
                        "WILAYAH" => array(
                            "label" => "Wilayah",
                        ),
                        "NO_BUKTI" => array(
                            "label" => "No SP",
                        ),
                        "TGL" => array(
                            "label" => "Tgl SP",
                        ),
                        "KODEC" => array(
                            "label" => "Kode",
                        ),
                        "NAMAC" => array(
                            "label" => "Nama",
                        ),
                        "KD_BRG" => array(
                            "label" => "Article",
                        ),
                        "QTY" => array(
                            "label" => "Lusin",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "QTYP" => array(
                            "label" => "Pair",
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
</form>

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
    $(document).ready(function() {
        select_wilayah_1();
    });

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
            "<div class='select2-result-repository clearfix text_input'>" +
            "<div class='select2-result-repository__title text_input'></div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatSelection(repo) {
        return repo.text;
    }
</script>
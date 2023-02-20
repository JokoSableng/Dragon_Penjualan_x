<style>
    .judulnya {
        color: black;
        background-color: #d2f4e8;
    }
</style>

<section>
    <div class="container-fluid">
        <div class="alert alert-success" role="alert">
            <i class="fas fa-money"></i> Laporan Rincian Penjualan PMS
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="registerpenjualanpms" method="post" action="<?php echo base_url('admin/laporan/index_Register_Penjualan_PMS') ?>">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1 nopadding">
                        <label class="label-title">Periode </label>
                    </div>
                    <div class="col-md-3 nopadding">
                        <input type="text" value="<?= $PER ?>" class="form-control form-control-user" id="bulanPeriode" placeholder="mm/yyyy" name="PER">
                    </div>
                    <div class="col-md-1">
                        <label class="label-title">Wilayah </label>
                    </div>
                    <div class="col-md-3">
                        <select class="js-example-responsive form-control KDMTS" name="KDMTS" id="KDMTS" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["KDMTS"] == $KDMTS) {
                                echo '<option value="' . $KDMTS . '" selected >' . $KDMTS . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
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
                    "dataStore" => $register_penjualan_pms,
                    "name" => "example",
                    "showFooter"=>true,
                    "showFooter"=>"bottom",
                    "columns" => array(
                        "KDMTS" => array(
                            "label" => "Flag",
                        ),
                        "NOSJ" => array(
                            "label" => "Pelanggan",
                        ),
                        "TGLCI" => array(
                            "label" => "Tanggal Ci",
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
                            "label" => "T Disk",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
							"footer"=>"sum",
                        ),
                        "TOTAL" => array(
                            "label" => "Total",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
							"footer"=>"sum",
                        ),
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
    $(document).ready(function() {
        select_wilayah_1();
    });

    function select_wilayah_1() {
        $('#KDMTS').select2({
            ajax: {
                url: "<?= base_url('admin/laporan/getData_jl_cihdr_kdmts') ?>",
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
            placeholder: 'Masukan Wilayah ...',
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

</script>
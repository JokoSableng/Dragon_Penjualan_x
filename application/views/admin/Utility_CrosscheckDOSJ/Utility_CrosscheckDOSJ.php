<style>
    .judulnya {
        color: black;
        background-color: #d2f4e8;
    }
</style>

<section>
    <div class="container-fluid">
        <div class="alert alert-success" role="alert">
            <i class="fas fa-money"></i> CROSSCHECK SJ DO
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="rincianpenjualanwilayah" method="post" action="<?php echo base_url('admin/Utility_CrosscheckDOSJ/index_Utility_CrosscheckDOSJ') ?>">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1 nopadding">
                        <label class="label-title">NO SP </label>
                    </div>
                    <div class="col-md-2 nopadding">
                        <input type="text" value="<?php if (isset($_POST["NOSP"])) echo $_POST["NOSP"]; ?>" class="form-control form-control-user NOSP" id="NOSP"  name="NOSP">
                    </div>
                    <div class="col-md-1">
                        <label class="label-title">Article </label>
                    </div>
                    <div class="col-md-2">
                        <select class="js-example-responsive form-control KDBRG" name="KDBRG" id="KDBRG" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["KDBRG"] == $KDBRG) {
                                echo '<option value="' . $KDBRG . '" selected >' . $KDBRG . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="label-title">Kodecus </label>
                    </div>
                    <div class="col-md-2">
                        <select class="js-example-responsive form-control KODEC" name="KODEC" id="KODEC" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["KODEC"] == $KODEC) {
                                echo '<option value="' . $KODEC . '" selected >' . $KODEC . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1 nopadding">
                        <button class="btn btn-md btn-secondary" id="tampilkan" name="tampilkan"> Tampilkan </button>
                    </div>
                    <!-- <div class="dropdown col-md-1 nopadding">
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
                    </div> -->
                </div>
            </div>
            <hr class="m-t-10">
            <!-- PASTE DIBAWAH INI -->
            <!-- DISINI BATAS AWAL KOOLREPORT-->
            <?php
                use \koolreport\datagrid\DataTables;
            ?>
            <div class="report-content">
            <legend>SP</legend>
                <?php
                DataTables::create(array(
                    "dataStore" => $crosscheck_dosj_so,
                    "name" => "example",
                    "fastRender" => true,
                    "showFooter"=>true,
                    "showFooter"=>"bottom",
                    "columns" => array(
                        "NO_SP" => array(
                            "label" => "NO_SP",
                        ),
                        "NO_DO" => array(
                            "label" => "NO_DO",
                        ),
                        "KD_BRG" => array(
                            "label" => "ARTICLE",
                        ),
                        "QTY" => array(
                            "label" => "LUSIN",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
							"footer"=>"sum",
                        ),
                        "QTYP" => array(
                            "label" => "PAIR",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
							"footer"=>"sum",
                        ),
                        "KODEC" => array(
                            "label" => "KODECUS",
                        ),
                        "NAMAC" => array(
                            "label" => "NAMA",
                        ),
                    ),
                    "cssClass" => array(
                        "table" => "table table-hover table-bordered",
                        "th" => "judulnya",
                        "td" => function ($row, $colName) {
                            // if ($colName == "QTY" || $colName == "QTYP") {
                            //     return "text-right";
                            // }
                        }
                    ),
                    "options" => array(
                        "columnDefs"=>array(
                            array(
                                "className" => "dt-right", 
                                "targets" => [3,4],
                            ),
                        ),
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
            
            <hr class="m-t-10">

            <div class="report-content">
            <legend>SJ</legend>
                <?php
                DataTables::create(array(
                    "dataStore" => $crosscheck_dosj_jual,
                    "name" => "example2",
                    "fastRender" => true,
                    "showFooter"=>true,
                    "showFooter"=>"bottom",
                    "columns" => array(
                        "NO_SP" => array(
                            "label" => "NO_SP",
                        ),
                        "NO_DO" => array(
                            "label" => "NO_DO",
                        ),
                        "KD_BRG" => array(
                            "label" => "ARTICLE",
                        ),
                        "QTY" => array(
                            "label" => "LUSIN",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
							"footer"=>"sum",
                        ),
                        "QTYP" => array(
                            "label" => "PAIR",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
							"footer"=>"sum",
                        ),
                        "NO_SJ" => array(
                            "label" => "NO_SJ",
                        ),
                        "KODEC" => array(
                            "label" => "KODECUS",
                        ),
                        "NAMAC" => array(
                            "label" => "NAMA",
                        ),
                    ),
                    "cssClass" => array(
                        "table" => "table table-hover table-bordered",
                        "th" => "judulnya",
                        "td" => function ($row, $colName) {
                            // if ($colName == "QTY" || $colName == "QTYP") {
                            //     return "text-right";
                            // }
                        }
                    ),
                    "options" => array(
                        "columnDefs"=>array(
                            array(
                                "className" => "dt-right", 
                                "targets" => [3,4],
                            ),
                        ),
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
        select_article();
        select_kodecus();
    });

    function select_article() {
        $('#KDBRG').select2({
            ajax: {
                url: "<?= base_url('admin/Utility_CrosscheckDOSJ/getArticle') ?>",
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
			allowClear: true,
            dropdownAutoWidth: true,
            placeholder: 'Pilih Article ...',
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
    
    function select_kodecus() {
        $('#KODEC').select2({
            ajax: {
                url: "<?= base_url('admin/Utility_CrosscheckDOSJ/getKodec') ?>",
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
			allowClear: true,
            dropdownAutoWidth: true,
            placeholder: 'Pilih Kodecus ...',
            minimumInputLength: 0,
            templateResult: format,
            templateSelection: formatSelection
        });
    }

</script>
<style>
    .alert-container {
        background-color: #1cc88a;
        color: black;
        font-weight: bolder;
    }

    .table {
        height: 350px;
        overflow: scroll;
    }

    .table>thead>tr>th {
        background-color: #1cc88a;
        top: 0;
        position: sticky !important;
        z-index: 999;
        text-align: center;
        color: black;
        font-weight: bold;
    }

    .table>tbody>tr>td {
        color: black;
        text-align: center;
    }

    .table-striped>tbody>tr:nth-child(odd)>td,
    .table-striped>tbody>tr:nth-child(odd)>th {
        background-color: #ebedeb;
    }

    .table-striped>tbody>tr:nth-child(even)>td,
    .table-striped>tbody>tr:nth-child(even)>th {
        background-color: white;
    }

    .table>tbody>tr>td>div {
        text-align: center;
    }

    .table>tbody>tr>td>div>a {
        font-size: 13px;
        color: black;
        background-color: #7de89a;
    }

    .table>tbody>tr>td>div>a:hover {
        transition: 0.4s;
        color: #b3b3b3;
        background-color: #7de89a;
    }

    .table>tbody>tr>td>div>a::selection {
        color: white;
    }

    .table>tbody>tr>td>div>div>a:hover {
        transition: 0.4s;
        color: white;
        background-color: #1cc88a;
    }

    .table>tbody>tr>td>div>div>a>i {
        color: black;
        background-color: transparent;
    }

    /* Style tab */
    .tab {
        text-align: left;
        overflow: hidden;
    }

    .tab button {
        background-color: #D2F4E8;
        border-radius: 0.35rem;
        border-color: white;
        outline: none;
        cursor: pointer;
        padding: 10px 10px;
        transition: 0.4s;
    }

    .tab button:hover {
        background-color: #2E59D9;
        transition: 0.4s;
    }

    .tab button.active {
        background-color: #2E59D9;
        color: white;
    }

    .tab {
        font-weight: bold;
        color: black;
    }

    .text_input {
        font-size: small;
        color: black;
    }

    .label {
        color: black;
        font-weight: bold;
    }
</style>

<br>
<section>
    <div class="container-fluid">
        <div class="alert alert-success alert-container" role="alert">
            <i class="fas fa-university"></i>
            <label>
                Data PMS Validasi Pesanan Mutasi
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" action="<?php echo base_url('admin/DataPMS_ValidasiPesananMutasi/index_DataPMS_ValidasiPesananMutasi') ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">PMS </label>
                            </div>
                            <div class="col-md-2">
                                <select class="js-example-responsive form-control WILAYAH text_input" name="WILAYAH" id="WILAYAH" style="width: 100%;">
                                    <?php
                                    if (isset($_POST["tampilkan"]) &&  $_POST["WILAYAH"] == $WILAYAH) {
                                        echo '<option value="' . $WILAYAH . '" selected >' . $WILAYAH . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">No SP </label>
                            </div>
                            <div class="col-md-2">
                                <select class="js-example-responsive form-control NO_BUKTI_1 text_input" name="NO_BUKTI_1" id="NO_BUKTI_1" style="width: 100%;">
                                    <?php
                                    if (isset($_POST["tampilkan"]) &&  $_POST["NO_BUKTI_1"] == $NO_BUKTI_1) {
                                        echo '<option value="' . $NO_BUKTI_1 . '" selected >' . $NO_BUKTI_1 . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="label">S/D </label>
                            </div>
                            <div class="col-md-2">
                                <select class="js-example-responsive form-control NO_BUKTI_2 text_input" name="NO_BUKTI_2" id="NO_BUKTI_2" style="width: 100%;">
                                    <?php
                                    if (isset($_POST["tampilkan"]) &&  $_POST["NO_BUKTI_2"] == $NO_BUKTI_2) {
                                        echo '<option value="' . $NO_BUKTI_2 . '" selected >' . $NO_BUKTI_2 . '</option>';
                                    } else {
                                        echo '<option value="ZZZ" selected >ZZZ</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-2">
                                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="<?php echo base_url('admin/DataPMS_ValidasiPesananMutasi/update') ?>">
            <table id="batal_pp" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>No Bukti</th>
                        <th>Tanggal</th>
                        <th>No DO</th>
                        <th>Wilayah</th>
                        <th>Article</th>
                        <th>Warna</th>
                        <th>Gol</th>
                        <th>Lusin</th>
                        <th>Pair</th>
                        <th>Customers</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($datapms_validasipesananmutasi as $datapms_validasipesananmutasid) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->PER ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->TGL ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->NO_DO ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->WILAYAH ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->KD_BRG ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->WARNA ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->GOL ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->QTY ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->QTYP ?></td>
                            <td class="text_input"><?php echo $datapms_validasipesananmutasid->CUSTOMERS ?></td>
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
        $(window).keydown(function(event) {
            if ((event.keyCode == 13)) {
                event.preventDefault();
                return false;
            }
        });
        $('#batal_pp').DataTable({
            dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
                "<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + // peletakan entries, search, dan test_btn
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [
                [0, "asc"]
            ],
        });
        $('.buttons-pdf, .buttons-excel, .buttons-print').addClass('btn btn-primary mb-3');
        $("div.test_btn").append(' <input type="submit" class="btn btn-primary mb-3" id="update" name="update" value="Update"> ');
    });
</script>

<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if ((event.keyCode == 13)) {
                event.preventDefault();
                return false;
            }
        });
        $('body').on('keyup', 'input.numinput', function() {
            if (event.which != 190) {
                if (event.which >= 37 && event.which <= 40) return;
            }
            this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            hitung();
        });
        $('#myModalBatalPP').on('show.bs.modal', function(e) {
            targetBatal = $(e.relatedTarget);
        });
        $('body').on('click', '.select_batalpp', function() {
            var val = $(this).parents("tr").find(".NBPVAL").text();
            targetBatal.parents("div").find(".NO_BUKTI").val(val);
            $('#myModalBatalPP').modal('toggle');
        });
    });
    $(".date").datepicker({
        'dateFormat': 'dd-mm-yy',
    });
</script>

<script>
    $(document).ready(function() {
        select_wilayah();
        select_no_bukti_1();
        select_no_bukti_2();
    });

    function select_wilayah() {
        $('#WILAYAH').select2({
            ajax: {
                url: "<?= base_url('admin/DataPMS_ValidasiPesananMutasi/getData_wilayah') ?>",
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

    function select_no_bukti_1() {
        var wilayah = $('#WILAYAH').val();
        $('#NO_BUKTI_1').select2({
            ajax: {
                url: "<?= base_url('admin/DataPMS_ValidasiPesananMutasi/getData_nobukti_1') ?>",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page,
                        wilayah: $('#WILAYAH').val(),
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
            placeholder: 'Masukan No Bukti ...',
            minimumInputLength: 0,
            templateResult: format,
            templateSelection: formatSelection
        });
    }

    function select_no_bukti_2() {
        var wilayah = $('#WILAYAH').val();
        $('#NO_BUKTI_2').select2({
            ajax: {
                url: "<?= base_url('admin/DataPMS_ValidasiPesananMutasi/getData_nobukti_2') ?>",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page,
                        wilayah: $('#WILAYAH').val(),
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
            placeholder: 'Masukan No Bukti ...',
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
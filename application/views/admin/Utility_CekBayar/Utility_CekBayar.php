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
        font-weight: bold;
    }

    .detail-text {
        color: black;
        font-weight: bold;
    }

    .detail-text-total {
        color: green;
        font-weight: bold;
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
                Utility Cek Bayar
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" action="<?php echo base_url('admin/Utility_CekBayar/index_Utility_CekBayar') ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">No SJ </label>
                            </div>
                            <div class="col-md-3">
                                <select class="js-example-responsive form-control NO_SURAT_1" name="NO_SURAT_1" id="NO_SURAT_1" style="width: 100%;"> 
                                <?php
                                if (isset($_POST["NO_SURAT_1"]) &&  $_POST["NO_SURAT_1"] == $NO_SURAT_1) {
                                    echo '<option value="' . $NO_SURAT_1 . '" selected >' . $NO_SURAT_1 . '</option>';
                                } ?>
                                </select>
                                <!-- <input class="form-control text_input NO_SURAT_1" id="NO_SURAT_1" name="NO_SURAT_1" type="text" value=''> -->
                            </div>
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-2">
                                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="<?php echo base_url('admin/Utility_CekBayar/update') ?>">
            <table id="example" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>No Bukti</th>
                        <th>Tanggal</th>
                        <th>No SJ</th>
                        <th>Kodecus</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($utility_cekbayar as $utility_cekbayard) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $utility_cekbayard->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $utility_cekbayard->TGL ?></td>
                            <td class="text_input"><?php echo $utility_cekbayard->NO_SURAT ?></td>
                            <td class="text_input"><?php echo $utility_cekbayard->KODEC ?></td>
                            <td style="color: red; text-align: right; font-weight: bold;"><?php echo number_format($utility_cekbayard->SISA, 2, '.', ','); ?></td>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });

        function numberWithCommas(x) {
            // const fixedNumber = Number.parseFloat(x).toFixed(2);
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'excel'
            ],
            order: [
                [0, "asc"]
            ],
            paging: true,
        });
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy',
        })
        $('.buttons-excel').addClass('btn btn-primary mb-3');
        $('#example').show();
    });

    $('.NO_SURAT_1').select2({
        ajax: {
            url: "<?= base_url('admin/Utility_CekBayar/getjual') ?>",
            dataType: "json",
            type: "post",
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
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
        placeholder: 'No. SJ',
        minimumInputLength: 0,
        templateResult: formatSelect2,
        templateSelection: isiHeader
    });

    function formatSelect2(repo) {
        //HEADER tampilan dropdown items select2
        if (repo.loading) {
            return repo.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo.tampilan);
        return $container;
    }
    function isiHeader(repo) {
        //HEADER set value ke input text yang ingin diisi otomatis saat selesai pilih select2
        $('#NO_SURAT_1').val(repo.text);
        return repo.text;
    }
</script>
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
                Utility No Inv
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" action="<?php echo base_url('admin/Utility_NoInv/index_Utility_NoInv') ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">Periode </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="date form-control text_input TGL_1" id="TGL_1" name="TGL_1" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["TGL_1"])) {
                                                                                                                                                                echo $_POST["TGL_1"];
                                                                                                                                                            } else echo date('d-m-Y'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">Perke </label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control text_input PERKE_1" name="PERKE_1" id="PERKE_1">
                                    <?php if (isset($_POST["submit"]) && $_POST["PERKE_1"] == 'A') {
                                        echo "<option value='A' selected>A</option>";
                                        echo "<option value='B'>B</option>";
                                    } else {
                                        echo "<option value='A'>A</option>";
                                        echo "<option value='B' selected>B</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-7">
                            </div>
                            <div class="col-md-2">
                                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="<?php echo base_url('admin/Utility_NoInv/update') ?>">
            <table id="example" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Fase</th>
                        <th>Wilayah</th>
                        <th>No Bukti</th>
                        <th>Tgl Faktur</th>
                        <th>Invoice</th>
                        <th>Nett</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($utility_noinv as $utility_noinvd) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $utility_noinvd->PER ?></td>
                            <td class="text_input"><?php echo $utility_noinvd->PERKE ?></td>
                            <td class="text_input"><?php echo $utility_noinvd->WILAYAH ?></td>
                            <td class="text_input"><?php echo $utility_noinvd->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $utility_noinvd->TGL_FKTR ?></td>
                            <td class="text_input"><?php echo $utility_noinvd->INVOICE ?></td>
                            <td style="color: blue; text-align: right; font-weight: bold;"><?php echo number_format($utility_noinvd->TOTAL, 2, '.', ','); ?></td>
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
</script>
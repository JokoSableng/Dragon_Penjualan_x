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
                Transakasi Excel Giro Cair
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" action="<?php echo base_url('admin/Transaksi_ExcelGiroCair/index_Transaksi_ExcelGiroCair') ?>">
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
        <form method="post" action="<?php echo base_url('admin/Transaksi_ExcelGiroCair/update') ?>">
            <table id="example" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Wilayah</th>
                        <th>Kodec</th>
                        <th>Nama</th>
                        <th>Kota</th>
                        <th>No Bukti</th>
                        <th>Tgl Jtempo</th>
                        <th>Tgl Cair</th>
                        <th>Giro</th>
                        <th>Nominal Giro</th>
                        <th>Bank</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($excelgirocair as $excelgirocaird) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $excelgirocaird->PER ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->WILAYAH ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->KODEC ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->NAMAC ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->KOTA ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->JTEMPO ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->TGL_CAIR ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->NO_CHBG ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->GIRO ?></td>
                            <td class="text_input"><?php echo $excelgirocaird->BANK ?></td>
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
            columnDefs: 
            [ 
                {
                        className: "text-right", 
                        targets: [9],
                        render: $.fn.dataTable.render.number( ',', '.', 0, '' ),
                } 
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
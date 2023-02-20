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
                Fitur Excel 2
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" id="entri" action="<?php echo base_url('admin/Fitur_Excel_Excel2/index_Fitur_Excel_Excel2') ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">Tanggal </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="date form-control text_input TGL_1" id="TGL_1" name="TGL_1" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["TGL_1"])) {
                                                                                                                                                                echo $_POST["TGL_1"];
                                                                                                                                                            } else echo date('d-m-Y'); ?>">
                            </div>
                            <label class="label">s.d </label>
                            <div class="col-md-2">
                                <input type="text" class="date form-control text_input TGL_2" id="TGL_2" name="TGL_2" data-date-format="dd-mm-yyyy" onchange="cari()" value="<?php if (isset($_POST["TGL_2"])) {
                                                                                                                                                                echo $_POST["TGL_2"];
                                                                                                                                                            } else echo date('d-m-Y'); ?>">
                            </div>
                            <!-- <div class="col-md-7">
                            </div>
                            <div class="col-md-2">
                                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Search">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="<?php echo base_url('admin/Fitur_Excel_Excel2/index_Fitur_Excel_Excel2') ?>">
            <table id="example" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>nosj</th>
                        <th>nodo</th>
                        <th>invoice</th>
                        <th>kodefak</th>
                        <th>nofaktr</th>
                        <th>tglci</th>
                        <th>kodecus</th>
                        <th>nama</th>
                        <th>npwp</th>
                        <th>alamat</th>
                        <th>kota</th>
                        <th>total</th>
                        <th>tax</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($fitur_excel2 as $fitur_excel2d) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $fitur_excel2d->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->NO_DO ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->INVOICE ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->KD_FKTR ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->NO_FKTR ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->TGL_FKTR ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->KODEC ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->NAMAC ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->NPWP ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->ALAMAT ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->KOTA ?></td>
                            <td style="color: blue; text-align: right; font-weight: bold;"><?php echo $fitur_excel2d->TOTAL ?></td>
                            <td class="text_input"><?php echo $fitur_excel2d->TAX ?></td>
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

    function cari()
    {
        // if(e.keyCode == 13){
			document.getElementById("entri").submit();
        // }
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    extend: 'excel',
                    filename: 'fitur_excel2', 
                    title: '',
                },
            ],
            columnDefs: 
            [ 
                // {
                //         targets: [11],
                //         render: $.fn.dataTable.render.number( ',', '.', 0, '' ),
                // } 
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
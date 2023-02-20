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
                Fitur Excel 6
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" id="entri" action="<?php echo base_url('admin/Fitur_Excel_Excel6/index_Fitur_Excel_Excel6') ?>">
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
                            <div class="col-md-2">
                                <input class="btn btn-primary btn-block" type="button" id="btnAll" onclick="klik()" value="Export All">
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
        <form method="post" action="<?php echo base_url('admin/Fitur_Excel_Excel6/update') ?>">

            <legend>REK_ARTICLE_QTY_RP</legend>
            <table id="example_rekarticle" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>article</th>
                        <th>lusin</th>
                        <th>pair</th>
                        <th>total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($fitur_excel6_rekarticle as $fitur_excel6d) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $fitur_excel6d->KD_BRG ?></td>
                            <td class="text_input"><?php echo $fitur_excel6d->LUSIN ?></td>
                            <td class="text_input"><?php echo $fitur_excel6d->PAIR ?></td>
                            <td class="text_input"><?php echo $fitur_excel6d->TOTAL ?></td>
                        </tr>
                    <?php
                        $no++;
                    endforeach;
                    ?>
                </tbody>
            </table>

            <br>
            
            <legend>JL_ARTICLE_QTY_RP</legend>
            <table id="example_jlarticle" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>nosj</th>
                        <th>article</th>
                        <th>lusin</th>
                        <th>pair</th>
                        <th>total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($fitur_excel6_jlarticle as $fitur_excel6_jl) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $fitur_excel6_jl->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_jl->KD_BRG ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_jl->LUSIN ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_jl->PAIR ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_jl->TOTAL ?></td>
                        </tr>
                    <?php
                        $no++;
                    endforeach;
                    ?>
                </tbody>
            </table>

            <br>
            
            <legend>WILJL_ARTICLE_QTY_RP</legend>
            <table id="example_wiljlarticle" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>article</th>
                        <th>pms91</th>
                        <th>pms92</th>
                        <th>pms93</th>
                        <th>pms94</th>
                        <th>pms95</th>
                        <th>pms96</th>
                        <th>pms97</th>
                        <th>pms98</th>
                        <th>nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($fitur_excel6_wiljlarticle as $fitur_excel6_wil) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $fitur_excel6_wil->KD_BRG ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->PMS91 ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->PMS92 ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->PMS93 ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->PMS94 ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->PMS95 ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->PMS96 ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->PMS97 ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->PMS98 ?></td>
                            <td class="text_input"><?php echo $fitur_excel6_wil->TOTAL ?></td>
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

    function klik()
    {
        $('#btn_rekarticle').click();
        $('#btn_jlarticle').click();
        $('#btn_wiljlarticle').click();
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy',
        })

        $('#example_rekarticle').DataTable({
            dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    extend: 'excel',
                    filename: 'REK_ARTICLE_QTY_RP', 
                    title: '',
                    attr:  {
                        title: 'Excel',
                        id: 'btn_rekarticle',
                        class: 'btn btn-primary mb-3',
                    },
                },
            ],
            columnDefs: 
            [ 
                // {
                //         targets: [2,3],
                //         render: $.fn.dataTable.render.number( ',', '.', 0, '' ),
                // } 
            ],
            order: [
                [0, "asc"]
            ],
            paging: true,
        });
        $('#example_rekarticle').show();

        $('#example_jlarticle').DataTable({
            dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    extend: 'excel',
                    filename: 'JL_ARTICLE_QTY_RP', 
                    title: '',
                    attr:  {
                        title: 'Excel',
                        id: 'btn_jlarticle',
                        class: 'btn btn-primary mb-3',
                    },
                },
            ],
            columnDefs: 
            [ 
                // {
                //         targets: [2,3],
                //         render: $.fn.dataTable.render.number( ',', '.', 0, '' ),
                // } 
            ],
            order: [
                [0, "asc"]
            ],
            paging: true,
        });
        $('#example_jlarticle').show();
        
        $('#example_wiljlarticle').DataTable({
            dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    extend: 'excel',
                    filename: 'WILJL_ARTICLE_QTY_RP', 
                    title: '',
                    attr:  {
                        title: 'Excel',
                        id: 'btn_wiljlarticle',
                        class: 'btn btn-primary mb-3',
                    },
                },
            ],
            columnDefs: 
            [ 
                // {
                //         targets: [2,3],
                //         render: $.fn.dataTable.render.number( ',', '.', 0, '' ),
                // } 
            ],
            order: [
                [0, "asc"]
            ],
            paging: true,
        });
        $('#example_wiljlarticle').show();
    });
</script>
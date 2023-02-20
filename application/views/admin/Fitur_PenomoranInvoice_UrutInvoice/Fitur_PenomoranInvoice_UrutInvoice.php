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
                Fitur Penomoran Invoice Urut Invoice
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" id="entri" action="<?php echo base_url('admin/Fitur_Penomoraninvoice_UrutInvoice/index_Fitur_Penomoraninvoice_UrutInvoice') ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">Periode </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" value="<?php if (isset($_POST["PER"])) { echo $_POST["PER"]; } else echo $this->session->userdata['periode']; ?>" class="form-control form-control PER text_input" id="PER" name="PER" placeholder="mm/yyyy" onchange="cari()" onblur="cari()">
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2" align="right">
                                <label>Invoice terakhir : <?php if (isset($_POST["PER"])) { echo $noinv; } else echo '-'; ?></label>
                            </div>
                            <div class="col-md-2">
                                <input class="btn btn-primary btn-block" type="submit" name="proses" value="Invoice">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="<?php echo base_url('admin/Fitur_Penomoraninvoice_UrutInvoice/update') ?>">
            <table id="example" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>No SJ</th>
                        <th>Tgl SJ</th>
                        <th>Invoice</th>
                        <th>Tgl Fak</th>
                        <th>J Tempo</th>
                        <th>No Faktur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($fitur_penomoraninvoice_urutinvoice as $fitur_penomoraninvoice_urutinvoiced) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_urutinvoiced->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_urutinvoiced->TGL ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_urutinvoiced->INVOICE ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_urutinvoiced->TGL_FKTR ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_urutinvoiced->JTEMPO ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_urutinvoiced->NO_FKTR ?></td>
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
        $('#example').DataTable({
            dom: "<'row'<'col-md-6'><'col-md-6'>>" + 
                "<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + 
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", 
            buttons: [
                // {
                //     extend: 'excel',
                //     filename: 'fitur_excel7', 
                //     title: '',
                //     text: 'COPY',
                // },
            ],
            columnDefs: 
            [ 
                // {
                //         targets: [9],
                //         render: $.fn.dataTable.render.number( ',', '.', 0, '' ),
                // } 
            ],
            order: [
                [0, "asc"]
            ],
            paging: true,
        });
        $('.buttons-pdf, .buttons-excel, .buttons-print').addClass('btn btn-primary mb-3');
        // $("div.test_btn").append(' <input type="submit" class="btn btn-primary mb-3" id="update" name="update" value="Update"> ');
    });
    function cari()
    {
        // if(e.keyCode == 13){
			document.getElementById("entri").submit();
        // }
    };
</script>

<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if ((event.keyCode == 13)) {
                event.preventDefault();
                return false;
            }
        });
    });
    $(".date").datepicker({
        'dateFormat': 'dd-mm-yy',
    });
</script>
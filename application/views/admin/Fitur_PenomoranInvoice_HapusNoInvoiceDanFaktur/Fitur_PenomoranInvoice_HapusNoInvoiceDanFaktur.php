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
                Fitur Penomoran Invoice Edit/Hapus No Invoice Dan Faktur
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" id="entri" action="<?php echo base_url('admin/Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur/index_Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur') ?>" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">Tanggal </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" onchange="cari()" value="<?php if (isset($_POST["TGL"])) {
                                                                                                                                                        echo $_POST["TGL"];
                                                                                                                                                    } else echo date('d-m-Y'); ?>">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">Import Excel Edit</label>
                            </div>
                            <div class="col-md-3">
                                <input type="file" name="fileimporedit" class="form-control" id="fileedit">
                            </div>
                            <div class="col-md-1">
                                <input class="btn btn-primary btn-block" type="submit" name="ambiledit" value="Import" onclick="importExcelEdit()">
                            </div>

                            <hr width="1" size="500" style="0 auto" />

                            <div class="col-md-1">
                                <label class="label">Import Excel Hapus</label>
                            </div>
                            <div class="col-md-3">
                                <input type="file" name="fileimporhapus" class="form-control" id="filehapus">
                            </div>
                            <div class="col-md-1">
                                <input class="btn btn-primary btn-block" type="submit" name="ambilhapus" value="Import" onclick="importExcelHapus()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="<?php echo base_url('admin/Fitur_PenomoranInvoice_HapusNoInvoiceDanFaktur/update') ?>">
            <table id="batal_pp" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>nosj</th>
                        <th>tglci</th>
                        <th>tgfak</th>
                        <th>jtempo</th>
                        <th>invoice</th>
                        <th>kodefak</th>
                        <th>nofaktr</th>
                        <th>nocet</th>
                        <th>kdmts</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($fitur_penomoraninvoice_hapusnoinvoicedanfaktur as $fitur_penomoraninvoice_hapusnoinvoicedanfakturd) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->TGL ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->TGL_FKTR ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->JTEMPO ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->INVOICE ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->KD_FKTR ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->NO_FKTR ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->NO_CET ?></td>
                            <td class="text_input"><?php echo $fitur_penomoraninvoice_hapusnoinvoicedanfakturd->WILAYAH ?></td>
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
            dom: "<'row'<'col-md-6'B><'col-md-6'>>" +
                "<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + 
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", 
            buttons: [
                {
                    extend: 'excel',
                    filename: 'fitur_hapusInvoice', 
                    title: '',
                    text: 'Export Excel',
                },
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
        // $("div.test_btn").append(' <input type="submit" class="btn btn-primary mb-3" id="update" name="update" value="Update"> ');
        $('.buttons-pdf, .buttons-excel, .buttons-print').addClass('btn btn-primary mb-3');
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy',
        })
    });
    
    function cari()
    {
        // if(e.keyCode == 13){
			document.getElementById("entri").submit();
        // }
    }
    function importExcelEdit()
    {
        if ($('#fileedit').val()) {
			document.getElementById("entri").submit();
        }
        else {
			event.preventDefault();
            alert("File excel edit belum dipilih..");
        }
    }
    function importExcelHapus()
    {
        if ($('#filehapus').val()) {
			document.getElementById("entri").submit();
        }
        else {
			event.preventDefault();
            alert("File excel hapus belum dipilih..");
        }
    }
</script>
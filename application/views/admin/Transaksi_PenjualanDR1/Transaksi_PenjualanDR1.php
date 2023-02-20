<?php $kode_menu = $this->session->userdata['kode_menu']; ?>
<?php $level = $this->session->userdata['level']; ?>
<?php $super_admin = $this->session->userdata['super_admin']; ?>

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
        background-color: #7de89a;
    }

    .table-striped>tbody>tr:nth-child(even)>td,
    .table-striped>tbody>tr:nth-child(even)>th {
        background-color: #9ae6ae;
    }

    .table>tbody>tr>td>div {
        text-align: center;
    }

    .table>tbody>tr>td>div>a {
        font-size: 13px;
        color: black;
        background-color: #1cc88a;
    }

    .table>tbody>tr>td>div>a:hover {
        transition: 0.4s;
        color: #b3b3b3;
        background-color: #1cc88a;
    }

    .table>tbody>tr>td>div>a::selection {
        color: white;
    }

    .table>tbody>tr>td>div>div>a:hover {
        background-color: #71ad81;
    }

    .table>tbody>tr>td>div>div>a>i {
        color: black;
        background-color: transparent;
    }
</style>

<section>
    <br>
    <div class="container-fliud mx-4">
        <div class="alert alert-success alert-container" role="alert">
            <i class="fas fa-university"></i>
            <label>
                Transaksi Penjualan Lokal
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form method="post" action="<?php echo base_url('admin/Transaksi_PenjualanDR1/delete_multiple') ?>">
            <div class="btn-group" role="group" aria-label="Basic example">
            </div>
            <table id="example" class="table table-bordered table-striped table-hover table-responsive bodycontainer scrollable" style="width:100%;">
                <thead>
                    <tr>
                        <!-- <th width="75px"><input type="checkbox" id="selectall" /></th> -->
                        <th width="75px">Menu</th>
                        <th width="75px">No</th>
                        <th width="250px">No. SJ</th>
                        <th width="170px">Tgl</th>
                        <th width="275px">No Do</th>
                        <th width="350px">Kodec</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
    <br>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
                "<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + // peletakan entries, search, dan test_btn
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
            "order": [
                [3, 'asc']
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('admin/Transaksi_PenjualanDR1/get_ajax_jual') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0, 1, 2],
                "orderable": false
            }]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mb-3');
        $('#example').show();

    });
</script>
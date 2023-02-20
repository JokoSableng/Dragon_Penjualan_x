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
                Transaksi Cek BKM PMS A
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form method="post" action="<?php echo base_url('admin/Transaksi_CekBKM_PMSA/delete_multiple') ?>">
            <table id="example" class="table table-bordered table-striped table-hover table-responsive bodycontainer scrollable" style="width:100%;">
                <thead>
                    <tr>
                        <!-- <th width="75px"><input type="checkbox" id="selectall" /></th> -->
                        <th width="75px">Menu</th>
                        <th width="300px">No. Bukti</th>
                        <th width="145px">Tgl</th>
                        <th width="300px">No. DO</th>
                        <th width="300px">Tgl Faktur</th>
                        <th width="100px">Wilayah</th>
                        <th width="100px">Posted</th>
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
        var wilayah = $('#example').DataTable({
            dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
                "<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + // peletakan entries, search, dan test_btn
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
            "ajax": {
                "url": "<?php echo site_url('admin/Transaksi_CekBKM_PMSA/get_ajax_jl_piu') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }]
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var filter_wilayah = $('#WILAYAH').val();
                var data_wilayah = data[5];
                if (data_wilayah == filter_wilayah) {
                    return true;
                }
                return false;
            }
        );
        wilayah.draw();


        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mb-3');
        // menambahkan button  di test_btn
        $("div.test_btn").html(
        `
            <div class="form-group row">
                <div class="col-md-1">
                    <a class="btn  btn-md btn-success" href="input"> <i class="fas fa-plus fa-sm md-3"></i></a>
                </div>
                <div class="col-md-3">
                    <select class="form-control text_input WILAYAH" name="WILAYAH" id="WILAYAH">
                    <?php foreach ($wilayah as $value) : ?> 
                            <option value = '<?= $value->WILAYAH ?>'> <?= $value->WILAYAH . ' - ' . $value->WILAYAH1 ?> </option>
                    <?php endforeach; ?> 
                    </select>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <a class="btn btn-warning form-control" href="gantiBkm/?TIPE=1"> Pindah ke BKM</a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn-warning form-control" href="gantiBkm/?TIPE=2"> Pindah ke BBM</a>
                </div>
            </div>
        `);
        $('#example').show();

        $('#WILAYAH').change(function() {
            wilayah.draw();
        });
        
        $('body').on('change', '.POSTED', function() {
            let vv = $(this).closest('tr');
            let dipilih = 0;
            if (vv.find(".POSTED").is(":checked")==true) dipilih=2;
            if (vv.find(".POSTED").is(":checked")==false) dipilih=0;
            $.ajax({
                type: 'post',
                url: '<?= base_url('admin/Transaksi_CekBKM_PMSA/editPostedBkm'); ?>',
                data: {
                    NO_ID: vv.find(".NOID").val(),
                    POSTED: dipilih,
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                }
            });
        });
    });
</script>
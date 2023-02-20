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
        <form method="post" id="entri" action="<?php echo base_url('admin/DataPMS_ValidasiPesananMutasi/index_DataPMS_ValidasiPesananMutasi') ?>">
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
                            <div class="col-md-2">
                                <input class="btn btn-primary btn-block" type="submit" name="simpan" value="Simpan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="<?php echo base_url('admin/DataPMS_ValidasiPesananMutasi/update') ?>">
            <table id="example" class="table table-bordered table-bordered table-striped table-hover " style="width:100%; font-size: 12px;">
                <thead>
                    <tr>
					    <th>No</th>
                        <th>No SP</th>
                        <th>No DO</th>
                        <th>Wilayah</th>
                        <th>Tgl DO</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
            "paging": true,
			"search": {
				"search": "<?= $this->session->userdata['cari'] ?>"
			},
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + 
				"<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + 
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", 
			"order": [],
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo site_url('admin/DataPMS_ValidasiPesananMutasi/get_ajaxBkt') ?>",
				"type": "POST"
			},
			"columnDefs": [{
					"targets": [0, 1],
					"orderable": false
				},
            // {
            // 	className: "text-right",
            // 	"targets": [8, 9, 10, 11]
            // }
			],
		});
		$('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mb-3');

		$('#example').show();

        $('body').on('focusout keyup', 'input[type=search]', function() {
            $.ajax({
                type: 'post',
                url: '<?php echo base_url('admin/DataPMS_ValidasiPesananMutasi/carix'); ?>',
                data: {
                    cari: $(this).val()
                },
                dataType: 'json',
                success: function(response) {}
            });
        });

        $('body').on('change', '.NO_DO', function() {
            let vv = $(this).closest('tr');
            $.ajax({
                type: 'post',
                url: '<?= base_url('admin/DataPMS_ValidasiPesananMutasi/edit'); ?>',
                data: {
                    NO_BUKTI: vv.find("td:eq(1)").text(),
                    NO_DO: vv.find(".NO_DO").val(),
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                }
            });
        });
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
</script>
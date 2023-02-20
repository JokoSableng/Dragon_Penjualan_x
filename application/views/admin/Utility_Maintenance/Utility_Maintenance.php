<style>
    .alert-container {
        background-color: #aab5aa;
        color: black;
        font-weight: bolder;
    }

    .label-title {
        color: black;
        font-weight: bold;
    }

    .label {
        color: black;
        font-weight: bold;
    }

    .detail {
        color: black;
        text-align: center;
    }

    .footerCss {
        color: black;
        font-weight: bold;
    }

    .text_input {
        font-size: small;
        color: black;
    }
</style>

<section>
    <div class="container-fluid">
        <br>
        <div class="alert alert-container" role="alert">
            <i class="fas fa-university"></i> Maintenance
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="cekdata" method="post" action="<?php echo base_url('admin/Utility_TS/index_Utility_TS') ?>">
            <br><br><br><br><br>
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-2">
                        <input class="btn btn-primary btn-block" type="button" onclick="bt_ambilaccount()" name="" value="OK">
                    </div>
                    <!-- <div class="col-md-2">
                        <input class="btn btn-primary btn-block" type="button" onclick="bt_ambilkas()" name="" value="COBA2">
                    </div>
                    <div class="col-md-2">
                        <input class="btn btn-primary btn-block" type="button" onclick="bt_ambilbank()" name="" value="BANK">
                    </div>
                    <div class="col-md-2">
                        <input class="btn btn-primary btn-block" type="button" onclick="bt_ambilmemo()" name="" value="MEMO">
                    </div>
                    <div class="col-md-2">
                        <input class="btn btn-primary btn-block" type="button" onclick="bt_ambilhut()" name="" value="HUT">
                    </div>
                    <div class="col-md-2">
                        <input class="btn btn-primary btn-block" type="button" onclick="bt_ambilpiu()" name="" value="PIU">
                    </div> -->
                </div>
            </div>
            <hr class="m-t-10">
            <!-- PASTE DIBAWAH INI -->
            <!-- DISINI BATAS AWAL KOOLREPORT-->
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
        $("#btnExportCopy").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-copy').trigger();
        });
        $("#btnExportExcel").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-excel').trigger();
        });
        $("#btnExportPdf").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-pdf').trigger();
        });
        $("#btnExportCsv").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-csv').trigger();
        });
        // $("#btnExportPrint").on("click", function() {
        // 	var table = $('#example').DataTable();
        // 	table.button('.buttons-print').trigger();
        // });
        $('.date').mask('00-00-0000');
    });

    // function bt_ambilaccount() {
    //     if (confirm("Yakin Ambil Data?")) {
    //         // document.getElementById("transaksipemesanan").submit();
    //         window.location.replace("<?php echo base_url('admin/Coba/coba1') ?>");
    //     } else {
    //         alert("Batal Ambil Data Account!");
    //     }
    // }

    function bt_ambilkas() {
        if (confirm("Yakin Ambil Data?")) {
            // document.getElementById("transaksipemesanan").submit();
            window.location.replace("<?php echo base_url('admin/Coba/coba2') ?>");
        } else {
            alert("Batal Ambil Data Kas!");
        }
    }

    function bt_ambilbank() {
        if (confirm("Yakin Ambil Data Bank?")) {
            // document.getElementById("transaksipemesanan").submit();
            window.location.replace("<?php echo base_url('admin/Utility_TS/ambildatabank') ?>");
        } else {
            alert("Batal Ambil Data Bank!");
        }
    }

    function bt_ambilmemo() {
        if (confirm("Yakin Ambil Data Memo?")) {
            // document.getElementById("transaksipemesanan").submit();
            window.location.replace("<?php echo base_url('admin/Utility_TS/ambildatamemo') ?>");
        } else {
            alert("Batal Ambil Data Memo!");
        }
    }

    function bt_ambilpiu() {
        if (confirm("Yakin Ambil Data Piutang?")) {
            // document.getElementById("transaksipemesanan").submit();
            window.location.replace("<?php echo base_url('admin/Utility_TS/ambildatapiu') ?>");
        } else {
            alert("Batal Ambil Data Piutang!");
        }
    }

    function bt_ambilhut() {
        if (confirm("Yakin Ambil Data Hutang?")) {
            // document.getElementById("transaksipemesanan").submit();
            window.location.replace("<?php echo base_url('admin/Utility_TS/ambildatahut') ?>");
        } else {
            alert("Batal Ambil Data Hutang!");
        }
    }
</script>
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
            <i class="fas fa-university"></i> Cek No SJJLPMS
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="entri" method="post" action="<?php echo base_url('admin/Utility_CekNoSJJLPMS/index_Utility_CekNoSJJLPMS') ?>">
            <br>
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-0 nopadding">
                        <label class="label-title">Tanggal </label>
                    </div>
                    <div class="col-md-2 nopadding">
                        <input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" onchange="cari()" value="<?php if (isset($_POST["TGL"])) {
                                                                                                                                                echo $_POST["TGL"];
                                                                                                                                            } else echo date('d-m-Y'); ?>">
                    </div>
                </div>
            </div>
        </form>

        <hr class="m-t-10">

        <table id="utility_copy" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
            <thead>
                <tr>
                    <th>NOSJ</th>
                    <th>SELISIH</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                foreach ($utility_CekNoSJJLPMS as $detail) :
                ?>
                    <tr>
                        <td class="text_input"><?php echo $detail->NOSJ ?></td>
                        <td class="text_input"><?php echo $detail->TOTAL ?></td>
                    </tr>
                <?php
                    $no++;
                endforeach;
                ?>
            </tbody>
        </table>
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
        $('#utility_copy').DataTable({
            dom: "<'row'<'col-md-6'B><'col-md-6'>>" +
                "<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + 
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", 
            buttons: [
                {
                    extend: 'excel',
                    filename: 'utility_CekNoSJJLPMS', 
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
        });
    });
    function cari()
    {
        // if(e.keyCode == 13){
			document.getElementById("entri").submit();
        // }
    }
</script>
<?php
foreach ($bank_masuk as $rowh) {
    $session_prog = $_SESSION['prog'];
    $session_username = $_SESSION['username'];
    $session_grup = $_SESSION['grup'];
};
?>

<style>
    #myInput {
        background-image: url('<?php echo base_url() ?>assets/img/search-icon-blue.png');
        background-position: 10px 12px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 14px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }

    #myTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    #myTable th,
    #myTable td {
        text-align: left;
        padding: 5px;
    }

    #myTable tr {
        border-bottom: 1px solid #ddd;
    }

    #myTable tr.header,
    #myTable tr:hover {
        background-color: #f1f1f1;
    }

    input[type=text]:focus {
        width: 100%;
    }

    table {
        table-layout: fixed;
    }

    table th {
        color: black;
        text-align: center;
    }

    table td {
        overflow: hidden;
    }

    .label {
        color: black;
        font-weight: bold;
    }

    .rightJustified {
        text-align: right;
    }

    /* .total { font-size: 14px; font-weight: bold; color: blue; } */
    .bodycontainer {
        /* width: 1000px; */
        max-height: 500px;
        margin: 0;
        overflow-y: auto;
    }

    #datatable td {
        padding: 2px !important;
        vertical-align: middle;
    }

    .table-scrollable {
        margin: 0;
        padding: 0;
    }

    .modal-bodys {
        max-height: 250px;
        overflow-y: auto;
    }

    .select2-dropdown {
        width: 500px !important;
    }

    /* .container { text-align: center; vertical-align: middle;} */
    .checkbox_container {
        width: 25px;
        height: 25px;
    }

    td input[type="checkbox"] {
        float: left;
        margin: 0 auto;
        width: 100%;
    }

    .text_input {
        font-size: small;
        color: black;
    }

    .tab {
        text-align: left;
        overflow: hidden;
    }

    .tab button {
        background-color: #01BAEF;
        border-radius: 0.35rem;
        border-color: white;
        outline: none;
        cursor: pointer;
        padding: 10px 10px;
        transition: 0.4s;
    }

    .tab button:hover {
        background-color: #347AC9;
        transition: 0.4s;
    }

    .tab button.active {
        background-color: #347AC9;
        color: white;
    }

    .tab {
        font-weight: bold;
        color: black;
    }
</style>

<div class="container-fluid">
    <br>
    <div class="alert alert-success alert-container" role="alert">
        <i class="fas fa-university"></i> Update Transaksi Rencana Bank Masuk
    </div>
    <?= $this->session->flashdata('pesannobuktidobel') ?>
    <form id="bankmasuk" name="bankmasuk" action="<?php echo base_url('admin/Transaksi_PembayaranBBM/updateRbank_aksi'); ?>" class="form-horizontal" method="post">
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-1">
                            <label class="label">No Bukti </label>
                        </div>
                        <div class="input-group col-md-1">
                            <input type="hidden" name="ID" id="ID" class="form-control" value="<?php echo $rowh->ID ?>">
                            <input class="form-control text_input BUKTI" id="BUKTI" name="BUKTI" type="text" value="<?php echo $rowh->BUKTI ?>" style="font-weight: bolder;" readonly>
                        </div>
                        <div class="input-group col-md-1">
                            <input class="form-control text_input NOMER" id="NOMER" name="NOMER" type="text" value="<?php echo $rowh->NOMER ?>" minlength="4" maxlength="4" style="font-weight: bolder;" required readonly>
                        </div>
                        <div class="col-md-1">
                            <label class="label">Bank Account </label>
                        </div>
                        <div class="col-md-2 input-group">
                            <input value="<?php echo $rowh->BACNO ?>" name="BACNO" id="BACNO" type="text" class="form-control BACNO text_input" onkeypress="return tabE(this,event)" readonly required>
                            <!-- <span class="input-group-btn">
                                <a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_no_acno" data-toggle="modal" href="#lupacount"><i class="fa fa-search"></i></a>
                            </span> -->
                        </div>
                        <div class="input-group col-md-2">
                            <input class="form-control text_input BNAMA" id="BNAMA" name="BNAMA" type="text" value="<?php echo $rowh->BNAMA ?>" readonly>
                            <input class="form-control text_input BNK" id="BNK" name="BNK" type="hidden" value="<?php echo $rowh->BNK ?>" readonly>
                        </div>
                        <div class="input-group col-md-1">
                            <input class="form-control text_input KD" id="KD" name="KD" type="text" value="<?php echo $rowh->KD ?>" readonly>
                        </div>
                        <div class="col-md-1">
                            <label class="label">Tanggal </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rowh->TGL, TRUE)); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-1">
                            <label class="label">Dari / Ke </label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control text_input KET" id="KET" name="KET" type="text" value="<?php echo $rowh->KET ?>" readonly>
                        </div>
                        <div class="col-md-2"><label class="label">* Total Jumlah Harus Sama</label></div>
                        <div class="col-md-3">
                            <!-- GRUP = 2 -->
                            <?php
                            if ($session_prog == 'KASIR' && $rowh->USRNM_KSR == $session_username && $rowh->POSTED_KSR == '0')
                                echo '<label class="label">* User Kasir Memiliki Hak Akses Untuk Edit </label>';
                            elseif ($session_prog == 'ACCOUNTING' && $rowh->POSTED_ACC == '0')
                                echo '<label class="label">* User Accounting Memiliki Hak Akses Untuk Edit </label>';
                            elseif ($session_prog == 'PJL')
                                echo '<label class="label">* User Penjualan Memiliki Hak Akses Untuk Edit </label>';
                            else {
                                echo '<label class="label" style="color: red;">User Tidak Memiliki Hak Akses Edit </label>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive scrollable">
                    <table id="datatable" class="table table-hoverx table-stripedx table-borderedx table-condensed table-scrollable">
                        <thead>
                            <tr>
                                <th width="50px">No</th>
                                <th class="th_acno">Acno</th>
                                <th class="th_uraian">Uraian</th>
                                <th class="th_total">Total</th>
                                <th class="th_tgcair th_kasir">Tg Cair</th>
                                <th class="th_cair th_kasir">Cair</th>
                                <th class="th_bg">BG</th>
                                <th class="th_jtempo">J Tempo</th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($bank_masuk as $row) :
                            ?>
                                <tr>
                                    <td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
                                    <td>
                                        <div class="input-group">
                                            <select class="js-example-responsive-acno form-control ACNO text_input" name="ACNO[]" id="ACNO<?php echo $no; ?>" onchange="acno(this.id)">
                                                <option value="<?php echo $row->ACNO; ?>" selected id="ACNO<?php echo $no; ?>"><?php echo $row->ACNO; ?></option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input name="URAIAN[]" id="URAIAN<?php echo $no; ?>" value="<?= $row->URAIAN ?>" type="text" class="form-control text_input URAIAN">
                                        <input name="NAMA[]" id="NAMA<?php echo $no; ?>" value="<?= $row->NAMA ?>" type="hidden" class="form-control text_input NAMA" readonly>
                                    </td>
                                    <td><input name="JUMLAH[]" onchange="hitung()" id="JUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->JUMLAH, 2, '.', ','); ?>" type="text" class="form-control JUMLAH rightJustified text-primary"></td>
                                    <td class="td_kasir">
                                        <input name="TGL_CAIR[]" id="TGL_CAIR<?php echo $no; ?>" type="text" class="date form-control text_input" data-date-format="dd-mm-yyyy" value="<?php if ($row->TGL_CAIR != "1970-01-01")  echo date('d-m-Y', strtotime($row->TGL_CAIR, TRUE)); ?>" onclick="select()">
                                    </td>
                                    <td class="td_kasir">
                                        <input <?php
                                                if ($row->CAIR != "0") echo 'checked'; ?> name="CAIR[]" id="CAIR<?php echo $no; ?>" type="checkbox" value="<?= $row->CAIR ?>" class="checkbox_container CAIR" disabled>
                                    </td>
                                    <td><input name="BG[]" id="BG<?php echo $no; ?>" value="<?= $row->BG ?>" type="text" class="form-control text_input BG"></td>
                                    <td><input name="JTEMPO[]" id="JTEMPO<?php echo $no; ?>" type="text" class="date form-control text_input" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($row->JTEMPO, TRUE)); ?>" onclick="select()"></td>
                                    <td>
                                        <input name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden">
                                        <?php
                                        if ($session_prog == 'KASIR' && $rowh->USRNM_KSR == $session_username && $rowh->POSTED_KSR == '0')
                                            echo '<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>';
                                        elseif ($session_prog == 'ACCOUNTING' && $rowh->POSTED_ACC == '0')
                                            echo '<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>';
                                        elseif ($session_prog == 'PJL')
                                            echo '<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>';
                                        else {
                                            echo '';
                                        }
                                        ?>
                                        <!-- <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button> -->
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <input class="form-control TJUMLAH rightJustified text-primary font-weight-bold" id="TJUMLAH" name="TJUMLAH" value="<?php echo number_format($rowh->TJUMLAH, 2, '.', ','); ?>" readonly>
                                <input type="hidden" class="form-control TJUMLAH_TAMPUNGAN rightJustified font-weight-bold" id="TJUMLAH_TAMPUNGAN" name="TJUMLAH_TAMPUNGAN" value="<?php echo number_format($rowh->TJUMLAH_TAMPUNGAN, 2, '.', ','); ?>" readonly>
                            </td>
                            <td></td class="td_kasir">
                            <td></td>
                            <td></td class="td_kasir">
                            <td></td>
                            <td></td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!--tab-->
        <?php
        if ($session_prog == 'KASIR' && $rowh->USRNM_KSR == $session_username && $rowh->POSTED_KSR == '0')
            echo '<div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i></button>
                    </div>
                </div>
            </div>';
        elseif ($session_prog == 'ACCOUNTING' && $rowh->POSTED_ACC == '0')
            echo '<div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i></button>
                    </div>
                </div>
            </div>';
        elseif ($session_prog == 'PJL')
            echo '<div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i></button>
                    </div>
                </div>
            </div>';
        else {
            echo '';
        }
        ?>
        <!-- <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-4">
                    <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i></button>
                </div>
            </div>
        </div> -->
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-8"></div>
                <div class="col-md-2">
                    <?php
                    if ($rowh->POSTED_KSR == '0')
                        echo '<button type="button" class="btn btn-sm btn-danger">Kasir Belum Posted</button>';
                    else {
                        echo '<button type="button" class="btn btn-sm btn-primary">Kasir Sudah Posted</button>';
                    }
                    ?>
                </div>
                <div class="col-md-2">
                    <?php
                    if ($rowh->POSTED_ACC == '0')
                        echo '<button type="button" class="btn btn-sm btn-danger">Acc Belum Posted</button>';
                    else {
                        echo '<button type="button" class="btn btn-sm btn-primary">Acc Sudah Posted</button>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        if ($session_prog == 'KASIR' && $rowh->USRNM_KSR == $session_username && $rowh->POSTED_KSR == '0')
            echo '<div class="row">
                <div class="col-xs-9">
                    <div class="wells">
                        <div class="btn-group cxx">
                            <button type="button" onclick="chekbox(), cekjumlah()" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            <a type="button" href="#" onclick="window.close()" class="btn btn-danger">Cancel</a>
                        </div>
                        <h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
                    </div>
                </div>
            </div>';
        elseif ($session_prog == 'ACCOUNTING' && $rowh->POSTED_ACC == '0')
            echo '<div class="row">
                <div class="col-xs-9">
                    <div class="wells">
                        <div class="btn-group cxx">
                            <button type="button" onclick="chekbox(), cekjumlah()" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            <a type="button" href="#" onclick="window.close()" class="btn btn-danger">Cancel</a>
                        </div>
                        <h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
                    </div>
                </div>
            </div>';
        elseif ($session_prog == 'PJL')
            echo '<div class="row">
                <div class="col-xs-9">
                    <div class="wells">
                        <div class="btn-group cxx">
                            <button type="button" onclick="chekbox(), cekjumlah()" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            <a type="button" href="#" onclick="window.close()" class="btn btn-danger">Cancel</a>
                        </div>
                        <h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
                    </div>
                </div>
            </div>';
        else {
            echo '';
        }
        ?>
    </form>
</div>

<!-- myModal No Faktur-->
<div id="mymodal_no_acno" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: bold; color: black;">Data Account</h4>
            </div>
            <div class="modal-body">
                <table class='table table-bordered' id='modal_no_acno'>
                    <thead>
                        <th>N Acno</th>
                        <th>B Acno</th>
                        <th>BNK</th>
                        <th>KD</th>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT ACNO AS BACNO, 
								NAMA AS BNAMA,
								BNK AS BNK,
								KD AS KD
							FROM account
							WHERE KD<>''
							ORDER BY ACNO";
                        $a = $this->db->query($sql)->result();
                        foreach ($a as $b) {
                        ?>
                            <tr>
                                <td class='NAAVAL'><a href="#" class="select_no_acno"><?php echo $b->BACNO; ?></a></td>
                                <td class='BAAVAL text_input'><?php echo $b->BNAMA; ?></td>
                                <td class='BNAVAL text_input'><?php echo $b->BNK; ?></td>
                                <td class='KDAVAL text_input'><?php echo $b->KD; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#modal_no_acno').DataTable({
            dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
                "<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            order: true,
        });
        $('.modal-footer').on('click', '#close', function() {
            $('input[type=search]').val('').keyup(); // this line and next one clear the search dialog
        });
    });
</script>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        if ($('#NOMER').val() == '') {
                            alert("Harap isi nomer 4 digit !!!");
                            $('#NOMER').focus();
                        }
                        if ($('#BACNO').val() == '') {
                            alert("Harap isi No Account !!!");
                            $('#BACNO').focus();
                        }
                    } else {
                        $(this).submit(function() {
                            return false;
                        });
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    var target;
    var idrow = <?php echo $no ?>;

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    jQuery(function($) {
        $('form').bind('submit', function() {
            $(this).find(':input').prop('disabled', false);
        });
    });

    $(document).ready(function() {
        $(".alert-dismissible").hide();
        $(".alert-dismissible").fadeTo(5000, 500).slideUp(500, function() {
            $(".alert-dismissible").slideUp(500);
        });

        $("#TJUMLAH").autoNumeric('init', {
            aSign: '<?php echo ''; ?>',
            vMin: '-999999999.99'
        });
        $("#TJUMLAH_TAMPUNGAN").autoNumeric('init', {
            aSign: '<?php echo ''; ?>',
            vMin: '-999999999.99'
        });
        jumlahdata = 100;
        for (i = 0; i <= jumlahdata; i++) {
            $("#JUMLAH" + i.toString()).autoNumeric('init', {
                aSign: '<?php echo ''; ?>',
                vMin: '-999999999.99'
            });
        }
        //MyModal No Account
        $('#mymodal_no_acno').on('show.bs.modal', function(e) {
            target = $(e.relatedTarget);
        });
        $('body').on('click', '.select_no_acno', function() {
            var val = $(this).parents("tr").find(".NAAVAL").text();
            target.parents("div").find(".BACNO").val(val);
            var val = $(this).parents("tr").find(".BAAVAL").text();
            target.parents("div").find(".BNAMA").val(val);
            var val = $(this).parents("tr").find(".BNAVAL").text();
            target.parents("div").find(".BNK").val(val);
            var val = $(this).parents("tr").find(".KDAVAL").text();
            target.parents("div").find(".KD").val(val);
            $('#mymodal_no_acno').modal('toggle');
        });
        $('body').on('click', '.btn-delete', function() {
            var val = $(this).parents("tr").remove();
            idrow--;
            nomor();
        });
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy',
        });
        ///	ALERT SESSION
        var session_progam = "<?php echo $session_prog; ?>";
        // alert("Session Program = " + session_progam);
        ///	BATAS ALERT SESSION

        if (session_progam == "KASIR") {
            $(".label_accounting").prop("hidden", true);

            $(".th_acno").width(100);
            $(".th_uraian").width(325);
            $(".th_total").width(150);
            $(".th_tgcair").width(100);
            $(".th_bg").width(200);
            $(".th_cair").width(75);
            $(".th_jtempo").width(100);
        } else if (session_progam == "ACCOUNTING" || session_progam == "PJL") {
            $(".label_kasir").prop("hidden", true);
            $(".td_kasir").prop("hidden", true);
            $(".th_kasir").prop("hidden", true);
            $(".td_kasir").prop("hidden", true);

            $(".th_acno").width(100);
            $(".th_uraian").width(425);
            $(".th_total").width(150);
            $(".th_tgcair").width(0);
            $(".th_bg").width(250);
            $(".th_cair").width(0);
            $(".th_jtempo").width(125);

        } else {}
    });

    function nomor() {
        var i = 1;
        $(".REC").each(function() {
            $(this).val(i++);
        });
        hitung();
    }

    function hitung() {
        var TJUMLAH = 0;

        var total_row = idrow;
        for (i = 0; i < total_row; i++) {

        };
        $(".JUMLAH").each(function() {
            var val = parseFloat($(this).val().replace(/,/g, ''));
            if (isNaN(val)) val = 0;
            TJUMLAH += val;
        });

        if (isNaN(TJUMLAH)) TJUMLAH = 0;

        $('#TJUMLAH').val(numberWithCommas(TJUMLAH));

        $('#TJUMLAH').autoNumeric('update');
    }

    function chekbox() {
        $(".CAIR").each(function() {
            if ($(this).is(":checked") == true) {
                $(this).attr('value', '1');
            } else {
                $(this).prop('checked', true);
                $(this).attr('value', '0');
            }
        });
    }

    function cekjumlah() {
        // bankmasuk
        var tjumlah = $('#TJUMLAH').val();
        var session_progam = "<?php echo $session_prog; ?>";
        var tjumlah_tampungan = $('#TJUMLAH_TAMPUNGAN').val();
        if (tjumlah != tjumlah_tampungan && (session_progam == 'ACCOUNTING'  || session_progam == 'PJL')) {
            // $('#TJUMLAH').val();
            alert("Jumlah Total Harus Sama !!!");
        } else {
            $('#bankmasuk').submit();
        }
    }

    function tambah() {
        var session_progam = "<?php echo $session_prog; ?>";
        if (session_progam == "KASIR") {

            var x = document.getElementById('datatable').insertRow(idrow + 1);
            var td1 = x.insertCell(0);
            var td2 = x.insertCell(1);
            var td3 = x.insertCell(2);
            var td4 = x.insertCell(3);
            var td5 = x.insertCell(4);
            var td6 = x.insertCell(5);
            var td7 = x.insertCell(6);
            var td8 = x.insertCell(7);
            var td9 = x.insertCell(8);

            var tdacno0 = "<div class='input-group'><select class='js-example-responsive-acno form-control ACNO0 text_input' name='ACNO[]' id=ACNO0" + idrow + " onchange='acno(this.id)' onfocusout='hitung()' required></select></div>";
            var tdacno = tdacno0;

            td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control text_input' onkeypress='return tabE(this,event)' readonly>";
            td2.innerHTML = tdacno;
            td3.innerHTML = "<input name='URAIAN[]' id=URAIAN0" + idrow + " type='text' class='form-control URAIAN text_input'><input name='NAMA[]' id=NAMA0" + idrow + " type='hidden' class='form-control NAMA text_input' readonly>";
            td4.innerHTML = "<input name='JUMLAH[]' onchange='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary'>";
            td5.innerHTML = "<input name='TGL_CAIR[]' ocnlick='select()' id=TGL_CAIR" + idrow + " type='text' class='date form-control TGL_CAIR text_input' data-date-format='dd-mm-yyyy' value=''> readonly disabled";
            td6.innerHTML = "<input name='CAIR[]' id=CAIR" + idrow + " type='checkbox' class='checkbox_container CAIR' value='0' unchecked disabled>";
            td7.innerHTML = "<input name='BG[]' id=BG0" + idrow + " type='text' class='form-control BG text_input'>";
            td8.innerHTML = "<input name='JTEMPO[]' ocnlick='select()' id=JTEMPO" + idrow + " type='text' class='date form-control JTEMPO text_input' data-date-format='dd-mm-yyyy' value='<?php if (isset($_POST["tampilkan"])) {
                                                                                                                                                                                                echo $_POST["JTEMPO"];
                                                                                                                                                                                            } else echo date('d-m-Y'); ?>'>";
            td9.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control' value='0'  >" +
                " <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

            jumlahdata = 100;
            for (i = 0; i <= jumlahdata; i++) {
                $("#JUMLAH" + i.toString()).autoNumeric('init', {
                    aSign: '<?php echo ''; ?>',
                    vMin: '-999999999.99'
                });
            }
            idrow++;
            select_acno();
            nomor();
            $(".ronly").on('keydown paste', function(e) {
                e.preventDefault();
                e.currentTarget.blur();
            });
            $('input[type="checkbox"]').on('change', function() {
                this.value ^= 1;
                console.log(this.value)
            });
        } else if (session_progam == "ACCOUNTING" || session_progam == "PJL") {
            var x = document.getElementById('datatable').insertRow(idrow + 1);
            var td1 = x.insertCell(0);
            var td2 = x.insertCell(1);
            var td3 = x.insertCell(2);
            var td4 = x.insertCell(3);
            var td5 = x.insertCell(4);
            var td6 = x.insertCell(5);
            var td7 = x.insertCell(6);

            var tdacno0 = "<div class='input-group'><select class='js-example-responsive-acno form-control ACNO0 text_input' name='ACNO[]' id=ACNO0" + idrow + " onchange='acno(this.id)' onfocusout='hitung()' required></select></div>";
            var tdacno = tdacno0;

            td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control text_input' onkeypress='return tabE(this,event)' readonly>";
            td2.innerHTML = tdacno;
            td3.innerHTML = "<input name='URAIAN[]' id=URAIAN0" + idrow + " type='text' class='form-control URAIAN text_input'><input name='NAMA[]' id=NAMA0" + idrow + " type='hidden' class='form-control NAMA text_input' readonly>";
            td4.innerHTML = "<input name='JUMLAH[]' onchange='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary'>";
            td5.innerHTML = "<input name='BG[]' id=BG0" + idrow + " type='text' class='form-control BG text_input'>";
            td6.innerHTML = "<input name='JTEMPO[]' ocnlick='select()' id=JTEMPO" + idrow + " type='text' class='date form-control JTEMPO text_input' data-date-format='dd-mm-yyyy' value='<?php if (isset($_POST["tampilkan"])) {
                                                                                                                                                                                                echo $_POST["JTEMPO"];
                                                                                                                                                                                            } else echo date('d-m-Y'); ?>'>";
            td7.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control' value='0'  >" +
                " <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

            jumlahdata = 100;
            for (i = 0; i <= jumlahdata; i++) {
                $("#JUMLAH" + i.toString()).autoNumeric('init', {
                    aSign: '<?php echo ''; ?>',
                    vMin: '-999999999.99'
                });
            }
            idrow++;
            select_acno();
            nomor();
            $(".ronly").on('keydown paste', function(e) {
                e.preventDefault();
                e.currentTarget.blur();
            });
            $('input[type="checkbox"]').on('change', function() {
                this.value ^= 1;
                console.log(this.value)
            });
        } else {

        }
    }

    function hapus() {
        if (idrow > 1) {
            var x = document.getElementById('datatable').deleteRow(idrow);
            idrow--;
            nomor();
        }
    }
</script>

<script>
    $(document).ready(function() {
        select_acno();
        //        select_no_fktr();
        select_kodec();
    });

    function select_acno() {
        var bnk = $('#BNK').val();
        $('.js-example-responsive-acno').select2({
            ajax: {
                url: "<?= base_url('admin/Transaksi_PembayaranBBM/getDataAjax_account') ?>",
                dataType: "json",
                type: "post",
                delay: 10,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page,
                        bnk: $('#BNK').val(),
                    }
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Account',
            minimumInputLength: 0,
            templateResult: format_acno,
            templateSelection: formatSelection_acno
        });
    }

    function format_acno(repo_acno) {
        if (repo_acno.loading) {
            return repo_acno.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix text_input'>" +
            "<div class='select2-result-repository__title text_input'></div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo_acno.ACNO);
        return $container;
    }
    var nama = '';

    function formatSelection_acno(repo_acno) {
        nama = repo_acno.NAMA;
        return repo_acno.text;
    }

    function acno(x) {
        var q = x.substring(4, 8);
        $('#NAMA' + q).val(nama);
        console.log('nama' + q);
    }

    function select_no_fktr() {
        var kodec = $('#KODEC').val();
        $('.js-example-responsive-no_fktr').select2({
            ajax: {
                url: "<?= base_url('admin/Transaksi_PembayaranBBM/getDataAjax_no_fktr') ?>",
                dataType: "json",
                type: "post",
                delay: 10,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page,
                        kodec: $('#KODEC').val(),
                    }
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Pilih PB',
            minimumInputLength: 0,
            templateResult: format_no_fktr,
            templateSelection: formatSelection_no_fktr
        });
    }

    function format_no_fktr(repo_no_fktr) {
        if (repo_no_fktr.loading) {
            return repo_no_fktr.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix text_input'>" +
            "<div class='select2-result-repository__title text_input'></div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo_no_fktr.NO_FKTR);
        return $container;
    }
    var jumlah = '';

    function formatSelection_no_fktr(repo_no_fktr) {
        jumlah = repo_no_fktr.JUMLAH;
        return repo_no_fktr.text;
    }

    function no_fktr(xx) {
        var qq = xx.substring(7, 11);
        $('#JUMLAH' + qq).val(jumlah);
        console.log('No Fktr :' + qq);
    }

    function select_kodec() {
        $('.js-example-responsive-kodec').select2({
            ajax: {
                url: "<?= base_url('admin/Transaksi_PembayaranBBM/getDataAjax_cust') ?>",
                dataType: "json",
                type: "post",
                delay: 10,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page,
                    }
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Customer',
            minimumInputLength: 0,
            templateResult: format_kodec,
            templateSelection: formatSelection_kodec
        });
    }

    function format_kodec(repo_kodec) {
        if (repo_kodec.loading) {
            return repo_kodec.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix text_input'>" +
            "<div class='select2-result-repository__title text_input'></div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo_kodec.KODEC);
        return $container;
    }
    var namac = '';

    function formatSelection_kodec(repo_kodec) {
        namac = repo_kodec.NAMAC;
        return repo_kodec.text;
    }

    function kodec(xxx) {
        var qqq = xxx.substring(5, 9);
        $('#NAMAC' + qqq).val(namac);
        console.log('Namas ' + qqq);
    }

    $('body').on('change', '.BG', function() {
        var NO_BG = $(this).val();
        var urut = $(this).attr('id').substring(2, 5);

        $('.BG').not(this).filter(function() {
            if ($(this).val() === NO_BG) {
                $("#BG" + urut).val("");
                alert("NO BG SUDAH ADA");
            }
        });
        $.ajax({
            type: 'get',
            url: '<?php echo base_url('index.php/admin/Transaksi_PembayaranBBM/cekBG'); ?>',
            data: {
                NO_BG: NO_BG
            },
            dataType: 'json',
            success: function(response) {
                $("#BG" + urut).val("");
                alert("NO BG SUDAH ADA");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
        });
    });
</script>
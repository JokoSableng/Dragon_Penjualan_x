<style>
    .alert-container {
        background-color: #1cc88a;
        color: black;
        font-weight: bolder;
    }

    .alert-container-2 {
        background-color: #ffffff;
        color: black;
        font-weight: bolder;
        text-align: center;
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
        background-color: #9c774c;
    }

    .table>tbody>tr>td>div>a:hover {
        transition: 0.4s;
        color: #b3b3b3;
        background-color: #9c774c;
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

    .label {
        color: black;
        font-weight: bold;
    }

    .text-input {
        color: black;
    }
</style>

<br>
<section>
    <div class="container-fluid">
        <div class="alert alert-success alert-container" role="alert">
            <i class="fas fa-university"></i>
            <label>
                Ambil Data SJ
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" action="<?php echo base_url('admin/DataPMS_AmbilDataSJ/index_DataPMS_AmbilDataSJ') ?>">
            <div class="col-md-12">
                <div class="form-group column">
                    <div class="alert alert-success alert-container-2" role="alert">
                        <div class="col-md-12">
                            <label style="color: black; text-align: left;">Periode <?php echo $this->session->userdata['periode']; ?></label>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <label class="label">Fase :</label>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control text_input PERKE" name="PERKE" id="PERKE">
                                        <?php if (isset($_POST["tampilkan"]) && $_POST["PERKE"] == '1') {
                                            echo "<option value='1' selected>1</option>";
                                            echo "<option value='2'>2</option>";
                                        } else {
                                            echo "<option value='1'>1</option>";
                                            echo "<option value='2' selected>2</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="label">PMS :</label>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control text_input WILAYAH" name="WILAYAH" id="WILAYAH">
                                        <?php if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '66') {
                                            echo "<option value='66' selected>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '77') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77' selected>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '88') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88' selected>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '90') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90' selected>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '91') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91' selected>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '92') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92' selected>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '93') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93' selected>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '94') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94' selected>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '95') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95' selected>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '96') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96' selected>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '97') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97' selected>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '98') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98' selected>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        } else if (isset($_POST["tampilkan"]) && $_POST["WILAYAH"] == '100') {
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100' selected>BANDUNG</option>";
                                        } else {
                                            echo "<option value='' selected>Pilih Wilayah</option>";
                                            echo "<option value='66'>INDOTIM</option>";
                                            echo "<option value='77'>JATIM B</option>";
                                            echo "<option value='88'>CAKRA</option>";
                                            echo "<option value='90'>ONLINE</option>";
                                            echo "<option value='91'>JATIM</option>";
                                            echo "<option value='92'>JATENG</option>";
                                            echo "<option value='93'>JAKARTA</option>";
                                            echo "<option value='94'>LAMPUNG</option>";
                                            echo "<option value='95'>PALEMBANG</option>";
                                            echo "<option value='96'>PEKANBARU</option>";
                                            echo "<option value='97'>PADANG</option>";
                                            echo "<option value='98'>MEDAN</option>";
                                            echo "<option value='100'>BANDUNG</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group-append">
                                        <input class="btn btn-primary" type="submit" name="submit" value="Tampil Data">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="<?php echo base_url('admin/DataPMS_AmbilDataSJ/update') ?>">
            <table id="databbm" class="table table-bordered table-striped table-hover " style="width:100%; font-size: 13px">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Fase</th>
                        <th>Tanggal</th>
                        <th>No Bukti</th>
                        <th>No SO</th>
                        <th>Wilayah</th>
                        <th>Kodec</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($ambildatasj as $ambildatasjp) :
                    ?>
                        <tr>
                            <td class="text_input"><?php echo $ambildatasjp->PER ?><input type="hidden" name="no_bukti[]" value="<?php echo $ambildatasjp->NO_BUKTI ?>"></td>
                            <td class="text_input"><?php echo $ambildatasjp->PERKE ?></td>
                            <td class="text_input"><?php if ($ambildatasjp->TGL == "2001-01-01") echo '';
                                                    else echo date('d-m-Y', strtotime($ambildatasjp->TGL, TRUE)) ?></td>
                            <td style="font-weight: bold; text-decoration: underline; color: blue;"><?php echo $ambildatasjp->NO_BUKTI ?></td>
                            <td class="text_input"><?php echo $ambildatasjp->NO_SO ?></td>
                            <td class="text_input"><?php echo $ambildatasjp->WILAYAH ?></td>
                            <td class="text_input"><?php echo $ambildatasjp->KODEC ?></td>
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
        $('#databbm').DataTable({
            dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
                "<'row'<'col-md-2'l><'col-md-6 test_btn'><'col-md-4'f>>" + // peletakan entries, search, dan test_btn
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [
                [0, "asc"]
            ],
        });
        $('.buttons-pdf, .buttons-excel, .buttons-print').addClass('btn btn-primary mb-3');
        $("div.test_btn").append(' <input type="submit" class="btn btn-danger mb-3" id="update" name="update" value="Ambil Data PMS"> ');
    });
</script>


<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if ((event.keyCode == 13)) {
                event.preventDefault();
                return false;
            }
        });
        $('body').on('keyup', 'input.numinput', function() {
            if (event.which != 190) {
                if (event.which >= 37 && event.which <= 40) return;
            }
            this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            hitung();
        });
    });
</script>
<style>
    .alert-container {
        background-color: #1cc88a;
        color: black;
        font-weight: bolder;
    }

    .table {
        /* height: 350px; */
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
        /* text-align: center; */
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
                Utility <?= $JUDUL ?>
            </label>
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <br>
        <form method="post" id="entri" action="<?php echo base_url('admin/Utility_KasBank_Bukti/index_KasBank_Bukti/'.$JENIS) ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">No Bukti lama</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control text_input nobukti" id="nobukti" name="nobukti" onchange="cekBuktiBaru(); getNoBukti()" placeholder="Bukti lama">
                            </div>
                            <label class="form-label" id="lbl_buktilama" style="color:red; font-size:18px"></label>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">No Bukti baru</label>
                            </div>
                            <div class="col-md-2 input-group" style="display:flex;">
                                <label class="form-label" id="lbl_tipe" style="font-size:18px">----</label>
                                <input type="text" class="form-control text_input nobukti_baru" id="nobukti_baru" name="nobukti_baru" onkeyup="cekBuktiBaru()" placeholder="(4 digit)" maxlength="4" style="width:50px;">
                                <label class="form-label" id="lbl_periode" style="font-size:18px">--------</label>
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" id="statusBukti" class="form-control" style="pointer-events: none; accent-color: green;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1">
                                <label class="label">Tanggal</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="date form-control text_input TGL" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" onchange="formatBukti()">
                            </div>
                            <label class="form-label" id="lbl_tgl" style="color:red; font-size:18px"></label>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-2">
                                <input class="btn btn-primary btn-block" type="button" value="GANTI" onclick="simpan()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-fixed table-striped table-border table-hover nowrap datatable">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No Bukti</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">No SJ</th>
                    <th scope="col">Kode Cus</th>
                    <th scope="col">Nilai</th>
                </tr>
            </thead>
            <tbody>
            </tbody> 
        </table>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy',
        });
        
        formatBukti();
    });
    
    function getNoBukti() {
		var buktilama = $("#nobukti").val();
        var jenis = <?=$JENIS?>;
        //1 BKM ke BKM, 2 BKM ke BBM, 3 BBM ke BBM, 4 BBM ke BKM
        if((jenis=="1" || jenis=="2") && (buktilama.substring(0,3)!="BKM"))
        {
            $("#lbl_buktilama").text("No Bukti lama salah! ("+$("#nobukti").val()+")");
            $("#nobukti").val('')
        }
        else if((jenis=="3" || jenis=="4") && (buktilama.substring(0,3)!="BBM")) 
        {
            $("#lbl_buktilama").text("No Bukti lama salah! ("+$("#nobukti").val()+")");
            $("#nobukti").val('')
        }
        else
        {
            $("#lbl_buktilama").text("");
            $('.datatable').DataTable().destroy();
            tabel = $('.datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": true,
                "order": [[ 0, 'asc' ]],
                "ajax":
                {
                    "url": "<?= base_url('admin/Utility_KasBank_Bukti/getDetailBukti') ?>",
                    "type": "POST",
                    "data": {
                        "nobukti" : $('#nobukti').val(),
                    }
                },
                "deferRender": true,
                "aLengthMenu": [[10, 20, 50],[ 10, 20, 50]],
                "columns": [
                    // { "data": "id",
                    //     render: function (data, type, row, meta) {
                    //         return meta.row + meta.settings._iDisplayStart + 1;
                    //     }
                    // },
                    { "data": "NO_BUKTI" },
                    { "data": "TGL_FKTR" },
                    { "data": "NO_SURAT" },
                    { "data": "KODEC" },
                    { "data": "TOTAL", render: $.fn.dataTable.render.number( ',', '.', 0, '' ) },
                ],
                "columnDefs": 
                [
                    {
                        "className": "text-center", 
                        "targets": [0,1,2,3]
                    },
                    {
                        "className": "text-right", 
                        "targets": [4]
                    },
                ],
            });
        }
    }
    
	function cekBuktiBaru(){
		var buktilama = $("#nobukti").val();
		var buktibaru = $("#lbl_tipe").text()+$("#nobukti_baru").val()+$("#lbl_periode").text();
		var hasilCek='YES';

        if($("#nobukti_baru").val()!='')
        {
            $.ajax(
            {
                type: 'POST',    
                url: "<?= base_url('admin/Utility_KasBank_Bukti/cekBuktiBaru') ?>",
                data: {
                    'NO_BUKTI': buktibaru,
                },
                success: function(resp)
                {
                    if (resp.length > 0) {
                        $.each(resp, function(i, item) {
                            hasilCek=resp[i].POSTED;
                        });
                    }

                    if (hasilCek=='YES' && buktilama!=buktibaru) {
                        $('#statusBukti').prop('checked', true).change();
                    }
                    else {
                        $('#statusBukti').prop('checked', false).change();
                    }

                },
                error: function() {
                    console.log('Error cekBuktiBaru occured');
                }
            });
        }
	}

    function formatBukti()
    {
        var jenis = <?=$JENIS?>;
        if(jenis=="1" || jenis=="4")
        {
            //1 BKM ke BKM, 4 BBM ke BKM
            $("#lbl_tipe").text("BKM-");
        }
        if(jenis=="2" || jenis=="3")
        {
            //2 BKM ke BBM, 3 BBM ke BBM
            $("#lbl_tipe").text("BBM-");
        }
        
        var tgl = $("#TGL").val();
        var hari = tgl.substring(0,2);
        var bulan = tgl.substring(3,5);
        var tahun = tgl.substring(6,10);

        var convertTgl = new Date(tahun,bulan-1,hari);
        if ((convertTgl.getMonth()+1!=bulan)||(convertTgl.getDate()!=hari))
        {
            $("#lbl_periode").text("--------");
            $("#lbl_tgl").text("Cek tanggal! ("+$("#TGL").val()+")");
            return 1;
        }
        else
        {
            $("#lbl_periode").text("/"+bulan+"/"+tahun);
            $("#lbl_tgl").text("");
            return 0;
        }
    }

    function simpan()
    {
        formatBukti();
        cekBuktiBaru();
        var cek = 0;
		var buktilama = $("#nobukti").val();
        var tabel = $('.datatable').DataTable();
 
        if (!tabel.data().count()) 
        {
            cek=1;
            alert('Data Bukti lama tidak ada!');
        }
        if(buktilama=='')
        {
            cek=1;
            alert("Cek entrian No Bukti!");
        }
        if($('#statusBukti').is(':checked')==false)
        {
            cek=1;
            alert("No Bukti baru tidak dapat diproses!");
        }
        if(formatBukti()==1)
        {
            cek=1
            alert("Cek tanggal! ("+$("#TGL").val()+")");
        }

        if(cek==0)
        {
			document.getElementById("entri").submit();
        }
    }
</script>
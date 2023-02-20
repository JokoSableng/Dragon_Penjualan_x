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

    .total {
        font-size: 14px;
        font-weight: bold;
        color: blue;
    }

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

    .text_input {
        font-size: small;
        color: black;
    }
</style>

<div class="container-fluid">
    <br>
    <div class="alert alert-success alert-container" role="alert">
        <i class="fas fa-university"></i> Input Cek BKM PMS A
    </div>
    <form id="cekbkm_pmsa" name="cekbkm_pmsa" action="<?php echo base_url('admin/Transaksi_CekBKM_PMSA/input_aksi'); ?>" class="form-horizontal" method="post">
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-1">
                            <label class="label">No Bukti </label>
                        </div>
                        <div class="input-group col-md-2">
                            <input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value='BKM-'>
                        </div>
						<div class="col-md-4">
							<label id="bukti_akhir" style="color: blue; font-weight: bold;">
								No Bukti Terakhir
							</label>
						</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-1">
                            <label class="label">Tanggal </label>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="date form-control text_input" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
                                                                                                                                                    echo $_POST["TGL"];
                                                                                                                                                } else echo date('d-m-Y'); ?>" onclick="select()">
                        </div>
                        <div class="col-md-1">
                            <label class="label">Setor </label>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control text_input" name="KD_SETOR" id="KD_SETOR" style="width: 100%;">
                                <option value="RI" selected>RI</option>
                                <option value="CA">CA</option>
                                <option value="DN">DN</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="label">Kode Area </label>
                        </div>
                        <div class="col-md-2">
                            <select class="js-example-responsive-wilayah form-control text_input WILAYAH" name="WILAYAH" id="WILAYAH" onchange="wilayah(this.id)"></select>
                        </div>
                        <div class="col-md-1">
                            <label class="label">No Perk </label>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control text_input ACC" id="ACC" name="ACC" type="text" value=''>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-1">
                            <label class="label">Customer </label>
                        </div>
                        <div class="col-md-2">
                            <select class="js-example-responsive-kodec form-control text_input KODEC" name="KODEC" id="KODEC" onchange="kodec(this.id)"></select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control text_input NAMAC" id="NAMAC" name="NAMAC" type="text" value='' readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-1">
                            <label class="label">Notes </label>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value=''>
                        </div>
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-5">
                            <input class="btn btn-secondary" id="CENTANG" type="button" onclick="centang()" value="Centang">
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
                                <th width="200px">No Sj</th>
                                <th width="200px">Invoice</th>
                                <th width="200px">Tg Fak</th>
                                <th width="200px">Tgl Sj</th>
                                <th width="150px">Bayar</th>
                                <th width="150px">Cek</th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly> <input name="NOBUKTI[]" id="NOBUKTI0" type="text" class="form-control NOBUKTI text_input" hidden readonly></td>
                                <!-- <td>
                                    <div class='input-group'>
                                        <select value="" class="js-example-responsive-no_surat form-control NO_SURAT0" name="NO_SURAT[]" id="NO_SURAT0" onchange="no_surat(this.id)" onfocusout="hitung()" required></select>
                                    </div>
                                </td> -->
                                <td><input name="NO_SURAT[]" id="NO_SURAT0" type="text" class="form-control NO_SURAT text_input" readonly></td>
                                <td><input name="INVOICE[]" id="INVOICE0" type="text" class="form-control INVOICE text_input" readonly></td>
                                <td><input name="TGL_FKTR[]" id="TGL_FKTR0" type="text" class="form-control TGL_FKTR text_input" readonly></td>
                                <td><input name="TGL_SURAT[]" id="TGL_SURAT0" type="text" class="form-control TGL_SURAT text_input" readonly></td>
                                <td><input name="TOTAL[]" onclick="select()" onkeyup="hitung()" value="0" id="TOTAL0" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
                                <td><input name="TANDA[]" id="TANDA0" type="text" class="form-control TANDA text_input"></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
                                        <i class="fa fa-fw fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input class="form-control TTOTAL rightJustified text-primary font-weight-bold" id="TTOTAL" name="TTOTAL" value="0" readonly></td>
                            <td></td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <!--tab-->
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-1">
                    <button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-3">
                    <h3 class="label">Metode Pembayaran </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive scrollable">
                    <table class="table table-hoverx table-stripedx table-borderedx table-condensed table-scrollable">
                        <thead>
                            <tr>
                                <th width="200px">No Giro</th>
                                <th width="200px">Bank</th>
                                <th width="200px">J Tempo</th>
                                <th width="100px">Tgl Cair</th>
                                <th width="150px">Giro</th>
                                <th width="150px">Tunai</th>
                                <th width="150px">Ku</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input name="NO_CHBG" id="NO_CHBG" type="text" class="form-control NO_CHBG text_input"></td>
                                <td><input name="BANK" id="BANK" type="text" class="form-control BANK text_input"></td>
                                <td>
                                    <input type="text" class="date form-control text_input" id="JTEMPO" name="JTEMPO" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
                                                                                                                                                                echo $_POST["JTEMPO"];
                                                                                                                                                            } else echo date('d-m-Y'); ?>" onclick="select()">
                                </td>
                                <td>
                                    <input type="text" class="date form-control text_input" id="TGL_CAIR" name="TGL_CAIR" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
                                                                                                                                                                    echo $_POST["TGL_CAIR"];
                                                                                                                                                                } else echo date('d-m-Y'); ?>" onclick="select()">
                                </td>
                                <td><input name="GIRO" onclick="select()" onkeyup="hitung()" value="0" id="GIRO" type="text" class="form-control GIRO rightJustified text-primary"></td>
                                <td><input name="TUNAI" onclick="select()" onkeyup="hitung()" value="0" id="TUNAI" type="text" class="form-control TUNAI rightJustified text-primary"></td>
                                <td><input name="KU" onclick="select()" onkeyup="hitung()" value="0" id="KU" type="text" class="form-control KU rightJustified text-primary"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-xs-9">
                <div class="wells">
                    <div class="btn-group cxx">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        <a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
                    </div>
                    <h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
                </div>
            </div>
        </div>
    </form>
</div>


    <div class="modal fade" id="browseCentangModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Pilih BKM/BBM</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-centang">
				<thead>
					<tr>
						<th>No SJ</th>
						<th>Invoice</th>
						<th>No BKM Lama</th>
						<th>Nilai</th>
						<th>Kodecus</th>
						<th>Giro</th>
						<th>Jtempo</th>
						<th>Tgl Cair</th>
						<th>Centang</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" onclick="chooseCentangArr()" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

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
    var idrow = 1;

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $(document).ready(function() {
        no_terakhir();
        $("#TTOTAL").autoNumeric('init', {
            aSign: '<?php echo ''; ?>',
            vMin: '-999999999.99'
        });
        $("#GIRO").autoNumeric('init', {
            aSign: '<?php echo ''; ?>',
            vMin: '-999999999.99'
        });
        $("#TUNAI").autoNumeric('init', {
            aSign: '<?php echo ''; ?>',
            vMin: '-999999999.99'
        });
        $("#KU").autoNumeric('init', {
            aSign: '<?php echo ''; ?>',
            vMin: '-999999999.99'
        });
        jumlahdata = 100;
        for (i = 0; i <= jumlahdata; i++) {
            $("#TOTAL" + i.toString()).autoNumeric('init', {
                aSign: '<?php echo ''; ?>',
                vMin: '-999999999.99'
            });
        }
        $('body').on('click', '.btn-delete', function() {
            var val = $(this).parents("tr").remove();
            // idrow--;
            nomor();
        });
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy',
        })

        
        var dTableCentang;
		var rowidCentang;
		loadDataCentang = function(){
			var dataDetail = $("input[name='NO_SURAT[]']").map(function() {
				var isi = "''";
				if ($(this).val()) {
					isi = "'" + $(this).val() + "'";
				}
				return isi;
			}).get();

			$.ajax(
			{
				type: 'GET',    
			    url: '<?php echo base_url('admin/Transaksi_CekBKM_PMSA/getDataCentang'); ?>',
				dataType: 'json',
				data: {
                    kodec: $('#KODEC').val(),
					listDetail: dataDetail, 
				},
				success: function(resp)
				{
					if(dTableCentang){
						dTableCentang.clear();
					}
					for(var i=0; i<resp.length; i++){
						dTableCentang.row.add([
							'<label id="pilihSurat'+i+'" value="'+resp[i].NO_SURAT+'">'+resp[i].NO_SURAT+'</label> <input id="pilihTgSurat'+i+'" hidden value="'+resp[i].TGL_SURAT+'"></input> <input id="pilihTgFaktur'+i+'" hidden value="'+resp[i].TGL_FKTR+'"></input>',
							resp[i].INVOICE,
							resp[i].NO_BUKTI,
							'<label id="pilihNilai'+i+'" value="'+resp[i].BAYAR+'">'+Intl.NumberFormat('en-US').format(resp[i].BAYAR)+'</label>',
							resp[i].KODEC,
							Intl.NumberFormat('en-US').format(resp[i].GIRO),
							resp[i].JTEMPO,
							resp[i].TGL_CAIR,
							'<input type="checkbox" class="form-control" id="pilih'+i+'" value="'+resp[i].NO_ID+'"></input>',						
						]);
					}
					dTableCentang.draw();
				}
			});
		}
		
		dTableCentang = $("#table-centang").DataTable({
			
			columnDefs: [
				{
					targets:  [3,5],
					className: 'text-right'
				}
			],
		});
		
		centang = function(){
            var barisDetail = $('#datatable tbody tr').length;
            var barisInsert = idrow!=barisDetail ? idrow : barisDetail;
            if (idrow==1) barisInsert=0;
			rowidCentang = barisInsert;
			loadDataCentang();
			$("#browseCentangModal").modal("show");
		}
        
		chooseCentangArr = function(){
			var centangDipilih = $("input[type='checkbox']").map(function() {
				var idx = dTableCentang.row(this).index();
				var kode = null;
				if($(this).prop("checked"))
				{
					kode = '"'+$(this).val()+'"';
				} 
				return kode;
			}).get();
			var suratDipilih = $("input[type='checkbox']").map(function() {
				var kode = null;
				if($(this).prop("checked"))
				{
					var idx = (this.id).substring(5, 10);
					kode = '"' + $("#pilihSurat"+idx).text() + '"';
				} 
				return kode;
			}).get();
			var tgFakturDipilih = $("input[type='checkbox']").map(function() {
				var kode = null;
				if($(this).prop("checked"))
				{
					var idx = (this.id).substring(5, 10);
					kode = '"' + $("#pilihTgFaktur"+idx).val() + '"';
				} 
				return kode;
			}).get();
			var tgSuratDipilih = $("input[type='checkbox']").map(function() {
				var kode = null;
				if($(this).prop("checked"))
				{
					var idx = (this.id).substring(5, 10);
					kode = '"' + $("#pilihTgSurat"+idx).val() + '"';
				} 
				return kode;
			}).get();
			var nilaiDipilih = $("input[type='checkbox']").map(function() {
				var kode = null;
				if($(this).prop("checked"))
				{
					var idx = (this.id).substring(5, 10);
					kode = '"' + $("#pilihNilai"+idx).text() + '"';
				} 
				return kode;
			}).get();

			var centangArr = JSON.parse("[" + centangDipilih + "]");
			var suratArr = JSON.parse("[" + suratDipilih + "]");
			var tgFakturArr = JSON.parse("[" + tgFakturDipilih + "]");
			var tgSuratArr = JSON.parse("[" + tgSuratDipilih + "]");
			var nilaiArr = JSON.parse("[" + nilaiDipilih + "]");
            
			while (idrow<(parseInt(rowidCentang)+parseInt(suratArr.length)))
			{
				tambah();
			};

			for (var i=0 ; i<suratArr.length ; i++) 
			{
				$("#NOBUKTI"+(parseInt(rowidCentang)+i)).val(centangArr[i]);
				$("#NO_SURAT"+(parseInt(rowidCentang)+i)).val(suratArr[i]);
				$("#TGL_FKTR"+(parseInt(rowidCentang)+i)).val(tgFakturArr[i]);
				$("#TGL_SURAT"+(parseInt(rowidCentang)+i)).val(tgSuratArr[i]);
				$("#TOTAL"+(parseInt(rowidCentang)+i)).val(nilaiArr[i]);
				// $("#TANDA"+(parseInt(rowidCentang)+i)).val('*');
			};

			$("#browseCentangModal").modal("hide");
            metodeBayar();
			hitung();
		}

    });

	function metodeBayar() {
        var noid = 0;
        $(".NOBUKTI").each(function(i, el) {
            if(i===0)
            {
                noid = $(this).val();
                
                $.ajax({
                    type: 'get',
                    url: '<?php echo base_url('admin/Transaksi_CekBKM_PMSA/getMetodeBayar'); ?>',
                    data: {
                        no_id: noid,
                    },
                    dataType: 'json',
                    success: function(response) {
                        $("#NO_CHBG").val(response[0].NO_CHBG);
                        $("#BANK").val(response[0].BANK);
                        $("#JTEMPO").val(response[0].JTEMPO);
                        $("#TGL_CAIR").val(response[0].TGL_CAIR);
                        $("#GIRO").val(response[0].GIRO);
                        $("#TUNAI").val(response[0].TUNAI);
                        $("#KU").val(response[0].KU);

                        $("#GIRO").autoNumeric('update');
                        $("#TUNAI").autoNumeric('update');
                        $("#KU").autoNumeric('update');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {}
                });
            }
        });
    }

	function no_terakhir() {
		$.ajax({
			type: 'get',
			url: '<?php echo base_url('admin/Transaksi_CekBKM_PMSA/no_terakhir'); ?>',
			data: {
				tipe: 'BKM',
				// kd: $("#KD").val(),
			},
			dataType: 'json',
			success: function(response) {
				$("#bukti_akhir").text("No Bukti Terakhir " + (response[0].NO_BUKTI ?? '-') );
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {}
		});

	}

    function nomor() {
        var i = 1;
        $(".REC").each(function() {
            $(this).val(i++);
        });
        hitung();
    }

    function hitung() {
        var TTOTAL = 0;

        $(".TOTAL").each(function() {
            var val = parseFloat($(this).val().replace(/,/g, ''));
            if (isNaN(val)) val = 0;
            TTOTAL += val;
        });

        if (isNaN(TTOTAL)) TTOTAL = 0;

        $('#TTOTAL').val(numberWithCommas(TTOTAL));
        $("#TTOTAL").autoNumeric('update');
    }

    function tambah() {

        // var x = document.getElementById('datatable').insertRow(idrow + 1);
        var x = document.getElementById('datatable').getElementsByTagName('tbody')[0].insertRow();
        var td1 = x.insertCell(0);
        var td2 = x.insertCell(1);
        var td3 = x.insertCell(2);
        var td4 = x.insertCell(3);
        var td5 = x.insertCell(4);
        var td6 = x.insertCell(5);
        var td7 = x.insertCell(6);
        var td8 = x.insertCell(7);

        var no_surat0 = "<div class='input-group'><select class='js-example-responsive-no_surat form-control NO_SURAT' name='NO_SURAT[]' value='' id=NO_SURAT" + idrow + " onchange='no_surat(this.id)' onfocusout='hitung()' required></select></div>";
        var no_surat = no_surat0;

        td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly> <input name='NOBUKTI[]' id=NOBUKTI" + idrow + " type='text' class='form-control NOBUKTI text_input' hidden readonly>";
        // td2.innerHTML = no_surat;
        td2.innerHTML = "<input name='NO_SURAT[]' id=NO_SURAT" + idrow + " type='text' class='form-control NO_SURAT text_input' readonly>";
        td3.innerHTML = "<input name='INVOICE[]' id=INVOICE" + idrow + " type='text' class='form-control INVOICE text_input' readonly>";
        td4.innerHTML = "<input name='TGL_FKTR[]' onclick='select()' id=TGL_FKTR" + idrow + " type='text' class='form-control TGL_FKTR text_input' readonly>";
        td5.innerHTML = "<input name='TGL_SURAT[]' onclick='select()' id=TGL_SURAT" + idrow + " type='text' class='form-control TGL_SURAT text_input' readonly>";
        td6.innerHTML = "<input name='TOTAL[]' onclick='select()' onkeyup='hitung()' value='0' id=TOTAL" + idrow + " type='text' class='form-control TOTAL rightJustified text-primary' readonly>";
        td7.innerHTML = "<input name='TANDA[]' id=TANDA" + idrow + " type='text' class='form-control TANDA text_input' maxlength='1'>";
        td8.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
            " <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

        jumlahdata = 100;
        for (i = 0; i <= jumlahdata; i++) {
            $("#TOTAL" + i.toString()).autoNumeric('init', {
                aSign: '<?php echo ''; ?>',
                vMin: '-999999999.99'
            });
        }
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy',
        })
        // select_no_surat();
        idrow++;
        nomor();
        $(".ronly").on('keydown paste', function(e) {
            e.preventDefault();
            e.currentTarget.blur();
        });
    }

    function hapus() {
        if (idrow > 1) {
            var x = document.getElementById('datatable').deleteRow(idrow);
            // idrow--;
            nomor();
        }
    }
</script>

<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if ((event.keyCode == 13)) {
                event.preventDefault();
                return false;
            }
        });
        select_wilayah();
        select_kodec();
        // select_no_surat();
    });

    function select_wilayah() {
        $('.js-example-responsive-wilayah').select2({
            ajax: {
                url: "<?= base_url('admin/Transaksi_CekBKM_PMSA/getDataAjax_wilayah') ?>",
                dataType: "json",
                type: "post",
                delay: 10,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page
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
            placeholder: 'Pilih Wilayah',
            minimumInputLength: 0,
            templateResult: format_wilayah,
            templateSelection: formatSelection_wilayah
        });
    }

    function format_wilayah(repo_wilayah) {
        if (repo_wilayah.loading) {
            return repo_wilayah.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix text_input'>" +
            "<div class='select2-result-repository__title text_input'></div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo_wilayah.WILAYAH);
        return $container;
    }

    function formatSelection_wilayah(repo_wilayah) {
        return repo_wilayah.text;
    }

    function wilayah(x) {
        var q = x.substring(7, 9);
        console.log('Wilayah :' + q);
    }

    function select_kodec() {
        var wilayah = $('#WILAYAH').val();
        $('.js-example-responsive-kodec').select2({
            ajax: {
                url: "<?= base_url('admin/Transaksi_CekBKM_PMSA/getDataAjax_cust') ?>",
                dataType: "json",
                type: "post",
                delay: 10,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page,
                        wilayah: $('#WILAYAH').val(),
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

    function kodec(xx) {
        var qq = xx.substring(6, 8);
        $('#NAMAC' + qq).val(namac);
        isiNoperk();
        console.log('Namac :' + qq);
    }

    function isiNoperk() {
        var kodeCus = $('#KODEC').val();
        $('#ACC').val("");
        if (kodeCus.substring(0,2)=="66") $('#ACC').val("132.13");
        if (kodeCus.substring(0,2)=="77") $('#ACC').val("132.12");
        if (kodeCus.substring(0,2)=="88") $('#ACC').val("132.09");
        if (kodeCus.substring(0,2)=="90") $('#ACC').val("132.11");
        if (kodeCus.substring(0,2)=="91") $('#ACC').val("132.01");
        if (kodeCus.substring(0,2)=="92") $('#ACC').val("132.02");
        if (kodeCus.substring(0,2)=="93") $('#ACC').val("132.03");
        if (kodeCus.substring(0,2)=="94") $('#ACC').val("132.04");
        if (kodeCus.substring(0,2)=="95") $('#ACC').val("132.05");
        if (kodeCus.substring(0,2)=="97") $('#ACC').val("132.07");
        if (kodeCus.substring(0,2)=="98") $('#ACC').val("132.08");
        if (kodeCus.substring(0,3)=="100") $('#ACC').val("132.10");
    }
/*
    function select_no_surat() {
        var kodec = $('#KODEC').val();
        $('.js-example-responsive-no_surat').select2({
            ajax: {
                url: "<?php //echo base_url('admin/Transaksi_CekBKM_PMSA/getDataAjax_no_surat') ?>",
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
            placeholder: 'Pilih No SJ',
            minimumInputLength: 0,
            templateResult: format_no_surat,
            templateSelection: formatSelection_no_surat
        });
    }

    function format_no_surat(repo_no_surat) {
        if (repo_no_surat.loading) {
            return repo_no_surat.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix text_input'>" +
            "<div class='select2-result-repository__title text_input'></div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo_no_surat.NO_SURAT);
        return $container;
    }
    var invoice = '';
    var tgl_fktr = '';
    var tgl_surat = '';
    var total = '';

    function formatSelection_no_surat(repo_no_surat) {
        invoice = repo_no_surat.INVOICE;
        tgl_fktr = repo_no_surat.TGL_FKTR;
        tgl_surat = repo_no_surat.TGL_SURAT;
        total = repo_no_surat.TOTAL;
        return repo_no_surat.text;
    }

    function no_surat(xxx) {
        var qqq = xxx.substring(8, 12);
        $('#INVOICE' + qqq).val(invoice);
        $('#TGL_FKTR' + qqq).val(tgl_fktr);
        $('#TGL_SURAT' + qqq).val(tgl_surat);
        $('#TOTAL' + qqq).val(total);
        $('#TOTAL' + qqq).autoNumeric('update');
        console.log('No Surat :' + qqq);
        hitung();
    }
    */
</script>
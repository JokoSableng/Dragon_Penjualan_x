<section>
<div class="container-fliud mx-2">

    <div class="alert alert-success" role="alert">
      <i class="fas fa-university"></i> Laporan
    </div>

    <?php echo $this->session->flashdata('pesan') ?>

	<div class="dropdown">
		<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Tutorial
		</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="https://www.malasngoding.com/category/html">HTML</a>
				<a class="dropdown-item" href="https://www.malasngoding.com/category/bootstrap-4">Bootstrap 4</a>
				<a class="dropdown-item" href="https://www.malasngoding.com/category/codeigniter">CodeIgniter</a>
			</div>
	</div>

    <form method="post" action="<?php echo base_url('admin/laporan')?>">

	<div class="col-md-6">
			<div class="form-group row">
				<div class="col-md-2">
					<label>Tanggal</label>
				</div>
				<div class="col-md-4 nopadding">
						<input type="text" class="date form-control" name="TGL1" value="" data-date-format="dd-mm-yyyy" >

				</div>
				<div class="col-md-1 nopadding">
					<label>S/D</label>
				</div>
				<div class="col-md-4 nopadding">
						<input type="text" class="date form-control" name="TGL2" value="" data-date-format="dd-mm-yyyy" >
				</div>

			</div>
	</div>
	
	<button class="btn btn-md btn-secondary"> Tampilkan </button>

	<hr class="m-t-10">

	<div class="btn-group btn-md" role="group" aria-label="Basic example">
        <a class="btn  btn-smd btn-success" href="piu/input"> <i class="fas fa-plus fa-sm mb-3" ></i></a>
        
        <button  type="submit" class="btn btn-sm btn-danger"> <i class="fas fa-trash fa-sm mb-3"></i></button>
        <a class="btn btn-md btn-success" href="laporan/print"> <i class="fas fa-print fa-md mb-3" ></a></i>
    </div>  

    <br>
	<br>
	
    <table id="example" class="table display table-bordered table-striped table-hover " style="width:100%; display:none;">
        <thead>
        <tr>
            <th>NO</th>
            <th>No Bukti</th>
            <th>Tgl</th>
            <th>Merk</th>
            <th class="apply-filter">Nama</th>
            <th>No Faktur</th>
            <th>Total </th>
          
        </tr>
        </thead>
        <tbody>
         <?php
        $no=1;
        foreach ($piu as $piup ): ?>
        <tr>
            <td  width="20px"><?php echo $no++ ?></td>
			<!-- <td><a href="laporan/response/<?php echo $piup->ID ?>" ><?php echo $piup->NO_BUKTI ?></a></td> -->
			<td><input type="button" class="btn btn-primary view_detail" relid="<?php echo $piup->ID ?>" value="<?php echo $piup->NO_BUKTI ?>"></td>
            <td><?php echo $piup->TGL?></td>
            <td><?php echo $piup->MERK?></td>
            <td><?php echo $piup->NAMA ?></td>
            <td><?php echo $piup->NO_FAKTUR?></td>
            <td><?php echo $piup->TTOTAL?></td>
            
        </tr>

        <?php endforeach; ?> 
        </tbody>
    </table>
    
  

</form>

</div>

<div class="modal fade" id="modalMd" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Detail Laporan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>    
                    </div>
                    <div class="modal-body">
					<table class="table table-bordered table-striped">
						<thead class="btn-primary">
							<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							</tr>
						</thead>
						<tbody id="show-data">

						</tbody>
					</table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
		</div>
		
</section>

<script>
$(document).ready(function()
{	
		$(".date").datepicker({
			'dateFormat':'dd-mm-yy',
		})
});

function showDetail(id){
        $('#modalMd').modal('show');
        }
</script>

<script type="text/javascript">
    $(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name="_token"]').attr('content')
			}
			});
	
      $('.view_detail').click(function(){
          var id = $(this).attr('relid'); //get the attribute value
          $.ajax({
              type:'get',
              url : '<?php echo base_url('index.php/admin/laporan/response'); ?>',
              data:{id : id},
              dataType: 'json',
              success:function(response) {
				alert(response);
					var html = '';
                    var i;
                    for(i=0; i<response.length; i++){
                        html += '<tr>'+
                                '<td>'+response[i].NAMA+'</td>'+
                                '<td>'+response[i].MERK+'</td>'+
                                '<td>'+response[i].NO_ID+'</td>'+
                                '</tr>';
                    }
					$('#modalMd').modal({backdrop: 'static', keyboard: true, show: true});
					$('#show-data').html(html);
			}
          });
      });
    });
</script>

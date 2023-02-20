<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Dragon Penjualan</title>
	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
	<div class="container"> <br><br><br>
		<!-- Outer Row -->
		<div class="row justify-content-center">
			<div class="col-xl-5 col-lg-6 col-md-5">
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Login Administrator</h1>
										<?php echo $this->session->flashdata('pesan') ?>
										<?php echo $this->session->unset_userdata('pesan') ?>
									</div>
									<form method="post" action="<?php echo base_url('admin/auth/proses_login') ?>" class="user">
										<div class="form-group">
											<input type="text" class="form-control form-control-user" id="exampleInputEmail" placeholder="User Name" name="username">
											<?php echo form_error('username', '<div class="text-danger small ml-3">', '</div>') ?>
										</div>
										<div class="form-group">
											<input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
											<?php echo form_error('password', '<div class="text-danger small ml-3">', '</div>') ?>
										</div>
										<button class="btn btn-primary btn-user btn-block">Login</button>
										<a class="btn btn-danger btn-user btn-block" onfocusout="hitung()" data-target="#modal_list_user" data-toggle="modal" href="#list_user">List User</a>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal List User-->
	<div id="modal_list_user" class="modal fade" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" style="font-weight: bold; color: black;">List User Penjualan</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: red;">
						<span aria-hidden="true" style="color: white;">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class='table table-bordered' id='list_user' style="color: black;">
						<thead>
							<th>Username</th>
							<th>Program</th>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT USERNAME,
								KET
							FROM users
							WHERE PROG = 'PENJUALAN'
							ORDER BY KET";
							$a = $this->db->query($sql)->result();
							foreach ($a as $b) {
							?>
								<tr>
									<td class='USERNAME text_input' style="padding: 5;"><?php echo $b->USERNAME; ?></td>
									<td class='KET text_input' style="padding: 5;"><?php echo $b->KET; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#list_user').DataTable({
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

	<script type="text/javascript">
		jQuery.extend(jQuery.expr[':'], {
			focusable: function(el, index, selector) {
				return $(el).is(':input[type="text"], :input[type="password"], select, [tabindex], button');
			}
		});

		$(document).on('keydown', ':focusable', function(e) {
			if (e.which == 13) {
				e.preventDefault();
				// Get all focusable elements on the page
				var $canfocus = $(':focusable');
				var index = $canfocus.index(this) + 1;
				if (index >= $canfocus.length) index = 0;
				$canfocus.eq(index).focus();
				$(":focus").select();
			}
			if (e.which == 37) {
				e.preventDefault();
				// Get all focusable elements on the page
				var $canfocus = $(':focusable');
				var index = $canfocus.index(this) - 1;
				if (index >= $canfocus.length) index = 0;
				$canfocus.eq(index).focus();
				$(":focus").select();
			}
			if (e.which == 39) {
				e.preventDefault();
				// Get all focusable elements on the page
				var $canfocus = $(':focusable');
				var index = $canfocus.index(this) + 1;
				if (index >= $canfocus.length) index = 0;
				$canfocus.eq(index).focus();
				$(":focus").select();
			}
		});

		$(document).on('keydown', '.btn-user:focus', function(e) {
			if (e.which == 13) {
				e.preventDefault();
				$('.user').submit();
			}
		});
	</script>

	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
	<script src="js/sb-admin-2.min.js"></script>

</body>

</html>
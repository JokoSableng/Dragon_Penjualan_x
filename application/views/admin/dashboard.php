<style>
	.PENJUALAN {
		background-color: #1cc88a;
	}
</style>

<body>
	<br>
	<div class="container-fluid">
		<br>
		<div class="alert PENJUALAN shadow-sm" role="alert">
			<i class="fas fa-tachometer-alt"></i> Dashboard
		</div>
		<div class="alert PENJUALAN shadow-sm" role="alert">
			<h4 class="alert-heading">Selamat Datang</h4>
			<p>Selamat Datang <strong><?php echo $username; ?> </strong> di Sistem Informasi kami</p>
			<p> Anda login sebagai <strong><?php echo $level; ?> </strong> </p>
			<p>periode <?php echo $periode; ?> </p>

			<br>
			<hr>
			<div id="notif_so"></div>
		</div>
	</div>

	<body>

		<script>
			function notif_so() {
				$.ajax({
					type: 'get',
					url: '<?php echo base_url('index.php/admin/dashboard/notif_so'); ?>',
					dataType: 'json',
					success: function(response) {
						var html = `<div class="row text-center my-3">
										<div class="col-md-12">
											<span>
												<h2 style="text-shadow: 2px 2px 2px #00FF79;"><i class="fas fa-md fa-exclamation-circle"></i> SO Belum Ada NO DO <i class="fas fa-md fa-exclamation-circle"></i></h2>
											</span>
										</div>
									</div>
									<div class="row d-flex justify-content-between">`;
						var i;
						for (i = 0; i < response.length; i++) {
							html += `	<div class="col-xl-2 col-md-2">
											<div class="card mb-1" style="-webkit-box-shadow: 1px 10px 20px 2px rgba(0, 255, 120,0.5); box-shadow: 1px 10px 20px 2px rgba(0, 255, 120,0.5);">
												<div class="card-header" style="text-align: center; background-color: #1cc88a;">
													<i class="fas fa-exclamation-circle" style="color: white;"></i>
												</div>
												<div class="card-body p-1" style="text-align: center;">
													<ul class="list-group">
														<li class="list-group-item py-1 font-weight-bold">` + response[i].NO_BUKTI + `</li>
													</ul>
												</div>
											</div>
										</div>
									`;
						}
						html += `</div>`;
						$('#notif_so').html(html);
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$('#notif_so').html('');
					}
				});
			};
			notif_so();
			setInterval(notif_so, 30 * 1000);
		</script>
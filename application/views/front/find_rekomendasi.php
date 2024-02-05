<script type="text/javascript">
	function det_smart(id) {
		$.ajax({
			type: "ajax",
			url: "<?= base_url('pil_smart/') ?>"+id,
			async: false,
			dataType: "json",
			success: function (data) {
				Swal.fire({
					title: data.namap+' '+data.bentuk,
					imageUrl: '<?= "assets/img/perusahaan/"?>'+data.foto,
					imageHeight: 150,
					html:
					'<hr>'+
					'<div class="text-left small">'+
					'<ul>'+
					'<li>Tipe Bus: '+data.tipe+'"</li>'+
					'<li>Tahun Rilis: '+data.tahun+'</li>'+
					'<li>Fasililtas Toilet: '+data.toilet+'</li>'+
					'<li>Fasilitas Smoking Area: '+data.smoking+'</li>'+
					'<li>Kursi: '+data.kapasitas+' Seat / '+data.tseat+'Seat</li>'+
					'<li>Kecepatan: '+data.cepat+' KMJ</li>'+
					'<li>Jenis Bus: '+data.jenis+'</li>'+
					'<li>Jumlah Bus: '+data.jbus+' Bus</li>'+
					'<li>Harga: Rp.'+konversi(data.harga)+'</li>'+
					'</ul>'+
					'</div>'
				})
			}
		});
	}
</script>
<?php $platform = $this->agent->platform(); ?>
<div class="card shadow animated fadeInDownBig border-bottom-primary shadow h-100 py-2 my-3" id="manual">
	<div class="card-header">
		<h6 class="font-weight-bold text-primary text-center">Cari Rekomendasi Perusahaan</h6>
	</div>
	<form method="POST" enctype="multipart/form-data" id="form_cari" action="pembobotan">
		<div class="card-body">
			<div class="alert alert-primary text-center" role="alert">** Pilih 2 Perusahaan Otobus Untuk Dibandingkan **</div>
			<div class="table-responsive <?php if ($platform == "Android" || $platform == "iOS"){echo "small";} ?>">
				<table class="table table-hover table-striped table-borderless table-sm" id="tab_pilih">
					<thead class="thead-light text-center">
						<tr>
							<th class="px-1">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" id="chk_boxes" class="custom-control-input">
									<label class="custom-control-label" for="chk_boxes"></label>
								</div>
							</th>
							<th>Perusahaan Otobus</th>
							<th>Toilet-Smoking</th>
							<th>Kursi</th>
						<?php if ($platform == "Android" || $platform == "iOS") { ?>
						<?php } else { ?>
							<th>Tipe</th>
						<?php } ?>
							<th>Kecepatan</th>
						<?php if ($platform == "Android" || $platform == "iOS") { ?>
						<?php } else { ?>
							<th>Jenis Bus</th>
							<th>Tahun Rilis</th>
						<?php } ?>
							<th>Jumlah Bus</th>
							<th>Harga</th>
							<th>...</th>
						</tr>
					</thead>
					<tbody id="show_pilih">
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer text-center">
			<button class="btn btn-primary btn-block" id="btn_cari">
				<i class="fas fa-rocket"></i>&nbsp;Menuju Pengisian Kuesioner
			</button>
		</div>
	</form>
</div>
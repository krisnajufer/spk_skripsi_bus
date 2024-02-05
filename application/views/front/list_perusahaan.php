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
					'<li>Toilet: '+data.toilet+'</li>'+
					'<li>Smoking: '+data.smoking+'</li>'+
					'<li>Kursi: '+data.kapasitas+' Seat / '+data.tseat+' Seat</li>'+
					'<li>Kecepatan: '+data.cepat+' KMJ</li>'+
					'<li>Jenis: '+data.jenis+'</li>'+
					'<li>Jumlah Bus: '+data.jbus+' Bus</li>'+
					'<li>Harga: Rp.'+konversi(data.harga)+' per hari</li>'+
					'</ul>'+
					'</div>'
				})
			}
		});
	}
</script>
<?php
$platform = $this->agent->platform();
if ($platform=="Android" || $platform=="iOS") {
	$cardsize = 'col-6';
	$imgsize = '';
	$size = 'small';
	$btn = 'btn-sm';
} else {
	$cardsize = 'col-md-2';
	$imgsize = '';
	$size = '';
	$btn = '';
}
?>
<div class="row justify-content-center mb-5">
	<div class="col-12">
		<div class="card shadow animated fadeInDownBig border-bottom-primary shadow h-100 py-2 my-3" id="manual">
			<div class="card-header">
				<h6 class="font-weight-bold text-primary text-center">List Perusahaan Otobus</h6>
			</div>
			<div class="card-body">
				<div class="<?= $size ?> row py-2" id="fltr">
					<div class="col">
						<form enctype="multipart/form-data" id="form_filter" method="POST">
							<div class="form-group row justify-content-center">
								<label for="filter" class="col-sm-2 col-form-label">Urutkan : </label>
								<div class="col-sm-3">
									<select name="filter" id="filter" class="custom-select form-control">
										<option value="" selected> --- </option>
										<option value="harga_rendah">Harga Terendah</option>
										<option value="harga_tinggi">Harga Tertinggi</option>
									</select>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row justify-content-center py-2" id="data_list"></div>
				<div class="float-right justify-content-center" id='pagination'></div>
			</div>
			<div class="card-footer text-center">
				<a href="<?= base_url('opsi') ?>" class="btn btn-primary btn-icon-split m-1">
					<span class="icon text-white"><i class="fas fa-search"></i></span>
					<span class="text">Cari Rekomendasi</span>
				</a>
			</div>
		</div>
	</div>
</div>
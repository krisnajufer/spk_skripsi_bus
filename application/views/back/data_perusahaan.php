<script type="text/javascript">
	function mdl_smart() {
		document.getElementById("mdlhead").classList.remove('bg-warning');
		document.getElementById("mdlhead").classList.add('bg-info');
		$('#headtitle').text('Tambah Data Perusahaan');
		$('#mdl_smart').modal('show');
		$('#form_smart')[0].reset();
		document.getElementById("image-preview").src = "";
		$('#image-preview').removeAttr('src');
	}	
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
					'<li>Fasilitas Toilet: '+data.toilet+'</li>'+
					'<li>Fasilitas Smoking: '+data.smoking+'</li>'+
					'<li>Kursi: '+data.kapasitas+' Seat / '+data.tseat+' Seat</li>'+
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
	function edt_smart(id) {
		$.ajax({
			type: "ajax",
			url: "<?= base_url('pil_smart/') ?>"+id,
			async: false,
			dataType: "json",
			success: function (data) {
				document.getElementById("mdlhead").classList.remove('bg-info');
				document.getElementById("mdlhead").classList.add('bg-warning');
				$('#headtitle').text('Edit Data Perusahaan');
				$('#mdl_smart').modal('show');
				$('[name="id"]').val(data.id);
				$('[name="bentuk"]').val(data.bentuk);
				$('[name="namap"]').val(data.namap);
				$('[name="tipe"]').val(data.tipe);
				$('[name="tahun"]').val(data.tahun);
				$('[name="toilet"]').val(data.toilet);
				$('[name="smoking"]').val(data.smoking);
				$('[name="kapasitas"]').val(data.kapasitas);
				$('[name="tseat"]').val(data.tseat);
				$('[name="cepat"]').val(data.cepat);
				$('[name="jenis"]').val(data.jenis);
				$('[name="jbus"]').val(data.jbus);
				$('[name="harga"]').val(data.harga);
				document.getElementById("image-preview").src = "<?= base_url('assets/img/perusahaan')."/" ?>"+data.foto;
			},
			error: function (data) {
				swal('Terdapat Kesalahan');
			}
		});
	}
	function del_smart(id) {
		$.ajax({
			type: "ajax",
			url: "<?= base_url('pil_smart/') ?>"+id,
			async: false,
			dataType: "json",
			success: function (data) {
				$('#mdl_smart_del').modal('show');
				$('[name="id"]').val(data.id);
				document.getElementById("preview_del").src = "<?= base_url('assets/img/perusahaan')."/" ?>"+data.foto;
				$('#perusahaan_name').text(data.namap+' '+data.bentuk);
			},
			error: function (data) {
				swal('Terdapat Kesalahan');
			}
		});
	}
</script>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h4 mb-0 text-gray-800">Data Perusahaan Otobus</h1>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card border-left-primary shadow mb-4">
			<div class="card-header py-3">
				<h6 class="text-center m-0 font-weight-bold text-primary">Data Perusahaan Otobus</h6>
			</div>
			<div class="card-body">
				<button type="button" class="btn btn-info btn-icon-split btn-sm mb-4" onclick="mdl_smart()" data-toggle="tooltip" data-placement="right" title="Tambah Data">
					<span class="icon text-white-50"><i class="fas fa-plus"></i></span>
					<span class="text">Tambah</span>
				</button>
				<button type="button" class="btn btn-primary btn-icon-split btn-sm mb-4 float-right" id="reload_tsmart" data-toggle="tooltip" data-placement="right" title="Reload Tabel">
					<span class="icon text-white-50"><i class="fas fa-sync"></i></span>
					<span class="text">Reload</span>
				</button>
				<script type="text/javascript"></script>
				<div class="table-responsive">
					<table class="table table-hover table-striped table-borderless table-sm w-100 d-block d-md-table" id="tab_smart">
						<thead class="thead-light">
							<tr>
								<th>No</th>
								<th>namap</th>
								<th>Bentuk</th>
								<th>Tipe</th>
								<th>Toilet</th>
								<th>Smoking</th>
								<th>Kursi</th>
								<th>Kecepatan</th>
								<th>Jenis Bus</th>
								<th>Tahun Rilis</th>
								<th>Jumlah Bus</th>
								<th>Harga</th>
								<th>Opsi</th>
							</tr>
						</thead>
						<tbody id="show_smart">
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
</div>
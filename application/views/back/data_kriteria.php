<script type="text/javascript">
	function edt_kriteria(id) {
		$.ajax({
			type: "post",
			url: "<?= base_url('edit_kriteria') ?>",
			data: {
				'id_kriteria' : id
			},
			async: false,
			dataType: "json",
			success: function (data) {
				document.getElementById("mdlhead").classList.remove('bg-info');
				document.getElementById("mdlhead").classList.add('bg-warning');
				$('#headtitle').text('Edit Data');
				$('#mdl_kriteria').modal('show');
				$('[name="kriteria"]').val(data.kriteria);
				$('[name="bobot"]').val(data.bobot);
				$('[name="id_kriteria"]').val(data.id_kriteria);
			},
			error: function (data) {
				swal('Terdapat Kesalahan');
			}
		});
	}

	function delete_kriteria(id)
	{
		$.ajax({
			type: "post",
			url: "<?= base_url('delete_kriteria') ?>",
			data: {
				'id_kriteria': id
			},
			dataType: "json",
			success: function(data){
				if(data)
				{
					swal('Berhasil Hapus Data')
					setTimeout(function() {
						location.reload();
					}, 1000)
				}
			},
			error: function (data){
				swal('Gagal Hapus Data!');
			}
		})
	}
</script>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h4 mb-0 text-gray-800">Data Kriteria</h1>
</div>

<div class="row justify-content-center">
	<div class="col-lg-6">
		<div class="card border-left-info shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between align-items-center">
				<h6 class="text-center m-0 font-weight-bold text-info">Data Kriteria</h6>
				<button class="btn btn-primary" onclick="$('#mdl_kriteria').modal('show')">Tambah Data</button>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-striped table-borderless" id="tab_kriteria">
						<thead class="thead-light">
							<tr>
								<th>No.</th>
								<th>Kriteria</th>
								<th>Bobot</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody id="show_kriteria">
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
</div>
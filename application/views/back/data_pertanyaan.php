<script type="text/javascript">
	function edt_pertanyaan(id) {
		$.ajax({
			type: "ajax",
			url: "<?= base_url('pil_tanya/') ?>"+id,
			async: false,
			dataType: "json",
			success: function (data) {
				document.getElementById("mdlhead").classList.remove('bg-info');
				document.getElementById("mdlhead").classList.add('bg-warning');
				$('#headtitle').text('Edit Data');
				$('#mdl_tanya').modal('show');
				$('[name="pertanyaan"]').val(data.pertanyaan);
				$('[name="id_pertanyaan"]').val(data.id_pertanyaan);
				$('#kriteria_select').val(data.id_kriteria)
			},
			error: function (data) {
				swal('Terdapat Kesalahan');
			}
		});
	}

	function delete_pertanyaan(id){
		$.ajax({
			type: "post",
			url: "<?= base_url('delete_pertanyaan') ?>",
			data: {
				'id_pertanyaan': id
			},
			async: false,
			dataType: "json",
			success: function (data) {
				if(data)
				{
					toast_sukses_simpan();
					setTimeout(()=>{
						location.reload()
					},1500)
				}
			},
			error: function (data) {
				swal('Terdapat Kesalahan');
			}
		});
	}
</script>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h4 mb-0 text-gray-800">Data Pertanyaan</h1>
</div>

<div class="row justify-content-center">
	<div class="col-lg-10">
		<div class="card border-left-warning shadow mb-4">
			<!-- <div class="card-header py-3">
				<h6 class="text-center m-0 font-weight-bold text-warning">Data Pertanyaan</h6>
				<button class="btn btn-primary" onclick="$('#mdl_kriteria').modal('show')">Tambah Data</button>
			</div> -->
			<div class="card-header py-3 d-flex justify-content-between align-items-center">
				<h6 class="text-center m-0 font-weight-bold text-warning">Data Pertanyaan</h6>
				<button class="btn btn-primary" onclick="$('#mdl_tanya').modal('show')">Tambah Data</button>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-borderless table-striped" id="tab_pertanyaan">
						<thead class="thead-light">
							<tr>
								<th>No.</th>
								<th>Kriteria</th>
								<th>Pertanyaan</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody id="show_pertanyaan">
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function detail_perhitungan(id) {
		console.log(id)
		$.ajax({
			type: "post",
			url: "<?= base_url('detail_perhitungan') ?>",
			data: {
				'id_detail' : id
			},
			async: false,
			dataType: "json",
			success: function (data) {
				var html = '';
				var i;
				$('#headtitle').text('Detail Data Perhitungan ID#'+id)
				$('#otobusName').text(data[0].bentuk+'.'+data[0].namap)
				$('#skorAkhir').text(data[0].skor_akhir)
				$('#mdl_detail_perhitungan').modal('show');
				for (i = 0; i < data.length; i++) {
					html+= '<tr>'+
					'<td>'+(i+1)+'</td>'+
					'<td>'+data[i].normalisasi+'</td>'+
					'<td>'+data[i].utilities+'</td>'+
					'</tr>';
				}
				$('#show_detail_perhitungan').html(html);
			},
			error: function (data) {
				// swal('Terdapat Kesalahan');
			}
		});
	}
</script>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h4 mb-0 text-gray-800">Data Perhitungan</h1>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card border-left-success shadow mb-4">
			<div class="card-header py-3">
				<h6 class="text-center m-0 font-weight-bold text-success">Data Perhitungan</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-striped table-borderless" id="tab_perhitungan">
						<thead class="thead-light">
							<tr>
								<th>No.</th>
								<th>Waktu Perhitungan</th>
								<th>Nama</th>
								<th>Hasil Perhitungan</th>
								<th>Dicari Oleh</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="show_perhitungan">
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
</div>
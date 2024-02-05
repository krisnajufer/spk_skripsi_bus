<div class="modal fade" id="mdl_smart" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl cascading-modal" role="document">
		<div class="modal-content">
			<div id="mdlhead" class="modal-header bg-info text-white">
				<h5 id="headtitle" class="modal-title text-center col-12">Data Perusahaan Otobus</h5>
			</div>
			<form method="POST" enctype="multipart/form-data" id="form_smart">
				<div class="modal-body">
					<div class="row justify-content-center">
						<div class="col-4">
							<input type="text" name="id" class="form-control" hidden>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label>Bentuk Perusahaan</label>
										<input type="text" name="bentuk" class="form-control" autofocus>
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Nama Perusahaan</label>
										<input type="text" name="namap" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label>Tipe Bus</label>
										<input type="number" min="3" step="0.5" name="tipe" class="form-control">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Tahun Rilis</label>
										<input type="number" min="2018" name="tahun" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label>Toilet</label>
										<input type="number" min="0" name="toilet" class="form-control">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Smoking Area</label>
										<input type="number" min="0" name="smoking" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label>Kapasitas</label>
										<input type="number" min="16" name="kapasitas" class="form-control">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Seat style</label>
										<input type="number" min="2" step="0.1" name="tseat" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
								<label>Kecepatan Bus</label>
								<input type="number" min="100" step="10" name="cepat" class="form-control">
							</div>
							<div class="form-group">
								<label>Jenis Bus</label>
								<input type="text" name="jenis" class="form-control">
							</div>
							<div class="form-group">
								<label>Jumlah Bus</label>
								<input type="number" min="1" name="jbus" class="form-control">
							</div>
							<div class="form-group">
								<label>Harga</label>
								<input type="number" min="2000000" step="100000" name="harga" class="form-control">
							</div>
						</div>
						<div class="col-3 text-center">
							<div class="form-group">
								<label>Foto Bus</label>
								<div class="custom-file">
									<input type="file" name="foto" class="form-control custom-file-input" accept="image/*" id="foto" onchange="previewImage();">
									<label class="custom-file-label" for="foto">Pilih Foto</label>
									<small>(.jpg atau .png | Max 2MB)</small>
								</div>
								<center>
									<p hidden id="det_image"></p>
									<img id="image-preview" style="height: 200px;width: auto;">
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer form-group justify-content-center">
					<button class="btn btn-sm btn-success" id="sim_smart" type="submit">
						<i class="fas fa-save"></i>&nbsp; Simpan
					</button>
					<button class="btn btn-sm btn-danger" type="button" data-dismiss="modal">
						<i class="fas fa-window-close"></i>&nbsp; Batal
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
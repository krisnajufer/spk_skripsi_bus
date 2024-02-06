<div class="modal fade" id="mdl_kriteria" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hidden="true">
	<div class="modal-dialog cascading-modal" role="document">
		<div class="modal-content">
			<div id="mdlhead" class="modal-header bg-info text-white">
				<h5 id="headtitle" class="modal-title text-center col-12"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" id="form_kriteria">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="kriteria">Kriteria: </label>
								<textarea class="form-control" id="kriteria" rows="3" name="kriteria"></textarea>
								
							</div>
							<div class="form-group">
								<label for="kriteria">Bobot: </label>
								<input class="form-control" id="bobot" type="number" name="bobot"></input>
							</div>
							
							<input type="text" name="id_kriteria" id="id_kriteria" hidden>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer form-group justify-content-center">
				<button class="btn btn-sm btn-success" id="simp_kriteria" type="submit">
					<i class="fas fa-save"></i>&nbsp; Simpan
				</button>
				<button class="btn btn-sm btn-danger" type="button" data-dismiss="modal">
					<i class="fas fa-window-close"></i>&nbsp; Batal
				</button>
			</div>
		</div>
	</div>
</div>
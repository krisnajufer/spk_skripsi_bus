<div class="modal fade" id="mdl_detail_perhitungan" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl cascading-modal" role="document">
		<div class="modal-content">
			<div id="mdlhead" class="modal-header bg-danger text-white">
				<h5 id="headtitle" class="modal-title text-center col-12">Detail Data Perhitungan</h5>
			</div>
			<div class="modal-body">
                <div>
                    <div class="d-flex justify-content-between">
                        <div>
                            Nama Otobus:
                            <h1 id="otobusName"></h1>
                        </div>
                        <div>
                            Skor Akhir:
                            <h1 id="skorAkhir"></h1>
                        </div>
                    </div>
                    <table class="table table-hover table-striped table-borderless" id="tab_detail_perhitungan">
						<thead class="thead-light">
							<tr>
								<th>No.</th>
								<th>Normalisasi</th>
								<th>Utilitas</th>
							</tr>
						</thead>
						<tbody id="show_detail_perhitungan">
						</tbody>
					</table>
                </div>
			</div>
			<div class="modal-footer form-group justify-content-center">
				<button class="btn btn-sm btn-danger" type="button" data-dismiss="modal">
					<i class="fas fa-window-close"></i>&nbsp; Tutup
				</button>
			</div>
		</div>
	</div>
</div>
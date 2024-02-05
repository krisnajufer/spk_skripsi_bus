<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h4 mb-0 text-gray-800">Dashboard</h1>
</div>

<div class="row">
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Perusahaan</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_perusahaan ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-mobile fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Kriteria</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_kriteria ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-sign fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Perhitungan</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_perhitungan ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-calculator fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Paling Banyak Dicari</div>
						<div class="h6 mb-0 font-weight-bold text-gray-800">
						<?php if ($most_freq == false) {
							echo "Tidak Ada Data";
						} else {
							echo $most_freq->namap.' '.$most_freq->bentuk.' ('.$most_freq->id_perusahaan.'x Dicari)';
						}
						?>						
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-mobile-alt fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<?php if($flash): ?>
<div class="flash-data" data-type="<?= $flash['type']; ?>" data-title="<?= $flash['title']; ?>"></div>
<?php endif; ?>
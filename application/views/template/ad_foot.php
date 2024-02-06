				</div>
			</div>
		</div>
	</div>
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>
	<script src="<?= base_url() ?>assets/js/jquery-3.3.1.js"></script>
	<script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
	<script src="<?= base_url() ?>assets/js/sb-admin-2.js"></script>
	<script src="<?= base_url() ?>assets/js/notif.js"></script>
	<script src="<?= base_url() ?>assets/vendor/summernote/summernote-bs4.js"></script>
	<script src="<?= base_url() ?>assets/vendor/sweetalert/dist/sweetalert2.js"></script>
	<script src="<?= base_url() ?>assets/vendor/datatables/jquery.dataTables.js"></script>
	<script src="<?= base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>
	<script src="<?= base_url() ?>assets/vendor/chart.js/Chart.js"></script>
	<?php $p = $this->uri->segment(1); ?>
	<script type="text/javascript">
		function logout() {
			Swal.fire({
				confirmButtonClass: 'btn btn-success m-2',
				cancelButtonClass: 'btn btn-danger m-2',
				buttonsStyling: false,
				showCancelButton: true,
				title: 'Yakin ingin keluar ?',
				type: 'warning',
				confirmButtonText: '<i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Ya !',
				cancelButtonText: '<i class="fas fa-times"></i>&nbsp;&nbsp;Batal'
			}).then((result) => {
				if (result.value) {
					window.location.replace('<?= base_url('logout') ?>');
				}
			})
		}
		<?php if ($p == 'admin') { ?>
		<?php if($flash): ?>
			const flashType = $('.flash-data').data('type');
			const flashTitle = $('.flash-data').data('title');
			if (flashType || flashTitle) {
				const Notif = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 4000
				});
				Notif.fire({
					type: flashType,
					title:flashTitle
				});
			}
		<?php endif; ?>
			tampil_chart();
			setInterval(function(){tampil_chart()},30000);
			function tampil_chart() {
				var ctx;
				ctx = $('#myChart');
				$.ajax({
					type: "GET",
					url: "<?= base_url('chart_data') ?>",
					async: false,
					dataType: "json",
					success: function (response) {
						var i,tgl=[],jml=[];
						for (i=0;i<response.length;i++){
							tgl.push(response[i].tanggal);
							jml.push(response[i].jumlah);
						}
						var myChart = new Chart(ctx, {
							type: 'line',
							data: {
								labels: tgl,
								datasets: [{
									label: 'Jumlah Pencarian Dalam Perhari',
									data: jml,
									lineTension: 0.3,
									backgroundColor: "rgba(78, 115, 223, 0.05)",
									borderColor: "rgba(78, 115, 223, 1)",
									pointRadius: 3,
									pointBackgroundColor: "rgba(78, 115, 223, 1)",
									pointBorderColor: "rgba(78, 115, 223, 1)",
									pointHoverRadius: 3,
									pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
									pointHoverBorderColor: "rgba(78, 115, 223, 1)",
									pointHitRadius: 10,
									pointBorderWidth: 2
								}]
							},
							options: {
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: true
										}
									}]
								}
							}
						});
					}
				});
			}
		<?php } ?>

		<?php if ($p == 'perusahaan') { ?>
		function previewImage() {
			document.getElementById("image-preview").style.tipe = "block";
			var oFReader = new FileReader();
			oFReader.readAsDataURL(document.getElementById("foto").files[0]);

			oFReader.onload = function(oFREvent) {
				document.getElementById("image-preview").src = oFREvent.target.result;
			};
		};

		function konversi(angka) {
			var reverse = angka.toString().split('').reverse().join(''),
			ribuan = reverse.match(/\d{1,3}/g);
			ribuan = ribuan.join('.').split('').reverse().join('');
			return ribuan
		}
		<?php } ?>
		
		$(document).ready(function() {
			<?php if ($p == 'perusahaan') { ?>
			var tab_smart;
			tab_smart = $('#tab_smart').DataTable({
				"processing": true,
				"serverSide": true,
				"order": [],
				"ajax": {
					"url": "<?= base_url('ajax_list')?>",
					"type": "POST"
				},
				"columnDefs": [{ 
					"targets": [ 0,-1 ],
					"orderable": false
				}],
				initComplete:function () {
					$('#tab_smart thead tr th').addClass("align-middle text-center");
					$('#show_smart tr td').addClass("align-middle");
				}
			});
			function reload_tab_smart()
			{
				// tab_smart.ajax.reload(null,false);
				tab_smart.ajax.reload(function () {
					$('#show_smart tr td').addClass("align-middle");
				})
			}
			$('#form_smart').submit(function (e) {
				e.preventDefault();
				var form = document.getElementById('form_smart');
				var namap = $('[name="namap"]').val();
				var bentuk = $('[name="bentuk"]').val();
				var tipe = $('[name="tipe"]').val();
				var tahun = $('[name="tahun"]').val();
				var kapasitas = $('[name="kapasitas"]').val();
				var tseat = $('[name="tseat"]').val();
				var toilet = $('[name="toilet"]').val();
				var smoking = $('[name="smoking"]').val();
				var cepat = $('[name="cepat"]').val();
				var jenis = $('[name="jenis"]').val();
				var jbus = $('[name="jbus"]').val();
				var harga = $('[name="harga"]').val();
				if (namap==''||bentuk==''||tipe==''||tahun==''||tseat==''||kapasitas==''||toilet==''||smoking==''||cepat==''||jenis==''||jbus==''||harga=='') {
					swal('Lengkapi Data Terlebih Dahulu');
				} else {
					$.ajax({
						url: "<?= base_url('simpan_perusahaan') ?>",
						type: "POST",
						data: new FormData(form),
						processData: false,
						contentType: false,
						cache: false,
						async: false,
						success: function(data){
							$('#mdl_smart').modal('hide');
							toast_sukses_simpan();
							reload_tab_smart();
						},
						error: function(data){
							toast_gagal_simpan();
						}
					});
				}
			})
			$('#del_smart').click(function () {
				$.ajax({
					type: "POST",
					url: "<?= base_url('del_perusahaan') ?>",
					data: $('#form_del_smart').serialize(),
					success: function (data){
						$('#mdl_smart_del').modal('hide');
						toast_sukses_hapus();
						reload_tab_smart();
					},
					error: function(data){
						toast_gagal_hapus();
					}
				});
			})
			$('#reload_tsmart').click(function () {
				reload_tab_smart();
			})
			const backcam = document.getElementById('backcam');
			const frontcam = document.getElementById('frontcam');
			backcam.addEventListener('input', function() {
				let start = this.selectionStart;
				let end = this.selectionEnd;

				const current = this.value
				const corrected = current.replace(/([^+0-9]+)/gi, '');
				this.value = corrected;

				if (corrected.length < current.length) --end;
				this.setSelectionRange(start, end);
			});
			frontcam.addEventListener('input', function() {
				let start = this.selectionStart;
				let end = this.selectionEnd;

				const current = this.value
				const corrected = current.replace(/([^+0-9]+)/gi, '');
				this.value = corrected;

				if (corrected.length < current.length) --end;
				this.setSelectionRange(start, end);
			});
			// tampil_perusahaan();
			function tampil_perusahaan() {
				pop_det = 'data-toggle="tooltip" title="Detail Data"';
				pop_edt = 'data-toggle="tooltip" title="Edit Data"';
				pop_del = 'data-toggle="tooltip" title="Delete Data"';
				$.ajax({
					type: "ajax",
					url: "<?= base_url('list_perusahaan') ?>",
					async: false,
					dataType: "json",
					success: function (data) {
						var html = '';
						var i;
						for (i = 0; i < data.length; i++) {
							html+= '<tr>'+
							'<td>'+(i+1)+'</td>'+
							'<td>'+data[i].namap+'</td>'+
							'<td>'+data[i].bentuk+'</td>'+
							'<td>'+data[i].tipe+'"</td>'+
							'<td>'+data[i].toilet+' GB</td>'+
							'<td>'+data[i].smoking+' GB</td>'+
							'<td>'+data[i].kapasitas+' MP / '+data[i].tseat+' MP</td>'+
							'<td>'+data[i].cepat+' GHz</td>'+
							'<td>'+data[i].jenis+'</td>'+
							'<td>'+data[i].tahun+'</td>'+
							'<td>'+data[i].jbus+' mAh</td>'+
							'<td>Rp.'+konversi(data[i].harga)+'</td>'+
							'<td class="text-center">'+
							'<button class="btn btn-sm btn-primary m-1" onclick="det_smart('+
							data[i].id+
							');" '+pop_det+'><i class="fas fa-info-circle"></i></button>'+
							'<button class="btn btn-sm btn-warning m-1" onclick="edt_smart('+
							data[i].id+
							');" '+pop_edt+'><i class="fas fa-pen-square"></i></button>'+
							'<button class="btn btn-sm btn-danger m-1" onclick="del_smart('+
							data[i].id+
							');" '+pop_del+'><i class="fas fa-trash"></i></button>'+
							'</td>'+
							'</tr>';
						}
						$('#show_smart').html(html);
					}
				});
			}
			<?php } ?>

			<?php if ($p == 'kriteria') { ?>
			tampil_kriteria();
			function tampil_kriteria() {
				pop_edt = 'data-toggle="tooltip" title="Edit Data"';
				pop_delete = 'data-toggle="tooltip" title="Delete Data"';
				$.ajax({
					type: "ajax",
					url: "<?= base_url('list_kriteria') ?>",
					async: false,
					dataType: "json",
					success: function (data) {
						var html = '';
						var i;
						for (i = 0; i < data.length; i++) {
							html+= '<tr>'+
							'<td>'+(i+1)+'</td>'+
							'<td>'+data[i].kriteria+'</td>'+
							'<td>'+data[i].bobot+'</td>'+
							'<td class="text-center">'+
							'<button class="btn btn-sm btn-warning m-1" onclick="edt_kriteria('+
							data[i].id_kriteria+
							');" '+pop_edt+'><i class="fas fa-pen-square"></i></button>'+
							'<button class="btn btn-sm btn-danger m-1" onclick="delete_kriteria('+
							data[i].id_kriteria+
							');" '+pop_delete+'><i class="fas fa-trash"></i></button>'+
							'</td>'+
							'</tr>';
						}
						$('#show_kriteria').html(html);
					}
				});
			}
			
			$('#simp_kriteria').click(function(e) {
				let inputKriteria = $('#kriteria').val()
				let inputBobot = $('#bobot').val()
				let id_kriteria = $('[name="id_kriteria"]').val();
				
				if(inputKriteria == '')
				{
					swal('Data Kriteria Tidak Boleh Kosong!')
				}else
				{
					$.ajax({
						type: "post",
						url: "<?= base_url('simpan_kriteria') ?>",
						data: {
							'id_kriteria': id_kriteria,
							'kriteria' : inputKriteria,
							'bobot' : inputBobot
						},
						success: function(data)
						{
							if(data == 1)
							{
								console.log(12)
								swal('Berhasil Menyimpan Data')
								setTimeout(function() {
									location.reload();
								}, 1000)
							}
						},
						error: function(error){
							swal('Terjadi Kesalahan Error!');
							console.log(error)
						}
					})
				}

			})

			<?php } ?>

			<?php if ($p == 'pertanyaan') { ?>
			tampil_pertanyaan();
			function tampil_pertanyaan() {
				pop_edt = 'data-toggle="tooltip" title="Edit Data"';
				$.ajax({
					type: "ajax",
					url: "<?= base_url('list_pertanyaan') ?>",
					async: false,
					dataType: "json",
					success: function (data) {
						var html = '';
						var i;
						for (i = 0; i < data.length; i++) {
							html+= '<tr>'+
							'<td>'+(i+1)+'</td>'+
							'<td>'+data[i].kriteria+'</td>'+
							'<td>'+data[i].pertanyaan+'</td>'+
							'<td class="text-center">'+
							'<button class="btn btn-sm btn-warning m-1" onclick="edt_pertanyaan('+
							data[i].id_pertanyaan+
							');" '+pop_edt+'><i class="fas fa-pen-square"></i></button>'+
							'</td>'+
							'</tr>';
						}
						$('#show_pertanyaan').html(html);
					}
				});
			}
			$('#simp_tanya').click(function () {
				$.ajax({
					type: "POST",
					url: "<?= base_url('simpan_pertanyaan') ?>",
					data: $('#form_tanya').serialize(),
					success: function (data){
						$('#mdl_tanya').modal('hide');
						toast_sukses_simpan();tampil_pertanyaan();
					},
					error: function(data){
						toast_gagal_simpan();
					}
				});
			})
			<?php } ?>

			<?php if ($p == 'pengaturan') { ?>
			<?php $r = $detail_con->row(); ?>
			$('#note_help').summernote({
				placeholder: 'Isi..',
				toolbar: [
				 ['style', ['bold', 'italic', 'underline']],
				 ['para', ['ul', 'ol', 'paragraph']],
				 ['height', ['height']]
				],
				height: 225
			});
			$('#note_help').summernote('code','<?= $r->halaman_bantuan ?>');
			$('#simp_setting').click(function () {
				var nama_instansi = $('[name="nama_instansi"]').val();
				var alamat_instansi = $('[name="alamat_instansi"]').val();
				var deskripsi = $('[name="deskripsi"]').val();
				var nama_aplikasi = $('[name="nama_aplikasi"]').val();
				if (nama_instansi==''||nama_aplikasi==''||alamat_instansi==''||deskripsi=='') {
					swal('Lengkapi Data Terlebih Dahulu');
				} else {
					$.ajax({
						type: "POST",
						url: "<?= base_url('simpan_config') ?>",
						data: $('#form_setting').serialize(),
						success: function (data){
							toast_sukses_simpan();
						},
						error: function(data){
							toast_gagal_simpan();
						}
					});
				}
			});
			$('#simp_help').click(function () {
				$.ajax({
					type: "POST",
					url: "<?= base_url('simpan_bantuan') ?>",
					data: $('#form_help').serialize(),
					success: function (data){
						sukses_simpan_bantuan();
					},
					error: function (data) {
						swal(data);
					}
				});
			});
			$('#reset_help').click(function () {
				Swal.fire({
					title: 'Apakah anda yakin ingin mereset data ini?',
					text: 'Data yang telah diubah tidak dapat dikembalikan',
					type: 'warning',
					showCancelButton : true,
					confirmButtonText: '<i class="fas fa-eraser"></i>&nbsp;&nbsp;Ya, Reset Data !',
					cancelButtonText: '<i class="fas fa-times"></i>&nbsp;&nbsp;Batal'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: "POST",
							url: "<?= base_url('reset_bantuan') ?>",
							success: function (){
								sukses_reset();
								// setTimeout(' window.location = "<?= base_url('pengumuman') ?>"; ',1100);
							},
							error: function (data) {
								gagal_reset();
							}
						});
					}
				})
			});
			<?php } ?>

			<?php if ($p == 'addadmin') { ?>
			var username_user = $('[name="username_user"]');
			username_user.on('keyup',function () {
				$.ajax({
					type: "POST",
					url: "<?= base_url('cekusername_user') ?>",
					data: $('#form_adduser').serialize(),
					success: function (data) {
						if (data) {
							swal("Username Telah Digunakan");
							username_user.addClass("is-invalid");
							username_user.removeClass("is-valid");
						} else {
							username_user.addClass("is-valid");
							username_user.removeClass("is-invalid");
						}
					}
				});
			});
			var username = $('[name="username"]');
			username.on('keyup',function () {
				$.ajax({
					type: "POST",
					url: "<?= base_url('cekusername_admin') ?>",
					data: $('#form_addmin').serialize(),
					success: function (data) {
						if (data) {
							swal("Username Telah Digunakan");
							username.addClass("is-invalid");
							username.removeClass("is-valid");
						} else {
							username.addClass("is-valid");
							username.removeClass("is-invalid");
						}
					}
				});
			});
			showuseradmin();
			$('#reload_tabel').click(function () {
				showuseradmin();
			})
			function showuseradmin() {
				tampil_admin();
				$('#tab_user').DataTable().destroy();
				tampil_user();
				$('#tab_user').DataTable();
			}
			function tampil_admin() {
				var user="<?= $this->session->userdata('admin')['username']; ?>";
				var akses="<?= $this->session->userdata('admin')['hak_akses']; ?>";
				pop_edt = 'data-toggle="tooltip" data-placement="top" title="Edit Data"';
				pop_del = 'data-toggle="tooltip" data-placement="top" title="Delete Data"';
				$.ajax({
					type: "ajax",
					url: "<?= base_url('list_admin') ?>",
					async: false,
					dataType: "json",
					success: function (data) {
						var html = '';
						var i;
						if (akses == 'sadmin') {
							for (i = 0; i < data.length; i++) {
								if (data[i].username == user) {
									html+= '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].nama+'</td>'+
									'<td>'+data[i].username+'</td>'+
									// '<td>'+data[i].password.replace(/./g, '*')+'</td>'+
									'<td>'+data[i].last_login+'</td>'+
									'<td class="text-center">'+
									'<button class="btn btn-sm btn-warning m-1" onclick="edt_admin('+
									data[i].id_admin+
									');" '+pop_edt+'><i class="fas fa-pen-square"></i></button>'+
									'</td>'+
									'</tr>';
								} else {
									html+= '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].nama+'</td>'+
									'<td>'+data[i].username+'</td>'+
									// '<td>'+data[i].password.replace(/./g, '*')+'</td>'+
									'<td>'+data[i].last_login+'</td>'+
									'<td class="text-center">'+
									'<button class="btn btn-sm btn-warning m-1" onclick="edt_admin('+
									data[i].id_admin+
									');" '+pop_edt+'><i class="fas fa-pen-square"></i></button>'+
									'<button class="btn btn-sm btn-danger m-1 del_addmin" onclick="del_admin('+
									data[i].id_admin+
									');" '+pop_del+'><i class="fas fa-trash"></i></button>'+
									'</td>'+
									'</tr>';
								}
							}
						} else {
							for (i = 0; i < data.length; i++) {
								if (data[i].hak_akses == 'sadmin') {
								} else if (data[i].username == user) {
									html+= '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].nama+'</td>'+
									'<td>'+data[i].username+'</td>'+
									// '<td>'+data[i].password.replace(/./g, '*')+'</td>'+
									'<td>'+data[i].last_login+'</td>'+
									'<td class="text-center">'+
									'<button class="btn btn-sm btn-warning m-1" onclick="edt_admin('+
									data[i].id_admin+
									');" '+pop_edt+'><i class="fas fa-pen-square"></i></button>'+
									'</td>'+
									'</tr>';
								} else {
									html+= '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].nama+'</td>'+
									'<td>'+data[i].username+'</td>'+
									// '<td>'+data[i].password.replace(/./g, '*')+'</td>'+
									'<td>'+data[i].last_login+'</td>'+
									'<td class="text-center">'+
									'</td>'+
									'</tr>';
								}
							}
						}
						$('#show_admin').html(html);
					}
				});
			}
			$('#simp_addmin').click(function () {
				var username = $('[name="username"]').val();
				var password = $('[name="password"]').val();
				var nama = $('[name="nama"]').val();
				if (username==''||password==''||nama=='') {
					swal('Lengkapi Data Terlebih Dahulu');
				} else {
					$.ajax({
						type: "POST",
						url: "<?= base_url('simpan_admin') ?>",
						data: $('#form_addmin').serialize(),
						success: function (data){
							showuseradmin();
							$('#mdl_addadmin').modal('hide');
							toast_sukses_simpan();
						},
						error: function(data){
							toast_gagal_simpan();
						}
					});
				}
			});
			$('.del_addmin').click(function () {
				setTimeout(function() { tampil_admin(); }, 5000);
				$('#reload_tabel').trigger('click');
			});
			function tampil_user() {
				pop_edt = 'data-toggle="tooltip" data-placement="top" title="Edit Data"';
				pop_del = 'data-toggle="tooltip" data-placement="top" title="Delete Data"';
				$.ajax({
					type: "ajax",
					url: "<?= base_url('list_user') ?>",
					async: false,
					dataType: "json",
					success: function (data) {
						var html = '';
						var i;
						for (i = 0; i < data.length; i++){
							html+= '<tr>'+
							'<td>'+(i+1)+'</td>'+
							'<td>'+data[i].nama+'</td>'+
							'<td>'+data[i].username+'</td>'+
							// '<td>'+data[i].password.replace(/./g, '*')+'</td>'+
							'<td>'+data[i].last_login+'</td>'+
							'<td class="text-center">'+
							'<button class="btn btn-sm btn-primary m-1" onclick="edt_user('+
							data[i].id_user+
							');" '+pop_edt+'><i class="fas fa-pen-square"></i></button>'+
							'<button class="btn btn-sm btn-danger m-1" onclick="del_user('+
							data[i].id_user+
							');" '+pop_del+'><i class="fas fa-trash"></i></button>'+
							'</td>'+
							'</tr>';
						}
						$('#show_user').html(html);
					}
				})
			}
			var tab_user;
			tab_user = $('#tab_user').DataTable();
			$('#simp_adduser').click(function () {
				var username = $('[name="username_user"]').val();
				var password = $('[name="password_user"]').val();
				var nama = $('[name="nama_user"]').val();
				if (username==''||password==''||nama=='') {
					swal('Lengkapi Data Terlebih Dahulu');
				} else {
					$.ajax({
						type: "POST",
						url: "<?= base_url('simpan_user') ?>",
						data: $('#form_adduser').serialize(),
						success: function (data){
							$('#mdl_adduser').modal('hide');
							showuseradmin();
							toast_sukses_simpan();
						},
						error: function(data){
							toast_gagal_simpan();
						}
					});
				}
			});
			<?php } ?>

			<?php if ($p == 'perhitungan') { ?>
			var tab_perhitungan;
			tab_perhitungan = $('#tab_perhitungan').DataTable({
				"processing": true,
				"serverSide": true,
				"order": [],
				"ajax": {
					"url": "<?= base_url('list_perhitungan')?>",
					"type": "POST"
				},
				"columnDefs": [{ 
					"targets": [ 0 ],
					"orderable": false
				}],
				initComplete:function () {
					$('#perhitungan thead tr th').addClass("align-middle text-center");
					$('#show_perhitungan tr td').addClass("align-middle");
				}
			});
			function tampil_perhitungan() {
				$.ajax({
					type: "ajax",
					url: "<?= base_url('list_perhitungan') ?>",
					async: false,
					dataType: "json",
					success: function (data) {
						var html = '';
						var i;
						console.log(data)
						for (i = 0; i < data.length; i++) {
							html+= '<tr>'+
							'<td>'+(i+1)+'</td>'+
							'<td>'+data[i].tanggal+'</td>'+
							'<td>'+data[i].namap+' '+data[i].bentuk+'</td>'+
							'<td>'+data[i].skor_akhir+'</td>'+
							'<td>'+data[i].nama+'</td>'+
							'<td class="text-center">'+
							'<button class="btn btn-sm btn-warning m-1" onclick="detail_perhitungan('+
							data[i].id_detail+
							');"><i class="fas fa-pen-square"></i></button>'+
							'</td>'+
							'</tr>';
						}
						$('#show_perhitungan').html(html);
					}
				});
			}
			<?php } ?>

			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
</body>
</html>
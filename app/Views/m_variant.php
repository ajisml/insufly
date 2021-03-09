<?= $this->extend('_partials/template') ?>

<?= $this->section('head') ?>

<?= $this->endSection() ?>

<?= $this->section('s-body') ?>
	<div class="section-body">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h4>Variasi</h4>
						<button type="button" class="btn btn-primary btn-sm btn-variant"><i class="fas fa-plus"></i></button>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Nama</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody id="tbvariant">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h4>Subvariasi</h4>
						<button type="button" class="btn btn-primary btn-sm btn-subvariant"><i class="fas fa-plus"></i></button>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Nama</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody id="tbsubvariant">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
	$(document).ready(function(){
		tb_subvar();
		tb_var();
		function tb_var(){
			$.ajax({
					url	 	: "<?= base_url('api/getVariant/variant') ?>",
					type  	: "GET",
					dataType: "JSON",
					async   : false,
					success : (res)=>{
						var html;
						for(var i=0;i<res.length;i++){
							html +=
							`
							<tr>
								<td>${res[i].name}</td>
								<td>
								<button type="button" data-name="${res[i].name}" data-id="${res[i].id}" class="btn btn-primary btn-edit btn-sm"><i class="fas fa-edit"></i></button>
								<button type="button" data-id="${res[i].id}" class="btn btn-danger btn-delete btn-sm"><i class="fas fa-eraser"></i></button>
								</td>
							</tr>
							`;
						}
						$("#tbvariant").html(html);
					}  
				});
		}
		function tb_subvar() {
			$.ajax({
				url	 	: "<?= base_url('api/getVariant/subvariant') ?>",
				type  	: "GET",
				dataType: "JSON",
				async   : false,
				success : (res)=>{
					var html;
					for(var i=0;i<res.length;i++){
						html +=
						`
						<tr>
							<td>${res[i].name}</td>
							<td>
								<button type="button" data-id="${res[i].id}" data-name="${res[i].name}" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-edit"></i></button>
								<button type="button" data-id="${res[i].id}" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-eraser"></i></button>
							</td>
						</tr>
						`;
					}
					$("#tbsubvariant").html(html);
				}  
			});
		}
		$("#tbvariant").on('click','.btn-delete', function() {
			var id 		=	$(this).data('id');
			Swal.fire({
				title : 'Yaqueen Mau Dihapus ?',
				text  : 'Menurut Saya Sih Jan Dihapus Tapi Diedit Ja ~ Hehe',
				icon  : 'warning',
				showCancelButton : true,
			}).then((value)=>{
				if(value.isConfirmed){
					$.ajax({
						url 	: "<?= base_url('api/deleteVariant') ?>",
						type 	: "POST",
						dataType: "JSON",
						data 	: {id:id},
						success : (res)=>{
							if(res.success === true){
								tb_var();
								Swal.fire(
									'Data Berhasil Dihapus',
									res.data,
									'success'
								);
							}
						}  
					});
				}
			});
		});
		$("#tbvariant").on('click','.btn-edit', function() {
			var name 	=	$(this).data('name');
			var id 		=	$(this).data('id');
			Swal.fire({
			  title: 'Ubah Variasi '+name,
			  input: 'text',
			  inputAttributes: {
			    autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Simpan',
			  showLoaderOnConfirm: true,
			  preConfirm: (name) => {
			   $.ajax({
			   	url 	: "<?= base_url('api/editVariant') ?>",
			   	type 	: "POST",
			   	dataType: "JSON",
			   	data 	: {name:name,id:id},
			   	success : (ok)=>{

			   	}
			   });
			  },
			  allowOutsideClick: () => !Swal.isLoading()
			}).then((result) => {
			  if (result.isConfirmed) {
			  	tb_var();
			    Swal.fire(
			    	'Sukses Diubah',
			    	'Data Berhasil Diubah',
			    	'success',
			    );
			  }
			})
		});
		$(".btn-variant").click(function(){
			Swal.fire({
			  title: 'Masukan Nama Variasi',
			  input: 'text',
			  inputAttributes: {
			    autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Simpan',
			  showLoaderOnConfirm: true,
			  preConfirm: (name) => {
			   $.ajax({
			   	url 	: "<?= base_url('api/addVariant') ?>",
			   	type 	: "POST",
			   	dataType: "JSON",
			   	data 	: {name:name},
			   	success : (ok)=>{

			   	}
			   });
			  },
			  allowOutsideClick: () => !Swal.isLoading()
			}).then((result) => {
			  if (result.isConfirmed) {
			  	tb_var();
			    Swal.fire(
			    	'Sukses Disimpan',
			    	'Data Berhasil Disimpan',
			    	'success',
			    );
			  }
			})
		});
		$(".btn-subvariant").click(function(){
			Swal.fire({
			  title: 'Masukan Nama Subvariasi',
			  input: 'text',
			  inputAttributes: {
			    autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Simpan',
			  showLoaderOnConfirm: true,
			  preConfirm: (name) => {
			   $.ajax({
			   	url 	: "<?= base_url('api/addsubvar') ?>",
			   	type 	: "POST",
			   	dataType: "JSON",
			   	data 	: {name:name},
			   	success : (ok)=>{

			   	}
			   });
			  },
			  allowOutsideClick: () => !Swal.isLoading()
			}).then((result) => {
			  if (result.isConfirmed) {
			  	tb_subvar();
			    Swal.fire(
			    	'Sukses Disimpan',
			    	'Data Berhasil Disimpan',
			    	'success',
			    );
			  }
			})
		});
		$("#tbsubvariant").on('click','.btn-edit', function() {
			var name 	=	$(this).data('name');
			var id 		=	$(this).data('id');
			Swal.fire({
			  title: 'Ubah Subvariasi '+name,
			  input: 'text',
			  inputAttributes: {
			    autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Simpan',
			  showLoaderOnConfirm: true,
			  preConfirm: (name) => {
			   $.ajax({
			   	url 	: "<?= base_url('api/editSubVariant') ?>",
			   	type 	: "POST",
			   	dataType: "JSON",
			   	data 	: {name:name,id:id},
			   	success : (ok)=>{

			   	}
			   });
			  },
			  allowOutsideClick: () => !Swal.isLoading()
			}).then((result) => {
			  if (result.isConfirmed) {
			  	tb_subvar();
			    Swal.fire(
			    	'Sukses Diubah',
			    	'Data Berhasil Diubah',
			    	'success',
			    );
			  }
			})
		});
		$("#tbsubvariant").on('click','.btn-delete', function() {
			var id 		=	$(this).data('id');
			Swal.fire({
				title : 'Yaqueen Sub Variasi Mau Dihapus ?',
				text  : 'Menurut Saya Sih Jan Dihapus Tapi Diedit Ja ~ Hehe',
				icon  : 'warning',
				showCancelButton : true,
			}).then((value)=>{
				if(value.isConfirmed){
					$.ajax({
						url 	: "<?= base_url('api/deleteSubVariant') ?>",
						type 	: "POST",
						dataType: "JSON",
						data 	: {id:id},
						success : (res)=>{
							if(res.success === true){
								tb_subvar();
								Swal.fire(
									'Data Berhasil Dihapus',
									res.data,
									'success'
								);
							}
						}  
					});
				}
			});
		});
	});
</script>
<?= $this->endSection() ?>
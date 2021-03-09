<?= $this->extend('_partials/template') ?>


<?= $this->section('s-body') ?>
	<div class="section-body">
		<div class="card">
			<div class="card-header">
				<h4>Kelola Kategori</h4>
				<button type="button" class="btn btn-primary btn-sm btn-add"><i class="fas fa-plus"></i></button>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Nama Kategory</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="tbcat">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
	$(document).ready(function(){
		tb_cat();
		function tb_cat() {
			$.ajax({
				url  	: 	"<?= base_url('api/getCat') ?>",
				type 	: 	"GET",
				dataType: 	"JSON",
				async 	: 	false,
				success  : 	(res)=>{
					var html="";
					for(var i = 0; i < res.length; i++){
						html +=
						`
						<tr>
							<td>${res[i].name}</td>
							<td>
								<button type="button" data-id="${res[i].id}" data-name="${res[i].name}" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-edit"></i></button>
								<button type="button" data-name="${res[i].name}" data-id="${res[i].id}" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-eraser"></i></button>
							</td>
						</tr>
						`;
					}
					$("#tbcat").html(html);
				}
			});
		}
		$(".btn-add").click(function(){
			Swal.fire({
			  title: 'Masukan Nama Kategori',
			  input: 'text',
			  inputAttributes: {
			    autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Simpan',
			  showLoaderOnConfirm: true,
			  preConfirm: (name) => {
			   $.ajax({
			   	url 	: "<?= base_url('api/addCat') ?>",
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
			    Swal.fire(
			    	'Sukses Disimpan',
			    	'Data Berhasil Disimpan',
			    	'success',
			    );
				tb_cat();
			  }
			});
		});
		$("#tbcat").on('click','.btn-edit', function(){
			var name 	=	$(this).data('name');
			var id 		=	$(this).data('id');
			Swal.fire({
			  title: 'Ubah '+name,
			  input: 'text',
			  inputAttributes: {
			    autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Ubah',
			  showLoaderOnConfirm: true,
			  preConfirm: (name) => {
			   $.ajax({
			   	url 	: "<?= base_url('api/updateCat') ?>",
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
			  	tb_cat();
			    Swal.fire(
			    	'Sukses Diubah',
			    	'Data Berhasil Diubah',
			    	'success',
			    );
			  }
			});
		});
		$("#tbcat").on('click','.btn-delete', function() {
			var id 		=	$(this).data('id');
			var name 	=	$(this).data('name');
			Swal.fire({
				title 	: 	"Yaqueen Mau Dihapus ?",
				text 	: 	"Yaqueen "+name+" Mau Dihapus, Kalo Dihapus Data Nda Bisa Kembali Lho!",
				icon 	: 	"warning",
				showCancelButton : true,
			}).then((result)=>{
				if(result.isConfirmed){
					$.ajax({
						url 	: "<?= base_url('api/deleteCat') ?>", 
						type 	: "POST",
						dataType: "JSON",
						data 	: {id:id},
						success : (ok)=>{
							if(ok.success === true){
								tb_cat();
								Swal.fire(
									'Sukses Dihapus',
									ok.data,
									'success',
								);
							}else{
								tb_cat();
								Swal.fire(
									'Gagal Dihapus',
									ok.data,
									'error',
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